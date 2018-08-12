<?php

namespace Zest\Validation;

class JsonRules extends StickyRules
{
    public function validate($value)
    {
        if ($this->notBeEmpty($value)) {
            $value = json_decode($value);
            if ($value !== null) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}
