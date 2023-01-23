
<?php

require_once("dbconnect.php");

session_start();

if(empty($_SESSION['id'])) {
//ログインページへリダイレクト

header("Location: ../login_function/login3.php");
echo "ログインしてください";
exit;
}



$db = db_connect();

$memberID = $_SESSION['id'];

$statement = $db->prepare("SELECT * FROM nopel_posts WHERE memberID = ?");
$statement->bindParam(1, $memberID, PDO::PARAM_INT);
$statement->execute();

$userspage = $statement->fetchall();



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
<script async src="https://www.googletagmanager.com/gtag/js?id=G-17M1D0PRFC"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-17M1D0PRFC');
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
<li><a href="../index.php">ホーム<span>Home</span></a></li>

<li><a href="/novel_reading/reading_list.php">小説一覧<span>novel</span></a></li>



</ul>
</nav>
<!--小さな端末用（800px以下端末）メニュー-->

<div id="contents" class="inner">

<div id="main">

<section id="new">


<div id="content_main">
<h3><a href="/novel_post/novel_post.php">小説を投稿する</a></h3>

        <h2><a class="nav-link" href="logout.php">ログアウトする</a></h2>
   
    
    
    </div>
    
    


</section>

</div>
</div>




<div id="content_main">



<article class="article">

<div class="article-info">
<?php




foreach ($userspage as $userpage) {

    echo "<h3>" . htmlspecialchars($userpage['name'], ENT_QUOTES, 'UTF-8');
    echo "<h1>" . htmlspecialchars($userpage['title'], ENT_QUOTES, 'UTF-8') . "</h1>";
    echo "<span>カテゴリー：" . htmlspecialchars($userpage['kategori'], ENT_QUOTES, 'UTF-8') . "</span>";
    echo "<p>あらすじ" . htmlspecialchars($userpage['summary'], ENT_QUOTES, 'UTF-8') . "</br></p>";
    echo "<time>投稿日時：" . htmlspecialchars($userpage['date'], ENT_QUOTES, 'UTF-8') . "</time>";
    echo "<p>本文" .htmlspecialchars($userpage['honbun'], ENT_QUOTES, 'UTF-8') . "<p>";



?>

<a href="update.php?id=<?php echo $userpage['id']; ?>">編集</a>
<a href="delete.php?id=<?php echo $userpage['id']; ?>">削除</a>

<?php

}

?>



</div>
</article>



   
    
    
    </div>
    
    


</section>

<section>


</div>
<!--/#main-->

<div id="sub">

    <nav class="box">
        <h2>Contents</h2>
        <ul class="submenu">
            
            <li><a href="index.php">ホーム</a></li>
            <li><a href="/mypage/mypage.php">マイページ</a></li>
            <li><a href="./novel_reading/reading_list.php">小説一覧</a></li>

            
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
