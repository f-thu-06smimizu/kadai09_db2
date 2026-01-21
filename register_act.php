<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
include('functions.php');
$pdo = db_conn();

$username = $_POST['username'];
$lid = $_POST['lid'];
$lpw = $_POST['lpw'];
$hashed_lpw = password_hash($lpw, PASSWORD_DEFAULT);

$sql = "INSERT INTO users_table(id, username, lid, lpw, kanri_flg, life_flg) VALUES(NULL, :username, :lid, :lpw, 0, 0)";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':username', $username, PDO::PARAM_STR);
$stmt->bindValue(':lid',      $lid,      PDO::PARAM_STR);
$stmt->bindValue(':lpw',      $hashed_lpw, PDO::PARAM_STR);

try {
    $status = $stmt->execute();
    header('Location: login.php');
} catch (PDOException $e) {
    exit('SQL Error:' . $e->getMessage());
}
exit();