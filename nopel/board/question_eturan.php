<?php
//データベース接続
require_once("/????/www/nopel/login_function/dbconnect.php");

session_start();

$dbh = db_connect();

//全記事を抽出
$statement = $dbh->prepare("SELECT * FROM  question");
$statement->execute();
$questions = $statement->fetchAll();
$statement = null;




?>

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

<style>

.enclosure {
  border:medium solid;
  border-spacing: 50px;
  border-color: lime;
}

.wrap {
 width: 100%;
}

.upper {
justify-content: center;
align-items:center;
width:100%;
height:100px;
background-color:black;
border-color:black;
}

</style>
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
<li><a href="index.php">ホーム<span>Home</span></a></li>
<li><a href="/mypage/mypage.php">マイページ<span>mypage</span></a></li>

<li><a href="/board/question_eturan.php">掲示板<span>board</span></a></li>
<li><a href="/novel_reading/reading_list.php">小説一覧<span>novel</span></a></li>



</ul>
</nav>
<!--小さな端末用（800px以下端末）メニュー-->

<h3><a href="/board/question.php" >新たに書き込む</a></h3>





<div id="content_main">

<article class="article">

<div class="article-info">
<?php




foreach ($questions as $question) {

    echo '<div class="enclosure">';
  
    echo "<h1>" . htmlspecialchars($question['title'], ENT_QUOTES, 'UTF-8') . "</h1>";
    echo "<p>本文:" . htmlspecialchars($question['body'], ENT_QUOTES, 'UTF-8') . "</br></p>";
    echo "<p>" .htmlspecialchars($question['name'], ENT_QUOTES, 'UTF-8') . "</br></p>";
    echo "<time>投稿日時：" . htmlspecialchars($question['date'], ENT_QUOTES, 'UTF-8') . "</time>";
    

?>


<div>
    <a href="comment.php?id=<?php echo $question["id"];?>">書き込む</a>
</div>

<div>
    <a href="delete_confirm.php?id=<?php echo $question["id"]; ?>">削除</a>

</div>


<?php

echo '</div>';

}

?>


</div>
</article>
</div>

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
