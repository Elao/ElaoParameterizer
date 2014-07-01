<?php

/**
 * This file is part of the ElaoParameterizer component.
 *
 * Copyright (C) 2014 Elao
 *
 * @author Elao <contact@elao.com>
 */

namespace Elao\Parameterizer\Tests;

use Elao\Parameterizer\Inflector\Inflector;
use Elao\Parameterizer\ParameterizerFactory;

/**
 * Parameterizer factory test
 */
class ParameterizerFactoryTest extends \PHPUnit_Framework_TestCase
{
    protected function createParameterizerFactory()
    {
        return new ParameterizerFactory(
            new Inflector()
        );
    }

    public function testCreate()
    {
        $factory = $this->createParameterizerFactory();

        $parameterizer = $factory->create('foo');

        $this->assertInstanceOf(
            'Elao\Parameterizer\Parameterizer',
            $parameterizer
        );

        $this->assertEquals(
            'foo',
            $parameterizer->getName()
        );
    }

    public function testCreatePattern()
    {
        $factory = $this->createParameterizerFactory();

        $pattern = $factory->createPattern(
            'foo',
            array('foo' => 'bar')
        );

        $this->assertInstanceOf(
            'Elao\Parameterizer\Pattern\Pattern',
            $pattern
        );

        $this->assertEquals(
            'foo',
            $pattern->getName()
        );

        $this->assertEquals(
            'bar',
            $pattern->getOption('foo')
        );
    }

    public function testCreateParameter()
    {
        $factory = $this->createParameterizerFactory();

        $parameter = $factory->createParameter(
            'foo',
            'bar',
            array('foo' => 'bar')
        );

        $this->assertInstanceOf(
            'Elao\Parameterizer\Parameter\Parameter',
            $parameter
        );

        $this->assertEquals(
            'foo',
            $parameter->getName()
        );

        $this->assertEquals(
            'bar',
            $parameter->getValue()
        );

        $this->assertEquals(
            'bar',
            $parameter->getOption('foo')
        );
    }
}
