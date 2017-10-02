<?php

namespace marvin255\bxcontent\packs\bootstrap;

use marvin255\bxcontent\packs\Pack;
use marvin255\bxcontent\controls\Input;
use marvin255\bxcontent\controls\Editor;
use marvin255\bxcontent\controls\Combine;
use marvin255\bxcontent\views\Component;

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
            'view' => new Component($APPLICATION, 'marvin255.bxcontent:bootstrap.tabs'),
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
}
