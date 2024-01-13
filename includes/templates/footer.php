<?php
    if(!isset($_SESSION)) {
        session_start();
    }
    
    $auth = $_SESSION["login"] ?? false;
    // var_dump($auth);
?>

<footer class="footer seccion">
        <div class="contenedor contenedor-footer">
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

    <p class="copyright">Todos los Derechos Reservados <?php echo date("Y"); ?> &copy;</p>
</footer>

    <script src="/build/js/bundle.min.js"></script>
</body>
</html>
