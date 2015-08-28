<?php
namespace BryanCrowe\ApiPagination\Test;

use BryanCrowe\ApiPagination\Controller\Component\ApiPaginationComponent;
use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\Network\Request;
use Cake\Network\Response;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;


class ArticlesController extends Controller
{
    public $components = ['Paginator'];
}

/**
 * ApiPaginationComponentTest class
 */
class ApiPaginationComponentTest extends TestCase
{
    public $fixtures = ['plugin.BryanCrowe/ApiPagination.Articles'];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        $this->Articles = TableRegistry::get('BryanCrowe/ApiPagination.Articles', ['table' => 'bryancrowe_articles']);
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
    }

    public function testNonApiPaginatedRequest()
    {
        $request = new Request('/articles');
        $response = $this->getMock('Cake\Network\Response');
        $controller = new ArticlesController($request, $response);
        $apiPaginationComponent = new ApiPaginationComponent($controller->components());
        $event = new Event('Controller.beforeRender', $controller);

        $this->assertNull($apiPaginationComponent->beforeRender($event));
    }

    public function testDefaultPaginationSettings()
    {
        $request = new Request('/articles');
        $request->env('HTTP_ACCEPT', 'application/json');
        $response = $this->getMock('Cake\Network\Response');
        $controller = new ArticlesController($request, $response);
        $controller->set('data', $controller->paginate($this->Articles));
        $apiPaginationComponent = new ApiPaginationComponent($controller->components());
        $event = new Event('Controller.beforeRender', $controller);
        $apiPaginationComponent->beforeRender($event);

        $result = $apiPaginationComponent->_registry->getController()->viewVars['pagination'];
        $expected = [
            'finder' => 'all',
            'page' => 1,
            'current' => 20,
            'count' => 23,
            'perPage' => 20,
            'prevPage' => false,
            'nextPage' => true,
            'pageCount' => 2,
            'sort' => null,
            'direction' => false,
            'limit' => null,
            'sortDefault' => false,
            'directionDefault' => false
        ];

        $this->assertSame($expected, $result);
    }
}
