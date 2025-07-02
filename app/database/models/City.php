<?php
include_once __DIR__ . "\..\config\connection.php";
include_once __DIR__ . "\..\config\crud.php";

class City extends connection implements crud
{

    private $id;
    private $name_en;
    private $name_ar;
    private $shipping_fees;
    private $status;
    private $country;
    private $created_at;
    private $updated_at;


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
     * Get the value of name_en
     */
    public function getName_en()
    {
        return $this->name_en;
    }

    /**
     * Set the value of name_en
     *
     * @return  self
     */
    public function setName_en($name_en)
    {
        $this->name_en = $name_en;

        return $this;
    }

    /**
     * Get the value of name_ar
     */
    public function getName_ar()
    {
        return $this->name_ar;
    }

    /**
     * Set the value of name_ar
     *
     * @return  self
     */
    public function setName_ar($name_ar)
    {
        $this->name_ar = $name_ar;

        return $this;
    }
    
    /**
     * Get the value of shipping_fees
     */ 
    public function getShipping_fees()
    {
        return $this->shipping_fees;
    }

    /**
     * Set the value of shipping_fees
     *
     * @return  self
     */ 
    public function setShipping_fees($shipping_fees)
    {
        $this->shipping_fees = $shipping_fees;

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
     * Get the value of country
     */ 
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set the value of country
     *
     * @return  self
     */ 
    public function setCountry($country)
    {
        $this->country = $country;

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
    }
    public function read()
    {
        $query = "SELECT * FROM `city` WHERE `status` = $this->status";
        return $this->runDQL($query);
    }
    public function update()
    {
    }
    public function delete()
    {
    }
    
    public function readCity()
    {
        $query = "SELECT `country`.`name_en`AS `country_name_en`,`country`.`name_ar`AS `country_name_ar`,`city`.* FROM `city` JOIN `country` ON `city`.`country_id` = `country`.`id`";
        return $this->runDQL($query);
    }

   

    
}