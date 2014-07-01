<?php

/**
 * This file is part of the ElaoParameterizer component.
 *
 * Copyright (C) 2014 Elao
 *
 * @author Elao <contact@elao.com>
 */

namespace Elao\Parameterizer;

use Elao\Parameterizer\Pattern\Pattern;

/**
 * Parameterizer
 */
class Parameterizer
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
     * Patterns
     *
     * @var array
     */
    protected $patterns = array();

    /**
     * Constructor
     *
     * @param string               $name
     * @param ParameterizerFactory $factory
     */
    public function __construct($name, ParameterizerFactory $factory)
    {
        // Name
        $this->name = (string) $name;

        // Factory
        $this->factory = $factory;
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
     * Get all patterns
     *
     * @return array
     */
    public function all()
    {
        return $this->patterns;
    }

    /**
     * Get a pattern
     *
     * @param string $name
     *
     * @return Pattern
     */
    public function get($name)
    {
        foreach ($this->patterns as $pattern) {
            if ($pattern->getName() == $name) {
                return $pattern;
            }
        }

        throw new \InvalidArgumentException(sprintf('Pattern "%s" not found', $name));
    }

    /**
     * Add a pattern
     *
     * @param Pattern $pattern
     *
     * @return Parameterizer
     */
    public function add(Pattern $pattern)
    {
        $this->patterns[] = $pattern;

        return $this;
    }

    /**
     * Create a pattern
     *
     * Convenient method to create and add a pattern at the same time
     *
     * @param string $name
     * @param array  $options
     *
     * @return Parameterizer
     */
    public function create($name, array $options = array())
    {
        $pattern = $this->factory->createPattern(
            $name,
            $options
        );

        $this->add($pattern);

        return $pattern;
    }

    /**
     * Get parameters values from patterns
     *
     * @return array
     */
    public function getValues()
    {
        $values = array();

        foreach ($this->patterns as $pattern) {
            $values[$pattern->getName()] = $pattern->getValues();
        }

        return $values;
    }

    /**
     * Merge patterns parameters values
     *
     * @param array $values
     *
     * @return Parameterizer
     */
    public function mergeValues(array $values = array())
    {
        foreach ($values as $patternName => $patternValues) {
            try {
                // Import pattern parameters
                $pattern = $this->get($patternName);
                $pattern->mergeValues($patternValues);
            } catch (\InvalidArgumentException $exception) {
            }
        }

        return $this;
    }
}
