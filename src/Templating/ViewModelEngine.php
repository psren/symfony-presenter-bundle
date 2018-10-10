<?php

declare(strict_types=1);


namespace Psren\ViewModelBundle\Templating;

use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psren\ViewModelBundle\Templating\NameGuesser\NameGuesser;
use Psren\ViewModelBundle\ViewModel;
use Symfony\Component\Templating\EngineInterface;
use Symfony\Component\Templating\StreamingEngineInterface;
use Symfony\Component\Templating\TemplateReferenceInterface;

final class ViewModelEngine implements EngineInterface, StreamingEngineInterface
{

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var NameGuesser
     */
    private $nameGuesser;
    
    /**
     * @var EngineInterface
     */
    private $engine;
    
    /**
     * @var StreamingEngineInterface
     */
    private $streamingEngine;

    public function __construct(
        ContainerInterface $container,
        NameGuesser $nameGuesser,
        EngineInterface $engine,
        StreamingEngineInterface $streamingEngine
    )
    {
        $this->container = $container;
        $this->nameGuesser = $nameGuesser;
        $this->engine = $engine;
        $this->streamingEngine = $streamingEngine;
    }

    public function render($name, array $parameters = array())
    {
        $viewModel = $this->container->get($name);
        $view = $this->nameGuesser->extractName($viewModel);
        $parameters = $this->mergeParameters($viewModel, $parameters);
        
        return $this->engine->render($view, $parameters);
    }

    public function stream($name, array $parameters = array())
    {
        $viewModel = $this->container->get($name);
        $view = $this->nameGuesser->extractName($viewModel);
        $parameters = $this->mergeParameters($viewModel, $parameters);

        return $this->streamingEngine->stream($view, $parameters);
    }

    public function exists($name) : bool
    {
        return $this->supports($name);
    }

    public function supports($name) : bool
    {
        try {
            $this->container->get($name);
        } catch (NotFoundExceptionInterface $e) {
            return false;
        }
        
        return true;
    }

    private function mergeParameters(ViewModel $viewModel, array $parameters = []) : array
    {
        return array_merge($viewModel->getData(), $parameters);
    }

}