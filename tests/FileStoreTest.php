<?php
/**
 * Created by IntelliJ IDEA.
 * User: kernel Huang
 * Email: kernelman79@gmail.com
 * Date: 2018/11/23
 * Time: 3:38 PM
 */

namespace Tests;


use Exceptions\UnWritableException;
use PHPUnit\Framework\TestCase;
use Storage\FileStore;
use Processor\Config;
use Processor\FileSize;
use Processor\Filename;

/**
 * Test files are stored
 *
 * Class FileStoreTest
 * @package Tests
 */
class FileStoreTest extends TestCase {

    /**
     * Test create the empty folders
     *
     * @throws UnWritableException
     * @throws \Exceptions\AlreadyExistsException
     * @throws \Exceptions\UnExecutableException
     */
    public function testCreateDir() {
        $dir    = '/tmp/LogSystem';
        $create = FileStore::createDir($dir);
        if ($create) {
            $this->assertTrue(true, 'Create dir: ' . $dir . 'success');

        } else {
            $this->assertFalse(false, 'Create dir: ' . $dir . 'failed');
        }
    }

    /**
     * Test delete the empty folders
     *
     * @throws UnWritableException
     * @throws \Exceptions\NonEmptyException
     * @throws \Exceptions\UnExecutableException
     */
    public function testDeleteEmptyDir() {
        $dir    = '/tmp/LogSystem';
        $delete = FileStore::deleteEmptyDir($dir);
        $this->assertEquals(true, $delete);
    }

    /**
     * Test the file get
     */
    public function testGetFile() {
        $file   = '/tmp/logs/LogSystem/tests.log.20181124';
        $get    = FileStore::get($file);

        if ($get) {
            $this->assertTrue(true, 'Get the file success');

        } else {
            $this->assertFalse(false, 'Get the file failed');
        }
    }

    /**
     * Test the file save
     *
     */
    public function testSave() {
        $schema     = 'LogSystem';
        $module     = 'tests';
        $config     = Config::{$schema}();
        $moduleName = $config::get('module')::next($module);
        $filename   = $config::get('root') . $config::get('name') . '/' . Filename::{$moduleName}();
        $content    = 'FileStore test save.' . PHP_EOL;

        $checkSize  = FileSize::{$schema}($filename);
        $currentDir = dirname($filename);
        $parentDir  = dirname($currentDir);

        if ($checkSize) {

            $checkFile = FileStore::checkFile($filename);

            if (!$checkFile) {
                $checkParentDir     = FileStore::checkDir($parentDir);

                if (!$checkParentDir) {

                    try {
                        $createParentDir    = FileStore::createDir($parentDir);

                        if ($createParentDir) {
                            $createCurrentDir   = FileStore::createDir($currentDir);

                            if ($createCurrentDir) {
                                $save = FileStore::save($filename, $content);
                                $this->assertEquals(true, $save);
                            }
                        }

                    } catch (\Exception $exception) {
                        echo $exception->getMessage();
                    }
                }

                if ($checkParentDir) {

                    $checkCurrentDir = FileStore::checkDir($currentDir);
                    if (!$checkCurrentDir) {

                        try {
                            $createCurrentDir = FileStore::createDir($currentDir);

                            if ($createCurrentDir) {
                                $save = FileStore::save($filename, $content);
                                $this->assertEquals(true, $save);

                            } else {
                                throw new UnWritableException($currentDir);
                            }

                        } catch (\Exception $exception) {
                            echo $exception->getMessage();
                        }
                    }

                    if ($checkCurrentDir) {

                        try {
                            $save = FileStore::save($filename, $content);
                            $this->assertEquals(true, $save);

                        } catch (\Exception $exception) {
                            echo $exception->getMessage();
                        }
                    }
                }
            }

            if ($checkFile) {

                try {
                    $save = FileStore::save($filename, $content);
                    $this->assertEquals(true, $save);

                } catch (\Exception $exception) {
                    echo $exception->getMessage();
                }
            }
        }

        if (!$checkSize) {

            try {
                $newFiles = $filename . Filename::now();
                $move = FileStore::moveFile($filename, $newFiles);
                $this->assertEquals(true, $move);

                if ($move) {
                    $save = FileStore::save($filename, $content);
                    $this->assertEquals(true, $save);
                }

            } catch (\Exception $exception) {
                echo $exception->getMessage();
            }
        }
    }
}
