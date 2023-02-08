<?php

/**
 * @package OB extension
 */
/*
Plugin Name: OB extension
Plugin URI: https://OB extension.com/
Description: For OB extension
Version: 1.0.3
Requires at least: 5.0
Requires PHP: 5.2
Author: Automattic
Author URI: https://automattic.com/wordpress-plugins/
License: GPLv2 or later
Text Domain: OB extension
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.

Copyright 2005-2022 Automattic, Inc.
*/

// Make sure we don't expose any info if called directly




add_action('wp_head', 'wpshout_action_header');

function wpshout_action_header()
{

	wp_register_style('ob-extension', plugin_dir_url(__FILE__) . '_inc/css/ob-extension.css', array(), false);
	wp_enqueue_style('ob-extension');
    wp_enqueue_script( 'ob-extension-js', plugin_dir_url(__FILE__) . '_inc/js/ob-extension.js', false );
}

add_action('wp_enqueue_scripts', 'wpshout_action_header', false);

// elementor
// Add Plugin actions
function init_elementor_widgets_ob()
{
	// Include Widget files
	$files = glob(__DIR__ . '/widgets/elementors/*.php');

	// 	echo var_dump(__DIR__ . '/widgets/elementors/*.php');
	// exit();

	foreach ($files as $file) {
		require_once($file);
	}
	// Register widget
	\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \Elementor_Ob_Extension_Widget());
	\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \Elementor_BlogArticleBrazil_Widget());
}

add_action('elementor/widgets/widgets_registered', 'init_elementor_widgets_ob');


// Register Custom Post Type
function page_index_post_type()
{

	$labels = array(
		'name'                  => _x('Page index', 'Post Type General Name', 'OBE'),
		'singular_name'         => _x('Page index', 'Post Type Singular Name', 'OBE'),
		'menu_name'             => __('Page index', 'OBE'),
		'name_admin_bar'        => __('Page index', 'OBE'),
		'archives'              => __('Chapter Archives', 'OBE'),
		'attributes'            => __('Chapter Attributes', 'OBE'),
		'parent_item_colon'     => __('Parent Chapter:', 'OBE'),
		'all_items'             => __('All Chapters', 'OBE'),
		'add_new_item'          => __('Add New Chapter', 'OBE'),
		'add_new'               => __('Add Chapter', 'OBE'),
		'new_item'              => __('New Chapter', 'OBE'),
		'edit_item'             => __('Edit Chapter', 'OBE'),
		'update_item'           => __('Update Chapter', 'OBE'),
		'view_item'             => __('View Chapter', 'OBE'),
		'view_items'            => __('View Chapter', 'OBE'),
		'search_items'          => __('Search Chapter', 'OBE'),
		'not_found'             => __('Not found', 'OBE'),
		'not_found_in_trash'    => __('Not found in Trash', 'OBE'),
		'featured_image'        => __('Featured Image', 'OBE'),
		'set_featured_image'    => __('Set featured image', 'OBE'),
		'remove_featured_image' => __('Remove featured image', 'OBE'),
		'use_featured_image'    => __('Use as featured image', 'OBE'),
		'insert_into_item'      => __('Insert into Chapter', 'OBE'),
		'uploaded_to_this_item' => __('Uploaded to this Chapter', 'OBE'),
		'items_list'            => __('Chapters list', 'OBE'),
		'items_list_navigation' => __('Chapters list navigation', 'OBE'),
		'filter_items_list'     => __('Filter chapter list', 'OBE'),
	);
	$args = array(
		'label'                 => __('Page index', 'OBE'),
		'description'           => __('Page index', 'OBE'),
		'labels'                => $labels,
		'supports'              => array('title', 'editor', 'thumbnail'),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'          	=> 'dashicons-admin-page',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
	);
	register_post_type('Page index', $args);
}
add_action('init', 'page_index_post_type', 0);

