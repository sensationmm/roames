<?php 
/**
 * @package WordPress
 * @subpackage Roames 2016
 * Template Name: Contact
*/
get_header(); 

$page_banner = get_field('page_banner', $pageObj->ID);
if($page_banner == '') $page_banner = 'assets/images/banner-default.jpg';
?>

	<div class="banner" style="background-image:url(<?php echo $page_banner; ?>);">
		<div class="banner-content">
			<h1><?php echo $pageObj->post_title; ?></h1>
		</div>
	</div>

	<div class="body-content">
		<div class="col-offices">
		<?php
			if( have_rows('contact_regions') ):
		        while ( have_rows('contact_regions') ) : the_row();
		            echo '<article>';
						echo '<h2>'.get_sub_field('contact_regions_name').'</h2>';
						echo '<p>'.get_sub_field('contact_regions_address').'<br />';
							echo '<b>T</b> '.get_sub_field('contact_regions_telephone').'<br />';
							$link = get_sub_field('contact_regions_map');
							if($link != '')
								echo '<a href="'.$link.'" title="View on Google Maps" target="_blank">View on Google Maps</a></p>';
					echo '</article>';
		        endwhile;
			endif;
		?>
		</div>

		<div class="col-form">
			<div class="form-box">
				<div class="form-box-header">Get in touch</div>
				<?php echo get_field('contact_form', $pageObj->ID, false); ?>
			</div>
		</div>
	</div>

	<?php include 'footer.php'; ?>