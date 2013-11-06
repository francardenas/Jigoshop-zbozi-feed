<?php
ob_start();
/*
Plugin Name: Jigoshop - XML Feed zbozi.cz
Plugin URI: http://www.francardenas.com/
Version: 1.00
Author: Fran Cardenas
License:
Description: Wordpress plugin that create a XML feed for zbozi.cz with Jigoshop products
*/
/*  Copyright 2013  francardenas.com  (email : fran@francardenas.com)

*/

if (!isset($wpdb)) $wpdb = $GLOBALS['wpdb'];

//Define the product feed php page
function zbozi_feed_rss() {
 $rss_template = dirname(__FILE__) . '/product-feed.php';
 load_template ( $rss_template );
}

//Add the product feed RSS
add_action('do_feed_zbozi', 'zbozi_feed_rss', 10, 1);

//Update the Rerewrite rules
add_action('init', 'add_products_to_zbozi');

//function to add the rewrite rules
function add_products_to_zbozi_rules( $wp_rewrite ) {
 $new_rules = array(
 'feed/(.+)' => 'index.php?feed='.$wp_rewrite->preg_index(1)
 );
 $wp_rewrite->rules = $new_rules + $wp_rewrite->rules;
}

//add the rewrite rule
function add_products_to_zbozi( ) {
 global $wp_rewrite;
 add_action('generate_rewrite_rules', 'add_products_to_zbozi_rules');
 $wp_rewrite->flush_rules();
}

$feed_ver = '1.00';

/* 
 * Do not change this - otherwise it may result in damage to the system
 */
add_option('zbozi_products_in_feed', 50);
add_option('feed_title', '');
add_option('zbozi_product_condition', 'new');
add_option('zbozi_product_dph', 'DPH');
add_option('zbozi_product_na_sklade', 'available');
add_option('zbozi_product_out_stock', 'out of stock');
add_option('zbozi_product_type', 'Software | Wordpress | Plugin');
add_option('zbozi_product_cpc', '');
add_option('zbozi_product_delivery', '');

add_option('zbozirss_what_to_show', 'both');
add_option('zbozirss_which_first', 'posts');
add_option('zbozirss_post_sort_order', 'title');
add_option('zbozirss_page_sort_order', 'title');
add_option('zbozirss_comments_on_posts', FALSE);
add_option('zbozirss_comments_on_pages', FALSE);
add_option('zbozirss_show_zero_comments', FALSE);
add_option('zbozirss_hide_future', FALSE);
add_option('zbozirss_new_window', FALSE);
add_option('zbozirss_show_post_date', FALSE);
add_option('zbozirss_show_page_date', FALSE);
add_option('zbozirss_date_format', 'F jS, Y');
add_option('zbozirss_hide_protected', TRUE);

add_option('zbozirss_excluded_pages', '');
add_option('zbozirss_page_nav', '1');
add_option('zbozirss_page_nav_where', 'top');
add_option('zbozirss_xml_path', '');

add_option('zbozirss_xml_where', 'last');

/*
 * Setting the plugin page in System Settings
 */
function zbozirss_xml_feed2() {
	if (function_exists('add_options_page')) {
		add_options_page('XML Feed zbozi.cz', 'XML Feed zbozi.cz', 'manage_options', __FILE__, 'zbozirss_options_page');
	}
}

/* 
 * Updating settings
 */
