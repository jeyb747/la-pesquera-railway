<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . "/version_final/php/modelo/conexion.php");

// Seguridad: Solo administradores
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 'admin') {
    header("Location: /version_final/index.php");
    exit();
}

if (isset($_GET['accion'])) {
    $accion = $_GET['accion'];

    // ACCIÓN: CREAR TIPO DE DOCUMENTO
    if ($accion == 'crear') {
        $nombre = trim($_POST['nombre_documento']);
        
        if (!empty($nombre)) {
            $stmt = $conexion->prepare("INSERT INTO tipo_documento (nombre) VALUES (?)");
            $stmt->bind_param("s", $nombre);
            $stmt->execute();
            $stmt->close();
        }
        header("Location: /version_final/paginas/admin/config_tipo_documentos.php?status=creado");
        exit();
    }

    // ACCIÓN: ELIMINAR TIPO DE DOCUMENTO
    if ($accion == 'eliminar') {
        $id = intval($_GET['id']);
        
        if ($id > 0) {
            $stmt = $conexion->prepare("DELETE FROM tipo_documento WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt->close();
        }
        header("Location: /version_final/paginas/admin/config_tipo_documentos.php?status=eliminado");
        exit();
    }
}

// Redirección por defecto si no hay acción válida
header("Location: /version_final/paginas/admin/config_tipo_documentos.php");
exit();