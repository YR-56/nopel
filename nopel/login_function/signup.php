<?php 

session_start();

require_once("dbconnect.php");

$pdo = db_connect();

//クロスサイトリクエストフォージェリ対策
$_SESSION['token'] = base64_encode(openssl_random_pseudo_bytes(32));
$token = $_SESSION['token'];

//クリックジャっキング対策
header('X-FRAME-OPTIONS: SAMEORIGIN');

//成功、エラーメッセージの初期化
$errors = array();



if(empty($_GET)) {
    header("Location: signup.php");
    exit();
}else{
    //GETデータを変数に格納
    $urltoken = isset($_GET["urltoken"]) ? $_GET["urltoken"] : NULL;

    //メール入力判定
    if($urltoken == ''){
        $errors['urltoken'] = "トークンがありません";

    }else{
        try{
            //DB接続
            //flagが０の未登録者　or 仮登録日から２４時間以内
            $sql = "SELECT mail FROM pre_user WHERE urltoken=(:urltoken) AND flag =0 AND date > now() - interval 24 hour";
            $stm = $pdo->prepare($sql);
            $stm->bindValue(':urltoken', $urltoken, PDO::PARAM_STR);
            $stm->execute();

            //レコード件数取得
            $row_count = $stm->rowCount();

            //24時間以内に仮登録され、本登録されていないトークンの場合
            if($row_count == 1){
                $mail_array = $stm->fetch();
                $mail = $mail_array["mail"];
                $_SESSION['mail'] = $mail;
            }else{
                $errors['urltoken_timeover'] = "このURLはご利用できません。有効期限がすぎたかURLが間違っている可能性があります。もう一度登録をやりなおしてください。";

            }
            //データベース接続切断
            $stm = null;

        }catch(PDOException $e){
            print('Error:'.$e->getMessage());
            die();
        }
    }
}

/*確認する押した後の処理*/

if(isset($_POST['btn_confirm'])){
    if(empty($_POST)){
        header("Location: registration_mail.php");
        exit();
    }else{
        //POSTされたデータを各変数に入れる
        $name = isset($_POST['name']) ? $_POST['name'] : NULL;
        $password = isset($_POST['password']) ? $_POST['password'] :NULL;

        //セッションに登録
        $_SESSION['name'] = $name;
        $_SESSION['password'] = $password;

        //アカウント入力判定
        //パスワード

        if($password == ''):
            $errors['password'] = "パスワードが入力されていません";
        else:
            $password_hide = str_repeat('*', strlen($password));
        endif;

        if($name == ''):
            $errors['name'] = "氏名が入力されていません。";
        endif;
    }
}

/**
 * 
 * page_3
 * 登録押した後の処理
 * 
 */

 if(isset($_POST['btn_submit'])){
     $password = password_hash($_SESSION['password'], PASSWORD_DEFAULT);

     //ここでデータベースに接続する
     try{
         $sql = "INSERT INTO members (name,password, mail) VALUES (:name,:password,:mail)";
         $stm = $pdo->prepare($sql);
         $stm->bindValue(':name', $_SESSION['name'], PDO::PARAM_STR);
         $stm->bindValue(':mail', $_SESSION['mail'], PDO::PARAM_STR);
         $stm->bindValue(":password", $password, PDO::PARAM_STR);
         $stm->execute();

         //pre_userのflagを１にする（トークンの）無効
         $sql = "UPDATE pre_user SET flag=1 WHERE mail=:mail";
         $stm = $pdo->prepare($sql);

         //プレースホルダへ実際の値を設定する
         $stm->bindValue(':mail', $mail, PDO::PARAM_STR);
         $res = $stm->execute();
         

         exit();

        /**
         * 登録ユーザーと管理者へ仮登録されたメール送信
         * 
         * 
         * 
         */


         

         $_SESSION['mail'] = $mail;
         $companymail = "";
         $mailTo = $mail;
         $body = <<< EOM
         この度はご登録ありがとうございます。
         本登録いたしました。
         EOM;

         mb_language('ja');
         mb_internal_encoding('UTF-8');

         //FROMヘッダーを作成
         $header = 'From: nopelunei@gmail.com';

         if(mb_send_mail($mailTo, $body, $header, $companymail)){
            $message['success'] = "会員登録されました";

         }else{
             $errors['mail_error'] = "メールの送信に失敗しました";

         }

         

         //データベース接続遮断
         $stm = null;

         //セッション変数をすべて解除
         $_SESSION = array();

         //セッションクッキーの削除
         if(isset($_COOKIE["PHPSESSID"])) {
             setcookie("PHPSESSID", '', time() - 1800, '/');
         }

         //セッションを破棄する
         session_destroy();
     }catch (PDOException $e){
         //トランザクション取り消し
         $pdo->rollback();
         $errors['error'] = "もう一度やり直してください。";
         print('Error:'.$egetMessage());
     }
 }



?>





<h1>会員登録画面</h1>

<!-- page_3 完了画面-->

<?php if(isset($_POST['btn_submit']) && count($errors) === 0): ?>
<a>本登録されました。</a>

<!-- page_2 確認画面 -->
<?php elseif(isset($_POST['btn_confirm']) && count($errors) === 0): ?>
    <form action="<?php echo $_SERVER['SCRIPT_NAME'] ?>?urltoken=<?php print $urltoken; ?>" method="post">

<p>メールアドレス: <?=htmlspecialchars($_SESSION['mail'], ENT_QUOTES)?></p>
<p>パスワード: <?=$password_hide?></p>
<p>ユーザー名:<?=htmlspecialchars($name, ENT_QUOTES)?></p>

<input type="submit" name="btn_back" value="戻る">
<input type="hidden" name="token" value="<?=$_POST['token']?>">
<input type="submit" name="btn_submit" value="登録する">
</form>

<?php else: ?>
    <!-- page_1 登録画面 -->

    <?php if(count($errors) > 0): ?>
        <?php
        foreach($errors as $value){
            echo "<p class='error'>".$value."</p>";
        }

?>

<?php endif; ?>

<?php if(!isset($errors['urltoken_timeover'])): ?>
<form action="<?php echo $_SERVER['SCRIPT_NAME'] ?>?urltoken=<?php print $urltoken; ?> " method="post">
<p>メールアドレス:<?=htmlspecialchars($mail, ENT_QUOTES, 'UTF-8')?></p>
<p>パスワード: <input type="password" name="password"></p>
<p>氏名：<input type="text" name="name" value="<?php if(!empty($_SESSION['name'])){echo $_SESSION['name']; } ?>"></p>

<input type="hidden" name="token" value="<?=$token?>">
<input type="submit" name="btn_confirm" value="確認する">

</form>

<?php endif; ?>
<?php endif; ?>

