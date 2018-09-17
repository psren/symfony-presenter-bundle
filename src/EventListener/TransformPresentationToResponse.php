<?php

declare(strict_types=1);


namespace Psren\ViewModelBundle\EventListener;


use Psr\Container\ContainerInterface;
use Psren\ViewModelBundle\Presentation;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;

final class TransformPresentationToResponse
{

    /**
     * @var ContainerInterface
     */
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }
    
    public function onKernelView(GetResponseForControllerResultEvent $event)
    {
        $result = $event->getControllerResult();
        if (! $result instanceof Presentation) {
            return;
        }
        
        $view = $result->getView();
        $parameters = $result->getData();
        $response = $result->getResponse();

        if ($this->container->has('templating')) {
            $content = $this->container->get('templating')->render($view, $parameters);
        } elseif ($this->container->has('twig')) {
            $content = $this->container->get('twig')->render($view, $parameters);
        } else {
            throw new \LogicException('You can not use "ViewModels" if the Templating Component or the Twig Bundle are not available. Try running "composer require symfony/twig-bundle".');
        }
        
        $response->setContent($content);
        $event->setResponse($response);
    }

}