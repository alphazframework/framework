<?php

/**
 * This file is part of the Zest Framework.
 *
 * @author Muhammad Umer Farooq (Malik) <mumerfarooqlablnet01@gmail.com>
 *
 * @link https://lablnet.github.io/profile/
 *
 * For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 * @since 3.0.0
 *
 * @license MIT
 */

namespace Zest\Common\Model;

class Model
{
    /**
     * Model.
     *
     * @since 3.0.0
     *
     * @var string
     */
    private $model;

    /**
     * Set the model.
     *
     * @param (string) $model model name
     *
     * @since 3.0.0
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
     * @since 3.0.0
     *
     * @return resource
     */
    public function execute()
    {
        if (class_exists($this->model)) {
            return new $this->model();
        }

        throw new \Exception("The model Class {$this->model} not found", 500);
    }
}
