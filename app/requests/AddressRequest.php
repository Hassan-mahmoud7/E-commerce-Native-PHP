<?php

class AddressRequest
{

    private $address;
    private $country;
    private $city;
    private $region;
    private $floor;
    private $flat;
    private $street;
    private $building;


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
     * Get the value of city
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set the value of city
     *
     * @return  self
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }


    /**
     * Get the value of region
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * Set the value of region
     *
     * @return  self
     */
    public function setRegion($region)
    {
        $this->region = $region;

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



    public function addressValidation()
    {
        $error = '';
        if (empty($this->address)) {
            $error = "<div class='alert alert-danger'>Address Is Required</div>";
        }
        return $error;
    }
    public function countryValidation()
    {
        $error = '';
        if (empty($this->country)) {
            $error = "<div class='alert alert-danger'>Country Is Required</div>";
        }

        return $error;
    }
    public function cityValidation()
    {
        $error = '';
        if (empty($this->city)) {
            $error = "<div class='alert alert-danger'>City Is Required</div>";
        }
        return $error;
    }
    public function regionValidation()
    {
        $error = '';
        if (empty($this->region)) {
            $error = "<div class='alert alert-danger'>Region Is Required</div>";
        }

        return $error;
    }
    public function floorValidation()
    {
        $error = '';
        if (empty($this->floor)) {
            $error = "<div class='alert alert-danger'>Floor Is Required</div>";
        }

        return $error;
    }
    public function flatValidation()
    {
        $error = '';
        if (empty($this->flat)) {
            $error = "<div class='alert alert-danger'>Flat Is Required</div>";
        }

        return $error;
    }
    public function streetValidation()
    {
        $error = '';
        if (empty($this->street)) {
            $error = "<div class='alert alert-danger'>Street Is Required</div>";
        }

        return $error;
    }
    public function buildingValidation()
    {
        $error = '';
        if (empty($this->building)) {
            $error = "<div class='alert alert-danger'>Building Is Required</div>";
        }

        return $error;
    }
}