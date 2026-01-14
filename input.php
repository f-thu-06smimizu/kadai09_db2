<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atora | Exploration</title>
    <link rel="stylesheet" href="style.css?v=2">
</head>
<body>

<div class="main-wrapper content-container fade-in">
    <div class="top-label">Atora / Archive</div>

    <main>
        <h1>
            旅に出る前に、<br>
            心にある「澱」を言葉にする。
        </h1>

        <form action="write.php" method="post">
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