<?php

namespace Born;

class Terminal
{
    /**
     * @var Cart
     */
    private $cart;

    /**
     * @var Array
     */
    private $products = Array();

    /**
     * Set new cart for terminal
     */
    public function __construct()
    {
        $this->cart = new Cart();
    }
    
    /**
     * Set Product
     * @param string $name
     * @param float $price
     * @return Product
     * @throws Born\InvalidArgumentException
     */
    public function setProduct($name, $price)
    {
        if (array_key_exists($name,$this->products)) {
            throw new InvalidArgumentException(
                "$name is invalid, duplicate found"
            );
        }
        
        $new = new Product($name, $price);
        $this->products[$new->getName()] = $new;

        return $new;
    }

    /**
     * Get Products
     * @return Array
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * Set Discount
     * @param Product $product
     * @param string $name
     * @param float $price
     * @param integer $volume
     * @return Discount
     */
    public function setDiscount(Product $product, $name, $price, $volume)
    {
       $discount = new Discount($name, $price, $volume);
       $this->products[$product->getName()]->setDiscount($discount); 

       return $discount;
    }
    
    /**
     * Scan product name
     * @param string $name
     * @return void
     * @throws Born\InvalidArgumentException
     */
    public function scan($name)
    {
        if (!array_key_exists($name, $this->products)) {
            throw new InvalidArgumentException(
                "$name is an invalid product"
            );
        }
        
        $this->cart->addProduct($this->products[$name]);
    }

    /**
     * Get Cart
     * @return Cart
     */
    public function getCart()
    {
        return $this->cart;
    }

    /**
     * Get total
     * @return float $total
     */
    public function total()
    {
        $total = 0;

        foreach ($this->cart->getProducts() as $product) {
            $total += $this->calculateProductPrice($product['product']); 
        }

        return $total;
    }

    /**
     * Calculate price of product
     * @param Product $product
     * @return float
     */
    private function calculateProductPrice(Product $product)
    {
        $discounts = $product->getDiscounts();
        $qty = $this->cart->getQty($product); 
        $price = $product->getPrice();

        if (empty($discounts)) {
            return $this->calculateHardPrice($price,$qty); 
        } else {
            return $this->caclulateProductDiscount($price, $discounts, $qty);
        }
    }
    
    /**
     * Calculate price of product without discounts
     * @param float $price
     * @param integer $qty
     * @return float
     */
    private function calculateHardPrice($price, $qty)
    {
        return $price * $qty;
    }

    /**
     * Calculate price of product with discounts
     * @param float $price
     * @param Array $discounts
     * @param integer $qty
     * @return float $total
     */
    private function caclulateProductDiscount($price, $discounts, $qty)
    {
        $total = 0;
        //Sort discounts by volume to apply the largest discount first.
        usort($discounts, array($this, "compare"));

        foreach ($discounts as $discount) {
            $volume = $discount->getVolume();
            if ($qty >= $volume) {
                $this->applyDiscount(
                    $discount->getPrice(), 
                    $qty, 
                    $volume, 
                    $total
                );
            }
        }

        if ($qty > 0)
            $total += $this->calculateHardPrice($price, $qty);
        
        return $total;
    }

    /**
     * Recursive function to apply discount
     * @param float $price
     * @param integer $qty
     * @param integer $volume
     * @param float $total
     * @return void
     */
    private function applyDiscount($price, &$qty, $volume, &$total)
    {
        if ($qty >= $volume) {
            $qty = $qty - $volume;
            $total += $price;
            $this->applyDiscount($price, $qty, $volume, $total);
        }
    }

    /**
     * Compare product discount volume
     * @param Discount $a
     * @param Discount $b
     * @return boolean
     */
    private function compare($a, $b)
    {
        return $a->getVolume() < $b->getVolume();
    }

    /**
     * Empty cart
     * @return void
     */
    public function emptyCart()
    {
        foreach ($this->products as $product) {
            $this->cart->deleteProduct($product);
        }
    }
}
