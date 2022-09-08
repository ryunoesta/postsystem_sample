<?php
// 新しいセッションを開始
session_start();

// 既存のセッションを解除
if(!empty($_SESSION["admin_login"])||!empty($_SESSION["user_login"])){
    unset($_SESSION["admin_login"],$_SESSION["user_login"]);
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
    <link rel="stylesheet" href="./style.css">
    <title>株式会社〇〇 | ログイン画面</title>
    <meta name="description" content="ログイン画面です">
</head>
<body>

    <div class="title">
        <h1>株式会社〇〇</h1>
    </div>
    
    <form action="top.php" method="post">

        <div class="content-title">
            <p>パスワード</p>
        </div>   

        <!-- ログイン失敗 -->
        <?php if(!empty($_SESSION["error"])):
            $error = $_SESSION["error"];
            unset($_SESSION["error"]);
        ?>
        <ul class = error_message>
            <li><?php echo $error;?></li>
        </ul>
        <?php endif;?>

        <!-- パスワード入力 -->
        <div class="content-area">
            <input type="password" name="password">
        </div>

        <!-- ログインボタン -->
        <div class="ログイン">
        <input type="submit" name="btn" value="ログイン">
        </div>

    </form>

</body>
</html>

