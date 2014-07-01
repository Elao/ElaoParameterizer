<?php

/**
 * This file is part of the ElaoParameterizer component.
 *
 * Copyright (C) 2014 Elao
 *
 * @author Elao <contact@elao.com>
 */

namespace Elao\Parameterizer\Parameter;

use Elao\Parameterizer\Inflector\Inflector;

/**
 * Parameterizer parameter
 */
class Parameter
{
    /**
     * Name
     *
     * @var string
     */
    protected $name;

    /**
     * Value
     *
     * @var mixed
     */
    protected $value;

    /**
     * Options
     *
     * - label   : Label
     * - choices : Array of choices
     * - min     : Minimum value
     * - max     : Maximum value
     * - step    : Incremental step
     *
     * @var array
     */
    protected $options = array();

    /**
     * Constructor
     *
     * @param string    $name
     * @param Inflector $inflector
     */
    public function __construct($name, Inflector $inflector)
    {
        // Name
        $this->name = (string) $name;

        // Inflector
        $this->inflector = $inflector;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get value
     *
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set value
     *
     * @param mixed $value
     *
     * @return Parameter
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Set options
     *
     * @return Pattern
     */
    public function setOptions(array $options)
    {
        // Options
        $this->options = array_merge(
            $this->options,
            $options
        );

        // Options - Label
        if (!isset($this->options['label'])) {
            $this->options['label'] = $this->inflector->humanize($this->name);
        }

        return $this;
    }

    /**
     * Get option
     *
     * @param string     $name
     * @param mixed|null $default
     *
     * @return mixed
     */
    public function getOption($name, $default = null)
    {
        if (array_key_exists($name, $this->options)) {
            return $this->options[$name];
        }

        return $default;
    }
}
