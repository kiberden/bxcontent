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
        $multiple = true;
        $serializeKey = 'serializeKey_' . mt_rand();
        $serializeValue = 'serializeValue_' . mt_rand();
        $serialize = [
            'type' => 'not_' . $type,
            $serializeKey => $serializeValue,
        ];

        $etalon = [
            $type => [
                'label' => $label,
                'type' => $type,
                'controls' => $controls,
                'multiple' => $multiple,
                $serializeKey => $serializeValue,
            ],
        ];
        ksort($etalon[$type]);

        $snippet = $this->getMockBuilder([
            '\marvin255\bxcontent\SnippetInterface',
            'JsonSerializable',
        ])->getMock();
        $snippet->method('getType')->will($this->returnValue($type));
        $snippet->method('getControls')->will($this->returnValue($controls));
        $snippet->method('getLabel')->will($this->returnValue($label));
        $snippet->method('getMultiple')->will($this->returnValue($multiple));
        $snippet->method('jsonSerialize')->will($this->returnValue($serialize));

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
}
