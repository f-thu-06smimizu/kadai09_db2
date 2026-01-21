<?php
include('functions.php');
$id = $_GET['id'];
$pdo = connect_to_db();

// 指定されたIDの賢人データを削除するSQL
$sql = 'DELETE FROM sage_routes WHERE id=:id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);

try {
    $status = $stmt->execute();
} catch (PDOException $e) {
    echo json_encode(["sql error" => "{$e->getMessage()}"]);
    exit();
}

// 削除が終わったら一覧画面に戻る
header("Location:read.php");
exit();