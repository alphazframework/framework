<?php

namespace Softhub99\Zest_Framework\Validator;

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
     * method <__construct>
     * the method used to compile the validation rules into a booleans.
     */
    public function __construct($rules)
    {
        $this->compile($rules);
    }

    /**
     * The method used to compile the rules into a booleans and store the errors in the @var errors.
     *
     * @param
     *  rules [type of : array] : the validation rules
     *
     * @return boolean/error
     */
    public function compile($rules)
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
     * The method used to check if the input is not empty.
     *
     * @param inputName [tyoe of : string] : the input name
     *
     * @return error or true
     */
    public function makeItRequired($inputName)
    {
        if (input($inputName)) {
            return true;
        } else {
            $this->errors[$inputName] = $this->errorsStyle['emptyError'];
        }
    }

    /**
     * The method used to check the length of the input value.
     *
     * @param inputName [type of : string] : the input name
     * value [type of : int] : the rule value
     *
     * @return string
     **/
    public function max($inputName, $value)
    {
        if (strlen(input($inputName)) >= $value) {
            $this->errors[$inputName] = $this->errorsStyle['maxError'].' '.$value;
        } else {
            return true;
        }
    }

    /**
     * The method used to check the length of the input value.
     *
     * @param inputName [type of : string] : the input name
     * value [type of : int] : the rule value
     *
     * @return string
     */
    public function min($inputName, $value)
    {
        if (strlen(input($inputName)) <= $value) {
            $this->errors[$inputName] = $this->errorsStyle['minError'].' '.$value;
        } else {
            return true;
        }
    }

    /**
     * The method used the strip tags function to delete html codes.
     *
     * @param inputName [type of : string] : the input name
     *
     * @return string
     */
    public function cleanHtml($inputName)
    {
        return escape(input($inputName));
    }

    /**
     * the method used to check the type of the input value with the type given>.
     *
     * @param
     * type [type of : string] : the rule value
     * inputName [type of : string] : the input name
     * inputValue [type of : text] : the input value
     *
     * @return error | true
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
