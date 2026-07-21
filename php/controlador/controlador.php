<?php
session_start(); // Aquí es el único lugar donde se inicia la sesión

// Cargamos el modelo que contiene la función verificarUsuario()
require_once("../modelo/login.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if(!isset($_POST['correo']) || !isset($_POST['password'])){
        echo "Faltan datos";
        exit();
    }

    $correo = $_POST['correo'];
    $password = $_POST['password'];

    // Ahora sí va a encontrar la función perfectamente
    $resultado = verificarUsuario($correo, $password);

    if ($resultado) {

        $usuario = $resultado;

        // 🛑 BLOQUEO DE USUARIO INACTIVO
        if (isset($usuario['estado']) && $usuario['estado'] == 0) {
            header("Location: /version_final/paginas/login.php?error=cuenta_desactivada");
            exit();
        }

        // ✅ SESIÓN NORMAL
        $_SESSION['id'] = $usuario['id'];
        $_SESSION['usuario'] = $usuario['nombre'];
        $_SESSION['rol'] = $usuario['rol']; 

        // 🔥 REDIRECCIÓN POR ROL
        if ($usuario['rol'] == 'admin') {
            header("Location: /version_final/paginas/admin/dashboard.php");
        } elseif ($usuario['rol'] == 'repartidor') {
            header("Location: /version_final/paginas/repartidor/domicilios.php");
        } else {
            header("Location: http://localhost/version_final/paginas/menu.php");
        }
        exit();

    } else {
        require_once(__DIR__ . '/../../includes/flash.php');
        flash_set('danger', 'Correo o contraseña incorrectos.');
        header('Location: /version_final/paginas/login.php');
        exit();
    }
}
?>
