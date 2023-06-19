<?php
    $db_host = "localhost"; //資料庫位置，目前是在本機，因此可以輸入localhost
    $db_username = "root";//資料庫帳號
    $db_password = "";//目前因為是新建立的，因此預設是沒有密碼。我們先這樣簡易練習即可，未來如果要上線，記得要改密碼。
    $db_name = "board"; //要連結的資料庫

    $db_link = new mySqli($db_host,$db_username,$db_password,$db_name);
    //連結資料庫


    //測試是否有連結成功
    if($db_link->connect_error == ""){
        echo "連接成功";
        $db_link->query("SET NAME 'utf8'"); //使用 UTF8解析;
    };

    $sendToSqlData = "SELECT * FROM `msg` ORDER BY `id` DESC"; 
    //這變數，是儲存要送給 SQL 的敘述句。
    $allData = $db_link->query($sendToSqlData);
    //$allData 將上面的 敘述句 送給連結了資料庫的 $db_link，因此會得到 msg 此資料表。



    /*******POST************/
    if(isset($_POST["action"])){
        echo "有接收到 POST喔~";
        $toSaveSql = "INSERT INTO msg (names,title,content) VALUES (?,?,?)";
        $toSave = $db_link->prepare($toSaveSql);
        $toSave->bind_param("sss",
        $_POST["names"],
        $_POST["title"],
        $_POST["content"]);

        $toSave->execute();
        $toSave->close();

        header("Location: index.php");
    };

   


?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
        * { box-sizing:border-box;}
        .msg { margin:0 0 20px 0; padding:0 0 10px 0; border-bottom:1px solid #ededed;}
        .msg p { margin:0; padding:0;font:15px/1.5 "微軟正黑體"}
    </style>
</head>
<body>
    <?php echo "HELLO~"; ?>
    <h1>我的第一個留言板</h1>
    <?php while($item =  $allData->fetch_assoc()){ ?>
        <div class="msg">
            <p>姓名：<?php echo $item["names"]; ?></p>
            <p>標題：<?php echo $item["title"]; ?></p>
            <p>內容：<?php echo $item["content"]; ?></p>
        </div>
    <?php } ?>

    <div class="userMsgInput">
        <form action="" method="post">
            <p>姓名：<input type="text" name="names" id=""></p>
            <p>標題：<input type="text" name="title" id=""></p>
            <p>內容：<input type="text" name="content" id=""></p>
            <input type="hidden" name="action">
            <input type="submit" value="送出">
        </form>
    </div>

</body>
</html>