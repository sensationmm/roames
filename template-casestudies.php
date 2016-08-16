<?php 
/**
 * @package WordPress
 * @subpackage Roames 2016
 * Template Name: Case Studies
*/
get_header();  

$page_banner = get_field('page_banner', $pageObj->ID);
if($page_banner == '') $page_banner = 'assets/images/banner-default-casestudies.jpg';
?>

	<div class="banner" style="background-image:url(<?php echo $page_banner; ?>);">
		<div class="banner-content">
			<h1>Case Studies</h1>
		</div>
	</div>
		
	<div class="filter">
		<div class="body">
			<div class="events-filter">
				<ul>
					<li>View by:</li>
					<li class="option"><a href="<?php echo get_permalink(95); ?>" title="View all">All</a></li>
					<?php
						$localisation = get_categories(array('taxonomy' => 'casestudies-region', 'hide_empty' => 0, 'title_li' => '', 'echo' => false));
						// echo '<pre>';print_r($localisation);echo '</pre>';

						foreach($localisation as $region) {
							echo '<li class="option"><a '.(($region->term_id == get_queried_object()->term_id) ? 'class="active" ' : '').' href="'.get_term_link($region->term_id).'" title="View '.$region->name.' case studies">'.$region->name.'</a></li>';
						}
					?>
					<li class="option-dropdown">
						<form name="mobilenav" method="post" action="/wp-content/themes/roames2016/mobile-redirect.php">
							<select name="destination" onchange="document.mobilenav.submit()">
							<option value="<?php echo get_permalink(95); ?>">All</option>
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

	<div class="events">
	<?php
		$term_id = get_queried_object()->term_id;
		if($term_id != '') {
			$args = array('post_type' => 'casestudy', 'tax_query' => array(array('taxonomy' => 'casestudies-region', 'field' => 'id', 'terms' => $term_id)));
		} else {
			$args = array('post_type' => 'casestudy', 'posts_per_page' => -1);
		}
		$casestudies = get_posts($args);

		if(sizeof($casestudies) > 0) {
			$count = 0;
			foreach($casestudies as $casestudy) {
				$count++;
				// echo '<div class="event">';
				// 	echo '<div class="event-date">'.get_field('event_date', $casestudy->ID).'</div>';
				// 	echo '<div class="event-category">'.get_field('event_type', $casestudy->ID).'</div>';
				// 	echo '<h3>'.$casestudy->post_title.'</h3>';
				// 	echo '<p>'.get_field('event_intro', $casestudy->ID).'</p>';
				// 	echo '<a class="button-label" href="'.get_permalink($casestudy->ID).'" alt="Register">Register</a>';
				// echo '</div>';


				echo '<a href="'.get_permalink($casestudy->ID).'" title="View '.$casestudy->post_title.'">';
				$image = wp_get_attachment_url( get_post_thumbnail_id($casestudy->ID) );
				echo '<article class="case-study casestudy'.$count.'" style="background-image:url('.$image.');" >';
					echo '<div class="case-study-label">';
					$client = get_field('casestudies_client', $casestudy->ID);
						echo '<div class="case-study-category">'.$client->post_title.'</div>';
						echo '<h3>'.$casestudy->post_title.'</h3>';
					echo '</div>';
				echo '</article>';
				echo '</a>';
			}
		} else {
			echo '<div class="no-results"><p>There are no case studies to display for this region</p></div>';
		}
	?>
	</div>

<?php get_footer(); ?> 