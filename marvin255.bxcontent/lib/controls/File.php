<?php

namespace marvin255\bxcontent\controls;

use CAdminFileDialog;

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

    /**
     * @inheritdoc
     */
    public function jsonSerialize()
    {
        $return = parent::jsonSerialize();
        $return['template'] = $this->getTemplate();

        return $return;
    }

    /**
     * Возвращает шаблон для создания поля в js.
     *
     * В битриксе довольно эксцентричный js, который нельзя вызвать из js, а
     * приходится вызывать исключительно из php. Функция создает шаблон со
     * специальными плейсхолдерами для подстановки в js.
     *
     * @return string
     */
    protected function getTemplate()
    {
        $cAdminFileDialog = [
            'event' => '_____clickEvent_____',
            'arResultDest' => [
                'ELEMENT_ID' => '_____elementId_____',
            ],
            'arPath' => [
                'PATH' => '/upload',
            ],
            'select' => 'F',
            'operation' => 'O',
            'showUploadTab' => true,
            'showAddToMenuTab' => false,
            'allowAllFiles' => false,
            'SaveConfig' => false,
            'fileFilter' => 'png,jpg,jpeg,pdf,doc,docx,xls,xlsx,ppt,pptx,txt',
        ];

        ob_start();
        ob_implicit_flush(false);
        CAdminFileDialog::ShowScript($cAdminFileDialog);

        return ob_get_clean();
    }
}
