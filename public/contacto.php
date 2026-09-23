<?php
/**
 * Receptor de leads del formulario B2B.
 *
 * Recibe el POST en JSON que manda ContactForm.astro, guarda una copia en CSV
 * fuera de public_html y despacha un mail con la consulta ya formateada.
 *
 * El CSV es la fuente de verdad: si el mail falla (SPF, MX en otro proveedor,
 * cuota del hosting), el lead ya quedo guardado y se puede abrir en Excel.
 */

// ============================================================
// Configuracion
// ============================================================

$DESTINATARIOS = ['hola@porcorosso.com.ar'];
$REMITENTE     = 'web@porcorosso.com.ar';   // debe ser del dominio para no caer en spam
$ARCHIVO_CSV   = __DIR__ . '/../../leads/leads-b2b.csv';  // fuera de public_html
$MAX_BYTES     = 20000;
$MIN_SEGUNDOS  = 3;   // un humano no completa 4 pasos en menos que esto

// ============================================================

header('Content-Type: application/json; charset=utf-8');

function responder(int $codigo, array $cuerpo): never {
    http_response_code($codigo);
    echo json_encode($cuerpo, JSON_UNESCAPED_UNICODE);
    exit;
}

if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
    responder(405, ['ok' => false, 'error' => 'Metodo no permitido']);
}

$crudo = file_get_contents('php://input', false, null, 0, $MAX_BYTES + 1);
if ($crudo === false || strlen($crudo) > $MAX_BYTES) {
    responder(413, ['ok' => false, 'error' => 'Payload invalido']);
}

$datos = json_decode($crudo, true);
if (!is_array($datos)) {
    responder(400, ['ok' => false, 'error' => 'JSON invalido']);
}

// ---- Anti-spam -------------------------------------------------

// Honeypot: campo invisible que solo completan los bots.
if (!empty($datos['sitio_web'])) {
    responder(200, ['ok' => true]);   // respuesta normal para no delatar la trampa
}

// Tiempo de completado: los bots envian de inmediato.
$transcurrido = isset($datos['tiempo_ms']) ? (int) $datos['tiempo_ms'] : PHP_INT_MAX;
if ($transcurrido < $MIN_SEGUNDOS * 1000) {
    responder(200, ['ok' => true]);
}

// ---- Normalizacion y validacion --------------------------------

/** Aplana arrays, recorta y saca caracteres de control. */
function limpiar(mixed $valor): string {
    if (is_array($valor)) {
        $valor = implode(', ', array_map('strval', $valor));
    }
    $valor = str_replace(["\r", "\n"], ' ', (string) $valor);   // corta header injection
    $valor = preg_replace('/[\x00-\x1F\x7F]/u', '', $valor);
    return trim(mb_substr($valor, 0, 1000));
}

$CAMPOS = [
    'tipo_cliente' => 'Tipo de negocio',
    'empresa'      => 'Negocio',
    'zona'         => 'Zona',
    'productos'    => 'Productos de interes',
    'volumen'      => 'Volumen estimado',
    'frecuencia'   => 'Frecuencia',
    'nombre'       => 'Contacto',
    'telefono'     => 'Telefono',
    'email'        => 'Email',
    'mensaje'      => 'Mensaje',
];

$lead = [];
foreach ($CAMPOS as $clave => $_) {
    $lead[$clave] = limpiar($datos[$clave] ?? '');
}

foreach (['empresa', 'zona', 'nombre', 'telefono', 'email'] as $obligatorio) {
    if ($lead[$obligatorio] === '') {
        responder(422, ['ok' => false, 'error' => "Falta el campo: $obligatorio"]);
    }
}

if (!filter_var($lead['email'], FILTER_VALIDATE_EMAIL)) {
    responder(422, ['ok' => false, 'error' => 'Email invalido']);
}

$momento = date('Y-m-d H:i:s');
$origen  = limpiar($_SERVER['HTTP_REFERER'] ?? '');

// Identificador del clic de Google Ads. Va al CSV pero NO al mail: al comercial
// que lee el lead no le dice nada, y solo agrega ruido. Sirve para subir
// conversiones sin conexion cuando una consulta termina siendo cliente real.
// Se agrega al final, despues de Origen, para no correr las columnas de los
// leads que ya esten guardados.
$gclid = limpiar($datos['gclid'] ?? '');

