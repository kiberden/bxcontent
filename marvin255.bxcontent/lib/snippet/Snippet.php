<?php

namespace marvin255\bxcontent\snippet;

use InvalidArgumentException;

/**
 * Объект сниппета, который содержит в себе настройки для
 * отображения управляющего элемента для ввода данных.
 *
 * Ключевые параметры сниппета - имя и тип. Имя должно быть уникальным
 * в рамках контекста (сниппет может быть вложен в другой сниппет, значит в рамках родителя
 * или же в списке сниппетов, который будут отправлены для отображения).
 * Тип может быть общий для нескольких сниппетов и используется для того, чтобы
 * объединить сниппеты с одинаковой логикой для представления.
 */
class Snippet implements SnippetInterface
{
    /**
     * @var string
     */
    protected $type = 'default';
    /**
     * @var string
     */
    protected $name;
    /**
     * @var \marvin255\bxcontent\snippet\SnippetInterface
     */
    protected $parent;
    /**
     * @var array
     */
    protected $params = [];

    /**
     * @param string $name
     * @param array  $params
     *
     * @throws \InvalidArgumentException
     */
    public function __construct($name, array $params = [])
    {
        if (!$this->isItemAValidName($name)) {
            throw new InvalidArgumentException(
                'Snippet name must be a non empty string of digits, latins and _'
            );
        }
        $this->name = $name;

        $this->setParams($params);
    }

    /**
     * @inheritdoc
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @inheritdoc
     */
    public function setParent(SnippetInterface $parentSnippet)
    {
        $this->parent = $parentSnippet;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     *
     * @throws \InvalidArgumentException
     */
    public function setParam($name, $value)
    {
        if (!$this->isItemAValidName($name)) {
            throw new InvalidArgumentException(
                'Parameter name must be a non empty string of digits, latins and _'
            );
        }

        $this->params[$name] = $value;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function setParams(array $params)
    {
        $this->params = [];
        foreach ($params as $name => $value) {
            $this->setParam($name, $value);
        }

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getParam($name)
    {
        return isset($this->params[$name]) ? $this->params[$name] : null;
    }

    /**
     * @inheritdoc
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @inheritdoc
     */
    public function jsonSerialize()
    {
        $return['name'] = $this->getName();
        $return['type'] = $this->getType();
        $return['params'] = $this->getParams();

        return $return;
    }

    /**
     * Проверяет, что строка является не пустой и содержит только цифры, латиницу
     * и символ подчеркивания.
     *
     * @param string $itemToCheck
     *
     * @return bool
     */
    protected function isItemAValidName($itemToCheck)
    {
        return is_string($itemToCheck) && preg_match('/^[0-9a-zA-Z_]+$/', $itemToCheck);
    }
}
