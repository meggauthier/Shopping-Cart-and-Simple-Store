<?php
/**
 * Created by PhpStorm.
 * User: mgauthier
 * Date: 11/7/2018
 * Time: 11:04 AM
 */
class Cart {

    private $dbConnection;

    function __construct() {
        $this->dbConnection = new mysqli(MYSQLSERVER, MYSQLUSER, MYSQLPASSWORD, MYSQLDB);
    }

    function __destruct(){
        $this->dbConnection->close();
    }

    public function getProducts(){
        $arr = array();
        $dbConnection = $this->dbConnection;
        $dbConnection->query( "SET NAMES 'UTF8'" );
        $statement = $dbConnection->prepare( "select id, product, price from products order by product asc" );
        $statement->execute();
        $statement->bind_result( $id, $product, $price);
        while ( $statement->fetch() ) {
            $line = new stdClass;
            $line->id = $id;
            $line->product = $product;
            $line->price = $price;
            $arr[] = $line;
        }
        $statement->close();
        return $arr;
    }

    public function addToCart() {
        $id = intval($_GET["id"]);
        if($id > 0) {
            if($_SESSION['cart'] != "") {
                $cart = json_decode( $_SESSION['cart'], true);
                $found = false;
                for($i=0; $i<count($cart); $i++) {
                    if($cart[$i][ "product" ] == $id){
                        $cart[$i]["count"] = $cart[$i]["count"] + 1;
                        $found = true;
                        break;
                    }
                }
                if(!$found) {
                    $line = new stdClass;
                    $line->product = $id;
                    $line->count = 1;
                    $cart[] = $line;
                }
                $_SESSION['cart'] = json_encode($cart);
            } else {
                $line = new stdClass;
                $line->product = $id;
                $line->count = 1;
                $cart[] = $line;
                $_SESSION['cart'] = json_encode($cart);
            }
        }
    }

    public function getCart(){
        $cartArray = array();
        if($_SESSION['cart'] != ""){
            $cart = json_decode($_SESSION['cart'], true);
            for($i=0;$i<count($cart);$i++){
                $lines = $this->getProductData($cart[$i]["product"]);
                $line = new stdClass;
                $line->id = $cart[$i]["product"];
                $line->count = $cart[$i]["count"];
                $line->product = $lines->product;
                $line->total = ($lines->price*$cart[$i]["count"]);
                $cartArray[] = $line;
            }
        }
        return $cartArray;
    }

    private function getProductData($id) {
        $dbConnection = $this->dbConnection;
        $dbConnection->query( "SET NAMES 'UTF8'" );
        $statement = $dbConnection->prepare( "select product, price from products where id = ? limit 1" );
        $statement->bind_param( 'i', $id);
        $statement->execute();
        $statement->bind_result( $product, $price);
        $statement->fetch();
        $line = new stdClass;
        $line->product = $product;
        $line->price = $price;
        $statement->close();
        return $line;
    }
}
?>