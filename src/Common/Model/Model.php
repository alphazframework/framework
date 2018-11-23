<?php

/**
 * This file is part of the Zest Framework.
 *
 * @author   Malik Umer Farooq <lablnet01@gmail.com>
 * @author-profile https://www.facebook.com/malikumerfarooq01/
 *
 * For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 *
 * @license MIT
 */

namespace Zest\Common\Model;

class Model
{
    /*
     * Model
    */
    private $model;

    /**
     * Set the model.
     *
     * @param $set model name
     *
     * @return resource
     */
    public function set($model)
    {
        $this->model = '\App\Models\\'.$model;

        return $this;
    }

    /**
     * Get the instance of model class.
     *
     * @return resource
     */
    public function execute()
    {
        if (class_exists($this->model)) {
            return new $this->model();
        }

        throw new \Exception("Class {$this->model} not found", 500);
    }
}
