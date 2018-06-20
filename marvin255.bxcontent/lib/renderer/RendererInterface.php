<?php

namespace marvin255\bxcontent\renderer;

/**
 * Интерфейс для объекта, который отображает html для сниппета.
 */
interface RendererInterface
{
    /**
     * Возвращает строку с html, построенную на основе параметров.
     *
     * @param array $value
     *
     * @return string
     */
    public function render(array $value);
}
