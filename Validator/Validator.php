<?php

namespace Softhub99\Zest_Framework\Validator;

class Validator
{
    protected static $messages;

    protected static $handler;

    protected static $customMessages;

    protected static $errors;

    public function __construct(array $data, array $rules, $customValidationErrorMessages = [])
    {
        static::create($data, $rules, $customValidationErrorMessages);
    }

    /**
     * Perform validation for data.
     *
     * @param $data
     **/
    public function parseData(array $data)
    {
        $field = $data['field'];
        foreach ($data['policies'] as $rule => $policy) {
            $passes = call_user_func_array([new Rule(), $rule], [$field, $data['value'], $policy]);
            if (!$passes) {
                Handler::set(
                    str_replace(
                        [':attribute', ':policy', '_'],
                        [$field, $policy, ' '], static::$messages[$rule]), $field
                );
            }
        }
    }

    /**
     * Create the error msg.
     *
     * @param
     * $data, fields and values pair under validation
     * $policies, the rules that validation must satisfy
     * $messages, custom validation messages
     *
     * @return void
     **/
    public function create(array $data, array $policies, array $messages = [])
    {
        static::$customMessages = $messages;
        static::$messages = Handler::getValidationMessages(static::$customMessages);
        foreach ($data as $field => $value) {
            if (in_array($field, array_keys($policies))) {
                static::parseData(
                    ['field' => $field, 'value' => $value, 'policies' => $policies[$field]]
                );
            }
        }
    }

    /**
     * Check if validation failed.
     *
     * @return bool
     */
    public function fail()
    {
        return Handler::has();
    }

    /**
     * Set the error messages.
     *
     * @return $this
     */
    public function error()
    {
        static::$errors = Handler::all();
    }

    /**
     * Check if a given key exists in array.
     *
     * @param $key
     *
     * @return bool
     */
    public function isKey($key)
    {
        return (array_key_exists($key, static::$errors)) ? true : false;
    }

    /**
     * Get the first error in the validation error array for given key.
     *
     * @param  $key
     *
     * @return mixed
     */
    public function first($key = null)
    {
        return current(static::$errors[$key]);
    }

    /**
     * Get the last error in the validation error array for given key.
     *
     * @param  $key
     *
     * @return mixed
     */
    public function last($key = null)
    {
        return end(static::$errors[$key]);
    }

    /**
     * Get all error messages or all errors under a specified key.
     *
     * @param $key
     *
     * @return mixed
     */
    public function get($key = null)
    {
        return (isset($key)) ? static::$errors[$key] : static::$errors;
    }
}
