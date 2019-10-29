<?php
/**
 * File containing Request type interface
 *
 * @package Eightshift_Libs\Routes
 */

declare( strict_types=1 );

namespace Eightshift_Libs\Routes;

use Eightshift_Libs\Core\Service;

/**
 * Route interface that adds routes
 *
 * @since 0.1.0
 */
interface Route extends Service {

  /**
   * Alias for GET transport method.
   *
   * @var string
   *
   * @since 0.1.0
   */
  const READABLE = 'GET';

  /**
   * Alias for POST transport method.
   *
   * @var string
   *
   * @since 0.1.0
   */
  const CREATABLE = 'POST';

    /**
   * Alias for PATCH transport method.
   *
   * @var string
   *
   * @since 0.1.0
   */
  const EDITABLE = 'PATCH';

  /**
   * Alias for PUT transport method.
   *
   * @var string
   *
   * @since 0.1.0
   */
  const UPDATEABLE = 'PUT';

  /**
   * Alias for DELETE transport method.
   *
   * @var string
   *
   * @since 0.1.0
   */
  const DELETABLE = 'DELETE';
}
