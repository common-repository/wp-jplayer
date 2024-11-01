<?php
/*
Plugin Name: WP jPlayer
Plugin URI: http://www.techna2.com/blog
Description: WP JPlayer provides easy way to embed videos in jPlayer, cross platform video into your web pages.
Author: Neerav Dobaria
Version: 0.2
Author URI: http://www.techna2.com/blog
*/

//avoid direct calls to this file, because now WP core and framework has been used
if (!function_exists('add_action')) {
	header('Status: 403 Forbidden');
	header('HTTP/1.1 403 Forbidden');
	exit();
}

// Define certain terms which may be required throughout the plugin
define('WPJPLAYER_NAME', 'WP JPlayer');
define('WPJPLAYER_PATH', WP_PLUGIN_DIR . '/wp-jplayer');
define('WPJPLAYER_URL', WP_PLUGIN_URL . '/wp-jplayer');
define('WPJPLAYER_BASENAME', plugin_basename(__FILE__));

if (!class_exists('wpjplayer')) {
	class wpjplayer
	{

		static $count = 0;

		function wpjplayer()
		{
			if (is_admin()) {
				// nothing to do here
			} else {
                // inorder for shortcode to work in widget area
                add_filter('widget_text', 'do_shortcode');

                add_action('the_posts', array(&$this, 'has_shortcode'));
				add_shortcode('wpjplayer', array(&$this, 'process_short_code'));
			}
		}

		/**
		 * Loading scripts only if a particular shortcode is present
		 * http://goo.gl/N3Vo8
		 * */
		function has_shortcode($posts)
		{
			if (empty($posts)) {
				return $posts;
			}

			$found = false;

			foreach ($posts as $post) {
				if (stripos($post->post_content, '[wpjplayer')) {
					$found = true;
				}
				break;
			}

			if ($found) {
				wp_enqueue_style( 'wpjplayer_jp_style', WPJPLAYER_URL . '/assets/skin/blue.monday/jplayer.blue.monday.css');
				wp_enqueue_script('wpjplayer_jp_script', WPJPLAYER_URL . '/assets/js/jquery.jplayer.min.js', array('jquery'));
			}
			return $posts;
		}


        /**
         * Process shortcode, generate video player markup and return it
         * */
        function process_short_code($atts)
		{
			//increase video count
			 $this->count += 1;

			if (empty($atts['src'])) {
				return 'SRC parameter is missing.';
			}

            $default = array(
                'src' => '',
                'title' => '',
                'poster' => '',
                'size' => '270p'
            );

            extract(shortcode_atts($default, $atts));

			// parameter for video player
			$count = $this->count;
			$jsurl = WPJPLAYER_URL.'/assets/js';
			
			$player = <<<PLY
			<script type="text/javascript">
				//<![CDATA[
				jQuery(document).ready(function(){
					jQuery("#jquery_jplayer_$count").jPlayer({
						ready: function () {
							jQuery(this).jPlayer("setMedia", {
								m4v: "$src",
								poster: "$poster"
							});
						},
						swfPath: "$jsurl",
						supplied: "m4v",
						cssSelectorAncestor: "#jp_container_$count",
                        smoothPlayBar: true,
                        keyEnabled: true
					});
				});
				//]]>
			</script>
			<div id="jp_container_$count" class="jp-video jp-video-$size">
			<div class="jp-type-single">
				<div id="jquery_jplayer_$count" class="jp-jplayer"></div>
				<div class="jp-gui">
					<div class="jp-video-play">
						<a href="javascript:;" class="jp-video-play-icon" tabindex="1">play</a>
					</div>
					<div class="jp-interface">
						<div class="jp-progress">
							<div class="jp-seek-bar">
								<div class="jp-play-bar"></div>
							</div>
						</div>
						<div class="jp-current-time"></div>
						<div class="jp-duration"></div>
						<div class="jp-controls-holder">
							<ul class="jp-controls">
								<li><a href="javascript:;" class="jp-play" tabindex="1">play</a></li>
								<li><a href="javascript:;" class="jp-pause" tabindex="1">pause</a></li>
								<li><a href="javascript:;" class="jp-stop" tabindex="1">stop</a></li>
								<li><a href="javascript:;" class="jp-mute" tabindex="1" title="mute">mute</a></li>
								<li><a href="javascript:;" class="jp-unmute" tabindex="1" title="unmute">unmute</a></li>
								<li><a href="javascript:;" class="jp-volume-max" tabindex="1" title="max volume">max volume</a></li>
							</ul>
							<div class="jp-volume-bar">
								<div class="jp-volume-bar-value"></div>
							</div>
							<ul class="jp-toggles">
								<li><a href="javascript:;" class="jp-full-screen" tabindex="1" title="full screen">full screen</a></li>
								<li><a href="javascript:;" class="jp-restore-screen" tabindex="1" title="restore screen">restore screen</a></li>
								<li><a href="javascript:;" class="jp-repeat" tabindex="1" title="repeat">repeat</a></li>
								<li><a href="javascript:;" class="jp-repeat-off" tabindex="1" title="repeat off">repeat off</a></li>
							</ul>
						</div>
						<div class="jp-title">
							<ul>
								<li>$title</li>
							</ul>
						</div>
					</div>
				</div>
				<div class="jp-no-solution">
					<span>Update Required</span>
					To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.
				</div>
			</div>
		</div>
PLY;

			return $player;
		}
	}

	$wpjplayer = new wpjplayer();
}