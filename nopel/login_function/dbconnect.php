<?php

function db_connect(){

$hostname='????.db.sakura.ne.jp';
$dbname='????_nopel'; //データベース名
$user='?????';
$pass='??????'; //データベース接続時のパスワード

try {

$dbh = new PDO('mysql:host='.$hostname.';dbname='.$dbname.';charset=utf8' ,$user,$pass);


} catch (PDOException $e) {


exit('DBConnectError:'.$e->getMessage());
}
return $dbh;

}

