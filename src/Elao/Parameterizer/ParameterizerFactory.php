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
use Elao\Parameterizer\Parameter\Parameter;
use Elao\Parameterizer\Inflector\Inflector;

/**
 * Parameterizer factory
 */
class ParameterizerFactory
{
    /**
     * Inflector
     *
     * @var Inflector
     */
    protected $inflector;

    /**
     * Constructor
     *
     * @param string $name
     */
    public function __construct(Inflector $inflector)
    {
        // Inflector
        $this->inflector = $inflector;
    }

    /**
     * Create
     *
     * @param string $name
     */
    public function create($name)
    {
        $parameterizer = new Parameterizer(
            $name,
            $this
        );

        return $parameterizer;
    }

    /**
     * Create a pattern
     *
     * @param string $name
     * @param array  $options
     */
    public function createPattern($name, array $options = array())
    {
        $pattern = new Pattern(
            $name,
            $this,
            $this->inflector
        );

        return $pattern
            ->setOptions($options);
    }

    /**
     * Create a parameter
     *
     * @param string     $name
     * @param null|mixed $value
     * @param array      $options
     */
    public function createParameter($name, $value = null, array $options = array())
    {
        $parameter = new Parameter(
            $name,
            $this->inflector
        );

        return $parameter
            ->setValue($value)
            ->setOptions($options);
    }
}
