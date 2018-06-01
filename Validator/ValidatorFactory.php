<?php

namespace src\Classes\Validator;

use src\Classes\Validator\Validator as Validator;

class ValidatorFactory
{
    public function make($request, $rules)
    {
        return new Validator($request, $rules);
    }
}
