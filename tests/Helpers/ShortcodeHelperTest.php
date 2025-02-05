<?php

namespace Tests\Helpers;

use EightshiftLibs\Helpers\Shortcode;

beforeEach(function () {
	global $shortcode_tags;
	$shortcode_tags = ['sayHello' => 'Tests\\Helpers\\sayHello'];

	$this->shortcode = new Shortcode();
});


test('Shortcode helper will call the shortcode callback', function() {
	function sayHello(array $args): void {
		echo "Hello {$args['name']}!";
	}
	
	ob_start();
	$this->shortcode->getShortcode('sayHello', ['name' => 'John']);
	$result = ob_get_clean();

	$this->assertEquals('Hello John!', $result);
});


test('Shortcode helper will return false in case the callback doesn\'t exist', function() {
	$this->assertFalse($this->shortcode->getShortcode('random', ['name' => 'John']));
});
