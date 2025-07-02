<?php
$title = "Purchase Completed";
include_once 'layout/header.php';
include_once 'app/middleware/auth.php';
include_once 'layout/nav.php';
include_once 'layout/breadcrumb.php';
spl_autoload_register(function ($class) {
    include "app/database/models/" . $class . ".php";
});

$cratObject = new Carts;
$cartResult = $cratObject->setUser_id($_SESSION['user']->id)->getProductInCart();
if (!empty($cartResult)) {
    $carts = $cartResult->fetch_all(MYSQLI_ASSOC);
}else{
    echo "" ;
}

$addressObject = new Address;
$addressResult = $addressObject->setUser_id($_SESSION['user']->id)->read();
if (isset($addressResult)) {
    $address = $addressResult->fetch_object();
}

$regionObject = new Regions;
$regionResult = $regionObject->setId($address->regions_id)->getShippingFees();
if (isset($regionResult)) {
    $region = $regionResult->fetch_object();
}
$orderObject = new Order;
$orderDateRuselt = $orderObject->setAddress_id($address->id)->setStatus(1)->setUser_id($_SESSION['user']->id)->read();
if (!empty($orderDateRuselt)) {
   $orderDate = $orderDateRuselt->fetch_object();
}

// $dateNow = date("Y-m-d",strtotime('now')); echo '<br>';
// $date=date_create($dateNow);
// date_add($date,date_interval_create_from_date_string("$addDay days"));
// $dateDelivre = date_format($date,"Y-m-d");

?>

<div class="container mt-5">
<div class='alert alert-success'>Purchase Completed ; <br> Almost up to you: <?= isset($orderDate->delivre_date)?$orderDate->delivre_date . ' ' . date("D",strtotime($orderDate->delivre_date)):''; ?> <br> 
<p> City :- <?= !empty($region->city_name_en)?$region->city_name_en:''; ?></p>
<p> Regoin :- <?= isset($address->regoin_name_en)?$address->regoin_name_en:''; ?></p>
<p> Address :- <?= $address->address ?></p>
<p class="fs-5"> Total price: <span class="text-primary">$<?= isset($orderDate->total_price)?$orderDate->total_price:''; ?> </span> 

</div>
    <hr class="hrcoler">
    <div class="row">
        <?php
        $totalPrice = 0;
        if (!empty($carts)) {
            
        
        foreach ($carts as $index => $cart) {
        $subTotal = $cart['cart-quantity'] *  $cart['price'];
        ?>
        
            <div class=" col-xl-4 col-lg-2 col-md-4 col-sm-6  mb-30">
            <div class="card mb-3" style="width: 18rem;">
                <img src="assets/img/product/<?= $cart['image'] ?>" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title"><?= $cart['name_en'] ?></h5>
                    <p class="card-text">Quantity = <?= $cart['cart-quantity'] ?></p>
                    <span class="card-text">until Price: $<?= $subTotal ?></span>

                </div>
            </div>
            </div>

        <?php
            $totalPrice += $subTotal;
        }} ?>
    </div>


    <hr class="hrcoler mt-0">
    <div class="col-5 mb-4">
        <!-- <h3 class="h3 text-success">Receipt</h3>
        <hr class="hrcoler mt-0 col-4">
        <p class="fs-4"> Total price: <span class="text-primary">$<?= $_SESSION['total_price'] = $totalPrice ?> </span>
        </p>
        <p class="fs-4"> Shipping Expenses: <span class="text-primary">$<?= $region->shipping_fees ?> </span></p>
        <p class="fs-4"> Total: <span class="text-danger">$<?= $_SESSION['total'] = $total = $totalPrice + $region->shipping_fees ?> </span>
        </p> -->

        <form method="post">
            <a href="index.php" class="btn btn-primary rounded mt-5" >home</a>
            <a href="my-order.php" class="btn btn-success rounded mt-5" >My Order</a>
        </form>
    </div>
</div>

<?php
include_once "layout/footer.php";
include_once "layout/scripts.php";
?>