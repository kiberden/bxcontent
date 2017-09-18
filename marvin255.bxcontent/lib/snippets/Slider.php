<?php

namespace marvin255\bxcontent\snippets;

use marvin255\bxcontent\controls\Combine;
use marvin255\bxcontent\controls\Input;
use marvin255\bxcontent\controls\File;

/**
 * Сниппет для слайдера.
 */
class Slider extends Base
{
    /**
     * @inheritdoc
     */
    public function __construct(array $settings)
    {
        $settings['type'] = 'slider';
        $settings['label'] = 'Слайдер';
        $settings['controls'] = [
            new Combine([
                'name' => 'slides',
                'label' => 'Слайды',
                'multiple' => true,
                'elements' => [
                    new File([
                        'name' => 'image',
                        'label' => 'Изображение',
                    ]),
                    new Input([
                        'name' => 'name',
                        'label' => 'Подпись',
                    ]),
                ],
            ]),
        ];

        parent::__construct($settings);
    }
}
