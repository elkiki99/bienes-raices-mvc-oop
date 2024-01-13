<?php
    if(!isset($_SESSION)) {
        session_start();
    }
    
    $auth = $_SESSION["login"] ?? false;
    // var_dump($auth);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienes Raíces</title>
    <link rel="stylesheet" href="/build/css/app.css">
</head>
<body>
    <header class="header <?php echo $inicio ? 'inicio' : ''; ?>">
        <div class="contenedor contenido-header">
            <div class="barra">
                <a href="/">
                    <img class="logo" src="/build/img/logo.svg" alt="Logo Bienes Raíces">
                </a>

                <div class="mobile-menu">
                    <img src="/build/img/barras.svg" alt="Icono Menú Responsive">
                </div>

                <div class="derecha">
                    <img class="dark-mode-boton" src="/build/img/dark-mode.svg" alt="Icono Dark Mode">
                    <nav class="navegacion">
                        <a href="/nosotros">Nosotros</a>
                        <a href="/propiedades">Anuncios</a>
                        <a href="/blog">Blog</a>
                        <a href="/contacto">Contacto</a>
                        <?php if($auth) : ?>
                            <a href="/cerrar-sesion">Cerrar Sesión</a>
                        <?php endif ?>
                    </nav>
                </div>
                
            </div> <!--.barra-->
            <?php 
                if($inicio) {
                    echo "<h1>Venta de Casas y Departamentos Exclusivos de Lujo</h1>";
                }
            ?>
        </div>
    </header>