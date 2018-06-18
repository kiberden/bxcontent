<?php

namespace marvin255\bxcontent\snippet;

use InvalidArgumentException;

/**
 * Объект сниппета, который содержит в себе настройки для
 * отображения управляющего элемента для ввода данных.
 */
class Snippet implements SnippetInterface
{
    /**
     * @var string
     */
    protected $type;
    /**
     * @var string
     */
    protected $name;
    /**
     * @var mixed
     */
    protected $value;
    /**
     * @var \marvin255\bxcontent\snippet\SnippetInterface
     */
    protected $parent;
    /**
     * @var array
     */
    protected $params = [];

    /**
     * @param string $type
     * @param string $name
     * @param array  $params
     *
     * @throws \InvalidArgumentException
     */
    public function __construct($type, $name, array $params = [])
    {
        if (!$this->isItemAValidName($type)) {
            throw new InvalidArgumentException(
                'Snippet type must be a non empty string of digits, latins and _'
            );
        }
        $this->type = $type;

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
     * @inheritdoc
     */
    public function getInputName()
    {
        return $this->parent
            ? $this->parent->getInputName() . "[{$this->name}]"
            : $this->name;
    }

    /**
     * @inheritdoc
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getValue()
    {
        return $this->value;
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

        if (!is_scalar($value) && !is_array($value)) {
            throw new InvalidArgumentException(
                'Parameter value must be scalar (string, int, float, etc.) or array'
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
        $return = $this->getParams();
        $return['name'] = $this->getName();
        $return['inputName'] = $this->getInputName();
        $return['type'] = $this->getType();

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
