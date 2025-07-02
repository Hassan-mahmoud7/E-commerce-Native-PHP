<?php
$title = "Finish buying";
include_once 'layout/header.php';
include_once 'app/middleware/auth.php';
include_once 'layout/nav.php';
include_once 'layout/breadcrumb.php';
spl_autoload_register(function ($class) {
    include "app/database/models/" . $class . ".php";
});

$cratObject = new Carts;
$cartResult = $cratObject->setUser_id($_SESSION['user']->id)->getProductInCart();
if (isset($cartResult)) {
    $carts = $cartResult->fetch_all(MYSQLI_ASSOC);
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
// $dateNow = date("Y-m-d",strtotime('now')); echo '<br>';
// $date=date_create($dateNow);
// date_add($date,date_interval_create_from_date_string("$addDay days"));
// $dateDelivre = date_format($date,"Y-m-d");
if ($_POST) {
    if (isset($_POST['order_creat'])) {
        $addDay = 4;
        $dateDelivre = date("Y-m-d", strtotime("+$addDay days"));
        $orderObject = new Order;
        $getOrderNumber = $orderObject->getOrderNum();
        $number = $getOrderNumber->fetch_object();
        $addNewNumber = ++$number->order_number;
        $orderObject->setOrder_number($addNewNumber)->setStatus(1);
        $orderObject->setPrice($_SESSION['total_price']);
        $orderObject->setTotal_price($_SESSION['total']);
        $orderObject->setDelivre_date($dateDelivre);
        $orderObject->setAddress_id($address->id);
        $orderObject->setUser_id($_SESSION['user']->id);
        $orderResult = $orderObject->create();
        if ($orderResult) {
            // echo "<div class='alert alert-success'>tam ad5al pnagh</div>";
            header('location:purchase-completed.php');
        } if(empty($orderResult)) {
            echo "<div class='alert alert-danger'>something wrong please try again later </div>";
        }
    }
}

?>

<div class="container mt-5">
    <div class="col-6 mb-4 row">
        <h3 class="h3 text-success col-4 ">My Address</h3>
        <a href="my-account.php?adrs=address" class="btn btn-warning rounded col-2">Edit</a>

        <hr class="hrcoler mt-0 col-6">
    </div>
    <?php
    // foreach ($addresses as $index => $address) {
    ?>
    <p> City :- <?= $region->city_name_en ?></p>
    <p> Regoin :- <?= $address->regoin_name_en ?></p>
    <p> Address :- <?= $address->address ?></p>
    <p> Street :- <?= $address->street ?></p>
    <p> Building :- <?= $address->building ?></p>
    <p> Floor :- <?= $address->floor ?></p>
    <p> Flat :- <?= $address->flat ?></p>
    <p> Notes :- <?= $address->notes == null? 'No Notes' : $address->notes ; ?></p>

    <?php
    // }
    ?>
    <hr class="hrcoler">
    <div class="grid-list-product-wrapper col-7">
        <div class="col-12 mb-4 row">
            <h3 class="h3 text-success col-4">My Products</h3>
            <a href="cart-page.php" class="btn btn-warning rounded col-2">Edit</a>
            <hr class="hrcoler mt-0 col-6">
        </div>

        <?php
        $totalPrice = 0;
        foreach ($carts as $index => $cart) {
            $subTotal = $cart['cart-quantity'] *  $cart['price']
        ?>

            <div class="product-list product-view pb-20">
                <div class="row">
                    <div class="product-width col-xl-4 col-lg-2 col-md-4 col-sm-6 col-12 mb-30">
                        <div class="product-wrapper col-6">
                            <div class="product me-2 col-xl-4 col-lg-2 col-md-4 col-sm-6 col-12 mb-30">
                                <a href="product-details.php?pro=<?= $cart['id'] ?>">
                                    <!-- <img alt="" src="assets/img/product/product-2.jpg" > -->
                                    <figure class="figure">
                                        <img src="assets/img/product/<?= $cart['image'] ?>" class="figure-img img-fluid rounded" alt="...">
                                        <!-- <figcaption class="figure-caption text-end">A caption for the above image.</figcaption> -->
                                    </figure>
                                </a>
                            </div>

                            <div class="product-list-details">
                                <h4>
                                    <a href="product-details.html"><?= $cart['name_en'] ?></a>
                                </h4>
                                <div class="product-price-wrapper">
                                    <span><?=  $subTotal ?></span>
                                    <!-- <span class="product-price-old">$120.00 </span> -->
                                </div>
                                <p>Quantity = <?= $cart['cart-quantity'] ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php
            $totalPrice +=  $subTotal;
        } ?>
    </div>

    <hr class="hrcoler mt-0">
    <div class="col-5 mb-4">
        <h3 class="h3 text-success">Receipt</h3>
        <hr class="hrcoler mt-0 col-4">
        <p class="fs-4"> SubTotal: <span class="text-primary">$<?= $_SESSION['total_price'] = $totalPrice ?> </span>
        </p>
        <p class="fs-4"> Shipping Expenses: <span class="text-primary">$<?= $region->shipping_fees ?> </span></p>
        <p class="fs-4"> Total price: <span class="text-danger">$<?= $_SESSION['total'] = $totalPrice + $region->shipping_fees ?> </span>
        </p>

        <form method="post">
            <button class="btn btn-success rounded mt-5" name="order_creat">Confirmation</button>
        </form>
    </div>
</div>

<?php
include_once "layout/footer.php";
include_once "layout/scripts.php";
?>