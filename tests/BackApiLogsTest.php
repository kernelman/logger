<?php
/**
 * Class BackApiLogsTest
 *
 * Author:  Kernel Huang
 * Mail:    kernelman79@gmail.com
 * Date:    11/29/18
 * Time:    2:09 PM
 */

namespace Tests;


use Logs\Services\Logs;

class BackApiLogsTest extends TestCase {

    public function testLogDebug() {
        $log = [
            'schema'    => 'BackApi',
            'module'    => 'user',
            'statusCode'=> 404,
            'message'   => 'Request fail.',
            'content'   => 'BackApi test level: error.'
        ];

        try {
            $debug = Logs::debug($log);
            $this->assertEquals($debug, true);

        } catch (\Exception $exception) {
            echo $exception->getMessage();
        }
    }

    public function testLogError() {
        $log = [
            'schema'    => 'BackApi',
            'module'    => 'user',
            'statusCode'=> 404,
            'message'   => 'Request fail.',
            'content'   => 'BackApi test level: error.'
        ];

        try {
            $error = Logs::error($log);
            $this->assertEquals($error, true);

        } catch (\Exception $exception) {
            echo $exception->getMessage();
        }
    }

    /**
     * @throws \Exceptions\InvalidArgumentException
     * @throws \Exceptions\NotFoundException
     * @throws \Exceptions\UnFormattedException
     */
    public function testInfo() {
        $log            = new \stdClass();
        $log->schema    = 'BackApi';
        $log->module    = 'user';
        $log->message   = 'Request fail.';
        $log->content   = (object)['id' => 1, 'name' => 'user'];

        $info = Logs::info($log);
        $this->assertEquals($info, true);

        $log            = new \stdClass();
        $log->schema    = 'BackApi';
        $log->module    = 'user';
        $log->message   = 'Request fail.';
        $log->content   = ['id' => 1, 'name' => 'user'];

        $info = Logs::info($log);
        $this->assertEquals($info, true);
    }
}
