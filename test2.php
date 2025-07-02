
                        //change password
                        if (isset($_POST['update_password'])) {

                            $validation->setOldPassword($_POST['old_password'])
                                ->setPassword($_POST['new_password'])
                                ->setConfirmPassword($_POST['confirm_password']);
                            $oldPasswordValidationResult = $validation->oldPasswordValidation();

                            if (sha1($_POST['old_password']) != $userobject->login()) {
                                $oldPasswordValidationResult['old_database'] = "<div class='alert alert-danger'> Something Password </div>";
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

                        $result = $userobject->emailExists();
                        $user = $result->fetch_object();   //b7wel date ale gya mn db 2la object

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
                                                        <h5 class="panel-title"><span>1</span> <a data-toggle="collapse"
                                                                data-parent="#faq" href="#my-account-1">Edit your
                                                                account information </a></h5>
                                                    </div>
                                                    <div id="my-account-1"
                                                        class="panel-collapse collapse <?= isset($_POST['update_profile']) ? 'show' : ''; ?>">
                                                        <div class="panel-body">
                                                            <div class="billing-information-wrapper">
                                                                <div class="account-info-wrapper">
                                                                    <h4>My Account Information</h4>
                                                                    <h5>Your Personal Details</h5>
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
                                                                </div>
                                                                <form method="post" enctype="multipart/form-data">
                                                                    <div class="row">

                                                                        <div class="col-3  offset-4  my-5">
                                                                            <img src="assets/img/users/<?= $user->image ?>"
                                                                                alt="" class="w-100 rounded-circle">
                                                                            <input type="file" name="image"
                                                                                class="form-control mt-3" id="">
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
                                                        <label>Email Address</label>
                                                        <input type="email">
                                                    </div>
                                                </div> -->
                                                                        <div class="col-lg-6 col-md-6">
                                                                            <div class="billing-info">
                                                                                <label>Phone</label>
                                                                                <input type="number" name="phone"
                                                                                    value="<?= $user->phone ?>">
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
                                                                                    <option
                                                                                        <?= $user->gender == 'm' ? 'selected' : '' ?>
                                                                                        value="m">male</option>
                                                                                    <option
                                                                                        <?= $user->gender == 'f' ? 'selected' : '' ?>
                                                                                        value="f">female</option>
                                                                                </select>
                                                                                <?php

                                                                                if (isset($genderValidationResult['gender_required'])) {
                                                                                    echo  $genderValidationResult['gender_required'];
                                                                                } ?>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="billing-back-btn">
                                                                        <div class="billing-btn">
                                                                            <button type="submit"
                                                                                name="update_profile">Update
                                                                                profile</button>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="panel panel-default">
                                                    <div class="panel-heading">
                                                        <h5 class="panel-title"><span>2</span> <a data-toggle="collapse"
                                                                data-parent="#faq" href="#my-account-2">Change
                                                                your password </a></h5>
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
                                                                        <div class="col-lg-12 col-md-12">
                                                                            <div class="billing-info">
                                                                                <label>Old Password</label>
                                                                                <input type="password"
                                                                                    name="old_password">
                                                                                <?php
                                                                                if (isset($oldPasswordValidationResult)) {
                                                                                    foreach ($oldPasswordValidationResult as $key => $error) {
                                                                                        echo $error;
                                                                                    }
                                                                                }
                                                                                // if (!empty($oldPasswordValidationResult['old_datebase'])) {
                                                                                //    echo $oldPasswordValidationResult['old_datebase'] ;
                                                                                // }

                                                                                ?>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-12 col-md-12">
                                                                            <div class="billing-info">
                                                                                <label>New Password</label>
                                                                                <input type="password"
                                                                                    name="new_password">
                                                                                <?php
                                                                                if (isset($passwordValidationResult['password_required'])) {
                                                                                    echo $passwordValidationResult['password_required'];
                                                                                }
                                                                                if (isset($passwordValidationResult['password_pattern'])) {
                                                                                    echo $passwordValidationResult['password_pattern'];
                                                                                }
                                                                                ?>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-12 col-md-12">
                                                                            <div class="billing-info">
                                                                                <label>Password Confirm</label>
                                                                                <input type="password"
                                                                                    name="confirm_password">
                                                                                <?php
                                                                                if (isset($ConfirmPasswordValidationResult['confirmPassword_required'])) {
                                                                                    echo $ConfirmPasswordValidationResult['confirmPassword_required'];
                                                                                }
                                                                                if (isset($ConfirmPasswordValidationResult['password_notmatched'])) {
                                                                                    echo $ConfirmPasswordValidationResult['password_notmatched'];
                                                                                }
                                                                                ?>
                                                                            </div>
                                                                        </div>
                                                                </div>
                                                                <div class="billing-back-btn">
                                                                    <div class="billing-btn">
                                                                        <button type="submit"
                                                                            name="update_password">Update
                                                                            Password</button>
                                                                    </div>
                                                                </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>