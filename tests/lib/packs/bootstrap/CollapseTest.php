<?php

namespace marvin255\bxcontent\tests\lib\packs\bootstrap;

class CollapseTest extends \PHPUnit_Framework_TestCase
{
    public function testDefaultConfig()
    {
        global $APPLICATION;
        $APPLICATION = $this
            ->getMockBuilder('\CMain')
            ->getMock();

        $testLabel = 'label_' . mt_rand();

        $manager = \marvin255\bxcontent\SnippetManager::getInstance(true);
        \marvin255\bxcontent\packs\bootstrap\Collapse::setTo($manager, ['label' => $testLabel]);

        $this->assertInstanceOf(
            '\marvin255\bxcontent\packs\bootstrap\Collapse',
            $manager->get('bootstrap.collapse')
        );

        $this->assertSame(
            $testLabel,
            $manager->get('bootstrap.collapse')->getLabel()
        );
    }
}
