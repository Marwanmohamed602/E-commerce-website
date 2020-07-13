<?php
session_start();
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    define('__ROOT__', "../");
    require_once(__ROOT__ ."Model/CartModel.php");
    require_once(__ROOT__ ."Controller/CartController.php");
    $model = new CartModel(null, $_SESSION['id'], 'pending');
    $cart = new CartController($model);
    $cart->insert();
    header('location:' . $_SERVER['HTTP_REFERER'] . '?success=product added successfully');
}
else {
    header('location:index.php');
}
?>