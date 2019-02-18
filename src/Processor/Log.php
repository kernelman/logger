<?php
/**
 * Class Log
 *
 * Author:  Kernel Huang
 * Mail:    kernelman79@gmail.com
 * Date:    12/6/18
 * Time:    3:32 PM
 */

namespace Logs\Processor;


use Exceptions\NotFoundException;
use Services\Config;

trait Log {

    protected static $env     = null;
    protected static $level   = null;

    /**
     * @param $property
     * @return bool
     * @throws NotFoundException
     * @throws \Exceptions\InvalidArgumentException
     * @throws \Exceptions\UnFormattedException
     */
    public static function process($property) {
        self::$env      = null;
        $property       = is_array($property) ? (object)$property : $property;

        if (self::verify($property)) {

            self::$env  = self::getEnv($property);
            $store      = self::storeProcess($property);
            $models     = self::models($property);
            $content    = self::export($models, new ExportTypes());

            return $store::save($content);
        }

        return false;
    }

    /**
     * 判断日志模型属性是否存在
     *
     * @param $object
     * @param $property
     * @return mixed
     * @throws NotFoundException
     */
    private static function property($object, $property) {
        if (property_exists($object, $property)) {
            return true;
        }

        throw new NotFoundException($property . self::NOT_FOUND . 'logs');
    }

    /**
     * @param $property
     * @return bool
     * @throws NotFoundException
     */
    private static function verify($property) {
        $schema = self::property($property, 'schema');
        $module = self::property($property, 'module');

        if ($schema && $module) {
            return true;
        }

        return false;
    }

    /**
     * @param $property
     * @param $key
     * @return mixed
     */
    private static function getConfig($property, $key) {
        $config = Config::{$property->schema}();
        return $config::get($key);
    }

    /**
     * @param $property
     * @return mixed
     */
    private static function getEnv($property) {
        return self::getConfig($property, 'env');
    }

    /**
     * @return mixed
     */
    private static function getEnable() {
        $config = Config::logs();
        return $config::get('enable');
    }

    /**
     * @param $property
     * @return mixed
     * @throws NotFoundException
     */
    private static function storeProcess($property) {
        $store  = self::getConfig($property, 'store');

        if (class_exists($store)) {
            return $store::set($property->schema, $property->module);
        }

        throw new NotFoundException('Class: ' . $store);
    }

    /**
     * Export data formatting.
     *
     * @param object $models
     * @param ExportTypes $export
     * @return bool|false|string
     * @throws \Exceptions\InvalidArgumentException
     * @throws \Exceptions\UnFormattedException
     */
    private static function export($models, ExportTypes $export) {
        $content = '';

        if (self::$env === 'pro') {
            $content = $export->json($models, self::$level);
        }

        if (self::$env === 'dev') {
            $content = $export->text($models, self::$level);
        }

        return $content;
    }

    /**
     * Instance log models.
     *
     * @param $property
     * @return mixed
     */
    private static function models($property) {
        $models     = self::getConfig($property, 'models');
        $instance   = $models . $property->schema;

        return new $instance($property, self::$level, self::$env);
    }
}
