<?php

declare(strict_types=1);


namespace Psren\ViewModelBundle;

use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;

class ViewModelRegistryTest extends TestCase
{
    protected function viewModelGenerator(array $models = []): \Generator
    {
        foreach ($models as $model) {
            yield $model;
        }
    }
    
    public function testItFindsTheViewModel()
    {
        $vm1 = $this
            ->getMockBuilder(ViewModel::class)
            ->setMockClassName('foo')
            ->getMock();
        
        $vm2 = $this->getMockBuilder(ViewModel::class);
        

        $registry = new ViewModelRegistry($this->viewModelGenerator([$vm2, $vm1]));
        
        $this->assertSame($vm1, $registry->get('foo'));
    }
    
    public function testServiceNotFound()
    {
        $registry = new ViewModelRegistry($this->viewModelGenerator());
        
        $this->expectException(ServiceNotFoundException::class);
        
        $registry->get('foo');
    }
}
