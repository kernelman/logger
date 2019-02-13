<?php
/**
 * Class Formatted
 *
 * Author:  Kernel Huang
 * Mail:    kernelman79@gmail.com
 * Date:    12/5/18
 * Time:    1:37 PM
 */

namespace Processor;


use Exceptions\UnFormattedException;

/**
 * Class Formatted
 * @package Processor
 */
class Formatted {

    /**
     * @param $property
     * @return bool|false|string
     * @throws UnFormattedException
     */
    public static function boot($property) {
        return self::isString($property) ?: self::isObject($property) ?: self::isArray($property);
    }

    /**
     * @param $property
     * @return bool
     */
    public static function isString($property) {
        if(is_string($property)) {
            return $property;
        }

        return false;
    }

    /**
     * @param $property
     * @return bool|false|string
     * @throws UnFormattedException
     */
    public static function isArray($property) {
        if(is_array($property)) {
            return self::toJson($property);
        }

        return false;
    }

    /**
     * @param $property
     * @return bool|false|string
     * @throws UnFormattedException
     */
    public static function isObject($property) {
        if(is_object($property)) {
            return self::toJson($property);
        }

        return false;
    }

    /**
     * @param $property
     * @param int $type
     * @return false|string
     * @throws UnFormattedException
     */
    public static function toJson($property, $type = JSON_UNESCAPED_SLASHES) {

        try {

            return json_encode($property, $type);

        } catch (\Exception $exception) {

            throw new UnFormattedException($exception->getMessage());
        }
    }
}
