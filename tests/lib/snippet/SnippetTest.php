<?php

namespace marvin255\bxcontent\tests\lib\snippet;

use marvin255\bxcontent\tests\SnippetCase;
use marvin255\bxcontent\snippet\Snippet;

/**
 * Стандартный сниппет.
 */
class SnippetTest extends SnippetCase
{
    /**
     * @inheritdoc
     */
    protected function createSnippetObject($name = 'default_name', $type = 'default')
    {
        return new Snippet($type, $name);
    }

    /**
     * @test
     */
    public function testConstructWrongTypeException()
    {
        $this->setExpectedException('\\InvalidArgumentException');
        $snippet = new Snippet('type~~~', 'name');
    }

    /**
     * @test
     */
    public function testConstructWrongNameException()
    {
        $this->setExpectedException('\\InvalidArgumentException');
        $snippet = new Snippet('type', 'name~~~');
    }
}
