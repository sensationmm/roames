<?php 
/**
 * @package WordPress
 * @subpackage Roames 2016
 * Template Name: Blog
*/
get_header();  

$page_banner = get_field('page_banner', $pageObj->ID);
if($page_banner == '') $page_banner = 'assets/images/banner-default-articles.jpg';
?>

	<div class="banner" style="background-image:url(<?php echo $page_banner; ?>);">
		<div class="banner-content">
			<h1>Articles</h1>
		</div>
	</div>

	<div class="body-content">
		<div class="col-main">

		<div class="tags-mobile">
				Filter by <b>Tags</b>:
			<div class="tags"><?php wp_tag_cloud('smallest=12&largest=12'); ?></div>
		</div>
		
		<?php
			$term_id = get_queried_object()->term_id;
			if($term_id != '') {
				$args = array('post_type' => 'post', 'posts_per_page' => 5, 'tax_query' => array(array('taxonomy' => 'post_tag', 'field' => 'id', 'terms' => $term_id)));
			} else {
				$args = array('post_type' => 'post', 'posts_per_page' => 5);
			}
			$articles = get_posts($args);
 			$repeaterExclude = '';

			if(sizeof($articles) > 0) {
				foreach($articles as $article) {
					echo '<article class="blog-article">';
						echo '<h2><a href="'.get_permalink($article->ID).'" alt="Read more">'.$article->post_title.'</a></h2>';
						
						// $image = wp_get_attachment_url( get_post_thumbnail_id($article->ID) );
						$image = wp_get_attachment_image(get_post_thumbnail_id($article->ID), 'large', false, array('class'=>'banner','style'=>'height:auto;'));
						if($image != '') {
							// echo '<a href="'.get_permalink($article->ID).'" alt="Read more"><img class="banner" src="'.$image.'" /></a>';
							echo '<a href="'.get_permalink($article->ID).'" alt="Read more">'.$image.'</a>';
						}
						if($article->post_excerpt != '')
							echo apply_filters('the_content', $article->post_excerpt);
						else 
							echo apply_filters('the_content', substr(strip_tags($article->post_content), 0, 200).'...');
						echo '<p><a class="button-label" href="'.get_permalink($article->ID).'" alt="Read more">Continue reading</a></p>';
					echo '</article>';

					$repeaterExclude .= $article->ID.',';
				}
			} else {
				echo '<div class="no-results"><h2>Sorry!</h2><p>There are no articles to display for that tag</p></div>';
			}

			echo do_shortcode('[ajax_load_more post_type="post" repeater="default" posts_per_page="5" transition="fade" button_label="Load More Articles" scroll="false" pause="true" post__not_in="'.$repeaterExclude.'"]');
		?>
			<!--div class="button button-center">Load more</div-->
		</div>

		<div class="col-left">
			Filter by <b>Tags</b>:
			<div class="tags">
				<a href="/publications/articles/">All</a>

			<?php
				$tags = get_tags();
				global $wp_query;
				$tagCurrent = get_query_var('tag');
				foreach($tags as $tag) {
					$tag_link = get_tag_link( $tag->term_id );
					echo '<a ';
					if($tag->slug == $tagCurrent) echo 'class="active" ';
					echo 'href="'.$tag_link.'" title="View '.$tag->name.' articles">'.ucwords($tag->name).'</a>';
				}
			?>
			</div>

			<?php
			/********************
			 * CTA
			 ********************/
			if($tagCurrent == '')
				$cta = get_field('page_cta', $pageObj->ID);
			else
				$cta = get_field('page_cta', 101);

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