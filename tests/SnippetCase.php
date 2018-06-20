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
        $param2Value = null;

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
        $snippetName = 'snippet_name_' . mt_rand();
        $snippetParams = [
            'param_1_' . mt_rand() => 'param_1_value_' . mt_rand(),
            'param_2_' . mt_rand() => 'param_2_value_' . mt_rand(),
        ];

        $snippet = $this->createSnippetObject($snippetName);
        $json = [
            'params' => $snippetParams,
            'name' => $snippetName,
            'type' => $snippet->getType(),
        ];
        $assertingJson = $snippet->setParams($snippetParams)->jsonSerialize();
        ksort($json);
        ksort($assertingJson);

        $this->assertSame($json, $assertingJson);
    }
}
