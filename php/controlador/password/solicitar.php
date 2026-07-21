<?php
session_start(); require_once($_SERVER['DOCUMENT_ROOT'].'/version_final/php/modelo/conexion.php'); require_once($_SERVER['DOCUMENT_ROOT'].'/version_final/php/configuracion/mail.php'); require_once($_SERVER['DOCUMENT_ROOT'].'/version_final/includes/flash.php');
$correo=trim($_POST['correo']??''); $q=$conexion->prepare('SELECT id FROM usuarios WHERE correo=?'); $q->bind_param('s',$correo); $q->execute(); $u=$q->get_result()->fetch_assoc();
if($u){ $token=bin2hex(random_bytes(32)); $hash=hash('sha256',$token); $q=$conexion->prepare('INSERT INTO password_resets(usuario_id,token_hash,expira_en) VALUES(?,?,DATE_ADD(NOW(),INTERVAL 1 HOUR))'); $q->bind_param('is',$u['id'],$hash); $q->execute(); $url='http'.(!empty($_SERVER['HTTPS'])?'s':'').'://'.$_SERVER['HTTP_HOST'].'/version_final/paginas/restablecer_password.php?token='.$token; enviar_correo($correo,'Restablece tu contraseña','Restablecimiento de contraseña',"Abre este enlace antes de una hora:\n$url"); }
flash_set('success','Si el correo existe, recibirás un enlace para restablecer tu contraseña.'); header('Location: /version_final/paginas/login.php');
?>
