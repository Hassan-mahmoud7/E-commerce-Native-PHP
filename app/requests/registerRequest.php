<?php
include_once __DIR__."\..\database\models\User.php";
class registerRequest
{
    private $password;
    private $confirmPassword;
    private $oldPassword;
    private $email;
    private $phone;
    private $first_name;
    private $last_name;
    private $gender;
  


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

    /**
     * Get the value of email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of phone
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set the value of phone
     *
     * @return  self
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }
    /**
     * Get the value of confirmPassword
     */
    public function getConfirmPassword()
    {
        return $this->confirmPassword;
    }

    /**
     * Set the value of confirmPassword
     *
     * @return  self
     */
    public function setConfirmPassword($confirmPassword)
    {
        $this->confirmPassword = $confirmPassword;

        return $this;
    }
    
    /**
     * Get the value of oldPassword
     */ 
    public function getOldPassword()
    {
        return $this->oldPassword;
    }

    /**
     * Set the value of oldPassword
     *
     * @return  self
     */ 
    public function setOldPassword($oldPassword)
    {
        $this->oldPassword = $oldPassword;

        return $this;
    }
     /**
     * Get the value of first_name
     */ 
    public function getFirst_name()
    {
        return $this->first_name;
    }

    /**
     * Set the value of first_name
     *
     * @return  self
     */ 
    public function setFirst_name($first_name)
    {
        $this->first_name = $first_name;

        return $this;
    }

    /**
     * Get the value of last_name
     */ 
    public function getLast_name()
    {
        return $this->last_name;
    }

    /**
     * Set the value of last_name
     *
     * @return  self
     */ 
    public function setLast_name($last_name)
    {
        $this->last_name = $last_name;

        return $this;
    }
    
    /**
     * Get the value of gender
     */ 
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set the value of gender
     *
     * @return  self
     */ 
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    public function emailValidation()
    {
        //required
        $errors = [];
        if (empty($this->email)) {
            $errors['email_required'] = "<div class='alert alert-danger'> Email Is Required </div>";
        } else {
            $pattern = '/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/';
            // preg_match($email,$pattern);     #  (true , false) ($v1 = $v2) جهزها بتتآكد ان paltin function دى
            if (!preg_match($pattern, $this->email)) {
                $errors['email_pattern'] = "<div class='alert alert-danger'> Email Is Invalid </div>";
            }
        }
        return $errors;
    }
    public function passwordValidation()
    {
        $errors = [];
        $pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,20}$/';
        // password required
        if (empty($this->password)) {
            $errors['password_required'] = "<div class='alert alert-danger'> password Is Required </div>";
        }
       
            // pattern
            if (empty($errors)) {
                if (!preg_match($pattern, $this->password)) {
                    $errors['password_pattern'] = "<div class='alert alert-danger'>Minimum eight and maximum 20 characters, at least one uppercase letter, one lowercase letter, one number and one special character: </div>";
                }
            }
       
        return $errors;
    }
    public function oldPasswordValidation()
    {
        $errors = [];
        $pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,20}$/';
        // password required
        if (empty($this->oldPassword)) {
            $errors['old_password_required'] = "<div class='alert alert-danger'> Old Password Is Required </div>";
            // pattern
        }
        if (empty($errors)) {
            if (!preg_match($pattern, $this->oldPassword)) {
             $errors['old_password_pattern'] = "<div class='alert alert-danger'>Minimum eight and maximum 20 characters, at least one uppercase letter, one lowercase letter, one number and one special character: </div>";
            }
        
        }
       
       
        return $errors;
    }
    public function confirmPasswordValidation()
    {
        $errors = [];
         // confirm password required
         if (empty($this->confirmPassword)) {
            $errors['confirmPassword_required'] = "<div class='alert alert-danger'> Confirm Password Is Required </div>";
        }
        if (empty($errors)) {
            // password = confirm || matched
            if ($this->password != $this->confirmPassword) {
                $errors['password_notmatched'] = "<div class='alert alert-danger'> Password Not Matched </div>";
            }
        }
        return $errors;
    }
    public function checkIfEmailExists()
    {
        $erorrs = [];
        $userObject = new User;
        $userObject->setEmail($this->email);
        $result = $userObject->emailExists();
        if ($result) {
            $erorrs['email_alreadyExists'] = "<div class='alert alert-danger'> Email Already Exists </div>";
        }
        
        return $erorrs;


    }
    public function checkIfPhoneExists()
    {
        $erorrs = [];
        $userObject = new User;
        $userObject->setPhone($this->phone);
        $result = $userObject->phoneExists();
        if ($result) {
            $erorrs['phone_alreadyExists'] = "<div class='alert alert-danger'> Phone Already Exists </div>";
        }
        return $erorrs ;
       
    }
    public function validatFirstname()
    {
        $errors = [];
        if (empty($this->first_name)) {
            $errors['first_name_required'] = "<div class='alert alert-danger'> First Name Is Required </div>";

        }
        return $errors;
        
    }
    public function validatLastname()
    {
        $errors = [];
        if (empty($this->last_name)) {
            $errors['last_name_required'] = "<div class='alert alert-danger'> Last Name Is Required </div>";

        }
        return $errors;
        
    }
    public function requiredphone()
    {
        $errors = [];
        if (empty($this->phone)) {
            $errors['phone_required'] = "<div class='alert alert-danger'> Phone Is Required </div>";

        }
        return $errors;
        
    }
    public function requiredGender()
    {
        $errors = [];
        if (empty($this->gender)) {
            $errors['gender_required'] = "<div class='alert alert-danger'> Gender Is Required </div>";

        }
        return $errors;
        
    }

   


}