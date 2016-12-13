<?php
/**
 * Template Name: Full Width
 *
 * This is the template that displays all pages with using visual composer to edit it
 *
 * @package WordPress
 * @subpackage Nipate
 * @since Nipate 1.0
 */

get_header();

if(have_posts()) { the_post();
	//the_title();
 ?>
<div class="fre_container">
	
	<?php the_content(); ?>
		
</div>

<?php

}
get_footer();
