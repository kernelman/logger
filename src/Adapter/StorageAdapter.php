<?php
/**
 * Created by IntelliJ IDEA.
 * User: kernel Huang
 * Email: kernelman79@gmail.com
 * Date: 2018/11/23
 * Time: 1:16 PM
 */

namespace Logs\Adapter;


/**
 * Interface StorageAdapter
 * @package Adapter
 */
interface StorageAdapter {

    /**
     * Set data
     *
     * @param $schema
     * @param $module
     * @return mixed
     */
    public static function set($schema, $module);

    /**
     * Save data
     *
     * @param $content
     * @return mixed
     */
    public static function save($content);
}
