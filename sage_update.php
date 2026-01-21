<?php
// --- 1. DB接続と関数の読み込み ---
include('functions.php');
$pdo = connect_to_db();

// --- 2. データ受け取りチェック ---
// 全ての項目が正しく送られてきているか確認します
if (
    !isset($_POST['name']) || $_POST['name'] === '' ||
    !isset($_POST['location_name']) || $_POST['location_name'] === '' ||
    !isset($_POST['description']) || $_POST['description'] === '' ||
    !isset($_POST['id']) || $_POST['id'] === ''
) {
    exit('データが足りません。修正してください。');
}

// 変数に代入
$name = $_POST['name'];
$location_name = $_POST['location_name'];
$description = $_POST['description'];
$id = $_POST['id'];

// --- 3. SQL作成（UPDATE文） ---
// 指定したIDのデータだけを更新します
$sql = "UPDATE sage_routes 
        SET name=:name, 
            location_name=:location_name, 
            description=:description, 
            updated_at=now() 
        WHERE id=:id";

$stmt = $pdo->prepare($sql);

// バインド変数で安全に値を渡す（SQLインジェクション対策）
$stmt->bindValue(':name', $name, PDO::PARAM_STR);
$stmt->bindValue(':location_name', $location_name, PDO::PARAM_STR);
$stmt->bindValue(':description', $description, PDO::PARAM_STR);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);

// --- 4. 実行 ---
try {
    $status = $stmt->execute();
} catch (PDOException $e) {
    echo json_encode(["sql error" => "{$e->getMessage()}"]);
    exit();
}

// --- 5. リダイレクト ---
// 更新が終わったら一覧画面（read.php）へ自動で戻ります
header("Location:read.php");
exit();