<?php

/**
 * This file is part of the ElaoParameterizer component.
 *
 * Copyright (C) 2014 Elao
 *
 * @author Elao <contact@elao.com>
 */

namespace Elao\Parameterizer\Twig\Extension;

use Elao\Parameterizer\Parameterizer;

/**
 * Twig dat gui extension
 */
class DatGuiExtension extends \Twig_Extension
{
    /**
     * Parameterizer
     *
     * @var Parameterizer
     */
    protected $parameterizer;

    /**
     * Constructor
     *
     * @param Parameterizer $parameterizer
     */
    public function __construct(Parameterizer $parameterizer)
    {
        // Parameterizer
        $this->parameterizer = $parameterizer;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'elao_parameterizer_dat_gui';
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction(
                'elao_parameterizer_dat_gui_render_javascript',
                array($this, 'renderJavascript'),
                array('is_safe' => array('html')
            )
        );
    }

    /**
     * Render javascript
     *
     * @param array $options
     *
     * @return string
     */
    public function renderJavascript(array $options = array())
    {
        // Options
        $options = array_merge(
            array(
                'gui' => 'gui'
            ),
            $options
        );

        $javascript = '(function(gui) {' . "\n";

        $javascript .= <<< EOF

function setCookie(name, value) {
    var expires = '';
    document.cookie = name + '=' + value + expires + '; path=/';
}

function extend(out) {
    out = out || {};
    for (var i = 1; i < arguments.length; i++) {
        if (!arguments[i])
            continue;
        for (var key in arguments[i]) {
            if (arguments[i].hasOwnProperty(key))
                out[key] = arguments[i][key];
        }
    }
  return out;
};

EOF;

        $javascript .= 'function onParametersUpdated() {' . "\n";
        $javascript .= '    setCookie(\'' . $this->parameterizer->getName() . '\', JSON.stringify(parameters));' . "\n";
        $javascript .= '}' . "\n\n";

        // Parameters
        $javascript .= 'var parameters = ' . json_encode($this->parameterizer->getValues()) . ';' . "\n\n";

        // Patterns
        $javascript .= 'var patterns = {';
        foreach ($this->parameterizer->all() as $pattern) {
            $javascript .=
                "\n" .
                '    \'' . $pattern->getName() . '\': gui.addFolder(\'' .
                $pattern->getOption('label') .
                '\'),';
        }
        $javascript = rtrim($javascript, ',');
        $javascript .= "\n" .'};' . "\n\n";

        // Patterns definitions
        foreach ($this->parameterizer->all() as $pattern) {
            foreach ($pattern->all() as $parameter) {
                $javascript .=
                    'patterns[\'' .
                    $pattern->getName() .
                    '\']' . "\n";
                $javascript .=
                    '    .add(parameters[\'' .
                    $pattern->getName() .
                    '\'], \'' .
                    $parameter->getName() . '\'';
                if ($parameter->getOption('choices')) {
                    $javascript .= ', ' . json_encode($parameter->getOption('choices'));
                }
                if (!is_null($parameter->getOption('min')) && !is_null($parameter->getOption('max'))) {
                    $javascript .= ', ' . $parameter->getOption('min') . ', ' . $parameter->getOption('max');
                }
                $javascript .= ')' . "\n";
                if (!is_null($parameter->getOption('step'))) {
                    $javascript .= '    .step(' . $parameter->getOption('step')  . ')' . "\n";
                }
                $javascript .= '    .name(\'' . $parameter->getOption('label')  . '\')' . "\n";
                $javascript .= '    .onChange(onParametersUpdated);' . "\n";
            }
        }

        $javascript .= '})(' . $options['gui'] . ');';

        return $javascript;
    }
}
