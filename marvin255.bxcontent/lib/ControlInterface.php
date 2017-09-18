<?php

namespace marvin255\bxcontent;

use JsonSerializable;

/**
 * Интерфейс для построения элемента управления. Например,
 * input или textarea.
 */
interface ControlInterface extends JsonSerializable
{
    /**
     * Возвращет тип элемента управления.
     *
     * @return string
     */
    public function getType();

    /**
     * Возвращет имя элемента управления.
     *
     * @return string
     */
    public function getName();

    /**
     * Возвращет метку элемента управления.
     *
     * @return string
     */
    public function getLabel();

    /**
     * Возвращет атрибуты элемента управления.
     *
     * @return string
     */
    public function getAttributes();
}
