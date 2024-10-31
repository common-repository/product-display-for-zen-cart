=== Product Display for Zen Cart ===
Contributors: scottcwilson
Donate link: http://donate.thatsoftwareguy.com/
Tags: zencart 
Requires at least: 4.3 
Tested up to: 4.8
Stable tag: 1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Allows you to easily display products from your Zen Cart installation on your WordPress blog using a shortcode.

== Description ==

Product Display for Zen Cart takes a product id, and pulls in the product name, price, image, description and link, and displays it in a post. 

== Installation ==

Note: This is a two-part install; you have to install files on your OpenCart installation and on your WordPress installation.

Install the WordPress part of this mod as usual (using the Install button on the mod page on WordPress.org).  The follow these steps:

1. Get the <a href="http://www.thatsoftwareguy.com/downloads/wppd_zencart.zip">Zen Cart file</a> for this mod, unzip it, and copy the "wppd_zencart/" folder to the top level folder of your cart.  So wppd_zencart will be at the same level as includes and admin.

1. In your WordPress admin, do the following: 
- In Plugins->Installed Plugins, click the "Activate" link under Product Display for Zen Cart.
- In Settings->Product Display for Zen Cart, set your Zen Cart URL.  

To show a specific product on your blog, use the shortcode [zc_product_display] with parameter "id" as a self closing tag.  So showing product 40 would be done as follows: 

[zc_product_display id="40"]


== Frequently Asked Questions ==


== Screenshots ==

1. What the product information in your post will look like. 

== Changelog ==
First version

== Upgrade Notice ==
First version

