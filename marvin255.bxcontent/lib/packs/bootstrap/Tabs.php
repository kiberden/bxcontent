<?php

namespace marvin255\bxcontent\packs\bootstrap;

use marvin255\bxcontent\packs\Pack;
use marvin255\bxcontent\controls\Input;
use marvin255\bxcontent\controls\Editor;
use marvin255\bxcontent\controls\Combine;

/**
 * Сниппет для табов.
 *
 * Html будет создан на основе bootstrap tabs. Входит в пак готовых сниппетов.
 */
class Tabs extends Pack
{
    /**
     * @inheritdoc
     */
    protected function getDefaultSettings()
    {
        global $APPLICATION;

        $return = [
            'label' => 'Табы',
            'controls' => [],
        ];

        $return['controls'][] = new Combine([
            'name' => 'tabs',
            'label' => 'Табы',
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
        return 'bootstrap.tabs';
    }

    /**
     * @inheritdoc
     */
    protected function renderInternal(array $snippetValues)
    {
    }
}
