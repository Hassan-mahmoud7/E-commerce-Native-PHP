 <?php

use LDAP\Result;

 $title = "Varify Email"; 
  include_once 'layout/header.php';
  include_once 'app/requests/registerRequest.php';
  include_once 'app/database/models/User.php';
  include_once 'app/mail/mail.php';


  if ($_POST) {
     //validation =>
     $validationEmail = new registerRequest;
     $validationEmail->setEmail($_POST['email']);
     $emailValidationResalt = $validationEmail->emailValidation();

     if (empty($emailValidationResalt)) {
      $userObject = new user;
      $userObject->setEmail($_POST['email']);
      $EmailExistsResult = $userObject->emailExists();
      if ($EmailExistsResult) {
       $user = $EmailExistsResult->fetch_object();
       $code = rand(10000,99999);
       $userObject->setCode($code);
       $result = $userObject->updateCode();
       if ($result) {
        //  $body = "<P> Hello {$user->first_name}</p> <p>Your Varification code is:<b style='color:blue;'>$code</b> thank you</p>";
        //  $mail = new mail($_POST['email'],'Forget Password',$body);
        //  $mailResult = $mail->send();
        //  if ($mailResult) {
             $_SESSION['checkcode-email'] = $user->email;
             header('location:check-code.php?page=varify-email');die;
        //  }
       }
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
               <h4><?= $title;?></h4>
             </a>
           </div>
           <div class="tab-content">
             <div id="lg1" class="tab-pane active">
               <div class="login-form-container">
                 <div class="login-register-form">
                   <form  method="post">
                     <input type="Email" name="email" placeholder="email" />
                     <?php
                     if (!empty($emailValidationResalt)) {
                      foreach ($emailValidationResalt as $key => $error) {
                       echo $error;
                      }
                     }
                     if (isset($EmailExistsResult) && empty($EmailExistsResult)) {
                      echo "<div class='alert alert-danger'> Email Dosen't Match Our Records </div>";
                     }
                     
                     ?>
                       <button type="submit" class="btn btn-success"><span>Check</span></button>
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