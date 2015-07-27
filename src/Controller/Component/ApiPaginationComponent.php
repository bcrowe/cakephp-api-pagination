<?php
namespace BryanCrowe\ApiPagination\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\Controller;
use Cake\Event\Event;

/**
 * This is a simple component that injects pagination info into responses when
 * using CakePHP's PaginatorComponent alongside of CakePHP's JsonView or XmlView
 * classes.
 */
class ApiPaginationComponent extends Component
{
    /**
     * Default config.
     *
     * @var array
     */
    protected $_defaultConfig = [
        'key' => 'pagination',
        'aliases' => [],
        'visible' => []
    ];

    /**
     * Holds the paging information.
     *
     * @var array
     */
    protected $paging = [];

    /**
     * Injects the pagination info into the response if the current request is a
     * JSON or XML request with pagination.
     *
     * @param Event $event The Controller.beforeRender event.
     * @return void
     */
    public function beforeRender(Event $event)
    {
        $controller = $event->subject();

        if (!$this->isPaginatedApiRequest($controller)) {
            return;
        }

        $this->paging = $controller->request->params['paging'][$controller->name];

        if (!empty($this->config('aliases'))) {
            $this->setAliases();
        }

        if (!empty($this->config('visible'))) {
            $this->setVisible();
        }

        $controller->set($this->config('key'), $this->paging);
        $controller->viewVars['_serialize'][] = $this->config('key');
    }

    /**
     * Aliases the default pagination keys to the new keys that the user defines
     * in the config.
     *
     * @return void
     */
    protected function setAliases()
    {
        $aliases = $this->config('aliases');
        foreach ($aliases as $key => $value) {
            $this->paging[$value] = $this->paging[$key];
            unset($this->paging[$key]);
        }
    }

    /**
     * Removes any pagination keys that haven't been defined as visible in the
     * config.
     *
     * @return void
     */
    protected function setVisible()
    {
        $visible = $this->config('visible');
        foreach ($this->paging as $key => $value) {
            if (!in_array($key, $visible)) {
                unset($this->paging[$key]);
            }
        }
    }

    /**
     * Checks whether the current request is a JSON or XML request with
     * pagination.
     *
     * @param \Cake\Controller\Controller $controller A reference to the
     *   instantiating controller object
     * @return bool True if JSON or XML with paging, otherwise false.
     */
    protected function isPaginatedApiRequest(Controller $controller)
    {
        if (isset($controller->request->params['paging']) &&
            $controller->request->is('json') ||
            $controller->request->is('xml')
        ) {
            return true;
        }

        return false;
    }
}
