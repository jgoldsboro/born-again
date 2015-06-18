<?php

namespace Born;

class Cart 
{
    /**
     * @var Array
     */
    protected $products = Array();

    /**
     * Get products
     * @return Array $products
     */
    public function getProducts()
    {
        return $this->products;
    }
    
    /**
     * Get Quantity
     * @param Product $product
     * @return integer
     * @throws Born\InvalidArgumentException
     */
    public function getQty(Product $product)
    {
        $name = $product->getName();

        if (!array_key_exists($name, $this->products)) {
            throw new InvalidArgumentException(
                "$name is an invalid product name"
            ); 
        }
        
        return $this->products[$name]['qty'];
    }
    
    /**
     * Add Product
     * @param Product $product
     * @return Cart
     * @throws Born\InvalidArgumentException
     */
    public function addProduct(Product $product)
    {
        $name = $product->getName();

        if (!$name) {
            throw new InvalidArgumentException(
                'invalid product'
            );
        }

        if (isset($this->products[$name])) {
            $this->updateProduct($product, $this->products[$name]['qty'] + 1);
        } else {
            $this->products[$name] = array('product' => $product, 'qty' => 1);
        }

        return $this;
    }

    /**
     * Update Product
     * @param Product $product
     * @param integer $qty
     * @return Cart
     */
    public function updateProduct(Product $product, $qty)
    {
        $name = $product->getName();

        if ($qty === 0) {
            $this->deleteProduct($product);
        } elseif (($qty > 0) && ($qty != $this->products[$name]['qty'])) {
            $this->products[$name]['qty'] = $qty; 
        }

        return $this;
    }

    /**
     * Delete Product
     * @param Product $product
     * @return Cart
     */
    public function deleteProduct(Product $product)
    {
        $name = $product->getName();

        if (isset($this->products[$name])) {
            unset($this->products[$name]);
        }

        return $this;
    }
}
