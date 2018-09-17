<?php

declare(strict_types=1);


namespace Psren\ViewModelBundle;


use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;
use Symfony\Component\HttpFoundation\Response;

final class ViewModelFactory
{

    /**
     * @var ViewModel[]
     */
    private $viewModels;

    public function __construct(iterable $viewModels)
    {
        foreach ($viewModels as $viewModel) {
            $this->viewModels[\get_class($viewModel)] = $viewModel;
        }
    }
    
    public function create(string $view, string $serviceId, array $data = [], Response $response = null): Presentation
    {
        if(! isset($this->viewModels[$serviceId])) {
            throw new ServiceNotFoundException(sprintf('You have requested a non-existent service "%s". Tag it with "psren.view_model".', $serviceId));
        }
        
        return new Presentation(
            $view,
            $this->viewModels[$serviceId],
            $response ?? new Response(),
            $data
        );
    }

}