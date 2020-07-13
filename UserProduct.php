<?php
  require_once(__ROOT__ . "Model/Model.php");
?>

<?php
class UserProduct extends Model 
{
    public $no_prod;

    function __construct()
    {
        $sql = "SELECT * FROM products";
        $dbh = $this->connect();
        $result = $dbh->query($sql);
        $this->no_prod = $result->num_rows;
    }
    
    public function insertRecord($user_id)
  {
    $sql = "INSERT INTO user_products(user_id,no_products) values($user_id,$this->no_prod)";
    $dbh = $this->connect();
    if($dbh->query($sql))
        return true;
    else
        return false;
    
  }

  public function updateRecord($user_id)
  {
    $sql = "UPDATE user_products SET no_products=$this->no_prod WHERE user_id=$user_id";
    $dbh = $this->connect();
    if($dbh->query($sql))
        return true;
    else
        return false;
    
  }

  public function getUpdate($user_id)
  {
      $sql = "SELECT * FROM user_products WHERE user_id=$user_id LIMIT 1";
      $dbh = $this->connect();
      $result = $dbh->query($sql);
      if($result->num_rows == 0) {
        $this->insertRecord($user_id);
        return 0;

      }
      else {
          $this->updateRecord($user_id);
        return $this->no_prod - $dbh->fetchRow()['no_products'];
      }
  }
	 
}