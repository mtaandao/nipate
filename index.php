<?php
/**
 * The main template file
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

<section class="blog-header-container">
	<div class="container">
		<!-- blog header -->
		<div class="row">
		    <div class="col-md-12 blog-classic-top">
		        <h2><?php _e("Blog",ET_DOMAIN) ?></h2>
		        <form id="search-bar" action="<?php echo home_url() ?>">
		            <i class="fa fa-search"></i>
		            <input type="text" name="s" placeholder="<?php _e("Search at blog",ET_DOMAIN) ?>">
		        </form>
		    </div>
		</div>      
		<!--// blog header  -->	
	</div>
</section>

<div class="container">
	<!-- block control  -->
	<div class="row block-posts" id="post-control">
		<div class="col-md-9 posts-container" id="posts_control">
		<?php
			if(have_posts()){
				get_template_part( 'list', 'posts' );
			} else {
				echo '<h2>'.__( 'There is no posts yet', ET_DOMAIN ).'</h2>';
			}
		?>
		</div><!-- LEFT CONTENT -->
		<div class="col-md-3 blog-sidebar" id="right_content">
			<?php get_sidebar('blog'); ?>
		</div><!-- RIGHT CONTENT -->
	</div>
	<!--// block control  -->
</div>
<?php
	get_footer();
?>