<?php 
/*
This file includes the 'why' behind the AAC-SCORING plugin as well as
any options when they appear.

As an aside, this little bit of PHP was added to satisfy the
PHP 7.0 Compatibility Checker */ ?> 
<div class="wrap"> <div
class="aac-scoring-right" style="float: right; width: 350px;"> <h2>Why
AAC Scoring?</h2>

<p>I found that my site was performing poorly in to all the scanners I had access, such as GTMetrix, WooRank, SemRush, Pagespeed, Yslow, etc. With a few changes, I was able to improve my scores which also improved the performance of the site. The biggest change was moving to the Twenty Fourteen, and other themes, but it had some pretty serious issues.</p>

<ul style="list-style-type: disc; list-style-position: inside;">
<li>Used fonts the theme never used (such as Lato, Open Sans)</li>
<li>Loaded Genericons which was fairly heavy weight, so I replaced it with Font Awesome if that fone was already in used</li>
<li>Did not embed the Theme (specifically Twenty Fourteen) Styles above the fold</li>
<li>Did not allow for embedding specific other styles above the fold</li>
<li>Has major H1 collisions</li>
</ul>

<p>The goal was to alleviate all these problems so that my site performed better and scored better within all the scanners used. To get my scores, I did have to use other plugins as well.</p>

<p>What I did is documented at the following locations:</p>
<ul style="list-style-type: disc; list-style-position: inside;">
<li><a href="http://www.astroarch.com/2015/11/pagespeed-twenty-fourteen-theme/">http://www.astroarch.com/2015/11/pagespeed-twenty-fourteen-theme/</a></li>
<li><a href="http://www.astroarch.com/2015/09/removing-genericons-twenty-fourteen-theme/">http://www.astroarch.com/2015/09/removing-genericons-twenty-fourteen-theme/</a>
</ul>
<p>The first link goes through why I used additional plugins, where to get them and how to set them up. The second link is purely about why Genericons had to go (security reasons).</p>

<p>As I find more to do, I will be keeping those URLs up to date.</p>

</div>
<div class="aac-scoring-left">
<p>This plugin currently does the following:</p>
<ul style="list-style-type: disc; list-style-position: inside;">
<li>removes excessive fonts: Lato (from google), Open Sans (from google), Genericons. Genericons is replaced with Font Awesome if available using the FontAwesomeFour or Icon Fonts plugins. FontAwesomeFour overrides Icon Fonts.</li>
<li>Embeds styles Above-the-fold for the Twentyfourteen Styles, and the plugins: WP Bootstrap Tabs, Tabby Responsive Tabs, Simple Custom CSS, Fourteen Colors, Responsive Lightbox, and WP-Columna, Fancier Author Box</li>
<li>Removes H1 collisions in sidebars (Unfortuantely, a sub theme is required to remove all H1 collisions)</li>
<li>Works with Speed Booster Pack, Fast Velocity Minify, BWP-Minify, Defer CSS Addon for BWP Minify, W3 Total Cache, etc. Most minify plugins.</li>
<li>If using W3 Total Cache, will disable the W3TC Comment in the footer</li>
<li>Remove the JSON and oEmbed API links</li>
<li>Remove the Pingback URL</li>
</ul>

<h2>AAC Scoring Options</h2>
At the moment there are no options, but we are planning to add the following:
<ul style="list-style-type: disc; list-style-position: inside;">
<li>Specify the styles to place above-the-fold</li>
<li>Specify the font set to use instead of Font Awesome</li>
</ul>

<h2>Special Considerations</h2>
<p>Some plugins like tabby responsive tabs also require you to NOT defer the JS. It is already in the footer, but deferal breaks the tabs.</p>

<h2>Sub Theme Support</h2>
<p>Subtheme support does exist, but please be aware that you will probably want to ignore the parent themes styles as it is pulled in directly by this plugin. You can do this using BWP-Minify and other plugins otherwise when using deferred CSS you will cause unnecessary reflows and duplicated data. If you are using the Child Themes plugin, this is handled for you.</p>

In the meantime use the <a href="https://wordpress.org/support/plugin/aac-scoring">support forum</a> to request more styles to add above-the-fold.

<h2>Suggested Other Plugins</h2>
<ul style="list-style-type: disc; list-style-position: inside;">
<li><a href="http://wordpress.org/plugins/wp-smushit/">WP Smush</a></li>
<li><a href="http://wordpress.org/plugins/fast-velocy-minify/">Fast Velocity Minify</a></li>
<li><a href="http://wordpress.org/plugins/wp-declutter/">Declutter Wordpress</a></li>
</ul>

</div>
</div>
