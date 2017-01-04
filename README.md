# GSuite Checker

[![Join the PHP Chat community][ico-phpchat]][link-phpchat]
[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

> Google Suite AKA GSuite (Formerly known as Google Apps) Checker for Domains. It lets you determine if a domain has an active GSuite Account.

> The checker can check up to **25** domains simultaneously in a pool of requests.

## Install

Via Composer

``` bash
$ composer require irazasyed/gsuite-checker
```

## Usage

``` php
$domains = ['test.com', 'domain.com', 'example.com'];

$gsuite = Irazasyed\GsuiteChecker::make($domains)->check();

$result = $gsuite->all();
```

The result is an array of domain => status.

There are 3 status codes:

- **-1** - The request was rejected due to whatever issues and should be retried.
- **0** - There is no GSuite Account associated with the domain.
- **1** - There is a GSuite Account associated with the domain.

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) and [CONDUCT](CONDUCT.md) for details.

## Security

If you discover any security related issues, please email syed at lukonet.com instead of using the issue tracker.

## Credits

- [Syed Irfaq R.][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-phpchat]: https://img.shields.io/badge/Join-PHP%20Chat-blue.svg?style=flat-square
[ico-version]: https://img.shields.io/packagist/v/irazasyed/gsuite-checker.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/irazasyed/gsuite-checker/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/irazasyed/gsuite-checker.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/irazasyed/gsuite-checker.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/irazasyed/gsuite-checker.svg?style=flat-square

[link-phpchat]: https://phpchat.co/?ref=gsuite-checker
[link-packagist]: https://packagist.org/packages/irazasyed/gsuite-checker
[link-travis]: https://travis-ci.org/irazasyed/gsuite-checker
[link-scrutinizer]: https://scrutinizer-ci.com/g/irazasyed/gsuite-checker/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/irazasyed/gsuite-checker
[link-downloads]: https://packagist.org/packages/irazasyed/gsuite-checker
[link-author]: https://github.com/irazasyed
[link-contributors]: ../../contributors
