<?php

/**
 * This file is part of the ElaoParameterizer component.
 *
 * Copyright (C) 2014 Elao
 *
 * @author Elao <contact@elao.com>
 */

namespace Elao\Parameterizer\Pattern;

use Elao\Parameterizer\Inflector\Inflector;
use Elao\Parameterizer\ParameterizerFactory;
use Elao\Parameterizer\Parameter\Parameter;

/**
 * Parameterizer pattern
 */
class Pattern
{
    /**
     * Name
     *
     * @var string
     */
    protected $name;

    /**
     * Factory
     *
     * @var ParameterizerFactory
     */
    protected $factory;

    /**
     * Inflector
     *
     * @var Inflector
     */
    protected $inflector;

    /**
     * Options
     *
     * - label : Label
     *
     * @var array
     */
    protected $options = array();

    /**
     * Parameters
     *
     * @var array
     */
    protected $parameters = array();

    /**
     * Constructor
     *
     * @param string               $name
     * @param ParameterizerFactory $factory
     * @param Inflector            $inflector
     */
    public function __construct($name, ParameterizerFactory $factory, Inflector $inflector)
    {
        // Name
        $this->name = (string) $name;

        // Factory
        $this->factory = $factory;

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

    /**
     * Get all parameters
     *
     * @return array
     */
    public function all()
    {
        return $this->parameters;
    }

    /**
     * Get a parameter
     *
     * @param string $name
     *
     * @return Parameter
     */
    public function get($name)
    {
        foreach ($this->parameters as $parameter) {
            if ($parameter->getName() == $name) {
                return $parameter;
            }
        }

        throw new \InvalidArgumentException(sprintf('Parameter "%s" not found', $name));
    }

    /**
     * Add a parameter
     *
     * @param string $name
     *
     * @return Pattern
     */
    public function add(Parameter $parameter)
    {
        $this->parameters[] = $parameter;

        return $this;
    }

    /**
     * Create a parameter
     *
     * Convenient method to create and add a parameter at the same time
     *
     * @param string     $name
     * @param null|mixed $value
     * @param array      $options
     *
     * @return Pattern
     */
    public function create($name, $value = null, array $options = array())
    {
        $parameter = $this->factory->createParameter(
            $name,
            $value,
            $options
        );

        $this->add($parameter);

        return $this;
    }

    /**
     * Get a parameter value
     *
     * Convenient method to access directly to a parameter value
     *
     * @param string $name
     * @param mixed  $default
     *
     * @return mixed
     */
    public function getValue($name, $default = null)
    {
        try {
            return $this->get($name)->getValue();
        } catch (\InvalidArgumentException $exception) {
            return $default;
        }
    }

    /**
     * Set a parameter value
     *
     * Convenient method to directly set a parameter value
     *
     * @param string $name
     * @param mixed  $value
     *
     * @return Pattern
     */
    public function setValue($name, $value)
    {
        $this->get($name)->setValue($value);

        return $this;
    }

    /**
     * Get all parameters values
     *
     * @return array
     */
    public function getValues()
    {
        $values = array();

        foreach ($this->parameters as $parameter) {
            $values[$parameter->getName()] = $parameter->getValue();
        }

        return $values;
    }

    /**
     * Merge parameters values
     *
     * @param array $values
     *
     * @return Pattern
     */
    public function mergeValues(array $values = array())
    {
        foreach ($values as $parameterName => $parameterValue) {
            try {
                $parameter = $this->get($parameterName);
                $parameter->setValue($parameterValue);
            } catch (\InvalidArgumentException $exception) {
            }
        }

        return $this;
    }
}
