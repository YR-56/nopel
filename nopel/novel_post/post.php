<?php

require_once("/home/manzaisaga/www/nopel/login_function/dbconnect.php");

$token = $_POST['token'];

if($token != hash("sha256", session_id())){
   header('Location: /novel_post/novel_post.php');
   exit();
}

session_start();
if(isset($_SESSION['id'])){

   $mail = $_SESSION['id'];

}


$name = $_POST['name'];

if(isset($_POST["kategori"])) {
   // セレクトボックスで選択された値を受け取る
   $kategori = $_POST["kategori"];
 
   
 }

$title = $_POST['title'];

$summary = $_POST['summary'];

$honbun = $_POST['honbun'];



echo date( "Y年m月d日 H時i分s秒" ) ;

if($name == '' || $title == '' || $honbun == ''){
header("Location: 小説投稿.php"); 
exit(); 
}

try {

$db = db_connect();

//プリペアドステートメントを作成
$stmt = $db->prepare("INSERT INTO nopel_posts (mail, name, title, kategori, summary, honbun, date)
VALUES (:mail, :name, :title, :kategori, :summary, :honbun, now())
");

$stmt->bindParam(':mail', $mail, PDO::PARAM_STR);
$stmt->bindParam(':name', $name, PDO::PARAM_STR);
$stmt->bindParam(':title', $title, PDO::PARAM_STR);
$stmt->bindParam(':kategori', $kategori, PDO::PARAM_STR);
$stmt->bindParam(':honbun', $honbun, PDO::PARAM_STR);
$stmt->bindParam(':summary', $summary, PDO::PARAM_STR);

//クエリの実行
$stmt->execute();

header('Location: novel_done.html');
exit();


} catch (PDOException $e){
exit('エラー:' . $e->getMessage());
}



?>

<html>

<head>
<meta charset="UTF-8">
<title>確認</title>


</head>

<body>

<p>作者名: <?php echo $name; ?></p>
<p>原作カテゴリ: <?php echo $kategori; ?></p>
<p>あらすじ: <?php echo $summary; ?></p>
<p>タイトル: <?php echo $title; ?></p>
<p>本文: <?php echo $honbun; ?></p>

 

</body>
   </html>