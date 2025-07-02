<?php
$title = "Product Singel";
include_once 'layout/header.php';
include_once 'layout/nav.php';
include_once 'layout/breadcrumb.php';
spl_autoload_register(function ($class) {
    include "app/database/models/" . $class . ".php";
});
if (isset($_POST['add-review'])) {
    $reviewObject = new Review;
    $reviewObject->setValue($_POST['value']);
    $reviewObject->setComment($_POST['comment']);
    $reviewObject->setProduct_id($_GET['pro']);
    $reviewObject->setUSer_id($_SESSION['user']->id);
    $reviewResult = $reviewObject->create();
    if ($reviewResult) {
        $reviewMessage = "<div class='alert alert-success'> Thank You For Review. </div>";
    } else {
        $reviewMessage = "<div class='alert alert-denger'> Try Again Later. </div>";
    }
}
if ($_GET) {
    if ($_GET['pro']) {
        if (is_numeric($_GET['pro'])) {
            $productObject = new Product;
            $productObject->setId($_GET['pro']);
            $productObject->setStatus(1);
            $productObjectResult = $productObject->readByid();
            if ($productObjectResult) {
                $product = $productObjectResult->fetch_object();
                $RelatedSub = $productObject->setSubcategory_id($product->subcategory_id);
                $RelatedSubResult = $RelatedSub->RelatedProducts();
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
} else {
    header('location:errors/404.php');
    die;
}
if (isset($_POST['add_cart'])) {
    if (!isset($_SESSION['user'])) {
        header("location:login.php");
    }
    if (isset($_SESSION['user'])) {
       
        if (isset($_POST['qtybtn'])) {
            if ($_POST['qtybtn'] > $product->quantity) {
                $qtyLimit = "<div class='alert alert-danger'>Quantity limit $product->quantity </div>";
            }
            if ($_POST['qtybtn'] <= 0) {
                $qtyLimit = "<div class='alert alert-danger'>Less Quentity 1</div>";
            }
            if (empty($qtyLimit)) {

                $cartObject = new Carts;
                $newQty = $product->quantity - $_POST['qtybtn'] ;
                $productObject->setQuantity($newQty)->setId($product->id)->UpdateQuantity();
                $insirtCart = $cartObject->setProduct_id($product->id)->setUser_id($_SESSION['user']->id)->setQuantity($_POST['qtybtn']);
                $insirtCart->create();
                header("location:cart-page.php");
                die;
            }
        }
    }
}





?>

<div>
    <style>
        * {
            margin: 0;
            padding: 0;
        }

        .rate {
            float: left;
            height: 46px;
            padding: 0 10px;
        }

        .rate:not(:checked)>input {
            position: absolute;
            top: -9999px;
        }

        .rate:not(:checked)>label {
            float: right;
            width: 1em;
            overflow: hidden;
            white-space: nowrap;
            cursor: pointer;
            font-size: 30px;
            color: #ccc;
        }

        .rate:not(:checked)>label:before {
            content: '★ ';
        }

        .rate>input:checked~label {
            color: #ffc700;
        }

        .rate:not(:checked)>label:hover,
        .rate:not(:checked)>label:hover~label {
            color: #deb217;
        }

        .rate>input:checked+label:hover,
        .rate>input:checked+label:hover~label,
        .rate>input:checked~label:hover,
        .rate>input:checked~label:hover~label,
        .rate>label:hover~input:checked~label {
            color: #c59b08;
        }

        /* Modified from: https://github.com/mukulkant/Star-rating-using-pure-css */
    </style>
</div>
<!-- Product Deatils Area Start -->
<div class="product-details pt-100 pb-95">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-12">
                <div class="product-details-img">
                    <img class="zoompro" src="assets/img/product/<?= $product->image ?>" data-zoom-image="assets/img/product/<?= $product->image ?>" alt="zoom" />
                    <!-- <div id="gallery" class="mt-20 product-dec-slider owl-carousel">
                        <a data-image="assets/img/product-details/product-detalis-l1.jpg"
                            data-zoom-image="assets/img/product-details/product-detalis-bl1.jpg">
                            <img src="assets/img/product-details/product-detalis-s1.jpg" alt="">
                        </a>
                        <a data-image="assets/img/product-details/product-detalis-l2.jpg"
                            data-zoom-image="assets/img/product-details/product-detalis-bl2.jpg">
                            <img src="assets/img/product-details/product-detalis-s2.jpg" alt="">
                        </a>
                        <a data-image="assets/img/product-details/product-detalis-l3.jpg"
                            data-zoom-image="assets/img/product-details/product-detalis-bl3.jpg">
                            <img src="assets/img/product-details/product-detalis-s3.jpg" alt="">
                        </a>
                        <a data-image="assets/img/product-details/product-detalis-l4.jpg"
                            data-zoom-image="assets/img/product-details/product-detalis-bl4.jpg">
                            <img src="assets/img/product-details/product-detalis-s4.jpg" alt="">
                        </a>
                        <a data-image="assets/img/product-details/product-detalis-l5.jpg"
                            data-zoom-image="assets/img/product-details/product-detalis-bl5.jpg">
                            <img src="assets/img/product-details/product-detalis-s5.jpg" alt="">
                        </a>
                        <a data-image="assets/img/product-details/product-detalis-l2.jpg"
                            data-zoom-image="assets/img/product-details/product-detalis-bl2.jpg">
                            <img src="assets/img/product-details/product-detalis-s2.jpg" alt="">
                        </a>
                    </div> -->
                    <!-- <span>-29%</span> -->
                </div>
            </div>
            <div class="col-lg-6 col-md-12">
                <div class="product-details-content">
                    <h4><?= $product->name_en ?></h4>
                    <div class="rating-review">
                        <div class="pro-dec-rating">
                            <?php
                            for ($i = 1; $i <= 5; $i++) {
                                if ($i <= $product->reviews_avg) {
                            ?>
                                    <i class="ion-android-star-outline theme-star"></i>
                                <?php
                                } else {
                                ?>
                                    <i class="ion-android-star-outline"></i>
                            <?php
                                }
                            }
                            ?>
                        </div>
                        <div class="pro-dec-review">
                            <ul>
                                <li><?= $product->reviews_count ?> Reviews </li>
                                <li> Add Your Reviews</li>
                            </ul>
                        </div>
                    </div>
                    <span><?= $product->price ?> EGP</span>
                    <!--//////////   ADD TO CART    //////// -->
                    <form action="" method="post" class="mt-2 mb-4">
                        <?php
                        if ($product->quantity == 0) {
                            $message = "out of stock";
                            $color = "danger"; ?>


                        <?php
                        } elseif ($product->quantity >= 1 && $product->quantity <= 5) {
                            $message = "In stock";
                            $color = "warning";
                        } else {
                            $message = "In stock";
                            $color = "success";
                        }

                        ?>
                        <?php if ($product->quantity == 0) {
                            echo "";
                        } else {
                            $cart = "+ Add to cart";

                        ?>
                            <button name="add_cart" class="border-0 bg-transparent-success-text">
                                <span class="h4 text-<?= $color ?>">
                                    <!-- <a class="text-" href=""> -->
                                    <?= $cart ?>
                                    <i class="ti-shopping-cart text-<?= $color ?>"></i>
                                    <!-- </a> -->
                                </span>
                            </button>
                        <?php
                        } ?>
                        <div class="quality-add-to-cart">
                            <!--////////// END  ADD TO CART    //////// -->
                            <div class="quality">
                                <label>Qty:</label>
                                <input class="cart-plus-minus-box" type="number" name="qtybtn" value="1">
                            </div>
                            <!-- <div class="shop-list-cart-wishlist">
                            <a title="Add To Cart" href="#">
                                <i class="icon-handbag"></i>
                            </a>
                            <a title="Wishlist" href="#">
                                <i class="icon-heart"></i>
                            </a>
                        </div> -->
                        </div>
                    </form>
                    <?= isset($qtyLimit) ? $qtyLimit : ""; ?>

                    <div class="in-stock">
                        <p>Available: <span class="text-<?= $color ?>"><?= $message ?></span></p>
                    </div>
                    <p><?= $product->desc_en ?> </p>


                    <div class="pro-dec-categories">
                        <ul>
                            <li class="categories-title"><a href="shop.php?cat=<?= $product->category_id ?>&page=1"><?= $product->category_name_en ?>,</a>
                            </li>
                            <li><a href="shop.php?sub=<?= $product->subcategory_id ?>&page=1"><?= $product->subcategory_name_en ?>,</a>
                            </li>
                            <li><a href="shop.php?brand=<?= $product->brand_id ?>&page=1"><?= $product->brand_name_en ?>, </a>
                            </li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- Product Deatils Area End -->
<div class="description-review-area pb-70">
    <div class="container">
        <div class="description-review-wrapper">
            <div class="description-review-topbar nav text-center">
                <a class="active" data-toggle="tab" href="#des-details1">Description</a>
                <a data-toggle="tab" href="#des-details3">Review</a>
            </div>
            <div class="tab-content description-review-bottom">
                <div id="des-details1" class="tab-pane active">
                    <div class="product-description-wrapper">
                        <p> <?= $product->desc_en ?> </p>

                    </div>
                </div>

                <div id="des-details3" class="tab-pane">
                    <div class="rattings-wrapper">
                        <?php
                        $reviewsResult = $productObject->getReviews();
                        if ($reviewsResult) {
                            $reviews = $reviewsResult->fetch_all(MYSQLI_ASSOC);
                            foreach ($reviews as $index => $review) {
                        ?>
                                <div class="sin-rattings">
                                    <div class="star-author-all">
                                        <div class="ratting-star f-left">
                                            <?php
                                            for ($i = 1; $i <= 5; $i++) {
                                                if ($i <= $review['value']) {
                                            ?>
                                                    <i class="ion-star theme-color"></i>
                                                <?php
                                                } else {
                                                ?>
                                                    <i class="ion-android-star-outline"></i>
                                            <?php
                                                }
                                            }
                                            ?>

                                            <span>(<?= $review['value'] ?>)</span>
                                        </div>
                                        <div class="ratting-author f-right">
                                            <h3><?= $review['full_name'] ?></h3>
                                            <span><?= $review['created-at'] ?></span>

                                        </div>
                                    </div>
                                    <p><?= $review['comment'] ?></p>
                                </div>
                        <?php
                            }
                        } else {
                            echo "<div class='alert alert-warning text-center'>No Reviews Yet </div>";
                        }
                        ?>


                    </div>
                    <?php
                    if (isset($_SESSION['user'])) {
                    ?>
                        <?php
                        if (isset($reviewMessage)) {
                            echo $reviewMessage;
                        }
                        ?>
                        <div class="ratting-form-wrapper">
                            <h3>Add your Comments :</h3>
                            <div class="ratting-form">
                                <form action="#" method="post">
                                    <div class="">
                                        <h2>Rating:</h2>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="rate">
                                                <input type="radio" id="star5" name="value" value="5" />
                                                <label for="star5" title="text">5 stars</label>
                                                <input type="radio" id="star4" name="value" value="4" />
                                                <label for="star4" title="text">4 stars</label>
                                                <input type="radio" id="star3" name="value" value="3" />
                                                <label for="star3" title="text">3 stars</label>
                                                <input type="radio" id="star2" name="value" value="2" />
                                                <label for="star2" title="text">2 stars</label>
                                                <input type="radio" id="star1" name="value" value="1" />
                                                <label for="star1" title="text">1 star</label>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="rating-form-style form-submit">
                                                <textarea name="comment" placeholder="Comment"></textarea>
                                                <input type="submit" name="add-review" value="add review">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="product-area pb-100">
    <div class="container">
        <div class="product-top-bar section-border mb-35">
            <div class="section-title-wrap">
                <h3 class="section-title section-bg-white">Related Products</h3>
            </div>
        </div>
        <div class="row">
            <?php
            if (!empty($RelatedSubResult)) {
                $RelatedPros = $RelatedSubResult->fetch_all(MYSQLI_ASSOC);
                foreach ($RelatedPros as $sub => $RelatedPro) {
            ?>
                    <div class="col-md-3">
                        <div class="product-img">
                            <a href="product-details.php?pro=<?= $RelatedPro['id'] ?>">
                                <img alt="" src="assets/img/product/<?= $RelatedPro['image'] ?>">
                            </a>

                            <div class="product-action">
                                <a class="action-wishlist" href="#" title="Wishlist">
                                    <i class="ion-android-favorite-outline"></i>
                                </a>
                                <a class="action-cart" href="#" title="Add To Cart">
                                    <i class="ion-ios-shuffle-strong"></i>
                                </a>
                                <a class="action-compare" href="#" data-target="#exampleModal" data-toggle="modal" title="Quick View">
                                    <i class="ion-ios-search-strong"></i>
                                </a>
                            </div>
                        </div>
                        <div class="product-content text-left">
                            <div class="product-hover-style">
                                <div class="product-title">
                                    <h4>
                                        <a href="product-details.php?pro=<?= $RelatedPro['id'] ?>"><?= $RelatedPro['name_en'] ?></a>
                                    </h4>
                                </div>
                                <div class="cart-hover">
                                    <h4><a href="product-details.php?pro=<?= $RelatedPro['id'] ?>">+ Add to cart</a></h4>
                                </div>
                            </div>
                            <div class="product-price-wrapper">
                                <span><?= $RelatedPro['price'] ?> EGP</span>
                                <!-- <span class="product-price-old">$120.00 </span> -->
                            </div>
                        </div>
                    </div>
            <?php }
            } ?>
        </div>
    </div>
</div>


<?php
include_once "layout/footer.php";
include_once "layout/scripts.php";
?>