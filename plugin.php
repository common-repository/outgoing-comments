<?php
/*
Plugin Name: Outgoing Comments (Tracker)
Plugin URI: http://mr.hokya.com/outgoing-comments/
Description: Display your recent outgoing comments on your dashboard menu to help you revisit your friend's site.
Version: 1.10
Author: Julian Widya Perdana
Author URI: http://mr.hokya.com/
*/

if (!get_option("oc_title")) update_option("oc_title","Outgoing Comments");

function register_outgoing_comments () {
	wp_add_dashboard_widget("Outgoing comments","Outgoing comments","outgoing_comments_db_widget");
}

function outgoing_comments_db_widget () {
	echo "<p>Here is your recent recorder comments on other site by exchanging comments or blogwalking</p>";
	$rss = fetch_feed("http://feeds.backtype.com/url/".str_replace("http://","",get_option("home"))."/");
	
	echo '<style>.rssSummary a {display:none}</style>';
	echo '<div class="rss-widget" style="overflow:scroll;height:200px">';
	wp_widget_rss_output($rss,"show_date=1&show_summary=1&show_author=1");
	echo '</div>';
	
	echo "<p><a href='http://mr.hokya.com/outgoing-comments' target='_blank'>Get Support</a> or <a href='http://mr.hokya.com/donate' target='_blank'>Give Support.</a></p>";
	
}

function outgoing_comments_widget ($args) {
	extract($args);
	$title = get_option("oc_title");
	echo $before_widget.$before_title.$title.$after_title;
	echo '<style>.rssSummary a {display:none}</style>';
	echo '<div>';
	$rss = fetch_feed("http://feeds.backtype.com/url/".str_replace("http://","",get_option("home"))."/");
	wp_widget_rss_output($rss,"show_date=1&show_summary=1&show_author=1");
	echo '</div>';
	echo $after_widget;
}

function outgoing_comments_control () {
	if ($_POST["oc_submit"]) {
		update_option("oc_title",$_POST["title"]);
	}
	$title = get_option("oc_title");
	echo "Title:<input name='title' value='$title'/><input type='hidden' name='oc_submit' value=1/>";
}

function outgoing_comments_rw () {
	register_sidebar_widget("Outgoing Comments","outgoing_comments_widget");
	register_widget_control("Outgoing Comments","outgoing_comments_control");
}

add_action('wp_dashboard_setup','register_outgoing_comments');
add_action('plugins_loaded','outgoing_comments_rw');

?>