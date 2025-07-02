<?php
session_start();
  include_once 'app/database/models/User.php';
 
 $userObject = new User ;
 $userObject->setStatus(1);
 $userObject->setEmail($_GET['email']);
 $result = $userObject->updateUserStatus();
 
 if ($result) {
     $_SESSION['message'] = "<div class='alert alert-success'> Email Updated Successfully </div>";
 }else {
     $_SESSION['message'] = "<div class='alert alert-danger'> Something went Wrong </div>";

 }
 
    header('location:my-account.php');
  ?>
 