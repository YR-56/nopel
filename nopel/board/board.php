<?php

$num = 10;

//DBに接続
$dsn = 'mysql:host=localhost;dbname=bbs;charset=utf8';
$user = 'root';
$password = '';

//GETメソッドで２ページ目以降が指定されているとき
$page = 1;
if(isset($_GET['page']) && $_GET['page'] > 1){
    $page = intval($_GET['page']);
}

try {

    //PDOインスタンスの生成
    $db = new PDO($dsn, $user, $password);
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

    //プリペアドステートメントを作成
    $stmt = $db->prepare("SELECT * FROM board ORDER BY date DESC LIMIT :page, :num");

    //パラメータ割り当て
    $page = ($page-1) * $num;
    $stmt->bindParam(':page', $page, PDO::PARAM_INT);
    $stmt->bindParam(':num', $num, PDO::PARAM_INT);

    $stmt->bindParam(':num', $num, PDO::PARAM_INT);

    //クエリの実行
    $stmt->execute();
} catch (PDOException $e){
    exit("エラー:" . $e->getMessage());
}



?>





<h1>掲示板</h1>
<form action="bbs_post.php" method="post">
    <div class="form-group">
        <label>タイトル</label>
        <input type="text" name="title" class="form-control">
</div>



<div class="form-group">
    <label>内容</label>
    <textarea name="body" class="form-control" row="5">

</textarea>

</div>

<div class="form-group">
    <label>削除パスワード(数字4桁)</label>
    <input type="text" name="pass" class="form-control">
</div>

<input type="submit" class="btn btn-primary" value="書き込む">
</form>
<hr>

<?php while ($row = $stmt->fetch()): ?>

    <div class="card">
        <div class="card-header"><?php echo $row['title']? $row['title']: '(無題)'; ?></div>
        <div class="card-body">
            <p class="card-text"><?php echo nl2br($row['body']) ?></p>

</div>

<div class="card-footer">
    <?php echo $row['date'] ?>

</div>

</div>

<hr>

<?php endwhile; ?>

<?php

//ページ数の表示
try {
    $stmt = $db->prepare("SELECT COUNT(*) FROM board");

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
        echo '<li class="page-item"><a href="board.php?page='.$i.'">'.$i.'</a></li>';
    }

    echo '</ul></nav>';
}

?>
