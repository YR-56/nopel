<?php

session_start();

//データベース接続
require_once("/home/manzaisaga/www/nopel/login_function/dbconnect.php");

$dbh = db_connect();

$num = 3;

//データベース接続



//GETメソッドで２ページ目以降が指定されているとき
$page = 1;

$id = $_GET["id"] ?? null;

$post_id = $id;



if(isset($_GET['page']) && $_GET['page'] > 1){
    $page = intval($_GET['page']);
}

try {

   

    //プリペアドステートメントを作成
    $stmt = $dbh->prepare("SELECT * FROM comments  WHERE post_id=:post_id  ORDER BY date DESC LIMIT :page, :num");

    //パラメータ割り当て
    $page = ($page-1) * $num;
    $stmt->bindParam(':page', $page, PDO::PARAM_INT);
    $stmt->bindParam(':num', $num, PDO::PARAM_INT);

  
    $stmt->bindParam( ':post_id', $post_id, PDO::PARAM_INT);
   

    //クエリの実行
    $stmt->execute();

    $statement = null;
} catch (PDOException $e){
    exit("エラー:" . $e->getMessage());
}




//idから記事を一軒取得





//idをセッションIDにセット。書き込み時に読み込まれたときidが受け渡されないのを防ぐため



$statement = $dbh->prepare("SELECT * FROM question WHERE id = ?");

$statement->bindParam(1, $id);

$statement->execute();
$question = $statement->fetch();



$statement = null;

?>

<!-- 記事をHTMLに出力　-->

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title></title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="keywords" content="">
<link rel="stylesheet" href="/css/sample1_style.css">
<link rel="stylesheet" href="/css/N3小説閲覧.css">
<link rel="stylesheet" href=" ">


<script src="openclose.js"></script>
<script src="fixmenu_pagetop.js"></script>




<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>


<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-MS6628RXJJ"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-MS6628RXJJ');
</script>

<![endif]-->
</head>

<body>

<header>
<div class="inner">
<h1 style="color:#99FFFF">Nopel</a></h1>

</div>
</header>

<!--スライドショー-->




<!--PC用（801px以上端末）メニュー-->
<nav id="menubar">
<ul class="inner">
<li><a href="/index.php">ホーム<span>Home</span></a></li>
<li><a href="/mypage/mypage.php">マイページ<span>mypage</span></a></li>

<li><a href="/board/question_eturan.php">掲示板<span>board</span></a></li>
<li><a href="/novel_reading/reading_list.php">小説一覧<span>novel</span></a></li>



</ul>
</nav>
<!--小さな端末用（800px以下端末）メニュー-->


<div id="content_main">
    <article class="article">
<div class="article-info">



<h1><?php echo $question["title"]; ?></h1>



<p><?php echo $question["body"]; ?></p>
<p><?php echo $question["date"]; ?></p>
</div>
</article>

<a href="#com">▼コメントを書く</a><br><br><div class="heading">





<?php 
 

while ($comment = $stmt->fetch()): ?>

    <div class="card">
      
        <div class="card-body">
            <p class="card-text"><?php echo nl2br($comment['body']) ?></p>

</div>

<div class="card-footer">
    <?php echo $comment['date'] ?>

</div>

</div>

<hr>

<?php endwhile; ?>

<?php

//ページ数の表示
try {
    $stmt = $dbh->prepare("SELECT COUNT(*) FROM comments  WHERE post_id=:post_id ");

    $stmt->bindParam( ':post_id', $post_id, PDO::PARAM_INT);

    //クエリの実行
    $stmt->execute();
} catch (PDOException $e) {
    exit("エラー:" . $e->getMessage());
}

//書き込みの件数を取得
$comments = $stmt->fetchColumn();

//ページ数を計算
$max_page = ceil($comments / $num);

if($max_page >= 1){
    echo '<nav><ul class="pagination">';

    for ($i = 1; $i <= $max_page; $i++) {
        echo '<li class="page-item"><a href="comment.php?page='.$i.'&id='. $post_id.'">'.$i.'</a></li>';
    }

    echo '</ul></nav>';
}

?>

<form action="comment_post.php" method="post" id="com">

<div class="form-group">
    <label>内容</label>
    <textarea name="body" class="form-control" row="5">

</textarea>

</div>

<input type="hidden" name="post_id" value="<?php echo $id; ?>">

<input type="submit" class="btn btn-primary" value="書き込む">
</form>
<hr>









<!--/#main-->

<div id="sub">

    <nav class="box">
        <h2>Contents</h2>
        <ul class="submenu">
            
            <li><a href="index.php">ホーム</a></li>
            <li><a href="/mypage/mypage.php">マイページ</a></li>
            <li><a href="./novel_reading/reading_list.php">小説一覧</a></li>
            <li><a href="/board/question_eturan.php">掲示板</a></li>

            
        </ul>
    </nav>


</div>
<!--/#sub-->


<!--/#contents-->



<ul class="nl">

<li><a href="html/nopel_rule.html">利用規約</a></li>


<li><a href="html/privacy.html">プライバシーポリシー</a></li> 

</ul>


<footer>
<small>Copyright&copy; <a href="">Nopel</a> All Rights Reserved.</small>
<span class="pr"><a href="https://template-party.com/" target="_blank">《Web Design:Template-Party》</a></span>
</footer>

<!--PAGE TOP（↑）ボタン-->
<p class="nav-fix-pos-pagetop"><a href="#">↑</a></p>

<!--メニュー開閉ボタン-->
<div id="menubar_hdr" class="close"></div>
<!--メニューの開閉処理条件設定　800px以下-->
<script>
if (OCwindowWidth() <= 800) {
	open_close("menubar_hdr", "menubar-s");
}
</script>




</body>
</html>


<!doctype html>

<html lang="ja" >
    <head>

<meta charset="utf-8">



 

</head>



<body>



<div id="content_main">
    <article class="article">
<div class="article-info">



<h1><?php echo $question["title"]; ?></h1>



<p><?php echo $question["body"]; ?></p>
<p><?php echo $question["date"]; ?></p>
</div>
</article>

<a href="#com">▼コメントを書く</a><br><br><div class="heading">





<?php 
 

while ($comment = $stmt->fetch()): ?>

    <div class="card">
      
        <div class="card-body">
            <p class="card-text"><?php echo nl2br($comment['body']) ?></p>

</div>

<div class="card-footer">
    <?php echo $comment['date'] ?>

</div>

</div>

<hr>

<?php endwhile; ?>

<?php

//ページ数の表示
try {
    $stmt = $dbh->prepare("SELECT COUNT(*) FROM comments  WHERE post_id=:post_id ");

    $stmt->bindParam( ':post_id', $post_id, PDO::PARAM_INT);

    //クエリの実行
    $stmt->execute();
} catch (PDOException $e) {
    exit("エラー:" . $e->getMessage());
}

//書き込みの件数を取得
$comments = $stmt->fetchColumn();

//ページ数を計算
$max_page = ceil($comments / $num);

if($max_page >= 1){
    echo '<nav><ul class="pagination">';

    for ($i = 1; $i <= $max_page; $i++) {
        echo '<li class="page-item"><a href="comment.php?page='.$i.'&id='. $post_id.'">'.$i.'</a></li>';
    }

    echo '</ul></nav>';
}

?>

<form action="comment_post.php" method="post" id="com">

<div class="form-group">
    <label>内容</label>
    <textarea name="body" class="form-control" row="5">

</textarea>

</div>

<input type="hidden" name="post_id" value="<?php echo $id; ?>">

<input type="submit" class="btn btn-primary" value="書き込む">
</form>
<hr>

</body>

</html>