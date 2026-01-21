<?php
// 1. セッション開始と門番（これを忘れると誰でも登録できてしまいます！）
session_start();
include('functions.php'); 
check_session_id(); // ログインチェック

// 2. データの受け取り
$experience_type   = $_POST['experience_type'];
$name              = $_POST['name'];
$location_name     = $_POST['location_name'];
$lat               = $_POST['lat'];
$lng               = $_POST['lng'];
$description       = $_POST['description'];
$recommended_route = $_POST['recommended_route'];

// 3. DB接続
// functions.php 内の関数名が db_conn ならこれでOK
$pdo = db_conn(); 

// 4. SQL作成 (sage_routesテーブルへ挿入)
$sql = "INSERT INTO sage_routes (experience_type, name, location_name, lat, lng, description, recommended_route, created_at) 
        VALUES (:experience_type, :name, :location_name, :lat, :lng, :description, :recommended_route, sysdate())";

$stmt = $pdo->prepare($sql);

// バインド変数で安全に値を渡す
$stmt->bindValue(':experience_type',   $experience_type,   PDO::PARAM_STR);
$stmt->bindValue(':name',              $name,              PDO::PARAM_STR);
$stmt->bindValue(':location_name',     $location_name,     PDO::PARAM_STR);
$stmt->bindValue(':lat',               $lat,               PDO::PARAM_STR);
$stmt->bindValue(':lng',               $lng,               PDO::PARAM_STR);
$stmt->bindValue(':description',       $description,       PDO::PARAM_STR);
$stmt->bindValue(':recommended_route', $recommended_route, PDO::PARAM_STR);

// 5. 実行
$status = $stmt->execute();

// 6. 完了後のリダイレクト
if ($status == false) {
    $error = $stmt->errorInfo();
    exit("ErrorQuery:".$error[2]);
} else {
    header("Location: read.php");
    exit();
}