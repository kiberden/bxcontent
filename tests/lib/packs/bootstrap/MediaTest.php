<?php

namespace marvin255\bxcontent\tests\lib\packs\bootstrap;

class MediaTest extends \PHPUnit_Framework_TestCase
{
    public function testDefaultConfig()
    {
        $testLabel = 'label_' . mt_rand();

        $manager = \marvin255\bxcontent\SnippetManager::getInstance(true);
        \marvin255\bxcontent\packs\bootstrap\Media::setTo($manager, ['label' => $testLabel]);

        $this->assertInstanceOf(
            '\marvin255\bxcontent\packs\bootstrap\Media',
            $manager->get('bootstrap.media')
        );

        $this->assertSame(
            $testLabel,
            $manager->get('bootstrap.media')->getLabel()
        );
    }
}
