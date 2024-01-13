<?php 

namespace Controllers;

use MVC\Router;
use Model\Propiedad;
use Model\Entrada;
use PHPMailer\PHPMailer\PHPMailer;

class PaginasController {
    public static function index(Router $router) {
        $propiedades = Propiedad::get(3);
        $entradas = Entrada::get(2);
        $inicio = true;

        $router->render("paginas/index", [
            "propiedades" => $propiedades,
            "entradas" => $entradas,
            "inicio" => $inicio
        ]);
    }

    public static function nosotros(Router $router) {
        $router->render("paginas/nosotros", [
        ]);
    }

    public static function propiedades(Router $router) {
        $propiedades = Propiedad::all();

        $router->render("paginas/propiedades", [
            "propiedades" => $propiedades
        ]);
    }

    public static function propiedad(Router $router) {

        $id = validarORedireccionar("/propiedades");

        $propiedad = Propiedad::find($id);

        if(!$propiedad || $id < 1) {
            header("location: /propiedades");
        }

        $router->render("paginas/propiedad", [
            "propiedad" => $propiedad
        ]);
    }

    public static function blog(Router $router) {

        $entradas = Entrada::all();

        $router->render("paginas/blog", [
            "entradas" => $entradas
        ]); 
    }

    public static function entrada(Router $router) {

        $id = validarORedireccionar("/blog");

        $entrada = Entrada::find($id);

        if(!$entrada || $id < 1) {
            header("location: /blog");
        }

        $router->render("paginas/entrada", [
            "entrada" => $entrada
        ]);
    }

    public static function contacto(Router $router) {

        $mensaje = null;

        if($_SERVER["REQUEST_METHOD"] === "POST") {

            $respuestas = $_POST["contacto"];

            // Crear una nueva instancia de mail
            $mail = new PHPMailer();

            // Configurar SMTP (Protocolo de envío de emails) 
            $mail->isSMTP();
            $mail->Host = "smtp.mailtrap.io";
            $mail->SMTPAuth = true;
            $mail->Username = "86956efe8aec88";
            $mail->Password = "034385d7ce0cf8";
            $mail->SMTPSecure = "tls";
            $mail->Port = 2525;

            // Configurar el contenido del email
            $mail->setFrom("admin@bienesraices.com");
            $mail->addAddress("admin@bienesraices.com", "BienesRaices.com");
            $mail->Subject = "Tienes un nuevo mensaje";

            // Habilitar HTML
            $mail->isHTML(true);
            $mail->CharSet = "UTF-8";

            // Definir el contenido
            $contenido = "<html>";
            $contenido .= "<p>Tienes un nuevo mensaje</p>";
            $contenido .= "<p>Nombre: " . $respuestas["nombre"] . " </p>";

            // Enviar de forma condicional email o telefono
            if($respuestas["contacto"] === "Telefono") {
                $contenido .= "<p>Eligió ser contactado vía telefono:</p>";
                $contenido .= "<p>Telefono: " . $respuestas["telefono"] . " </p>";
                $contenido .= "<p>Fecha: " . $respuestas["fecha"] . " </p>";
                $contenido .= "<p>Hora: " . $respuestas["hora"] . " </p>";
            } else {
                // Email
                $contenido .= "<p>Eligió ser contactado vía email:</p>";
                $contenido .= "<p>Email: " . $respuestas["email"] . " </p>";
            }

            $contenido .= "<p>Mensaje: " . $respuestas["mensaje"] . " </p>";
            $contenido .= "<p>Vende o compra: " . $respuestas["tipo"] . " </p>";
            $contenido .= "<p>Precio o Presupuesto: $ " . $respuestas["precio"] . " </p>";
            $contenido .= "</html>";

            $mail->Body = $contenido;
            $mail->AltBody = "Esto es un texto alternativo sin HTML";

            // Enviar el email
            if($mail->send()) {
                $mensaje = "El mensaje fue enviado correctamente";
            } else {
                $mensaje = "El mensaje no se pudo enviar";
            }
        }

        $router->render("paginas/contacto", [
            "mensaje" => $mensaje
        ]);
    }
}