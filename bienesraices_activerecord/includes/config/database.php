<?php
function conectarDB() : mysqli {
    $db = new mysqli('localhost', 'root', 't7h9a8d9', 'bienesraices_crud');
    if(!$db) {
        echo "Error, no se pudo conectar";
        exit;
    } 
    return $db;
} 