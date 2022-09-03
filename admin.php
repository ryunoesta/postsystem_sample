<?php
// 新しいセッションを開始
session_start();

// ログインできていない場合
if(empty($_SESSION["admin_login"])){
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- favicon -->
    <link rel="icon" href="">
    <!-- css -->
    <link rel="stylesheet" href="style.css">
    <title>株式会社〇〇 | 投稿画面</title>
</head>
<body>
    <div class="container">
        <div class="title">
            <h1>株式会社〇〇</h1>
        </div>

        <h2>社内共有掲示板</h2>

        <form action="./top.php" method="post" enctype="multipart/form-data">
            <div class="content-title">
                <p>タイトル</p>
                
            </div>
            <div class="content-area">
                <input type="text" name="title" required>
                <hr>
            </div>
            <div class="content-title">
                <p>投稿内容</p>
            </div>
            <div class="content-area">
                <input type="text" name="contents" required>
            </div>
            <div class="content-title">
                <p>画像アップロード</p>
            </div>
            <div class="content-area">
                <input type="file" name="upload_image" accept="image/*">
            </div>
            <div class="content-title">
                <p>日報アップロード</p>
            </div>
            <div class="content-area">
                <input type="file" name="upload_file" enctype="multipart/form-data">
            </div>
            <div class="content-title">
                <p>社員名</p>
            </div>
            <div class="content-area">
                <input type="text" name="name" required>
            </div>
            <!-- 重要ボタン -->
            <label>
                <input type="checkbox" name="important" value="1" >重要・緊急事項
            </label>
            <input type="submit" name="btn_submit" value="投稿">
        </form>
    </div>
</body>
</html>