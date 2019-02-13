<?php
/**
 * Created by IntelliJ IDEA.
 * User: kernel Huang
 * Email: kernelman79@gmail.com
 * Date: 2018/11/21
 * Time: 3:01 PM
 */

namespace Processor;

use Exceptions\InvalidArgumentException;
use Exceptions\NotFoundException;
use Storage\FileStore;

/**
 * 获取配置文件
 *
 * Class Config
 * @package Processor
 */
class Config {

    private static $config      = null;
    private static $configName  = null;
    private static $parent      = null;

    /**
     * 通过配置名称加载配置文件
     *
     * @param $name // 配置文件名
     * @param $arguments
     * @return string
     */
    public static function __callStatic($name, $arguments) {
        self::$configName  = null;
        self::$configName  = strtolower($name);

        try {

            $path = '../config/' . self::$configName . '.php';
            if (FileStore::checkFile($path)) {
                self::$config = include $path;

                if (!is_object(self::$config)) {
                    throw new InvalidArgumentException(self::$configName . ' value must be the object');
                }
            }

        } catch (\Exception $exception) {
            echo $exception->getMessage();
        }

        return self::class;
    }

    /**
     * 检查配置文件属性是否存在
     *
     * @param $property
     * @return mixed
     * @throws NotFoundException
     */
    public static function get($property) {
        try {

            if(property_exists(self::$config, $property)) {

                $result = self::$config->{$property};

                if(is_string($result) || is_int($result)) {
                    return $result;
                }

                if(is_object($result)) {
                    self::$parent = null;
                    self::$parent = $result;

                    return self::class;
                }

                if(is_array($result)) {
                    self::$parent = null;
                    self::$parent = (object)$result;

                    return self::class;
                }

                throw new InvalidArgumentException($property . ' value must be the string or int or array or object');

            }

        } catch (\Exception $exception) {
            echo $exception->getMessage();
        }

        throw new NotFoundException($property . ' property at ' . self::$configName . ' config');
    }

    /**
     * @param $property
     * @return string
     * @throws NotFoundException
     */
    public static function next($property) {
        try {

            if(property_exists(self::$parent, $property)) {

                $result = self::$parent->{$property};

                if(is_string($result) || is_int($result)) {
                    return $result;
                }

                if(is_object($result)) {
                    self::$parent = null;
                    self::$parent = $result;

                    return self::class;
                }

                if(is_array($result)) {
                    self::$parent = null;
                    self::$parent = (object)$result;

                    return self::class;
                }

                throw new InvalidArgumentException($property . ' value must be the string or int or array or object');
            }

        } catch (\Exception $exception) {
            echo $exception->getMessage();
        }

        throw new NotFoundException($property . ' property at ' . self::$configName . ' config');
    }
}
