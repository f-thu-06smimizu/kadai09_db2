<?php
include('functions.php');
$pdo = db_conn();

// 1. データ取得
$username = $_POST['username'];
$lid = $_POST['lid'];
$lpw = $_POST['lpw'];

// 2. パスワードを暗号化
$hashed_lpw = password_hash($lpw, PASSWORD_DEFAULT);

// 3. SQL作成（users_tableに変更済み）
$sql = "INSERT INTO users_table(id, username, lid, lpw, kanri_flg, life_flg) VALUES(NULL, :username, :lid, :lpw, 0, 0)";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':username', $username, PDO::PARAM_STR);
$stmt->bindValue(':lid',      $lid,      PDO::PARAM_STR);
$stmt->bindValue(':lpw',      $hashed_lpw, PDO::PARAM_STR);

try {
    $status = $stmt->execute();
} catch (PDOException $e) {
    exit('SQL Error:' . $e->getMessage());
}

// 4. 登録できたらログイン画面へ
header('Location: login.php');
exit();