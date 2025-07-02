<?php
$title = "profile";
include_once 'layout/header.php';
include_once 'app/middleware/auth.php';
include_once 'layout/nav.php';
include_once 'layout/breadcrumb.php';
include_once 'app/requests/registerRequest.php';
include_once 'app/services/media.php';
include_once 'app/mail/mail.php';
include_once 'app/requests/AddressRequest.php';
spl_autoload_register(function ($class) {
    include "app/database/models/" . $class . ".php";
});
spl_autoload_register(function ($class) {
    include "app/requests/" . $class . ".php";
});
// get user information
$userobject = new User;
$userobject->setEmail($_SESSION['user']->email);

$validation = new registerRequest;
// update user profile

$errors = [];
$success = [];
if (isset($_POST['update_profile'])) {

    // print_r($_POST);
    // print_r($_FILES);die;
    $validation->setFirst_name($_POST['first_name']);
    $first_nameValidationResult = $validation->validatFirstname();
    $validation->setLast_name($_POST['last_name']);
    $last_nameValidationResult = $validation->validatLastname();
    $validation->setPhone($_POST['phone']);
    $phoneRequired = $validation->requiredphone();
    $validation->setGender($_POST['gender']);
    $genderValidationResult = $validation->requiredGender();

    if (
        empty($first_nameValidationResult) || empty($last_nameValidationResult)
        || empty($phoneRequired) || empty($genderValidationResult)
    ) {
        if ($_FILES['image']['error'] == 0) {
            $media = new media;
            $imageResult = $media->setImage($_FILES['image'])
                ->validateOnSize(10 ** 6)
                ->validateOnExtension(['png', 'jpg', 'jpeg'])->upload('users');
            if (empty($imageResult->getErrors())) {
                $userobject->setImage($imageResult->getNewImageName());
            }
            //validate size 
            // validate on extension
            // Upload image
        }
        $result = $userobject->setFirst_name($_POST['first_name'])
            ->setLast_name($_POST['last_name'])
            ->setPhone($_POST['phone'])
            ->setGender($_POST['gender'])
            ->update();

        if ($result) {
            $_SESSION['user']->first_name = $_POST['first_name'];
            $_SESSION['user']->last_name = $_POST['last_name'];
            $_SESSION['user']->phone = $_POST['phone'];
            $_SESSION['user']->gender = $_POST['gender'];
            $success['update_profile']['success'] = "<div class='alert alert-success'> Date Update Successfully</div>";
        } else {
            $errors['update_profile']['something'] = "<div class='alert alert-danger'> Something Went Wrong </div>";
        }
    }
}

