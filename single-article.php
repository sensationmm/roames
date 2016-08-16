<?php 
get_header();  

$page_banner = get_field('page_banner', $pageObj->ID);
if($page_banner == '') $page_banner = 'assets/images/banner-default-articles.jpg';
?>

	<div class="banner" style="background-image:url(<?php echo $page_banner; ?>);">
		<div class="banner-content">
			<h1>Articles</h1>
		</div>
	</div>

	<div class="body-article">
		<article>
			<h2><?php echo $pageObj->post_title; ?></h2>
			<p class="author">By <?php $author = get_userdata($pageObj->post_author); echo $author->first_name.' '.$author->last_name; ?>. If you like this article, click <span class="newsletter-popup">here</span> to get more like it sent to your email.</p>
			<?php
				$image = wp_get_attachment_image(get_post_thumbnail_id($article->ID), 'large', false, array('class'=>'banner','style'=>'height:auto;'));
				if($image != '') {
					// echo '<a href="'.get_permalink($article->ID).'" alt="Read more"><img class="banner" src="'.$image.'" /></a>';
					echo '<a href="'.get_permalink($article->ID).'" alt="Read more">'.$image.'</a>';
				}

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

			<div class="similar-header">Similar articles</div>
			<ul class="similar">
			<?php
			    $tags = wp_get_post_tags($pageObj->ID);
			     
			    if ($tags) {
				    $tag_ids = array();
				    foreach($tags as $individual_tag) $tag_ids[] = $individual_tag->term_id;
					    $args=array(
					    'tag__in' => $tag_ids,
					    'post__not_in' => array($post->ID),
					    'posts_per_page'=>5, // Number of related posts to display.
					    'caller_get_posts'=>1
				    );
				     
				    $my_query = new wp_query( $args );
				 	
				 	if($my_query->has_posts()) {
					    while( $my_query->have_posts() ) {
						    $my_query->the_post();

						    echo '<li><a href="'.get_permalink(the_ID()).'">'; the_title(); echo '</a></li>';
					    }
					} else {
						echo '<li>No similar articles to display</li>';
					}
			    } else {
					echo '<li>No similar articles to display</li>';
				}
			    $post = $orig_post;
			    wp_reset_query();
		    ?>
			</ul>


			<div class="sharer">
				<?php
                    $title = urlencode($pageObj->post_title);
                    $link = urlencode(get_permalink($pageObj->ID));
                ?>

                <a onclick="return ss_plugin_loadpopup_js(this);" rel="external nofollow" class="ss-button-facebook" href="http://www.facebook.com/sharer/sharer.php?u=<?php echo $link; ?>" target="_blank" style="text-indent:-1000px;overflow:hidden;" title="Share on Facebook"><img src="assets/images/social-facebook.gif" /></a>

                <a onclick="return ss_plugin_loadpopup_js(this);" rel="external nofollow" class="ss-button-twitter" href="http://twitter.com/intent/tweet/?text=<?php echo $title; ?>&amp;url=<?php echo $link; ?>" target="_blank" style="text-indent:-1000px;overflow:hidden;" title="Share on Twitter"><img src="assets/images/social-twitter.gif" /></a>

                <a onclick="return ss_plugin_loadpopup_js(this);" rel="external nofollow" class="ss-button-linkedin" href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo $link; ?>&amp;title=<?php echo $title; ?>" target="_blank" style="text-indent:-1000px;overflow:hidden;" title="Share on Linkedin"><img src="assets/images/social-linkedin.gif" /></a>

			</div>
			
		</article>

	</div>

	<?php get_footer(); ?>