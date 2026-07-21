<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'].'/version_final/php/modelo/conexion.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/version_final/includes/flash.php');
if (($_SESSION['rol'] ?? '') !== 'admin') { flash_set('danger','No tienes permiso para realizar esta acción.'); header('Location: /version_final/index.php'); exit; }
$id = (int)($_POST['id'] ?? 0); $nombre = trim($_POST['nombre'] ?? ''); $descripcion = trim($_POST['descripcion'] ?? '');
if ($nombre === '') { flash_set('warning','El nombre de la categoría es obligatorio.'); header('Location: /version_final/paginas/admin/categorias.php'); exit; }
if ($id) { $q=$conexion->prepare('UPDATE categorias SET nombre=?, descripcion=? WHERE id=?'); $q->bind_param('ssi',$nombre,$descripcion,$id); }
else { $q=$conexion->prepare('INSERT INTO categorias (nombre,descripcion) VALUES (?,?)'); $q->bind_param('ss',$nombre,$descripcion); }
if ($q->execute()) flash_set('success', $id ? 'Categoría actualizada.' : 'Categoría creada.'); else flash_set('danger','No se pudo guardar. Verifica que no exista una categoría con ese nombre.');
header('Location: /version_final/paginas/admin/categorias.php');
?>
