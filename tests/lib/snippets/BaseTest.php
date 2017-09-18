<?php

namespace marvin255\bxcontent\tests\lib\snippets;

class BaseTest extends \PHPUnit_Framework_TestCase
{
    public function testGetType()
    {
        $arConfig = [
            'type' => 'type_' . mt_rand(),
            'label' => 'label_' . mt_rand(),
            'controls' => [
                $this->getMockBuilder('\marvin255\bxcontent\ControlInterface')
                    ->getMock(),
            ],
        ];

        $snippet = new \marvin255\bxcontent\snippets\Base($arConfig);

        $this->assertSame(
            $arConfig['type'],
            $snippet->getType()
        );
    }

    public function testGetLabel()
    {
        $arConfig = [
            'type' => 'type_' . mt_rand(),
            'label' => 'label_' . mt_rand(),
            'controls' => [
                $this->getMockBuilder('\marvin255\bxcontent\ControlInterface')
                    ->getMock(),
            ],
        ];

        $snippet = new \marvin255\bxcontent\snippets\Base($arConfig);

        $this->assertSame(
            $arConfig['label'],
            $snippet->getLabel()
        );
    }

    public function testGetControls()
    {
        $controlKey = 'controls_key_' . mt_rand();
        $control = $this->getMockBuilder('\marvin255\bxcontent\ControlInterface')
            ->getMock();
        $control->method('getName')->will($this->returnValue($controlKey));

        $arConfig = [
            'type' => 'type_' . mt_rand(),
            'label' => 'label_' . mt_rand(),
            'controls' => [$control],
        ];

        $snippet = new \marvin255\bxcontent\snippets\Base($arConfig);

        $this->assertSame(
            [$controlKey => $control],
            $snippet->getControls()
        );
    }

    public function testEmptyTypeException()
    {
        $arConfig = [
            'label' => 'label_' . mt_rand(),
            'controls' => [
                $this->getMockBuilder('\marvin255\bxcontent\ControlInterface')
                    ->getMock(),
            ],
        ];

        $this->setExpectedException('\marvin255\bxcontent\Exception', 'type');
        $snippet = new \marvin255\bxcontent\snippets\Base($arConfig);
    }

    public function testEmptyLabelException()
    {
        $arConfig = [
            'type' => 'type_' . mt_rand(),
            'controls' => [
                $this->getMockBuilder('\marvin255\bxcontent\ControlInterface')
                    ->getMock(),
            ],
        ];

        $this->setExpectedException('\marvin255\bxcontent\Exception', 'label');
        $snippet = new \marvin255\bxcontent\snippets\Base($arConfig);
    }

    public function testEmptyControlsException()
    {
        $arConfig = [
            'type' => 'type_' . mt_rand(),
            'label' => 'label_' . mt_rand(),
        ];

        $this->setExpectedException('\marvin255\bxcontent\Exception', 'controls');
        $snippet = new \marvin255\bxcontent\snippets\Base($arConfig);
    }

    public function testNonArrayControlsException()
    {
        $arConfig = [
            'type' => 'type_' . mt_rand(),
            'label' => 'label_' . mt_rand(),
            'controls' => 123,
        ];

        $this->setExpectedException('\marvin255\bxcontent\Exception', 'controls');
        $snippet = new \marvin255\bxcontent\snippets\Base($arConfig);
    }

    public function testWrongControlsInstanceException()
    {
        $arConfig = [
            'type' => 'type_' . mt_rand(),
            'label' => 'label_' . mt_rand(),
            'controls' => ['test_key' => 123],
        ];

        $this->setExpectedException('\marvin255\bxcontent\Exception', 'test_key');
        $snippet = new \marvin255\bxcontent\snippets\Base($arConfig);
    }

    public function testNameDoublingControlsException()
    {
        $controlKey = 'controls_key_' . mt_rand();
        $control = $this->getMockBuilder('\marvin255\bxcontent\ControlInterface')
            ->getMock();
        $control->method('getName')->will($this->returnValue($controlKey));

        $arConfig = [
            'type' => 'type_' . mt_rand(),
            'label' => 'label_' . mt_rand(),
            'controls' => [
                $control,
                $control,
            ],
        ];

        $this->setExpectedException('\marvin255\bxcontent\Exception', $controlKey);
        $snippet = new \marvin255\bxcontent\snippets\Base($arConfig);
    }
}
