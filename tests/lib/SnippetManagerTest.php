<?php

namespace marvin255\bxcontent\tests\lib;

class SnippetManagerTest extends \PHPUnit_Framework_TestCase
{
    public function testSet()
    {
        $name = 'type_' . mt_rand();
        $name1 = 'type_2_' . mt_rand();
        $snippet = $this->getMockBuilder('\marvin255\bxcontent\snippets\SnippetInterface')
            ->getMock();

        $manager = \marvin255\bxcontent\SnippetManager::getInstance(true);

        $this->assertSame(
            $manager,
            $manager->set($name, $snippet)
        );
        $this->assertSame(
            $snippet,
            $manager->get($name)
        );
        $this->assertSame(
            null,
            $manager->get($name1)
        );
    }

    public function testSetEmptySnippetNameException()
    {
        $snippet = $this->getMockBuilder('\marvin255\bxcontent\snippets\SnippetInterface')
            ->getMock();

        $manager = \marvin255\bxcontent\SnippetManager::getInstance(true);

        $this->setExpectedException('\marvin255\bxcontent\Exception', 'name');
        $manager->set('', $snippet);
    }

    public function testRemove()
    {
        $name = 'type_' . mt_rand();
        $snippet = $this->getMockBuilder('\marvin255\bxcontent\snippets\SnippetInterface')
            ->getMock();

        $manager = \marvin255\bxcontent\SnippetManager::getInstance(true);

        $manager->set($name, $snippet);
        $this->assertSame(
            $manager,
            $manager->remove($name)
        );
        $this->assertSame(
            null,
            $manager->get($name)
        );
    }

    public function testRemoveEmptySnippetException()
    {
        $name = 'type_' . mt_rand();
        $snippet = $this->getMockBuilder('\marvin255\bxcontent\snippets\SnippetInterface')
            ->getMock();

        $manager = \marvin255\bxcontent\SnippetManager::getInstance(true);

        $this->setExpectedException('\marvin255\bxcontent\Exception', $name);
        $manager->remove($name);
    }

    public function testJsonSerialize()
    {
        $name = 'type_' . mt_rand();
        $controls = ['control_' . mt_rand()];
        $label = 'label_' . mt_rand();

        $etalon = [
            $name => [
                'label' => $label,
                'controls' => $controls,
            ],
        ];
        ksort($etalon[$name]);

        $snippet = $this->getMockBuilder('\marvin255\bxcontent\snippets\SnippetInterface')->getMock();
        $snippet->method('getControls')->will($this->returnValue($controls));
        $snippet->method('getLabel')->will($this->returnValue($label));

        $manager = \marvin255\bxcontent\SnippetManager::getInstance(true);

        $return = $manager->set($name, $snippet)->jsonSerialize();
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
        $name = 'type_' . mt_rand();
        $controls = ['control_' . mt_rand()];
        $label = 'label_' . mt_rand();
        $js1 = 'js_' . mt_rand();
        $js2 = 'js_2_' . mt_rand();

        $etalon = [
            $name => [
                'label' => $label,
                'controls' => $controls,
            ],
        ];

        $managerData = "<script>$.fn.marvin255bxcontent('registerSnippets', ";
        $managerData .= json_encode($etalon);
        $managerData .= ');</script>';

        $snippet = $this->getMockBuilder('\marvin255\bxcontent\snippets\SnippetInterface')->getMock();
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

        $manager->set($name, $snippet)->registerAssets($asset, $parameterName);
    }
}
