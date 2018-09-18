# Symfony Presenter-Bundle

[![Build Status](https://travis-ci.org/psren/symfony-viewmodel-bundle.svg?branch=master)](https://travis-ci.org/psren/symfony-viewmodel-bundle)
--

Passes Data to your View without cluttering your Controllers.

## Installation

```sh
composer require psren/viewmodel-bundle
```

In your `bundles.php` add
```php
Psren\ViewModelBundle\ViewModelBundle::class => ['all' => true],
```

## Usage

### Build your ViewModel

```php
namespace App\ViewModel;
// you can place it wherever you want.
// this is just the example namespace.
// Maybe you want to place this next to your controller?
// Or in the correct folder for the domain?
// Do whatever you want ;-)

final class HomePage implements ViewModel
{
    // Automatic injection of Services works here.
    // You can e.g. inject your Database-Connection.
    public function __construct(...)
    {
    }

    public function getData(): array
    {
        return [
            'foo' => 'bar',
        ];
    }
}
```

### Usage in the Controller

You can use the Symfony functions as normal.
But you can use a Service-ID to replace the template now.
If the service exists it will use your ViewModel.`

You can use DI for ViewModels as you would in every other class.
E.g. Typehint the `DBAL\Conntection` in the `__construct` of your `ViewModel`.

```php
final class HomePage extends Controller
{
    use Psren\ViewModelBundle\ViewModels;
    
    public function simpleAction()
    {
        return $this->render(App\ViewModel\HomePage::class);
    }
}
```

## Common pitfalls

Some of your assigned data is dependent on the `Request` instance, on `Forms`, on User-Input etc.

*Do NOT try to add all View data in your ViewModels*

Some Variables should be passed by the controller directly to the view. 
You can still do that by using the Symfony default (second Parameter on `render`, `renderView`, `stream`.

Just add Data to the ViewModel that is not part of the Controlling-Process.
