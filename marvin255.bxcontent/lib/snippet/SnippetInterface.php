<?php

namespace marvin255\bxcontent\snippet;

use JsonSerializable;

/**
 * Интерфейс для объекта сниппета, который содержит в себе настройки для
 * отображения управляющего элемента для ввода данных.
 */
interface SnippetInterface extends JsonSerializable
{
    /**
     * Возвращает тип указанного сниппета.
     *
     * @return string
     */
    public function getType();

    /**
     * Задает родительский сниппет для текущего сниппета.
     *
     * @param \marvin255\bxcontent\snippet\SnippetInterface $parentSnippet
     *
     * @return self
     */
    public function setParent(SnippetInterface $parentSnippet);

    /**
     * Возвращает родительский сниппет для текущего сниппета или null если родителя нет.
     *
     * @return \marvin255\bxcontent\snippet\SnippetInterface|null
     */
    public function getParent();

    /**
     * Возвращает машиночитаемое название текущего сниппета.
     *
     * @return string
     */
    public function getName();

    /**
     * Возвращает название для input с учетом всех родителей данного сниппета.
     *
     * @return string
     */
    public function getInputName();

    /**
     * Задает значение данного объекта сниппета.
     *
     * @param mixed $value
     *
     * @return self
     */
    public function setValue($value);

    /**
     * Возвращает значение данного объекта сниппета.
     *
     * @return mixed
     */
    public function getValue();

    /**
     * Задает параметр настройки сниппета.
     *
     * @param string $name  Название параметра
     * @param mixed  $value Значение параметра
     *
     * @return self
     */
    public function setParam($name, $value);

    /**
     * Задает параметры настройки сниппета из массива.
     *
     * @param array $params Массив вида "имя параметра => значение параметра"
     *
     * @return self
     */
    public function setParams(array $params);

    /**
     * Возвращает значение параметра настройки сниппета.
     *
     * @param string $name Название параметра
     *
     * @return mixed
     */
    public function getParam($name);

    /**
     * Возвращает список значений всех параметров сниппета.
     *
     * @return array Массив вида "имя параметра => значение параметра"
     */
    public function getParams();
}
