<?php

namespace App\Repositories;


abstract class Repository
{

    protected static $model;
    protected static $instance;

    /**
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public static function __callStatic($name, $arguments)
    {
        self::getModel();
        return call_user_func_array([static::$model, $name], $arguments);
    }


    /**
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        return call_user_func_array([static::$model, $name], $arguments);
    }

    /**
     * @param $model
     */
    public function setModel($model)
    {
        static::$model = $model;
    }

}