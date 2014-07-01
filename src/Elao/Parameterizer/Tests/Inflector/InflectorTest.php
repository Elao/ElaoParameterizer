<?php

/**
 * This file is part of the ElaoParameterizer component.
 *
 * Copyright (C) 2014 Elao
 *
 * @author Elao <contact@elao.com>
 */

namespace Elao\Parameterizer\Tests\Inflector;

use Elao\Parameterizer\Inflector\Inflector;

/**
 * Parameterizer inflector test
 */
class InflectorTest extends \PHPUnit_Framework_TestCase
{
    protected function createInflector()
    {
        return new Inflector();
    }

    /**
     * @dataProvider testHumanizeProvider
     */
    public function testHumanize($text, $humanizedText)
    {
        $inflector = $this->createInflector();

        $this->assertEquals(
            $humanizedText,
            $inflector->humanize($text)
        );
    }

    public function testHumanizeProvider()
    {
        return array(
              array('foo', 'Foo'),
              array(' foo ', 'Foo'),
              array('fOo', 'F oo'),
              array('foo bar', 'Foo bar'),
              array('foo_bar', 'Foo bar'),
              array('foo-bar', 'Foo-bar'),
              array('foo.bar', 'Foo.bar')
        );
    }
}
