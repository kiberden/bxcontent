<?php

namespace marvin255\bxcontent\controls;

/**
 * Поле для ввода, которое отображается в виде WYSIWYG редактора.
 */
class Editor extends Base
{
    /**
     * @inheritdoc
     */
    public function getType()
    {
        return 'editor';
    }
}
