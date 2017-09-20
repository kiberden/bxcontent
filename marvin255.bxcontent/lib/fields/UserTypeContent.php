<?php

namespace marvin255\bxcontent\fields;

use marvin255\bxcontent\SnippetManager;
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
        CJSCore::Init(['jquery']);
        SnippetManager::getInstance()->registerAssets(Asset::getInstance());

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
}
