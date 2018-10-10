<?php

declare(strict_types=1);


namespace Psren\ViewModelBundle\Templating\NameGuesser;

use Psren\ViewModelBundle\ViewModel;

interface NameGuesser
{

    public function extractName(ViewModel $viewModel): string;
}
