<?php

if (!function_exists('bridge_qode_child_theme_enqueue_scripts')) {

	function bridge_qode_child_theme_enqueue_scripts()
	{
		wp_register_style('bridge-childstyle', get_stylesheet_directory_uri() . '/style.css');
		wp_enqueue_style('bridge-childstyle');
	}

	add_action('wp_enqueue_scripts', 'bridge_qode_child_theme_enqueue_scripts', 11);
}

// Add .cdn after http:// or https://
function to_cdn($src)
{
	if (!defined('CDN_URL')) {
		return $src;
	}
	return CDN_URL . '/fit=cover/' . $src;
}

function test_get_attachment_image_src($image)
{
	if (!is_admin()) {
		if (!$image) {
			return false;
		}

		if (is_array($image)) {
			$src = to_cdn($image[0]); // To CDN
			$width = $image[1];
			$height = $image[2];

			return [$src, $width, $height, true];
		} else {
			return false;
		}
	}

	return $image;
}
add_filter('wp_get_attachment_image_src', 'test_get_attachment_image_src', 10, 4);
