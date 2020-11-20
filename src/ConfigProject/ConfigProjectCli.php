<?php

/**
 * Class that registers WPCLI command for Config Project.
 *
 * @package EightshiftLibs\Config
 */

declare(strict_types=1);

namespace EightshiftLibs\ConfigProject;

use EightshiftLibs\Cli\AbstractCli;
use WP_CLI\ExitException;

/**
 * Class ConfigProjectCli
 */
class ConfigProjectCli extends AbstractCli
{

	/**
	 * Output dir relative path.
	 */
	public const OUTPUT_DIR = '../../../';

	/**
	 * Get WPCLI command name
	 *
	 * @return string
	 */
	public function getCommandName(): string
	{
		return 'init_config_project';
	}

	/**
	 * Define default develop props.
	 *
	 * @param array $args WPCLI eval-file arguments.
	 *
	 * @return array
	 */
	public function getDevelopArgs(array $args): array
	{
		return [
			'env' => $args[1] ?? 'EB_TEST_ENV',
			'root' => $args[2] ?? './',
		];
	}

	/**
	 * Get WPCLI command doc.
	 *
	 * @return array
	 */
	public function getDoc(): array
	{
		return [
			'shortdesc' => 'Generates projects config file to control global variables used in WordPress project.',
			'synopsis' => [
				[
					'type' => 'assoc',
					'name' => 'env',
					'description' => 'Define project env variable name.',
					'optional' => false,
				],
				[
					'type' => 'assoc',
					'name' => 'root',
					'description' => 'Define project root relative to initialization file of WP CLI.',
					'optional' => true,
				],
			],
		];
	}

	public function __invoke(array $args, array $assocArgs) // phpcs:ignore
	{
		// Get Props.
		$env = $assocArgs['env'] ?? '';
		$root = $assocArgs['root'] ?? static::OUTPUT_DIR;

		// Read the template contents, and replace the placeholders with provided variables.
		try {
			$class = $this->getExampleTemplate(__DIR__, $this->getClassShortName());
		} catch (ExitException $e) {
			exit("{$e->getCode()}: {$e->getMessage()}");
		}

		// Replace stuff in file.
		try {
			$class = $this->renameTextDomain($assocArgs, $class);
		} catch (ExitException $e) {
			exit("{$e->getCode()}: {$e->getMessage()}");
		}

		if (!empty($env)) {
			$class = str_replace('EB_ENV', $env, $class);
		}

		// Output final class to new file/folder and finish.
		try {
			$this->outputWrite($root, 'wp-config-project.php', $class, $assocArgs);
		} catch (ExitException $e) {
			exit("{$e->getCode()}: {$e->getMessage()}");
		}

		\WP_CLI::success("Please do the following steps manually to complete the setup:");
		\WP_CLI::success("1. In wp-config.php - Make sure to define your env const {$env} to 'develop' like so: <?php define( '{$env}', 'develop' ); ?>`");
		\WP_CLI::success("2. In wp-config.php - Make sure to require wp-config-project.php (at the end of the file) but before the wp-settings.php. Like this:`);");
		\WP_CLI::success("
		/** Absolute path to the WordPress directory. */
		if ( !defined('ABSPATH') ) {
			define('ABSPATH', dirname(__FILE__) . '/');
		}
		
		// Include wp config for your project.
		 require_once(ABSPATH . 'wp-config-project.php');
		
		/** Sets up WordPress vars and included files. */
		require_once(ABSPATH . 'wp-settings.php');
		");
	}
}
