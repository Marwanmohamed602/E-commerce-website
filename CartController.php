<?php

  require_once(__ROOT__ . "Controller/Controller.php");

class CartController extends Controller
{
    public function insert() 
    {
          // Escape user inputs for security
    $user_id = $_SESSION['id'];
    $product_id = $_REQUEST['product_id'];
    $active = $this->model->checkUserCarts($user_id);
    if($active == 0) {
        $cart_id = $this->model->createCart($user_id);
    }
    else {
        $cart_id = $active;
    }
    $this->model->addProduct($cart_id, $product_id);

    }

    public function confirm()
    {
    
    $cart_id = $_REQUEST['cart_id'];

      $this->model->confirmCart($cart_id); 
    }

   
}
?>