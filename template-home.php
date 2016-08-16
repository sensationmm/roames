<?php 
/**
 * @package WordPress
 * @subpackage Roames 2016
 * Template Name: Home
*/
$data = get_userdata( get_current_user_id() );
 
if ( is_object( $data) ) {
    $current_user_caps = $data->allcaps;
     
    // print it to the screen
    echo '<pre>' . print_r( $current_user_caps, true ) . '</pre>';
}
get_header();  

$page_banner = get_field('page_banner', $pageObj->ID);
if($page_banner == '') $page_banner = 'assets/images/banner-default.jpg';
?>

	<div class="intro" style="background-image:url(<?php echo $page_banner; ?>);">
		<div class="intro-content intro-content-custom">
			<h1><?php echo get_field('home_header', $pageObj->ID); ?></h1>
			<p><?php echo get_field('home_strapline', $pageObj->ID); ?></p>
			<a class="button" href="<?php echo get_field('home_link', $pageObj->ID); ?>"><?php echo get_field('home_label', $pageObj->ID); ?></a>
		</div>

		<div class="go down">f</div>
	</div>

	<article>
	<?php
		$industries = get_page(20);

		echo '<h2>'.$industries->post_title.'</h2>';

		$args = array('parent' => $industries->ID , 'sort_order' => 'asc', 'sort_column' => 'menu_order');
		$industryPanels = get_pages($args);
		echo '<div class="feature-panels">';
		$count = 0;
		foreach($industryPanels as $panel) {
			$count++;
			$content = '';
			echo '<div class="feature-row">';
				$content .= '<div class="feature-col feature-col-text">';
					$content .= '<h3>'.$panel->post_title.'</h3>';
					$content .= '<p>'.get_field('industries_text', $panel->ID).'</p>';
					$content .= '<a class="button" href="'.get_permalink($panel->ID).'" alt="Read more">Read more</a>';
				$content .= '</div>';

				$image = get_field('industries_image', $panel->ID);
				if($count%2 == 0)
					$content = '<div class="feature-col feature-col-image" style="background-image:url('.$image.');">&nbsp;</div>'.$content;
				else
					$content = $content.'<div class="feature-col feature-col-image" style="background-image:url('.$image.');">&nbsp;</div>';

				echo $content;
			echo '</div>';
		}
		echo '</div>';
	?>
	</article>


	<article class="panel-padded">
		<h2><?php echo get_field('home_events', $pageObj->ID); ?></h2>
		<div class="events">
		<?php
			$args = array('post_type' => 'event',
						  'posts_per_page' => -1,
						  'orderby' => 'meta_value',
						  'meta_key' => 'event_date',
						  'order' => 'asc'
						 );
			$events = get_posts($args);

			$count = 0;
			foreach($events as $event) {
				$date = get_field('event_date', $event->ID);
				$timestamp = strtotime($date);
				$date = date('j M Y', $timestamp);
				if($count < 4 && $timestamp >= time()) {
					$count++;
					echo '<div class="event">';
						echo '<div class="event-date">'.$date.'</div>';
						echo '<div class="event-category">'.get_field('event_type', $event->ID).'</div>';
						echo '<h3><a href="'.get_permalink($event->ID).'" alt="Register">'.$event->post_title.'</a></h3>';
						echo '<p>'.get_field('event_intro', $event->ID).'</p>';
						$label = get_field('event_label', $event->ID);
						if($label == '') $label = 'Register';
						echo '<a class="button-label event-register" href="'.get_permalink($event->ID).'" alt="'.$label.'">'.$label.'</a>';
					echo '</div>';
				}
			}
		?>
		</div>
	</article>


	<article class="panel-grey panel-padded">
		<h2><?php echo get_field('home_case_studies', $pageObj->ID); ?></h2>
		<div class="case-studies">
		<?php
			$args = array('post_type' => 'casestudy',
						  'posts_per_page' => 2);
			$casestudies = get_posts($args);

			if(sizeof($casestudies) > 0) {
				foreach($casestudies as $casestudy) {
					echo '<a href="'.get_permalink($casestudy->ID).'" title="View '.$casestudy->post_title.'">';
					$image = wp_get_attachment_url( get_post_thumbnail_id($casestudy->ID) );
					echo '<article class="case-study case-study-custom" style="background-image:url('.$image.');">';
						echo '<div class="case-study-label">';
						$client = get_field('casestudies_client', $casestudy->ID);
							echo '<div class="case-study-category">'.$client->post_title.'</div>';
							echo '<h3>'.$casestudy->post_title.'</h3>';
						echo '</div>';
					echo '</article>';
					echo '</a>';
				}
			}

		?>
		</div>
	</article>


	<article class="panel-padded">
		<h2><?php echo get_field('home_testimonials', $pageObj->ID); ?></h2>
		<div class="body testimonials padding-side-80 padding-side-mob-40">
		<?php
			$args = array('post_type' => 'testimonial',
						  'posts_per_page' => 1,
						  'orderby' => 'rand',
						  'order' => 'asc');
			$testimonials = get_posts($args);

			foreach($testimonials as $testimonial) {
				echo '<quote>"'.$testimonial->post_content.'"</quote>';
				$logo = get_field('client_logo', $testimonial->ID);
				echo '<img src="'.$logo.'" alt="'.get_field('client_name', $testimonial->ID).'" />';
				echo '<div class="attr">'.$testimonial->post_title.'</div>';
			}
		?>
		</div>
		<div class="body clients clients-custom">
			<h3>Businesses using our platform</h3>
			<?php
				if( have_rows('home_clients') ):
			        while ( have_rows('home_clients') ) : the_row();
			            $logo = get_sub_field('home_clients_logo');
			            $name = get_sub_field('home_clients_name');
						echo '<img src="'.$logo.'" alt="'.$name.'" />';
			        endwhile;
    			endif;
		    ?>
		</div>
	</article>

<?php get_footer(); ?> 