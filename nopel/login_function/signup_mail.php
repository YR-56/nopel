<?php

session_start();

require_once("dbconnect.php");

$errors = [];
$pdo = db_connect();




//クロスサイトリクエストフォージェリ対策

$_SESSION['token'] = base64_encode(openssl_random_pseudo_bytes(32));

$token = $_SESSION['token'];

//クリックジャッキング対策

header('X-FRAME-OPTIONS: SAMEORIGIN');




//送信ボタンをクリックした後の処理
if(isset($_POST['submit'])) {
    
    //メールアドレスが空欄
    if(empty($_POST['mail'])){

        $errors['mail'] = 'メールアドレスが未入力です';
    } else {

        //postされたデータを変数に格納
        $mail = isset($_POST['mail']) ? $_POST['mail'] : NULL;

        //メールアドレス構文チェック
        if(!preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $mail)){
            $errors['mail_check'] = 'メールアドレスの形式が正しくありません';
        }

        //DB確認
        $sql = "SELECT id FROM members WHERE mail=:mail";
        $stm = $pdo->prepare($sql);
        $stm->bindValue(':mail', $mail, PDO::PARAM_STR);

        $stm->execute();
        $dbh = null;


        $result = $stm->fetch(PDO::FETCH_ASSOC);

        //userテーブルに同じメールアドレスがある場合
        if(isset($result["id"])) {
            $errors['user_check'] = 'このメールアドレスはすでに登録されています。';
        }
    }

    //エラーがない場合はそのままpre_userテーブルにインサート
    if(count($errors) === 0){
        $urltoken = hash('sha256', uniqid(rand(),1));
        
        $url = "https://nopel.org/login_function/signup.php?urltoken=".$urltoken;


        //ここでデータベースに登録する
        try{
            //例外処理を投げる
            $sql = "INSERT INTO pre_user (urltoken, mail, date, flag) VALUES (:urltoken, :mail, now(), '0')";
            $stm = $pdo->prepare($sql);
            $stm->bindValue(':urltoken', $urltoken, PDO::PARAM_STR);
            $stm->bindValue(':mail', $mail, PDO::PARAM_STR);
            $stm->execute();

            $dbh = null;
            $message = "メールをお送りしました。24時間以内にメールに記載されたURLからご登録ください";

        } catch (PDOException $e) {
            print('Error:'.$e->getMessage());
            die();
        }


//メール送信処理

$mailTo = $mail;
$companymail = "";
$subject = "[Nopel]本登録確認専用URLのおしらせ";
$body = "この度はご登録ありがとうございます。２４時間以内に下記のURLからご登録ください。\n";

$body .= "https://nopel.org/login_function/signup.php?urltoken=".$urltoken;



   
mb_language('ja');
mb_internal_encoding('UTF-8');

//FROMヘッダーを作成
$header = "From:nopelunei@gmail.com";

if(mb_send_mail($mailTo, $subject, $body, $header,$companymail)){

    //セッション変数をすべて解除
    $_SESSION = array();
    //クッキーの削除
    if(isset($_COOKIE["PHPSESSID"])) {
        setcookie("PHPSESSID", '', time() - 1800, '/');
    }
    //セッションを破棄する
    session_destroy();
    $message = "メールをお送りしました。24時間以内にメールを記載されたURLからご登録ください";
}

    }


}

?>


<h1>仮会員登録画面</h1>
<?php if (isset($_POST['submit']) && count($errors) === 0): ?>
   <!-- 登録完了画面 -->
   <p><?=$message?></p>
   <p>↓TEST用(後ほど削除)：このURLが記載されたメールが届きます。</p>
   <a href="<?=$url?>"><?=$url?></a>
<?php else: ?>
<!-- 登録画面 -->
   <?php if(count($errors) > 0): ?>
       <?php
       foreach($errors as $value){
           echo "<p class='error'>".$value."</p>";
       }
       ?>
   <?php endif; ?>
   <form action="<?php echo $_SERVER['SCRIPT_NAME'] ?>" method="post">
       <p>メールアドレス：<input type="text" name="mail" size="50" value="<?php if( !empty($_POST['mail']) ){ echo $_POST['mail']; } ?>"></p> 
       <input type="hidden" name="token" value="<?=$token?>">
       <input type="submit" name="submit" value="送信">
   </form>
<?php endif; ?>
