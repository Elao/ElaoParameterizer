ElaoParameterizer
=================

[![Latest Stable Version](https://poser.pugx.org/elao/parameterizer/v/stable.svg)](https://packagist.org/packages/elao/parameterizer)
[![Total Downloads](https://poser.pugx.org/elao/parameterizer/downloads.svg)](https://packagist.org/packages/elao/parameterizer)
[![Latest Unstable Version](https://poser.pugx.org/elao/parameterizer/v/unstable.svg)](https://packagist.org/packages/elao/parameterizer)
[![License](https://poser.pugx.org/elao/parameterizer/license.svg)](https://packagist.org/packages/elao/parameterizer)

[![Build Status](https://travis-ci.org/Elao/ElaoParameterizer.svg?branch=master)](https://travis-ci.org/Elao/ElaoParameterizer)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Elao/ElaoParameterizer/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Elao/ElaoParameterizer/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/Elao/ElaoParameterizer/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/Elao/ElaoParameterizer/?branch=master)

Description:
------------

This component provides a set of classes to handle some service parameters in a structured way, and a twig [dat.GUI](http://workshop.chromeexperiments.com/examples/gui/#1--Basic-Usage) extension to set them with style.

A symfony [ElaoParameterizerBundle](https://github.com/Elao/ElaoParameterizerBundle) also exists to simplify integration in your project.

Installation:
-------------

Add ElaoParameterizer in your composer.json:

```
{
    "require": {
        "elao/elao/parameterizer": "1.0.*"
    }
}
```

Now tell composer to download the library by running the command:

```
$ php composer.phar update elao/parameterizer
```

How to use it:
--------------

Classes are structured in a hierarchical manner, where a single **Parameterizer** contains n **Patterns**, each one containing n **Parameters**.

	Parameterizer
		Pattern
			Parameter
			Parameter
			Parameter
		Pattern
			Parameter
			Parameter

All classes takes a name as argument, and **Parameter** an initial value.

A factory is provided to simplify the parameterizer creation, and each class provides a convenient method to simplify its children creation.

```
$factory = new ParameterizerFactory(new Inflector());

// Create a "foo" named parameterizer
$parameterizer = $factory->create('foo');

$parameterizer
	// Create a "foo" named pattern
	->create('foo')
		// Create a "bar" named parameter with a "baz" value
 		->create('bar', 'baz')
		// Create a "dinosaur" named parameter with a 42 value
 		->create('dinosaur', 42);
```

#### Options

A pattern can takes an array of options.
One of them is "label", which, if not provided, is automatically set as a human readable version of the pattern name, via an inflector.

```
$pattern->setOptions(array('foo' => 'bar'));

// bar
$pattern->getOption('foo');
// 123 (default value, as "bar" options does not exists)
$pattern->getOption('bar', 123);
// Label
$pattern->getOption('label');
```

A parameter can also takes an array of options.
Same rule applies for the label, and some extra options, such as "choices", "min", "max" and "set", are specific for dat.GUI integration.

```
$parameter->setOptions(array('min' => 1, 'max' => 2));

// 1
$parameter->getOption('min');
// null (default value, as "step" options does not exists)
$parameter->getOption('step');
// Label
$parameter->getOption('label');
```

#### Values

At each level, you can get and merge values to communicate and synchronize with the real world.

```
// Gives a pattern indexed array of indexed parameter values array
$parameterizer->getValues();
// Merge
$parameterizer->mergeValues(array('foo' => array('bar' => 'baz')));

// Get indexed parameter values array
$pattern->getValues();
// Merge
$pattern->mergeValues(array('bar' => 'baz'));
// Get foo parameter value
$pattern->getValue('bar');
// Set foo parameter value
$pattern->setValue('bar', 'baz');

// Get value
$parameter->getValue();
// Set value
$parameter->setValue();
```

#### Interface

An **Parameterizable** interface is provided to harmonize your code.

#### dat.GUI twig extension

This extension provides a **elao_parameterizer_dat_gui_render_javascript** method, which render the javascript part of dat.GUI integration. It accepting an array of options, one of them, "gui" being a string of the name of the dat.GUI instance to use.

```
<script src="https://cdnjs.cloudflare.com/ajax/libs/dat-gui/0.5/dat.gui.min.js"></script>
<script>
    var gui = new dat.GUI();
    {{ elao_parameterizer_dat_gui_render_javascript({'gui': 'gui'}) }}
</script>
```
