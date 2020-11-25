<?php

/**
 * The login page specific functionality.
 *
 * @package EightshiftLibs\Login
 */

declare(strict_types=1);

namespace EightshiftLibs\Login;

use EightshiftLibs\Services\ServiceInterface;

/**
 * Class Login
 *
 * This class handles all login page options.
 */
abstract class AbstractLogin implements ServiceInterface
{

	/**
	 * Change default logo link with home url.
	 *
	 * @param string $loginHeaderUrl Login header logo URL.
	 *
	 * @return string Modified login header logo URL.
	 */
	public function customLoginUrl(string $loginHeaderUrl): string
	{
		return \home_url('/');
	}
}
