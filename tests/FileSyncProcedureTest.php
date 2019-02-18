<?php
/**
 * Class FileSyncProcedureTest
 *
 * Author:  Kernel Huang
 * Mail:    kernelman79@gmail.com
 * Date:    11/29/18
 * Time:    2:09 PM
 */

namespace Tests;


use Files\Sync\FileStore;
use Logs\Processor\Filename;
use Logs\Processor\FileSize;
use Logs\Processor\FileSyncProcedure;
use Services\Config;

class FileSyncProcedureTest extends TestCase {

    public function testProcedure() {
        $schema     = 'LogSystem';
        $module     = 'tests';
        $config     = Config::{$schema}();
        $moduleName = $config::find('module')::next($module);
        $filename   = $config::get('root') . strtolower($config::get('name')) . '/' . Filename::{$moduleName}();
        $content    = 'FileStore test procedure.' . PHP_EOL;

        $checkSize  = FileSize::{$schema}($filename);
        $checkFile  = FileStore::checkFile($filename);

        try {

            $procedure = new FileSyncProcedure($checkSize, $checkFile, $filename, $content);
            $run = $procedure->begin();
            $this->assertEquals($run, true);

        } catch (\Exception $exception) {
            echo $exception->getMessage();
        }
    }
}
