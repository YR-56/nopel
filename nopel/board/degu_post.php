<?php

$token = $_POST['token'];

if($token != hash("sha256", session_id())){
   header('Location: degu_board.php');
   exit();
}



$name = $_POST['name'];

if(isset($_POST["kategori"])) {
   // セレクトボックスで選択された値を受け取る
   $kategori = $_POST["kategori"];
 
   
 }

$title = $_POST['title'];



$honbun = $_POST['honbun'];



echo date( "Y年m月d日 H時i分s秒" ) ;

if($name == '' ||  $honbun == ''){
header("Location: degu_board.php"); 
exit(); 
}

//DBに接続

$dsn = 'mysql:host=localhost;dbname=bbs;charset=utf8';
$user = 'root';
$password = '';

try {

//pdoインスタンスを作成
$db = new PDO($dsn, $user, $password);
$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

//プリペアドステートメントを作成
$stmt = $db->prepare("INSERT INTO board (name, title, honbun, date)
VALUES (:name, :title, :honbun, now())
");


$stmt->bindParam(':name', $name, PDO::PARAM_STR);
$stmt->bindParam(':title', $title, PDO::PARAM_STR);

$stmt->bindParam(':honbun', $honbun, PDO::PARAM_STR);


//クエリの実行
$stmt->execute();

header('Location: thank.php');
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