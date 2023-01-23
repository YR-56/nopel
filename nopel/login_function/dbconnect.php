<?php

function db_connect(){

$hostname='mysql621.db.sakura.ne.jp';
$dbname='manzaisaga_nopel'; //データベース名
$user='manzaisaga';
$pass='ryu1rou56'; //データベース接続時のパスワード

try {

$dbh = new PDO('mysql:host='.$hostname.';dbname='.$dbname.';charset=utf8' ,$user,$pass);


} catch (PDOException $e) {


exit('DBConnectError:'.$e->getMessage());
}
return $dbh;

}

