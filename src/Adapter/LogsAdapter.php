<?php
/**
 * Created by IntelliJ IDEA.
 * User: kernel Huang
 * Email: kernelman79@gmail.com
 * Date: 2018/11/21
 * Time: 12:23 PM
 */

namespace Logs\Adapter;

/**
 * Interface LogsAdapter
 * @package Adapter
 */
interface LogsAdapter {

    /**
     * @param $content
     * @return mixed
     */
    public static function debug($content);     // 调试

    /**
     * @param $content
     * @return mixed
     */
    public static function info($content);      // 输出信息

    /**
     * @return mixed
     */
    public static function notice();            // 提示

    /**
     * @return mixed
     */
    public static function warning();           // 警告

    /**
     * @param $content
     * @return mixed
     */
    public static function error($content);     // 错误

    /**
     * @return mixed
     */
    public static function critical();

    /**
     * @return mixed
     */
    public static function alert();

    /**
     * @return mixed
     */
    public static function emergency();

    /**
     * @return mixed
     */
    public static function fatal();             // 严重错误

    /**
     * @return mixed
     */
    public static function success();           // 成功
}
