<?php
declare(strict_types=1);

namespace BryanCrowe\ApiPagination\Test;

use BryanCrowe\ApiPagination\Controller\Component\ApiPaginationComponent;
use BryanCrowe\ApiPagination\TestApp\Controller\ArticlesIndexController;
use Cake\Event\Event;
use Cake\Http\ServerRequest as Request;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * ApiPaginationComponentTest class
 *
 * @property ArticlesIndexController $controller
 */
class ApiPaginationComponentOnNonConventionalControllerNameTest extends TestCase
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
        $this->controller = new ArticlesIndexController($this->request, $this->response);
        $this->Articles = TableRegistry::getTableLocator()->get('BryanCrowe/ApiPagination.Articles', ['table' => 'bryancrowe_articles']);
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
     * Test that a non conventional controller name is supported using the 'model' config.
     *
     * @dataProvider dataForTestVariousModelValueOnNonConventionalController
     * @param array $config
     * @param $expected
     * @return void
     */
    public function testVariousModelValueOnNonConventionalController(array $config, $expected)
    {
        $this->controller->setRequest(
            $this->controller->getRequest()->withEnv('HTTP_ACCEPT', 'application/json')
        );
        $this->controller->set('data', $this->controller->paginate($this->Articles));
        $apiPaginationComponent = new ApiPaginationComponent($this->controller->components(), $config);
        $event = new Event('Controller.beforeRender', $this->controller);
        $apiPaginationComponent->beforeRender($event);

        $result = $apiPaginationComponent->getController()->viewBuilder()->getVar('pagination');
        $this->assertSame($expected, $result);
    }

    /**
     * If the name of the paginated model is not specified, the result of the pagination
     * on a controller not having the same name as the model fails.
     *
     * @return array[]
     */
    public function dataForTestVariousModelValueOnNonConventionalController(): array
    {
        return [
            [[], []],
            [['model' => 'Articles'], $this->getDefaultPagination()],
            [['model' => 'articles'], $this->getDefaultPagination()],
            [['model' => 'NonExistingModel'], []],
        ];
    }

    /**
     * Returns the standard pagination result.
     *
     * @return array
     */
    private function getDefaultPagination(): array
    {
        return [
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
    }
}
