<?php
require_once("modelo/conexion.php"); // ruta correcta desde php/prueba.php

// Verificar conexión
if ($conexion) {
    echo "Base de datos conectada correctamente 👍";
} else {
    echo "Error en la conexión ❌";
}
?>