<?php

// Importar la conexion
require 'includes/config/database.php';
$db = conectarDB();

// Crear email y contraseña
$email = "correo@correo.com";
$contraseña = "123456";

// Hashear contraseña
$contraseñaHash = password_hash($contraseña, PASSWORD_DEFAULT); // md5(uniqid(rand(), true)) version anterior, mezcla md5 y uniqid

// Query apra crear el usuario
$query = "INSERT INTO usuarios (email, contraseña) VALUES ('{$email}', '{$contraseñaHash}');";

// Agregarlo a la bd
mysqli_query($db, $query);


