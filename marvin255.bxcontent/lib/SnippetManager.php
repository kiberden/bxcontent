<?php

namespace marvin255\bxcontent;

use Bitrix\Main\Page\Asset;
use JsonSerializable;

/**
 * Менеджер доступных сниппетов для контента.
 *
 * Так, как нет никакой возможности передать менеджера в инстанс поля, то
 * реализует Singleton, что, в принципе, не особо нужно было бы.
 */
class SnippetManager implements JsonSerializable
{
    /**
     * Объект для реализации singleton.
     *
     * @var \marvin255\bxfoundation\application\Application
     */
    private static $instance = null;
    /**
     * Массив зарегистрированных сниппетов.
     *
     * @var array
     */
    protected $snippets = [];
    /**
     * Список js файлов, которые нужно зарегистрировать для текущего набора сниппетов.
     *
     * @var array
     */
    protected $js = [];

    /**
     * Возвращает объект singleton, если он уже создан, либо создает новый
     * и возвращает новый.
     *
     * @param bool $refresh Флаг, который указывает, что инстанс нужно пересоздать заново
     *
     * @return \marvin255\bxfoundation\application\Application
     */
    public static function getInstance($refresh = false)
    {
        return self::$instance === null || $refresh
            ? self::$instance = new self
            : self::$instance;
    }

    /**
     * Реализация singleton. Запрещает создание новых объектов.
     */
    private function __construct()
    {
    }

    /**
     * Добавляет новый тип сниппета.
     *
     * @param \marvin255\bxcontent\SnippetInterface $snippet Объект сниппета
     *
     * @return \marvin255\bxcontent\SnippetManager
     *
     * @throws \marvin255\bxcontent\Exception
     */
    public function set(SnippetInterface $snippet)
    {
        if ($this->get($snippet->getType()) !== null) {
            throw new Exception('Snippet with type ' . $snippet->getType() . ' already exists');
        }
        $this->snippets[$snippet->getType()] = $snippet;

        return $this;
    }

    /**
     * Удаляет сниппет с сответствующим типом.
     *
     * @param string $type Тип сниппета
     *
     * @return \marvin255\bxcontent\SnippetManager
     *
     * @throws \marvin255\bxcontent\Exception
     */
    public function remove($type)
    {
        if ($this->get($type) === null) {
            throw new Exception('Can\'t find snippet with type ' . $type . ' to unset');
        }
        unset($this->snippets[$type]);

        return $this;
    }

    /**
     * Возвращает сниппет по его имени.
     *
     * @param string $type
     *
     * @return \marvin255\bxcontent\SnippetInterface|null
     */
    public function get($type)
    {
        return isset($this->snippets[$type]) ? $this->snippets[$type] : null;
    }

    /**
     * Приводит данные менеджера сниппетов к представлению, которое будет отправлено в json.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        $return = [];
        foreach ($this->snippets as $type => $snippet) {
            $return[$type] = [
                'type' => $snippet->getType(),
                'label' => $snippet->getLabel(),
                'controls' => $snippet->getControls(),
            ];
        }

        return $return;
    }

    /**
     * Возвращает набор js, которые зарегистриует данны объект.
     *
     * @return array
     */
    public function getJs()
    {
        return $this->js;
    }

    /**
     * Задает список js для регистрации.
     *
     * @param array $js
     *
     * @return \marvin255\bxcontent\SnippetManager
     */
    public function setJs(array $js)
    {
        $this->js = [];
        foreach ($js as $script) {
            $this->addJs($script);
        }

        return $this;
    }

    /**
     * Добавляет скрипт к списку для регистрации
     *
     * @param string $script
     *
     * @return \marvin255\bxcontent\SnippetManager
     */
    public function addJs($script)
    {
        if (trim($script) === '') {
            throw new Exception('Script name can\'t blank');
        }
        $this->js[] = $script;

        return $this;
    }

    /**
     * Регистриует все ассеты для отображения полей в админке.
     *
     * @param \Bitrix\Main\Page\Asset $asset         Менеджер ассетов битрикса
     * @param string                  $parameterName Название параметра, в котором будут переданы все настройки сниппетов
     *
     * @return \marvin255\bxcontent\SnippetManager
     */
    public function registerAssets(Asset $asset, $parameterName = 'marvin255bxcontent')
    {
        $js = $this->getJs();
        foreach ($js as $script) {
            $asset->addJs($script, true);
        }

        $managerData = "<script>window.{$parameterName} = ";
        $managerData .= json_encode($this);
        $managerData .= ';</script>';
        $asset->addString($managerData, true);
    }
}
