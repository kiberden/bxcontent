<?php

namespace marvin255\bxcontent\tests\lib;

class SnippetManagerTest extends \PHPUnit_Framework_TestCase
{
    public function testSet()
    {
        $type = 'type_' . mt_rand();
        $type2 = 'type_2_' . mt_rand();
        $snippet = $this->getMockBuilder('\marvin255\bxcontent\SnippetInterface')
            ->getMock();
        $snippet->method('getType')->will($this->returnValue($type));

        $manager = \marvin255\bxcontent\SnippetManager::getInstance(true);

        $this->assertSame(
            $manager,
            $manager->set($snippet)
        );
        $this->assertSame(
            $snippet,
            $manager->get($type)
        );
        $this->assertSame(
            null,
            $manager->get($type2)
        );
    }

    public function testSetDoublingException()
    {
        $type = 'type_' . mt_rand();
        $snippet = $this->getMockBuilder('\marvin255\bxcontent\SnippetInterface')
            ->getMock();
        $snippet->method('getType')->will($this->returnValue($type));

        $manager = \marvin255\bxcontent\SnippetManager::getInstance(true);

        $this->setExpectedException('\marvin255\bxcontent\Exception', $type);
        $manager->set($snippet)->set($snippet);
    }

    public function testRemove()
    {
        $type = 'type_' . mt_rand();
        $snippet = $this->getMockBuilder('\marvin255\bxcontent\SnippetInterface')
            ->getMock();
        $snippet->method('getType')->will($this->returnValue($type));

        $manager = \marvin255\bxcontent\SnippetManager::getInstance(true);

        $manager->set($snippet);
        $this->assertSame(
            $manager,
            $manager->remove($type)
        );
        $this->assertSame(
            null,
            $manager->get($type)
        );
    }

    public function testRemoveEmptySnippetException()
    {
        $type = 'type_' . mt_rand();
        $snippet = $this->getMockBuilder('\marvin255\bxcontent\SnippetInterface')
            ->getMock();
        $snippet->method('getType')->will($this->returnValue($type));

        $manager = \marvin255\bxcontent\SnippetManager::getInstance(true);

        $this->setExpectedException('\marvin255\bxcontent\Exception', $type);
        $manager->remove($type);
    }

    public function testJsonSerialize()
    {
        $type = 'type_' . mt_rand();
        $controls = ['control_' . mt_rand()];
        $label = 'label_' . mt_rand();

        $etalon = [
            $type => [
                'label' => $label,
                'type' => $type,
                'controls' => $controls,
            ],
        ];
        ksort($etalon[$type]);

        $snippet = $this->getMockBuilder('\marvin255\bxcontent\SnippetInterface')->getMock();
        $snippet->method('getType')->will($this->returnValue($type));
        $snippet->method('getControls')->will($this->returnValue($controls));
        $snippet->method('getLabel')->will($this->returnValue($label));

        $manager = \marvin255\bxcontent\SnippetManager::getInstance(true);

        $return = $manager->set($snippet)->jsonSerialize();
        foreach ($return as &$item) {
            ksort($item);
        }
        $this->assertSame(
            $etalon,
            $return
        );
    }

    public function testSetJs()
    {
        $manager = \marvin255\bxcontent\SnippetManager::getInstance(true);
        $manager->addJs('test3');

        $this->assertSame(
            $manager,
            $manager->setJs(['test1', 'test2'])
        );
        $this->assertSame(
            ['test1', 'test2'],
            $manager->getJs()
        );
    }

    public function testAddJs()
    {
        $manager = \marvin255\bxcontent\SnippetManager::getInstance(true);

        $this->assertSame(
            $manager,
            $manager->addJs('test1')
        );
        $manager->addJs('test2');
        $this->assertSame(
            ['test1', 'test2'],
            $manager->getJs()
        );
    }

    public function testAddJsEmptyNameException()
    {
        $manager = \marvin255\bxcontent\SnippetManager::getInstance(true);
        $this->setExpectedException('\marvin255\bxcontent\Exception');
        $manager->addJs('');
    }

    public function testRegisterAssets()
    {
        $parameterName = 'parameter_' . mt_rand();
        $type = 'type_' . mt_rand();
        $controls = ['control_' . mt_rand()];
        $label = 'label_' . mt_rand();
        $js1 = 'js_' . mt_rand();
        $js2 = 'js_2_' . mt_rand();

        $etalon = [
            $type => [
                'type' => $type,
                'label' => $label,
                'controls' => $controls,
            ],
        ];

        $managerData = "<script>window.{$parameterName} = ";
        $managerData .= json_encode($etalon);
        $managerData .= ';</script>';

        $snippet = $this->getMockBuilder('\marvin255\bxcontent\SnippetInterface')->getMock();
        $snippet->method('getType')->will($this->returnValue($type));
        $snippet->method('getControls')->will($this->returnValue($controls));
        $snippet->method('getLabel')->will($this->returnValue($label));

        $asset = $this->getMockBuilder('\Bitrix\Main\Page\Asset')
            ->setMethods(['addString', 'addJs'])
            ->getMock();
        $asset->expects($this->at(0))
            ->method('addJs')
            ->with($this->equalTo($js1), $this->equalTo(true));
        $asset->expects($this->at(1))
            ->method('addJs')
            ->with($this->equalTo($js2), $this->equalTo(true));
        $asset->expects($this->at(2))
            ->method('addString')
            ->with($this->equalTo($managerData), $this->equalTo(true));

        $manager = \marvin255\bxcontent\SnippetManager::getInstance(true);

        $manager->addJs($js1)->addJs($js2);

        $manager->set($snippet)->registerAssets($asset, $parameterName);
    }
}
