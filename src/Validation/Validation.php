<?php

/**
 * This file is part of the Zest Framework.
 *
 * @author   Muhammad Umer Farooq <lablnet01@gmail.com>
 * @author-profile https://www.facebook.com/Muhammadumerfarooq01/
 *
 * For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 *
 * @license MIT
 */

namespace Zest\Validation;

class Validation
{
    /*
     * Messages
    */
    protected $messages;
    /*
     * Errors
    */
    protected $errors;

    /**
     * Compile input.
     *
     * @param $input input value
     *        $role   required etc
     *        $type input
     *
     * @return string
     */
    public function __construct($input, $rule, $type = 'input')
    {
        $this->messages = Handler::getMsgs();
        $this->make($input, $rule, $type);
    }

    /**
     * Compile Json.
     *
     * @param $data (array)
     *              ['policies'] => policies
     *              ['value']  => Value to be checked
     *              ['field'] => field name
     *
     * @return string
     */
    public function jsonCompile($data, $policie)
    {
        $passed = call_user_func_array([new JsonRules(), $policie], [$data]);
        if ($passed !== true) {
            Handler::set($this->messages[$policie], 'json');
        }
    }

    /**
     * Compile Database Unique.
     *
     * @param $data (array)
     *              ['policies'] => policies
     *              ['value']  => Value to be checked
     *              ['field'] => field name
     *
     * @return string
     */
    public function databaseCompile($data, $table)
    {
        $rule = 'unique';
        $passed = call_user_func_array([new databaseRules(), $rule], [$data['field'], $data['value'], $table]);
        if ($passed !== true) {
            Handler::set(
                    str_replace(':field', $data['field'], $this->messages[$rule]), $data['field']);
        }
    }

    /**
     * Compile input.
     *
     * @param $data (array)
     *              ['policies'] => policies
     *              ['value']  => Value to be checked
     *              ['field'] => field name
     *
     * @return string
     */
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

    /**
     * Compile input.
     *
     * @param $data (array)
     *              ['policies'] => policies
     *              ['value']  => Value to be checked
     *              ['field'] => field name
     *
     * @return string
     */
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

    /**
     * Check if their any error exists.
     *
     * @return bool
     */
    public function fail()
    {
        return Handler::has();
    }

    /**
     * Store error msgs.
     *
     * @return this
     */
    public function error()
    {
        $this->errors = Handler::all();

        return $this;
    }

    /**
     * Check whether the error has or not.
     *
     * @param $key key of error msg
     *
     * @return string
     */
    public function has($key)
    {
        return (isset($this->errors[$key])) ? true : false;
    }

    /**
     * Get the error msg.
     *
     * @param $key key of error msg
     *
     * @return string
     */
    public function get($key = null)
    {
        return (isset($key)) ? $this->errors[$key] : $this->errors;
    }

    /**
     * Get the last error msg.
     *
     * @param $key key of error msg
     *
     * @return string
     */
    public function last($key = null)
    {
        return end($this->get($key));
    }

    /**
     * Get the first error msg.
     *
     * @param $key key of error
     *
     * @return string
     */
    public function first($key = null)
    {
        return current($this->get($key));
    }
}
