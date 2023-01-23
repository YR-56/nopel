<?php

require_once("/home/manzaisaga/www/nopel/login_function/dbconnect.php");

$db = db_connect();


//1ページに表示される書き込みの数
$num = 10;
$page = $_GET['page'] ?? 1;
//pageパラメータで値が渡されたらそのページ、なければ1ページ目

$offset = ($page - 1) * $num;




//1件ごと１０ずつSQLからデータを抽出

$statement = $db->prepare("SELECT * FROM nopel_posts ORDER BY id DESC LIMIT ? OFFSET ?");
$statement->bindParam(1, $num, PDO::PARAM_INT);
$statement->bindParam(2, $offset, PDO::PARAM_INT);

$statement->execute();

$novels = $statement->fetchAll();





$statement = $db->prepare('SELECT COUNT(*) As count FROM nopel_posts');
$statement->execute();

$numbers = $statement->fetchColumn();

//ページ数を計算
$page_number = ceil($numbers / $num);











$statement = null;


$novels_json = json_encode($novels);


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
<li><a href="../index.php">ホーム<span>Home</span></a></li>
<li><a href="/mypage/mypage.php">マイページ<span>mypage</span></a></li>



</ul>
</nav>



<div id="contents" class="inner">

<div id="main">



<h3><a href="/login_function/entry2.php">小説を投稿する場合はユーザー登録をお願いします。</a></h3>





<section id="new">

<div id="content_main">

    <article class="article">
    
    <div class="article-info">
<?php
    
//ページネーションを表示
for ($i = 1; $i <= $page_number; $i ++){
    if($i == $page){
        echo "<span style='padding: 5px;'>$page</span>";
        

    }else {
        echo "<a href='./sample_eturan_pagenavi.php?page=$i' style='padding: 5px;'>$i</a>";

    }}




    
    foreach ($novels as $novel) {
        echo '<div class="enclosure">';


        echo "<div>作者:" . htmlspecialchars($novel['name'], ENT_QUOTES, 'UTF-8') . "</div>";



        echo "<div>タイトル" . htmlspecialchars($novel['title'], ENT_QUOTES, 'UTF-8') . "</div>";
        echo "<div><span>カテゴリー：" . htmlspecialchars($novel['kategori'], ENT_QUOTES, 'UTF-8') . "</span></div>";
        echo "<div class='upper'><p>あらすじ" . htmlspecialchars($novel['summary'], ENT_QUOTES, 'UTF-8') . "</br></p></div>";
        echo "<div>投稿日時：" . htmlspecialchars($novel['date'], ENT_QUOTES, 'UTF-8') . "</div>";
        echo '<a href="post_detail.php?id=' .$novel['id'] . '">本文を読む</a>';
        echo '</div>';

}
        
    
    ?>
    
  
    
    
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
            
            

            
        </ul>
    </nav>

   


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
