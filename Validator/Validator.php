<?php

namespace src\Classes\Validator;

use src\Interfaces\Validator\ValidatorInterface as ValidatorInterface;

class Validator implements ValidatorInterface
{
    /**
     * @var error [type of : array] : store the validation errors
     */
    public $errors = [];

    /**
     * @var errorsStyle [type of : array] : store the errors text style
     */
    protected $errorsStyle = [
      'maxError'       => 'Max length allowed',
      'minError'       => 'Min length allowed',
      'emptyError'     => 'This Field is required',
      'notString'      => 'This field must be a alphabetic character(s)',
      'notNum'         => 'This field must be a numeric character(s)',
      'notEmail'       => 'Type of this field must be email',
      'notUrl'         => 'Type of this field must be url',
      'notWorking'     => 'The url of this website not working',
    ];

    /**
     * function <__construct>
     * the function used to compile the validation rules into a booleans.
     */
    public function __construct($request, $rules)
    {
        $this->compile($request, $rules);
    }

    /**
     * Descriptions: src/Interfaces/Validator/ValidatorInterface.php Line: 13.
     */
    public function compile($request, $rules)
    {
        foreach ($rules as $inputName => $rules) {
            $rules = explode(',', $rules);

            foreach ($rules as $rule) {
                $rule = explode(':', $rule);
                $ruleName = $rule[0];
                $ruleValue = $rule[1];
                switch ($ruleName) {

                    case 'required':
                        ($ruleValue === 'true') ? $this->makeItRequired($request, $inputName) : null;
                    break;

                    case 'min':
                        $this->min($request, $inputName, $ruleValue);
                    break;

                    case 'max':
                        $this->max($request, $inputName, $ruleValue);
                    break;

                    case 'cleanHtml':
                        ($ruleValue === 'true') ? $inputValue = $this->cleanHtml($request, $inputName) : $inputValue = $request->get($inputName);
                    break;

                    case 'type':
                        $this->typeof($ruleValue, $inputName, $inputValue);
                    break;

                }
            }
        }
    }

    /**
     * Descriptions: src/Interfaces/Validator/ValidatorInterface.php Line: 22.
     */
    public function makeItRequired($request, $inputName)
    {
        (empty($request->get($inputName))) ? $this->errors[$inputName] = $this->errorsStyle['emptyError'] : true;
    }

    /**
     * Descriptions: src/Interfaces/Validator/ValidatorInterface.php Line: 32.
     */
    public function max($request, $inputName, $value)
    {
        return (strlen($request->get($inputName)) >= $value) ? $this->errors[$inputName] = $this->errorsStyle['maxError'].' '.$value : true;
    }

    /**
     * Descriptions: src/Interfaces/Validator/ValidatorInterface.php Line: 42.
     */
    public function min($request, $inputName, $value)
    {
        return (strlen($request->get($inputName)) <= $value) ? $this->errors[$inputName] = $this->errorsStyle['minError'].' '.$value : true;
    }

    /**
     * Descriptions: src/Interfaces/Validator/ValidatorInterface.php Line: 51.
     */
    public function cleanHtml($request, $inputName)
    {
        return strip_tags($request->get($inputName));
    }

    /**
     * Descriptions: src/Interfaces/Validator/ValidatorInterface.php Line: 61.
     */
    public function typeof($type, $inputName, $inputValue)
    {
        if ($type === 'string') {
            return (ctype_alpha($inputValue)) ? true : $this->errors[$inputName] = $this->errorsStyle['notString'];
        }
        if ($type === 'int') {
            return (ctype_digit($inputValue)) ? true : $this->errors[$inputName] = $this->errorsStyle['notNum'];
        }
        if ($type === 'email') {
            return (filter_var($inputValue, FILTER_VALIDATE_EMAIL)) ? true : $this->errors[$inputName] = $this->errorsStyle['notEmail'];
        }
        if ($type === 'url') {
            return (filter_var($inputValue, FILTER_VALIDATE_URL)) ? true : $this->errors[$inputName] = $this->errorsStyle['notUrl'];
        }
        if ($type === 'Aurl') {
            return (gethostbyname($inputValue) === $inputValue) ? true : $this->errors[$inputName] = $this->errorsStyle['notWorking'];
        }
    }
}
