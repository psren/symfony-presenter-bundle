<?php

declare(strict_types=1);


namespace Psren\ViewModelBundle;

use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psren\ViewModelBundle\Templating\TemplateChooser;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

trait ViewModels
{

    /**
     * Renders a view.
     *
     * @final
     */
    protected function render(string $view, array $parameters = array(), Response $response = null): Response
    {
        return parent::render(
            $this->getView($view),
            $this->getParameters($view, $parameters),
            $response
        );
    }

    /**
     * Returns a rendered view.
     *
     * @final
     */
    protected function renderView(string $view, array $parameters = array()): string
    {
        return parent::renderView(
            $this->getView($view),
            $this->getParameters($view, $parameters)
        );
    }

    protected function stream(string $view, array $parameters = array(), StreamedResponse $response = null): StreamedResponse
    {
        return parent::stream(
            $this->getView($view),
            $this->getParameters($view, $parameters),
            $response
        );
    }
    
    private function getParameters(string $view, array $parameters = []) : array
    {
        $viewModel = $this->getViewModel($view);
        
        if (! $viewModel) {
            return $parameters;
        }
        
        return array_merge($viewModel->getData(), $parameters);
    }
    
    private function getView(string $view) : string
    {
        $viewModel = $this->getViewModel($view);
        
        if (! $viewModel) {
            return $view;
        }
        
        /** @var TemplateChooser $templateChooser */
        $templateChooser = $this->container->get('psren.view_model.template_chooser');
        return $templateChooser->get($viewModel);
    }
    
    private function getViewModel(string $view) : ?ViewModel
    {
        if (! $this->container instanceof ContainerInterface) {
            return null;
        }

        try {
            /** @var ViewModel $viewModel */
            return $this->container->get($view);
        } catch (NotFoundExceptionInterface $e) {
            return null;
        }
    }
}
