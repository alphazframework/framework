<?php

namespace Softhub99\Zest_Framework\Validation;

class Validation
{
    protected $messages;
    protected $errors;

    public function __construct($input, $rule, $type = 'input')
    {
        $this->messages = Handler::getMsgs();
        $this->make($input, $rule, $type);
    }

    public function jsonCompile($data, $policie)
    {
        $passed = call_user_func_array([new JsonRules(), $policie], [$data]);
        if ($passed !== true) {
            Handler::set($this->messages[$policie], 'json');
        }
    }

    public function databaseCompile($data, $table)
    {
        $rule = 'unique';
        call_user_func_array([new databaseRules(), $rule], [$data['field'], $data['value'], $table]);
        if ($passed !== true) {
            Handler::set(
                    str_replace(':field', $data['field'], $this->messages[$rule]), $data['field']);
        }
    }

    public function inputCompile(array $data)
    {
        foreach ($data['policies'] as $rule => $policy) {
            $passed = call_user_func_array([new InputRules(), $rule], [$data['value']]);
            if ($passed !== true) {
                Handler::set(
                    str_replace(':field', $data['field'], $this->messages[$rule]), $data['field']);
            }
        }
    }

    public function make($data, $policies, $type)
    {
        if ($type === 'input') {
            foreach ($data as $field => $value) {
                if (array_key_exists($field, $policies)) {
                    $this->inputCompile(
                        ['field' => $field, 'value' => $value, 'policies' => $policies[$field]]
                    );
                }
            }
        } elseif ($type === 'json') {
            $this->jsonCompile($data, $policies);
        } elseif ($type === 'database') {
            $this->databaseCompile($data, $policies);
        }
    }

    public function fail()
    {
        return Handler::has();
    }

    public function error()
    {
        $this->errors = Handler::all();

        return $this;
    }

    public function has($key)
    {
        return (isset($this->errors[$key])) ? true : false;
    }

    public function get($key = null)
    {
        return (isset($key)) ? $this->errors[$key] : $this->errors;
    }

    public function last($key = null)
    {
        return end($this->get($key));
    }

    public function first($key = null)
    {
        return current($this->get($key));
    }
}
