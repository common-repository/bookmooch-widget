=== BookMooch Widget ===
Contributors: montanamax
Donate link: 
Tags: bookmooch, widget
Requires at least: 2.8
Tested up to: 2.8
Stable tag: trunk

This plugin makes it easy to integrate widgets from [http://BookMooch.com](http://BookMooch.com) into your blog without using any code.

== Description ==

The BookMooch Widget simplifies adding [http://BookMooch.com](http://BookMooch.com) widgets to Wordpress websites and blogs. These widgets can display books you are giving away for free, books you have recently recieved for free, or books you have in your wishlist to find. This widget takes advantage of the new multi-instance widget API of Wordpress version 2.8, and is not compatible with to earlier versions of Wordpress. A live demonstration of this plugin is at [http://montanamax.net/montanamax/plugins](http://montanamax.net/montanamax/plugins)

For support, please contact me at the plugin website [http://montanamax.net/montanamax/plugins](http://montanamax.net/montanamax/plugins)

== Installation ==

The easy way: Go to the Add New Plugins page in your Wordpress admin panel and search for 'bookmooch'. Then click two more times to install and activate the plugin. Finally, go to the Widget admin panel and drag the BookMooch Widget to the sidebar where you want it to appear.

The more complicated way:

1. Upload `bookmooch-widget.php` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Add the BookMooch widget to your sidebar using the widget admin screen.

== Frequently Asked Questions ==

= Why do some of the books in my listing show the covers and some show up as text links? =

If the cover image file can't be loaded or a cover can't be found, a text link will display instead.

= Why did I suddently get the whole BookMooch home page inserted into my sidebar? =

That's because an error was thrown when calling the BookMooch widget. The most likely problem is that the text in the username field doesn't exactly match the BookMooch username. I'll be working on better error handling for this in the next release.

= Why did my blog lockup after loading everything up to the BookMooch sidebar widget? =

I just noticed this problem tonight - but it's not the WP blog server having a problem. Unforutately BookMooch.com is currently down, so the users browser is locking up trying to retrieve the widget information. Fixing this is going to be my top priority for the widget so that if BookMooch.com is offline, the operation of the WP blog will be normal.

== Screenshots ==

1. BookMooch Widget Control Screen
1. BookMooch Widget with Horizontal Covers
1. BookMooch Widget with Vertical Listings

== Changelog ==

= 0.2 =
* Initial public release through Wordpress Plugins
* All basic widget options from BookMooch are configurable in the widget.

= 0.1 =
* Private version released on plugin website only


== Feature Roadmap ==

Future features

- Better input error trapping
- More graceful handling of books without image covers
- Custom CSS styling of display listings and covers returned from BookMooch
- Internationalization
- Cache function to protect WP blog performance when BookMooch.com is unavailable

