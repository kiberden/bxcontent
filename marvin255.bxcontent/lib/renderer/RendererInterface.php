<?php

namespace marvin255\bxcontent\renderer;

use marvin255\bxcontent\snippet\SnippetInterface;

/**
 * Интерфейс для объекта, который отображает html для сниппета.
 */
interface RendererInterface
{
    /**
     * Возвращает строку с html для указанного в параметре сниппета.
     *
     * @param \marvin255\bxcontent\snippet\SnippetInterface $snippet
     *
     * @return string
     */
    public function render(SnippetInterface $snippet);
}
