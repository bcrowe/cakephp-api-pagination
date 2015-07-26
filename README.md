# CakePHP API Pagination

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

This is a simple component for CakePHP 3 which injects pagination information
from CakePHP's Paginator, into Json and Xml View responses.

## Install

Via Composer

``` bash
$ composer require bcrowe/cakephp-api-pagination
```

Then make sure to load the plugin in your application's `bootstrap.php` file.

``` php
Plugin::load('BryanCrowe/ApiPagination');
```

## Usage

Load the component in a controller's `initialize()` method:


``` php
public function initialize()
{
	parent::initialize();
	$this->loadComponent('BryanCrowe/ApiPagination');
}
```

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email bryan@bryan-crowe.com instead of using the issue tracker.

## Credits

- [Bryan Crowe][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/bcrowe/cakephp-api-pagination.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/bcrowe/cakephp-api-pagination/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/bcrowe/cakephp-api-pagination.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/bcrowe/cakephp-api-pagination.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/bcrowe/cakephp-api-pagination.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/bcrowe/cakephp-api-pagination
[link-travis]: https://travis-ci.org/bcrowe/cakephp-api-pagination
[link-scrutinizer]: https://scrutinizer-ci.com/g/bcrowe/cakephp-api-pagination/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/bcrowe/cakephp-api-pagination
[link-downloads]: https://packagist.org/packages/bcrowe/cakephp-api-pagination
[link-author]: https://github.com/bcrowe
[link-contributors]: ../../contributors
