<?php
include_once __DIR__ . "\..\config\connection.php";
include_once __DIR__ . "\..\config\crud.php";

class Product extends connection implements crud
{


    private $id;
    private $name_en;
    private $name_ar;
    private $desc_en;
    private $desc_ar;
    private $status;
    private $image;
    private $price;
    private $quantity;
    private $subcategory_id;
    private $category_id;
    private $brand_id;
    private $created_at;
    private $updated_at;
    private $limit ;
    private $offset;



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
     * Get the value of image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set the value of image
     *
     * @return  self
     */
    public function setImage($image)
    {
        $this->image = $image;

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


    /**
     * Get the value of desc_en
     */
    public function getDesc_en()
    {
        return $this->desc_en;
    }

    /**
     * Set the value of desc_en
     *
     * @return  self
     */
    public function setDesc_en($desc_en)
    {
        $this->desc_en = $desc_en;

        return $this;
    }

    /**
     * Get the value of desc_ar
     */
    public function getDesc_ar()
    {
        return $this->desc_ar;
    }

    /**
     * Set the value of desc_ar
     *
     * @return  self
     */
    public function setDesc_ar($desc_ar)
    {
        $this->desc_ar = $desc_ar;

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
     * Get the value of quantity
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

    /**
     * Get the value of brand_id
     */
    public function getBrand_id()
    {
        return $this->brand_id;
    }

    /**
     * Set the value of brand_id
     *
     * @return  self
     */
    public function setBrand_id($brand_id)
    {
        $this->brand_id = $brand_id;

        return $this;
    }

    /**
     * Get the value of subcategory_id
     */
    public function getSubcategory_id()
    {
        return $this->subcategory_id;
    }

    /**
     * Set the value of subcategory_id
     *
     * @return  self
     */
    public function setSubcategory_id($subcategory_id)
    {
        $this->subcategory_id = $subcategory_id;

        return $this;
    }
    /**
     * Get the value of category_id
     */
    public function getCategory_id()
    {
        return $this->category_id;
    }

    /**
     * Set the value of category_id
     *
     * @return  self
     */
    public function setCategory_id($category_id)
    {
        $this->category_id = $category_id;

        return $this;
    }
    
    /**
     * Get the value of start
     */ 
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * Set the value of start
     *
     * @return  self
     */ 
    public function setLimit($limit)
    {
        $this->limit = $limit;

        return $this;
    }

    /**
     * Get the value of offset
     */ 
    public function getOffset()
    {
        return $this->offset;
    }

    /**
     * Set the value of offset
     *
     * @return  self
     */ 
    public function setOffset($offset)
    {
        $this->offset = $offset;

        return $this;
    }
    public function create()
    {
    }
    public function read()
    {
        $query = "SELECT `id`,`name_en`,`desc_en`,`price`,`image` FROM `products_details` WHERE `status` = $this->status ORDER BY `price`,`name_en` ";
        return $this->runDQL($query);
    }
    public function update()
    {
    }
    public function delete()
    {
    }
    public function readBySub()
    {
        $query = "SELECT `id`,`name_en`,`desc_en`,`price`,`image` FROM `products_details` WHERE `status` = $this->status AND `subcategory_id` = $this->subcategory_id ORDER BY `price`,`name_en` LIMIT $this->limit OFFSET $this->offset ";
        return $this->runDQL($query);
    }
    public function readBycat()
    {
        $query = "SELECT `id`,`name_en`,`desc_en`,`price`,`image` FROM `products_details` WHERE `status` = $this->status AND `category_id` = $this->category_id ORDER BY `price`,`name_en` LIMIT $this->limit OFFSET $this->offset";
        return $this->runDQL($query);
    }
    public function readByIdBrand()
    {
        $query = "SELECT `id`,`name_en`,`desc_en`,`price`,`image` FROM `products_details` WHERE `status` = $this->status AND `brand_id` = $this->brand_id ORDER BY `price`,`name_en` LIMIT $this->limit OFFSET $this->offset";
        return $this->runDQL($query);
    }
    public function readByid()
    {
        $query = "SELECT * FROM `products_details` WHERE `status` = $this->status AND `id` = $this->id ";
        return $this->runDQL($query);
    }
    public function getReviews()
    {
        $query = "SELECT * FROM `users_reviews` WHERE `products_id` = $this->id";
        return $this->runDQL($query);
    }
    public function getNewproducts()
    {
        $query = "SELECT `id`,`name_en`,`desc_en`,`price`,`image` FROM `products_details` WHERE `status` = $this->status ORDER BY `created_at` DESC LIMIT 4 ";
        return $this->runDQL($query);
    }
    public function RelatedProducts()
    {
        $query = "SELECT * FROM `products_details` WHERE `status` = $this->status AND `subcategory_id` = $this->subcategory_id LIMIT 4";
        return $this->runDQL($query);
    }
    public function UpdateQuantity()
    {
        $query = "UPDATE `products` SET `quantity` = $this->quantity  WHERE `id` = $this->id";
        return $this->runDML($query);
    }
    public function getQntiyProduct()
    {
        $query = "SELECT `id`,`name_en`,`desc_en`,`price`,`image`,`quantity` FROM `products` WHERE `id` = $this->id";
        return $this->runDQL($query);
    }
    public function search(){
        $query = "SELECT * FROM `products` WHERE `name_en` LIKE '$this->name_en%' ORDER BY `price`,`name_en` LIMIT $this->limit OFFSET $this->offset " ;
        return $this->runDQL($query);
    }
    public function updateMultiple(array $id)
    {

        $newQtys =  explode(',', $this->quantity);
        $newQty = '';
        foreach ($newQtys as $key => $value) {
            $newQty .= $value;
        }
        $allId = implode(",", $id);
        $query = "UPDATE `products` SET `quantity` = CASE `id`
        $newQty
          ELSE `quantity` END WHERE `id` IN($allId)";
        return $this->runDML($query);
    }
    public function getProMultipleQty(array $ids)
    {

        $allId = '';
        $allId .= implode(",", $ids);
        $query = "SELECT `id`,`quantity`,`name_en` FROM `products` WHERE `id` IN($allId)";
        return $this->runDQL($query);
    }
    public function maxPriceAndMinPrice(){
       $value = "";
        if (isset($this->brand_id)) {
            $value = " WHERE `brand_id` = $this->brand_id";
        }elseif(isset($this->subcategory_id)){
            $value = " WHERE `subcategory_id` = $this->subcategory_id";
        }elseif(isset($this->category_id)){
            $value = " WHERE `category_id` = $this->category_id";
        }elseif(isset($this->name_en)){
            $value = " WHERE `name_en` LIKE '$this->name_en%' ORDER BY `price`,`name_en`";
        }else {
            $value = "";
        }
        $query = "SELECT COUNT(`id`) AS `total`, MAX(`price`) AS `max_price`, MIN(`price`) AS `min_price` FROM `products_details` $value ";
        return $this->runDQL($query) ;
    }
    public function searchRange($minPrice ,$maxPrice){
       $query = "SELECT `id`,`name_en`,`desc_en`,`price`,`image` FROM `products` WHERE `name_en` LIKE '$this->name_en%' AND `price` BETWEEN $minPrice AND $maxPrice " ;
       return $this->runDQL($query);
    }
    // public function pagination($limit ,$offset) {
    //     $query ="SELECT * FROM `products_details` WHERE `id` AND `status` = '1' LIMIT $limit OFFSET $offset";
    //     return $this->runDQL($query);
    // }
    public function searchRangeByGet($minPrice ,$maxPrice ){
        $unknowGet = "";
        
        if (isset($this->brand_id)) {
            $unknowGet = "`brand_id` = $this->brand_id AND";
        }elseif (isset($this->subcategory_id)) {
            $unknowGet = "`subcategory_id` = $this->subcategory_id AND";
        }elseif (isset($this->category_id)) {
            $unknowGet = "`category_id` = $this->category_id AND";
        }elseif (isset($this->name_en)) {
            $unknowGet = " `name_en` LIKE '$this->name_en%'AND";
        }else{
            $unknowGet = "";
        }
       $query = "SELECT `id`,`name_en`,`desc_en`,`price`,`image` FROM `products_details` WHERE $unknowGet `price` BETWEEN $minPrice AND $maxPrice  ORDER BY `price`,`name_en` LIMIT $this->limit OFFSET $this->offset " ;
      return $this->runDQL($query);
    }
        
    public function countProducts($minPrice ,$maxPrice)
    {
        $unknowGet = "";
        
        if (isset($this->brand_id)) {
            $unknowGet = "AND `brand_id` = $this->brand_id AND `price` BETWEEN $minPrice AND $maxPrice";
        }elseif (isset($this->subcategory_id)) {
            $unknowGet = "AND `subcategory_id` = $this->subcategory_id AND `price` BETWEEN $minPrice AND $maxPrice";
        }elseif (isset($this->category_id)) {
            $unknowGet = "AND `category_id` = $this->category_id AND `price` BETWEEN $minPrice AND $maxPrice";
        }elseif (isset($this->name_en)) {
            $unknowGet = "AND `name_en` LIKE '$this->name_en%' BETWEEN $minPrice AND $maxPrice";
        }else{
            $unknowGet = "AND `price` BETWEEN $minPrice AND $maxPrice";
        }
        $query = "SELECT COUNT(*) as `total` FROM `products_details` WHERE `status` = $this->status $unknowGet";
        $result = $this->runDQL($query);
        $row = $result->fetch_assoc();
        return $row['total'];
    }
    public function readPagination($limit, $offset)
    {
        $query = "SELECT `id`,`name_en`,`desc_en`,`price`,`image` FROM `products_details` WHERE `status` = $this->status ORDER BY `price`,`name_en` LIMIT $limit OFFSET $offset";
        return $this->runDQL($query);
    }

    

}
