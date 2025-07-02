<?php
$title = "shop";
include_once 'layout/header.php';
include_once 'layout/nav.php';
include_once 'layout/breadcrumb.php';
spl_autoload_register(function ($class) {

    include "app/database/models/" . $class . ".php";
});

$productObject = new Product;
$productObject->setStatus(1);
$limit = 10;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $limit;

if ($_GET) {
    if (isset($_GET['sub']) && isset($_GET['page'])) {
        if (is_numeric($_GET['sub'])) {
            $subcategoryObject->setId($_GET['sub']);
            $subResult = $subcategoryObject->getSubById();
            if ($subResult) {
                $productObject->setSubcategory_id($_GET['sub']);
                $productObjectResult = $productObject->setLimit($limit)->setOffset($offset)->readBySub();
                $productObjectPriceResult = $productObject->setSubcategory_id($_GET['sub'])->maxPriceAndMinPrice();
                if (isset($productObjectPriceResult)) {
                    $filterPrice = $productObjectPriceResult->fetch_object();
                }
                $totalProducts = $filterPrice->total;
                $totalPages = ceil($totalProducts / $limit);
            } else {
                // header('location:errors/404.php');
                die;
            }
        } else {
            // header('location:errors/404.php');
            die;
        }
    } elseif (isset($_GET['cat'])) {
        if (is_numeric($_GET['cat']) && isset($_GET['page'])) {
            $categoryObject->setId($_GET['cat']);
            $catResult = $categoryObject->getCatById();
            if ($catResult) {
                $productObject->setCategory_id($_GET['cat']);
                $productObjectResult = $productObject->setLimit($limit)->setOffset($offset)->readBycat();
                $productObjectPriceResult = $productObject->setCategory_id($_GET['cat'])->maxPriceAndMinPrice();
                if (isset($productObjectPriceResult)) {
                    $filterPrice = $productObjectPriceResult->fetch_object();
                }
                $totalProducts = $filterPrice->total;
                $totalPages = ceil($totalProducts / $limit);
            } else {
                header('location:errors/404.php');
                die;
            }
        } else {
            header('location:errors/404.php');
            die;
        }
    } elseif (isset($_GET['brand'])) {
        if (is_numeric($_GET['brand']) && isset($_GET['page'])) {
            $barndObject = new Brand;
            $barndObject->setId($_GET['brand']);
            $barndObject->setStatus(1);
            $brandResult = $barndObject->getBrandById();
            if ($brandResult) {
                $productObject->setBrand_id($_GET['brand']);
                $productObjectResult = $productObject->setLimit($limit)->setOffset($offset)->readByIdBrand();
                $productObjectPriceResult = $productObject->setBrand_id($_GET['brand'])->maxPriceAndMinPrice();
                if (isset($productObjectPriceResult)) {
                    $filterPrice = $productObjectPriceResult->fetch_object();
                }
                $totalProducts = $filterPrice->total;
                $totalPages = ceil($totalProducts / $limit);
            } else {
                header('location:errors/404.php');
                die;
            }
        } else {
            header('location:errors/404.php');
            die;
        }
    } elseif (isset($_GET['search']) || isset($_GET['page'])) { //  why must put &&  instead of || 
        $stringArray = str_split($_GET['search']);
        $search = '';
        foreach ($stringArray as $key => $searchs) {
            $search .= $searchs . '%';
        }
        $productObjectResult = $productObject->setLimit($limit)->setOffset($offset)->setName_en($search)->search();
        if (empty($productObjectResult)) {
            $messageSearch = "<div class='alert alert-secondary'> Sorry i can't find this : {$_GET['search']}</div>";
        }
        $productObjectPriceResult = $productObject->setName_en($search)->maxPriceAndMinPrice();
        if (isset($productObjectPriceResult)) {
            $filterPrice = $productObjectPriceResult->fetch_object();
        }
        $totalProducts = $filterPrice->total;
        $totalPages = ceil($totalProducts / $limit);
    } elseif (isset($_GET['page']) && is_numeric($_GET['page'])) {
        // $start = 0 ;
        // $rowPrePage = 3;
        // $productObjectResults = $productObject->read();
        // $num_rows = mysqli_num_rows($productObjectResults);
        // $pages = ceil($num_rows / $rowPrePage);
        // if (isset($_GET['page'])) {


        $productObjectResult = $productObject->readPagination($limit, $offset);
        $productObjectPriceResult = $productObject->maxPriceAndMinPrice();
        if (isset($productObjectPriceResult)) {
            $filterPrice = $productObjectPriceResult->fetch_object();
        }
        if (isset($_POST['min_price']) && isset($_POST['max_price'])) {
            $totalProducts = $productObject->countProducts($_POST['min_price'], $_POST['max_price']);
        } else {
            $totalProducts = $productObject->countProducts($filterPrice->min_price, $filterPrice->max_price);
        }
        
        $totalPages = ceil($totalProducts / $limit);
    } else {
        // header('location:errors/404.php');
        // die;
    }
} else {
    $productObjectResult = $productObject->maxPriceAndMinPrice();
    if (isset($productObjectResult)) {
        $filterPrice = $productObjectResult->fetch_object();
    }
    if (isset($productObjectResult)) {
        $productObjectResult = $productObject->readPagination($limit, $offset);
        if (isset($_POST['min_price']) && isset($_POST['max_price'])) {
            $totalProducts = $productObject->countProducts($_POST['min_price'], $_POST['max_price']);
        } if (!isset($_POST['min_price']) && !isset($_POST['max_price'])) {
         
            $totalProducts = $productObject->countProducts($filterPrice->min_price, $filterPrice->max_price);
        }
        $totalPages = ceil($totalProducts / $limit);
    }
}
if (isset($_POST['min_price']) && isset($_POST['max_price'])) {


    if (isset($_GET['sub']) && isset($_GET['page'])) {

        $productObjectResult = $productObject->setSubcategory_id($_GET['sub'])->setLimit($limit)->setOffset($offset)->searchRangeByGet($_POST['min_price'], $_POST['max_price']);
        $totalProducts = $productObject->setSubcategory_id($_GET['sub'])->countProducts($_POST['min_price'], $_POST['max_price']);
        $totalPages = ceil($totalProducts / $limit); 

    } elseif (isset($_GET['brand']) && isset($_GET['page'])) {
        $productObjectResult = $productObject->setBrand_id($_GET['brand'])->setLimit($limit)->setOffset($offset)->searchRangeByGet($_POST['min_price'], $_POST['max_price']);
        $totalProducts = $productObject->setBrand_id($_GET['brand'])->countProducts($_POST['min_price'], $_POST['max_price']);
        $totalPages = ceil($totalProducts / $limit);
    } elseif (isset($_GET['cat']) && isset($_GET['page'])) {
        $productObjectResult = $productObject->setCategory_id($_GET['cat'])->setLimit($limit)->setOffset($offset)->searchRangeByGet($_POST['min_price'], $_POST['max_price']);
        $totalProducts = $productObject->setCategory_id($_GET['cat'])->countProducts($_POST['min_price'], $_POST['max_price']);
        $totalPages = ceil($totalProducts / $limit);
        // search
    } elseif (isset($_GET['search']) || isset($_GET['page'])) {
        $productObjectResult = $productObject->setName_en($search)->setLimit($limit)->setOffset($offset)->searchRangeByGet($_POST['min_price'], $_POST['max_price']);
        $totalProducts = $productObject->setName_en($search)->countProducts($_POST['min_price'], $_POST['max_price']);
        $totalPages = ceil($totalProducts / $limit);
    } elseif(isset($_GET['page'])){
     $productObjectResult = $productObject->setLimit($limit)->setOffset($offset)->searchRangeByGet($_POST['min_price'],$_POST['max_price']);
     $totalProducts = $productObject->countProducts($_POST['min_price'], $_POST['max_price']);
     $totalPages = ceil($totalProducts / $limit);
    }else{
        $productObjectResult = $productObject->setLimit($limit)->setOffset($offset)->searchRangeByGet($_POST['min_price'],$_POST['max_price']);
        $totalProducts = $productObject->countProducts($_POST['min_price'], $_POST['max_price']);
        $totalPages = ceil($totalProducts / $limit);
    }
    // $start = 0 ;
    // $rowPrePage = 3;
    // $productObjectResults =  $productObject->read();
    // if (!empty( $productObjectResults)) {

    //     $num_rows = mysqli_num_rows($productObjectResults);
    // }
    // $pages = ceil($num_rows / $rowPrePage);
    // if (isset($_GET['page'])) {

    //     $page = $_GET['page'] ;
    //     $start = ($page - 1) * $rowPrePage;
    // }
    // $productObjectResult = $productObject->searchRange($_POST['min_price'],$_POST['max_price'],$limit, $offset);
    // }
    //    }
    if (empty($productObjectResult)) {
        $messageFilter = "<div class='alert alert-secondary'>There is no product in between {$_POST['min_price']} And {$_POST['max_price']} </div>";
    }
}
function unKnowGet($Get)
{
    if (isset($_GET['sub']) && $Get = $_GET['sub']) {
        $Get = 'sub=' . $_GET['sub'] . '&';
    } elseif (isset($_GET['cat']) && $Get = $_GET['cat']) {
        $Get = 'cat=' . $_GET['cat'] . '&';
    } elseif (isset($_GET['brand']) && $Get = $_GET['brand']) {
        $Get = 'brand=' . $_GET['brand'] . '&';
    } elseif (isset($_GET['search']) && $Get = $_GET['search']) {
        $Get = 'search=' . $_GET['search'] . '&';
    } else {
        $Get = '';
    }
    return $Get;
}
//   echo unKnowGet($_GET);die;

