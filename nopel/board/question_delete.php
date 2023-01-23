<?php
require_once("/home/manzaisaga/www/nopel/login_function/dbconnect.php");

$dbh = db_connect();

session_start();

//データの受け取り


$_SESSION["deleteId"] = $id;

var_dump($id);

$pass = $_POST['pass'];

$statement = $dbh->prepare("SELECT * FROM question WHERE id = ?");
$statement->bindParam(1, $id, PDO::PARAM_INT);

$password = $statement->execute();

if(empty($pass)) {
header('Location: /board/passkara.php');

}





if($password["pass"] !== $pass){
$errmsg = ["パスワードが間違っています"];
$_SESSION["errmsg"] = $errmsg;


}


/*
try {

    $statement = $db->prepare("DELETE FROM question WHERE id = ?");
    $statement->bindParam(1, $id, PDO::PARAM_INT);
    $statement->execute();

    header('Location: /mypage/mypage.php');


} catch (PDOException $e) {
    exit('エラー:' . $e->getMessage());
}

*/


?>