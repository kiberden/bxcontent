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
     * @test
     */
    public function testConstructWrongNameException()
    {
        $this->setExpectedException('\\InvalidArgumentException');
        $snippet = $this->createSnippetObject('name~~~~');
    }

    /**
     * @test
     */
    public function testGetType()
    {
        $snippet = $this->createSnippetObject();

        $this->assertSame('default', $snippet->getType());
    }

    /**
     * @inheritdoc
     */
    protected function createSnippetObject($name = 'default_name', array $params = [])
    {
        return new Snippet($name, $params);
    }
}
