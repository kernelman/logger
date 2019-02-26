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
        if (!self::getEnable() && !self::getShow()) {
            return false;
        }

        self::$level    = null;
        self::$level    = Message::LOG_DEBUG;

        return self::process($logProperty);
    }

    /**
     * @param $logProperty
     * @return bool|mixed
     * @throws NotFoundException
     * @throws \Exceptions\InvalidArgumentException
     * @throws \Exceptions\UnFormattedException
     */
    public static function info($logProperty) {
        if (!self::getEnable() && !self::getShow()) {
            return false;
        }

        self::$level = null;
        self::$level = Message::LOG_INFO;

        return self::process($logProperty);
    }

    /**
     * @param $logProperty
     * @return bool|mixed
     * @throws NotFoundException
     * @throws \Exceptions\InvalidArgumentException
     * @throws \Exceptions\UnFormattedException
     */
    public static function error($logProperty) {
        if (!self::getEnable() && !self::getShow()) {
            return false;
        }

        self::$level = null;
        self::$level = Message::LOG_ERROR;

        return self::process($logProperty);
    }

    /**
     * @todo
     * @return mixed|void
     */
    public static function notice() {
    }

    /**
     * @todo
     * @return mixed|void
     */
    public static function warning() {
    }

    /**
     * @todo
     * @return mixed|void
     */
    public static function critical() {
    }

    /**
     * @todo
     * @return mixed|void
     */
    public static function alert() {
    }

    /**
     * @todo
     * @return mixed|void
     */
    public static function emergency() {
    }

    /**
     * @todo
     * @return mixed|void
     */
    public static function fatal() {

    }

    /**
     * @todo
     * @return mixed|void
     */
    public static function success() {
    }
}
