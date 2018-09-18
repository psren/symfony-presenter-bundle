<?php

declare(strict_types=1);


namespace Psren\ViewModelBundle;

interface ViewModel
{

    /**
     * The data which should be passed to the view
     *
     * @return array
     */
    public function getData(): array;
}
