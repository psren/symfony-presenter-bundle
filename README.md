# Symfony Presenter-Bundle

Passes Data to your View without cluttering your Controllers.
Works with ```symfony/twig-bundle``` or ```symfony/templating```.

## Installation

```sh
composer require psren/presenter-bundle
```

In your bundles.php add
```php
Psren\ViewModelBundle\ViewModelBundle::class => ['all' => true],
```

## Usage

### Build your ViewModel

```php
final class HomePageViewModel implements ViewModel
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

```php
final class HomePage extends Controller
{
    public function simpleAction(ViewModelFactory $viewModelFactory)
    {
        return $viewModelFactory->create('index.html.twig', HomePageViewModel::class);
    }
    
    public function withControllerDataAction(ViewModelFactory $viewModelFactory)
    {
        return $viewModelFactory->create('index.html.twig', HomePageViewModel::class, [
            'data_from_controller' => true
        ]);
    }
    
    public function withCustomResponseAction(ViewModelFactory $viewModelFactory)
    {
        $response = new Response();
        $response->setStatusCode(404);
        
        return $viewModelFactory->create('index.html.twig', HomePageViewModel::class, [], $response);
    }
}
```

## How it works

The Bundle listens to the ```kernel.view``` event and converts the Presentation to a Response.