<?php

declare(strict_types=1);


namespace Psren\ViewModelBundle\Templating\NameGuesser;

use Psren\ViewModelBundle\Templating\NameGuesser\NameGuesser;
use Psren\ViewModelBundle\ViewModel;
use Symfony\Component\Serializer\NameConverter\NameConverterInterface;

final class ByViewModelName implements NameGuesser
{
    /**
     * @var NameConverterInterface
     */
    private $nameConverter;
    /**
     * @var string
     */
    private $extension;
    
    /**
     * @var string
     */
    private $irrelevantNamespaces;

    public function __construct(NameConverterInterface $nameConverter, string $extension, string $irrelevantNamespaces)
    {
        $this->nameConverter = $nameConverter;
        $this->extension = $extension;
        $this->irrelevantNamespaces = $irrelevantNamespaces;
    }

    public function extractName(ViewModel $viewModel): string
    {
        $className = $this->getCleanName(get_class($viewModel));
        $name = $this->nameConverter->normalize($className);
        $name = str_replace('\_', '/', $name);
        
        return $name . $this->extension;
    }

    private function getCleanName(string $class): string
    {
        if (! $this->irrelevantNamespaces) {
            return $class;
        }
        
        $class = preg_replace(explode(',', $this->irrelevantNamespaces), '\\', $class);
       
        return str_replace('\\\\', '', $class);
    }
}
