=== WP jPlayer ===
Contributors: n33rav
Tags: video, jplayer, m4v
Donate Link: http://www.techna2.com/blog
Requires at least: 2.7
Tested up to: 3.5.1
Stable tag: 0.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

WP jPlayer provides easy way to embed videos in jPlayer, cross platform video into your web pages.

== Description ==

WP jPlayer provides easy way to embed videos in jPlayer, cross platform video into your web pages.

This version is just a start and does not have any configuration options available. Suggest features you want via WordPress forum and I'll try to include them.

Use following shortcode in your post/page content,
    **[wpjplayer src="your video src url" title="your video title" poster="your video poster url" size="360p"]**

* src: video url, format must be m4v (required)
* title: title of video (optional)
* poster: video poster url (optional)
* size: resolution of video (optional) Either 270p(default) or 360p.

== Installation ==

1. Upload to the "wp-jplayer" directory to `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Add shortcode in your post/page or widget text box

== Frequently Asked Questions ==

= Why only m4v format is supported? =

Becasue its supported by both html5 and flash player and it works on most browsers and devices.

== Changelog ==
= 0.2 =
* Update jPlayer.js version for vulnerability fixes
* Introduce size parameter: 270p or 360p
* Make shortcode work in sidebar text widget

= 0.1 =
* Initial version.