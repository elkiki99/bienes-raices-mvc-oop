<?php

function conectarDB() : mysqli {
    $db = new mysqli ("localhost", "root", "DoctorWho2332", "bienesraices_crud");

    if(!$db) {
        echo "No se contectó correctamente a la base de datos";
        exit;
    }

    return $db;
}
