<?php
/**
 * Autoloader for index.php
 */
spl_autoload_register (
    function ($class) {
        require_once('terminal.php');
        require_once('cart.php');
        require_once('product.php');
        require_once('discount.php');
        require_once('exceptions/InvalidArgumentException.php');
        require_once('interfaces/Exception.php');
});