// Cuando ocurrio el clic, y hasta cuando se puede subir la conversion.
// Google no importa conversiones sin conexion subidas mas de 90 dias despues
// del clic, y ese plazo corre desde el clic, no desde esta consulta: si alguien
// hizo clic en un anuncio y completa el formulario 80 dias despues, quedan 10
// dias, no 90. La fecha limite va calculada en la planilla para no tener que
// sacar la cuenta lead por lead.
// El timestamp lo pone el navegador del visitante, asi que un reloj mal puesto
// puede mandar una fecha futura o absurda. Se descarta lo que no tenga sentido
// contra la hora del servidor: preferimos la columna vacia a una fecha inventada
// que haga creer que todavia hay ventana para subir la conversion.
$clicMs  = (int) preg_replace('/\D/', '', (string) ($datos['gclid_ts'] ?? ''));
$clicSeg = intdiv($clicMs, 1000);
$ahora   = time();
$valido  = $clicSeg > 0 && $clicSeg <= $ahora + 86400 && $clicSeg >= $ahora - 90 * 86400;

$clicFecha = $valido ? date('Y-m-d', $clicSeg) : '';
$subirAnte = $valido ? date('Y-m-d', $clicSeg + 90 * 86400) : '';

// ---- Respaldo en CSV -------------------------------------------

$guardado = false;
$carpeta  = dirname($ARCHIVO_CSV);

if (is_dir($carpeta) || @mkdir($carpeta, 0700, true)) {
    $nuevo = !file_exists($ARCHIVO_CSV);
    if ($manejador = @fopen($ARCHIVO_CSV, 'a')) {
        if (flock($manejador, LOCK_EX)) {
            if ($nuevo) {
                fwrite($manejador, "\xEF\xBB\xBF");   // BOM: Excel abre los acentos bien
                fputcsv($manejador, array_merge(['Fecha'], array_values($CAMPOS), ['Origen', 'GCLID', 'Fecha del clic', 'Subir conversion antes de']), ',', '"', '\\');
            }
            fputcsv($manejador, array_merge([$momento], array_values($lead), [$origen, $gclid, $clicFecha, $subirAnte]), ',', '"', '\\');
            $guardado = true;
            flock($manejador, LOCK_UN);
        }
        fclose($manejador);
    }
}

// ---- Mail ------------------------------------------------------

$asunto = sprintf('[Lead B2B] %s - %s', $lead['empresa'], $lead['zona']);

$lineas = ["Nueva consulta desde b2b.porcorosso.com.ar", str_repeat('=', 46), ''];
foreach ($CAMPOS as $clave => $etiqueta) {
    if ($lead[$clave] !== '') {
        $lineas[] = sprintf('%-22s %s', $etiqueta . ':', $lead[$clave]);
    }
}
$lineas[] = '';
$lineas[] = str_repeat('-', 46);
$lineas[] = 'Recibido: ' . $momento;
$lineas[] = $guardado ? 'Guardado en la planilla de leads.' : 'ATENCION: no se pudo escribir el CSV de respaldo.';

$cuerpo = implode("\n", $lineas);

$cabeceras = implode("\r\n", [
    'From: Web Porco Rosso <' . $REMITENTE . '>',
    'Reply-To: ' . $lead['nombre'] . ' <' . $lead['email'] . '>',
    'Content-Type: text/plain; charset=UTF-8',
    'X-Mailer: PHP/' . phpversion(),
]);

$enviado = false;
foreach ($DESTINATARIOS as $destino) {
    if (@mail($destino, $asunto, $cuerpo, $cabeceras, '-f' . $REMITENTE)) {
        $enviado = true;
    }
}

// El lead se considera recibido si quedo guardado O si salio el mail.
if (!$guardado && !$enviado) {
    error_log('[porcorosso] Lead perdido: ' . json_encode($lead, JSON_UNESCAPED_UNICODE));
    responder(500, ['ok' => false, 'error' => 'No se pudo procesar la consulta']);
}

responder(200, ['ok' => true, 'guardado' => $guardado, 'notificado' => $enviado]);
