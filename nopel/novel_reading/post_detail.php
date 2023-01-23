<?php

require_once("/dbconnect.php");

$db = db_connect();




//idから記事を一軒取得

$id = $_GET["id"] ?? null;
$statement = $db->prepare("SELECT * FROM nopel_posts WHERE id = ?");

$statement->bindParam(1, $id);

$statement->execute();
$novel = $statement->fetch();

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







<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
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
<li><a href="/mypage/mypage.php">マイページ<span>mypage</span></a></li>
<li><a href="./novel_reading/reading_list.php">小説一覧<span>novel</span></a></li>





</ul>
</nav>



<div id="contents" class="inner">

<div id="main">


<h3>小説サイト<br>
<a href="/login_function/entry2.php">ユーザー登録はこちら</a></h3>





<section id="new">

<div id="content_main">

    <article class="article">
    
    <div class="article-info">
<h3><?php echo $novel["name"]; ?></h3>
<h1><?php echo $novel["title"]; ?></h1>

<div><?php echo $novel["kategori"]; ?></div>

<p><?php echo $novel["honbun"]; ?></p>




    </div>
    </article>
    </div>
    
    
    <script>
    
    var novels = JSON.parse('{?php echo $novels_json; ?}');
    
    console.log(novels)
    
    for(i = 0; i < novels.length; i++) {
        $button = document.createElement('button');
        $button.onclick = function(){
    
        alert(i);
        alert(novels[i]);
    
    
        }
    }
    
    </script>
    

</section>

<section>


</div>
<!--/#main-->

<div id="sub">

    <nav class="box">
        <h2>Contents</h2>
        <ul class="submenu">
            <li><a href="../index.php">ホーム</a></li>
            <li><a href="/mypage/mypage.php">マイページ</a></li>
            <li><a href="/novel_reading/reading_list.php">小説一覧</a></li>
            

            
        </ul>
    </nav>

    <section class="box">
        <h2>ご予約、お問い合わせは<br><tel></tel></h2>
        
    </section>



</div>
<!--/#sub-->


<!--/#contents-->

<footer>
<small>Copyright&copy; <a href="">旅館</a> All Rights Reserved.</small>
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
