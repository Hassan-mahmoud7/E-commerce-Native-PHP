<?php

class loginRequest {

    private $password;
    

    /**
     * Get the value of password
     */ 
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */ 
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    public function passwordValidation()
    {
        $errors = [];
        $pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,20}$/';
        // password required
        if (empty($this->password)) {
            $errors['password_required'] = "<div class='alert alert-danger'> password Is Required </div>";
        }
        if (empty($errors)) {
            if (!preg_match($pattern, $this->password)) {
                $errors['password_pattern'] = "<div class='alert alert-danger'> Faild Attempt </div>";
            }
        }
        return $errors;
    }
}