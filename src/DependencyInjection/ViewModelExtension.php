<?php

declare(strict_types=1);


namespace Psren\ViewModelBundle\DependencyInjection;


use Psren\ViewModelBundle\ViewModel;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

final class ViewModelExtension extends Extension
{
    
    public function load(array $configs, ContainerBuilder $container)
    {
        $container
            ->registerForAutoconfiguration(ViewModel::class)
            ->addTag('psren.view_model');
        
        $loader = new XmlFileLoader(
            $container,
            new FileLocator(__DIR__.'/../Resources/config')
        );
        $loader->load('services.xml');
    }

}