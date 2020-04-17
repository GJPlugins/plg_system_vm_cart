<?php
/**
 * @package    e-lektra.com.ua
 *
 * @author     oleg <your@email.com>
 * @copyright  A copyright
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 * @link       http://your.url.com
 */

defined('_JEXEC') or die;

/**
 * Plg_system_vm_cart script file.
 *
 * @package   e-lektra.com.ua
 * @since     1.0.0
 */
class plgSystemPlg_system_vm_cartInstallerScript
{
	/**
	 * Constructor
	 *
	 * @param    JAdapterInstance $adapter  The object responsible for running this script
	 * @since 3.9
	 */
	public function __construct( $adapter) {}
	
	/**
	 * Called before any type of action
	 *
	 * @param string           $route   Which action is happening (install|uninstall|discover_install|update)
	 * @param JAdapterInstance $adapter The object responsible for running this script
	 *
	 * @return void True on success
	 * @since 3.9
	 */
	public function preflight($route,  $adapter) {}
	
	/**
	 * Called after any type of action
	 *
	 * @param string           $route   Which action is happening (install|uninstall|discover_install|update)
	 * @param JAdapterInstance $adapter The object responsible for running this script
	 *
	 * @return void True on success
	 * @since 3.9
	 */
	public function postflight($route,  $adapter) {}

	/**
	 * Called on installation
	 *
	 * @param   JAdapterInstance $adapter  The object responsible for running this script
	 *
	 * @return  boolean  True on success
	 * @since 3.9
	 */
	public function install( $adapter) {}
	
	/**
	 * Called on update
	 *
	 * @param JAdapterInstance $adapter The object responsible for running this script
	 *
	 * @return void True on success
	 * @since 3.9
	 */
	public function update( $adapter) {}
	
	/**
	 * Called on uninstallation
	 *
	 * @param    JAdapterInstance $adapter  The object responsible for running this script
	 * @since 3.9
	 */
	public function uninstall( $adapter) {}
}
