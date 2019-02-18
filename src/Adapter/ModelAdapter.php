<?php
/**
 * Class ModelAdapter
 *
 * Author:  Kernel Huang
 * Mail:    kernelman79@gmail.com
 * Date:    11/29/18
 * Time:    9:51 PM
 */

namespace Logs\Adapter;


/**
 * Interface ModelAdapter
 * @package Adapter
 */
interface ModelAdapter {

    /**
     * 设置日志记录时间
     */
    public function setTime();

    /**
     * 设置用户
     */
    public function setUser();

    /**
     * 设置用户IP
     */
    public function setIp();

    /**
     * 设置状态码
     */
    public function setStatusCode();
}
