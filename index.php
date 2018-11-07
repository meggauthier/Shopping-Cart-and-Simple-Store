<?php
session_start();
require_once("config.php");
require_once("cart.php");
?>
<html xmlns = "http://www.w3.org/1999/xhtml">
<head>
    <title>Example of AJAX Cart</title>
    <meta http-equiv = "Content-Type" content="text/html; charset=utf-8" />
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
    <script type="text/javascript" src="main.js"></script>
</head>
<body leftmargin="0" marginwidth="0" topmargin="0" marginheight="0">
<h1>Products list</h1>
<?php
$cart = new cart();
$products = $cart->getProducts();
?>
<table cellpadding="5" cellspacing="0" border="0">
    <tr>
        <td style="width: 200px"><b>Product</b></td>
        <td style="width: 300px" colspan="2"><b>Price</b></td>
    </tr>
    <?php
    foreach($products as $product) {
        ?>
        <tr>
            <td><?php print HtmlSpecialChars($product->product); ?></td>
            <td>$<?php print $product->price; ?></td>
            <td style="text-align: center"><span style="cursor:pointer;" class="addToCart" data-id="<?php print $product->id; ?>">add to cart</span></td>
        </tr>
        <?php
    }
    ?>
</table>
<br /><a href="show-cart.php" title="go to cart">Go to cart</a>
</body>
</html>