 <?php

  $title = "Set New Password";
  include_once 'layout/header.php';
  include_once 'app/requests/registerRequest.php';
  include_once 'app/database/models/User.php';


  if ($_POST) {
    $validat = new registerRequest;
    $validat->setPassword($_POST['password']);
    $validat->setConfirmPassword($_POST['confirm_password']);
    $passwordValidationResult = $validat->passwordValidation();
    if (empty($passwordValidationResult)) {
      $userObject = new User;
      $userObject->setPassword($_POST['password']);
      $userObject->setEmail($_SESSION['checkcode-email']);
      $result = $userObject->updatePassword();
      if ($result) {
        header('location:login.php');
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
                         <a class="active" data-toggle="tab" href="#lg1">
                             <h4><?= $title; ?></h4>
                         </a>
                     </div>
                     <div class="tab-content">
                         <div id="lg1" class="tab-pane active">
                             <div class="login-form-container">
                                 <div class="login-register-form">
                                     <?php
                                      if (isset($result) && !$result) {
                                        echo "<div class='alert alert-danger'> Try Agian later </div>";
                                      } ?>
                                     <form method="post">
                                         <input type="password" name="password" placeholder="Password" value="<?=isset($_POST['password'])?$_POST['password']:'';?>" />
                                         <?php
                                          if (isset($passwordValidationResult['password_required'])) {
                                            echo $passwordValidationResult['password_required'];
                                          }
                                          if (isset($passwordValidationResult['password_pattern'])) {
                                            echo $passwordValidationResult['password_pattern'];
                                          }
                                          ?>
                                         <input type="password" name="confirm_password"
                                             placeholder="Confirm Password" />
                                         <?php
                                          if (isset($passwordValidationResult['confirmPassword_required'])) {
                                            echo $passwordValidationResult['confirmPassword_required'];
                                          }
                                          if (isset($passwordValidationResult['password_notmatched'])) {
                                            echo $passwordValidationResult['password_notmatched'];
                                          }
                                          ?>
                                         <button type="submit" class="btn btn-success"><span>Update</span></button>
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

  include_once 'layout/scripts.php';
  ?>