<?php

namespace marvin255\bxcontent;

/**
 * Интерфейс для построения законченой части контента - сниппета. Например,
 * сниппет слайдера или сниппет аккордеона.
 */
interface SnippetInterface
{
    /**
     * Возвращет тип сниппета.
     *
     * @return string
     */
    public function getType();

    /**
     * Возвращет человекочитаемую метку сниппета.
     *
     * @return string
     */
    public function getLabel();

    /**
     * Возвращет массив с полями для ввода, которые будут выводиться в админке.
     *
     * @return array
     */
    public function getControls();

    /**
     * Возвращет правду, если можно созать несколько экземпляров данного сниппета.
     *
     * @return bool
     */
    public function getMultiple();

    /**
     * Возвращет объект для отображения сниппета или строку с вызовом компонента для отображения.
     *
     * @return string
     */
    public function getRenderer();
}
