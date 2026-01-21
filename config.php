<?php
function db_conn() {
    $db_name = 'atora2026_atora_db';
    $db_host = 'mysql3112.db.sakura.ne.jp';
    $db_id   = 'atora2026';
    $db_pw   = '260116_aatora'; 

    try {
        $pdo = new PDO("mysql:host={$db_host};dbname={$db_name};charset=utf8mb4", $db_id, $db_pw);
        return $pdo;
    } catch (PDOException $e) {
        // エラー内容に $db_host を含めて表示
        exit('DB Connect Error(Host:'.$db_host.'):' . $e->getMessage());
    }
}
?>