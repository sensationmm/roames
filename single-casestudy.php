<?php 
get_header();  

$page_banner = get_field('page_banner', $pageObj->ID);
if($page_banner == '') $page_banner = 'assets/images/banner-default-casestudies.jpg';
?>

	<div class="banner" style="background-image:url(<?php echo $page_banner; ?>);">
		<div class="banner-content">
			<h1>Case Studies</h1>
		</div>
	</div>

	<div class="body-article">
		<article>
			<h2><?php echo $pageObj->post_title; ?></h2>
			<?php 
				echo apply_filters('the_content', $pageObj->post_content);

				$pdfDownload = get_field('casestudies_download', $pageObj->ID, false);
				if($pdfDownload != '') {
					echo '<div class="form-box">';
					echo '<div class="form-box-header">Download the full case study</div>';
					echo $pdfDownload;
					echo '</div>';
				}

			?>

			<div class="similar-header">More case studies</div>
			<ul class="similar">
			<?php
				$args = array('post_type' => 'casestudy', 'posts_per_page' => 5, 'orderby' => 'post_date', 'order' => 'desc', 'exclude' => $pageObj->ID);
				$casestudies = get_posts($args);

				if(sizeof($casestudies) > 0) {
					foreach($casestudies as $casestudy) {
						echo '<li><a href="'.get_permalink($casestudy->ID).'">'.$casestudy->post_title.'</a></li>';
					}
				} else {
					echo '<li>No case studies to display</li>';
				}
		    ?>
			</ul>

			<?php
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
			
		</article>

	</div>

	<?php get_footer(); ?>