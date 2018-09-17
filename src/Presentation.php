<?php

declare(strict_types=1);


namespace Psren\ViewModelBundle;


use Symfony\Component\HttpFoundation\Response;

/**
 * @internal
 */
final class Presentation
{

    /**
     * @var string
     */
    private $view;
    
    /**
     * @var ViewModel
     */
    private $viewModel;
    
    /**
     * @var Response
     */
    private $response;
    
    /**
     * @var array
     */
    private $data;

    public function __construct(string $view, ViewModel $viewModel, Response $response, array $data)
    {
        $this->view = $view;
        $this->viewModel = $viewModel;
        $this->response = $response;
        $this->data = $data;
    }

    public function getView(): string
    {
        return $this->view;
    }

    public function getResponse(): Response
    {
        return $this->response;
    }

    public function getData(): array
    {
        return array_merge($this->viewModel->getData(), $this->data);
    }
    
}