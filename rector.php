<?php

declare(strict_types=1);

use Rector\Core\Configuration\Option;
use Rector\Core\ValueObject\PhpVersion;
use Rector\DeadDocBlock\Rector\ClassMethod\RemoveUselessReturnTagRector;
use Rector\DeadDocBlock\Rector\Property\RemoveUselessVarTagRector;
use Rector\Set\ValueObject\SetList;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
	// get parameters
	$parameters = $containerConfigurator->parameters();

	// paths to refactor; solid alternative to CLI arguments
	$parameters->set(Option::PATHS, [__DIR__ . '/src', __DIR__ . '/tests']);

	$parameters->set(
		Option::AUTOLOAD_PATHS,
		[
			__DIR__ . '/vendor/squizlabs/php_codesniffer/autoload.php',
			__DIR__ . '/vendor/php-stubs/wordpress-stubs/wordpress-stubs.php',
		]
	);

	$parameters->set(Option::PHP_VERSION_FEATURES, PhpVersion::PHP_73);

	// auto import fully qualified class names? [default: false]
	$parameters->set(Option::AUTO_IMPORT_NAMES, true);

	// skip root namespace classes, like \DateTime or \Exception [default: true]
	$parameters->set(Option::IMPORT_SHORT_CLASSES, false);

	// Run Rector only on changed files
	$parameters->set(Option::ENABLE_CACHE, true);

	// Path to phpstan with extensions, that PHPSTan in Rector uses to determine types
	$parameters->set(Option::PHPSTAN_FOR_RECTOR_PATH, getcwd() . '/phpstan.neon.dist');

	// Define what rule sets will be applied
	$parameters->set(
		Option::SETS,
		[
			SetList::DEAD_CODE,
			SetList::PHP_73
		]
	);

	// register single rule
    $services = $containerConfigurator->services();
    $services->set(RemoveUselessReturnTagRector::class);
    $services->set(RemoveUselessVarTagRector::class);
};
