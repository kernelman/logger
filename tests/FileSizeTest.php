<?php
/**
 * Created by IntelliJ IDEA.
 * User: kernel Huang
 * Email: kernelman79@gmail.com
 * Date: 2018/11/21
 * Time: 3:08 PM
 */

namespace Tests;

use Logs\Processor\FileSize;

class FileSizeTest extends TestCase {

    public function testFileSize() {
        $check = FileSize::backapi(__FILE__);
        $this->assertEquals($check, true);
    }
}
