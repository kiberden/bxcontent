<?php

namespace marvin255\bxcontent;

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Page\Asset;
use CJSCore;

Loc::loadMessages(__FILE__);

/**
 * Пользовательское поле, для которого додавляется js конструктор, что позволяет
 * создавать сложный html: слайдеры, аккордеоны и т.д.
 */
class UserTypeContent
{
    /**
     * Возвращает описание поля для регистрации обработчика.
     *
     * @return array
     */
    public function GetUserTypeDescription()
    {
        return [
            'USER_TYPE_ID' => 'Marvin255Bxcontent',
            'CLASS_NAME' => '\marvin255\bxcontent\UserTypeContent',
            'DESCRIPTION' => Loc::getMessage('BX_CONTENT_PROPERTY_TYPE_NAME'),
            'BASE_TYPE' => 'string',
        ];
    }

    /**
     * Возвращает html для поля для ввода, которое отбразится в административной части.
     *
     * @param array $field   Свойства поля из настроек административной части
     * @param array $control Массив с именами для элементов поля из битрикса
     *
     * @return string
     */
    public function GetEditFormHTML($field, $control)
    {
        self::registerAssets();
        $return = '<textarea style="display: none;" class="marvin255bxcontent-init" name="' . htmlentities($control['NAME']) . '">';
        $return .= htmlentities(isset($field['VALUE']) ? $field['VALUE'] : '');
        $return .= '</textarea>';

        return $return;
    }

    /**
     * Возвращает описание колонки в базе данных, которая будет создана для сущности.
     */
    public function GetDBColumnType($field)
    {
        return 'text';
    }

    /**
     * Регистрирует все js и css файлы, которые необходимы для работы поля.
     */
    protected static function registerAssets()
    {
        $managerData = '<script>window.marvin255bxcontent = ';
        $managerData .= json_encode(SnippetManager::getInstance());
        $managerData .= ';</script>';
        Asset::getInstance()->addString($managerData, true);

        CJSCore::Init(['jquery']);
    }
}
