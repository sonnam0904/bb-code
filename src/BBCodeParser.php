<?php namespace Sonnn\BBCode;

use \Sonnn\BBCode\Traits\ArrayTrait;

class BBCodeParser
{

    use ArrayTrait;

    public $parsers = [
        'bold' => [
            'pattern' => '/\[B\](.*?)\[\/B\]/s',
            'replace' => '<strong>$1</strong>',
            'content' => '$1'
        ],
        'italic' => [
            'pattern' => '/\[I\](.*?)\[\/I\]/s',
            'replace' => '<em>$1</em>',
            'content' => '$1'
        ],
        'underline' => [
            'pattern' => '/\[U\](.*?)\[\/U\]/s',
            'replace' => '<u>$1</u>',
            'content' => '$1'
        ],
        'linethrough' => [
            'pattern' => '/\[S\](.*?)\[\/S\]/s',
            'replace' => '<strike>$1</strike>',
            'content' => '$1'
        ],
        'size' => [
            'pattern' => '/\[SIZE\=([1-7])\](.*?)\[\/SIZE\]/s',
            'replace' => '<font size="$1">$2</font>',
            'content' => '$2'
        ],
        'color' => [
            'pattern' => '/\[COLOR\=(#[A-f0-9]{6}|#[A-f0-9]{3})\](.*?)\[\/COLOR\]/s',
            'replace' => '<font color="$1">$2</font>',
            'content' => '$2'
        ],
        'center' => [
            'pattern' => '/\[CENTER\](.*?)\[\/CENTER\]/s',
            'replace' => '<div style="text-align:center;">$1</div>',
            'content' => '$1'
        ],
        'left' => [
            'pattern' => '/\[LEFT\](.*?)\[\/LEFT\]/s',
            'replace' => '<div style="text-align:left;">$1</div>',
            'content' => '$1'
        ],
        'right' => [
            'pattern' => '/\[RIGHT\](.*?)\[\/RIGHT\]/s',
            'replace' => '<div style="text-align:right;">$1</div>',
            'content' => '$1'
        ],
        'quote' => [
            'pattern' => '/\[QUOTE\](.*?)\[\/QUOTE\]/s',
            'replace' => '<blockquote>$1</blockquote>',
            'content' => '$1'
        ],
        'namedquote' => [
            'pattern' => '/\[QUOTE\=(.*?)\](.*)\[\/QUOTE\]/s',
            'replace' => '<blockquote><small>$1</small>$2</blockquote>',
            'content' => '$2'
        ],
        'link' => [
            'pattern' => '/\[URL\](.*?)\[\/URL\]/s',
            'replace' => '<a href="$1" rel="nofollow">$1</a>',
            'content' => '$1'
        ],
        'namedlink' => [
            'pattern' => '/\[URL\=\'(.*?)\'](.*?)\[\/URL\]/s',
            'replace' => '<a href="$1" rel="nofollow">$2</a>',
            'content' => '$2'
        ],
        'image' => [
            'pattern' => '/\[IMG\](.*?)\[\/IMG\]/s',
            'replace' => '<div><img class="lazy-image" data-original="$1" src="/images/global/90.gif"></div>',
            'content' => '$1'
        ],
        'orderedlistnumerical' => [
            'pattern' => '/\[LIST=1\](.*?)\[\/LIST\]/s',
            'replace' => '<ol>$1</ol>',
            'content' => '$1'
        ],
        'orderedlistalpha' => [
            'pattern' => '/\[LIST=a\](.*?)\[\/LIST\]/s',
            'replace' => '<ol type="a">$1</ol>',
            'content' => '$1'
        ],
        'unorderedlist' => [
            'pattern' => '/\[LIST\](.*?)\[\/LIST\]/s',
            'replace' => '<ul>$1</ul>',
            'content' => '$1'
        ],
        'listitem' => [
            'pattern' => '/\[\*\](.*)/',
            'replace' => '<li>$1</li>',
            'content' => '$1'
        ],
        'code' => [
            'pattern' => '/\[CODE\](.*?)\[\/CODE\]/s',
            'replace' => '<code>$1</code>',
            'content' => '$1'
        ],
        'youtube' => [
            'pattern' => '/\[YOUTUBE\](.*?)\[\/YOUTUBE\]/s',
            'replace' => '<iframe width="560" height="315" src="//www.youtube.com/embed/$1" frameborder="0" allowfullscreen></iframe>',
            'content' => '$1'
        ],
        'linebreak' => [
            'pattern' => '/\r\n/',
            'replace' => '<br />',
            'content' => ''
        ],
        'sub' => [
          'pattern' => '/\[SUB\](.*?)\[\/SUB\]/s',
          'replace' => '<sub>$1</sub>',
          'content' => '$1'
        ],
        'sup' => [
          'pattern' => '/\[SUP\](.*?)\[\/SUP\]/s',
          'replace' => '<sup>$1</sup>',
          'content' => '$1'
        ],
        'small' => [
          'pattern' => '/\[SMALL\](.*?)\[\/SMALL\]/s',
          'replace' => '<small>$1</small>',
          'content' => '$1'
        ],
        'font' => [
            'pattern' => '/\[FONT\=(.*?)\](.*?)\[\/FONT\]/s',
            'replace' => '<font face="$1">$2</font>',
            'content' => '$2'
        ]
    ];

