<?php
namespace BryanCrowe\ApiPagination\Test;

use BryanCrowe\ApiPagination\Controller\Component\ApiPaginationComponent;
use Cake\Controller\ComponentRegistry;
use Cake\Controller\Controller;
use Cake\Core\Plugin;
use Cake\Network\Request;
use Cake\Network\Response;
use Cake\TestSuite\TestCase;

/**
 * ApiPaginationComponentTest class
 */
class ApiPaginationComponentTest extends TestCase
{
    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
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

    public function testInit()
    {
        $request = new Request('/');
        $response = $this->getMock('Cake\Network\Response');

        $controller = new Controller($request, $response);
        $controller->loadComponent('BryanCrowe/ApiPagination.ApiPagination');

        $expected = [
            'key' => 'pagination',
            'aliases' => [],
            'visible' => []
        ];

        $result = $controller->ApiPagination->config();

        $this->assertSame($expected, $result);
    }
}
