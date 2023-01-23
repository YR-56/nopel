<?php

//セッション開始
session_start();


require_once("dbconnect.php");




if(isset($_SESSION['id'])){

//セッションにユーザーIDがある＝ログインしている
//ログイン済みならトップページに遷移する

header('Location: ../mypage/mypage.php');

} else if(isset($_POST['mail']) && isset($_POST['password'])){
//ログインしていないかメールアドレスとパスワードが送信されたとき

$dbh = db_connect();

//プリペアードステートメントを作成
$stmt = $dbh->prepare("SELECT * FROM members WHERE mail=:mail");

//パラメータ割り当て

$stmt->bindParam(':mail', $_POST['mail'], PDO::PARAM_STR);

//クエリ実行
$stmt ->execute();

$result = $stmt->fetch(PDO::FETCH_ASSOC);

var_dump($result['password']);

var_dump($_POST['password']);



if(password_verify($_POST['password'], $result['password'])){

$_SESSION['id'] = $result['mail'];
header('Location: /mypage/mypage.php');
exit();
} else {

//1レコードも取得できなかった時
//ユーザー名　パスワードが間違っている可能性あり
//もう一度ログインフォームを表示

var_dump($password);
var_dump($row);
}

}






//ログインしていない場合は以降のログインフォームを表示する

?>

<!doctype html>

<html lang="ja">

<head>
<title>ログインフォーム</title>

<style type="text/css">
    form {
        width: 100%;
        max-width: 330px;
        padding: 15px;
        margin: auto;
        text-align: center;
    }

#name {
    margin-bottom: -1px;
    border-bottom-right-radius: 0;
    border-bottom-left-radius: 0;

}

#password {
    margin-bottom: 10px;
    border-top-left-radius: 0;
    border-top-right-radius:0;
}

</style>

</head>

<body>

<main role="main" class="container" style="padding:60px 15px 0">

<div>

<!-- ここからが本文 -->

<form action="login3.php" method="post">

<h1>ログインページ</h1>
<label class="sr-only">メールアドレス</label>

<input type="text" id="mail" name="mail" class="form-control" placeholder="メールアドレス">
<label class="sr-only">パスワード</label><br>

<input type="password" id="password" name="password" class="form-control" placeholder="パスワード">

<input type="submit" class="btn btn-primary btn-block" value="ログイン">

</form>

</div>

</body>
</html>

