<?php
// 新しいセッションを開始
session_start();

// パスワードの設定
define("PASSWORD","adminpassword");
define("PASS","password");

// パスワード一致確認処理
if(!empty($_POST["btn"])){

    if($_POST["password"]===PASSWORD){
        $_SESSION["admin_login"]=true;
    }elseif($_POST["password"]===PASS){
        $_SESSION["user_login"]=true;
    }else{$_SESSION["error"]="ログイン失敗しました";
        header('Location: login.php');
        exit;
    }

    // リダイレクト
    header('Location: top.php');
    exit;
}

//URLを変更して入れないようにする
if(!empty($_SESSION["admin_login"]) || !empty($_SESSION["user_login"])){

}else{
    header('Location: login.php');
    exit;
}

// タイムゾーンの設定
date_default_timezone_set("Asia/Tokyo");

// アップロード画像の処理
if(!empty($_FILES)){

    $imagename = $_FILES['upload_image']['tmp_name']; // 一時ファイル名
    $uploaded_imagepath = './images/'.$_FILES['upload_image']['name'];
    
    if (is_uploaded_file($imagename)) { // POST通信でアップロードされているかを確認
        if(move_uploaded_file($imagename ,$uploaded_imagepath )){ // 一時ファイルを指定したパスのディレクトリに移動
        $image_path = $uploaded_imagepath;
        }else{
        $image_path="";
        } 
    }
}

// アップロードファイルの処理
if(!empty($_FILES)){
 
    $filename = $_FILES['upload_file']['tmp_name']; // 一時ファイル名
    $uploaded_path = './files/'.$_FILES['upload_file']['name'];
    
    if (is_uploaded_file($filename)) { // POST通信でアップロードされているかを確認
        if(move_uploaded_file($filename ,$uploaded_path )){ // 一時ファイルを指定したパスのディレクトリに移動
        $file_path = $uploaded_path;
        }else{
        $file_path="";
        } 
    }
}

// メッセージを保存するファイル名を保存
define("FILENAME","./data.txt");

// 変数の初期化
$message = array();
$message_array = array();

if(!empty($_POST["btn_submit"])){

    if($file_handle =fopen(FILENAME,"a")){
      
    // 書き込み日時を取得
    $now_date = date("[Y年m月d日 H時i分]");

    // 書き込むデータを作成
    $date = "'".$_POST["title"]."','".$_POST["contents"]."','".$image_path."','".$file_path."','".$_POST["name"]."','".$now_date."','".$_POST["important"]."'\n";
        
    //ファイルに書き込む
    fwrite($file_handle, $date);

    //ファイルを閉じる
    fclose($file_handle);
    }

    // リダイレクト
    header('Location: top.php');
    exit;

}

if($file_handle = fopen(FILENAME,"r")){
    while($data = fgets($file_handle)){
        $split_data = preg_split('/\'/',$data);

        $message = array(
            "title" => $split_data[1], //タイトル
            "contents" => $split_data[3], //投稿内容
            "img_data" => $split_data[5], //画像
            "file_data" =>$split_data[7], //ファイル
            "name" => $split_data[9], //社員名
            "post_date" => $split_data[11], //時間
            'important'=> $split_data[13] //重要
        );

        //情報を先頭に入れる
        array_unshift( $message_array, $message);
    }
        // ファイルを閉じる
        fclose($file_handle);
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
    <!-- jquery -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script type="text/javascript"></script>
    <title>株式会社〇〇 | 社内共有掲示板</title>
</head>
<body>
    <div class="top-wrapper">
        <h1>社内共有掲示板</h1>
        <ul class="menu">
            <?php if(!empty($_SESSION["admin_login"])):?>
                <li><a href="./admin.php">投稿画面</a></li>
            <?php endif;?>
                <a href="./login.php"><li><img src="./img/logout.png" alt=""></li></a>
        </ul>
    </div>
    <div class="main-wrapper">
        <?php foreach($message_array as $value){ ?>
            
            <!-- タイトル・投稿日時 -->
            <div class="theme">
                <!-- 重要事項か判断する処理 -->
						<?php if(!empty($value["important"])): ?>
							<p class="red"><?=$value["title"]; ?><time><?=$value["post_date"]?></time></p>
						<?php else: ?>							
							<p class="black"><?=$value["title"]; ?><time><?=$value["post_date"]?></time></p>
						<?php endif; ?>
            </div>
            <!-- 社員名 -->
            <div class="name"><?=$value["name"];?></div>

            <div class="contents-wrapper">
                <!-- 投稿内容 -->
                <div class="contents"><?=$value["contents"]; ?></div>
                <!-- 添付ファイル -->
                <div class="contents">
                        <a class="file" target="_blank" href="<?=$value["file_data"];?>" download>
                            日報をダウンロード
                        </a>
                </div>  
                
                <hr>

                <!-- 添付画像 -->
                <div class="contents">
                    <img class="img" src="<?=$value["img_data"];?>" alt="">
                </div>
            </div>
            
            <!-- フッターメニュー -->
            <div class="footer-menu-wrapper">
                    
                <img class="toggle_img" src="./img/unlike.png" alt="">

            </div>
        <?php } ?>
    </div>
    <script>
        $(".toggle_img").on("click", function () {
        if ($(this).hasClass("change")) {
        $(this).attr("src", "./img/unlike.png");
        $(this).toggleClass("change");
        } else {
        $(this).attr("src", "./img/like.png");
        $(this).toggleClass("change");
        }
        });
    </script>
</body>
</html>