<?php
/**
 * Created by IntelliJ IDEA.
 * User: kernel Huang
 * Email: kernelman79@gmail.com
 * Date: 2018/11/23
 * Time: 1:34 PM
 */

namespace Logs\Services;


use Files\Sync\FileStore;
use Logs\Adapter\StorageAdapter;
use Logs\Processor\FileAsyncProcedure;
use Logs\Processor\FileSyncProcedure;
use Logs\Processor\FileSize;
use Logs\Processor\Filename;
use Services\Config;

class File implements StorageAdapter {

    public static $schema;
    public static $module;
    private static $filename;
    private static $type;       // sync or async, 日志写入方式(同步/异步)

    /**
     * 初始化参数
     *
     * @param $schema
     * @param $module
     * @return mixed|string
     */
    public static function set($schema, $module) {
        self::$schema   = null;
        self::$module   = null;
        self::$filename = null;

        self::$schema   = $schema;
        self::$module   = $module;

        $config         = Config::{self::$schema}();
        $name           = $config::find('module')::next(self::$module);
        self::$filename = $config::get('root') . strtolower($config::get('name')) . '/' . Filename::{$name}();
        self::$type     = $config::get('work');

        return self::class;
    }

    /**
     * 调用文件储存过程类
     *
     * @param $content
     * @return bool|mixed
     * @throws \Exceptions\AlreadyExistsException
     * @throws \Exceptions\InvalidArgumentException
     * @throws \Exceptions\NotFoundException
     * @throws \Exceptions\UnExecutableException
     * @throws \Exceptions\UnReadableException
     * @throws \Exceptions\UnWritableException
     * @throws \Exceptions\UnsavedException
     */
    public static function save($content) {
        if (self::$type === 'sync') {
            $store = new FileSyncProcedure(self::checkSize(), self::checkFile(), self::$filename, $content);
            return $store->begin();
        }

        if (self::$type === 'async') {
            $store = new FileAsyncProcedure(self::checkSize(), self::checkFile(), self::$filename, $content);
            return $store->begin();
        }

        return false;
    }

    /**
     * 检查日志文件是否存在
     *
     * @return bool
     */
    public static function checkFile() {
        return FileStore::checkFile(self::$filename);
    }

    /**
     * 检查日志文件大小
     *
     * @return mixed
     */
    public static function checkSize() {
        return FileSize::{self::$schema}(self::$filename);
    }
}
