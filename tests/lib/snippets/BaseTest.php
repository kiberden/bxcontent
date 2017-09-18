<?php

namespace marvin255\bxcontent\tests\lib\snippets;

class BaseTest extends \PHPUnit_Framework_TestCase
{
    public function testGetType()
    {
        $arConfig = [
            'type' => 'type_' . mt_rand(),
            'label' => 'label_' . mt_rand(),
            'controls' => ['controls_key_' . mt_rand(), 'controls_value_' . mt_rand()],
            'multiple' => true,
            'key_' . mt_rand() => 'value_' . mt_rand(),
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
            'controls' => ['controls_key_' . mt_rand(), 'controls_value_' . mt_rand()],
            'multiple' => true,
            'key_' . mt_rand() => 'value_' . mt_rand(),
        ];

        $snippet = new \marvin255\bxcontent\snippets\Base($arConfig);

        $this->assertSame(
            $arConfig['label'],
            $snippet->getLabel()
        );
    }

    public function testGetControls()
    {
        $arConfig = [
            'type' => 'type_' . mt_rand(),
            'label' => 'label_' . mt_rand(),
            'controls' => ['controls_key_' . mt_rand(), 'controls_value_' . mt_rand()],
            'multiple' => true,
            'key_' . mt_rand() => 'value_' . mt_rand(),
        ];

        $snippet = new \marvin255\bxcontent\snippets\Base($arConfig);

        $this->assertSame(
            $arConfig['controls'],
            $snippet->getControls()
        );
    }

    public function testGetMultiple()
    {
        $arConfig = [
            'type' => 'type_' . mt_rand(),
            'label' => 'label_' . mt_rand(),
            'controls' => ['controls_key_' . mt_rand(), 'controls_value_' . mt_rand()],
            'multiple' => true,
            'key_' . mt_rand() => 'value_' . mt_rand(),
        ];

        $snippet = new \marvin255\bxcontent\snippets\Base($arConfig);

        $this->assertSame(
            $arConfig['multiple'],
            $snippet->getMultiple()
        );
    }

    public function testJsonSerialize()
    {
        $arConfig = [
            'type' => 'type_' . mt_rand(),
            'label' => 'label_' . mt_rand(),
            'controls' => ['controls_key_' . mt_rand(), 'controls_value_' . mt_rand()],
            'multiple' => true,
            'key_' . mt_rand() => 'value_' . mt_rand(),
        ];
        ksort($arConfig);

        $snippet = new \marvin255\bxcontent\snippets\Base($arConfig);

        $return = $snippet->jsonSerialize();
        ksort($return);
        $this->assertSame(
            $arConfig,
            $return
        );
    }

    public function testEmptyTypeException()
    {
        $arConfig = [
            'label' => 'label_' . mt_rand(),
            'controls' => ['controls_key_' . mt_rand(), 'controls_value_' . mt_rand()],
            'multiple' => true,
            'key_' . mt_rand() => 'value_' . mt_rand(),
        ];

        $this->setExpectedException('\marvin255\bxcontent\Exception', 'type');
        $snippet = new \marvin255\bxcontent\snippets\Base($arConfig);
    }

    public function testEmptyLabelException()
    {
        $arConfig = [
            'type' => 'type_' . mt_rand(),
            'controls' => ['controls_key_' . mt_rand(), 'controls_value_' . mt_rand()],
            'multiple' => true,
            'key_' . mt_rand() => 'value_' . mt_rand(),
        ];

        $this->setExpectedException('\marvin255\bxcontent\Exception', 'label');
        $snippet = new \marvin255\bxcontent\snippets\Base($arConfig);
    }

    public function testEmptyControlsException()
    {
        $arConfig = [
            'type' => 'type_' . mt_rand(),
            'label' => 'label_' . mt_rand(),
            'multiple' => true,
            'key_' . mt_rand() => 'value_' . mt_rand(),
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
            'multiple' => true,
            'key_' . mt_rand() => 'value_' . mt_rand(),
        ];

        $this->setExpectedException('\marvin255\bxcontent\Exception', 'controls');
        $snippet = new \marvin255\bxcontent\snippets\Base($arConfig);
    }

    public function testNonBoolMultipleException()
    {
        $arConfig = [
            'type' => 'type_' . mt_rand(),
            'label' => 'label_' . mt_rand(),
            'controls' => ['controls_key_' . mt_rand(), 'controls_value_' . mt_rand()],
            'multiple' => 123,
            'key_' . mt_rand() => 'value_' . mt_rand(),
        ];

        $this->setExpectedException('\marvin255\bxcontent\Exception', 'multiple');
        $snippet = new \marvin255\bxcontent\snippets\Base($arConfig);
    }
}
