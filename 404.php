<?php
/**
 * @package WordPress
 * @subpackage Roames 2016
 * Template Name: 404 Error Page
*/

get_header();  

$page_banner = get_field('page_banner', $pageObj->ID);
if($page_banner == '') $page_banner = 'assets/images/banner-default.jpg';
?>

    <div class="banner" style="background-image:url(<?php echo $page_banner; ?>);">
        <div class="banner-content">
            <h1>Not Found!</h1>
        </div>
    </div>

    <div class="body-content">
        <article class="col-main">
                <h2>Sorry</h2>
                <p>The page you are looking for may have moved or been deleted.</p>
                <p>Try using the navigation above, or click the button below to return to the homepage.</p>
        </article>

            
    </div>
</div>

<?php get_footer(); ?> 