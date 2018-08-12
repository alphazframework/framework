<?php

namespace Zest\Validation;

class StickyRules
{
    public function notBeEmpty($value)
    {
        return (!empty($value)) ? true : false;
    }

    public function removeSpaces($value)
    {
        return escape($value);
    }
}
