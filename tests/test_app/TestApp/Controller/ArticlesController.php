<?php
namespace BryanCrowe\ApiPagination\TestApp\Controller;

use Cake\Controller\Controller;

class ArticlesController extends Controller
{
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Paginator');
    }
}
