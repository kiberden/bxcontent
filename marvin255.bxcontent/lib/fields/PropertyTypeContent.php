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
class PropertyTypeContent extends \CUserTypeString
{
    /**
     * Возвращает описание поля для регистрации обработчика.
     *
     * @return array
     */
    public function GetUserTypeDescription()
    {
        return [
            'PROPERTY_TYPE' => 'S',
            'USER_TYPE' => 'Marvin255Bxcontent',
            'DESCRIPTION' => Loc::getMessage('BX_CONTENT_PROPERTY_TYPE_NAME'),
            'GetPropertyFieldHtml' => [__CLASS__, 'getPropertyFieldHtml'],
        ];
    }

    /**
     * Возвращает html для поля для ввода, которое отбразится в административной части.
     *
     * @param array $arProperty         Свойства поля из настроек административной части
     * @param array $value              Массив со значениями поля из битрикса
     * @param array $strHTMLControlName Массив с именами для элементов поля из битрикса
     *
     * @return string
     */
    public function getPropertyFieldHtml($arProperty, $value, $strHTMLControlName)
    {
        CJSCore::Init(['jquery']);
        SnippetManager::getInstance()->registerAssets(Asset::getInstance());

        $return = '<textarea style="display: none;" class="marvin255bxcontent-init" name="' . htmlentities($strHTMLControlName['VALUE']) . '">';
        $return .= htmlentities($value['VALUE']);
        $return .= '</textarea>';

        return $return;
    }
}
