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
use Elao\Parameterizer\Parameterizer;
use Elao\Parameterizer\Pattern\Pattern;

/**
 * Parameterizer test
 */
class ParameterizerTest extends \PHPUnit_Framework_TestCase
{
    protected function createParameterizer($name)
    {
        return new Parameterizer(
            $name,
            new ParameterizerFactory(
                new Inflector()
            )
        );
    }

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

    public function testName()
    {
        $parameterizer = $this->createParameterizer('foo');

        $this->assertEquals(
            'foo',
            $parameterizer->getName()
        );
    }

    public function testPatterns()
    {
        $parameterizer = $this->createParameterizer('foo');

        $this->assertInternalType(
            'array',
            $parameterizer->all()
        );

        $this->assertCount(
            0,
            $parameterizer->all()
        );

        $parameterizer = $this->createParameterizer('foo');
        $pattern = $this->createPattern('bar');

        $parameterizer->add($pattern);

        $this->assertInternalType(
            'array',
            $parameterizer->all()
        );

        $this->assertCount(
            1,
            $parameterizer->all()
        );

        $this->assertContainsOnly(
            $pattern,
            $parameterizer->all()
        );

        $this->assertEquals(
            $pattern,
            $parameterizer->get('bar')
        );

        $parameterizer = $this->createParameterizer('foo');
        $pattern = $parameterizer->create('bar', array('foo' => 'bar'));

        $this->assertEquals(
            'bar',
            $pattern->getOption('foo')
        );

        $this->assertInternalType(
            'array',
            $parameterizer->all()
        );

        $this->assertCount(
            1,
            $parameterizer->all()
        );

        $this->assertContainsOnly(
            $pattern,
            $parameterizer->all()
        );

        $this->assertEquals(
            $pattern,
            $parameterizer->get('bar')
        );
    }

    public function testPatternNotFound()
    {
        $parameterizer = $this->createParameterizer('foo');

        $this->setExpectedException('\InvalidArgumentException');
        $parameterizer->get('bar');
    }

    public function testValues()
    {
        $parameterizer = $this->createParameterizer('foo');
        $parameterizer
            ->create('foo')
                ->create('a', '1')
                ->create('b', 2);
        $parameterizer
            ->create('bar')
                ->create('c', '3');

        $this->assertEquals(
            array(
                'foo' => array(
                    'a' => '1',
                    'b' => 2
                ),
                'bar' => array(
                    'c' => '3'
                )
            ),
            $parameterizer->getValues()
        );

        $parameterizer->mergeValues(
            array(
                'foo' => array(
                    'a' => '10'
                ),
                'bar' => array(
                    'd' => '4'
                ),
                'baz' => array(
                    'e' => 5
                )
            )
        );

        $this->assertEquals(
            array(
                'foo' => array(
                    'a' => '10',
                    'b' => 2
                ),
                'bar' => array(
                    'c' => '3'
                )
            ),
            $parameterizer->getValues()
        );
    }
}
