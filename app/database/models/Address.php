<?php
include_once __DIR__ . "\..\config\connection.php";
include_once __DIR__ . "\..\config\crud.php";

class Address extends connection implements crud
{

    private $id;
    private $address;
    private $street;
    private $building;
    private $floor;
    private $flat;
    private $notes;
    private $user_id;
    private $regions_id;
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
     * Get the value of address
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set the value of address
     *
     * @return  self
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get the value of street
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Set the value of street
     *
     * @return  self
     */
    public function setStreet($street)
    {
        $this->street = $street;

        return $this;
    }

    /**
     * Get the value of building
     */
    public function getBuilding()
    {
        return $this->building;
    }

    /**
     * Set the value of building
     *
     * @return  self
     */
    public function setBuilding($building)
    {
        $this->building = $building;

        return $this;
    }

    /**
     * Get the value of floor
     */
    public function getFloor()
    {
        return $this->floor;
    }

    /**
     * Set the value of floor
     *
     * @return  self
     */
    public function setFloor($floor)
    {
        $this->floor = $floor;

        return $this;
    }

    /**
     * Get the value of flat
     */
    public function getFlat()
    {
        return $this->flat;
    }

    /**
     * Set the value of flat
     *
     * @return  self
     */
    public function setFlat($flat)
    {
        $this->flat = $flat;

        return $this;
    }

    /**
     * Get the value of notes
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * Set the value of notes
     *
     * @return  self
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;

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
     * Get the value of regions_id
     */
    public function getRegions_id()
    {
        return $this->regions_id;
    }

    /**
     * Set the value of regions_id
     *
     * @return  self
     */
    public function setRegions_id($regions_id)
    {
        $this->regions_id = $regions_id;

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
        if (empty($this->notes)) {
            $notes = 'NULL';
        }else{
            $notes = $this->notes;
        }
        $query = "INSERT INTO `address`(`address`,`street`,`building`,`floor`,`flat`,`notes`,`user_id`,`regions_id`) VALUES('$this->address','$this->street','$this->building','$this->floor','$this->flat','$notes',$this->user_id,$this->regions_id)";
        return $this->runDML($query);
    }
    public function read()
    {
        $query ="SELECT `address`.*,`regions`.`name_en` AS `regoin_name_en` FROM `address` JOIN `regions` ON `regions`.`id` = `address`.`regions_id` WHERE `user_id` = $this->user_id";
        return $this->runDQL($query);
    }
    public function update()
    {
        $query="UPDATE `address` SET`address` = '$this->address',`street` = '$this->street',`building` = '$this->building',`floor` = '$this->floor',`flat` = '$this->flat',`notes` = '$this->notes',`user_id` = $this->user_id,`regions_id` = $this->regions_id WHERE `id` = $this->id";
        return $this->runDML($query);
    }
    public function delete()
    {
    }
}