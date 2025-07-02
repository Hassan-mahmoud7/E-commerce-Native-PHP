<?php
include_once __DIR__."\..\config\connection.php";
include_once __DIR__."\..\config\crud.php";

class Product_order extends connection implements crud {
    
    private $order_id;
    private $product_id;
    private $price_after_order;
    private $pro_name_en;
    private $pro_desc_en;
    private $pro_image;
    private $pro_price;
    private $count_product;
    

/**
     * Get the value of order_id
     */ 
    public function getOrder_id()
    {
        return $this->order_id;
    }

    /**
     * Set the value of order_id
     *
     * @return  self
     */ 
    public function setOrder_id($order_id)
    {
        $this->order_id = $order_id;

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
     * Get the value of price_after_order
     */ 
    public function getPrice_after_order()
    {
        return $this->price_after_order;
    }

    /**
     * Set the value of price_after_order
     *
     * @return  self
     */ 
    public function setPrice_after_order($price_after_order)
    {
        $this->price_after_order = $price_after_order;

        return $this;
    }

    /**
     * Get the value of pro_name_en
     */ 
    public function getPro_name_en()
    {
        return $this->pro_name_en;
    }

    /**
     * Set the value of pro_name_en
     *
     * @return  self
     */ 
    public function setPro_name_en($pro_name_en)
    {
        $this->pro_name_en = $pro_name_en;

        return $this;
    }

    /**
     * Get the value of pro_desc_en
     */ 
    public function getPro_desc_en()
    {
        return $this->pro_desc_en;
    }

    /**
     * Set the value of pro_desc_en
     *
     * @return  self
     */ 
    public function setPro_desc_en($pro_desc_en)
    {
        $this->pro_desc_en = $pro_desc_en;

        return $this;
    }

    /**
     * Get the value of pro_image
     */ 
    public function getPro_image()
    {
        return $this->pro_image;
    }

    /**
     * Set the value of pro_image
     *
     * @return  self
     */ 
    public function setPro_image($pro_image)
    {
        $this->pro_image = $pro_image;

        return $this;
    }

    /**
     * Get the value of pro_price
     */ 
    public function getPro_price()
    {
        return $this->pro_price;
    }

    /**
     * Set the value of pro_price
     *
     * @return  self
     */ 
    public function setPro_price($pro_price)
    {
        $this->pro_price = $pro_price;

        return $this;
    }

    /**
     * Get the value of count_product
     */ 
    public function getCount_product()
    {
        return $this->count_product;
    }

    /**
     * Set the value of count_product
     *
     * @return  self
     */ 
    public function setCount_product($count_product)
    {
        $this->count_product = $count_product;

        return $this;
    }

    public function create()
    {
    
    }
    public function read()
    {
        
    }
    public function update()
    {
    
    }public function delete()
    {
    
    }
    public function getMostOrderProducts()
    {
        $query ="SELECT `pro_name_en`,`pro_desc_en`,`pro_image`,`pro_price`,`count_product`,`product_id` FROM `most_order` ORDER BY `count_product` DESC LIMIT 4";
        return $this->runDQL($query);
    }


    
}