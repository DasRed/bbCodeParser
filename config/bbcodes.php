<?php

return [
	'bbcodes' => [
		['regex' => '#\[br\]#i', 'replacement' => '<br>'],

		['regex' => '#\[b\](.+)\[/b\]#isU', 'replacement' => '<strong>$1</strong>'],
		['regex' => '#\[i\](.+)\[/i\]#isU', 'replacement' => '<em>$1</em>'],
		['regex' => '#\[u\](.+)\[/u\]#isU', 'replacement' => '<u>$1</u>'],

		['regex' => '#\[h1\](.+)\[/h1\]#isU', 'replacement' => '<h1><a href="#$1" name="$1">$1</a></h1>'],
		['regex' => '#\[h2\](.+)\[/h2\]#isU', 'replacement' => '<h2><a href="#$1" name="$1">$1</a></h2>'],
		['regex' => '#\[h3\](.+)\[/h3\]#isU', 'replacement' => '<h3><a href="#$1" name="$1">$1</a></h3>'],
		['regex' => '#\[h4\](.+)\[/h4\]#isU', 'replacement' => '<h4><a href="#$1" name="$1">$1</a></h4>'],
		['regex' => '#\[h5\](.+)\[/h5\]#isU', 'replacement' => '<h5><a href="#$1" name="$1">$1</a></h5>'],
		['regex' => '#\[h6\](.+)\[/h6\]#isU', 'replacement' => '<h6><a href="#$1" name="$1">$1</a></h6>'],

		['regex' => '#\[p\](.+)\[/p\]#isU', 'replacement' => '<p>$1</p>'],

		['regex' => '#\[color=(.+)\](.+)\[/color\]#isU', 'replacement' => '<span style="color:$1">$2</span>'],

		['regex' => '#\[size=([0-9]+)\](.+)\[/size\]#isU', 'replacement' => '<span style="font-size:$1px">$2</span>'],

		['regex' => '#\[img\](.+)\[/img\]#isU', 'replacement' => '<img src="$1">'],
		['regex' => '#\[img=(.+)\]#isU', 'replacement' => '<img src="$1">'],

		['regex' => '#\[email\](.+)\[/email\]#isU', 'replacement' => '<a href="mailto:$1">$1</a>'],
		['regex' => '#\[email=(.+)\](.+)\[/email\]#isU', 'replacement' => '<a href="mailto:$1">$2</a>'],

		['regex' => '#\[url\](.+)\[/url\]#isU', 'replacement' => '<a href="$1">$1</a>'],
		['regex' => '#\[url=(.+)\|onclick\](.+)\[/url\]#isU', 'replacement' => '<a onclick="$1">$2</a>'],
		['regex' => '#\[url=(.+)\starget=(.+)\](.+)\[/url\]#isU', 'replacement' => '<a href="$1" target="$2">$3</a>'],
		['regex' => '#\[url=(.+)\](.+)\[/url\]#isU', 'replacement' => '<a href="$1">$2</a>'],

		['regex' => '#\[a=(.+)\](.+)\[/a\]#isU', 'replacement' => '<a href="#$1" name="$1">$2</a>'],

		['regex' => '#\[list\](.+)\[/list\]#isU', 'replacement' => '<ul>$1</ul>'],

		['regex' => '#\[\*\](.+)\[/\*\]#isU', 'replacement' => '<li>$1</li>']
	]
];