# CakePHP API Pagination

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-github]][link-github]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

This is a simple component for CakePHP 4.2+ which injects pagination information
from CakePHP's Paginator into serialized JsonView and XmlView responses.

See `1.x` and `2.x` releases and branches of this plugin for support of previous versions of CakePHP before `4.2`.

## Install

Via Composer

``` bash
$ composer require bcrowe/cakephp-api-pagination
```

Load the plugin by adding `$this->addPlugin('BryanCrowe/ApiPagination');` to the `bootsrap` method in your project’s `src/Application.php`:

``` php
public function bootstrap(): void
{
    parent::bootstrap();
    
    // ... bootstrap code ...

    // load more plugins here
    
    $this->addPlugin('BryanCrowe/ApiPagination');
}
```

## Usage

Make sure your application has been set up to use data views; see the
[Enabling Data Views in Your Application][link-dataviews] section of the CakePHP
documentation.

Then, load `ApiPaginationComponent`:

``` php
$this->loadComponent('BryanCrowe/ApiPagination.ApiPagination');
```

Then, go ahead and set your paginated view variable like so:

``` php
$this->set('articles', $this->paginate($this->Articles));
$this->viewBuilder()->setOption('serialize', ['articles']);
```
**Note:** It is important that your `serialize` option is an array, e.g.
`['articles']`, so that your pagination information can be set under its own
pagination key.

Your JsonView and XmlView responses will now contain the pagination information,
and will look something like this:

``` json
{
    "articles": ["...", "...", "..."],
    "pagination": {
        "finder": "all",
        "page": 1,
        "current": 20,
        "count": 5000,
        "perPage": 20,
        "prevPage": false,
        "nextPage": true,
        "pageCount": 250,
        "sort": null,
        "direction": false,
        "limit": null,
        "sortDefault": false,
        "directionDefault": false
    }
}
```

### Configuring the Pagination Output

ApiPagination has four keys for configuration: `key`, `aliases`, `visible` and `model`.

* `key` allows you to change the name of the pagination key.

* `aliases` allows you to change names of the pagination detail keys.

* `visible` allows you to set which pagination keys will be exposed in the
  response. **Note:** Whenever setting a key's visibility, make sure to use the
  aliased name if you've given it one.

* `model` allows you to set the name of the model the pagination is applied on
  if the controller does not follow CakePHP conventions, e.g. `ArticlesIndexController`.
  Per default the model is the name of the controller, e.g. `Articles` for `ArticlesController`.

An example using all these configuration keys:

``` php
$this->loadComponent('BryanCrowe/ApiPagination.ApiPagination', [
    'key' => 'paging',
    'aliases' => [
        'page' => 'currentPage',
        'current' => 'resultCount'
    ],
    'visible' => [
        'currentPage',
        'resultCount',
        'prevPage',
        'nextPage'
    ],
    'model' => 'Articles',
]);
```

This configuration would yield:

``` json
{
    "articles": ["...", "...", "..."],
    "paging": {
        "prevPage": false,
        "nextPage": true,
        "currentPage": 1,
        "resultCount": 20
    }
}
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed
recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CONDUCT](CONDUCT.md) for
details.

## Security

If you discover any security related issues, please email bryan@bryan-crowe.com
instead of using the issue tracker.

## Credits

- [Bryan Crowe][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more
information.

[ico-version]: https://img.shields.io/packagist/v/bcrowe/cakephp-api-pagination.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-github]: https://github.com/bcrowe/cakephp-api-pagination/workflows/CI/badge.svg
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/bcrowe/cakephp-api-pagination.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/bcrowe/cakephp-api-pagination.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/bcrowe/cakephp-api-pagination.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/bcrowe/cakephp-api-pagination
[link-github]: https://github.com/bcrowe/cakephp-api-pagination/actions
[link-scrutinizer]: https://scrutinizer-ci.com/g/bcrowe/cakephp-api-pagination/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/bcrowe/cakephp-api-pagination
[link-downloads]: https://packagist.org/packages/bcrowe/cakephp-api-pagination
[link-author]: https://github.com/bcrowe
[link-contributors]: ../../contributors
[link-dataviews]: https://book.cakephp.org/4/en/views/json-and-xml-views.html#enabling-data-views-in-your-application
