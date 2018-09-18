<?php

declare(strict_types=1);


namespace Psren\ViewModelBundle\Templating;

use Psren\ViewModelBundle\ViewModel;

interface TemplateChooser
{

    public function get(ViewModel $viewModel): string;
}
