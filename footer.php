<?php
wp_reset_query();
/**
 * The template for displaying the footer
 *
 * Contains footer content and the closing of the #main and #page div elements.
 *
 * @package WordPress
 * @subpackage Nipate
 * @since Nipate 1.0
 */
?>
<?php
if( is_active_sidebar( 'fre-footer-1' )    || is_active_sidebar( 'fre-footer-2' )
    || is_active_sidebar( 'fre-footer-3' ) || is_active_sidebar( 'fre-footer-4' )
    )
{$flag=true; ?>
<!-- FOOTER -->
<footer>
	<div class="container">
    	<div class="row">
            <div class="col-md-3 col-sm-6">
                <?php if( is_active_sidebar( 'fre-footer-1' ) ) dynamic_sidebar( 'fre-footer-1' );?>
            </div>
            <div class="col-md-3 col-sm-6">
                <?php if( is_active_sidebar( 'fre-footer-2' ) ) dynamic_sidebar( 'fre-footer-2' );?>
            </div>
            <div class="col-md-3 col-sm-6">
                <?php if( is_active_sidebar( 'fre-footer-3' ) ) dynamic_sidebar( 'fre-footer-3' );?>
            </div>
            <div class="col-md-3 col-sm-6">
                <?php if( is_active_sidebar( 'fre-footer-4' ) ) dynamic_sidebar( 'fre-footer-4' );?>
            </div>
        </div>
    </div>
</footer>
<?php }else{ $flag = false;} ?>
<div class="copyright-wrapper <?php if(!$flag){ echo 'copyright-wrapper-margin-top'; } ?> ">
<?php
    $copyright = ae_get_option('copyright');
    $has_nav_menu = has_nav_menu( 'et_footer' );
    $col = 'col-md-6  col-sm-6';
    if($has_nav_menu) {
        $col = 'col-md-4  col-sm-4';
    }
?>
	<div class="container">
        <div class="row">
            <div class="<?php echo $col ?> ">
            	<a href="<?php echo home_url(); ?>" class="logo-footer"><?php fre_logo('site_logo_white') ?></a>
            </div>
            <?php if($has_nav_menu){ ?>
            <div class="col-md-4  col-sm-4">
                <?php
                    wp_nav_menu( array('theme_location' =>'et_footer') );
                ?>
            </div>
            <?php }?>
            <div class="<?php echo $col;?> ">
            	<p class="text-copyright">
                    <?php
                        if($copyright){ echo $copyright; }
                    ?>
                </p>
            </div>
        </div>
    </div>
</div>

<!-- FOOTER / END -->

<?php

    if(!is_page_template( 'page-auth.php' )){
    	/* ======= modal register template ======= */
    	get_template_part( 'template-js/modal' , 'register' );
    	/* ======= modal register template / end  ======= */
    	/* ======= modal register template ======= */
    	get_template_part( 'template-js/modal' , 'login' );
    	/* ======= modal register template / end  ======= */
    }

	if(is_page_template( 'page-profile.php' )){
    	/* ======= modal add portfolio template ======= */
    	get_template_part( 'template-js/modal' , 'add-portfolio' );
    	/* ======= modal add portfolio template / end  ======= */
	}
	/* ======= modal change password template ======= */
	get_template_part( 'template-js/modal' , 'change-pass' );
	/* ======= modal change password template / end  ======= */

	get_template_part( 'template-js/post' , 'item' );
	get_template_part( 'template-js/project' , 'item' );
	get_template_part( 'template-js/user' , 'bid-item' );
	get_template_part( 'template-js/profile' , 'item' );
	get_template_part( 'template-js/portfolio' , 'item' );
	get_template_part( 'template-js/work-history', 'item' );
	get_template_part( 'template-js/skill' , 'item' );

	if(is_singular('project')){

		get_template_part( 'template-js/bid' , 'item' );
        get_template_part( 'template-js/modal' , 'review');
        get_template_part( 'template-js/modal' , 'bid' );
        get_template_part( 'template-js/modal' , 'accept-bid' );

	}

    if(is_author()){
        get_template_part( 'template-js/author-project' , 'item' );
    }
	//print modal contact template
	if( is_singular( PROFILE ) || is_author() ){
		get_template_part( 'template-js/modal' , 'contact' );
        /* ======= modal invite template ======= */
        get_template_part( 'template-js/modal' , 'invite' );
	}

	/* ======= modal invite template / end  ======= */
    /* ======= modal forgot pass template ======= */
    get_template_part( 'template-js/modal' , 'forgot-pass' );
    /* ======= modal forgot pass template / end  ======= */

    // modal edit project
    if( (get_query_var( 'author' ) == $user_ID && is_author() )
        ||  current_user_can('manage_options') || is_post_type_archive(PROJECT)
        || is_page_template('page-profile.php') || is_singular( PROJECT )
    ){
        get_template_part( 'template-js/modal' , 'edit-project' );
        get_template_part( 'template-js/modal' , 'reject' );
    }

    if(is_singular( PROJECT )) {
        get_template_part( 'template-js/message' , 'item' );
        get_template_part( 'template-js/report' , 'item' );
    }
if(is_page_template( 'page-list-testimonial.php' )) {   
    get_template_part( 'template-js/testimonial' , 'item' );
}
	wp_footer();
?>
<script type="text/template" id="ae_carousel_template">
    <li class="image-item" id="{{= attach_id }}">
        <a href="#"><i class="fa fa-paperclip"></i> {{= name }}</a>
        <a href="" title="<?php _e("Delete", ET_DOMAIN); ?>" class="delete-img delete"><i class="fa fa-times"></i></a>
    </li>
</script>
<!-- MODAL QUIT PROJECT-->
<div class="modal fade" id="quit_project" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <i class="fa fa-times"></i>
                </button>
                <h4 class="modal-title alert-color"><?php _e("Awww! Why quit?", ET_DOMAIN) ?></h4>
                <p class="alert-color">
                    <?php _e("You're going to quit this project, you won't be able to access the workspace anymore.", ET_DOMAIN); ?>
                </p>
            </div>
            <div class="modal-body">
                <form role="form" id="quit_project_form" class="quit_project_form">
                    <div class="form-group">
                        <label for="user_login"><?php _e('Please give us a clear report', ET_DOMAIN) ?></label>
                        <textarea name="comment_content"></textarea>
                    </div>
                    <div class="clearfix"></div>
                    <div class="form-group">
                        <button type="submit" class="btn-submit btn-sumary btn-sub-create">
                            <?php _e('Quit', ET_DOMAIN) ?>
                        </button>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog login -->
</div><!-- /.modal -->
<!--// MODAL QUIT PROJECT-->


<!-- MODAL CLOSE PROJECT-->
<div class="modal fade" id="close_project_success" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <i class="fa fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="content-close-wrapper">
                    <p class="alert-close-text">
                        <?php _e("We will review the reports from both freelancer and employer to give the best decision. It will take 3-5 business days for reviewing after receiving two reports.", ET_DOMAIN) ?>
                    </p>
                    <button type="submit" class="btn btn-ok">
                        <?php _e('OK', ET_DOMAIN) ?>
                    </button>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog login -->
</div><!-- /.modal -->
<!--// MODAL CLOSE PROJECT-->

</body>
</html>
