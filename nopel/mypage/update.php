<?php

session_start();
require_once("/dbconnect.php");


//URLの？以降で渡されるIDをキャッチ

$id = $_GET['id'];

//もし、＄idがからであったらmypage.phpにリダイレクトする

if(empty($id)) {
    header("Location: mypage.php");
    exit;
}

//データベース接続

$dbh = db_connect();


try {

$statement = $dbh->prepare("SELECT * FROM nopel_posts WHERE id = ?");
$statement->bindParam(1, $id, PDO::PARAM_INT);
$statement->execute();

$novel = $statement->fetchall();

} catch (PDOException $e) {
    //エラーメッセージの出力
    echo 'Error:' . $e->getMessage();

    die();
}

foreach ($novel as $row){
    $id = $row['id'];
    $title = $row['title'];
    $honbun = $row['honbun'];
    $summary = $row['summary'];
}

?>

<!doctype html>
<html>
    <head>
<title>記事編集</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>

<body>
    <h1>記事編集</h1>
    <form method="POST" action="update_done.php">
<input type="hidden" name="id" value="<?php echo $id; ?>">


title: <br>
<input type="text" name="title" id="title" style="width:200px; height:50px;" value=<?php echo $title; ?>>
<br>

summary: <br>
<input type="text" name="summary" id="summary" style="width:200px;height:100px;" value=<?php echo $summary; ?>>
<br>


honbun: <br>
<input type="text" name="honbun" id="honbun" style="width:200px;height:100px;" value=<?php echo $honbun; ?>><br>

<input type="submit" value="submit" id="edit" name="edit">

</form>
</body>
</html>





