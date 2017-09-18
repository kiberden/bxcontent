<?php

namespace marvin255\bxcontent;

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
     * Возвращает объект singleton, если он уже создан, либо создает новый
     * и возвращает новый.
     *
     * @return \marvin255\bxfoundation\application\Application
     */
    public static function getInstance()
    {
        return self::$instance === null
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
     * Реализация singleton. Запрещает клонирование объектов.
     */
    private function __clone()
    {
    }

    /**
     * Реализация singleton. Запрещает извлечение сериализованных объектов.
     */
    private function __wakeup()
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
        if ($this->get($snippet->getType()) !== null) {
            throw new Exception('Can\'t find snippet with type ' . $snippet->getType() . ' to unset');
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
            $return[$type] = [];
            if ($snippet instanceof JsonSerializable) {
                $return[$type] = $snippet->jsonSerialize();
            }
            $return[$type]['type'] = $snippet->getType();
            $return[$type]['controls'] = $snippet->getControls();
            $return[$type]['label'] = $snippet->getLabel();
            $return[$type]['multiple'] = $snippet->getIsMultiple();
        }

        return $return;
    }
}