//change password
if (isset($_POST['update_password'])) {

    $validation->setOldPassword($_POST['old_password'])
        ->setPassword($_POST['new_password'])
        ->setConfirmPassword($_POST['confirm_password']);
    $oldPasswordValidationResult = $validation->oldPasswordValidation();
    // $x = $userobject->change();

    if (empty($oldPasswordValidationResult)) {
        // password_verify(sha1($_POST['old_password']),$userobject->change())
        if (password_verify($_SESSION['user']->email, sha1($_POST['old_password']))) {
            $oldPasswordValidationResult['old_database'] = "<div class='alert alert-danger'> Wrong Password </div>";
        }
    }

    $passwordValidationResult = $validation->passwordValidation();
    $ConfirmPasswordValidationResult = $validation->confirmPasswordValidation();

    if (empty($oldPasswordValidationResult) && empty($ConfirmPasswordValidationResult) && empty($passwordValidationResult)) {
        $userobject->setPassword($_POST['new_password']);
        $resultPassword = $userobject->updatePassword();
        if ($resultPassword) {
            $success['update_password']['success'] = "<div class='alert alert-success'> Password Update Successfully</div>";
        }
    } else {
        $errors['update_password']['something'] = "<div class='alert alert-danger'> Something Went Wrong </div>";
    }
}
//change password
if (isset($_POST['update_email'])) {
    $validation->setEmail($_POST['email']);
    $emailValidationResult = $validation->emailValidation();
    $emailExistsResult = $validation->checkIfEmailExists();

    if (empty($emailValidationResult) && empty($emailExistsResult)) {
        $userobject->setEmail($_POST['email']);
        $userobject->setId($_SESSION['user']->id);
        $userobject->setStatus(0);
        $updateEmailResult = $userobject->updateEmail();
        if ($updateEmailResult) {
            $link = "http://localhost/new/ferst-broject-eCommerce/change-email.php?email={$_POST['email']}";

            $body = "<P> Hello {$_SESSION['user']->first_name}</p> 
              <p> Please Click the link below To Verify Account </p>
              <div> <a href='$link'> Verify </a></div>
              <p> Thank You </p>";
            $mail = new mail($_POST['email'], 'Verify-Email-Address', $body);
            $mailResult = $mail->send();
            if ($mailResult) {
                $success['update_email']['success'] = "<div class='alert alert-success'> A fresh Email Has Been Sent Successfully , Please Chick your Email Address </div>";
                unset($_SESSION['user']);
                header('Refresh: 5; url=login.php');
            } else {
                $errors['update_email']['try_again']  = "<div class='alert alert-danger'> Please Try Again Later </div>";
            }
        } else {
            $errors['update_email']['something']  = "<div class='alert alert-danger'> Something Went Wrong </div>";
        }
    }
}
// get address information
$addressObject = new Address;
$AddressResult = $addressObject->setUser_id($_SESSION['user']->id)->read();
if (empty($AddressResult)) {
    $message = "Insert Your Address";
    $btn = "<button type='submit' name='createAddress' class='btn btn-success rounded mb-4'>Create Address</button>";
} elseif (!empty($AddressResult)) {
    $address = $AddressResult->fetch_object();
    $_SESSION['address_id'] = $address->id;
    $message = "Modify your address book entries";
    $btn = "<button type='submit' name='updateAddress' class='btn btn-secondary rounded mb-4'>Update Address</button>";
}

$regionObject = new Regions;
$regionCityResult = $regionObject->setcity_id($_SESSION['user']->city_id)
    ->getRegionsCity();
