# General
This is a simple BBCode parser. 

# Installation
```bash
composer install dasred/bb-code-parser
```

# Usage
## Default
```php
$parser = new \DasRed\Parser\BBCode();
echo $parser->parse('[b]10.00[/b] seconds'); //  echos "<strong>10.00</strong> seconds
```

**following default BBCodes are supported**
```text
BBCode                                               | HTML
---------------------------------------------------- | -------------------------------------------------------------
[br]                                                 | <br>
[b]text[/b]                                          | <strong>text</strong>
[b class="fancy"]text[/b]                            | <strong class="fancy">text</strong>
[b data-value="10"]text[/b]                          | <strong data-value="10">text</strong>
[i]text[/i]                                          | <em>text</em>
[i class="fancy"]text[/i]                            | <em class="fancy">text</em>
[i data-value="10"]text[/i]                          | <em data-value="10">text</em>
[u]text[/u]                                          | <u>text</u>
[u class="fancy"]text[/u]                            | <u class="fancy">text</u>
[u data-value="10"]text[/u]                          | <u data-value="10">text</u>
[h1]text[/h1]                                        | <h1>text</h1>
[h1 class="fancy"]text[/h1]                          | <h1 class="fancy">text</h1>
[h1 data-value="10"]text[/h1]                        | <h1 data-value="10">text</h1>
[h2]text[/h2]                                        | <h2>text</h2>
[h2 class="fancy"]text[/h2]                          | <h2 class="fancy">text</h2>
[h2 data-value="10"]text[/h2]                        | <h2 data-value="10">text</h2>
[h3]text[/h3]                                        | <h3>text</h3>
[h3 class="fancy"]text[/h3]                          | <h3 class="fancy">text</h3>
[h3 data-value="10"]text[/h3]                        | <h3 data-value="10">text</h3>
[h4]text[/h4]                                        | <h4>text</h4>
[h4 class="fancy"]text[/h4]                          | <h4 class="fancy">text</h4>
[h4 data-value="10"]text[/h4]                        | <h4 data-value="10">text</h4>
[h5]text[/h5]                                        | <h5>text</h5>
[h5 class="fancy"]text[/h5]                          | <h5 class="fancy">text</h5>
[h5 data-value="10"]text[/h5]                        | <h5 data-value="10">text</h5>
[h6]text[/h6]                                        | <h6>text</h6>
[h6 class="fancy"]text[/h6]                          | <h6 class="fancy">text</h6>
[h6 data-value="10"]text[/h6]                        | <h6 data-value="10">text</h6>
[p]text[/p]                                          | <p>text</p>
[p class="fancy"]text[/p]                            | <p class="fancy">text</p>
[p data-value="10"]text[/p]                          | <p data-value="10">text</p>
[color=#FF0000]text[/color]                          | <span style="color:#FF0000">text</span>
[size=9]text[/size]                                  | <span style="font-size:9px">text</span>
[img]https://www.example.com/image.jpg[/img]         | <img src="https://www.example.com/image.jpg">
[img=https://www.example.com/image.jpg]              | <img src="https://www.example.com/image.jpg">
[email]info@example.com[/email]                      | <a href="mailto:info@example.com">info@example.com</a>
[email=info@example.com]text[/email]                 | <a href="mailto:info@example.com">text</a>
[url]https://www.example.com[/url]                   | <a href="https://www.example.com">https://www.example.com</a>
[url=alert('hello world')|onclick]text[/url]         | <a onclick="alert('hello world')">text</a>
[url=https://www.example.com target=_base]text[/url] | <a href="https://www.example.com" target="_base">text</a>
[url=https://www.example.com]text[/url]              | <a href="https://www.example.com">text</a>
[a=anker]text[/a]                                    | <a href="#anker" name="anker">text</a>
[list]text[/list]                                    | <ul>text</ul> 
[*]text[/*]                                          | <li>text</li>
```

## Own BBCodes
You can provide your own BBCodes.

You must create a config file with following structure. For example the file could be located at /var/www/bbcode.config.php
```php
<?php

return [
	'bbcodes' => [
		['regex' => '#\[br\]#i', 'replacement' => '<br />'],
        ['regex' => '#\[b(.*)\](.+)\[/b\]#isU', 'replacement' => '<b>$2</b>'],
    ]
];
```

```php
$parser = new \DasRed\Parser\BBCode('/var/www/bbcode.config.php');
echo $parser->parse('[b]10.00[/b] seconds'); //  echos "<b>10.00</b> seconds
```
