<?php
/**
 * Created by IntelliJ IDEA.
 * User: kernel Huang
 * Email: kernelman79@gmail.com
 * Date: 2018/11/23
 * Time: 1:57 PM
 */

namespace Tests;


use Services\Config;

/**
 * Class ConfigTest
 * @package Tests
 */
class ConfigTest extends TestCase {

    /**
     * @expectedException \Exceptions\NotFoundException
     */
    public function testConfig() {
        $configRoot = Config::backApi()::get('root');
        $this->assertEquals($configRoot, '/tmp/logs/');

        $configName = Config::backApi()::get('name');
        $this->assertNotEquals($configName, 'Backapi');

        $isNull = Config::backApi()::get('nam');
        $this->assertNull($isNull);
    }
}
