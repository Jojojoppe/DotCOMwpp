<?php

get_header(); ?>

    <main id="main" <?php auxin_content_main_class(); ?> >
        <div class="aux-wrapper">
            <div class="aux-container aux-fold">

                <?php
                
                    $cat = get_the_category(); $cats = get_the_category();
                    $catnames = [];
                    foreach($cats as $cat){
                        array_push($catnames, $cat->cat_name);
                    }
                    if(in_array('shows', $catnames) or in_array('shows-archive', $catnames)){
                        ob_start();
                        if ( ! ( function_exists( 'auxin_theme_do_location' ) && auxin_theme_do_location( 'single' ) ) && ! ( function_exists( 'elementor_theme_do_location' ) && elementor_theme_do_location( 'single' ) ) ) {
                            $is_pass_protected = post_password_required();
    
                            if ( have_posts() && ! $is_pass_protected ) {
                                get_template_part('templates/theme-parts/single', get_post_type() );
                                comments_template( '/comments.php', true );
                            } elseif( $is_pass_protected ) {
                                echo get_the_password_form();
                            } else {
                                get_template_part('templates/theme-parts/content', 'none' );
                            }
                        }   
                        $postcontent = ob_get_contents();
                        ob_end_clean();                     

                        $p_title = get_string_between($postcontent, "{TITLE}", "{/TITLE}");
                        $p_desc = get_string_between($postcontent, "{DESCLONG}", "{/DESCLONG}");
                        $p_when = get_string_between($postcontent, "{WHEN}", "{/WHEN}");
                        $p_where = get_string_between($postcontent, "{WHERE}", "{/WHERE}");
                        $p_lang = get_string_between($postcontent, "{LANG}", "{/LANG}");
                        $p_price = get_string_between($postcontent, "{PRICE}", "{/PRICE}");
                        $p_gallery = get_string_between($postcontent, "{GALLERY}", "{/GALLERY}");
                        $p_banner = get_string_between($postcontent, "{BANNER}", "{/BANNER}");
                        $p_resexc = get_string_between($postcontent, "{RESERVE_EXCLUDE}", "{/RESERVE_EXCLUDE}");
                        
                        $banner = substr($p_banner, strpos($p_banner, 'src="')+5);
                        $banner = substr($banner, 0, strpos($banner, '"'));

                        $dates = preg_split('/ (-|=) /', $p_when);
                        if($p_resexc!=""){
                            $resexc = preg_split('/ (-|=) /', $p_resexc);
                        }else{
                            $resexc = [];
                        }
                ?>
                
                <div id="primary" class="aux-primary" style="padding-top: 0 !important;">
                    <div class="content" role="main"  >
                        <div class="wp-block-image top-image">
                            <figure class="aligncenter size-full">
                                <img loading="lazy" src="<?php echo $banner; ?>" alt="" class="wp-image-241" srcset="<?php echo $banner; ?> 1000w" sizes="(max-width: 1000px) 100vw, 1000px" width="1000" height="300">
                            </figure>
                        </div>
                        <div class="wp-block-nk-awb nk-awb alignfull skewed-purple nk-awb-1gzeUS">
                            <div class="nk-awb-wrap nk-awb-rendered" data-awb-type="color" style="margin-left: -268.483px; margin-right: -280.5px;">
                            <div class="nk-awb-overlay" style="background-color: #660066;">
                        </div>
                    </div>
                    <div class="wp-block-nk-awb nk-awb in-skewed-purple nk-awb-1QgPRm">
                        <div class="wp-block-columns">
                            <div class="wp-block-column" style="flex-basis:66.66%">
                                <br><h2><?php echo $p_title; ?></h2>
                                <p><?php echo $p_desc; ?></p>
                            </div>
                            <div class="wp-block-column" style="flex-basis:33.33%">
                                <div class="wp-block-group has-background" style="background-color:#d6c2d6">
                                    <div class="wp-block-group__inner-container" style="color: black; margin-left: 0.5em;">
                                        <h5 style="margin-bottom: 0 !important;">When</h5><p style="margin-left: 1em;"><?php 
                                        foreach($dates as $d){ 
                                            //echo $d."<br>";
                                            echo date("F jS Y - H:i", strtotime($d))."<br>";
                                        } 
                                        ?></p>
                                        <h5 style="margin-bottom: 0 !important;">Where</h5><p style="margin-left: 1em;"><?php echo $p_where; ?></p>
                                        <h5 style="margin-bottom: 0 !important;">Price</h5><p style="margin-left: 1em;"><?php echo $p_price; ?></p>
                                        <h5 style="margin-bottom: 0 !important;">Language</h5><p style="margin-left: 1em;"><?php echo $p_lang; ?></p>
                            </div></div></div></div></div></div>
                            <div style="height:100px" aria-hidden="true" class="wp-block-spacer"></div>
                                <p><?php echo $p_gallery; ?></p>
                            <div style="height:100px" aria-hidden="true" class="wp-block-spacer"></div>
                        </div>
                       
                        <?php
                        if(in_array('shows', $catnames) && count($resexc)==0){
                        ?>
                        <div class="RESERVEBUTTON">
                            <div class="wp-block-buttons aligncenter">
                                <div class="wp-block-button">
                                    <a class="wp-block-button__link" href="/shows/reserve-tickets">RESERVE TICKETS</a><br>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                    </div><!-- end content -->
                </div><!-- end primary -->

                <?php get_sidebar(); ?>
                
                <?php }else{ ?>

                <div id="primary" class="aux-primary">
                    <div class="content" role="main"  >
                        <?php
                        if ( ! ( function_exists( 'auxin_theme_do_location' ) && auxin_theme_do_location( 'single' ) ) && ! ( function_exists( 'elementor_theme_do_location' ) && elementor_theme_do_location( 'single' ) ) ) {
                            $is_pass_protected = post_password_required();

                            if ( have_posts() && ! $is_pass_protected ) {
                                get_template_part('templates/theme-parts/single', get_post_type() );
                                comments_template( '/comments.php', true );
                            } elseif( $is_pass_protected ) {
                                echo get_the_password_form();
                            } else {
                                get_template_part('templates/theme-parts/content', 'none' );
                            }
                        }
                        ?>
                    </div><!-- end content -->
                </div><!-- end primary -->
                
                <?php } ?>


            </div><!-- end container -->
        </div><!-- end wrapper -->
    </main><!-- end main -->

<?php get_sidebar('footer'); ?>
<?php get_footer(); ?>