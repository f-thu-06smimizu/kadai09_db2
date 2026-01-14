<?php
ini_set('display_errors', "On"); // エラーを画面に表示する
require_once 'config.php'; // 接続設定の読み込み

// 本来はここでDBからデータを取得、まずは表示確認用のダミーデータで組んでみる
$problems = [
    ['no' => 1, 'title' => '合計の計算', 'desc' => '配列の数値をすべて合計します'],
    ['no' => 7, 'title' => '範囲の計算', 'desc' => '最大値と最小値の差を求めます'],
];
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>Atora Project Dashboard</title>
    <link rel="stylesheet" href="style.css"> </head>
<body>
    <header>
        <h1>Atora Development Dashboard</h1>
    </header>
    <main class="container">
        <div class="card-grid">
            <?php foreach ($problems as $p): ?>
                <div class="card">
                    <h3>Problem <?php echo sprintf('%02d', $p['no']); ?></h3>
                    <p><?php echo $p['title']; ?></p>
                    <a href="problem<?php echo sprintf('%02d', $p['no']); ?>.php" class="btn">詳細を見る</a>
                </div>
            <?php endforeach; ?>
        </div>
    </main>
</body>
</html>