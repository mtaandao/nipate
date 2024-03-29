<?php
/**
 * Template Name: Member Profile Page
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other 'pages' on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage Nipate
 * @since Nipate 1.0
 */
    global $wp_query, $ae_post_factory, $post, $current_user, $user_ID;
    //convert current user
    $ae_users  = AE_Users::get_instance();
    $user_data = $ae_users->convert($current_user->data);    
    $user_role = ae_user_role($current_user->ID);
    //convert current profile
    $post_object = $ae_post_factory->get(PROFILE);
    
    $profile_id = get_user_meta( $user_ID, 'user_profile_id', true);
    
    $profile = array('id' => 0, 'ID' => 0);
    if($profile_id) {
        $profile_post = get_post( $profile_id );
        if($profile_post && !is_wp_error( $profile_post )){
            $profile = $post_object->convert($profile_post);    
        }    
    } 
    
    //get profile skills
    $current_skills = get_the_terms( $profile, 'skill' );
    //define variables:
    $skills         = isset($profile->tax_input['skill']) ? $profile->tax_input['skill'] : array() ; 
    $job_title      = isset($profile->et_professional_title) ? $profile->et_professional_title : '';
    $hour_rate      = isset($profile->hour_rate) ? $profile->hour_rate : '';
    $currency       = isset($profile->currency) ? $profile->currency : '';
    $experience     = isset($profile->et_experience) ? $profile->et_experience : '';
    $hour_rate      = isset($profile->hour_rate) ? $profile->hour_rate : '';
    $about          = isset($profile->post_content) ? $profile->post_content : '';
    $display_name   = $user_data->display_name;
    $user_available = isset($user_data->user_available) && $user_data->user_available == "on" ? 'checked' : '';
    $country        = isset($profile->tax_input['country'][0]) ? $profile->tax_input['country'][0]->name : '' ; 
    $category       = isset($profile->tax_input['project_category'][0]) ? $profile->tax_input['project_category'][0]->slug : '' ;

	get_header();
