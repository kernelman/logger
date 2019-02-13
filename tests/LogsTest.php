<?php
/**
 * Created by IntelliJ IDEA.
 * User: kernel Huang
 * Email: kernelman79@gmail.com
 * Date: 2018/11/23
 * Time: 1:57 PM
 */

namespace Tests;


use PHPUnit\Framework\TestCase;
use Services\Logs;

/**
 * Class LogsTest
 * @package Tests
 */
class LogsTest extends TestCase {

    /**
     * @throws \Exceptions\NotFoundException
     * @throws \Exceptions\UnFormattedException
     */
    public function testDebug() {
        $log = [
        'schema'    => 'LogSystem',
        'module'    => 'tests',
        'message'   => 'Request failed.',
        'content'   => 'Logs test level: debug.',
        ];

        $debug  = Logs::debug($log);
        $this->assertEquals($debug, true);
    }

    /**
     * @throws \Exceptions\NotFoundException
     * @throws \Exceptions\UnFormattedException
     */
    public function testError() {
        $log            = new \stdClass();
        $log->schema    = 'LogSystem';
        $log->module    = 'tests';
        $log->message   = 'Request failed.';
        $log->content   = 'Logs test level: error.';

        $debug  = Logs::error($log);
        $this->assertEquals($debug, true);
    }
}
