<?php
session_start(); require_once($_SERVER['DOCUMENT_ROOT'].'/version_final/php/modelo/conexion.php'); require_once($_SERVER['DOCUMENT_ROOT'].'/version_final/includes/flash.php');
if (($_SESSION['rol'] ?? '') !== 'admin') { header('Location: /version_final/index.php'); exit; }
$id=(int)($_POST['id']??0); $estado=(int)($_POST['estado']??0); $q=$conexion->prepare('UPDATE categorias SET estado=? WHERE id=?'); $q->bind_param('ii',$estado,$id); $q->execute(); flash_set('success','Estado de categoría actualizado.'); header('Location: /version_final/paginas/admin/categorias.php');
?>
