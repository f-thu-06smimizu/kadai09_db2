<?php
include("functions.php");
$id = $_GET['id'];
$pdo = connect_to_db();

$sql = 'SELECT * FROM sage_routes WHERE id=:id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);

try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

$record = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$record) {
    exit('データが見つかりませんでした');
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atora | Edit Archive</title>
    <link rel="stylesheet" href="style.css?v=<?= time(); ?>">
</head>
<body class="scrollable">
    <div class="wrapper-read fade-in">
        <div class="edit-form-wrapper">
            <p class="top-label" style="text-align: center; margin-bottom: 80px;">Edit Sage Archive</p>
            
            <form action="sage_update.php" method="POST">
                <div class="edit-item">
                    <label class="edit-label">SAGE NAME</label>
                    <textarea name="name" rows="1"><?= h($record['name']) ?></textarea>
                </div>
                
                <div class="edit-item">
                    <label class="edit-label">LOCATION</label>
                    <textarea name="location_name" rows="1"><?= h($record['location_name']) ?></textarea>
                </div>
                
                <div class="edit-item">
                    <label class="edit-label">DESCRIPTION / EXPERIENCE</label>
                    <textarea name="description" rows="5"><?= h($record['description']) ?></textarea>
                </div>
                
                <input type="hidden" name="id" value="<?= $record['id'] ?>">
                
                <div style="text-align: center; margin-top: 80px;">
                    <button class="btn-enter">UPDATE ARCHIVE</button>
                    <a href="read.php" style="display:block; margin-top:40px; font-family: Montserrat; font-size:0.5rem; color:#aaa; text-decoration:none; letter-spacing: 0.2em;">CANCEL</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>