<?php

namespace Tests\Unit\Blocks;

use EightshiftLibs\Blocks\BlocksCli;
use Brain\Monkey;
use Brain\Monkey\Functions;
use function Tests\deleteCliOutput;
use function Tests\setupMocks;

/**
 * Mock before tests.
 */
beforeEach(function () {
	Monkey\setUp();
	setupMocks();

	$wpCliMock = \Mockery::mock('alias:WP_CLI');

	$wpCliMock
		->shouldReceive('success')
		->andReturnArg(0);

	$wpCliMock
		->shouldReceive('log')
		->andReturnArg(0);

	$wpCliMock
		->shouldReceive('runcommand')
		->andReturnArg(0);

	$wpCliMock
		->shouldReceive('error')
		->andReturnArg(0);

	$this->blocks = new BlocksCli('boilerplate');
});

/**
 * Cleanup after tests.
 */
afterEach(function () {
	$output = dirname(__FILE__, 3) . '/cliOutput';

	deleteCliOutput($output);

	Monkey\tearDown();
});

test('Blocks CLI command will correctly copy the Blocks class with defaults', function () {
	$blocks = $this->blocks;
	$blocks([], []);

	$outputPath = dirname(__FILE__, 3) . '/cliOutput/src/Blocks/Blocks.php';

	// Check the output dir if the generated method is correctly generated.
	$generatedBlocks = file_get_contents($outputPath);

	$this->assertStringContainsString('class Blocks extends AbstractBlocks', $generatedBlocks);
	$this->assertStringContainsString('@package EightshiftBoilerplate\Blocks', $generatedBlocks);
	$this->assertStringContainsString('namespace EightshiftLibs\Blocks', $generatedBlocks);
	$this->assertStringNotContainsString('footer.php', $generatedBlocks);
	$this->assertFileExists($outputPath);
});

// test('Blocks CLI command will correctly copy the Blocks class with set arguments', function () {
// 	$blocks = $this->blocks;
// 	$blocks([], [
// 		'namespace' => 'CoolTheme',
// 	]);

// 	// Check the output dir if the generated method is correctly generated.
// 	$generatedBlocks = file_get_contents(dirname(__FILE__, 3) . '/cliOutput/src/Blocks/Blocks.php');

// 	$this->assertStringContainsString('namespace CoolTheme\Blocks;', $generatedBlocks);
// });

// test('Blocks CLI documentation is correct', function () {
// 	$blocks = $this->blocks;

// 	$documentation = $blocks->getDoc();

// 	$key = 'shortdesc';

// 	$this->assertIsArray($documentation);
// 	$this->assertArrayHasKey($key, $documentation);
// 	$this->assertArrayNotHasKey('synopsis', $documentation);
// 	$this->assertEquals('Generates Blocks class.', $documentation[$key]);
// });

// test('Blocks CLI will copy block/component from eightshift-frontend-libs correctly', function () {
// 	$blocks = $this->blocks;
// 	$blocks([], []);

// 	// Functions\when("add_action")->justReturn(true);
// 	var_dump(function_exists('\add_action'));


// 	// $result = $blocks->blocksInit([]);

// 	// var_dump($result);


// 	// $this->assertIsArray($documentation);
// 	// $this->assertArrayHasKey($key, $documentation);
// 	// $this->assertArrayNotHasKey('synopsis', $documentation);
// 	// $this->assertEquals('Generates Blocks class.', $documentation[$key]);
// });