if (isset($regionCityResult)) {
    $regions = $regionCityResult->fetch_all(MYSQLI_ASSOC);
}
if ($_POST) {
    $validat = new AddressRequest;
    if (isset($_POST['updateAddress'])) {
        // print_r($_SESSION['city-id']);die;
        $regionResult = $regionObject->setStatus(1)->setId($address->regions_id)->getShippingFees();
        if (isset($regionResult)) {
            $regionUser = $regionResult->fetch_object();
        }
        //address  validation
        $addressValidat = $validat->setAddress($_POST['address']);
        $addressValidatResult = $addressValidat->addressValidation();
        //region  validation
        $regionValidat = $validat->setRegion($_POST['region']);
        $regionValidatResult = $regionValidat->regionValidation();
        //floor  validation
        $floorValidat = $validat->setFloor($_POST['floor']);
        $floorValidatResult = $floorValidat->floorValidation();
        //flat  validation
        $flatValidat = $validat->setFlat($_POST['flat']);
        $flatValidatResult = $flatValidat->flatValidation();
        //street  validation
        $streetValidat = $validat->setStreet($_POST['street']);
        $streetValidatResult = $streetValidat->streetValidation();
        //building  validation
        $buildingValidat = $validat->setBuilding($_POST['building']);
        $buildingValidatResult = $buildingValidat->buildingValidation();

        if (
            empty($addressValidatResult) && empty($countryValidatResult) &&
            empty($regionValidatResult) && empty($floorValidatResult) && empty($flatValidatResult) &&
            empty($streetValidatResult) && empty($buildingValidatResult)
        ) {
            $addressObject = new Address;
            $setaddress = $addressObject->setId($address->id)->setAddress($_POST['address'])
                ->setUser_id($_SESSION['user']->id)->setRegions_id($_POST['region'])->setFloor($_POST['floor'])
                ->setFlat($_POST['flat'])->setStreet($_POST['street'])
                ->setBuilding($_POST['building'])->setNotes($_POST['notes']);
            $addressResult = $setaddress->update();
            if ($addressResult) {
                $cartObject = new Carts;
                $cartIdResult = $cartObject->setUser_id($_SESSION['user']->id)->checkId();
                if (empty($cartIdResult)) {
                    header('location:my-account.php');die;
                }if(!empty($cartIdResult)){
                    header('location:finish-buying.php');die;
                }
            } else {
                $show = "show";
                $error = "<div class='alert alert-danger'>Sorry, an error occurred, try again later </div>";
            }
        }
    }
    if (isset($_POST['createAddress'])) {
        //address  validation
        $addressValidat = $validat->setAddress($_POST['address']);
        $addressValidatResult = $addressValidat->addressValidation();
        //region  validation
        $regionValidat = $validat->setRegion($_POST['region']);
        $regionValidatResult = $regionValidat->regionValidation();
        //floor  validation
        $floorValidat = $validat->setFloor($_POST['floor']);
        $floorValidatResult = $floorValidat->floorValidation();
        //flat  validation
        $flatValidat = $validat->setFlat($_POST['flat']);
        $flatValidatResult = $flatValidat->flatValidation();
        //street  validation
        $streetValidat = $validat->setStreet($_POST['street']);
        $streetValidatResult = $streetValidat->streetValidation();
        //building  validation
        $buildingValidat = $validat->setBuilding($_POST['building']);
        $buildingValidatResult = $buildingValidat->buildingValidation();

        if (
            empty($addressValidatResult) && empty($countryValidatResult) &&
            empty($regionValidatResult) && empty($floorValidatResult) && empty($flatValidatResult) &&
            empty($streetValidatResult) && empty($buildingValidatResult)
        ) {
            $addressObject = new Address;
            $setaddress = $addressObject->setAddress($_POST['address'])->setUser_id($_SESSION['user']->id)
                ->setRegions_id($_POST['region'])->setFloor($_POST['floor'])
                ->setFlat($_POST['flat'])->setStreet($_POST['street'])
                ->setBuilding($_POST['building'])->setNotes($_POST['notes']);
            $addressCareateResult = $setaddress->create();
            if ($addressCareateResult) {
                header('location:my-account.php');
                // $successAddress = "<div class='alert alert-success'>The Address Has Been Entered Successfully</div>";
            } else {
                $show = "show";
                $error = "<div class='alert alert-danger'>Sorry, an error occurred, try again later </div>";
            }
        }
    }
}


$result = $userobject->emailExists();
$user = $result->fetch_object();   //bt7wel date ale gya mn db 2la object

