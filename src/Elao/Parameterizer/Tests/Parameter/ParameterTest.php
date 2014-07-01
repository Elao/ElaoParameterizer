<?php

/**
 * This file is part of the ElaoParameterizer component.
 *
 * Copyright (C) 2014 Elao
 *
 * @author Elao <contact@elao.com>
 */

namespace Elao\Parameterizer\Tests\Parameter;

use Elao\Parameterizer\Inflector\Inflector;
use Elao\Parameterizer\Parameter\Parameter;

/**
 * Parameterizer parameter test
 */
class ParameterTest extends \PHPUnit_Framework_TestCase
{
    protected function createParameter($name)
    {
        return new Parameter(
            $name,
            new Inflector()
        );
    }

    public function testName()
    {
        $parameter = $this->createParameter('foo');

        $this->assertEquals(
            'foo',
            $parameter->getName()
        );
    }

    public function testValue()
    {
        $parameter = $this->createParameter('foo');

        $parameter->setValue('bar');

        $this->assertEquals(
            'bar',
            $parameter->getValue()
        );
    }

    public function testOptions()
    {
        $parameter = $this->createParameter('foo');

        $parameter->setOptions(
            array(
                'foo' => 'bar'
            )
        );

        $this->assertEquals(
            'bar',
            $parameter->getOption('foo')
        );

        $this->assertEquals(
            'Foo',
            $parameter->getOption('label')
        );

        $parameter = $this->createParameter('foo');

        $parameter->setOptions(
            array(
                'foo'   => 'bar',
                'label' => 'Foo bar'
            )
        );

        $this->assertEquals(
            'Foo bar',
            $parameter->getOption('label')
        );

        // Unknown option, using default value
        $this->assertEquals(
            'Bar foo',
            $parameter->getOption('bar', 'Bar foo')
        );
    }
}
