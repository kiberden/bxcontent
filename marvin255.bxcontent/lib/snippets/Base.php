<?php

namespace marvin255\bxcontent\snippets;

use marvin255\bxcontent\SnippetInterface;
use marvin255\bxcontent\ControlInterface;
use marvin255\bxcontent\Exception;

/**
 * Базовый сниппет, получает данные из массива в конструкторе
 * и проверяет их на валидность.
 */
class Base implements SnippetInterface
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
        } else {
            $controls = [];
            foreach ($this->settings['controls'] as $key => $control) {
                if (!($control instanceof ControlInterface)) {
                    throw new Exception("Control with key {$key} must be a ControlInterface instance");
                } elseif (isset($controls[$control->getName()])) {
                    throw new Exception('Control with name ' . $control->getName() . ' already exists');
                }
                $controls[$control->getName()] = $control;
            }
            $this->settings['controls'] = $controls;
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
    public function getRenderer()
    {
        return null;
    }
}
