<?php
include_once __DIR__ . "\..\config\connection.php";
include_once __DIR__ . "\..\config\crud.php";

class Order extends connection implements crud
{

    private  $id;
    private  $order_number;
    private  $status;
    private  $price;
    private  $total_price;
    private  $delivre_date;
    private  $address_id;
    private  $coupons_id;
    private  $user_id;
    private  $created_at;
    private  $updated_at;


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
     * Get the value of order_number
     */
    public function getOrder_number()
    {
        return $this->order_number;
    }

    /**
     * Set the value of order_number
     *
     * @return  self
     */
    public function setOrder_number($order_number)
    {
        $this->order_number = $order_number;

        return $this;
    }

    /**
     * Get the value of status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set the value of status
     *
     * @return  self
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get the value of price
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set the value of price
     *
     * @return  self
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get the value of total_price
     */
    public function gettotal_price()
    {
        return $this->total_price;
    }

    /**
     * Set the value of total_price
     *
     * @return  self
     */
    public function settotal_price($total_price)
    {
        $this->total_price = $total_price;

        return $this;
    }

    /**
     * Get the value of delivre_date
     */
    public function getDelivre_date()
    {
        return $this->delivre_date;
    }

    /**
     * Set the value of delivre_date
     *
     * @return  self
     */
    public function setDelivre_date($delivre_date)
    {
        $this->delivre_date = $delivre_date;

        return $this;
    }

    /**
     * Get the value of address_id
     */
    public function getAddress_id()
    {
        return $this->address_id;
    }

    /**
     * Set the value of address_id
     *
     * @return  self
     */
    public function setAddress_id($address_id)
    {
        $this->address_id = $address_id;

        return $this;
    }

    /**
     * Get the value of coupons_id
     */
    public function getCoupons_id()
    {
        return $this->coupons_id;
    }

    /**
     * Set the value of coupons_id
     *
     * @return  self
     */
    public function setCoupons_id($coupons_id)
    {
        $this->coupons_id = $coupons_id;

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
     * Get the value of created_at
     */
    public function getCreated_at()
    {
        return $this->created_at;
    }

    /**
     * Set the value of created_at
     *
     * @return  self
     */
    public function setCreated_at($created_at)
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * Get the value of updated_at
     */
    public function getUpdated_at()
    {
        return $this->updated_at;
    }

    /**
     * Set the value of updated_at
     *
     * @return  self
     */
    public function setUpdated_at($updated_at)
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function create()
    {
        $query = "INSERT INTO `order`(`order_number`,`status`,`price`,`total_price`,`delivre_date`,`address_id`,`user_id`) VALUES($this->order_number,$this->status,$this->price,$this->total_price,'$this->delivre_date',$this->address_id,$this->user_id)";
        return $this->runDML($query);
    }
    public function read()
    {
        $query = "SELECT * FROM `order` WHERE `address_id` = $this->address_id AND `status` = $this->status AND `user_id` =$this->user_id";
        return $this->runDQL($query);
    }
    public function update()
    {
    }
    public function delete()
    {
        $query = "DELETE FROM `order` WHERE `address_id` = $this->address_id AND `user_id` = $this->user_id ";
        return $this->runDML($query);
    }
    public function getOrderNum()
    {
        $query = "SELECT `id`,`order_number`,`updated_at` FROM `order` ORDER BY `updated_at` DESC LIMIT 1";
        return $this->runDQL($query);
    }

    
}