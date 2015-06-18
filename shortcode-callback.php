<?php

/**
 * @package Shortcode Callback
 */
/*
Plugin Name: Shortcode Callback
Plugin URI: https://marketplace.digitalpoint.com/shortcode-callback.3383/item
Description: Adds a [callback] shortcode that allows you to execute an arbitrary PHP function or method within your post.
Version: 1.0.0
Author: Digital Point
Author URI: https://www.digitalpoint.com/
License: GPLv2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: shortcode-callback
Domain Path: /languages
*/


if (!function_exists('add_action'))
{
	echo 'What the what?';
	exit;
}

define('SHORTCODE_CALLBACK_VERSION', '1.0.0');
define('SHORTCODE_CALLBACK_MINIMUM_WP_VERSION', '2.5');  // add_shortcode(): https://codex.wordpress.org/Function_Reference/add_shortcode
define('SHORTCODE_CALLBACK_PRODUCT_URL', 'https://marketplace.digitalpoint.com/shortcode-callback.3383/item');
define('SHORTCODE_CALLBACK_SUPPORT_URL', 'https://forums.digitalpoint.com/forums/products-tools.14/');

define('SHORTCODE_CALLBACK_PLUGIN_URL', plugin_dir_url(__FILE__));
define('SHORTCODE_CALLBACK_PLUGIN_DIR', plugin_dir_path(__FILE__));

load_plugin_textdomain('shortcode-callback', false, dirname(plugin_basename(__FILE__)) . '/languages');




class DigitalPointShortcodeCallback
{
	protected static $_instance;

	/**
	 * Protected constructor. Use {@link getInstance()} instead.
	 */
	protected function __construct()
	{
	}

	public static final function getInstance()
	{
		if (!self::$_instance)
		{
			$class = __CLASS__;
			self::$_instance = new $class;

			self::$_instance->_initHooks();
		}

		return self::$_instance;
	}


	/**
	 * Initializes WordPress hooks
	 */
	protected function _initHooks()
	{
		add_shortcode('callback', array($this, 'shortcode_callback'));
	}

	public function shortcode_callback($atts)
	{
		$atts = shortcode_atts(
			array(
				'function' => null,
				'include' => null,
				'param' => null
			),
			$atts,
			'callback'
		);
		if ($this->_isCallable($atts['function']))
		{
			return call_user_func($atts['function'], $atts['param']);
		}
		elseif (!empty($atts['include']))
		{
			if (file_exists(ABSPATH . $atts['include']))
			{
				require_once(ABSPATH . $atts['include']);
				if ($this->_isCallable(@$atts['function']))
				{
					return call_user_func($atts['function'], $atts['param']);
				}
				else
				{
					return sprintf(esc_html__('[callback] Function not callable: %s', 'shortcode-callback'), $atts['function']);
				}
			}
			else
			{
				return sprintf(esc_html__('[callback] File not found: %s', 'shortcode-callback'), ABSPATH . $atts['include']);
			}
		}
		else
		{
			return sprintf(esc_html__('[callback] Function not callable: %s', 'shortcode-callback'), $atts['function']);
		}
	}

	protected function _isCallable($function)
	{
		if (strpos($function, '::'))
		{
			$split = explode('::', $function);

			if (class_exists($split[0]))
			{
				$class = new $split[0];
				return is_callable(array($class, $split[1]));
			}
		}
		else
		{
			return is_callable($function);
		}
	}
}

DigitalPointShortcodeCallback::getInstance();