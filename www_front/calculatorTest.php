<?php
require (__DIR__ . '/calculator.php');
include (__NAMESPACE__ . '/vendor/phpunit/phpunit/tests/Framework/TestCaseTest.php');

class CalculatorTests extends PHPUnit_Framework_TestCase
{
    private $calculator;

    protected function setUp()
    {
        $this->calculator = new Calculator();
    }

    protected function tearDown()
    {
        $this->calculator = NULL;
    }

    public function testAdd()
    {
        $result = $this->calculator->add(1, 2);
        $this->assertEquals(3, $result);
    }

}