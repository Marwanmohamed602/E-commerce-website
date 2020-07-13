<?php
  require_once(__ROOT__ . "Model/Model.php");
?>

<?php
class CartModel extends Model 
{
    public $id;
    public $user_id;
    public $status;

    
    function __construct($id = null, $user_id = null, $status = null) 
	{
		$this->id = $id;
		if($id != null)
		{
		$this->readCart($id);
		}else
		{
		$this->user_id = $user_id;
		$this->status = $status;
		
		}
	}
	function readCart($id)
	{
		$sql = "SELECT * FROM cart_items where cart_items.cart_id=".$id;
		$dbh = $this->connect();
		$result = $dbh->query($sql);
		if ($result->num_rows > 0)
		{
			while($data = $result->fetch_assoc())
				$row[] = $data['product_id'];
				
			$sql = 'SELECT * FROM products WHERE id IN (' . implode(',', array_map('intval', $row)) . ')';
			$dbh = $this->connect();
			$results = $dbh->query($sql);
			if ($results->num_rows >0) {
				while($data = $results->fetch_assoc())
					$prod[] = $data;

				return $prod;

			}
		}
		else 
		{
			return null;
			
		}
		//$this->conn->close();
	}

	function checkUserCarts($user_id)
	{
		$sql = "SELECT * FROM carts where user_id='$user_id' AND status='pending'";
		$dbh = $this->connect();
		$result = $dbh->query($sql);
		// return $result->num_w
		if ($result->num_rows > 0)
		{
			$row = $dbh->fetchRow();
			return $row['id'];
			
		}
		else 
		{
			return 0;
			
		}
	}

	function createCart($user_id)
	{
		$sql = "INSERT INTO carts(user_id) VALUES('$user_id')";
		$dbh = $this->connect();
		if($dbh->query($sql))
			return $dbh->insert_id;
		else
			return false;
		
	}

	function addProduct($cart_id, $product_id)
	{
		$sql = "INSERT INTO cart_items(cart_id,product_id) VALUES($cart_id,'$product_id')";
		$dbh = $this->connect();
		if($dbh->query($sql))
			return true;
		else
			return false;
	}

	function confirmCart($cart_id)
	{
		$sql = "UPDATE carts set status='confirmed' WHERE id=$cart_id";
		$dbh = $this->connect();
		if($dbh->query($sql))
			return true;
		else
			return false;
	}

	function cartItems($cart_id){
		$sql = "SELECT * FROM cart_items where cart_id=".$cart_id;
		$dbh = $this->connect();
		if($result = $dbh->query($sql))
			return $result;
		else
			return false;
	}
 
}
?>