<?php

namespace marvin255\bxcontent\tests\lib\snippet;

use marvin255\bxcontent\tests\SnippetCase;

/**
 * Стандартный сниппет.
 */
class SnippetTest extends SnippetCase
{
    /**
     * @inheritdoc
     */
    protected function getSnippetClass()
    {
        return '\\marvin255\\bxcontent\\snippet\\Snippet';
    }
}
