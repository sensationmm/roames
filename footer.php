
<div style-"clear:both;"></div>
	<footer>
		<div class="footer-content footer-content-custom">
			<div class="footer-section footer-section-custom awards-custom">
				<div class="awards-header">Industry recognition</div>
				<div class="awards-img">
					<?php
						if( have_rows('home_recognition', 6) ):
							while ( have_rows('home_recognition', 6) ) : the_row();
					            $logo = get_sub_field('home_recognition_logo', 6);
					            $name = get_sub_field('home_recognition_name', 6);
								echo '<div class="award"><img class="awards" src="'.$logo.'" alt="'.$name.'" /></div>';
					        endwhile;
					    endif;
				    ?>
			    </div>
			</div>

			<div class="footer-section footer-section-custom">
				<div class="footer-col">
					<ul>
					<li class="header">Roames Platform</li>
					<?php
						$pages = get_pages(array('parent' => 8, 'orderby' => 'menu_order', 'order' => 'asc'));
						foreach($pages as $page) {
							echo '<li><a href="'.get_permalink($page->ID).'" title="Go to '.$page->post_title.'">'.$page->post_title.'</a></li>';
						}
					?>
					</ul>
				</div>
				
				<div class="footer-col">
					<ul>
					<li class="header">Industries</li>
					<?php
						$pages = get_pages(array('parent' => 20, 'orderby' => 'menu_order', 'order' => 'asc'));
						foreach($pages as $page) {
							echo '<li><a href="'.get_permalink($page->ID).'" title="Go to '.$page->post_title.'">'.$page->post_title.'</a></li>';
						}
					?>
					</ul>
				</div>
				
				<div class="footer-col">
					<ul>
					<li class="header">Publications</li>
					<?php
						$pages = get_pages(array('parent' => 51, 'orderby' => 'menu_order', 'order' => 'asc'));
						foreach($pages as $page) {
							echo '<li><a href="'.get_permalink($page->ID).'" title="Go to '.$page->post_title.'">'.$page->post_title.'</a></li>';
						}
					?>
					</ul>
				</div>
				
				<div class="footer-col">
					<ul>
					<li class="header">About Us</li>
					<?php
						$pages = get_pages(array('parent' => 55, 'orderby' => 'menu_order', 'order' => 'asc'));
						foreach($pages as $page) {
							echo '<li><a href="'.get_permalink($page->ID).'" title="Go to '.$page->post_title.'">'.$page->post_title.'</a></li>';
						}
					?>
					</ul>
				</div>
				
				<div class="footer-col">
					<ul>
					<li>&nbsp;</li>
					<?php
		    			$nav = wp_get_nav_menu_items('footer');
		    			if(sizeof($nav) > 0) {
		    				for($i=0; $i<sizeof($nav); $i++) {
		    					$navPage = get_field('_menu_item_object_id', $nav[$i]->ID);
		    					$navPage = get_post($navPage);

		    					echo '<li><a href="'.get_permalink($navPage->ID).'" title="Go to '.$navPage->post_title.'">'.$nav[$i]->title.'</a>';
		    					echo '</li>';
			    			}
			    		}
		    		?>
					</ul>
				</div>
			</div>

			<div class="social-header">Follow Us</div>
			<?php
				$facebook = get_field('social_facebook', 6);
				$twitter = get_field('social_twitter', 6);
				$linkedin = get_field('social_linkedin', 6);
				$youtube = get_field('social_youtube', 6);

				if($linkedin != '') echo '<a class="social-icon" href="'.$linkedin.'" target="_blank"><img src="assets/images/social-linkedin.png" alt="LinkedIn" /></a>';
				if($youtube != '') echo '<a class="social-icon" href="'.$youtube.'" target="_blank"><img src="assets/images/social-youtube.png" alt="YouTube" /></a>';
				if($twitter != '') echo '<a class="social-icon" href="'.$twitter.'" target="_blank"><img src="assets/images/social-twitter.png" alt="Twitter" /></a>';
				if($facebook != '') echo '<a class="social-icon" href="'.$facebook.'" target="_blank"><img src="assets/images/social-facebook.png" alt="Facebook" /></a>';
			?>

			<div class="copyright">
				<a href="http://www.fugro.com" target="_blank" title="Visit Fugro website"><img class="logo" src="assets/images/fugro-logo.gif" alt="Fugro" /></a>
				&copy; Fugro Roames 2016
			</div>
		</div>
	</footer>	

	<div class="overlay">
		<div class="overlay-content">
			<div class="overlay-content-inner" id="popup-demo">
				<div class="overlay-header">request a demo</div>
				<p>The best way to experience our platform is to see it for yourself. Request a free demo to view the platform's benefits in real time.</p>
				<?php  echo get_field('cta_code', 310, false); ?>
			</div>
			<div class="overlay-content-inner" id="popup-newsletter">
				<div class="overlay-header">join our newsletter</div>
				<p>Subscribe to our newsletter to receive more of the articles you like.</p>
				<?php  echo get_field('cta_code', 377, false); ?>
			</div>
			<div class="overlay-close">d</div>
		</div>

		<div class="overlay-mask"></div>
	</div>
	
	<script src="assets/js/app.min.js"></script>

    <?php wp_footer(); ?>

    <!-- Start of Async HubSpot Analytics Code -->
	<script type="text/javascript">
	(function(d,s,i,r) {
	 if (d.getElementById(i)){return;}
	 var n=d.createElement(s),e=d.getElementsByTagName(s)[0];
	 n.id=i;n.src='//js.hs-analytics.net/analytics/'+(Math.ceil(new Date()/r)*r)+'/2017084.js';
	 e.parentNode.insertBefore(n, e);
	})(document,"script","hs-analytics",300000);
	</script>
	<!-- End of Async HubSpot Analytics Code -->

    <!-- Start of Google Analytics Code -->
	<script>
	(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function()
	{ (i[r].q=i[r].q||[]).push(arguments)}
	,i[r].l=1*new Date();a=s.createElement(o),
	m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
	ga('create', 'UA-81603101-1', 'auto');
	ga('send', 'pageview');
	</script>
    <!-- End of Google Analytics Code -->

</body>
</html>