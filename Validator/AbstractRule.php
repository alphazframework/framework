<?php

namespace Softhub99\Zest_Framework\Validator;

class AbstractRule
{
    /**
     * Check if the supplied value is empty or not.
     *
     * @param $value that shoud be check
     **/
    public function notBeEmpty($value)
    {
        return ($value !== null && !empty(escape($value))) ? true : false;
    }
}
