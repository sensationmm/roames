<?php 
/**
 * @package WordPress
 * @subpackage Roames 2016
 * Template Name: Events
*/
get_header();  

$page_banner = get_field('page_banner', $pageObj->ID);
if($page_banner == '') $page_banner = 'assets/images/banner-default-events.jpg';
?>

	<div class="banner" style="background-image:url(<?php echo $page_banner; ?>);">
		<div class="banner-content">
			<h1>Events</h1>
		</div>
	</div>
		
	<div class="filter">
		<div class="body">
			<div class="events-filter">
				<ul>
					<li>View by:</li>
					<li class="option"><a href="<?php echo get_permalink(53); ?>" title="View all">All</a></li>
					<?php
						$localisation = get_categories(array('taxonomy' => 'events-region', 'hide_empty' => 0, 'title_li' => '', 'echo' => false));
						// echo '<pre>';print_r($localisation);echo '</pre>';

						foreach($localisation as $region) {
							echo '<li class="option"><a '.(($region->term_id == get_queried_object()->term_id) ? 'class="active" ' : '').' href="'.get_term_link($region->term_id).'" title="View '.$region->name.' events">'.$region->name.'</a></li>';
						}
					?>
					<li class="option-dropdown">
						<form name="mobilenav" method="post" action="/wp-content/themes/roames2016/mobile-redirect.php">
							<select name="destination" onchange="document.mobilenav.submit()">
							<option value="<?php echo get_permalink(53); ?>">All</option>
							<?php
								foreach($localisation as $region) {
									echo '<option '.(($region->term_id == get_queried_object()->term_id) ? 'selected="selected" ' : '').' value="'.get_term_link($region->term_id).'">'.$region->name.'</option>';
								}
							?>
							</select>
	        				<input type="hidden" name="action" value="redirect" />
						</form>
					</li>
				</ul>
			</div>
		</div>
	</div>

	<?php
		$term_id = get_queried_object()->term_id;
		if($term_id != '') {
			$args = array('post_type' => 'event', 
						  'posts_per_page' => -1, 
						  'tax_query' => array(array(
						  		'taxonomy' => 'events-region', 
						  		'field' => 'id', 
						  		'terms' => $term_id)),
						  'orderby' => 'meta_value',
						  'meta_key' => 'event_date',
						  'order' => 'asc'
						 );
		} else {
			$args = array('post_type' => 'event', 
						  'posts_per_page' => -1,
						  'orderby' => 'meta_value',
						  'meta_key' => 'event_date',
						  'order' => 'asc'
						 );
		}
		$events = get_posts($args);

		$count = 0;

		if(sizeof($events) > 0) {
		echo '<div class="events">';
		echo '<div class="events-row-4">';
			foreach($events as $event) {

				$date = get_field('event_date', $event->ID);
				$timestamp = strtotime($date);
				$date = date('j M Y', $timestamp);
				if($timestamp >= time()) {
					$count++;
					echo '<div class="event">';
						echo '<div class="event-date">'.date('j M Y', strtotime($date)).'</div>';
						echo '<div class="event-category">'.get_field('event_type', $event->ID).'</div>';
						echo '<h3><a href="'.get_permalink($event->ID).'" alt="Register">'.$event->post_title.'</a></h3>';
						//echo '<h3>'.$event->post_title.'</h3>';
						echo '<p>'.get_field('event_intro', $event->ID).'</p>';
						$label = get_field('event_label', $event->ID);
						if($label == '') $label = 'Register';
						echo '<a class="button-label event-register" href="'.get_permalink($event->ID).'" alt="'.$label.'">'.$label.'</a>';
					echo '</div>';

					if($count%4 == 0) echo '</div><div class="events-row-4">';
				}
			}
		if($count%4 == 3) echo '<div class="event event-empty">&nbsp;</div></div>';
		else if($count%4 == 2) echo '<div class="event event-empty">&nbsp;</div><div class="event event-empty">&nbsp;</div></div>';
		else if($count%4 == 1) echo '<div class="event event-empty">&nbsp;</div><div class="event event-empty">&nbsp;</div><div class="event event-empty">&nbsp;</div></div>';
		else echo '</div>';
		} else {
			echo '<div class="no-results"><p>There are no events to display for this region</p></div>';
		}

	?>
	</div>

<?php get_footer(); ?> 