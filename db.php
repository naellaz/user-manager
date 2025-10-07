<?php
require_once __DIR__ . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Ambil URL dari environment
$db_url = $_ENV['DATABASE_URL'];
$parsed_url = parse_url($db_url);

$host = $parsed_url['host'];
$port = $parsed_url['port'];
$user = $parsed_url['user'];
$pass = $parsed_url['pass'];
$dbname = ltrim($parsed_url['path'], '/');

try {
    $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}
