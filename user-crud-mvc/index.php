<?php

// charge l'autoload de composer
require "vendor/autoload.php";
session_start(); // démarrage de la session
// charge le contenu du .env dans $_ENV
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
$router = new Router();
$router->handleRequest($_GET);