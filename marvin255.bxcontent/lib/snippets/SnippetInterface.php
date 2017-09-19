<?php

namespace marvin255\bxcontent\snippets;

/**
 * Интерфейс для построения законченой части контента - сниппета. Например,
 * сниппет слайдера или сниппет аккордеона.
 */
interface SnippetInterface
{
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
}
