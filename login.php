 <?php
  $title = "Login";
  include_once 'layout/header.php';
  include_once 'app/middleware/guest.php';
  include_once 'layout/nav.php';
  include_once 'layout/breadcrumb.php'; 
  spl_autoload_register(function ($class) {
    include_once 'app/requests/' . $class . '.php';
  });
  include_once 'app/database/models/user.php';
  // include_once __DIR__."app\database\models\loginRequest.php";

  if ($_POST) {

    //validation =>
    $validationEmail = new registerRequest;
    //email => rquired , regex
    $validationEmail->setEmail($_POST['email']);
    $emailValidationResalt = $validationEmail->emailValidation();
    //password => rquired , regex
    $validationPassword = new loginRequest;
    $validationPassword->setPassword($_POST['password']);
    $passwordValidationResalt = $validationPassword->passwordValidation();

    if (empty($emailValidationResalt) && empty($passwordValidationResalt)) {
      // get user from db
      $userObject = new user;
      $userObject->setPassword($_POST['password']);
      $userObject->setEmail($_POST['email']);
      $result = $userObject->login();
      //user => exists => check code    
      if ($result) {
        $user = $result->fetch_object();  //  (fetch_object) object in  singl query db بترجع من  bltin function دية 
        switch ($user->status) {
          case '1':
            //status = 1 => home
            $_SESSION['user'] = $user;
            if (isset($_POST['remember_me'])) {
              setcookie('user', $_POST['email'] , time() + (86400 * 30), '/');
            }
            header('location:index.php');
            die;
            case '0':
              //status = 0 => check code
            $_SESSION['checkCode_email'] = $_POST['email'];
            header('location:check-code.php?page=login');
            die;
          default:
          //status = 2 => error message
            $message = "<div class='alert alert-danger'> Sorry , Your Account Has Been Blocked</div>";
            break;
        }
      } else {
        //user => not exists => error message
        $message = "<div class='alert alert-danger'> falid Attempt</div>";

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
                             <h4>login</h4>
                         </a>
                     </div>
                     <div class="tab-content">
                         <div id="lg1" class="tab-pane active">
                             <div class="login-form-container">
                                 <div class="login-register-form">
                                     <form action="#" method="post">
                                         <input type="email" name="email" placeholder="Email" value="<?php if (isset($_POST['email'])) { echo $_POST['email'];}  if (isset($_SESSION['checkCode_email'])) {  echo $_SESSION['checkCode_email'];unset($_SESSION['checkCode_email']);} ?>" />
                                         <?php
                                                if (!empty($emailValidationResalt)) {
                                                  foreach ($emailValidationResalt as $key => $error) {
                                                    echo $error;
                                                  }
                                                }
                                                   ?>
                                         <input type="password" name="password" placeholder="Password" />
                                                  <?php
                                              if (!empty($passwordValidationResalt)) {
                                                foreach ($passwordValidationResalt as $key => $error) {
                                                  echo $error;
                                                }
                                              }
                                              if (!empty($message)) {
                                                echo $message ;
                                              }
                                                    ?>
                                         <div class="button-box">
                                             <div class="login-toggle-btn">
                                                 <input type="checkbox" name="remember_me" value="1"/>
                                                 <label>Remember me</label>
                                                 <a href="varify-email.php">Forgot Password?</a>
                                             </div>
                                             <button type="submit"><span>Login</span></button>
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