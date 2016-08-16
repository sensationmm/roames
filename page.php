<?php 
get_header();  

$page_banner = get_field('page_banner', $pageObj->ID);
if($page_banner == '') $page_banner = 'assets/images/banner-default.jpg';
?>

	<div class="banner" style="background-image:url(<?php echo $page_banner; ?>);">
		<div class="banner-content">
			<?php

				$depth = 0;
				$parent_id  = $pageObj->post_parent;
				while ($parent_id > 0) {
					$page = get_page($parent_id);
					$parent_id = $page->post_parent;
					$depth++;
				}
			?>
			<h1><?php if ($depth < 1) { echo $pageObj->post_title; } else { $parent = get_page($pageObj->post_parent); echo $parent->post_title; } ?></h1>
		</div>
	</div>

	<div class="body-content">
		<article class="col-main">
			<div class="mobile-page-nav">
			<?php

				if(has_children($pageObj->ID)) {
					$parentID = $pageObj->ID;
				} else {
					$parentID = $pageObj->post_parent;
				}
				$args = array('parent' => $parentID , 'sort_order' => 'asc', 'sort_column' => 'menu_order');
				$nav = get_pages($args);
				echo '<form name="mobilenav" method="post" action="/wp-content/themes/roames2016/mobile-redirect.php">';
				echo '<select name="destination" onchange="document.mobilenav.submit()">';
				foreach($nav as $navItem) {
					echo '<option'.(($pageObj->ID == $navItem->ID) ? ' selected="selected"' : '').' value="'.get_permalink($navItem->ID).'">'.$navItem->post_title.'</option>';
				}
				echo '</select>';
        		echo '<input type="hidden" name="action" value="redirect" />';
				echo '</form>';
			?>
			</div>

			<?php if ($depth >= 1) echo '<h2>'.$pageObj->post_title.'</h2>'; ?>

			<?php 
				$video = get_field('video_code', $pageObj->ID);
				$video = html_entity_decode($video);
				$videoLoc = get_field('video_position', $pageObj->ID);
				if($video != '' && $videoLoc == 'above') {
					echo '<div class="video-holder">'.$video.'</div>';
				}
				
				if($videoLoc == 'in') {
					function shortcode_video() {
						$video = get_field('video_code', $pageObj->ID);
						$video = html_entity_decode($video);
						$video = '<p><div class="video-holder">'.$video.'</div></p>';
						return $video;
					}
					add_shortcode('video', 'shortcode_video');
				}

				echo apply_filters('the_content', $pageObj->post_content); 

				if($video != '' && $videoLoc == 'below') {
					echo '<div class="video-holder">'.$video.'</div>';
				}

				$download = get_field('download_file');
				$downloadText = get_field('download_text');
				if($downloadText == '') $downloadText = 'Download';
				if($download != '') {
					echo '<p><a class="button-label" href="'.$download.'" title="'.$downloadText.'">'.$downloadText.'</a></p>';
				}


				/********************
				 * CTA
				 ********************/
				$cta = get_field('page_cta_footer', $pageObj->ID);

				if($cta != '') {
					$post = get_field('cta_code', $cta->ID, false);
					echo '<div class="widget-holder">';
					echo $post;
					echo '</div>';
				}
			?>

			<div class="form-box">
			<?php if($pageObj->ID != 103) { ?>
				<div class="form-box-header">Request a demo or get in touch<br />for more information</div>
				<?php  echo get_field('cta_code', 297, false); ?>
			<?php } else { ?>
				<div class="form-box-header">Register your interest in a role at Roames – to be part of our team</div>
				<?php  echo get_field('cta_code', 357, false); ?>
			<?php } ?>
			</div>
		</article>

		<div class="col-left">
		<?php
			$navigation = '';
			$navigation .= '<ul class="menu">';
			foreach($nav as $navItem) {

				$count++;

				// $subnav = get_pages(array('parent' => $navItem->ID, 'sort_order' => 'asc', 'sort_column' => 'menu_order'));
				// if(sizeof($subnav) > 0) {
					
				// 	$navigation .= '<li class="header">';
				// 	$navigation .= '<a '.(($pageObj->ID == $navItem->ID) ? 'class="active"' : '').' href="'.get_permalink($navItem->ID).'">'.$navItem->post_title.'</a></li>';

				// 	foreach($subnav as $subnavItem) {
				// 		$navigation .= '<li>';
				// 		$navigation .= '<a '.(($pageObj->ID == $subnavItem->ID) ? 'class="active"' : '').' href="'.get_permalink($subnavItem->ID).'">'.$subnavItem->post_title.'</a></li>';
				// 	}
				// } else {
					$navigation .= '<li>';
					$navigation .= '<a '.(($pageObj->ID == $navItem->ID) ? 'class="active"' : '').' href="'.get_permalink($navItem->ID).'">'.$navItem->post_title.'</a></li>';
				//}
			}
			$navigation .= '</ul>';
			echo $navigation;

			/********************
			 * CTA
			 ********************/
			$cta = get_field('page_cta', $pageObj->ID);

			if($cta != '') {
				$post = get_field('cta_code', $cta->ID, false);
				echo '<div class="widget-holder">';
				echo $post;
				echo '</div>';
			}


		?>


			
		</div>
	</div>

<?php get_footer(); ?> 