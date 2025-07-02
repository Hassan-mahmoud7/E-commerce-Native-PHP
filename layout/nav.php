 <?php
  // spl_autoload_register(function ($class) {
  //   include_once 'app/database/models/' . $class . '.php';
  // });
  include_once 'app/database/models/Category.php';
  include_once 'app/database/models/Subcategory.php';
  include_once 'app/database/models/address.php';
  include_once 'app/database/models/order.php';
  include_once 'app/database/models/Product.php';


  $categoryObject = new Category;
  $categoryObject->setStatus(1);
  $categoriesResult = $categoryObject->read();

  $subcategoryObject = new Subcategory;
  $subcategoryObject->setStatus(1);

  $addressObject = new Address;
  if (isset($_SESSION['user'])) {
    $AddressResult = $addressObject->setUser_id($_SESSION['user']->id)->read();
  }
  if (!empty($AddressResult)) {
    $address = $AddressResult->fetch_object();
    $orderObject = new Order;
    $status = 1;
    $orderResult = $orderObject->setAddress_id($address->id)->setUser_id($_SESSION['user']->id)->setStatus($status)->read();
  }
  // $productObject = new Product ;
  // if ($_POST) {
  //   elseif (isset($_POST['search'])) {
  //     $productResult = $productObject->setName_en($_POST['search'])->search();
  //     if (isset($productResult)) {
  //       $productObjectResult = $productResult->fetch_all(MYSQLI_ASSOC);
  //       header('location:shop.php');die;
  //     }else{
  //       echo "Sorry can\'t fainded is it {$_POST['search']}";
  //     }
  //   }
  // }



  ?>
 <!-- header start -->
 <header class="header-area gray-bg clearfix">
   <div class="header-bottom">
     <div class="container">
       <div class="row">
         <div class="col-lg-2 col-md-3 col-ms-4">
           <div class="logo">
             <a href="index.php">
               <img alt="" src="assets/img/logo/logo.png" />
             </a>
           </div>
         </div>
         <div class="col-lg-4 col-md-4 col-ms-4">
           <div class="logo">
             <form class="news-form" method="get" action="shop.php">
               <input type="search" name="search" class="bg-light" placeholder="Search.....">
               <button type="submit"class="pt-2 close" >
                 <i  class="ion-ios-search-strong"></i>
               </button>
             </form>
           </div>
         </div>
         <div class="col-lg-6  col-ms-4">
           <div class="header-bottom-right">
             <div class="main-menu">
               <nav>
                 <ul>

                   <li class="top-hover">
                     <a href="index.php">home</a>


                   </li>
                   <li class="mega-menu-position top-hover"><a href="shop.php">Categories</a>
                     <ul class="mega-menu">
                       <?php
                        if (!empty($categoriesResult)) {
                          $categories = $categoriesResult->fetch_all(MYSQLI_ASSOC);
                          foreach ($categories as $index => $category) {
                        ?>
                           <li>
                             <ul>
                               <li class="mega-menu-title"><a href="shop.php?cat=<?= $category['id'] ?>&page=1"><b class="text-uppercase"><?= $category['name_en'] ?></b></a>
                               </li>
                               <?php
                                $subcategoryObject->setCategory_id($category['id']);
                                $subcategoryObjectResult = $subcategoryObject->read();
                                if (!empty($subcategoryObjectResult)) {
                                  $subcategories = $subcategoryObjectResult->fetch_all(MYSQLI_ASSOC);
                                  foreach ($subcategories as $index => $subcategory) {
                                ?>
                                   <li><a href="shop.php?sub=<?= $subcategory['id'] ?>&page=1"><?= $subcategory['name_en'] ?></a>
                                   </li>
                               <?php
                                  }
                                }
                                ?>
                             </ul>
                           </li>

                       <?php
                          }
                        }
                        ?>
                     </ul>
                   </li>
                   <li><a href="shop.php">Shop</a></li>
                 </ul>
               </nav>
             </div>
             <?php
              if (isset($_SESSION['user'])) {
              ?>
               <div class="header-currency">
                 <span class="digit"><?= $_SESSION['user']->first_name . ' ' . $_SESSION['user']->last_name ?>
                   <i class="ti-angle-down"></i></span>
                 <div class="dollar-submenu">
                   <ul>
                     <li><a href="my-account.php">Profile</a></li>
                     <li><a href="logout.php">Logout</a></li>
                   </ul>
                 </div>
               </div>
             <?php
              } else { ?>
               <div class="header-currency">
                 <span class="digit">Welcome </i></span>
                 <div class="dollar-submenu">
                   <ul>
                     <li><a href="login.php">login</a></li>
                     <li><a href="register.php">Register</a></li>
                   </ul>
                 </div>
               </div>
             <?php
              }
              ?>
             <div class="header-cart">
               <a href="cart-page.php">
                 <div class="cart-icon">
                   <i class="ti-shopping-cart"></i>
                 </div>
               </a>
               <div class="shopping-cart-content">
                 <?php
                  if (!empty($orderResult)) {
                    $orderNmb = $orderResult->fetch_object();

                    if (isset($orderNmb->id) && $orderNmb->status == $status) {
                  ?>
                     <div class="shopping-cart-btn">
                       <a href="my-order.php">my order</a>
                     </div>
                   <?php
                    }
                  } else {
                    ?>
                   <ul>
                     <!-- <li class="single-shopping-cart">
                       <div class="shopping-cart-img">
                         <a href="#"><img alt="" src="assets/img/cart/cart-1.jpg" /></a>
                       </div>
                       <div class="shopping-cart-title">
                         <h4><a href="#">Phantom Remote </a></h4>
                         <h6>Qty: 02</h6>
                         <span>$260.00</span>
                       </div>
                       <div class="shopping-cart-delete">
                         <a href="#"><i class="ion ion-close"></i></a>
                       </div>
                     </li> -->
                     <!-- <li class="single-shopping-cart">
                       <div class="shopping-cart-img">
                         <a href="#"><img alt="" src="assets/img/cart/cart-2.jpg" /></a>
                       </div>
                       <div class="shopping-cart-title">
                         <h4><a href="#">Phantom Remote</a></h4>
                         <h6>Qty: 02</h6>
                         <span>$260.00</span>
                       </div>
                       <div class="shopping-cart-delete">
                         <a href="#"><i class="ion ion-close"></i></a>
                       </div>
                     </li>
                   </ul>
                   <div class="shopping-cart-total">
                     <h4>Total : <span class="shop-total">$260.00</span></h4>
                   </div> -->
                     <div class="shopping-cart-btn">
                       <a href="cart-page.php">view cart</a>
                     </div>

                   <?php

                  }
                    ?>
               </div>
             </div>
           </div>
         </div>
         <div class="mobile-menu-area">
           <div class="mobile-menu">
             <nav id="mobile-menu-active">
               <ul class="menu-overflow">
                 <li>
                   <a href="index.php">HOME</a>
                   
                 </li>
                 <li>
                   <a href="#">PAGES</a>
                   <ul>
                     <!-- <li><a href="about-us.php">about us </a></li> -->
                     <?php
                      if (isset($_SESSION['user'])) {
                      ?>
                       <li><a href="my-account.php">my account :
                           <?= $_SESSION['user']->first_name . ' ' . $_SESSION['user']->last_name ?></a>
                       </li>
                       <li class="digit">
    
                       </li>
                     <?php } else { ?><li>
                         <a href="login.php">login</a>
                         <a href="register.php">register</a>
                       </li>
                     <?php } ?>
                     <!-- <li><a href="contact.php">contact</a></li> -->
                   </ul>
                 </li>
                 <li>
                   <a href="#"> categories </a>
                   <ul>
                     <li>
                           <?php                     
                              foreach ($categories as $index => $category) {
                            ?>
                                  <li class="mega-menu-title"><a href="shop.php?cat=<?= $category['id'] ?>&page=1"><b class="text-uppercase"><?= $category['name_en'] ?></b></a>
                           <ul>
                             <?php
                                    $subcategoryObject->setCategory_id($category['id']);
                                    $subcategoryObjectResult = $subcategoryObject->read();
                                    if (!empty($subcategoryObjectResult)) {
                                      $subcategories = $subcategoryObjectResult->fetch_all(MYSQLI_ASSOC);
                                      foreach ($subcategories as $index => $subcategory) {
                                    ?>
                             <li><a href="shop.php?sub=<?= $subcategory['id'] ?>&page=1"><?= $subcategory['name_en'] ?></a></li>
                               <?php
                                      }
                                    }
                                    ?>
                           </ul>
                                <?php
                        }
                      ?>
                         </li>
                   </ul>
                 </li>
               </ul>
               </li>
               <!-- <li><a href="contact.php"> Contact us </a></li> -->
               </ul>
             </nav>
           </div>
         </div>
       </div>
     </div>
   </div>
   </div>
  
 </header>

 <!-- header end -->