?>
<!-- my account start -->
<div class="checkout-area pb-80 pt-100">
    <div class="container">
        <div class="row">
            <div class="ml-auto mr-auto col-lg-9">
                <div class="checkout-wrapper">
                    <div id="faq" class="panel-group">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h5 class="panel-title"><span>1</span> <a data-toggle="collapse" data-parent="#faq"
                                        href="#my-account-1">Edit your account information </a></h5>
                            </div>
                            <div id="my-account-1"
                                class="panel-collapse collapse <?= isset($_POST['update_profile']) ? 'show' : ''; ?>">
                                <div class="panel-body">
                                    <div class="billing-information-wrapper">
                                        <div class="account-info-wrapper">
                                            <h4>My Account Information</h4>
                                            <h5>Your Personal Details</h5>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <?php
                                                if (isset($errors['update-profile'])) {
                                                    foreach ($errors['update-profile'] as $key => $error) {
                                                        echo $error;
                                                    }
                                                }
                                                if (isset($imageResult) && !empty($imageResult->getErrors())) {
                                                    foreach ($imageResult->getErrors() as $key => $error) {
                                                        echo $error;
                                                    }
                                                }
                                                if (isset($success['update_profile']['success'])) {
                                                    echo $success['update_profile']['success'];
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <form method="post" enctype="multipart/form-data">
                                            <div class="row">

                                                <div class="col-3  offset-4  my-5">
                                                    <img src="assets/img/users/<?= $user->image ?>" alt=""
                                                        class="w-100 rounded-circle">
                                                    <input type="file" name="image" class="form-control mt-3" id="">
                                                </div>
                                                <div class="col-lg-6 col-md-6">
                                                    <div class="billing-info">
                                                        <label>First Name</label>
                                                        <input type="text" name="first_name"
                                                            value="<?= $user->first_name ?>">
                                                        <?php
                                                        if (isset($first_nameValidationResult['first_name_required'])) {
                                                            echo  $first_nameValidationResult['first_name_required'];
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6">
                                                    <div class="billing-info">
                                                        <label>Last Name</label>
                                                        <input type="text" name="last_name"
                                                            value="<?= $user->last_name ?>">
                                                        <?php
                                                        if (isset($last_nameValidationResult['last_name_required'])) {
                                                            echo  $last_nameValidationResult['last_name_required'];
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                                <!-- <div class="col-lg-12 col-md-12">
                                                     <div class="billing-info"> 
                                                         <label>Email Address</label><input type="email">  
                                                        </div> </div> -->
                                                <div class="col-lg-6 col-md-6">
                                                    <div class="billing-info">
                                                        <label>Phone</label>
                                                        <input type="number" name="phone" value="<?= $user->phone ?>">
                                                        <?php
                                                        if (isset($phoneRequired['phone_required'])) {
                                                            echo  $phoneRequired['phone_required'];
                                                        } ?>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6">
                                                    <div class="billing-info">
                                                        <label>Gender</label>
                                                        <select name="gender" id="gender">
                                                            <option <?= $user->gender == 'm' ? 'selected' : '' ?>
                                                                value="m">male</option>
                                                            <option <?= $user->gender == 'f' ? 'selected' : '' ?>
                                                                value="f">female</option>
                                                        </select>
                                                        <?php if (isset($genderValidationResult['gender_required'])) {
                                                            echo  $genderValidationResult['gender_required'];
                                                        } ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="billing-back-btn">
                                                <div class="billing-btn">
                                                    <button type="submit" name="update_profile">Update profile</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h5 class="panel-title"><span>2</span> <a data-toggle="collapse" data-parent="#faq"
                                        href="#my-account-2">Change your password </a></h5>
                            </div>
                            <div id="my-account-2"
                                class="panel-collapse collapse <?= isset($_POST['update_password']) ? 'show' : ''; ?>">
                                <div class="panel-body">
                                    <div class="billing-information-wrapper">
                                        <div class="account-info-wrapper">
                                            <h4>Change Password</h4>
                                            <h5>Your Password</h5>
                                        </div>

                                        <div class="row">
                                            <form method="post">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <?php
                                                        if (isset($success['update_password']['success'])) {
                                                            echo $success['update_password']['success'];
                                                        }
                                                        if (isset($errors['update_password']['something'])) {
                                                            echo $errors['update_password']['something'];
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 col-md-12">
                                                    <div class="billing-info">
                                                        <label>Old Password</label>
                                                        <input type="password" name="old_password" value="">
                                                        <?php if (isset($oldPasswordValidationResult)) {
                                                            foreach ($oldPasswordValidationResult as $key => $error) {
                                                                echo $error;
                                                            }
                                                        }
                                                        // if (!empty($oldPasswordValidationResult['old_datebase'])) {
                                                        //  echo $oldPasswordValidationResult['old_datebase'] ;
                                                        // } 
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 col-md-12">
                                                    <div class="billing-info">
                                                        <label>New Password</label>
                                                        <input type="password" name="new_password" value="">
                                                        <?php if (isset($passwordValidationResult['password_required'])) {
                                                            echo $passwordValidationResult['password_required'];
                                                        }
                                                        if (isset($passwordValidationResult['password_pattern'])) {
                                                            echo $passwordValidationResult['password_pattern'];
                                                        } ?>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 col-md-12">
                                                    <div class="billing-info">
                                                        <label>Password Confirm</label>
                                                        <input type="password" name="confirm_password">
                                                        <?php if (isset($ConfirmPasswordValidationResult['confirmPassword_required'])) {
                                                            echo $ConfirmPasswordValidationResult['confirmPassword_required'];
                                                        }
                                                        if (isset($ConfirmPasswordValidationResult['password_notmatched'])) {
                                                            echo $ConfirmPasswordValidationResult['password_notmatched'];
                                                        } ?>
                                                    </div>
                                                </div>
                                        </div>
                                        <div class="billing-back-btn">
                                            <div class="billing-btn">
                                                <button type="submit" name="update_password">Update Password</button>
                                            </div>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h5 class="panel-title"><span>3</span> <a data-toggle="collapse" data-parent="#faq"
                                        href="#my-account-3">Change your Email </a></h5>
                            </div>
                            <div id="my-account-3"
                                class="panel-collapse collapse <?= isset($_POST['update_email']) || isset($_SESSION['message']) ? 'show' : ''; ?>">
                                <div class="panel-body">
                                    <div class="billing-information-wrapper">
                                        <div class="account-info-wrapper">
                                            <h4>Change Email</h4>
                                            <h5>Your Email</h5>
                                        </div>

                                        <div class="row">
                                            <form method="post">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <?php
                                                        if (isset($success['update_email']['success'])) {
                                                            echo $success['update_email']['success'];
                                                        }
                                                        if (isset($errors['update_email']['try_again'])) {
                                                            echo $errors['update_email']['try_again'];
                                                        }
                                                        if (isset($_SESSION['message'])) {
                                                            echo $_SESSION['message'];
                                                            unset($_SESSION['message']);
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 col-md-12">
                                                    <div class="billing-info">
                                                        <label>Email</label>
                                                        <input type="email" name="email" value="<?= $user->email ?>">
                                                        <?php
                                                        if (!empty($emailValidationResult)) {
                                                            foreach ($emailValidationResult as $index => $error) {
                                                                echo $error;
                                                            }
                                                        }
                                                        if (!empty($emailExistsResult)) {
                                                            foreach ($emailExistsResult as $index => $error) {
                                                                echo $error;
                                                            }
                                                        }
                                                        // if (!empty($oldPasswordValidationResult['old_datebase'])) {
                                                        //  echo $oldPasswordValidationResult['old_datebase'] ;
                                                        // } 
                                                        ?>
                                                    </div>
                                                </div>

                                        </div>
                                        <div class="billing-back-btn">
                                            <div class="billing-btn">
                                                <button type="submit" name="update_email">Update Email</button>
                                            </div>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                       
                        <div id="address" class="panel panel-default">
                            <div class="panel-heading ">
                                <h5 class="panel-title"><span>4</span> <a data-toggle="collapse" data-parent="#faq"
                                        href="#my-account-4 "><?= isset($message) ? $message : ''; ?></a></h5>
                            </div>
                            <div id="my-account-4"
                                class="panel-collapse collapse <?= isset($_GET['adrs']) || isset($_POST['updateAddress']) || isset($_POST['createAddress']) ? 'show' : ''; ?>">
                                <div class="panel-body">
                                    <div class="billing-information-wrapper">
                                        <div class="account-info-wrapper">
                                            <h4>Address Book Entries</h4>
                                        </div>
                                        <form action="" method="post">
                                            <div class="form-control mb-4">
                                                <!--  -->

                                                <div class="form-group">
                                                    <label for="inputAddress">Address</label>
                                                    <input type="text" name="address" class="form-control"
                                                        id="inputAddress" placeholder="Enter Your Address"
                                                        value="<?php if(isset($address->address)){echo $address->address;}else{echo '';}
                                                              if(isset($_POST['address'])) {echo $_POST['address'] ;}else{echo '';}?>">
                                                    <?= isset($addressValidatResult) ? $addressValidatResult : ''; ?>
                                                </div>

                                                <div class="form-row">

                                                    <div class="form-group col-md-4">
                                                        <label for="region">Region</label>
                                                        <select name="region" id="region" class="form-control"
                                                            placeholder="Choose City"> Choose City
                                                            <option value="<?= isset($address->regions_id) ? $address->regions_id : '' ?>" selected >
                                                                <?= isset($address->regoin_name_en) ? $address->regoin_name_en : ''; ?>
                                                            </option>
                                                            <optgroup label="do you want to change">
                                                                <?php
                                                                foreach ($regions as $index => $region) { ?>

                                                                <option
                                                                    <?= isset($_POST['region']) && $_POST['region'] == $region['id']  ? 'selected' : '' ?>
                                                                    value="<?= $region['id'] ?>">
                                                                    <?= $region['name_en'] ?>
                                                                    <?php

                                                                        ?>
                                                                </option>
                                                            </optgroup>

                                                            <?php
                                                                }

                                                        ?>
                                                        </select>
                                                        <?= isset($regionValidatResult) ? $regionValidatResult : ''; ?>
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <label for="floor">Floor</label>
                                                        <input type="text" class="form-control" name="floor" id="floor"
                                                            placeholder="Enter Your Floor"
                                                            value="<?php if(isset($address->floor)){echo $address->floor ;}else{echo '';}
                                                             if(isset($_POST['floor'])){echo $_POST['floor'];}else{echo '';} ?>">
                                                        <?= isset($floorValidatResult) ? $floorValidatResult : ''; ?>
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <label for="flat">Flat</label>
                                                        <input type="text" class="form-control" name="flat" id="flat"
                                                            placeholder="Enter Your Flat"
                                                            value="<?php if(isset($address->flat)){echo $address->flat ;}else{echo '';}
                                                             if(isset($_POST['flat'])){echo $_POST['flat'];}else{echo '';} ?>">
                                                        <?= isset($floorValidatResult) ? $flatValidatResult : ''; ?>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="street">Street</label>
                                                        <input type="text" class="form-control" name="street"
                                                            id="street" placeholder="Enter Your Street"
                                                            value="<?php if(isset($address->street)) {echo $address->street;}else{echo '';}
                                                             if(isset($_POST['street'])){echo $_POST['street'] ;} ?>">
                                                        <?= isset($streetValidatResult) ? $streetValidatResult : ''; ?>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="building">Building</label>
                                                        <input type="text" class="form-control" name="building"
                                                            id="building" placeholder="Enter Your Building"
                                                            value="<?php if(isset($address->building)) {echo $address->building ;}else{echo '';}
                                                             if(isset($_POST['building'])) {echo $_POST['building'] ;}else{echo '';} ?>">
                                                        <?= isset($buildingValidatResult) ? $buildingValidatResult : ''; ?>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="notes">Notes</label>
                                                    <input type="text" class="form-control" name="notes" id="notes"
                                                        placeholder="Any notes"
                                                        value="<?php if(isset($address->notes)) {echo $address->notes ;}else{echo '';}
                                                         if(isset($_POST['notes'])) {echo $_POST['notes'] ;} ?>">
                                                </div>
                                                <?= isset($btn) ? $btn : '' ?>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="panel panel-default">
                            <div class="panel-heading">
                                <h5 class="panel-title"><span>4</span> <a href="wishlist.html">Modify your wish list
                                    </a></h5>
                            </div>
                        </div> -->
                        <!-- my account end -->
                        <?php
                        include_once 'layout/footer.php';
                        include_once 'layout/scripts.php';
                        ?>