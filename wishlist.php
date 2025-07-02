<?php
$title = "WISHLIST";
include_once 'layout/header.php';
include_once 'app/middleware/auth.php';
include_once 'layout/nav.php';
include_once 'layout/breadcrumb.php';
spl_autoload_register(function ($class) {
    include "app/database/models/" . $class . ".php";
});
$cartObject = new Carts;

if ($_GET) {
    if ($_GET['editcart']) {
        if (is_numeric($_GET['editcart'])) {
            $readProduct = $cartObject->setUser_id($_SESSION['user']->id);
            $readProduct = $cartObject->setId($_GET['editcart']);
            $readProductResult = $readProduct->getEditProductInCart();
            if ($readProductResult) {
                $cartProduct = $readProductResult->fetch_object();
            }
        } else {
            header('location:errors/404.php');
            die;
        }
    } else {
        header('location:errors/404.php');
        die;
    }
} else {
    header('location:errors/404.php');
    die;
}
if ($_POST) {
    if (isset($_POST['qty'])) {
        if ($_POST['qty'] > $cartProduct->quantity) {
            $qtyLimit = "<div class='alert alert-danger w-50'>Quantity limit $cartProduct->quantity </div>";
        }
        if ($_POST['qty'] <= 0) {
            $qtyLimit = "<div class='alert alert-danger'>Less Quentity 1</div>";
        }
        if (empty($qtyLimit)) {
            $edit = $cartObject->setQuantity($_POST['qty'])->setId($_GET['editcart']);
            $editeResult = $edit->update();
            if (isset($editeResult)) {
                header('location:cart-page.php');
                die;
            }
        }
    }
}


?>

<!-- shopping-cart-area start -->
<div class="cart-main-area ptb-100">
    <div class="container">
        <h3 class="page-title">Your cart items</h3>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                <form method="post">
                    <div class="table-content table-responsive wishlist">
                        <table>
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Product Name</th>
                                    <th>Until Price</th>
                                    <th>Qty</th>
                                    <!-- <th>Subtotal</th> -->
                                    <th>Add To Cart</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="product-thumbnail">
                                        <div class="row">
                                            <img src="assets/img/product/<?= $cartProduct->image ?>" alt="" class="col-12 offset-2">
                                        </div>
                                    </td>
                                    <td class="product-name"><a href="#"><?= $cartProduct->name_en ?></a></td>
                                    <td class="product-price-cart"><span class="amount">$<?= $cartProduct->price ?></span></td>
                                    <form method="post">
                                        <td class="product-quantity">
                                            <div class="pro-dec-cart">
                                                <input type="number" name="qty" class="cart-plus-minus-box" id="qty" aria-describedby="helpId" value="<?= $cartProduct->cart_quantity ?>">
                                            </div>
                                        </td>
                                        <!-- <td class="product-subtotal">$110.00</td> -->
                                        <td class="product-wishlist-cart">
                                            <button type="submit" class="btn btn-success rounded">ADD TO CART</button>
                                        </td>
                                    </form>
                                    <?=isset($qtyLimit)?$qtyLimit:'';?>
                                </tr>
                            </tbody>
                        </table>
                       
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
include_once "layout/footer.php";
include_once "layout/scripts.php";
?>