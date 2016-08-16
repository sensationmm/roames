<?php 
/**
 * @package WordPress
 * @subpackage Roames 2016
 * Template Name: Panels
*/
get_header();  

$page_banner = get_field('page_banner', $pageObj->ID);
if($page_banner == '') $page_banner = 'assets/images/banner-default.jpg';
?>

	<div class="banner" style="background-image:url(<?php echo $page_banner; ?>);">
		<div class="banner-content">
			<h1>The Roames Platform</h1>
		</div>
	</div>

	<article>
		<div class="body">
		<?php
			$content = $pageObj->post_content;
			echo '<div class="intro">'.apply_filters('the_content', $content).'</div>';

			$args = array('parent' => $pageObj->ID , 'sort_order' => 'asc', 'sort_column' => 'menu_order');
			$sections = get_pages($args);
			echo '<div class="icons">';
			foreach($sections as $section) {
				echo '<div class="icon" rel="panel'.$section->ID.'">';
					$icon = get_field('roames_icon', $section->ID);
					echo '<img src="'.$icon.'" />';
					echo $section->post_title;
				echo '</div>';
			}
			echo '</div>';
		?>
		</div>
	</article>

	<?php
		$count = 0;
		foreach($sections as $section) {
			$count++;
			$image = get_field('roames_image', $section->ID);
			echo '<section class="panel'.(($count%2 == 0) ? ' panel-right' : '').'" id="panel'.$section->ID.'" style="background-image:url('.$image.');">';
				echo '<div class="panel-content">';
					echo '<h2>'.$section->post_title.'</h2>';
					echo '<p>'.get_field('roames_intro', $section->ID).'</p>';
					echo '<a class="button" href="'.get_permalink($section->ID).'">Read more</a>';
				echo '</div>';
			echo '</section>';
		}
	?>

<?php get_footer(); ?> 