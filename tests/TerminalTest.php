<?php

namespace Born;

class TerminalTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Terminal
     */
    private $terminal;

    public function setUp()
    {
        $this->terminal = new Terminal();
    }

    /**
     * Test minimal inputs based on requirements.
     * @return Array
     */
    public function testInputScan()
    {
        $valid = array( 
            'ABCDABAA' => 32.40,
            'CCCCCCC' => 7.25,
            'ABCD' => 15.40
        );

        $productA = $this->terminal->setProduct('A', 2.00);
        $this->terminal->setProduct('B', 12.00);
        $productC = $this->terminal->setProduct('C', 1.25);
        $this->terminal->setProduct('D', 0.15);

        $this->terminal->setDiscount($productA, 'Discount A', 7.00, 4);
        $this->terminal->setDiscount($productC, 'Discount C', 6.00, 6);

        foreach ($valid as $input => $validTotal) {
            $products = str_split($input, 1);
            foreach ($products as $name) {
                $this->terminal->scan($name);
            }

            $total = $this->terminal->total();
            $this->assertEquals($total, $validTotal);
            $this->terminal->emptyCart();
        }

        return array(
            'terminal' => $this->terminal,
            'productA' => $productA,
            'productC' => $productC
        );
    }
    
    /**
     * Test multiple discounts to a single product
     * @depends testInputScan 
     * @params Array
     */
    public function testMultipleDiscounts($mixed)
    {
        $terminal = $mixed['terminal'];

        $valid = array(
            'AAAAAAAAAAAAAAAAAAA' => 27.50,
            'CCCCCCCCCCCCCC' => 13.50
        );

        $terminal->setDiscount(
            $mixed['productA'],
            'Discount A Two',
            8.50,
            6
        );

        $terminal->setDiscount(
            $mixed['productC'],
            'Discount C Two',
            7.50,
            8
        );

        foreach ($valid as $input => $validTotal) {
            $products = str_split($input, 1);
            foreach ($products as $name) {
                $terminal->scan($name);
            }

            $total = $terminal->total();
            $this->assertEquals($total, $validTotal);
            $terminal->emptyCart();
        }
    }

    /**
     * Test a valid product
     * @return Array
     */
    public function testValidProduct()
    {
        $product = $this->terminal->setProduct('A', 2.00);

        $this->assertInstanceOf(Product::class, $product);

        return array(
            'terminal' => $this->terminal,
            'product' => $product
        );
    }

    /**
     * Test duplicate products
     * @depends testValidProduct
     * @param Array
     * @expectedException InvalidArgumentException
     */
    public function testDuplicateProduct($mixed)
    {
        $terminal = $mixed['terminal'];
        $copy = clone($mixed['product']);
        
        $terminal->setProduct(
            $copy->getName(), 
            $copy->getPrice()
        );
    }

    /**
     * Test a valid discount
     * @depends testValidProduct
     * @param Array
     */
    public function testValidDiscount($mixed)
    {
        $terminal = $mixed['terminal'];
        $discount = $terminal->setDiscount(
            $mixed['product'],
            'Discount A',
            7.00,
            4
        );

        $this->assertInstanceOf(Discount::class, $discount);
    }

    /**
     * Test invalid product name
     * @depends testValidProduct
     * @param Array
     * @expectedException InvalidArgumentException
     */
    public function testInvalidProductName($mixed)
    {
        $terminal = $mixed['terminal'];
        $terminal->scan('Z');
    }
}
