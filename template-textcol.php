<?php 
/**
 * @package WordPress
 * @subpackage Roames 2016
 * Template Name: Text Column
*/
get_header();  

$page_banner = get_field('page_banner', $pageObj->ID);
if($page_banner == '') $page_banner = 'assets/images/banner-default-casestudies.jpg';
?>

	<div class="banner" style="background-image:url(<?php echo $page_banner; ?>);">
		<div class="banner-content">
			<h1><?php echo $pageObj->post_title; ?></h1>
		</div>
	</div>

	<div class="body-article">
		<article>
			<?php echo apply_filters('the_content', $pageObj->post_content); ?>
		</article>

	</div>

	<?php get_footer(); ?>