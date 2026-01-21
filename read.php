<?php
// エラー表示設定
ini_set('display_errors', "On");
error_reporting(E_ALL);

session_start();
include('functions.php');

// ログインチェック
check_session_id();

// 1. DB接続
$pdo = db_conn();

// 2. データ取得SQL（pre_trip_logs から最新順に取得）
$sql = 'SELECT * FROM pre_trip_logs ORDER BY indate DESC';
$stmt = $pdo->prepare($sql);

try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  exit('SQL Error:' . $e->getMessage());
}

// 3. データ表示
if ($status == false) {
  $error = $stmt->errorInfo();
  exit('QueryError:' . $error[2]);
} else {
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $view = '';
  foreach ($result as $record) {
    $view .= "<tr>";
    $view .= "<td>{$record['indate']}</td>";   
    $view .= "<td>" . htmlspecialchars($record['pain_point'], ENT_QUOTES, 'UTF-8') . "</td>"; 
    $view .= "<td>" . htmlspecialchars($record['category'], ENT_QUOTES, 'UTF-8') . "</td>";   
    $view .= "</tr>";
  }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>旅のアーカイブ | Atora</title>
</head>
<body>
    <h1>心の記録アーカイブ</h1>
    <p>ようこそ、<?= htmlspecialchars($_SESSION['username']) ?> さん</p>
    
    <table border="1">
        <tr>
            <th>記録日時</th>
            <th>心の澱（Feeling）</th>
            <th>Theme（AI分析カテゴリ）</th>
        </tr>
        <?= $view ?>
    </table>
    
    <br>
    <a href="input.php">新しい澱を吐き出す（入力画面）</a><br><br>
    <a href="logout.php">ログアウト</a>
</body>
</html>