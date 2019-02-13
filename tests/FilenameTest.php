<?php
/**
 * Created by IntelliJ IDEA.
 * User: kernel Huang
 * Email: kernelman79@gmail.com
 * Date: 2018/11/21
 * Time: 3:08 PM
 */

namespace Tests;

use PHPUnit\Framework\TestCase;
use Processor\Filename;

class FilenameTest extends TestCase {

    public function testFilename() {
        $now        = date('Ymd', time());
        $filename   = Filename::backapi();
        $suffix     = 'backapi' . '.log.';

        $this->assertEquals($filename, $suffix . $now);

        if ($filename === $suffix . (int)($now - 1)) {
            $this->assertFalse(false, 'not Equals');

        } else {
            $this->assertTrue(true, 'Equals');
        }
    }
}
