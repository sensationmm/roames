<?php 
/**
 * @package WordPress
 * @subpackage Roames 2016
 * Template Name: Whitepapers
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
		$args = array('post_type' => 'whitepaper');
		$events = get_posts($args);


		echo '<div class="events-row-4">';
		$count = 0;

		if(sizeof($events) > 0) {
			foreach($events as $event) {
				$count++;
				echo '<div class="event">';
					echo '<h3>'.$event->post_title.'</h3>';
					echo '<p>'.get_field('whitepapers_intro', $event->ID).'</p>';
					echo '<a class="button-label event-register" href="'.get_field('whitepapers_link', $event->ID).'" alt="Download" target="_blank">Download</a>';
				echo '</div>';

				if($count%4 == 0) echo '</div><div class="events-row-4">';
			}
		} else {
			echo '<div class="no-results"><h2>Sorry!</h2><p>There are no events to display for that region</p></div>';
		}

		if($count%4 == 3) echo '<div class="event event-empty">&nbsp;</div><div class="event event-empty">&nbsp;</div><div class="event event-empty">&nbsp;</div></div>';
		else if($count%4 == 2) echo '<div class="event event-empty">&nbsp;</div><div class="event event-empty">&nbsp;</div></div>';
		else if($count%4 == 1) echo '<div class="event event-empty">&nbsp;</div></div>';
		else echo '</div>';
	?>
	</div>

<?php get_footer(); ?> 