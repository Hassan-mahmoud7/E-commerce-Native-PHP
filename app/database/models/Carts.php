<?php
include_once __DIR__ . "\..\config\connection.php";
include_once __DIR__ . "\..\config\crud.php";

class Carts extends connection implements crud
{

    private $id;
    private $product_id;
    private $user_id;
    private $quantity;


    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }
    /**
     * Get the value of product_id
     */
    public function getProduct_id()
    {
        return $this->product_id;
    }

    /**
     * Set the value of product_id
     *
     * @return  self
     */
    public function setProduct_id($product_id)
    {
        $this->product_id = $product_id;

        return $this;
    }

    /**
     * Get the value of user_id
     */
    public function getUser_id()
    {
        return $this->user_id;
    }

    /**
     * Set the value of user_id
     *
     * @return  self
     */
    public function setUser_id($user_id)
    {
        $this->user_id = $user_id;

        return $this;
    }

    /**
     * Get the value of qua ntity
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set the value of quantity
     *
     * @return  self
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }


    public function create()
    {
        $query = "INSERT INTO `carts`(`product_id`,`user_id`,`quantity`) VALUES($this->product_id,$this->user_id,$this->quantity)";
        return $this->runDML($query);
    }
    public function read()
    {
    }
    public function update()
    {
        $query = "UPDATE `carts` SET `quantity` = $this->quantity WHERE `id` = $this->id ";
        return $this->runDML($query);
    }
    public function delete()
    {
        $query = "DELETE FROM `carts` WHERE `user_id` = $this->user_id ";
        return $this->runDML($query);
    }
    public function getProductInCart()
    {
        $query = "SELECT `products`.*,`carts`.`quantity` AS `cart-quantity`,`carts`.`id` AS `cart_id`  FROM `carts` JOIN `products` ON `products`.`id` = `carts`.`product_id` WHERE `user_id` = $this->user_id";
        return $this->runDQL($query);
    }
    public function getEditProductInCart()
    {
        $query = "SELECT `products`.*,`carts`.`quantity` AS `cart_quantity`,`carts`.`id` AS `cart_id`,`carts`.`user_id` FROM `carts` JOIN `products` ON `products`.`id` = `carts`.`product_id` WHERE `carts`.`id` = $this->id AND `user_id` = $this->user_id";
        return $this->runDQL($query);
    }
    public function destroy()
    {
        $query = "DELETE FROM `carts` WHERE `id` = $this->id";
        return $this->runDML($query);
    }
    public function checkId(){
        $query = "SELECT * FROM `carts` WHERE `user_id` = $this->user_id";
        return $this->runDQL($query);
    }
}