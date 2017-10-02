<?php

namespace marvin255\bxcontent\packs\bootstrap;

use marvin255\bxcontent\packs\Pack;
use marvin255\bxcontent\controls\Input;
use marvin255\bxcontent\controls\Editor;
use marvin255\bxcontent\controls\File;
use marvin255\bxcontent\controls\Select;
use marvin255\bxcontent\controls\Combine;

/**
 * Сниппет для медиа объектов.
 *
 * Html будет создан на основе bootstrap media object. Входит в пак готовых сниппетов.
 */
class Media extends Pack
{
    /**
     * @inheritdoc
     */
    protected function getDefaultSettings()
    {
        global $APPLICATION;

        $return = [
            'label' => 'Медиа объекты',
            'controls' => [],
        ];

        $return['controls'][] = new Combine([
            'name' => 'items',
            'label' => 'Блоки',
            'multiple' => true,
            'elements' => [
                new File(['name' => 'image', 'label' => 'Изображение']),
                new Input(['name' => 'cation', 'label' => 'Заголовок']),
                new Select([
                    'name' => 'float',
                    'label' => 'Выравнивание',
                    'list' => [
                        'left' => 'По левому краю',
                        'right' => 'По правому краю',
                    ],
                ]),
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
        return 'bootstrap.media';
    }

    /**
     * @inheritdoc
     */
    protected function renderInternal(array $snippetValues)
    {
    }
}
