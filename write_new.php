<?php
session_start();
include('functions.php');
check_session_id();

// 1. input.php の name="pain_point" と一致させる
$pain = $_POST['pain_point'] ?? null; 
$category = $_POST['category'] ?? 'Existence'; // デフォルト値

// もし中身が空なら、エラーを出さずに戻す
if ($pain === null || $pain === '') {
    exit('入力が空です。前の画面に戻って入力してください。');
}

// 2. DB接続
$pdo = db_conn();

// 3. SQL作成 (pre_trip_logs テーブルに保存)
$sql = 'INSERT INTO pre_trip_logs (id, pain_point, category, indate) VALUES (NULL, :pain, :category, sysdate())';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':pain',     $pain,     PDO::PARAM_STR);
$stmt->bindValue(':category', $category, PDO::PARAM_STR);

try {
    $status = $stmt->execute();
} catch (PDOException $e) {
    exit('SQL Error:' . $e->getMessage());
}

// 4. 保存が終わったら一覧画面 (read.php) へ飛ばす
header('Location: read.php');
exit();