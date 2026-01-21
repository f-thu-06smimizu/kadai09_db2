<?php
session_start();
include("functions.php");

$lid = $_POST["lid"];
$lpw = $_POST["lpw"];

$pdo = db_conn();

$sql = "SELECT * FROM users_table WHERE lid = :lid AND life_flg = 0";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':lid', $lid, PDO::PARAM_STR);
$status = $stmt->execute();

if($status == false){
    sql_error($stmt);
}

$val = $stmt->fetch();

if( $val["id"] != "" && password_verify($lpw, $val["lpw"]) ){
    $_SESSION["chk_ssid"]  = session_id();
    $_SESSION["kanri_flg"] = $val['kanri_flg'];
    $_SESSION["username"]  = $val['username'];
    header("Location: input.php");
} else {
    header("Location: login.php");
}
exit();