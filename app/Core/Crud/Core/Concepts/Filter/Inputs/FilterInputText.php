<?php

namespace App\Core\Crud\Core\Concepts\Filter\Inputs;

class FilterInputText extends FilterInputBase
{
    public function getComponent(): string
    {
        return 'CrudFilterInputText';
    }
}
