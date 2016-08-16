<?php
	global $headerInclude, $post, $pageObj, $template;
	$pageObj = $post;
	$template = get_current_template();
	$template = substr($template, 0, stripos($template, '.'));
	$template = str_replace('template-', '', $template);



	if($pageObj->ID != 8 && $pageObj->ID != 6)
		$pageTitle = $pageObj->post_title;
	else 
		$pageTitle = get_bloginfo( 'name' );
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<link rel="shortcut icon" type="image/x-icon" href="assets/images/Fugro-favicon.ico" />
<title><?php echo $pageTitle; ?></title>
<base href="/wp-content/themes/roames2016/" />
<link rel="stylesheet" href="assets/css/style.css">
<?php echo $headerInclude; ?>
<?php wp_head(); ?>
</head>
<body id="<?php echo $template; ?>">

    <header>
		<div class="logo"><a href="/" title="Go to Homepage"><img src="assets/images/fugrow-roames-logo.gif" /></a></div>
		<div class="logo-mask"></div>

		<nav class="main">
			<div class="demo-link">Request a Demo</div>
			<?php
				
    			$nav = wp_get_nav_menu_items('header');

				$navigation = '';
				$subnavArray = array();
				for($i=0; $i<sizeof($nav); $i++) {
	    			$navPage = get_field('_menu_item_object_id', $nav[$i]->ID);
					$navPage = get_post($navPage);

					if($navPage->ID != 8) {
						$args = array('parent' => $navPage->ID, 'sort_order' => 'asc', 'sort_column' => 'menu_order');
						$subnav = get_pages($args);
						if(sizeof($subnav) > 0) {
							$navigationSub = '';
							$navigationSub .= '<ul id="nav'.$navPage->ID.'" style="display:none;">';
							$count = 0;
							foreach($subnav as $navItem) {
								$count++;

								$subnav = get_pages(array('parent' => $navItem->ID, 'sort_order' => 'asc', 'sort_column' => 'menu_order'));
								if(sizeof($subnav) > 0) {
									
									if(substr($navigationSub, -5) == '</li>')
										$navigationSub .= '</ul><ul>';
									else if(substr($navigationSub, -4) != '<ul>')
										$navigationSub .= '<ul>';
									$navigationSub .= '<li class="header"><a href="'.get_permalink($navItem->ID).'">'.$navItem->post_title.'</a></li>';

									foreach($subnav as $subnavItem) {
										$navigationSub .= '<li><a href="'.get_permalink($subnavItem->ID).'">'.$subnavItem->post_title.'</a></li>';
									}
									$navigationSub .= '</ul>';
								} else {
									$navigationSub .= '<li><a href="'.get_permalink($navItem->ID).'">'.$navItem->post_title.'</a></li>';
								}
							}
							$navigationSub .= '</ul>';
							$navigation .= $navigationSub;
							$subnavArray[$nav[$i]->ID] = $navigationSub;
						}
					}
				}
    			if(sizeof($nav) > 0) {
                    echo '<ul>';
    				for($i=0; $i<sizeof($nav); $i++) {
    					$navPage = get_field('_menu_item_object_id', $nav[$i]->ID);
    					$navPage = get_post($navPage);

    					if(has_children($navPage->ID) && $navPage->ID != 8) {
    						echo '<li class="nested">';
							echo '<a onclick="return false;" ';
    					} else {
    						echo '<li><a ';
    					}
    					// echo '<li'.((has_children($navPage->ID) && $navPage->ID != 8) ? ' class="nested"' : '').'>';

    					// echo '<a'.((has_children($navPage->ID) && $navPage->ID != 8) ? ' onclick="return false;"' : '').' ';
    					if($navPage->ID == 59)
    						echo 'id="login" target="_blank" ';
    					if($pageObj->ID == $navPage->ID)
    						echo 'class="active" ';
    					echo 'href="'.get_permalink($navPage->ID).'" rel="'.$navPage->ID.'" title="Go to '.$navPage->post_title.'">'.$nav[$i]->title.'</a>';
    					if(isset($subnavArray[$nav[$i]->ID]))
    						echo str_replace('<ul', '<ul class="subnav" ', $subnavArray[$nav[$i]->ID]);
    					echo '</li>';
	    			}
    				echo '</ul>';
	    		}
    		?>
		</nav>

		<div class="dropdown">
		<?php
			echo $navigation;
		?>
		</div>

		<div class="nav-mobile">j</div>
	</header>