?>
<section class="section-wrapper <?php if($user_role == FREELANCER) echo 'freelancer'; ?>">
	<div class="number-profile-wrapper">
    	<div class="container">
        	<div class="row">
            	<div class="col-md-12">
                	<h2 class="number-profile"><?php printf(__(" %s's Profile ", ET_DOMAIN), $display_name ) ?></h2>
                    <div class="nav-tabs-profile">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs responsive" role="tablist" id="myTab">
                            <li class="active">
                                <a href="#tab_account_details" role="tab" data-toggle="tab">
                                    <?php _e('Account Details', ET_DOMAIN) ?>
                                </a>
                            </li>
                            <?php if(fre_share_role() || $user_role == FREELANCER){ ?>
                            <li>
                                <a href="#tab_profile_details" role="tab" data-toggle="tab">
                                    <?php _e('Profile Details', ET_DOMAIN) ?>
                                </a>
                            </li>
                            <?php } ?>
                            <li>
                                <a href="#tab_project_details" role="tab" data-toggle="tab">
                                    <?php _e('Project Details', ET_DOMAIN) ?>
                                </a>
                            </li>
                            <?php do_action('fre_profile_tabs'); ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div> 
    <div class="list-profile-wrapper">
    	<div class="container">
        	<div class="row">
            	<div class="col-md-8">
                	<div class="tab-content-profile">
                        <!-- Tab panes -->
                        <div class="tab-content block-profiles responsive">
                            <!-- Tab account details -->
                            <div class="tab-pane fade in active" id="tab_account_details">
                                <div class="row">
                                    <div class="avatar-profile-page col-md-3 col-xs-12" id="user_avatar_container">
                                        <span class="img-avatar image" id="user_avatar_thumbnail">
                                            <?php echo get_avatar($user_data->ID, 125) ?>
                                        </span>
                                        <a href="#" id="user_avatar_browse_button">
                                            <?php _e('Change', ET_DOMAIN) ?>
                                        </a>
                                        <span class="et_ajaxnonce hidden" id="<?php echo de_create_nonce( 'user_avatar_et_uploader' ); ?>">
                                        </span>
                                    </div>
                                    <div class="info-profile-page col-md-9 col-xs-12">
                                        <form class="form-info-basic" id="account_form">
                                            <div class="form-group">
                                            	<div class="form-group-control">
                                                    <label><?php _e('Your Full Name', ET_DOMAIN) ?></label>
                                                    <input type="text" class="form-control" id="display_name" name="display_name" value="<?php echo $user_data->display_name ?>" placeholder="<?php _e('Enter Full Name', ET_DOMAIN) ?>">
                                                </div>
                                            </div>
                                            <div class="clearfix"></div>
                                            <div class="form-group">
                                            	<div class="form-group-control">
                                                	<div class="form-group-control">
                                                        <label><?php _e('Location', ET_DOMAIN) ?></label>
                                                        <input type="text" class="form-control" id="location" name="location" value="<?php echo $user_data->location ?>" placeholder="<?php _e('Enter location', ET_DOMAIN) ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="clearfix"></div>
                                            <div class="form-group">
                                            	<div class="form-group-control">
                                                    <label><?php _e('Email Address', ET_DOMAIN) ?></label>
                                                    <input type="email" class="form-control" id="user_email" name="user_email" value="<?php echo $user_data->user_email ?>" placeholder="<?php _e('Enter email', ET_DOMAIN) ?>">
                                                </div>
                                            </div>
                                            <div class="clearfix"></div>
                                            <?php if(ae_get_option('use_escrow', false)) {
                                                    do_action( 'ae_escrow_recipient_field'); 
                                                } ?>          
                                            <?php if( ae_get_option('pay_to_bid', false) ){ ?>
                                            <div class="form-group">
                                                <div class="form-group-control">
                                                    <label>
                                                        <?php _e('Your Credit number: ', ET_DOMAIN);  ?>
                                                        <?php echo get_user_credit_number( $user_ID ) ; ?>
                                                    </label>                                                   
                                                </div>
                                            </div>                                            
                                            <div class="clearfix"></div>                                            
                                            <?php } ?>
                                            <div class="form-group">
                                                <input type="submit" class="btn-submit btn-sumary" name="" value="<?php _e('Save Details', ET_DOMAIN) ?>">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!--// END ACCOUNT DETAILS -->
                            <!-- Tab profile details -->
                            <?php if(fre_share_role() || $user_role == FREELANCER) { ?>
                            <div class="tab-pane fade" id="tab_profile_details">
                            	<div class="detail-profile-page">
                                	<form class="form-detail-profile-page validateNumVal" id="profile_form">
                                        <div class="form-group">
                                        	<div class="form-group-control">
                                                <label><?php _e('Professional Title', ET_DOMAIN) ?></label>
                                                <input required class="input-item form-control text-field"  type="text" name="et_professional_title"
                                                <?php   if($job_title){
                                                            echo "value= $job_title ";
                                                        }?>
                                                       placeholder="<?php _e("e.g: Wordpress Developer", ET_DOMAIN) ?>">
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                    	<div class="form-group">
                                        	<div class="form-group-control">
                                                <label><?php _e('Your Hourly Rate', ET_DOMAIN) ?></label>
                                                <div class="row">
                                                    <div class="col-xs-8">
                                                        <input required class="input-item form-control text-field"  type="text" name="hour_rate"
                                                               <?php   if($hour_rate){
                                                            echo "value= $hour_rate ";
                                                        }?>  placeholder="<?php _e('e.g:30', ET_DOMAIN) ?>">
                                                    </div>
                                                    <div class="col-xs-4">
                                                        <span class="profile-exp-year">
                                                        <?php $currency = ae_get_option('content_currency'); 
                                                        if($currency){
                                                            echo $currency['code']; 
                                                        }else{ 
                                                            _e('USD', ET_DOMAIN);
                                                        } ?>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="form-group">
                                            <div class="skill-profile-control form-group-control">
                                            	<label><?php _e('Your Skills', ET_DOMAIN) ?></label>
                                                <?php 
                                                $switch_skill = ae_get_option('switch_skill');
                                                if(!$switch_skill){
                                                    ?>
                                                    <input  class="form-control skill" type="text" id="skill" placeholder="<?php _e("Skills (max is 5)", ET_DOMAIN); ?>" name="skill"  autocomplete="off" spellcheck="false" >
                                                    <ul class="skills-list" id="skills_list"></ul>
                                                    <?php
                                                }else{
                                                    $c_skills = array();
                                                    if(!empty($current_skills)){
                                                        foreach ($current_skills as $key => $value) {
                                                            $c_skills[] = $value->term_id;
                                                        };
                                                    }
                                                    ae_tax_dropdown( 'skill' , array(  'attr' => 'data-chosen-width="100%" required data-chosen-disable-search="" multiple data-placeholder="'.__(" Skills (max is 5)", ET_DOMAIN).'"',
                                                                        'class' => 'sw_skill required',
                                                                        'hide_empty' => false, 
                                                                        'hierarchical' => true , 
                                                                        'id' => 'skill' , 
                                                                        'show_option_all' => false,
                                                                        'selected' =>$c_skills
                                                                        ) 
                                                    );
                                                }
                                                
                                                ?>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="form-group">
                                            <div class="profile-category">
                                                <label><?php _e('Category', ET_DOMAIN) ?></label>
                                                <?php 
                                                    ae_tax_dropdown( 'project_category' , 
                                                          array(  
                                                                'attr'            => 'data-chosen-width="100%" data-chosen-disable-search="" data-placeholder="'.__("Choose categories", ET_DOMAIN).'"',
                                                                'class'           => 'chosen multi-tax-item tax-item required cat_profile', 
                                                                'hide_empty'      => false, 
                                                                'hierarchical'    => true , 
                                                                'id'              => 'project_category' , 
                                                                'selected'        => $category,
                                                                'show_option_all' => false
                                                              ) 
                                                    );
                                                ?>
                                            </div>
                                        </div> 
                                        <div class="clearfix"></div>
                                        <div class="form-group">
                                            <div class="form-group-control">
                                                <label><?php _e('Your Country', ET_DOMAIN) ?></label>
                                                <input required class="input-item form-control text-field" type="text" id="country" placeholder="<?php _e("Country", ET_DOMAIN); ?>" name="country"
                                                       <?php if($country){ echo "value=$country"; } ?> autocomplete="off" class="country" spellcheck="false" >
                                            </div>
                                        </div> 
                                        <div class="clearfix"></div>
                                        <div class="form-group about-you">
                                        	<div class="form-group-control row-about-you">
                                                <label><?php _e('About you', ET_DOMAIN) ?></label>
                                                <div class="clearfix"></div>
                                                <textarea class="form-control" name="post_content" id="about_content" cols="30" rows="5"><?php echo esc_textarea(trim($about)) ?></textarea>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="form-group">
                                        	<div class="experience">
                                                <label><?php _e('Your Experience', ET_DOMAIN) ?></label>
                                                <div class="row">
                                                    <div class="col-md-12 fix-width">
                                                        <input class="form-control col-xs-3 number is_number numberVal" step="5" min="1" type="number" name="et_experience" value="<?php echo $experience; ?>" />
                                                        <span class="col-xs-3 profile-exp-year"><?php _e("year(s)", ET_DOMAIN); ?></span>
                                                    </div>
                                                    <div class="col-xs-3">

                                                    </div>
                                                </div>
                                                
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <!--// project description -->
                                        <?php do_action( 'ae_edit_post_form', PROFILE, $profile ); ?>

                                        <div class="form-group portfolios-wrapper"> 
                                        	<div class="form-group-control">

                                                <label><?php _e('Your Portfolio', ET_DOMAIN) ?></label>
                                                <div class="edit-portfolio-container">
                                                    <?php
                                                    // list portfolio
                                                    query_posts( array(
                                                        'post_status' => 'publish',
                                                        'post_type'   => 'portfolio',
                                                        'author'      => $current_user->ID,
                                                        'posts_per_page' => -1
                                                    ));
                                                    get_template_part( 'list', 'portfolios' );
                                                    wp_reset_query();
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="form-group">
                                        	<input type="submit" class="btn-submit btn-sumary" name="" value="<?php _e('Save Details', ET_DOMAIN) ?>">
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <?php } ?>
                            <!--// END PROFILE DETAILS -->
                            <!-- tab project details -->
                            <div class="tab-pane fade" id="tab_project_details">
                                <?php 
                                // list all freelancer current bid
                                if(fre_share_role() || $user_role == FREELANCER){ ?>
                            	<div class="info-project-items">
                                    <h4 class="title-big-info-project-items">
                                        <?php _e("Current bids", ET_DOMAIN) ?>
                                    </h4>
                                    <?php 
                                        query_posts( array(
                                            'post_status' => array('publish', 'accept' ),
                                            'post_type'   => BID, 
                                            'author'      => $current_user->ID, 
                                        ));
                                        
                                        get_template_part( 'list', 'user-bids' );
                                        
                                        wp_reset_query();
                                    ?>
                                </div>
                                <?php 
                                }

                                if(fre_share_role() || $user_role != FREELANCER) {
                                    // employer works history & reviews
                                    get_template_part('template/work', 'history');
                                }
                                    
                                if(fre_share_role() || $user_role == FREELANCER) {
                                    // freelancer bids history and reviews
                                    get_template_part('template/bid', 'history');
                                }
                                ?>                            	
                            </div>
                            <?php do_action('fre_profile_tab_content');?>
                            <!--// END PROJECT DETAILS -->
                        </div>
                    </div>
                </div>
                <!-- profile left bar -->
                <div class="col-md-4">
                	<div class="setting-profile-wrapper <?php echo $user_role; ?>">
                        <?php if($user_role == FREELANCER){ ?>
                    	<div class="form-group">
                            <span class="text-intro">
                                <?php _e("Available for hire?", ET_DOMAIN) ?></span>
                            <span class="switch-for-hide tooltip-style" data-toggle="tooltip" data-placement="top" 
                                title='<?php _e('Turn on to display an "Invite me" button on your profile, allowing potential employers to suggest projects for you.', ET_DOMAIN);  ?>'
                            >
                                <input type="checkbox" <?php echo $user_available; ?> class="js-switch user-available" name="user_available"/>
                                <span class="user-status-text text <?php echo $user_available ? 'yes' : 'no' ?>">
                                    <?php echo $user_available ? __('Yes', ET_DOMAIN) : __('No', ET_DOMAIN); ?>
                                </span>
                            </span>
                        </div>
                        <div class="clearfix"></div>
                        <div class="form-group">
                            <span class="text-small">
                                <?php _e('Select "Yes" to display a "Hire me" button on your profile allowing potential clients and employers to contact you.', ET_DOMAIN) ?>
                            </span>
                        </div>
                        <?php }
                        // display a link for user to request a confirm email
                        if( !AE_Users::is_activate($user_ID) ) {
                         ?>
                        
                        <div class="form-group confirm-request">
                            <span class="text-small">
                                <?php 
                                _e('You have not confirmed your email yet, please check out your mailbox.', ET_DOMAIN);
                                echo '<br/>';
                                echo ' <a class="request-confirm" href="#">' .__( 'Request confirm email.' , ET_DOMAIN ). '</a>';
                                 ?>
                            </span>
                        </div>  
                        <?php } ?>
                        <ul class="list-setting">
                            <?php if(fre_share_role() || $user_role != FREELANCER ) { ?>
                            <li>
                                <a role="menuitem" tabindex="-1" href="<?php echo et_get_page_link("submit-project") ?>" class="display-name">
                                    <i class="fa fa-plus-circle"></i><?php _e("Post a Project", ET_DOMAIN) ?>
                                </a>
                            </li>
                            <?php } ?>
                        	<li>
                                <a href="#" class="change-password">
                                    <i class="fa fa-key"></i>
                                    <?php _e("Change Password", ET_DOMAIN) ?>
                                </a>
                            </li>
                            <?php if(ae_get_option('use_escrow', false)) {
                                do_action( 'ae_escrow_stripe_user_field');
                            } ?>
                            <!-- <li>
                                <a href="#" class="creat-team-link"><i class="fa fa-users"></i><?php _e("Create Your Team", ET_DOMAIN) ?></a>
                            </li> -->
                            <li>
                                <a href="<?php echo wp_logout_url( home_url() ); ?>" class="logout-link">
                                    <i class="fa fa-sign-out"></i>
                                    <?php _e("Log Out", ET_DOMAIN) ?>
                                </a>
                            </li>
                              <!-- HTML to write -->
                        </ul>
                        <div class="widget user_payment_status">
                        <?php ae_user_package_info($user_ID); ?>
                        </div>
                    </div>
                </div>
                <!--// profile left bar -->
            </div>
        </div>
    </div>
    
</section>

<!-- CURRENT PROFILE -->
<?php if($profile_id && $profile_post && !is_wp_error( $profile_post )){ ?>
<script type="data/json" id="current_profile">
    <?php echo json_encode($profile) ?>
</script>
<?php } ?>
<!-- END / CURRENT PROFILE -->

<!-- CURRENT SKILLS -->
<?php if( !empty($current_skills) ){ ?>
<script type="data/json" id="current_skills">
    <?php echo json_encode($current_skills) ?>
</script>
<?php } ?>
<!-- END / CURRENT SKILLS -->

<?php
	get_footer();
?>

