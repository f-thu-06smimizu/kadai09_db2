<?php
function db_conn() {
    $db_name = 'atora2026_atora_db';
    $db_host = 'mysql3112.db.sakura.ne.jp';
    $db_id   = 'atora2026';
    $db_pw   = 'A260116_aatora'; 
    try {
        $pdo = new PDO("mysql:host={$db_host};dbname={$db_name};charset=utf8", $db_id, $db_pw);
        return $pdo;
    } catch (PDOException $e) {
        exit('DB Connect Error:' . $e->getMessage());
    }
}
function h($str) { return htmlspecialchars($str, ENT_QUOTES, 'UTF-8'); }
function check_session_id() {
    if (!isset($_SESSION["chk_ssid"]) || $_SESSION["chk_ssid"] !== session_id()) {
        header('Location: login.php'); exit();
    } else {
        session_regenerate_id(true); $_SESSION["chk_ssid"] = session_id();
    }
}
function sql_error($stmt){
    $error = $stmt->errorInfo();
    exit("SQLError:".$error[2]);
}