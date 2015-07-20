<?php

return [
	'bbcodes' => [
		['regex' => '#\[br\]#i', 'replacement' => '<br>'],

		'nuff',
		['regex' => '#\[i\](.+)\[/i\]#isU', 'replacement' => '<em>$1</em>']
	]
];