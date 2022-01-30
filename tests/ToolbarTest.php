<?php

namespace Fruitcake\TelescopeToolbar\Tests;

use Illuminate\Support\Str;

class ToolbarTest extends TestCase
{

    public function testItInjectsOnPlainText()
    {
        $crawler = $this->call('GET', 'web/plain');

        $this->assertTrue(Str::contains($crawler->content(), 'Sfjs.loadToolbar'));
        $this->assertEquals(200, $crawler->getStatusCode());
    }

    public function testItInjectsOnHtml()
    {
        $crawler = $this->call('GET', 'web/html');

        $this->assertTrue(Str::contains($crawler->content(), 'Sfjs.loadToolbar'));
        $this->assertEquals(200, $crawler->getStatusCode());
    }

    public function testItDoesntInjectOnJson()
    {
        $crawler = $this->call('GET', 'api/ping');

        $this->assertFalse(Str::contains($crawler->content(), 'Sfjs.loadToolbar'));
        $this->assertEquals(200, $crawler->getStatusCode());
    }
}
