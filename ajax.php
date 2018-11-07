<?php
/**
 * Created by PhpStorm.
 * User: mgauthier
 * Date: 11/7/2018
 */

 session_start();

 require_once( "cart.php" );
 $cart = new cart();
 $action = strip_tags( $_GET["action"] );
 switch ($action) {
     case "add":
         $cart->addToCart();
         break;
 }
?>