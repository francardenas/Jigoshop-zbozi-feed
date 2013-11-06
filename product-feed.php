<?php
/**
 * Jigoshop - zbozi.cz XML Feed
 *
 * @package WordPress
 */

header("Content-Type: application/xml; charset=UTF-8");
        if ( isset ( $_REQUEST['feeddownload'] ) ) {
            header('Content-Disposition: attachment; filename="zbozi_feed.xml"');
        } else {
            header('Content-Disposition: inline; filename="zbozi_feed.xml"');
        }
$more = 1;
echo '<?xml version="1.0" encoding="'.get_option('blog_charset').'"?'.'>'; ?>

<SHOP>
    <?php
	
	function get_the_post_thumbnail_src( $post_id = null, $size = 'post-thumbnail' ) {

        $post_thumbnail_id = get_post_thumbnail_id( $post_id );

        if ( ! $post_thumbnail_id ) {
            return false;
        }

        list( $src ) = wp_get_attachment_image_src( $post_thumbnail_id, $size, false );

        return $src;
    }
	
       $args['post_type'] = 'product';
        $args['numberposts'] = 999;
        $args['offset'] = 0;

      $loop = new WP_Query( $args );
    while ( $loop->have_posts() ) : $loop->the_post();

        setup_postdata($post);

        $jigoshop_product = new jigoshop_product ( $post->ID );
				
		if ($jigoshop_product->is_in_stock()) {
			
			if ($jigoshop_product->get_price() > 0 ){
		
				$image_link = get_the_post_thumbnail_src ( $post->ID, 'shop_large' );
    ?>
    <SHOPITEM>
		<product><?php echo strip_tags(get_the_title()); ?></product>
<?php if (get_option('rss_use_excerpt')) : ?>
        <description><?php echo strip_tags(get_the_excerpt()) ?></description>
<?php else : ?>
        <description><?php echo strip_tags(get_the_excerpt()) ?></description>
<?php endif; ?>
		<URL><?php the_permalink_rss() ?></URL>
		<IMGURL><?php echo $image_link ?></IMGURL>
        <PRICE_VAT><?php echo $jigoshop_product->get_price() ?></PRICE_VAT>
		<MAX_CPC><?php echo get_option('zbozi_product_cpc') ?></MAX_CPC>
		<DELIVERY_DATE><?php echo get_option('zbozi_product_delivery') ?></DELIVERY_DATE>
		<ITEM_TYPE><?php echo get_option('zbozi_product_condition') ?></ITEM_TYPE>
	<?php rss_enclosure(); ?>
    <?php do_action('rss2_item'); ?>
    </SHOPITEM>
    <?php 
			}
		}
	endwhile;	?>
</SHOP>