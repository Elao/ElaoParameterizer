<?php

/**
 * This file is part of the ElaoParameterizer component.
 *
 * Copyright (C) 2014 Elao
 *
 * @author Elao <contact@elao.com>
 */

namespace Elao\Parameterizer\Tests\Pattern;

use Elao\Parameterizer\Inflector\Inflector;
use Elao\Parameterizer\ParameterizerFactory;
use Elao\Parameterizer\Pattern\Pattern;
use Elao\Parameterizer\Parameter\Parameter;

/**
 * Parameterizer pattern test
 */
class PatternTest extends \PHPUnit_Framework_TestCase
{
    protected function createPattern($name)
    {
        $inflector = new Inflector();

        return new Pattern(
            $name,
            new ParameterizerFactory(
                $inflector
            ),
            $inflector
        );
    }

    protected function createParameter($name)
    {
        return new Parameter(
            $name,
            new Inflector()
        );
    }

    public function testName()
    {
        $pattern = $this->createPattern('foo');

        $this->assertEquals(
            'foo',
            $pattern->getName()
        );
    }

    public function testOptions()
    {
        $pattern = $this->createPattern('foo');

        $pattern->setOptions(
            array(
                'foo' => 'bar'
            )
        );

        $this->assertEquals(
            'bar',
            $pattern->getOption('foo')
        );

        $this->assertEquals(
            'Foo',
            $pattern->getOption('label')
        );

        $pattern = $this->createPattern('foo');

        $pattern->setOptions(
            array(
                'foo'   => 'bar',
                'label' => 'Foo bar'
            )
        );

        $this->assertEquals(
            'Foo bar',
            $pattern->getOption('label')
        );

        // Unknown option, using default value
        $this->assertEquals(
            'Bar foo',
            $pattern->getOption('bar', 'Bar foo')
        );
    }

    public function testParameters()
    {
        $pattern = $this->createPattern('foo');

        $this->assertInternalType(
            'array',
            $pattern->all()
        );

        $this->assertCount(
            0,
            $pattern->all()
        );

        $pattern = $this->createPattern('foo');
        $parameter = $this->createParameter('bar');

        $pattern->add($parameter);

        $this->assertInternalType(
            'array',
            $pattern->all()
        );

        $this->assertCount(
            1,
            $pattern->all()
        );

        $this->assertContainsOnly(
            $parameter,
            $pattern->all()
        );

        $this->assertEquals(
            $parameter,
            $pattern->get('bar')
        );

        $pattern = $this->createPattern('foo');
        $pattern->create('bar', 'baz', array('foo' => 'bar'));
        $parameter = $pattern->get('bar');

        $this->assertEquals(
            'baz',
            $parameter->getValue()
        );

        $this->assertEquals(
            'bar',
            $parameter->getOption('foo')
        );

        $this->assertInternalType(
            'array',
            $pattern->all()
        );

        $this->assertCount(
            1,
            $pattern->all()
        );

        $this->assertContainsOnly(
            $parameter,
            $pattern->all()
        );

        $this->assertEquals(
            $parameter,
            $pattern->get('bar')
        );
    }

    public function testParameterNotFound()
    {
        $pattern = $this->createPattern('foo');

        $this->setExpectedException('\InvalidArgumentException');
        $pattern->get('bar');
    }

    public function testValues()
    {
        $pattern = $this->createPattern('foo');
        $pattern->create('bar', 'baz');

        $this->assertEquals(
            'baz',
            $pattern->getValue('bar')
        );

        $pattern->setValue('bar', 'bar');

        $this->assertEquals(
            'bar',
            $pattern->getValue('bar')
        );

        // Unknown parameter, using default value
        $this->assertEquals(
            'bar',
            $pattern->getValue('foo', 'bar')
        );

        $pattern->create('foo', 'baz');

        $this->assertEquals(
            array(
                'bar' => 'bar',
                'foo' => 'baz'
            ),
            $pattern->getValues()
        );

        $pattern->mergeValues(
            array(
                'foo' => 'bar',
                'baz' => 'bar'
            )
        );

        $this->assertEquals(
            array(
                'bar' => 'bar',
                'foo' => 'bar'
            ),
            $pattern->getValues()
        );
    }

    public function testValueParameterNotFound()
    {
        $pattern = $this->createPattern('foo');

        $this->setExpectedException('\InvalidArgumentException');
        $pattern->setValue('foo', 'bar');
    }
}
