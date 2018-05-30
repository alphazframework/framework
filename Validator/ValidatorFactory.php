<?php

namespace Softhub99\Zest_Framework\Validator;

use Softhub99\Zest_Framework\Validator\Validator as Validator;

class ValidatorFactory {

    public function make($rules) {
		return new Validator($rules);
    }

}