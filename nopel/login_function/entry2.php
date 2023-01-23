<?php 
require("./dbconnect.php");
session_start();

$db = db_connect();

if (!empty($_POST)) {
    /* 入力情報の不備を検知 */
    if ($_POST['memberID'] === "") {
        $error['memberID'] = "blank";
    }
    if ($_POST['password'] === "") {
        $error['password'] = "blank";
    }
    
    /* メールアドレスの重複を検知 */
    if (!isset($error)) {
        $member = $db->prepare('SELECT COUNT(*) as cnt FROM members WHERE memberID=?');
        $member->execute(array(
            $_POST['memberID']
        ));
        $record = $member->fetch();
        if ($record['cnt'] > 0) {
            $error['memberID'] = 'duplicate';
        }
    }

    /* エラーがなければ次のページへ */
    if (!isset($error)) {
        $_SESSION['join'] = $_POST;   // フォームの内容をセッションで保存
        header('Location: check2.php');   // check.phpへ移動
        exit();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0">
    <title>アカウント作成</title>
    <link href="https://unpkg.com/sanitize.css" rel="stylesheet"/>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="content">
        <form action="" method="POST">
            <h1>アカウント作成</h1>
            <p>当サービスをご利用するために、次のフォームに必要事項をご記入ください。</p>
            <br>

            <div class="control">
                <label for="name">ユーザー名</label>
                <input id="name" type="text" name="name">
            </div>

            <div class="control">
                <label for="memberID">会員ID<span class="required">必須</span></label>
                <input id="memberID" type="memberID" name="memberID">
                <?php if (!empty($error["memberID"]) && $error['memberID'] === 'blank'): ?>
                    <p class="error">＊会員IDを入力してください</p>
                <?php elseif (!empty($error["memberID"]) && $error['memberID'] === 'duplicate'): ?>
                    <p class="error">＊この会員IDはすでに登録済みです</p>
                <?php endif ?>
            </div>

            <div class="control">
                <label for="password">パスワード<span class="required">必須</span></label>
                <input id="password" type="password" name="password">
                <?php if (!empty($error["password"]) && $error['password'] === 'blank'): ?>
                    <p class="error">＊パスワードを入力してください</p>
                <?php endif ?>
            </div>

            <div class="control">
                <button type="submit" class="btn">確認する</button>
            </div>
        </form>
    </div>
</body>
</html>
