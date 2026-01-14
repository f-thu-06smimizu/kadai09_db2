<?php
// 1. データの受け取り
$experience_type  = $_POST['experience_type'];
$name             = $_POST['name'];
$location_name    = $_POST['location_name'];
$lat              = $_POST['lat'];
$lng              = $_POST['lng'];
$description      = $_POST['description'];
$recommended_route = $_POST['recommended_route'];

// 2. DB接続
try {
    $pdo = new PDO('mysql:dbname=atora_db_260102;charset=utf8mb4;host=localhost', 'root', '');
} catch (PDOException $e) {
    exit('DB接続エラー:' . $e->getMessage());
}

// 3. SQL作成 (sage_routesテーブルへ挿入)
$sql = "INSERT INTO sage_routes (experience_type, name, location_name, lat, lng, description, recommended_route, created_at) 
        VALUES (:experience_type, :name, :location_name, :lat, :lng, :description, :recommended_route, sysdate())";

$stmt = $pdo->prepare($sql);

// バインド変数で安全に値を渡す
$stmt->bindValue(':experience_type',  $experience_type,  PDO::PARAM_STR);
$stmt->bindValue(':name',             $name,             PDO::PARAM_STR);
$stmt->bindValue(':location_name',    $location_name,    PDO::PARAM_STR);
$stmt->bindValue(':lat',              $lat,              PDO::PARAM_STR);
$stmt->bindValue(':lng',              $lng,              PDO::PARAM_STR);
$stmt->bindValue(':description',      $description,      PDO::PARAM_STR);
$stmt->bindValue(':recommended_route', $recommended_route, PDO::PARAM_STR);

// 4. 実行
$status = $stmt->execute();

// 5. 完了後のリダイレクト
if ($status == false) {
    $error = $stmt->errorInfo();
    exit("ErrorQuery:".$error[2]);
} else {
    header("Location: read.php");
    exit;
}