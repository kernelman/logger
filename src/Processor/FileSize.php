<?php
/**
 * Created by IntelliJ IDEA.
 * User: kernel Huang
 * Email: kernelman79@gmail.com
 * Date: 2018/11/21
 * Time: 2:57 PM
 */

namespace Processor;

use Exceptions\InvalidArgumentException;
use Storage\FileStore;

class FileSize {

    private static $limit = 2001; // 单位MB, 日志文件大小设置超过阈值2000MB程序将抛出异常

    /**
     * @param $name
     * @param $arguments
     * @return bool
     * @throws InvalidArgumentException
     */
    public static function __callStatic($name, $arguments) {

        if (count($arguments) == 1) {

            $thresholdSize  = Config::{$name}()::get('size');
            $checkFile      = FileStore::checkFile($arguments[0]);

            if ($checkFile) {

                $fileSize       = filesize($arguments[0]);
                $defaultByte    = self::toBytes($thresholdSize);

                if ($fileSize < $defaultByte) {
                    return true;
                }

            } else {
                return true;
            }
        }

        return false;
    }

    /**
     * 兆字节转成字节(MB to Byte)
     *
     * @param int $bytes
     * @return mixed
     * @throws InvalidArgumentException
     */
    private static function toBytes(int $bytes = 0) {

        // 配置文件设置日志文件大小超出2000MB就抛出异常
        if ($bytes >= self::$limit) {
            throw new InvalidArgumentException('Limit param > ' . self::$limit);
        }

        return Bytes::megabyte($bytes)::toByte();
    }
}
