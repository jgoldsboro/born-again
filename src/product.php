<?php

namespace Born;

class Product
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var float
     */
    private $price;

    /**
     * @var Array
     */
    private $discounts = Array();

    /**
     * @param string $name
     * @param float $price
     */
    public function __construct($name, $price)
    {
        $this->setName($name);
        $this->setPrice($price);
    }

    /**
     * Get Name
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * Set Name
     * @param string $name
     * @return Product
     * @throws Born\InvalidArgumentException
     */
    public function setName($name)
    {
        if (!is_string($name)) {
            throw new InvalidArgumentException(
                "$name is invalid, must be string"
            );
        }
        
        $this->name = $name;

        return $this;
    }

    /**
     * Get Price
     * @return Product
     */ 
    public function getPrice()
    {
        return $this->price;
    }
    
    /**
     * Set Price
     * @param float $price
     * @return Product
     * @throws Born\InvalidArgumentException
     */
    public function setPrice($price)
    {
        if (!is_numeric($price)) {
            throw new InvalidArgumentException(
                "$price is invalid, must be numeric"
            );
        }
        
        $this->price = $price;

        return $this;
    }

    /**
     * Get Discounts
     * @return Array
     */
    public function getDiscounts()
    {
        return $this->discounts;
    }
    
    /**
     * Set Discount
     * @param Discount $discount
     * @return Discount
     * @throws Born\InvalidArgumentException
     */
    public function setDiscount(Discount $discount)
    {
        if (!($discount instanceof Discount)) {
            throw new InvalidArgumentType(
                "$discount is invalid, must be a discount"
            );
        }
        
        $this->discounts[] = $discount;

        return $this;
    }
}
