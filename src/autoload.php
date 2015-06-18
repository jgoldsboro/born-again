<?php
/**
 * Autoloader for index.php
 */
spl_autoload_register (
    function ($class) {
        include 'terminal.php';
        include 'cart.php';
        include 'product.php';
        include 'discount.php';
});
