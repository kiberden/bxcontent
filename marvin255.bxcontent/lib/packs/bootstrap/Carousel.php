<?php

namespace marvin255\bxcontent\packs\bootstrap;

use marvin255\bxcontent\packs\Pack;
use marvin255\bxcontent\controls\Input;
use marvin255\bxcontent\controls\File;
use marvin255\bxcontent\controls\Combine;
use marvin255\bxcontent\views\Component;

/**
 * Сниппет для слайдера.
 *
 * Html будет создан на основе bootstrap slider. Входит в пак готовых сниппетов.
 */
class Carousel extends Pack
{
    /**
     * @inheritdoc
     */
    protected function getDefaultSettings()
    {
        global $APPLICATION;

        $return = [
            'label' => 'Слайдер',
            'view' => new Component($APPLICATION, 'marvin255.bxcontent:bootstrap.carousel'),
            'controls' => [],
        ];

        $return['controls'][] = new Combine([
            'name' => 'slides',
            'label' => 'Слайды',
            'multiple' => true,
            'elements' => [
                new File(['name' => 'image', 'label' => 'Изображение']),
                new Input(['name' => 'caption', 'label' => 'Подпись']),
            ],
        ]);

        return $return;
    }

    /**
     * @inheritdoc
     */
    protected function getCodeForManager()
    {
        return 'bootstrap.carousel';
    }
}
