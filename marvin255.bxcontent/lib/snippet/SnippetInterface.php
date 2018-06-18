<?php

namespace marvin255\bxcontent\snippet;

use JsonSerializable;

/**
 * Интерфейс для объекта сниппета, который содержит в себе настройки для
 * отображения управляющего элемента для ввода данных.
 *
 * Ключевые параметры сниппета - имя и тип. Имя должно быть уникальным
 * в рамках контекста (сниппет может быть вложен в другой сниппет, значит в рамках родителя
 * или же в списке сниппетов, который будут отправлены для отображения).
 * Тип может быть общий для нескольких сниппетов и используется для того, чтобы
 * объединить сниппеты с одинаковой логикой для представления.
 */
interface SnippetInterface extends JsonSerializable
{
    /**
     * Возвращает тип данного сниппета.
     *
     * @return string
     */
    public function getType();

    /**
     * Задает родительский сниппет для данного сниппета.
     *
     * @param \marvin255\bxcontent\snippet\SnippetInterface $parentSnippet
     *
     * @return self
     */
    public function setParent(SnippetInterface $parentSnippet);

    /**
     * Возвращает родительский сниппет для данного сниппета или null если родителя нет.
     *
     * @return \marvin255\bxcontent\snippet\SnippetInterface|null
     */
    public function getParent();

    /**
     * Возвращает уникальное в рамках контекста имя данного сниппета.
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
     * Задает значение данного сниппета.
     *
     * @param mixed $value
     *
     * @return self
     */
    public function setValue($value);

    /**
     * Возвращает значение данного сниппета.
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
