=== Shortcode Callback ===
Contributors: digitalpoint
Tags: shortcode, short code, bbcode, callback, php, inject, code, execute, digitalpoint
Donate link: https://marketplace.digitalpoint.com/shortcode-callback.3383/item#utm_source=readme&utm_medium=wordpress&utm_campaign=plugin
Requires at least: 2.5
Tested up to: 4.3.0
Stable tag: 1.0.0
License: GPLv2
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Adds a [callback] shortcode that can trigger PHP code so you can insert custom/complex things into your pages/posts.

== Description ==
The Shortcode Callback plugin allows you to use a [callback] shortcode to execute arbitrary PHP code wherever the shortcode is used.

<strong>Usage</strong>

Execute someFunction() and insert whatever it returns with the following shortcode:
`[callback function="someFunction"]`

Example shortcode to include a PHP file (the path is relative to WordPress' ABSPATH), then insert the results of someFunction() where you used the shortcode:
`[callback include="custom/filetoinclude.php" function="someFunction"]`

Shortcode example that includes a PHP file (the path is relative to WordPress' ABSPATH), then passes a paramter to someFunction() and returns the results where you used the shortcode:
`[callback function="someFunction" include="custom/filetoinclude.php" param="something"]`

The format to call a class/method with the shortcode is exactly the same as above, except you specify the class::method in the "function" attribute of the shortcode.
`[callback function="someClass::someFunction" include="custom/filetoinclude.php" param="something"]`

There is an example (with PHP code) [over here](https://wordpress.org/plugins/shortcode-callback/faq/).

== Installation ==
1. Upload `shortcode-callback` folder to the `/wp-content/plugins/` directory.
1. Activate the Shortcode Callback plugin through the 'Plugins' menu in the WordPress admin area.

== Frequently Asked Questions ==
= Do you have an example of where the Shortcode Callback plugin is used? =
I built this plugin primarily because I needed a way to inject the "Daily Yield" and "Total Yield" numbers to [my solar power chart page](https://shawnhogan.com/solar-power-chart#utm_source=readme&utm_medium=wordpress&utm_campaign=plugin).

= The shortcode being used: =
`[callback function="DigitalPointElectricity::total_output" param="daily" include="custom/Electricity.php"]`

= The `custom/DigitalPointElectricity.php` file being called by the shortcode: =
`<?php

class DigitalPointElectricity
{
    public static function total_output($timeframe)
    {
        $totals = $GLOBALS['memcache']->get('shawnhogan-pv-total');

        if ($timeframe == 'total')
        {
            return $totals->Items[2]->TotalYield;
        }
        elseif ($timeframe == 'daily')
        {
            return $totals->Items[1]->DailyYield;
        }
    }
}`

== Changelog ==
= 1.0.0 =
* Initial release