<?php

session_start();
if (isset($_SESSION['id'])){
    unset($_SESSION['id']);
}
header('Location: /login_function/login3.php')

?>