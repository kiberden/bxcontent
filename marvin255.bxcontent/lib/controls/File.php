<?php

namespace marvin255\bxcontent\controls;

/**
 * Поле для ввода, которое отображается в виде строки
 * с возможностью загрузить файл чере интерфейс битрикса.
 */
class File extends Base
{
    /**
     * @inheritdoc
     */
    public function getType()
    {
        return 'file';
    }
}
