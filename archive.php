<?php
/**
 * The archive template file
 *
 * This is the most generic template file in a WordPress theme and one
 * of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query,
 * e.g., it puts together the home page when no home.php file exists.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Nipate
 * @since Nipate 1.0
 */
	get_header();
?>
<div class="container">
	<!-- block control  -->
	<div class="row block-posts" id="post-control">
		<div class="col-md-9 col-sm-12 col-xs-12 posts-container" id="posts_control">
		<?php
			if(have_posts()){
				get_template_part( 'list', 'posts' );
			} else {
				echo '<h2>'.__( 'There is no posts yet', ET_DOMAIN ).'</h2>';
			}
		?>
		</div><!-- LEFT CONTENT -->
		<div class="col-md-3 col-sm-12 col-xs-12" >
			<?php get_sidebar('blog'); ?>
		</div><!-- RIGHT CONTENT -->
	</div>
	<!--// block control  -->
</div>
<?php
	get_footer();
?>
