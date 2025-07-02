<?php
$title = "CART PAGE";
include_once 'layout/header.php';
include_once 'app/middleware/auth.php';
include_once 'layout/nav.php';
include_once 'layout/breadcrumb.php';
spl_autoload_register(function ($class) {
    include "app/database/models/" . $class . ".php";
});

// $get = [];
// $get = $_GET;
// foreach ($get as $key => $pro) {
    //  print_r($pro);die;

// }
//   print_r($_GET['qtyAll']);
//   print_r($_GET['proAll']);die;


if ($_POST) {
    if ($_POST['btn']) {
        // $addressObject = new Address;
        // $AddressResult = $addressObject->setUser_id($_SESSION['user']->id)->read();
        // if (isset($AddressResult)) {
        header('location:address-page.php');
        // } elseif (!isset($AddressResult)) {
        //     header('location:finish-buying.php');die;
        // }
    }
}

$cartObject = new Carts;
$productObject = new Product;

if (isset($_GET["cart"])) {
    $delete = $cartObject->setId($_GET["cart"]);
    $delete->destroy();
}
if (isset($_GET['user'])) {
    if ($_GET['user'] == $_SESSION['user']->id) {
        

    if (isset($_GET['proAll']) && isset($_GET['qtyAll'])) {
        $oldQtyProReslut = $productObject->getProMultipleQty($_GET['proAll']);
        if (isset($oldQtyProReslut)) {
             $oldQtyPros = $oldQtyProReslut->fetch_all(MYSQLI_ASSOC);
        }
        $loopQuery = '' ;
        $newQtys = '';
        foreach ($oldQtyPros as $key => $oldQtyPro) {
            $newQtys = $oldQtyPro['quantity'];
            $newQntys = '';
            $old = '' ;
            foreach ($_GET['qtyAll'] as $key => $qtyOldCart) {
                // $new .=  $oldQtyPro['id'] . '->' . $newQtys . ', ' ;
                $old .= $qtyOldCart + $newQtys ;
                // $newQntys['qty'] .= ' ' ;
            }
            // $newQtys .= $old + $oldQtyPro['quantity'];
            // $loopQuery .= "WHEN {$oldQtyPro['id']}  {$oldQtyPro['name_en']} {$oldQtyPro['quantity']} + $qtyOldCart THEN $newQntys , <br>";
            
            // $productObject->setQuantity($loopQuery)->updateMultiple($_GET['proAll']);
            
            $newQntys = $old ;
        }
        echo $newQntys;
    }

        $deleteAll = $cartObject->setUser_id($_GET['user']);
        $deleteAllResult = $deleteAll->delete();
        // if (isset($deleteAllResult)) {
        //     header('location:cart-page.php');die;
        // }
        $message = "<div class='alert alert-warning'>All products have been deleted. If you want to shop again,<a href='shop.php' class='text-success'>click here</a> </div>";
    } else {
        header('location:errors/404.php');
    }
}
if ($_GET) {
    if (isset($_GET['pro'])) {
        if (is_numeric($_GET['pro'])) {
            $productResult = $productObject->setId($_GET['pro'])->getQntiyProduct();
            if (isset($productResult)) {
                $productQty = $productResult->fetch_object();
                if (isset($_GET['qty'])) {
                    if (is_numeric($_GET['qty'])) {
                        $newQty =  $productQty->quantity + $_GET['qty'];
                        $productObject->setId($_GET['pro'])->setQuantity($newQty)->UpdateQuantity();
                    }
                }
            }
        }
    }
}
if ($_POST) {
    if ($_POST['btn']) {
        $addressObject = new Address;
        $AddressResult = $addressObject->setUser_id($_SESSION['user']->id)->read();
        if (empty($AddressResult)) {
            header('location:address-page.php');
            die;
        } elseif (!empty($AddressResult)) {
            header('location:finish-buying.php');
            die;
        }
    }
}
$totalProduct = 0;
$readProduct = $cartObject->setUser_id($_SESSION['user']->id);
$readProductResult = $readProduct->getProductInCart();
if ($readProductResult) {
    $cartProducts = $readProductResult->fetch_all(MYSQLI_ASSOC);





?>


    <!-- shopping-cart-area start -->
    <div class="cart-main-area ptb-100">
        <div class="container">
            <h3 class="page-title">Your cart items</h3>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                    <form action="#">
                        <div class="table-content table-responsive">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Product Name</th>
                                        <th>Until Price</th>
                                        <th>Qty</th>
                                        <th>Subtotal</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (isset($cartProducts)) {
                                        $proAll = '' ;
                                        $qtyAll = '' ;
                                        foreach ($cartProducts as $index => $cartProduct) {
                                            $subTotal = $cartProduct['cart-quantity'] * $cartProduct['price'];

                                            //    foreach ($subTotal as $unit => $price) {
                                            //     $totalProduct = 1;
                                            //    }
                                            $cartId = $cartProduct['cart_id'];
                                           

                                    ?>
                                            <tr>
                                                <td class="product-thumbnail">
                                                    <div class="row">
                                                        <img src="assets/img/product/<?= $cartProduct['image'] ?>" alt="" class="col-12 offset-2">
                                                    </div>
                                                </td>
                                                <td class="product-name"><a href="#"><?= $cartProduct['name_en'] ?> </a></td>
                                                <td class="product-price-cart"><span class="amount">$<?= $cartProduct['price'] ?></span></td>
                                                <td class="product-quantity">
                                                    <div class="pro-dec-cart alert alert-success">
                                                        <?= $cartProduct['cart-quantity'] ?>
                                                </td>
                                                <td class="product-subtotal">$<?= $subTotal ?></td>
                                                <td class="product-remove">
                                                    <form action="#" method="post">
                                                        <a href="wishlist.php?editcart=<?= $cartProduct['cart_id'] ?>"><i class="fa fa-pencil"></i></a>
                                                        <a href="cart-page.php?cart=<?= $cartId ?>&pro=<?= $cartProduct['id'] ?>&qty=<?= $cartProduct['cart-quantity'] ?>"><i class="fa fa-times text-black-50"></i></a>
                                                        <!-- class="border-0 bg-transparent" -->
                                                    </form>
                                                </td>

                                            </tr>
                                            
                                            <?php
                                            $proAll .= '&proAll[]='.$cartProduct['id'];                                       
                                            $qtyAll .= '&qtyAll[]='.$cartProduct['cart-quantity'];                                       
                                                $totalProduct += $subTotal;
                                            }
                                        }  
                                                                          
                                    ?>

                                </tbody>
                                <?= isset($message) ? $message : ''; ?>
                            </table>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="cart-shiping-update-wrapper d-flex justify-content-around">
                                    <div class="cart-shiping-update">
                                        <a href="shop.php">Continue Shopping</a>
                                    </div>
                                    <div class="cart-clear ">
                                        <a href="cart-page.php?user=<?= $_SESSION['user']->id . $proAll . $qtyAll?>">Clear Shopping Cart</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="row">
                        <!-- <div class="col-lg-4 col-md-6">
                        <div class="cart-tax">
                            <div class="title-wrap">
                                <h4 class="cart-bottom-title section-bg-gray">Estimate Shipping And Tax</h4>
                            </div>
                            <div class="tax-wrapper">
                                <p>Enter your destination to get a shipping estimate.</p>
                                <div class="tax-select-wrapper">
                                    <div class="tax-select">
                                        <label>
                                            * Country
                                        </label>
                                        <select class="email s-email s-wid">
                                            <option>Bangladesh</option>
                                            <option>Albania</option>
                                            <option>Åland Islands</option>
                                            <option>Afghanistan</option>
                                            <option>Belgium</option>
                                        </select>
                                    </div>
                                    <div class="tax-select">
                                        <label>
                                            * Region / State
                                        </label>
                                        <select class="email s-email s-wid">
                                            <option>Bangladesh</option>
                                            <option>Albania</option>
                                            <option>Åland Islands</option>
                                            <option>Afghanistan</option>
                                            <option>Belgium</option>
                                        </select>
                                    </div>
                                    <div class="tax-select">
                                        <label>
                                            * Zip/Postal Code
                                        </label>
                                        <input type="text">
                                    </div>
                                    <button class="cart-btn-2" type="submit">Get A Quote</button>
                                </div>
                            </div>
                        </div>
                    </div> -->
                        <!-- <div class="col-lg-4 col-md-6">
                        <div class="discount-code-wrapper">
                            <div class="title-wrap">
                                <h4 class="cart-bottom-title section-bg-gray">Use Coupon Code</h4>
                            </div>
                            <div class="discount-code">
                                <p>Enter your coupon code if you have one.</p>
                                <form>
                                    <input type="text" required="" name="name">
                                    <button class="cart-btn-2" type="submit">Apply Coupon</button>
                                </form>
                            </div>
                        </div>
                    </div> -->
                        <div class="col-lg-4 col-md-12 mx-auto">
                            <div class="grand-totall">
                                <div class="title-wrap">
                                    <h4 class="cart-bottom-title section-bg-gary-cart">Cart Total</h4>
                                </div>
                                <h5>Total products <span>$<?= "$totalProduct" ?></span></h5>
                                <!-- <div class="total-shipping">
                                <h5>Total shipping</h5>
                                <ul>
                                    <li><input type="checkbox"> Standard <span>$20.00</span></li>
                                    <li><input type="checkbox"> Express <span>$30.00</span></li>
                                </ul>
                            </div> -->
                                <!-- <h4 class="grand-totall-title">Grand Total <span>$260.00</span></h4> -->
                                <form method="post">
                                    <input type="submit" name="btn" class="btn btn-success w-100" placeholder="Complete the purchase">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


<?php
} else {
    echo "<div class='alert alert-warning mt-2'>There are no products yet. If you want to shop again,<a href='shop.php' class='text-success'>click here</a> </div>";
}
include_once "layout/footer.php";
include_once "layout/scripts.php";
?>