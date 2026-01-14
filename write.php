<?php
// 1. POSTデータ取得
$pain_point = $_POST['pain_point'];
$category = $_POST['category'];

// 2. DB接続
try {
    $pdo = new PDO('mysql:dbname=atora_db_260102;charset=utf8;host=localhost', 'root', '');
} catch (PDOException $e) {
    exit('DB Connect Error:' . $e->getMessage());
}

// 3. 新しいテーブル（pre_trip_logs）へ登録
$stmt = $pdo->prepare("INSERT INTO pre_trip_logs (id, pain_point, category, indate) VALUES (NULL, :pain_point, :category, sysdate())");

$stmt->bindValue(':pain_point', $pain_point, PDO::PARAM_STR);
$stmt->bindValue(':category', $category, PDO::PARAM_STR);

$status = $stmt->execute();

// 4. データ登録処理後
if ($status == false) {
    $error = $stmt->errorInfo();
    exit("ErrorMessage:" . $error[2]);
} else {
    // 登録成功したら、賢人の路を表示する「read.php」へリダイレクト
    header("Location: read.php");
    exit;
}
?>