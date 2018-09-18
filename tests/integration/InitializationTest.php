<?php
namespace Psren\ViewModelBundle;

use Nyholm\BundleTest\BaseBundleTestCase;
use Nyholm\BundleTest\CompilerPass\PublicServicePass;

class InitializationTest extends BaseBundleTestCase
{
    protected function setUp()
    {
        parent::setUp();
        // Make services public that match a regex
        $this->addCompilerPass(new PublicServicePass('|psren_view_model.*|'));
    }
    protected function getBundleClass()
    {
        return ViewModelBundle::class;
    }

    public function testInitBundle()
    {
        $this->bootKernel();
        $container = $this->getContainer();

        $this->assertTrue($container->has('psren_view_model.registry'));
        
        $service = $container->get('psren_view_model.registry');
        $this->assertInstanceOf(ViewModelRegistry::class, $service);
    }
}
