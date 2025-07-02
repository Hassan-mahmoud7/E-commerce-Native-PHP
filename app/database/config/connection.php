<?php
class connection {
   private $hostname = 'localhost';
   private $username = 'root';
   private $password = '';
   private $database = 'ecommerce';
   private $con;

    public function __construct()
    {
        $this->con = new mysqli($this->hostname,$this->username,$this->password,$this->database);
        // if ($const->connect_error) {
        //     die("Connection failed: " . $const->connect_error );
        // }
        // echo "connected successfully";
        
    }
    // insert - Update - Delete   (true / false)
    protected function runDML($query)
     {
        $result = $this->con->query($query);
        if ($result) {
            return true ;
        }else{
            return false ;
        }
       
    }
    // select (null / full)
    protected function runDQL($query)
    {
        $result = $this->con->query($query);
        if ($result->num_rows > 0) {
            return $result ;
        }else{
            return [];
        }
      
    }

}
// $x = new connection ;