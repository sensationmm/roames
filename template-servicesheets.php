<?php 
/**
 * @package WordPress
 * @subpackage Roames 2016
 * Template Name: Service Sheets
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
		
	<div class="events">
	<?php
		$args = array('post_type' => 'servicesheet');
		$events = get_posts($args);

		if(sizeof($events) > 0) {
			foreach($events as $event) {
				echo '<div class="event">';
					echo '<h3>'.$event->post_title.'</h3>';
					echo '<p>'.get_field('downloads_intro', $event->ID).'</p>';
					echo '<a class="button-label" href="'.get_field('downloads_file', $event->ID).'" alt="Download" target="_blank">Download</a>';
				echo '</div>';
			}
		} else {
			echo '<div class="no-results"><h2>Sorry!</h2><p>There are no service sheets to display</p></div>';
		}
	?>
	</div>

<?php get_footer(); ?> 