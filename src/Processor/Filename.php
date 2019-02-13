<?php
/**
 * Created by IntelliJ IDEA.
 * User: kernel Huang
 * Email: kernelman79@gmail.com
 * Date: 2018/11/21
 * Time: 2:43 PM
 */

namespace Processor;

/**
 * Class FilenameProcessor
 * @package Src\Processor
 */
class Filename {

    private static $name = null;

    /**
     * 生成文件名
     *
     * @param $name
     * @param $arguments
     * @return string
     */
    public static function __callStatic($name, $arguments) {
        self::$name = null;
        self::$name = $name . '.log.'. date("Ymd", time());

        return self::$name;
    }

    /**
     * 生成新文件后缀名
     *
     * @return string
     */
    public static function now() {
        return '.' . date('His', time());
    }
}
