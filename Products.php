<?php
/**
 * Created by PhpStorm.
 * User: mgauthier
 * Date: 10/15/2018
 * Time: 2:02 PM
 */

// php server session token
session_start();

//GC awareness shopper token


//require_once("Products.php");
//require_once("cart.php");
?>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>


    <h1 class="text-center">Products</h1>
<?php
$url = 'https://api.digitalriver.com/v1/shoppers/me/products?apiKey=0a1eeb0d83f04090a40ad5369431eab7&format=json';
$data = file_get_contents($url);

$characters = json_decode($data, true);

foreach ($characters as $products) : ?>
    <?php foreach ($products[product] as $product) : ?>
        <?php echo "<pre>";
        print_r($product);
        echo "</pre>";
        ?>
        <div class="col-xs-4 text-center border border-dark">
            <img src="<?= $product['thumbnailImage'] ?>" />
            <h3><?= $product[displayName] ?></h3>
            <h4><?= $product[shortDescription] ?></h4>
            <h4>Price: <?= $product[pricing][formattedListPrice] ?></h4>
            <h4> Sale Price: <?= $product[pricing][formattedSalePriceWithQuantity] ?></h4>
            <button><a href="" class="addToCart" data-id="<?php print $product[addProductToCart][cartUri] ?> ?>" onclick="addToCart()">>Add to Cart</a></button>
        </div>
    <?php endforeach; ?>
<?php endforeach; ?>