    private $enabledParsers;

    public function __construct()
    {
        $this->enabledParsers = $this->parsers;
    }

    /**
     * Parses the BBCode string
     * @param  string $source String containing the BBCode
     * @return string Parsed string
     */
    public function parse($source, $caseInsensitive = false)
    {
        foreach ($this->enabledParsers as $name => $parser) {
            $pattern = ($caseInsensitive) ? $parser['pattern'].'i' : $parser['pattern'];

            $source = $this->searchAndReplace($pattern, $parser['replace'], $source);
        }
        return $source;
    }

    /**
     * Remove all BBCode
     * @param  string $source
     * @return string Parsed text
     */
    public function stripBBCodeTags($source)
    {
        foreach ($this->parsers as $name => $parser) {
            $source = $this->searchAndReplace($parser['pattern'].'i', $parser['content'], $source);
        }
        return $source;
    }
    /**
     * Searches after a specified pattern and replaces it with provided structure
     * @param  string $pattern Search pattern
     * @param  string $replace Replacement structure
     * @param  string $source Text to search in
     * @return string Parsed text
     */
    protected function searchAndReplace($pattern, $replace, $source)
    {
        while (preg_match($pattern, $source)) {
            $source = preg_replace($pattern, $replace, $source);
        }

        return $source;
    }

    /**
     * Helper function to parse case sensitive
     * @param  string $source String containing the BBCode
     * @return string Parsed text
     */
    public function parseCaseSensitive($source)
    {
        return $this->parse($source, false);
    }

    /**
     * Helper function to parse case insensitive
     * @param  string $source String containing the BBCode
     * @return string Parsed text
     */
    public function parseCaseInsensitive($source)
    {
        return $this->parse($source, true);
    }

    /**
     * Limits the parsers to only those you specify
     * @param  mixed $only parsers
     * @return object BBCodeParser object
     */
    public function only($only = null)
    {
        $only = (is_array($only)) ? $only : func_get_args();
        $this->enabledParsers = $this->arrayOnly($this->parsers, $only);
        return $this;
    }

    /**
     * Removes the parsers you want to exclude
     * @param  mixed $except parsers
     * @return object BBCodeParser object
     */
    public function except($except = null)
    {
        $except = (is_array($except)) ? $except : func_get_args();
        $this->enabledParsers = $this->arrayExcept($this->parsers, $except);
        return $this;
    }

    /**
     * List of chosen parsers
     * @return array array of parsers
     */
    public function getParsers()
    {
        return $this->enabledParsers;
    }

    /**
     * Sets the parser pattern and replace.
     * This can be used for new parsers or overwriting existing ones.
     * @param string $name Parser name
     * @param string $pattern Pattern
     * @param string $replace Replace pattern
     * @param string $content Parsed text pattern
     * @return void
     */
    public function setParser($name, $pattern, $replace, $content)
    {
        $this->parsers[$name] = array(
            'pattern' => $pattern,
            'replace' => $replace,
            'content' => $content
        );

        $this->enabledParsers[$name] = array(
            'pattern' => $pattern,
            'replace' => $replace,
            'content' => $content
        );
    }
}