function zbozirss_options_page() {

	global $feed_ver;

	if (isset($_POST['set_defaults'])) {
		echo '<div id="message" class="updated fade"><p><strong>';

		update_option('zbozi_products_in_feed', 50);
		update_option('feed_title', '');
		update_option('zbozi_product_condition', 'new');
		update_option('zbozirss_what_to_show', 'both');
		update_option('zbozirss_which_first', 'posts');	
		update_option('zbozirss_post_sort_order', 'title');
		update_option('zbozirss_page_sort_order', 'title');
		update_option('zbozirss_comments_on_posts', FALSE);
		update_option('zbozirss_comments_on_pages', FALSE);
		update_option('zbozirss_show_zero_comments', FALSE);
		update_option('zbozirss_hide_future', FALSE);
		update_option('zbozirss_new_window', FALSE);
		update_option('zbozirss_show_post_date', FALSE);
		update_option('zbozirss_show_page_date', FALSE);
		update_option('zbozirss_date_format', 'F jS, Y');
		update_option('zbozirss_hide_protected', TRUE);
		update_option('zbozirss_excluded_pages', '');
		update_option('zbozirss_page_nav', '1');
		update_option('zbozirss_page_nav_where', 'top');
		update_option('zbozirss_xml_path', '');
		update_option('zbozi_product_type', 'Software | Wordpress | Plugin');
		update_option('zbozi_product_cpc', '');
		update_option('zbozi_product_delivery', '');
			update_option('zbozi_product_dph', 'DPH');
			update_option('zbozi_product_na_sklade', 'na sklade');
			update_option('zbozi_product_out_stock', 'out of stock');
		update_option('zbozirss_xml_where', 'last');

		echo "Default config loaded";
		echo '</strong></p></div>';	

	} else if (isset($_POST['info_update'])) {

		echo '<div id="message" class="updated fade"><p><strong>';

		update_option('zbozi_language3', (string) $_POST["zbozi_language3"]);
		update_option('zbozi_products_in_feed', (int) $_POST["zbozi_products_in_feed"]);
		update_option('feed_title', (string) $_POST["feed_title"]);
		update_option('zbozirss_what_to_show', (string) $_POST["zbozirss_what_to_show"]);
		update_option('zbozirss_which_first', (string) $_POST["zbozirss_which_first"]);
		update_option('zbozirss_post_sort_order', (string) $_POST["zbozirss_post_sort_order"]);	
		update_option('zbozirss_page_sort_order', (string) $_POST["zbozirss_page_sort_order"]);	
		update_option('zbozirss_comments_on_posts', (bool) $_POST["zbozirss_comments_on_posts"]);
		update_option('zbozirss_comments_on_pages', (bool) $_POST["zbozirss_comments_on_pages"]);
		update_option('zbozirss_show_zero_comments', (bool) $_POST["zbozirss_show_zero_comments"]);	
		update_option('zbozirss_hide_future', (bool) $_POST["zbozirss_hide_future"]);
		update_option('zbozirss_new_window', (bool) $_POST["zbozirss_new_window"]);	
		update_option('zbozirss_show_post_date', (bool) $_POST["zbozirss_show_post_date"]);
		update_option('zbozirss_show_page_date', (bool) $_POST["zbozirss_show_page_date"]);
		update_option('zbozirss_date_format', (string) $_POST["zbozirss_date_format"]);
		update_option('zbozirss_hide_protected', (bool) $_POST["zbozirss_hide_protected"]);
		update_option('zbozi_product_condition', (string) $_POST["zbozi_product_condition"]);
		update_option('zbozirss_excluded_pages', (string) $_POST["zbozirss_excluded_pages"]);
		update_option('zbozirss_page_nav', (string) $_POST["zbozirss_page_nav"]);
		update_option('zbozirss_page_nav_where', (string) $_POST["zbozirss_page_nav_where"]);
		update_option('zbozirss_xml_path', (string) $_POST["zbozirss_xml_path"]);
		update_option('zbozi_product_type', (string) $_POST["zbozi_product_type"]);
		update_option('zbozi_product_cpc', (string) $_POST["zbozi_product_cpc"]);
		update_option('zbozi_product_delivery', (string) $_POST["zbozi_product_delivery"]);
		update_option('zbozi_product_dph', (string) $_POST["zbozi_product_dph"]);
		update_option('zbozi_product_na_sklade', (string) $_POST["zbozi_product_na_sklade"]);
		update_option('zbozi_product_out_stock', (string) $_POST["zbozi_product_out_stock"]);
		update_option('zbozirss_xml_where', (string) $_POST["zbozirss_xml_where"]);	

		echo "XML feed config. updated";
	    echo '</strong></p></div>';
ob_flush();
	} ?>
	<div class="wrap">
	<h2>Jigoshop - zbozi.cz XML Feed</h2>
	<form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
	<input type="hidden" name="info_update" id="info_update" value="true" />

<hr>
	<fieldset class="options">

	<table width="100%" border="0" cellspacing="0" cellpadding="6">

   	<tr valign="top">

	<th width="45%" valign="top" align="right" scope="row">Product status</th><td valign="top">
	<input name="zbozi_product_condition" type="radio" value="new" <?php if (get_option('zbozi_product_condition') == "new") echo "checked='checked'"; ?> />&nbsp;&nbsp; new
	<input name="zbozi_product_condition" type="radio" value="used" <?php if (get_option('zbozi_product_condition') == "used") echo "checked='checked'"; ?> />&nbsp;&nbsp; used
	<input name="zbozi_product_condition" type="radio" value="refurbished" <?php if (get_option('zbozi_product_condition') == "refurbished") echo "checked='checked'"; ?>/>&nbsp;&nbsp;	refurbished<br />
	Default: <strong>new</strong>. But you can set to <strong>used</strong> or <strong>refurbished</strong>.<br /><br />
		</td></tr>

	<tr><th width="45%" valign="top" align="right" scope="row">In stock - options</th><td valign="top">
	<input name="zbozi_product_na_sklade" type="radio" value="available" <?php if (get_option('zbozi_product_na_sklade') == "available") echo "checked='checked'"; ?> />&nbsp;&nbsp; available
	<input name="zbozi_product_na_sklade" type="radio" value="available for order" <?php if (get_option('zbozi_product_na_sklade') == "available for order") echo "checked='checked'"; ?> />&nbsp;&nbsp; available for order<br />
		Default: <strong>available</strong>. But you can set to <strong>available for order</strong>.<br /><br />
		 </td></tr>

<tr><th width="45%" valign="top" align="right" scope="row">Product type</th><td valign="top">
	<input name="zbozi_product_type" type="text" size="75" value="<?php echo get_option('zbozi_product_type') ?>"/><br />
	Default: <strong>Software | Wordpress | Plugin</strong><br />
	Product Attributes can also set the taxonomy by Google merchant. Please use the scan and the plugin will help you. But it is not necessary to enter it again (once it has entered)<br />
	</td></tr>
	
	<tr><th width="45%" valign="top" align="right" scope="row">Max CPC</th><td valign="top">
	<input name="zbozi_product_cpc" type="text" size="75" value="<?php echo get_option('zbozi_product_cpc') ?>"/><br />
	Set the maximum price that you are willing to offer per click. Decimal places separated by comma. The maximum price per click is 500 CZK.<br />
	</td></tr>
	
	<tr><th width="45%" valign="top" align="right" scope="row">Delivery Date</th><td valign="top">
	<input name="zbozi_product_delivery" type="text" size="75" value="<?php echo get_option('zbozi_product_delivery') ?>"/><br />
	Product Delivery time in days , the time of receipt of payment (in case of cash on delivery from receipt of order) to dispatch of goods. The numerical value is then our system automatically converted to text representation.<br />
	<br />
	zbozi.cz Availability options:<br />
	in stock - 0 days<br />
	within a week - 1-6 days<br />
	more than a week - 7 days and more<br />
	unknown availabilty - -1<br />
	</td></tr>

	<br /><br /><br />

	</table>
	</fieldset>

	<div class="submit">
		<input type="submit" name="set_defaults" value="Set defaults &raquo;" />
		<input type="submit" name="info_update" value="Save settings &raquo;" />
	</div>

	</form>
<hr>
	<h2> Here is your zbozi.cz XML feed: <a target="_blank" href="<?php bloginfo_rss('wpurl') ?>/feed/zbozi/"><?php bloginfo_rss('wpurl') ?>/feed/zbozi/</a></h2>
	 <strong>Can't you see your XML feed?</strong>

<br />
	<li>Allow permanent links permissions</li>
	<li>Be sure that you have any products</li> <br />

	<h2>Products list</h2><br />

<table width="100%" border="0" cellspacing="0" cellpadding="6">
<tr>
<th>Product ID</th>
<th>Name</th>
<th>Description</th>
<th>URL link</th>
<th>Price with VAT</th>
<th>Category</th>
</tr>
<?php
    $args['post_type'] = 'product';
    $args['numberposts'] = 999;
    $args['offset'] = 0;

    $loop = new WP_Query( $args );
    while ( $loop->have_posts() ) : $loop->the_post();

                setup_postdata($post);

                $jigoshop_product = new jigoshop_product ( $post->ID );
?>
	<product>
	<tr>
		<td><ITEM_ID><?php echo $post->ID; ?></ITEM_ID></td>
        <td><PRODUCTNAME><?php echo get_the_title(); ?></PRODUCTNAME></td>
<td><?php if (get_option('rss_use_excerpt')) : ?>
        <description><![CDATA[<?php the_excerpt_rss() ?>]]></description>
<?php else : ?>
        <description><![CDATA[<?php the_excerpt_rss() ?>]]></description>
<?php endif; ?></td>
		<td><URL><?php the_permalink_rss() ?></URL></td>
		<td><PRICE_VAT><?php echo $jigoshop_product->get_price() ?></PRICE_VAT></td>
		<td><CATEGORYTEXT><?php echo get_option('zbozi_product_type') ?></CATEGORYTEXT></td>
<?php rss_enclosure(); ?>
<?php do_action('rss2_item'); ?>
    </tr></product>
    <?php endwhile;	?>
</table>

</div><?php
}
add_action('admin_menu', 'zbozirss_xml_feed2');