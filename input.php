<?php
// 1. セッション開始
session_start();

// 2. 共通関数読み込み
include('functions.php');

// --- 💡 [追加チェック] 門番が動いているか強制確認 ---
// もしシークレットモードでも飛ばない場合は、この下の行を一時的に有効にして
// 「強制終了」と表示されるか。
// exit('強制終了テスト'); 

// 3. 門番実行
check_session_id();
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atora | Exploration</title>
    <link rel="stylesheet" href="style.css?v=<?= time(); ?>">
</head>
<body>

<div class="main-wrapper content-container fade-in">
    <div class="top-label">Atora / Archive</div>
    <main>
        <h1>
            旅に出る前に、<br>
            心にある「澱」を言葉にする。
        </h1>
        <form action="write_new.php" method="post">
            <div class="input-area">
                <textarea name="pain_point" placeholder=".................." required autofocus></textarea>
            </div>
            <div class="meta-info">
                <span class="label">Theme</span>
                <select name="category">
                    <option value="Existence">自己の在り方について</option>
                    <option value="Relation">他者との繋がりについて</option>
                    <option value="Labor">生業と社会について</option>
                </select>
            </div>
            <div class="button-wrapper">
                <button type="submit" class="btn-enter">Begin Journey</button>
            </div>
        </form>
    </main>
</div>

</body>
</html>