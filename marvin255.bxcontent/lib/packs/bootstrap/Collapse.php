<?php

namespace marvin255\bxcontent\packs\bootstrap;

use marvin255\bxcontent\packs\Pack;
use marvin255\bxcontent\controls\Input;
use marvin255\bxcontent\controls\Editor;
use marvin255\bxcontent\controls\Combine;

/**
 * Сниппет для аккордеона.
 *
 * Html будет создан на основе bootstrap Collapse. Входит в пак готовых сниппетов.
 */
class Collapse extends Pack
{
    /**
     * @inheritdoc
     */
    protected function getDefaultSettings()
    {
        global $APPLICATION;

        $return = [
            'label' => 'Аккордеон',
            'controls' => [],
        ];

        $return['controls'][] = new Combine([
            'name' => 'items',
            'label' => 'Блоки',
            'multiple' => true,
            'elements' => [
                new Input(['name' => 'caption', 'label' => 'Заголовок']),
                new Editor(['name' => 'content', 'label' => 'Содержимое']),
            ],
        ]);

        return $return;
    }

    /**
     * @inheritdoc
     */
    protected function getCodeForManager()
    {
        return 'bootstrap.collapse';
    }

    /**
     * @inheritdoc
     */
    protected function renderInternal(array $snippetValues)
    {
    }
}
