<?php
/* Gmail SMTP. Install dependencies with: composer install */
function enviar_correo($destino, $asunto, $titulo, $mensaje) {
    if (!filter_var($destino, FILTER_VALIDATE_EMAIL)) return false;
    $configFile = __DIR__ . '/mail_config.php';
    $autoload = dirname(__DIR__, 2) . '/vendor/autoload.php';
    if (!is_file($configFile) || !is_file($autoload)) return false;
    $config = require $configFile;
    if (empty($config['username']) || empty($config['password'])) return false;
    require_once $autoload;
    try {
        $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = $config['host'] ?? 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = $config['username'];
        $mail->Password = $config['password'];
        $mail->SMTPSecure = \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = (int)($config['port'] ?? 587);
        $mail->CharSet = 'UTF-8';
        $mail->setFrom($config['username'], $config['from_name'] ?? 'La Pesquera');
        $mail->addAddress($destino);
        $mail->isHTML(true);
        $mail->Subject = $asunto;
        $mail->Body = '<!doctype html><html><body style="font-family:Arial,sans-serif;background:#f5f7fa;padding:24px"><div style="max-width:560px;margin:auto;background:#fff;border-radius:12px;padding:28px;color:#17324d"><h2 style="margin-top:0">'.htmlspecialchars($titulo).'</h2><p>'.nl2br(htmlspecialchars($mensaje)).'</p><hr style="border:0;border-top:1px solid #eee"><small>La Pesquera</small></div></body></html>';
        $mail->AltBody = $mensaje;
        return $mail->send();
    } catch (\Throwable $e) { error_log('Mail error: ' . $e->getMessage()); return false; }
}
?>