?>
<style>
/* Price Range slider */
.price-range-block {
    margin: 2% 0%;
}

.ui-slider-horizontal {

    width: 100%;
}

.ui-widget-header {
    background: #5ca520;
}

.price-range-field {
    width: 30%;
    min-width: 16%;
    background-color: #f9f9f9;
    border: 1px solid #6e6666;
    color: black;
    font-family: myFont;
    font: normal 14px Arial, Helvetica, sans-serif;
    border-radius: 5px;
    height: 26px;
    padding: 5px;
}

.search-results-block {
    position: relative;
    display: block;
    clear: both;
}
</style>
<!-- Shop Page Area Start -->
<div class="shop-page-area ptb-100">
    <div class="container">
        <div class="row flex-row-reverse">
            <div class="col-lg-9">
                <div class="shop-topbar-left">
                    <div class="shop-topbar-wrapper">
                        <ul class="view-mode">
                            <li class="active"><a href="#product-grid" data-view="product-grid"><i
                                        class="fa fa-th"></i></a></li>
                            <li><a href="#product-list" data-view="product-list"><i class="fa fa-list-ul"></i></a></li>
                        </ul>
                        <p>Showing <?= $offset + 1 ?> - <?= min($offset + $limit, $totalProducts) ?> of
                            <?= $totalProducts ?> results </p>
                    </div>
                    <!-- <div class="product-sorting-wrapper">
                        <div class="product-shorting shorting-style">
                            <label>View:</label>
                            <select>
                                <option value=""> 20</option>
                                <option value=""> 23</option>
                                <option value=""> 30</option>
                            </select>
                        </div>
                        <div class="product-show shorting-style">
                            <label>Sort by:</label>
                            <select>
                                <option value="">Default</option>
                                <option value=""> Name</option>
                                <option value=""> price</option>
                            </select>
                        </div>
                    </div> -->
                </div>
                <div class="grid-list-product-wrapper" id="searchRange">
                    <div class="product-grid product-view pb-20">
                        <div class="row">
                            <?php

                            if (isset($messageSearch)) {
                                echo $messageSearch;
                            }
                            if (isset($messageFilter)) {
                                echo $messageFilter;
                            }
                            if (!empty($productObjectResult)) {
                                $id = 0;
                                $products = $productObjectResult->fetch_all(MYSQLI_ASSOC);
                                // print_r($products);die;
                                foreach ($products as $index => $product) {
                            ?>
                            <div class="product-width col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 mb-30"
                                id="searchRange">
                                <div class="product-wrapper">
                                    <div class="product-img">
                                        <a href="product-details.php?pro=<?= $product['id'] ?>">
                                            <img loading="lazy" alt="" src="assets/img/product/<?= $product['image'] ?>" style="height: 300px;">
                                        </a>
                                        <!-- <span>-30%</span> -->
                                        <div class="product-action">
                                            <a class="action-wishlist" href="#" title="Wishlist">
                                                <i class="ion-android-favorite-outline"></i>
                                            </a>
                                            <a class="action-cart" href="#" title="Add To Cart">
                                                <i class="ion-ios-shuffle-strong"></i>
                                            </a>
                                            <a class="action-compare" href="#" data-target="#exampleModal"
                                                data-toggle="modal" title="Quick View">
                                                <i class="ion-ios-search-strong"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="product-content text-left">
                                        <div class="product-hover-style">
                                            <div class="product-title">
                                                <h4>
                                                    <a
                                                        href="product-details.php?pro=<?= $product['id'] ?>"><?= $product['name_en'] ?></a>
                                                </h4>
                                            </div>
                                            <div class="cart-hover">
                                                <h4><a href="product-details.php?pro=<?= $product['id'] ?>">+ Add to
                                                        cart</a></h4>
                                            </div>
                                        </div>
                                        <div class="product-price-wrapper">
                                            <span><?= $product['price'] ?></span>
                                            <!-- <span class="product-price-old">$120.00 </span> -->
                                        </div>
                                    </div>
                                    <div class="product-list-details">
                                        <h4>
                                            <a
                                                href="product-details.php?pro=<?= $product['id'] ?>"><?= $product['name_en'] ?></a>
                                        </h4>
                                        <div class="product-price-wrapper">
                                            <span><?= $product['price'] ?></span>
                                            <!-- <span class="product-price-old">$120.00 </span> -->
                                        </div>
                                        <p><?= $product['desc_en'] ?></p>
                                        <div class="shop-list-cart-wishlist">
                                            <a href="#" title="Wishlist"><i
                                                    class="ion-android-favorite-outline"></i></a>
                                            <a href="#" title="Add To Cart"><i class="ion-ios-shuffle-strong"></i></a>
                                            <a href="#" data-target="#exampleModal" data-toggle="modal"
                                                title="Quick View">
                                                <i class="ion-ios-search-strong"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php

                                }
                            }

                            ?>
                        </div>
                    </div>
                    <div class="pagination-total-pages">
                        <div class="pagination-style">
                            <ul>
                                <?php if ($page > 1) : ?>
                                <li><a class="prev-next prev" href="?<?= unKnowGet($_GET) ?>page=<?= $page - 1 ?>"><i
                                            class="ion-ios-arrow-left"></i> Prev</a></li>
                                <?php endif; ?>
                                <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                                <li><a class="<?= $i == $page ? 'active' : '' ?>"
                                        href="?<?= unKnowGet($_GET) ?>page=<?= $i ?>"><?= $i ?></a></li>
                                <?php endfor; ?>
                                <?php if ($page < $totalPages) : ?>
                                <li><a class="prev-next next"
                                        href="?<?= unKnowGet($_GET) ?>page=<?= $page + 1 ?>">Next<i
                                            class="ion-ios-arrow-right"></i> </a></li>
                                <?php endif; ?>
                            </ul>
                        </div>

                        <div class="total-pages">
                            <p>Showing <?= $offset + 1 ?> - <?= min($offset + $limit, $totalProducts) ?> of
                                <?= $totalProducts ?> results </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="shop-sidebar-wrapper gray-bg-7 shop-sidebar-mrg">
                    <div class="shop-widget">
                        <h4 class="shop-sidebar-title">Shop By Categories</h4>
                        <div class="shop-catigory">
                            <ul id="faq">
                                <?php
                                if (!empty($categoriesResult)) {
                                    foreach ($categoriesResult as $index => $category) {
                                ?>
                                <li> <a data-toggle="collapse" data-parent="#faq" href="#shop-catigory-<?= $index ?>">
                                        <?= $category['name_en'] ?> <i class="ion-ios-arrow-down"></i></a>
                                    <ul id="shop-catigory-<?= $index ?>" class="panel-collapse collapse ">
                                        <?php
                                                $subcategoryObject->setCategory_id($category['id']);
                                                $subcategoryObjectResult = $subcategoryObject->read();
                                                if (!empty($subcategoryObjectResult)) {
                                                    $subcategories = $subcategoryObjectResult->fetch_all(MYSQLI_ASSOC);
                                                    foreach ($subcategories as $index => $subcategory) {
                                                ?>
                                        <li><a
                                                href="shop.php?sub=<?= $subcategory['id'] ?>&page=1"><?= $subcategory['name_en'] ?></a>
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
                        </div>
                    </div>
                    <div class="shop-price-filter mt-40 shop-sidebar-border pt-35">
                        <h4 class="shop-sidebar-title">Price Filter</h4>
                        <div class="row">
                            <div class="col-md-12">
                                <div id="slider-range" class="price-filter-range" name="rangeInput"></div>

                                <div style="margin:30px auto">
                                    <form method="post">

                                        <input type="number" name="min_price" min=0 max="<?= $filterPrice->max_price ?>"
                                            oninput="validity.valid||(value='<?= $filterPrice->min_price ?>');"
                                            id="min_price" class="price-range-field" />
                                        <input type="number" name="max_price" min=0 max="<?= $filterPrice->max_price ?>"
                                            oninput="validity.valid||(value='<?= $filterPrice->max_price ?>');"
                                            id="max_price" class="price-range-field" />
                                        <button class="btn btn-success rounded price-range-search"
                                            id="price-range-submt">Search</button>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <div class="shop-widget mt-40 shop-sidebar-border pt-35">
                <h4 class="shop-sidebar-title">By Brand</h4>
                <div class="sidebar-list-style mt-20">
                    <ul>
                        <li><input type="checkbox"><a href="#">Green </a>
                        <li><input type="checkbox"><a href="#">Herbal </a></li>
                        <li><input type="checkbox"><a href="#">Loose </a></li>
                        <li><input type="checkbox"><a href="#">Mate </a></li>
                        <li><input type="checkbox"><a href="#">Organic </a></li>
                        <li><input type="checkbox"><a href="#">White </a></li>
                        <li><input type="checkbox"><a href="#">Yellow Tea </a></li>
                        <li><input type="checkbox"><a href="#">Puer Tea </a></li>
                    </ul>
                </div>
            </div>
            <div class="shop-widget mt-40 shop-sidebar-border pt-35">
                <h4 class="shop-sidebar-title">By Color</h4>
                <div class="sidebar-list-style mt-20">
                    <ul>
                        <li><input type="checkbox"><a href="#">Black </a></li>
                        <li><input type="checkbox"><a href="#">Blue </a></li>
                        <li><input type="checkbox"><a href="#">Green </a></li>
                        <li><input type="checkbox"><a href="#">Grey </a></li>
                        <li><input type="checkbox"><a href="#">Red</a></li>
                        <li><input type="checkbox"><a href="#">White </a></li>
                        <li><input type="checkbox"><a href="#">Yellow </a></li>
                    </ul>
                </div>
            </div>
            <div class="shop-widget mt-40 shop-sidebar-border pt-35">
                <h4 class="shop-sidebar-title">Compare Products</h4>
                <div class="compare-product">
                    <p>You have no item to compare. </p>
                    <div class="compare-product-btn">
                        <span>Clear all </span>
                        <a href="#">Compare <i class="fa fa-check"></i></a>
                    </div>
                </div>
            </div>
            <div class="shop-widget mt-40 shop-sidebar-border pt-35">
                <h4 class="shop-sidebar-title">Popular Tags</h4>
                <div class="shop-tags mt-25">
                    <ul>
                        <li><a href="#">Green</a></li>
                        <li><a href="#">Oolong</a></li>
                        <li><a href="#">Black</a></li>
                        <li><a href="#">Pu'erh</a></li>
                        <li><a href="#">Dark </a></li>
                        <li><a href="#">Special</a></li>
                    </ul>
                </div>
            </div> -->
        </div>
    </div>
</div>
</div>
</div>
<!-- Shop Page Area End -->
<?php
include_once "layout/footer.php";
include_once "layout/scripts.php";

?>
<script>
$(document).ready(function() {
    filterProducts();

    function filterProducts() {
        var min_price = $("#min_price").val();
        var max_price = $("#max_price").val();

        $.ajax({

            url: "app/requests/Searchangeequest.php",
            action: '',
            type: "POST",
            data: {
                min_price: min_price,
                max_price: max_price
            },
            success: function(data) {
                $("#searchRange").html(data);
            }
        });
    }
    $("#slider-range").slider({
        range: true,
        orientation: "horizontal",
        min: <?= $filterPrice->min_price ?>,
        max: <?= $filterPrice->max_price ?>,
        values: [<?= isset($_POST['min_price']) ? $_POST['min_price'] : $filterPrice->min_price ?>,
            <?= isset($_POST['max_price']) ? $_POST['max_price'] : $filterPrice->max_price ?>
        ],


        slide: function(event, ui) {
            if (ui.values[0] == ui.values[1]) {
                return false;
            }

            $("#min_price").val(ui.values[0]);
            $("#max_price").val(ui.values[1]);
            filterProducts();
        }
    });

    $("#min_price").val($("#slider-range").slider("values", 0));
    $("#max_price").val($("#slider-range").slider("values", 1));


})
</script>
<?php
include_once "layout/endbody.php";
?>