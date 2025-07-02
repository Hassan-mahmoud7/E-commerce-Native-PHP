<?php
$title = "Address";
include_once 'layout/header.php';
include_once 'app/middleware/auth.php';
include_once 'layout/nav.php';
include_once 'layout/breadcrumb.php';
include_once 'app/requests/AddressRequest.php';
spl_autoload_register(function ($class) {
    include "app/database/models/" . $class . ".php";
});
$cityObject = new City;
$cityRead = $cityObject->setStatus(1);
$cityReadResult = $cityRead->read();
if (isset($cityReadResult)) {
   $citys = $cityReadResult->fetch_all(MYSQLI_ASSOC);
}
$countryObject = new Country;
$countryRead = $countryObject->setStatus(1);
$countryReadResult = $countryRead->read();
if (isset($countryReadResult)) {
   $countrys = $countryReadResult->fetch_all(MYSQLI_ASSOC);
}
$regionObject = new Regions;
$regionObject->setStatus(1);
$regionRead = $regionObject->read();
if (isset($regionRead)) {
    $regions = $regionRead->fetch_all(MYSQLI_ASSOC);
}


if ($_POST) {
    $validat = new AddressRequest;
        //address  validation
       $addressValidat = $validat->setAddress($_POST['address']);
       $addressValidatResult = $addressValidat->addressValidation();
        //country  validation
        $countryValidat = $validat->setCountry($_POST['country']);
        $countryValidatResult = $countryValidat->countryValidation();
        //city  validation
        $cityValidat = $validat->setCity($_POST['city']);
        $cityValidatResult = $cityValidat->cityValidation();
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
         
        if (empty($addressValidatResult) && empty($countryValidatResult) && 
        empty($regionValidatResult) && empty($floorValidatResult) && empty($flatValidatResult) &&
         empty($streetValidatResult) && empty($buildingValidatResult)) {
            $addressObject = new Address;
            $setaddress = $addressObject->setAddress($_POST['address'])->setUser_id($_SESSION['user']->id)
            ->setRegions_id($_POST['region'])->setFloor($_POST['floor'])
            ->setFlat($_POST['flat'])->setStreet($_POST['street'])
            ->setBuilding($_POST['building'])->setNotes($_POST['notes']);
            $addressResult = $setaddress->create();
            if ($addressResult) {
                header('location:finish-buying.php');
            }
            else{
               $error = "<div class='alert alert-danger'>Sorry, an error occurred, try again later </div>";
                
            }
        
            
        }

       
  
    
}

?>

<div class="container mt-5"> 
    <?=isset($error)?$error:'' ?>
    <form action="" method="post">
        <div class="form-control mb-4">
            <!--  -->

            <div class="form-group">
                <label for="inputAddress">Address</label>
                <input type="text" name="address" class="form-control" id="inputAddress" placeholder="Enter Your Address" value="<?= isset($_POST['address'])?$_POST['address']:'';?>">
                <?= isset($addressValidatResult)?$addressValidatResult:'';?>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="inputCountry">Country</label>
                    <select name="country" id="inputCountry" class="form-control">
                   
                    <?php
                        foreach ($countrys as $index => $country) { 
                            ?>
                             <option <?= isset($_POST['country']) && $_POST['country'] == $country['id']?'selected':'' ?> value="<?= $country['id'] ?>"><?= $country['name_en'] ?></option>
                            <?php
                            }
                        ?>
                    </select>
                    <?= isset($countryValidatResult)?$countryValidatResult:'';?>
                  
                </div>
                <div class="form-group col-md-6">
                    <label for="inputCity">City</label>
                   
                    <select name="city" id="inputCity" class="form-control" placeholder="Choose City"> Choose City
                        <?php
                        foreach ($citys as $index => $city) {?>
                            <option <?=isset($_POST['city']) && $_POST['city'] == $city['id']?'selected':'' ?> value="<?=$city['id']?>"><?= $city['name_en']?></option>
                            
                            <?php
                      
                        }
                        ?>
                        
                    </select>
               
                    <?= isset($cityValidatResult)?$cityValidatResult:'';?>
                </div>
                <div class="form-group col-md-4">
                    <label for="region">Region</label>
                    <select name="region" id="region" class="form-control" placeholder="Choose City"> Choose City
                        <?php
                        foreach ($regions as $index => $region) {?>
                        
                            <option <?=isset($_POST['region']) && $_POST['region'] == $region['id']?'selected':'' ?> value="<?=$region['id']?>"><?= $region['name_en']?></option>
                        
                        <?php
                        }
                        ?>
                        
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label for="floor">Floor</label>
                    <input type="text" class="form-control" name="floor" id="floor" placeholder="Enter Your Floor" value="<?= isset($_POST['floor'])?$_POST['floor']:'';?>">
                    <?= isset($floorValidatResult)?$floorValidatResult:'';?>
                </div>
                <div class="form-group col-md-4">
                    <label for="flat">Flat</label>
                    <input type="text" class="form-control" name="flat" id="flat" placeholder="Enter Your Flat" value="<?= isset($_POST['flat'])?$_POST['flat']:'';?>">
                    <?= isset($floorValidatResult)?$flatValidatResult:'';?>
                </div>
                <div class="form-group col-md-6">
                    <label for="street">Street</label>
                    <input type="text" class="form-control" name="street" id="street" placeholder="Enter Your Street" value="<?= isset($_POST['street'])?$_POST['street']:'';?>">
                    <?= isset($streetValidatResult)?$streetValidatResult:'';?>
                </div>
                <div class="form-group col-md-6">
                    <label for="building">Building</label>
                    <input type="text" class="form-control" name="building" id="building" placeholder="Enter Your Building" value="<?= isset($_POST['building'])?$_POST['building']:'';?>">
                    <?= isset($buildingValidatResult)?$buildingValidatResult:'';?>
                </div>
            </div>
            <div class="form-group">
                <label for="notes">Notes</label>
                <input type="text" class="form-control" name="notes" id="notes" placeholder="Any notes" value="<?= isset($_POST['notes'])?$_POST['notes']:'';?>">
            </div>
            <div class="form-group">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1"
                        value="option1" checked>
                    <label class="form-check-label" for="exampleRadios1">
                        Paiement when recieving
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2"
                        value="option2">
                    <label class="form-check-label" for="exampleRadios2">
                        credit cards
                    </label>
                </div>
            </div>
            <button type="submit"  class="btn btn-success rounded mb-4">Complete a purchase</button>
        </div>
    </form>
</div>
<?php
include_once "layout/footer.php";
include_once "layout/scripts.php";
?>