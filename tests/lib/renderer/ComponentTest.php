<?php

namespace marvin255\bxcontent\tests\lib\renderer;

use marvin255\bxcontent\tests\BaseCase;
use marvin255\bxcontent\renderer\Component;

/**
 * Отображение сниппета с помощью компонента.
 */
class ComponentTest extends BaseCase
{
    /**
     * @test
     */
    public function testRender()
    {
        $component = 'component_' . mt_rand();
        $template = 'template_' . mt_rand();
        $value = [
            'view_key_' . mt_rand() => 'view_value_' . mt_rand(),
            'view_key_1_' . mt_rand() => 'view_value_1_' . mt_rand(),
        ];
        $renderedString = 'rendered_' . mt_rand();

        $application = $this->getMockBuilder('\CMain')
            ->setMethods(['includeComponent'])
            ->getMock();
        $application->method('includeComponent')
            ->with($this->equalTo($component), $this->equalTo($template), $this->equalTo($value))
            ->will($this->returnCallback(function () use ($renderedString) {
                echo $renderedString;
            }));

        $renderer = new Component($application, $component, $template);

        $this->assertSame($renderedString, $renderer->render($value));
    }
}
