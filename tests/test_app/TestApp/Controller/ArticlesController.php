<?php
declare(strict_types=1);

namespace BryanCrowe\ApiPagination\TestApp\Controller;

use Cake\Controller\Controller;

class ArticlesController extends Controller
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Paginator');
    }
}
