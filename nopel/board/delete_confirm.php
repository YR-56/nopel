



<?php

require_once("/home/manzaisaga/www/nopel/login_function/dbconnect.php");

$dbh = db_connect();

session_start();

$_SESSION["errmsg"] = $errmsg;

//データの受け取り

$id = $_GET["id"] ?? null;



$_SESSION["deleteId"] = $id;


//もし$idがからであった場合、mypage.phpにリダイレクトさせる
if(empty($id)) {
    header("Location: /mypage/eturan.php");
    exit;
}



?>

<form action="question_delete.php" method="post">

<div class="form-group">
    <label>削除パスワード(数字4桁)を入力してください
<?php if(isset($errmsg)) {echo $errmsg;} ?></label>
    <input type="text" name="pass" class="form-control">
</div>

<input type="submit" class="btn btn-primary" value="削除する">
<form>



