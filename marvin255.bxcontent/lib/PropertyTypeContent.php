<?php

namespace marvin255\bxcontent;

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Page\Asset;
use marvin255\bxcontent\SnippetManager;
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
     * @param array $arProperty Свойства поля из настроек административной части
     * @param array $value Массив со значениями поля из битрикса
     * @param array $strHTMLControlName Массив с именами для элементов поля из битрикса
     *
     * @return string
     */
    public function getPropertyFieldHtml($arProperty, $value, $strHTMLControlName)
    {
        self::registerAssets();
        $return = '<textarea style="display: none;" class="marvin255bxcontent-init" name="' . htmlentities($strHTMLControlName['VALUE']) . '">';
        $return .= htmlentities($value['VALUE']);
        $return .= '</textarea>';

        return $return;
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
