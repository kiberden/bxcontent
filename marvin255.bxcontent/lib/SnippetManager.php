<?php

namespace marvin255\bxcontent;

use marvin255\bxcontent\snippets\SnippetInterface;
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
     * @var \marvin255\bxcontent\SnippetManager
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
     * @return \marvin255\bxcontent\SnippetManager
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
     * Добавляет новый сниппет.
     *
     * @param string                                         $name    Название сниппета
     * @param \marvin255\bxcontent\snippets\SnippetInterface $snippet Объект сниппета
     *
     * @return \marvin255\bxcontent\SnippetManager
     *
     * @throws \marvin255\bxcontent\Exception
     */
    public function set($name, SnippetInterface $snippet)
    {
        $name = $this->normalizeSnippetName($name);
        if (!$name) {
            throw new Exception('Empty snippet name');
        }
        $this->snippets[$name] = $snippet;

        return $this;
    }

    /**
     * Удаляет сниппет.
     *
     * @param string $name Название сниппета
     *
     * @return \marvin255\bxcontent\SnippetManager
     *
     * @throws \marvin255\bxcontent\Exception
     */
    public function remove($name)
    {
        if ($this->get($name) === null) {
            throw new Exception('Can\'t find snippet with type ' . $name . ' to unset');
        }
        $name = $this->normalizeSnippetName($name);
        unset($this->snippets[$name]);

        return $this;
    }

    /**
     * Возвращает сниппет по его имени.
     *
     * @param string $name Название сниппета
     *
     * @return \marvin255\bxcontent\snippets\SnippetInterface|null
     */
    public function get($name)
    {
        $name = $this->normalizeSnippetName($name);

        return isset($this->snippets[$name]) ? $this->snippets[$name] : null;
    }

    /**
     * Приводит имена сниппетов в единообразный вид.
     *
     * @param string $name
     *
     * @return string
     */
    protected function normalizeSnippetName($name)
    {
        return strtolower(trim($name));
    }

    /**
     * Приводит данные менеджера сниппетов к представлению, которое будет отправлено в json.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        $return = [];
        foreach ($this->snippets as $name => $snippet) {
            $return[$name] = [
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
     * Добавляет скрипт к списку для регистрации.
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
     * @param \Bitrix\Main\Page\Asset $asset Менеджер ассетов битрикса
     *
     * @return \marvin255\bxcontent\SnippetManager
     */
    public function registerAssets(Asset $asset)
    {
        $js = $this->getJs();
        foreach ($js as $script) {
            $asset->addJs($script, true);
        }

        $managerData = "<script>$.fn.marvin255bxcontent('registerSnippets', ";
        $managerData .= json_encode($this);
        $managerData .= ');</script>';
        $asset->addString($managerData, true);
    }
}
