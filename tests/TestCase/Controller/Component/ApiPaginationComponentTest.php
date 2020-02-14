<?php
namespace BryanCrowe\ApiPagination\Test;

use BryanCrowe\ApiPagination\Controller\Component\ApiPaginationComponent;
use BryanCrowe\ApiPagination\TestApp\Controller\ArticlesController;
use Cake\Event\Event;
use Cake\Http\ServerRequest as Request;
use Cake\Http\Response;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * ApiPaginationComponentTest class
 *
 * @property ArticlesController $controller
 */
class ApiPaginationComponentTest extends TestCase
{
    public $fixtures = ['plugin.BryanCrowe/ApiPagination.Articles'];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        $this->request = new Request(['url' => '/articles']);
        $this->response = $this->createMock('Cake\Http\Response');
        $this->controller = new ArticlesController($this->request, $this->response);
        $this->Articles = TableRegistry::get('BryanCrowe/ApiPagination.Articles', ['table' => 'bryancrowe_articles']);
        parent::setUp();
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        parent::tearDown();
    }

    /**
     * Test that a non API or paginated request returns null.
     *
     * @return void
     */
    public function testNonApiPaginatedRequest()
    {
        $apiPaginationComponent = new ApiPaginationComponent($this->controller->components());
        $event = new Event('Controller.beforeRender', $this->controller);

        $this->assertNull($apiPaginationComponent->beforeRender($event));
    }

    /**
     * Test the expected pagination information for the component's default
     * config.
     *
     * @return void
     */
    public function testDefaultPaginationSettings()
    {
        $this->controller->setRequest(
            $this->controller->getRequest()->withEnv('HTTP_ACCEPT', 'application/json')
        );
        $this->controller->set('data', $this->controller->paginate($this->Articles));
        $apiPaginationComponent = new ApiPaginationComponent($this->controller->components());
        $event = new Event('Controller.beforeRender', $this->controller);
        $apiPaginationComponent->beforeRender($event);

        $result = $apiPaginationComponent->getController()->viewBuilder()->getVar('pagination');
        $expected = [
            'count' => 23,
            'current' => 20,
            'perPage' => 20,
            'page' => 1,
            'requestedPage' => 1,
            'pageCount' => 2,
            'start' => 1,
            'end' => 20,
            'prevPage' => false,
            'nextPage' => true,
            'sort' => null,
            'direction' => null,
            'sortDefault' => false,
            'directionDefault' => false,
            'completeSort' => [],
            'limit' => null,
            'scope' => null,
            'finder' => 'all',
        ];

        $this->assertSame($expected, $result);
    }

    /**
     * Test that visibility-only correctly sets the visible keys.
     *
     * @return void
     */
    public function testVisibilitySettings()
    {
        $this->controller->setRequest(
            $this->controller->getRequest()->withEnv('HTTP_ACCEPT', 'application/json')
        );
        $this->controller->set('data', $this->controller->paginate($this->Articles));
        $apiPaginationComponent = new ApiPaginationComponent(
            $this->controller->components(), [
            'visible' => [
                'page',
                'current',
                'count',
                'prevPage',
                'nextPage',
                'pageCount'
            ]
            ]
        );
        $event = new Event('Controller.beforeRender', $this->controller);
        $apiPaginationComponent->beforeRender($event);

        $result = $apiPaginationComponent->getController()->viewBuilder()->getVar('pagination');
        $expected = [
            'count' => 23,
            'current' => 20,
            'page' => 1,
            'pageCount' => 2,
            'prevPage' => false,
            'nextPage' => true,
        ];

        $this->assertSame($expected, $result);
    }

    /**
     * Test that alias-only correctly sets aliases the keys.
     *
     * @return void
     */
    public function testAliasSettings()
    {
        $this->controller->setRequest(
            $this->controller->getRequest()->withEnv('HTTP_ACCEPT', 'application/json')
        );
        $this->controller->set('data', $this->controller->paginate($this->Articles));
        $apiPaginationComponent = new ApiPaginationComponent(
            $this->controller->components(), [
            'aliases' => [
                'page' => 'curPage',
                'current' => 'currentCount',
                'count' => 'totalCount',
            ]
            ]
        );
        $event = new Event('Controller.beforeRender', $this->controller);
        $apiPaginationComponent->beforeRender($event);

        $result = $apiPaginationComponent->getController()->viewBuilder()->getVar('pagination');
        $expected = [
            'perPage' => 20,
            'requestedPage' => 1,
            'pageCount' => 2,
            'start' => 1,
            'end' => 20,
            'prevPage' => false,
            'nextPage' => true,
            'sort' => null,
            'direction' => null,
            'sortDefault' => false,
            'directionDefault' => false,
            'completeSort' => [],
            'limit' => null,
            'scope' => null,
            'finder' => 'all',
            'curPage' => 1,
            'currentCount' => 20,
            'totalCount' => 23,
        ];

        $this->assertSame($expected, $result);
    }

    /**
     * Test that key-only correctly sets the pagination key.
     *
     * @return void
     */
    public function testKeySetting()
    {
        $this->controller->setRequest(
            $this->controller->getRequest()->withEnv('HTTP_ACCEPT', 'application/json')
        );
        $this->controller->set('data', $this->controller->paginate($this->Articles));
        $apiPaginationComponent = new ApiPaginationComponent(
            $this->controller->components(), [
            'key' => 'paging'
            ]
        );
        $event = new Event('Controller.beforeRender', $this->controller);
        $apiPaginationComponent->beforeRender($event);

        $result = $apiPaginationComponent->getController()->viewBuilder()->getVar('paging');
        $expected = [
            'count' => 23,
            'current' => 20,
            'perPage' => 20,
            'page' => 1,
            'requestedPage' => 1,
            'pageCount' => 2,
            'start' => 1,
            'end' => 20,
            'prevPage' => false,
            'nextPage' => true,
            'sort' => null,
            'direction' => null,
            'sortDefault' => false,
            'directionDefault' => false,
            'completeSort' => [],
            'limit' => null,
            'scope' => null,
            'finder' => 'all',
        ];

        $this->assertSame($expected, $result);
    }

    /**
     * Test that all settings being used together work correctly.
     *
     * @return void
     */
    public function testAllSettings()
    {
        $this->controller->setRequest(
            $this->controller->getRequest()->withEnv('HTTP_ACCEPT', 'application/json')
        );
        $this->controller->set('data', $this->controller->paginate($this->Articles));
        $apiPaginationComponent = new ApiPaginationComponent(
            $this->controller->components(), [
            'key' => 'fun',
            'aliases' => [
                'page' => 'currentPage',
                'count' => 'totalCount',
                'limit' => 'unusedAlias'
            ],
            'visible' => [
                'currentPage',
                'totalCount',
                'limit',
                'prevPage',
                'nextPage'
            ]
            ]
        );
        $event = new Event('Controller.beforeRender', $this->controller);
        $apiPaginationComponent->beforeRender($event);

        $result = $apiPaginationComponent->getController()->viewBuilder()->getVar('fun');
        $expected = [
            'prevPage' => false,
            'nextPage' => true,
            'currentPage' => 1,
            'totalCount' => 23,
        ];

        $this->assertSame($expected, $result);
    }
}
