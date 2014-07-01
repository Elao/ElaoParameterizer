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
 * Parameterizable
 */
interface Parameterizable
{
    /**
     * Set parameters
     *
     * @param Pattern $parameters
     */
    public function setParameters(Pattern $parameters);
}
