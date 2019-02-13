<?php
/**
 * Created by IntelliJ IDEA.
 * User: kernel Huang
 * Email: kernelman79@gmail.com
 * Date: 2018/11/21
 * Time: 1:06 PM
 */

namespace Services;

use Adapter\LogsAdapter;
use Exceptions\NotFoundException;
use Processor\Log;
use Processor\Message;

class Logs implements LogsAdapter {

    use Log;

    const NOT_FOUND = ' Property does not exist in the object: ';

    /**
     * @param $logProperty
     * @return bool|mixed
     * @throws NotFoundException
     */
    public static function debug($logProperty) {
        self::$level    = null;
        self::$level    = Message::LOG_DEBUG;
        $property       = is_array($logProperty) ? (object)$logProperty : $logProperty;

        return Log::process($property);
    }

    /**
     * @param $logProperty
     * @return bool|mixed
     * @throws NotFoundException
     */
    public static function info($logProperty) {
        self::$level    = null;
        self::$level    = Message::LOG_INFO;
        $property       = is_array($logProperty) ? (object)$logProperty : $logProperty;

        return Log::process($property);
    }

    /**
     * @param $logProperty
     * @return bool|mixed
     * @throws NotFoundException
     */
    public static function error($logProperty) {
        self::$level    = null;
        self::$level    = Message::LOG_ERROR;
        $property       = is_array($logProperty) ? (object)$logProperty : $logProperty;

        return Log::process($property);
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
