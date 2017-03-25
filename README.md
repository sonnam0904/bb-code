[![Latest Version](https://img.shields.io/github/release/sonnn/bbcode.svg?style=flat-square)](https://github.com/sonnn/bbcode/v1.0)
[![Total Downloads](https://img.shields.io/packagist/dt/sonnn/bbcode.svg?style=flat-square)](https://packagist.org/packages/sonnn/bbcode)

The ``Sonnn\BBCode`` package will help you with parsing BBCode.

## Install

Via Composer

``` bash
$ composer require sonnn/bbcode
```

## Usage
To parse some text it's as easy as this!
``` php
$bbcode = new Sonnn\BBCode\BBCodeParser;

echo $bbcode->parse('[b]Bold Text![/b]');
// <strong>Bold Text!</strong>
```
Would like the parser to not use all bbcodes? Just do like this.
``` php
$bbcode = new Sonnn\BBCode\BBCodeParser;

echo $bbcode->only('bold', 'italic')
            ->parse('[b][u]Bold[/u] [i]Italic[/i]![/b]');
            // <strong>[u]Bold[/u] <em>Italic</em>!</strong>

echo $bbcode->except('bold')
            ->parse('[b]Bold[/b] [i]Italic[/i]');
            // [b]Bold[/b] <em>Italic</em>
```

By default the parser is case sensitive. But if you would like the parser to accept tags like `` [B]Bold Text[/B] `` it's really easy.
``` php
$bbcode = new Sonnn\BBCode\BBCodeParser;

// Case insensitive
echo $bbcode->parse('[b]Bold[/b] [I]Italic![/I]', true);
     // <strong>Bold</strong> <em>Italic!</em>

// Or like this

echo $bbcode->parseCaseInsensitive('[b]Bold[/b] [i]Italic[/i]');
     // <strong>Bold</strong> <em>Italic!</em>
```
You could also make it more explicit that the parser is case sensitive by using another helper function.
``` php
    $bbcode = new Sonnn\BBCode\BBCodeParser;

    echo $bbcode->parseCaseSensitive('[b]Bold[/b] [I]Italic![/I]');
         // <strong>Bold</strong> [I]Italic![/I]
```

If you would like to completely remove all BBCode it's just one function call away.
``` php
    $bbcode = new Sonnn\BBCode\BBCodeParser;

    echo $bbcode->stripBBCodeTags('[b]Bold[/b] [i]Italic![/i]');
         // Bold Italic!
```

## Laravel integration
The integration into Laravel is really easy, and the method is the same for both Laravel 4 and Laravel 5.
Just open your ``app.php`` config file.

In there you just add this to your providers array
``` php
'Sonnn\BBCode\BBCodeParserServiceProvider'
```

And this to your facades array
``` php
'BBCode' => 'Sonnn\BBCode\Facades\BBCodeParser'
```

The syntax is the same as if you would use it in vanilla PHP but with the ``BBCode::`` before the methods.
Here are some examples.
``` php
// Simple parsing
echo BBCode::parse('[b]Bold Text![/b]');

// Limiting the parsers with the only method
echo BBCode::only('bold', 'italic')
        ->parse('[b][u]Bold[/u] [i]Italic[/i]![/b]');
        // <strong>[u]Bold[/u] <em>Italic</em>!</strong>

// Or the except method
echo BBCode::except('bold')
        ->parse('[b]Bold[/b] [i]Italic[/i]');
        // [b]Bold[/b] <em>Italic</em>
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.