// Register Custom Taxonomy
function custom_taxonomy_xxx()
{

	$labels = array(
		'name'                       => _x('Chapter themes', 'Chapter themes General Name', 'text_domain'),
		'singular_name'              => _x('Chapter themes', 'Chapter themes Singular Name', 'text_domain'),
		'menu_name'                  => __('Chapter themes', 'text_domain'),
		'all_items'                  => __('All Items', 'text_domain'),
		'parent_item'                => __('Parent Item', 'text_domain'),
		'parent_item_colon'          => __('Parent Item:', 'text_domain'),
		'new_item_name'              => __('New Item Name', 'text_domain'),
		'add_new_item'               => __('Add New Item', 'text_domain'),
		'edit_item'                  => __('Edit Item', 'text_domain'),
		'update_item'                => __('Update Item', 'text_domain'),
		'view_item'                  => __('View Item', 'text_domain'),
		'separate_items_with_commas' => __('Separate items with commas', 'text_domain'),
		'add_or_remove_items'        => __('Add or remove items', 'text_domain'),
		'choose_from_most_used'      => __('Choose from the most used', 'text_domain'),
		'popular_items'              => __('Popular Items', 'text_domain'),
		'search_items'               => __('Search Items', 'text_domain'),
		'not_found'                  => __('Not Found', 'text_domain'),
		'no_terms'                   => __('No items', 'text_domain'),
		'items_list'                 => __('Items list', 'text_domain'),
		'items_list_navigation'      => __('Items list navigation', 'text_domain'),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy('taxonomy_table_of_content', array('pageindex'), $args);
}
add_action('init', 'custom_taxonomy_xxx', 0);


add_action('wp_ajax_getChapter', 'chapter_init');
add_action('wp_ajax_nopriv_getChapter', 'chapter_init');
function chapter_init()
{

	// if(!is_user_logged_in()) {
	// 	wp_send_json_success("");
	// 	die();
	// }

	$args =  array(
		'post_type' => 'pageindex',
		'post_status' => 'publish',
		'posts_per_page' => -1,
		'tax_query' => array(
			array(
				'taxonomy' => 'taxonomy_table_of_content',
				'field' => 'term_id',
				'terms' => $_POST['dataId']
			)
		)
	);

	$query = new WP_Query($args);
	ob_start();
	?>
        <?php
            $count = 0;
            while ( $query->have_posts() ) : $query->the_post();
            if($count == 0) {
            $count = $count + 1;
        ?>
            <div class="ob-extension-content__inner" data-content-id="active-<?php echo get_the_ID(); ?>">
                <div class="ob-extension-content__head">
                    <span>
                        <?php echo get_field("sub_title"); ?>
                    </span>
                    <h2><?php the_title(); ?></h2>
                </div>
                <?php the_content(); ?>
                <div class="ob-extension-content__footer">
                    <span>Author</span>
                    <?php echo get_field("author"); ?>
                </div>
            </div>
        <?php }
        endwhile; ?>
	<?php
	ob_end_flush();
	$content = ob_get_contents();
	ob_clean();

	wp_send_json_success($content);

	die(); //bắt buộc phải có khi kết thúc
}


function create_pageQuote_shortcode($args, $content) {
	ob_start();
	?>
		<div class="ct-info-quote">
			<div class="ct-info-quote__description">
				<?php echo get_field('content'); ?>
			</div>
			<div class="ct-info-quote__author">
				<div class="ct-info-quote__content">
					<div class="ct-info-quote__name">
						<?php echo get_field('name'); ?>
					</div>
					<div class="ct-info-quote__position">
						<?php echo get_field('position'); ?>
					</div>
					<?php if(get_field('quote_icon')) : ?>
					<div class="ct-info-quote__truelayer">
						<img src="<?php echo get_field('quote_icon'); ?>" alt="Truelayer">
					</div>
					<?php endif; ?>
				</div>
				<div class="ct-info-quote__avatar">
					<img src="<?php echo get_field('image'); ?>" alt="Avatar">
				</div>
			</div>
		</div>
	<?php
	$result = ob_get_contents();
	ob_end_clean();
	return $result;
}
add_shortcode( 'page-quote', 'create_pageQuote_shortcode' );

// Register Custom Post Type
function page_index_dashbload_post_type()
{
	$labels = array(
		'name'                  => _x('User index download', 'Post Type General Name', 'OBE'),
		'singular_name'         => _x('User index download', 'Post Type Singular Name', 'OBE'),
		'menu_name'             => __('User index download', 'OBE'),
		'name_admin_bar'        => __('User index download', 'OBE'),
		'archives'              => __('Chapter Archives', 'OBE'),
		'attributes'            => __('Chapter Attributes', 'OBE'),
		'parent_item_colon'     => __('Parent Chapter:', 'OBE'),
		'all_items'             => __('All Chapters', 'OBE'),
		'add_new_item'          => __('Add New Chapter', 'OBE'),
		'add_new'               => __('Add Chapter', 'OBE'),
		'new_item'              => __('New Chapter', 'OBE'),
		'edit_item'             => __('Edit Chapter', 'OBE'),
		'update_item'           => __('Update Chapter', 'OBE'),
		'view_item'             => __('View Chapter', 'OBE'),
		'view_items'            => __('View Chapter', 'OBE'),
		'search_items'          => __('Search Chapter', 'OBE'),
		'not_found'             => __('Not found', 'OBE'),
		'not_found_in_trash'    => __('Not found in Trash', 'OBE'),
		'featured_image'        => __('Featured Image', 'OBE'),
		'set_featured_image'    => __('Set featured image', 'OBE'),
		'remove_featured_image' => __('Remove featured image', 'OBE'),
		'use_featured_image'    => __('Use as featured image', 'OBE'),
		'insert_into_item'      => __('Insert into Chapter', 'OBE'),
		'uploaded_to_this_item' => __('Uploaded to this Chapter', 'OBE'),
		'items_list'            => __('Chapters list', 'OBE'),
		'items_list_navigation' => __('Chapters list navigation', 'OBE'),
		'filter_items_list'     => __('Filter chapter list', 'OBE'),
	);
	$args = array(
		'label'                 => __('User index download', 'OBE'),
		'description'           => __('User index download', 'OBE'),
		'labels'                => $labels,
		'supports'              => array('title', 'editor', 'thumbnail'),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'          	=> 'dashicons-admin-page',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => false,
		'can_export'            => false,
		'has_archive'           => false,
		'exclude_from_search'   => false,
		'publicly_queryable'    => false,
		'capability_type'       => 'page',
	);
	register_post_type('User index download', $args);
}
add_action('init', 'page_index_dashbload_post_type', 0);


function save_user_download_file($data)
{
	if (isset($_POST['user_name'])) $user_name = $_POST['user_name'];
	if (isset($_POST['user_email'])) $user_email = $_POST['user_email'];

	if(!empty($user_name) || !empty($user_email)) {
		$new_post = array(
			'ID' => '',
			'post_type' => 'userindexdownload', // Custom Post Type Slug
			'post_status' => 'private',
			'post_title' => $user_email,
		);
		$post_id = wp_insert_post($new_post);
		var_dump($post_id);
		if(!empty($post_id)) {
			if(!empty($user_name)) update_post_meta($post_id, 'user_name', $user_name);
			if(!empty($user_email)) update_post_meta($post_id, 'user_email', $user_email);
		}
	}

	return [
		'status' => 'success',
	];
}

function get_user_info_by_email($data)
{
	if (isset($_GET['user_email'])) $user_email = $_GET['user_email'];
	$user_name = null;
	$hash = null;

	if($user_email) {
		$user_info = get_user_by_email($user_email);
		if(!empty($user_info)) {
			$user_data = $user_info->data;
			$user_name = $user_data->user_nicename;
		}
		$hash = hash_hmac('sha256',  $user_email ,'obextensiontokenactive');
	}

	return [
		'status' => 'success',
		'data' => [
			'user_email' => $user_email,
			'user_name' => $user_name,
			'hash' => $hash
		]
	];
}

add_action('rest_api_init', function () {
    register_rest_route('theme/v1', 'save-user-download-file', array(
        'methods' => 'POST',
        'callback' => 'save_user_download_file',
    ));
    register_rest_route('theme/v1', 'get-user-info-by-email', array(
        'methods' => 'GET',
        'callback' => 'get_user_info_by_email',
    ));
});// http://example.com/wp-json/theme/v1/save-user-download-file



function user_index_dashbload_meta_box_output($post)
{
	$user_name = get_post_meta($post->ID, 'user_name', true);
	$user_email = get_post_meta($post->ID, 'user_email', true);

	echo '<div style="margin-bottom: 10px">';
	echo ('<label for="user_name">User name: </label>');
	echo ('<input type="text" id="user_name" name="user_name" value="' . esc_attr($user_name) . '" />');
	echo '</div>';
	echo '<div style="margin-bottom: 10px">';
	echo ('<label for="user_email">User email: </label>');
	echo ('<input type="text" id="user_email" name="user_email" value="' . esc_attr($user_email) . '" />');
	echo '</div>';

}

function user_index_dashbload_meta_box()
{
	add_meta_box('userindexdownload', 'userindexdownload', 'user_index_dashbload_meta_box_output', 'userindexdownload');
}
add_action('add_meta_boxes', 'user_index_dashbload_meta_box');
