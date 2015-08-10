<?php
namespace BryanCrowe\ApiPagination\Test;

use BryanCrowe\ApiPagination\Controller\Component\ApiPaginationComponent;
use Cake\Controller\ComponentRegistry;
use Cake\Controller\Controller;
use Cake\Network\Request;
use Cake\Network\Response;
use Cake\TestSuite\TestCase;

/**
 * ApiPaginationComponentTest class
 */
class ApiPaginationComponentTest extends TestCase
{
    public $component = null;
    public $controller = null;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $request = new Request();
        $response = new Response();
        $this->controller = new Controller($request, $response);
        $registry = new ComponentRegistry($this->controller);
        $this->component = new ApiPaginationComponent($registry);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        parent::tearDown();

        unset($this->component, $this->controller);
    }

    public function testTrue()
    {
        $this->assertTrue(true);
    }
}
