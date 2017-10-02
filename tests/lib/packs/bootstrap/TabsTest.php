<?php

namespace marvin255\bxcontent\tests\lib\packs\bootstrap;

class TabsTest extends \PHPUnit_Framework_TestCase
{
    public function testDefaultConfig()
    {
        $testLabel = 'label_' . mt_rand();

        $manager = \marvin255\bxcontent\SnippetManager::getInstance(true);
        \marvin255\bxcontent\packs\bootstrap\Tabs::setTo($manager, ['label' => $testLabel]);

        $this->assertInstanceOf(
            '\marvin255\bxcontent\packs\bootstrap\Tabs',
            $manager->get('bootstrap.tabs')
        );

        $this->assertSame(
            $testLabel,
            $manager->get('bootstrap.tabs')->getLabel()
        );
    }
}
