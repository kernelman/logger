<?php
/**
 * Created by IntelliJ IDEA.
 * User: kernel Huang
 * Email: kernelman79@gmail.com
 * Date: 2018/11/25
 * Time: 4:03 AM
 */

namespace Logs\Processor;


use Exceptions\UnsavedException;
use Exceptions\InvalidArgumentException;
use Exceptions\UnWritableException;
use Files\Async\FileAsyncStore;

/**
 * 文件同步写存储过程
 *
 * Class FileSyncProcedure
 * @package Processor
 */
class FileAsyncProcedure {

    private $size       = null;
    private $file       = null;
    private $content    = null;
    private $filename   = null;

    /**
     * 文件存储初始化
     *
     * FileProcedure constructor.
     * @param null $size
     * @param null $file
     * @param null $filename
     * @param null $content
     * @throws InvalidArgumentException
     */
    public function __construct($size = null, $file = null, $filename = null, $content = null) {

        if ($size === null || $file === null || $filename === null || $content === null) {
            throw new InvalidArgumentException('$size: ' . $size . ' || $file: ' . $file . ' || $filename: ' . $filename . ' || $content: ' . $content);
        }

        $this->size     = $size;
        $this->file     = $file;
        $this->content  = $content;
        $this->filename = $filename;
    }

    /**
     * 开始文件存储过程
     *
     * @return bool
     * @throws InvalidArgumentException
     * @throws UnWritableException
     * @throws UnsavedException
     * @throws \Exceptions\AlreadyExistsException
     * @throws \Exceptions\NotFoundException
     * @throws \Exceptions\UnExecutableException
     * @throws \Exceptions\UnReadableException
     */
    public function begin() {
        return $this->files() ?: $this->nonFile() ?: $this->nonSize();
    }

    /**
     * 文件大小没有超过阈值且文件存在
     *
     * @return bool
     * @throws InvalidArgumentException
     * @throws UnWritableException
     * @throws UnsavedException
     * @throws \Exceptions\AlreadyExistsException
     * @throws \Exceptions\NotFoundException
     * @throws \Exceptions\UnExecutableException
     * @throws \Exceptions\UnReadableException
     */
    private function files() {
        if ($this->size && $this->file) {
            $save = FileAsyncStore::save($this->filename, $this->content);

            if ($save) {
                return true;
            }

            throw new UnsavedException($this->filename);
        }

        return false;
    }

    /**
     * 文件大小没有超过阈值且文件不存在
     *
     * @return bool
     */
    private function nonFile() {
        try {

            if ($this->size && !$this->file && $this->buildDir()) {
                $save = FileAsyncStore::save($this->filename, $this->content);

                if ($save) {
                    return true;
                }
            }

            return false;

        } catch (\Exception $exception) {
            echo $exception->getMessage();
        }

        return false;
    }

    /**
     * 文件大小超过阈值
     *
     * @return bool
     */
    private function nonSize() {
        try {

            if (!$this->size && $this->file && $this->rebuildFile()) {
                $save = FileAsyncStore::save($this->filename, $this->content);

                if ($save) {
                    return true;
                }
            }

            return false;

        } catch (\Exception $exception) {
            echo $exception->getMessage();
        }

        return false;
    }

    /**
     * @return bool
     */
    private function buildParentDir() {
        try {
            $parentDir          = dirname(dirname($this->filename));
            $checkParentDir     = FileAsyncStore::checkDir($parentDir);

            if (!$checkParentDir) {
                $createParentDir = FileAsyncStore::createDir($parentDir);

                if ($createParentDir) {
                    return true;
                }

                throw new UnWritableException($parentDir);
            }

            return true;

        } catch (\Exception $exception) {
            echo $exception->getMessage();
        }

        return false;
    }

    /**
     * @return bool
     */
    private function buildCurrentDir() {
        try {
            $currentDir         = dirname($this->filename);
            $checkCurrentDir    = FileAsyncStore::checkDir($currentDir);

            if (!$checkCurrentDir) {
                $createCurrentDir = FileAsyncStore::createDir($currentDir);

                if ($createCurrentDir) {
                    return true;
                }

                throw new UnWritableException($currentDir);
            }

            return true;

        } catch (\Exception $exception) {
            echo $exception->getMessage();
        }

        return false;
    }

    /**
     * @return bool
     */
    private function buildDir() {
        if ($this->buildParentDir() && $this->buildCurrentDir()) {
            return true;
        }

        return false;
    }

    /**
     * @return bool
     */
    private function rebuildFile() {
        try {
            $newFiles   = $this->filename . Filename::now();
            $rebuild    = FileAsyncStore::moveFile($this->filename, $newFiles);

            if ($rebuild) {
                return true;
            }

            throw new UnWritableException($this->filename . ' move to ' . $newFiles);

        } catch (\Exception $exception) {
            echo $exception->getMessage();
        }

        return false;
    }

    public function __destruct() {
        unset($this->size);
        unset($this->file);
        unset($this->content);
        unset($this->filename);
    }
}
