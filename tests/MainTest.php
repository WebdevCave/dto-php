<?php

namespace Webdevcave\LibTemplatePhp\Tests;

use PHPUnit\Framework\Attributes\CoversClass;
use Webdevcave\LibTemplatePhp\Main;
use PHPUnit\Framework\TestCase;

#[CoversClass(Main::class)]
class MainTest extends TestCase
{
    public function testRun()
    {
        $main = new Main();
        $this->expectOutputString('Hello from Main class');

        $main->run();
    }
}
