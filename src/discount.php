<?php

namespace Born;

class Discount
{
    /**
     * @var float
     */
    private $price;

    /**
     * @var integer
     */
    private $volume;

    /**
     * @var string
     */
    private $name;

    /**
     * @param string $name
     * @param float $price
     * @param integer $volume
     */
    public function __construct($name, $price, $volume)
    {
        $this->setName($name);
        $this->setPrice($price);
        $this->setVolume($volume);
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
     * @return Discount
     * @throws Born\InvalidArgumentException
     */
    public function setName($name)
    {
        if (!is_string($name)) {
            throw new InvalidArgumentException(
                "$name is invalid, must be a string"
            );
        }
        
        $this->name = $name;

        return $this;
    }

    /**
     * Get Price
     * @return float $price
     */
    public function getPrice()
    {
        return $this->price;
    }
    
    /**
     * Set Price
     * @param float $price
     * @return Discount
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
     * Get Volume
     * @return integer $volume
     */
    public function getVolume()
    {
        return $this->volume;
    }
    
    /**
     * Set Volume
     * @param integer $volume
     * @return Discount
     * @throws Born\InvalidArgumentException
     */
    public function setVolume($volume)
    {
        if (!is_int($volume)) {
            throw new InvalidArgumentException(
                "$volume is invalid, must be integer"
            );
        }
       
        $this->volume = $volume;

        return $this;
    }
}
