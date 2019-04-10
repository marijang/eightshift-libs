<?php
/**
 * File that holds the registrable interface.
 *
 * @since   1.0.0
 * @package Eightshift_Libs\Core
 */

namespace Eightshift_Libs\Core;

/**
 * Interface Registrable.
 *
 * An object that can be registered.
 */
interface Registrable {

  /**
   * Register the current registrable.
   *
   * A register method holds the plugin action and filter hooks.
   * Following the single responsibility principle, every class
   * holds a functionality for a certain part of the plugin.
   * This is why every class should hold its own hooks.
   *
   * @return void
   *
   * @since 1.0.0
   */
  public function register() : void;
}
