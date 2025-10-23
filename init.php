<?php
$config = parse_ini_file('config.ini');

// Połączenie do bazy sesji
$pdo = new PDO(
    "mysql:host={$config['host']};dbname=sesje;charset=utf8",
    $config['user'],
    $config['password']
);

require 'session_handler.php';
$handler = new MySQLSessionHandler($pdo);
session_set_save_handler($handler, true);
session_start();

// Połączenie do bazy użytkowników
$pdoUsers = new PDO(
    "mysql:host={$config['host']};dbname=uzytkownicy;charset=utf8",
    $config['user'],
    $config['password']
);
?>
