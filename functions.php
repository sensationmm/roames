<?php
    
    add_theme_support('menus');
	add_theme_support( 'post-thumbnails' );

	function textdomain_jquery_enqueue() {
	   wp_deregister_script( 'jquery' );
	   wp_register_script( 'jquery', "https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js", false, null );
	   wp_enqueue_script( 'jquery' );
	}

	if ( !is_admin() ) {
	    add_action( 'wp_enqueue_scripts', 'textdomain_jquery_enqueue', 11 );
	}

	add_action( 'init', 'create_post_type');
	function create_post_type() {
		register_post_type( 'event',
			array('labels' => array( 'name' => __( 'Events' ), 'singular_name' => __( 'Event' )),
		  		'public' => true, 
		  		'has_archive' => true, 
		  		'menu_position' => 5, 
		  		'taxonomies' => array('post_tag'),
		  		'supports' => array('title','editor','author','thumbnail','excerpt'))
		);
		register_post_type( 'casestudy',
			array('labels' => array( 'name' => __( 'Case Studies' ), 'singular_name' => __( 'Case Study' )),
		  		'public' => true, 
		  		'has_archive' => true, 
		  		'menu_position' => 5, 
		  		'taxonomies' => array('post_tag'),
		  		'supports' => array('title','editor','author','thumbnail','excerpt'))
		);
		register_post_type( 'testimonial',
			array('labels' => array( 'name' => __( 'Testimonials' ), 'singular_name' => __( 'Testimonial' )),
		  		'public' => true, 
		  		'has_archive' => true, 
		  		'menu_position' => 5, 
		  		'taxonomies' => array('post_tag'),
		  		'supports' => array('title','editor','author','thumbnail','excerpt'))
		);
		register_post_type( 'client',
			array('labels' => array( 'name' => __( 'Clients' ), 'singular_name' => __( 'Client' )),
		  		'public' => true, 
		  		'has_archive' => true, 
		  		'menu_position' => 5, 
		  		'taxonomies' => array('post_tag'),
		  		'supports' => array('title','editor','author','thumbnail','excerpt'))
		);
		register_post_type( 'whitepaper',
			array('labels' => array( 'name' => __( 'Whitepapers' ), 'singular_name' => __( 'Whitepaper' )),
		  		'public' => true, 
		  		'has_archive' => true, 
		  		'menu_position' => 5, 
		  		'taxonomies' => array('post_tag'),
		  		'supports' => array('title','editor','author','thumbnail','excerpt'))
		);
		register_post_type( 'servicesheet',
			array('labels' => array( 'name' => __( 'Service Sheets' ), 'singular_name' => __( 'Service Sheet' )),
		  		'public' => true, 
		  		'has_archive' => true, 
		  		'menu_position' => 5, 
		  		'taxonomies' => array('post_tag'),
		  		'supports' => array('title','editor','author','thumbnail','excerpt'))
		);
		register_post_type( 'cta',
			array('labels' => array( 'name' => __( 'Calls to Action' ), 'singular_name' => __( 'Call to Action' )),
		  		'public' => true, 
		  		'has_archive' => true, 
		  		'menu_position' => 5, 
		  		'supports' => array('title'))
		);
		register_post_type( 'hubspot',
			array('labels' => array( 'name' => __( 'Hubspot Forms' ), 'singular_name' => __( 'Hubspot Form' )),
		  		'public' => true, 
		  		'has_archive' => true, 
		  		'menu_position' => 5, 
		  		'supports' => array('title'))
		);
		register_post_type( 'contact',
			array('labels' => array( 'name' => __( 'Region Contacts' ), 'singular_name' => __( 'Region Contact')),
		  		'public' => true, 
		  		'has_archive' => true, 
		  		'menu_position' => 5, 
		  		'supports' => array('title'))
		);


		register_taxonomy( 'events-region',array('event'),array('hierarchical'=>true,'label'=>'Regions','query_var'=>true,'rewrite'=>true));
		register_taxonomy( 'casestudies-region',array('casestudy'),array('hierarchical'=>true,'label'=>'Regions','query_var'=>true,'rewrite'=>true));

		$result = add_role(
		    'oilgasuser',
		    __( 'Oil & Gas' ),
		    array('read' => true, 
		    	  'edit_posts' => false, 
		    	  'edit_pages' => true,
			      'edit_others_pages' => 1,
			      'edit_published_pages' => 1,
			      'publish_pages' => 0
		    )
		);
	}

	add_filter( 'template_include', 'var_template_include', 1000 );
	function var_template_include( $t ){
	    $GLOBALS['current_theme_template'] = basename($t);
	    return $t;
	}

	/*
	* get current page template
	* $echo: (bool) echo or return value
	*/
	function get_current_template( $echo = false ) {
	    if( !isset( $GLOBALS['current_theme_template'] ) )
	        return 'false';
	    if( $echo )
	        echo $GLOBALS['current_theme_template'];
	    else
	        return $GLOBALS['current_theme_template'];
	}

	/*
	 * Test if page has children
	 */
	function has_children($postID) {
	    global $post;

	    $children = get_pages( array( 'child_of' => $postID ) );
	    if( count( $children ) == 0 ) {
	        return false;
	    } else {
	        return true;
	    }
	}

	/*
	 * Function to restrict all but oil and gas page access from oil and gas user group
	 */
	function exclude_pages_from_admin($query) {

	if($query->is_admin) {

		$caps = get_user_meta(get_current_user_id(), 'roames_capabilities', true);
		$roles = array_keys((array)$caps);
		if(in_array('oilgasuser', $roles) ){

			remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
	        remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' );
	        remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );
	        remove_meta_box( 'dashboard_secondary', 'dashboard', 'normal' );
	        remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
	        remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'side' );
	        remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
	        remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );
	        remove_meta_box( 'dashboard_activity', 'dashboard', 'normal');//since 3.8
			remove_meta_box( 'wpseo-dashboard-overview', 'dashboard', 'side' );
			remove_meta_box( 'wpseo-dashboard-overview', 'dashboard', 'side' );

			remove_menu_page( 'index.php' ); //dashboard

			$oilgas = get_pages(array('parent'=>34));
			$ids = array('34');
			foreach($oilgas as $page) {
				$ids[] = $page->ID;
			}
			$query->query_vars['post__in'] = $ids;

			global $pagenow;

			if( get_the_ID() != '' & !in_array(get_the_ID(), $ids) && $pagenow != 'post-new.php') {
				wp_redirect(admin_url());
			}
		}
	}
	return $query;
}
add_filter('parse_query', 'exclude_pages_from_admin',99);

?>