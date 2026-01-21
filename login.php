<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atora | Login</title>
    <link rel="stylesheet" href="style.css?v=<?= time(); ?>">
</head>
<body class="scrollable">
    <div class="wrapper-read fade-in">
        <div class="edit-form-wrapper" style="margin-top: 20vh;">
            <p class="top-label" style="text-align: center; margin-bottom: 60px;">Sign in to Atora</p>
            
            <form action="login_act.php" method="POST">
                <div class="edit-item">
                    <label class="edit-label">USERNAME</label>
                    <input type="text" name="username" class="edit-input" required style="width: 100%; background: transparent; border: none; border-bottom: 0.5px solid #e0e0e0; padding: 10px 0; outline: none;">
                </div>
                
                <div class="edit-item" style="margin-top: 30px;">
                    <label class="edit-label">PASSWORD</label>
                    <input type="password" name="password" class="edit-input" required style="width: 100%; background: transparent; border: none; border-bottom: 0.5px solid #e0e0e0; padding: 10px 0; outline: none;">
                </div>
                
                <div style="text-align: center; margin-top: 80px;">
                    <button class="btn-enter">ENTER</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>