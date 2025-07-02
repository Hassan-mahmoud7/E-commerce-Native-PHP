<?php
$title = "MY ORDER";
include_once 'layout/header.php';
include_once 'app/middleware/auth.php';
include_once 'layout/nav.php';
include_once 'layout/breadcrumb.php';
spl_autoload_register(function ($class) {
    include "app/database/models/" . $class . ".php";
});


$cartObject = new Carts;
$orderObject = new Order;
$productObject = new Product;

if (isset($_GET["order"])) {
      $productQtyResult = $productObject->setId($_GET["pro"])->getQntiyProduct();
        if (isset($productQtyResult)) {
            $productQty = $productQtyResult->fetch_object();
          $newQnty = $productQty->quantity + $_GET['proqty'];
          $productObject->setId($_GET["pro"])->getQntiyProduct();
          $productObject->setQuantity($newQnty)->setId($_GET["pro"])->UpdateQuantity();
          $delete = $cartObject->setId($_GET["order"]);
          $delete->destroy();
        }
}
if (isset($_GET['user'])) {
  if ($_GET['user'] == $_SESSION['user']->id) {
     $deleteAll = $cartObject->setUser_id($_GET['user']);
    $addressObject = new Address;
    $AddressResult = $addressObject->setUser_id($_SESSION['user']->id)->read();
   if (!empty($AddressResult)) {
      $address = $AddressResult->fetch_object();
       $orderObject->setAddress_id($address->id)->setUser_id($_GET['user']);
        $orderObject->delete();}
    $deleteAll->delete();
    $message = "<div class='alert alert-warning'>All products have been deleted. If you want to shop again,<a href='shop.php' class='text-success'>click here</a> </div>";
  }else {
    header('location:errors/404.php');
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
        <h3 class="page-title">My Order</h3>
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
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (isset($cartProducts)) {
                                    foreach ($cartProducts as $index => $cartProduct) { 
                                        $subTotal = $cartProduct['cart-quantity'] * $cartProduct['price'];
                                        $cartId = $cartProduct['cart_id'];
                                        
                                     ?>
                                     <tr>
                                         <td class="product-thumbnail">
                                             <div class="row">
                                             <img src="assets/img/product/<?=$cartProduct['image']?>" alt="" class="col-12 offset-2">
                                             </div>
                                         </td>
                                         <td class="product-name"><a href="#"><?= $cartProduct['name_en'] ?> </a></td>
                                         <td class="product-price-cart"><span class="amount">$<?= $cartProduct['price'] ?></span></td>
                                         <td class="product-quantity">
                                             <div class="pro-dec-cart alert alert-success">
                                                <?= $cartProduct['cart-quantity'] ?>
                                         </td>
                                         <td class="product-subtotal">$<?= $subTotal?></td>
                                         <td class="product-remove">
                                            
                                            
                                             
                                             <!-- class="border-0 bg-transparent" -->
                                            
                                        </td>
                                        
                                    </tr>
                                    
                                    <?php   
                                    $totalProduct += $subTotal ;
                                    }
                                    
                                }
                                
                                ?>
                              
                            </tbody>
                            <?= isset($message)?$message:'';?>
                        </table>
                    </div>                  
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="cart-shiping-update-wrapper d-flex justify-content-around">
                                
                                <div class="cart-clear ">
                                    <a href="my-order.php?user=<?=$_SESSION['user']->id?>">Cancel Order</a>
                                </div>
                                <h5 class="p-3 mb-2 bg-primary text-white">Total products <span>$<?= "$totalProduct" ?></span></h5>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="row">
                  
                </div>
            </div>
        </div>
    </div>
</div>


<?php
}else {
    echo"<div class='alert alert-warning mt-2'>There are no products yet. If you want to shop again,<a href='shop.php' class='text-success'>click here</a> </div>";
}
include_once "layout/footer.php";
include_once "layout/scripts.php";
?>