<?php
/**
 * Created by IntelliJ IDEA.
 * User: kernel Huang
 * Email: kernelman79@gmail.com
 * Date: 2018/11/21
 * Time: 1:06 PM
 */

namespace Logs\Services;

use Exceptions\NotFoundException;
use Message\Message;
use Logs\Adapter\LogsAdapter;
use Logs\Processor\Log;

class Logs implements LogsAdapter {

    use Log;

    const NOT_FOUND = ' Property does not exist in the object: ';

    /**
     * @param $logProperty
     * @return bool|mixed
     * @throws NotFoundException
     * @throws \Exceptions\InvalidArgumentException
     * @throws \Exceptions\UnFormattedException
     */
    public static function debug($logProperty) {
        self::$level    = null;
        self::$level    = Message::LOG_DEBUG;
        $property       = is_array($logProperty) ? (object)$logProperty : $logProperty;

        return self::process($property);
    }

    /**
     * @param $logProperty
     * @return bool|mixed
     * @throws NotFoundException
     * @throws \Exceptions\InvalidArgumentException
     * @throws \Exceptions\UnFormattedException
     */
    public static function info($logProperty) {
        self::$level    = null;
        self::$level    = Message::LOG_INFO;
        $property       = is_array($logProperty) ? (object)$logProperty : $logProperty;

        return self::process($property);
    }

    /**
     * @param $logProperty
     * @return bool|mixed
     * @throws NotFoundException
     * @throws \Exceptions\InvalidArgumentException
     * @throws \Exceptions\UnFormattedException
     */
    public static function error($logProperty) {
        self::$level    = null;
        self::$level    = Message::LOG_ERROR;
        $property       = is_array($logProperty) ? (object)$logProperty : $logProperty;

        return self::process($property);
    }

    public static function notice() {

    }

    public static function warning() {

    }

    public static function critical() {

    }

    public static function alert() {

    }

    public static function emergency() {

    }

    public static function fatal() {

    }

    public static function success() {

    }
}
