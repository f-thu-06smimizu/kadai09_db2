<?php

// PHPの開始タグ
ini_set('display_errors', "On");
error_reporting(E_ALL);

if ($_SERVER['SERVER_NAME'] === 'localhost') {
    $host = 'localhost';
    $db   = 'atora_local_db'; 
    $user = 'root';
    $pass = '';
} else {
    $host = 'mysql3112.db.sakura.ne.jp'; // さくらのDBホスト名
    $db   = 'atora2026_atora_db';
    $user = 'atora2026'; 
    $pass = ''; 
}

$dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
     $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
     die("接続エラー: " . $e->getMessage());
}