<?php
/**
 * Class FileSyncProcedure
 *
 * Author:  Kernel Huang
 * Mail:    kernelman79@gmail.com
 * Date:    11/29/18
 * Time:    2:09 PM
 */

namespace Tests;


use Logs\Services\Logs;

class AnchorTest extends TestCase {

    public function testLogDebug() {
        $log = [
            'schema'    => 'Anchor',
            'module'    => 'stats',
            'statusCode'=> 404,
            'message'   => 'Request fail.',
            'content'   => 'Anchor test level: debug.'
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
            'schema'    => 'Anchor',
            'module'    => 'stats',
            'statusCode'=> 404,
            'message'   => 'Request fail.',
            'content'   => 'Anchor test level: error.'
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
        $log->schema    = 'Anchor';
        $log->module    = 'stats';
        $log->message   = 'Request fail.';
        $log->content   = (object)['id' => 1, 'name' => 'anchor'];

        $info = Logs::info($log);
        $this->assertEquals($info, true);

        $log            = new \stdClass();
        $log->schema    = 'Anchor';
        $log->module    = 'stats';
        $log->message   = 'Request fail.';
        $log->content   = ['id' => 1, 'name' => 'anchor'];

        $info = Logs::info($log);
        $this->assertEquals($info, true);
    }
}
