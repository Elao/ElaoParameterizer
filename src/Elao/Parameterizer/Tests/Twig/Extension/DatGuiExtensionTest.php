<?php

/**
 * This file is part of the ElaoParameterizer component.
 *
 * Copyright (C) 2014 Elao
 *
 * @author Elao <contact@elao.com>
 */

namespace Elao\Parameterizer\Tests\Twig\Extension;

use Elao\Parameterizer\Inflector\Inflector;
use Elao\Parameterizer\ParameterizerFactory;
use Elao\Parameterizer\Parameterizer;
use Elao\Parameterizer\Twig\Extension\DatGuiExtension;

/**
 * Parameterizer DatGui twig extension test
 */
class DatGuiExtensionTest extends \PHPUnit_Framework_TestCase
{
    protected function createDatGuiExtension(Parameterizer $parameterizer)
    {
        return new DatGuiExtension(
            $parameterizer
        );
    }

    protected function createParameterizer($name)
    {
        return new Parameterizer(
            $name,
            new ParameterizerFactory(
                new Inflector()
            )
        );
    }

    public function testName()
    {
        $extension = $this->createDatGuiExtension(
            $this->createParameterizer('foo')
        );

        $this->assertEquals(
            'elao_parameterizer_dat_gui',
            $extension->getName()
        );
    }

    public function testFunctions()
    {
        $extension = $this->createDatGuiExtension(
            $this->createParameterizer('foo')
        );



        $this->assertContains(
            'elao_parameterizer_dat_gui_render_javascript',
            array_map(
                function($function) {
                    return $function->getName();
                },
                $extension->getFunctions()
            )
        );
    }

    public function testRenderJavascript()
    {
        $parameterizer = $this->createParameterizer('foo');
        $parameterizer
            ->create('foo')
                ->create('a', 1)
                ->create('b', 2, array('choices' => array(1, 2, 3)))
                ->create('c', 3, array('min' => 2, 'max' => 4))
                ->create('d', 4, array('step' => 1));


        $extension = $this->createDatGuiExtension($parameterizer);

        $this->assertNotEmpty(
            $extension->renderJavascript(array('gui' => 'gui'))
        );
    }
}
