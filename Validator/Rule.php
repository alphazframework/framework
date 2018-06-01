<?php

namespace Softhub99\Zest_Framework\Validator;

class Rule extends AbstractRule
{
    /**
     * @param
     * $column, field name
     * $value, value passed into the form
     * $policy, the rule that e set e.g min = 10
     * bool, true : false
     */
    public function require($column, $value, $policy)
    {
        return $this->notBeEmpty($value);
    }

    public function min($column, $value, $policy)
    {
        return ($this->notBeEmpty($value)) ? strlen($value) >= $policy : false;
    }

    public function max($column, $value, $policy)
    {
        return ($this->notBeEmpty($value)) ? strlen($value) <= $policy : false;
    }

    public function email($column, $value, $policy)
    {
        return ($this->notBeEmpty($value)) ? filter_var($value, FILTER_SANITIZE_EMAIL) : false;
    }

    public function aplhaNum($column, $value, $policy)
    {
        return ($this->notBeEmpty($value)) ? ctype_alnum($value) : false;
    }

    public function Num($column, $value, $policy)
    {
        return ($this->notBeEmpty($value)) ? ctype_digit($value) : false;
    }

    public function ip($column, $value, $policy)
    {
        return ($this->notBeEmpty($value)) ? filter_var($value, FILTER_VALIDATE_IP) : false;
    }

    public function string($column, $value, $policy)
    {
        return ($this->notBeEmpty($value)) ? ctype_alpha($value) : false;
    }

    public function url($column, $value, $policy)
    {
        return ($this->notBeEmpty($value)) ? filter_var($value, FILTER_VALIDATE_URL) : false;
    }
}
