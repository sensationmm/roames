<?php 
get_header();  

$page_banner = get_field('page_banner', $pageObj->ID);
if($page_banner == '') $page_banner = 'assets/images/banner-default-events.jpg';
?>

	<div class="banner" style="background-image:url(<?php echo $page_banner; ?>);">
		<div class="banner-content">
			<h1>Events</h1>
		</div>
	</div>

	<div class="body-content">
		<article class="col-article">
			<div class="event-category"><?php $type = get_field('event_type', $pageObj->ID); echo $type; ?></div>

			<div class="event-image"><?php the_post_thumbnail(); ?></div>

			<h2><?php echo $pageObj->post_title; ?></h2>
			<?php echo apply_filters('the_content', $pageObj->post_content); ?>

			<div class="event-details">
				<dl>
				<?php
					$date = get_field('event_date', $pageObj->ID);
					$time = get_field('event_time', $pageObj->ID);

					if($date != '')
						echo '<dt>Date:</dt><dd>'.date('j M Y', strtotime($date)).'</dd>';

					if($time != '')
						echo '<dt>Time:</dt><dd>'.$time.'</dd>';
				?>
				</dl>
			</div>
		</article>

		<div class="col-aside">
			<div class="form-box full-width">
				<div class="form-box-header"><?php echo get_field('event_form_header', $pageObj->ID, false); ?></div>

				<?php echo get_field('event_form', $pageObj->ID, false); ?>
				<!--form class="demo">
					<div class="form-half">
						<label>First name</label>
						<input type="text" />
					</div>
					<div class="form-half">
						<label>Last name</label>
						<input type="text" />
					</div>
					<div class="form-half">
						<label>Email</label>
						<input type="text" />
					</div>
					<div class="form-half">
						<label>Company name</label>
						<input type="text" />
					</div>
					<input type="submit" value="Send" />
				</form-->
			</div>
		</div>
	</div>
<?php get_footer(); ?> 