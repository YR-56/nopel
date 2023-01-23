<?php



//データベース接続
require_once("/home/manzaisaga/www/nopel/login_function/dbconnect.php");

$dbh = db_connect();



$title = $_POST['title'];

$name = $_POST['name'];

$body = $_POST['body'];

$pass = $_POST['pass'];


//必須項目
if($body == '' || $title == '' || $name == ''){
    header("Location: first_board.php");
    exit();
}

if(!preg_match("/^[0-9]{4}$/", $pass)){

    header("Location: first_board.php");
}




try {
   
    $stmt = $dbh->prepare("INSERT INTO question (name, title, body, date, pass)
    VALUES (:name, :title, :body, now(), :pass)");

    //プリペアードステートメントにパラメータを割り当てる
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':title', $title, PDO::PARAM_STR);
    $stmt->bindParam(':body', $body, PDO::PARAM_STR);
    $stmt->bindParam(':pass', $pass, PDO::PARAM_STR);

    //クエリの実行

    $stmt->execute();

    //board.phpにもどる
    header('Location:question_eturan.php');
    exit();
} catch (PDOException $e) {
    exit('エラー:' . $e->getMessage());

   
}




?>