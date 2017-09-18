<?php

namespace marvin255\bxcontent\snippets;

use marvin255\bxcontent\SnippetInterface;
use marvin255\bxcontent\Exception;
use JsonSerializable;

/**
 * Базовый сниппет, получает данные из массива в конструкторе
 * и проверяет их на валидность.
 */
class Base implements SnippetInterface, JsonSerializable
{
    /**
     * Настройки сниппета, вида "название поля => значение".
     *
     * @var array
     */
    protected $settings = [];

    /**
     * Конструктор. Задает настройки сниппета из массива.
     *
     * Настройки, которые не являются базовыми будут добавлены
     * в дополнительные параметры, которые выведутся в js в общем массиве.
     *
     * @param array $settings Настройки сниппета, вида "название поля => значение"
     */
    public function __construct(array $settings)
    {
        $this->configSnippet($settings);
        $this->checkSnippet();
    }

    /**
     * Задает настройки сниппета из массива.
     *
     * @param array $settings Настройки сниппета, вида "название поля => значение"
     *
     * @return \marvin255\bxcontent\SnippetInterface
     */
    protected function configSnippet(array $settings)
    {
        $this->settings = $settings;

        return $this;
    }

    /**
     * Проверяет текущие настройки сниппетан а валидность.
     *
     * @return \marvin255\bxcontent\SnippetInterface
     *
     * @throws \marvin255\bxcontent\Exception
     */
    protected function checkSnippet()
    {
        if (empty($this->settings['type']) || trim($this->settings['type']) === '') {
            throw new Exception('Snippet\'s type can\'t be empty');
        }

        if (empty($this->settings['label']) || trim($this->settings['label']) === '') {
            throw new Exception('Snippet\'s label can\'t be empty');
        }

        if (empty($this->settings['controls']) || !is_array($this->settings['controls'])) {
            throw new Exception('Snippet\'s controls must be a non empty array instance');
        }

        if (isset($this->settings['multiple']) && !is_bool($this->settings['multiple'])) {
            throw new Exception('Snippet\'s multiple must be a bool instance');
        }

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getType()
    {
        return $this->settings['type'];
    }

    /**
     * @inheritdoc
     */
    public function getLabel()
    {
        return $this->settings['label'];
    }

    /**
     * @inheritdoc
     */
    public function getControls()
    {
        return $this->settings['controls'];
    }

    /**
     * @inheritdoc
     */
    public function getMultiple()
    {
        return isset($this->settings['multiple']) ? $this->settings['multiple'] : false;
    }

    /**
     * @inheritdoc
     */
    public function getRenderer()
    {
        return null;
    }

    /**
     * @inheritdoc
     */
    public function jsonSerialize()
    {
        return $this->settings;
    }
}
