<?php

namespace marvin255\bxcontent\tests;

/**
 * Класс для тестирования сниппетов.
 */
abstract class SnippetCase extends BaseCase
{
    /**
     * Возвращает объект сниппета для проверки.
     *
     * @param string $name
     * @param array  $params
     *
     * @return \marvin255\bxcontent\snippet\SnippetInterface
     */
    abstract protected function createSnippetObject($name = 'default_name', array $params = []);

    /**
     * @test
     */
    public function testSetParent()
    {
        $parent = $this->getMockBuilder('\\marvin255\\bxcontent\\snippet\\SnippetInterface')
            ->getMock();

        $snippet = $this->createSnippetObject();

        $this->assertSame($snippet, $snippet->setParent($parent));
        $this->assertSame($parent, $snippet->getParent());
    }

    /**
     * @test
     */
    public function testSetValue()
    {
        $value = 'value_' . mt_rand();

        $snippet = $this->createSnippetObject();

        $this->assertSame($snippet, $snippet->setValue($value));
        $this->assertSame($value, $snippet->getValue());
    }

    /**
     * @test
     */
    public function testSetParam()
    {
        $emptyParamName = 'empty_name_' . mt_rand();
        $paramName = 'name_' . mt_rand();
        $paramValue = 'value_' . mt_rand();

        $snippet = $this->createSnippetObject();

        $this->assertSame($snippet, $snippet->setParam($paramName, $paramValue));
        $this->assertSame($paramValue, $snippet->getParam($paramName));
        $this->assertSame(null, $snippet->getParam($emptyParamName));
    }

    /**
     * @test
     */
    public function testSetParamNameException()
    {
        $paramName = '~~~~~name_' . mt_rand();
        $paramValue = 'value_' . mt_rand();

        $snippet = $this->createSnippetObject();

        $this->setExpectedException('\\InvalidArgumentException');
        $snippet->setParam($paramName, $paramValue);
    }

    /**
     * @test
     */
    public function testSetParamValueException()
    {
        $paramName = 'name_' . mt_rand();
        $paramValue = new \stdClass;

        $snippet = $this->createSnippetObject();

        $this->setExpectedException('\\InvalidArgumentException');
        $snippet->setParam($paramName, $paramValue);
    }

    /**
     * @test
     */
    public function testSetParams()
    {
        $param1Name = 'name_1_' . mt_rand();
        $param1Value = 'value_1_' . mt_rand();
        $param2Name = 'name_2_' . mt_rand();
        $param2Value = 'value_2_' . mt_rand();

        $snippet = $this->createSnippetObject();
        $snippet->setParams([$param2Name => $param2Value]);

        $this->assertSame($snippet, $snippet->setParams([$param1Name => $param1Value]));
        $this->assertSame([$param1Name => $param1Value], $snippet->getParams());
        $this->assertSame($param1Value, $snippet->getParam($param1Name));
        $this->assertSame(null, $snippet->getParam($param2Name));
    }

    /**
     * @test
     */
    public function testJsonSerialize()
    {
        $param1Name = 'name_1_' . mt_rand();
        $param1Value = 'value_1_' . mt_rand();
        $param2Name = 'name_2_' . mt_rand();
        $param2Value = 'value_2_' . mt_rand();
        $snippetName = 'snippet_name_' . mt_rand();

        $snippet = $this->createSnippetObject($snippetName);
        $json = [
            $param1Name => $param1Value,
            $param2Name => $param2Value,
            'name' => $snippetName,
            'type' => $snippet->getType(),
        ];
        $snippet->setParams([
            $param1Name => $param1Value,
            $param2Name => $param2Value,
        ]);
        $assertingJson = $snippet->jsonSerialize();
        ksort($json);
        ksort($assertingJson);

        $this->assertSame($json, $assertingJson);
    }
}
