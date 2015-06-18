<?php

namespace Born;

include 'autoload.php';

$terminal = new Terminal();
$productA = $terminal->setProduct('A',2.00);
$productB = $terminal->setProduct('B',12.00);
$productC = $terminal->setProduct('C',1.25);
$productD = $terminal->setProduct('D',0.15);

//$discountOne = $terminal->setDiscount($productA, 'Discount A One', 8.50, 6);
$discountTwo = $terminal->setDiscount($productA, 'Discount A Two', 7.00, 4);
$discountThree = $terminal->setDiscount($productC, 'Discount C', 6.00, 6);

$input = 'ABCDABAA';
//$input = 'CCCCCCC';
//$input = 'ABCD';
//$input = 'AAAAAAAAAAAA';
//$input = 'CCCCCCCCCCCC';

$products = str_split($input, 1);

if (is_array($products) && !empty($products)) {
    foreach($products as $name)
        $terminal->scan($name);
}

$cart = $terminal->getCart();
$total = $terminal->total();
var_dump($total);
