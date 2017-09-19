<?php

namespace marvin255\bxcontent\snippets;

use marvin255\bxcontent\controls\Input;
use marvin255\bxcontent\controls\File;
use marvin255\bxcontent\controls\Editor;

/**
 * Сниппет для цитата.
 */
class Blockquote extends Base
{
    /**
     * @inheritdoc
     */
    public function __construct(array $settings = array())
    {
        $settings['type'] = 'blockquote';
        $settings['label'] = 'Цитата';
        $settings['controls'] = [
            new File([
                'name' => 'photo',
                'label' => 'Фото',
            ]),
            new Input([
                'name' => 'sign',
                'label' => 'Подпись',
            ]),
            new Editor([
                'name' => 'text',
                'label' => 'Текст',
            ]),
        ];

        parent::__construct($settings);
    }
}
