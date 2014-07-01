<?php

/**
 * This file is part of the ElaoParameterizer component.
 *
 * Copyright (C) 2014 Elao
 *
 * @author Elao <contact@elao.com>
 */

namespace Elao\Parameterizer\Inflector;

/**
 * Parameterizer inflector
 */
class Inflector
{
    /**
     * Humanize
     *
     * @param string $text
     *
     * @return string
     */
    public function humanize($text)
    {
        return ucfirst(trim(strtolower(preg_replace(array('/([A-Z])/', '/[_\s]+/'), array('_$1', ' '), $text))));
    }
}
