<?php

return [
	'bbcodes' => [
		['regex' => '#\[br\]#i', 'replacement' => '<br>'],

		['regex' => '#\[b\](.+)\[/b\]#isU', 'nuff' => '<strong>$1</strong>'],
		['regex' => '#\[i\](.+)\[/i\]#isU', 'replacement' => '<em>$1</em>']
	]
];