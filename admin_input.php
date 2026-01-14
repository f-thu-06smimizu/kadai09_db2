<?php
// 一旦 config.php を読み込まずに画面が表示されるかテストします
// require_once('config.php');
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atora | Archive Management</title>
    <link rel="stylesheet" href="style.css?v=2">
</head>
<body>

<div class="main-wrapper content-container fade-in">
    <div class="top-label">Atora / Archive</div>

    <main>
        <h1>
            新たな賢人の地を、<br>
            アーカイブに刻む。
        </h1>

        <form action="admin_create.php" method="post">
            <div class="input-area">
                <input type="text" name="name" placeholder="Sage Name" style="width: 100%; max-width: 400px; background: transparent; border: none; border-bottom: 0.5px solid #e0e0e0; font-size: 1.1rem; font-family: inherit; color: var(--text-color); text-align: center; outline: none; padding: 10px 0; margin-bottom: 20px;" required autofocus>
                
                <input type="text" name="location_name" placeholder="Location Name" style="width: 100%; max-width: 400px; background: transparent; border: none; border-bottom: 0.5px solid #e0e0e0; font-size: 1.1rem; font-family: inherit; color: var(--text-color); text-align: center; outline: none; padding: 10px 0; margin-bottom: 20px;" required>
                
                <div style="display: flex; justify-content: center; gap: 20px; margin-bottom: 20px;">
                    <input type="text" name="lat" placeholder="Lat" style="width: 190px; background: transparent; border: none; border-bottom: 0.5px solid #e0e0e0; font-size: 1.1rem; font-family: inherit; color: var(--text-color); text-align: center; outline: none; padding: 10px 0;" required>
                    <input type="text" name="lng" placeholder="Lng" style="width: 190px; background: transparent; border: none; border-bottom: 0.5px solid #e0e0e0; font-size: 1.1rem; font-family: inherit; color: var(--text-color); text-align: center; outline: none; padding: 10px 0;" required>
                </div>

                <textarea name="description" placeholder="Description.................." required></textarea>
                <textarea name="recommended_route" placeholder="Recommended Route.................." style="margin-top:20px;"></textarea>
            </div>

            <div class="meta-info">
                <span class="label">Theme</span>
                <select name="experience_type">
                    <option value="Existence">自己の在り方について</option>
                    <option value="Relation">他者との繋がりについて</option>
                    <option value="Universal">普遍的な自然・宇宙について</option>
                </select>
            </div>

            <div class="button-wrapper">
                <button type="submit" class="btn-enter">Archive Data</button>
            </div>
        </form>
    </main>
</div>

</body>
</html>