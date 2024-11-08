<?php
require 'funciones.php';
require 'config/database.php';
require __DIR__ . '/../vendor/autoload.php';

use App\ActiveRecord;


// Conectarnos a la bd 
$db = conectarDB();
ActiveRecord::setDB($db);