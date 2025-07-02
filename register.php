 <?php
    $title = "Register";
    include_once 'layout/header.php';
    include_once 'app/middleware/guest.php'; 
    include_once 'layout/nav.php';
    include_once 'layout/breadcrumb.php';
    include_once 'app/requests/registerRequest.php';
    include_once 'app/database/models/User.php';
    include_once "app/mail/mail.php";
    if ($_POST) {
        //email
        $validation = new registerRequest;
        $validation->setEmail($_POST['email']);
        $emailValidationResult = $validation->emailValidation();
        $emailExistsResult = $validation->checkIfEmailExists();
        //password
        $validation->setPassword($_POST['password']);
        $validation->setConfirmPassword($_POST['confirm_password']);
        $passwordValidationResult = $validation->passwordValidation();
        $ConfirmPasswordValidationResult = $validation->confirmPasswordValidation();
        //phone
         $validation->setPhone($_POST['phone']);
        $phoneExistsResult = $validation->checkIfPhoneExists();
        $phoneRequired = $validation->requiredphone();
         //first name
         $validation->setFirst_name($_POST['first-name']);
         $first_nameValidationResult = $validation->validatFirstname();
         //last name
         $validation->setLast_name($_POST['last-name']);
         $last_nameValidationResult = $validation->validatLastname();

        if (empty($emailValidationResult) && empty($passwordValidationResult) && empty($emailExistsResult) 
        && empty($phoneExistsResult) && empty($first_nameValidationResult) && empty($last_nameValidationResult)
         && empty($phoneRequired) && empty($ConfirmPasswordValidationResult)) {
            $code = rand(10000,99999);
        $userObject = new User;
        $userObject->setFirst_name($_POST['first-name']);
        $userObject->setLast_name($_POST['last-name']);
        $userObject->setEmail($_POST['email']);
        $userObject->setPhone($_POST['phone']);
        $userObject->setPassword($_POST['password']);
        $userObject->setGender($_POST['gender']);
        $userObject->setCode($code);
        $result = $userObject->create();
        if ($result) {
            // $subject = "Ecommerce-verification-code";
            // $body = "<P> Hello {$_POST['first-name']}</p> <p>Your Varification code is:<b style='color:blue;'>$code</b> thank you</p>";
            // $mail = new mail($_POST['email'],$subject,$body);
            // $mailResult = $mail->send();
            // if ($mailResult) {
                $_SESSION['checkcode-email'] = $_POST['email'];
                header('location:check-code.php?page=register');die;
            // }
        }
    }
}




    ?>
 <div class="login-register-area ptb-100">
     <div class="container">
         <div class="row">
             <div class="col-lg-7 col-md-12 ml-auto mr-auto">
                 <div class="login-register-wrapper">
                     <div class="login-register-tab-list nav">
                         <a class="active" data-toggle="tab" href="#lg2">
                             <h4>register</h4>
                         </a>
                     </div>
                     <div class="tab-content">
                         <div id="lg2" class="tab-pane active">
                             <div class="login-form-container">
                                 <div class="login-register-form">
                                    <?php
                                    if (isset($result) && !$result) {
                                        echo "<div class='alert alert-danger'> Try Agian later </div>";
                                    }
                                    // if (isset($mailResult) && ! $mailResult) {
                                    //     echo "<div class='alert alert-danger'> Something Went Wrong </div>";
                                    // }
                                    ?>
                                     <form action="#" method="post">
                                         <input type="text" name="first-name" placeholder="First name" value="<?=isset($_POST['first-name'])?$_POST['first-name']:'';?>"/>
                                         <?php
                                         if (isset($first_nameValidationResult['first_name_required'])) {
                                            echo  $first_nameValidationResult['first_name_required'] ;
                                        }
                                         ?>
                                         <input type="text" name="last-name" placeholder="Last name" value="<?=isset($_POST['last-name'])?$_POST['last-name']:'';?>"/>
                                         <?php
                                           if (isset($last_nameValidationResult['last_name_required'])) {
                                             echo  $last_nameValidationResult['last_name_required'] ; }
                                         ?>
                                         <input name="email" placeholder="Email" type="email" value="<?=isset($_POST['email'])?$_POST['email']:'';?>" />
                                         <?php
                                            if (!empty($emailValidationResult)) {
                                                foreach ($emailValidationResult as $index => $errors) {
                                                    echo $errors;
                                                }
                                            }
                                            if (!empty($emailExistsResult)) {
                                                foreach ($emailExistsResult as $index => $errors) {
                                                    echo $errors;
                                                }
                                            }
                                            ?>
                                         <input type="tel" name="phone" placeholder="Phone" value="<?=isset($_POST['phone'])?$_POST['phone']:'';?>"/>
                                         <?php
                                             if (!empty($phoneExistsResult)) {
                                                foreach ($phoneExistsResult as $index => $errors) {
                                                    echo $errors;
                                                }
                                            }
                                            if (isset($phoneRequired['phone_required'])) {
                                            echo  $phoneRequired['phone_required'] ; 
                                            }
                                         ?>
                                         <input type="password" name="password" placeholder="Password" value="<?=isset($_POST['password'])?$_POST['password']:'';?>"/>
                                         <?php
                                         if (isset( $passwordValidationResult['password_required'])) {
                                            echo $passwordValidationResult['password_required'];
                                         }
                                         if (isset( $passwordValidationResult['password_pattern'])) {
                                            echo $passwordValidationResult['password_pattern'];
                                         }
                                         ?>
                                         <input type="password" name="confirm_password" placeholder="confirm Password" value="<?=isset($_POST['confirm_password'])?$_POST['confirm_password']:'';?>"/>
                                         <?php
                                         if (isset( $ConfirmPasswordValidationResult['confirmPassword_required'])) {
                                            echo $ConfirmPasswordValidationResult['confirmPassword_required'];
                                         }
                                         if (isset( $ConfirmPasswordValidationResult['password_notmatched'])) {
                                            echo $ConfirmPasswordValidationResult['password_notmatched'];
                                         }
                                         ?>
                                         <select name="gender" class="form-control mb-3">
                                                
                                             <option <?= (isset($_POST['gender']) && $_POST['gender'] == 'm') ? 'selected' : ''  ?> value="m">Male</option>
                                             <option <?= (isset($_POST['gender']) && $_POST['gender'] == 'f') ? 'selected' : ''  ?> value="f">Female</option> 
                                         </select>
                                         <div class="button-box mt-5">
                                             <button type="submit"><span>Register</span></button>
                                         </div>
                                     </form>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </div>

 <?php
    include_once 'layout/footer.php';
    include_once 'layout/scripts.php';

    ?>