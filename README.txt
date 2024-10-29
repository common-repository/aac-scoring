=== AAC Scoring ===
Contributors: Edward L Haletky
Donate link:
Tags: theme, pagespeed, yslow, gtmetrix, above-the-fold
Requires at least: 3.x
Tested up to: 4.7.2
Stable tag: 2.3.6.1
License: GPLv2

Improves Pagespeed/GTMetrix/SEMrush/Yslow scores for Twenty Fourteen and other themes by reducing round trips, moving core CSS above the fold.

== Description ==

Improves Pagespeed/GTMetrix/SEMrush/Yslow scores for Twenty Fourteen and other themes by reducing round trips, moving core CSS above the fold. For best results, you should also employ the following to get the best score:

	Fast Velocity Minify
	Smush IT
	Declutter Wordpress

= Features =
        - removes excessive fonts:
                Lato (from google)
                Open Sans (from google - part of WP Embed load)
			For Emphasize theme
                Genericons (replace with Font Awesome if in use)
	- removes excessive json+ld entries
        - Embedding Styles Above-the-fold:
		Child Theme Configurator (child theme styles)
                Twentyfourteen Styles (and main theme styles for other themes)
		Icon-Fonts when Font Awesome in use
		Font Awesome Four Menus (overrides Icon-Fonts font-awesome)
		Fourteen Colors
                WP Bootstrap Tabs
		Tabby Responsive Tab
                Simple Custom CSS
		WP-Columna
		Responsive Lightbox Fancybox
		Fancier Author Box
	- removes H1 collisions
	- removed W3 Total Cache comments at end of post
		W3 Total Cache adds a comment with whitespace that takes 
		lots of processing
	- removed Child Theme Configurator's parent theme
		older setup, new setup not yet.

== Installation ==

There's 3 ways to install this plugin:

= 1. The easy way =
1. Download the plugin (.zip file)
2. In your Admin, go to menu Plugins > Add
3. Select the tab "Upload"
4. Upload the .zip file you just downloaded
5. Activate the plugin

= 2. The old way (FTP) =
1. Upload `aac-scoring` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress

== Usage ==

Works best with BWP-Minify and Defer CSS AddOn for BWP Minify already installed, however, this is a plugin with no settings. It just works.

== Screenshots ==

There are none as there is no configuration.

== Frequently Asked Questions ==

1. Does it place CSS above the fold automatically?

No. The plugin loads specific CSS above the fold from the Twenty Fourteen and other themes as well as the WP Bootstrap Tabs, Simple Custom CSS, WP-Columna plugins. To add more please contact the author. Eventually, there will be a way to input other ones. However, too much CSS above the fold is also a problem.

2. Does the plugin automatically defer CSS or JS?

No. For CSS you need BWP Minify with the Defer CSS AddOn and for JS W3 Total Cache works great.

3. I am using Youtube/Vimeo but GTMetrix/Pagespeed/Yslow shows Youtube/Vimeo links?

Use the a3 Lazy Load or Speed Booster Pack plugins to lazy load Youtube and Vimeo players.

4. Google Links still show up in GTMetrix/Pagespeed/Yslow?

Unfortunately, if you are using Google Analytics as well as other Google integrations, the scripts are loaded with low cache values which cause issues to show up. I limit google integrations to just Analytics these days to limit the number of JS files loaded from elsewhere.

== Upgrade Notice ==

Please use the contact form in case of any issues while upgrading or using this plugin

== Change Log ==
2.3.6.1 Updated README.txt

2.3.6 Fixed protection around Tabby Responsive Tabs so error does not appear when it is not enabled as a plugin. Tested to 4.7.2

2.3.5 Update to Settings page, moved text around, including all things plugin does.

2.3.0 Fixed Tabby Responsive Tabs issue where tabby.css was not always included properly to be picked up by aac-scoring. Usually ended up with an empty CSS include above the fold.

2.2.0 Updated to support Tabby Responsive Tabs and removed excessive json+ld entries

2.1.0 Updated to ensure FontAwesome-Four Menus code if available is the FontAwesome to use over Icon-Fonts as it is newer. Added support for Emphasize theme to remove open-sans font

2.0.0 Rewrote main enqueue/dequeue code to work with all themes not just Twenty Fourteen as well as added support for Child Themes Configurator plugin and some level of dependencies.

1.8.3 Updated for WP 4.5, no other changes

1.8.2 Fixed bug in Fancier Author Box CSS include

1.8.1 Added support for Fancier Author Box

1.8 Fixed bug on IE ifdef
    Included Responsive Lightbox Fancybox support

1.7 Fixed a bug in Open Sans removal
    Added W3 Total Cache filter for comment removal at end of page. This comment not only takes processing time, but adds whitespace to the end of your page.

1.6 Fixed bug in Simple Custom CSS include for above the fold

1.5 Support for moving Fourteen-Colors above the fold and minifying the output

1.4.1 updates to release

1.4 tested against Wordpress 4.4

1.3.1 missing why.php file

1.3 added a Settings Menu to provide where to get information on the why of this plugin as well as a list of other useful plugins and where to get help. No options yet, but more to provide more readily available information.

1.2.1 updated README with FAQ

1.2 added support for WP-Columna

1.1 added aac_scoring_dynamic_sidebar_params to ensure H2 is used instead of H1 for sidebars to avoid SEMrush reported collisions

1.0 initial release including support for icon-fonts and wp-bootstrap-tabs

