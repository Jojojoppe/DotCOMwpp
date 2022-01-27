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
                ?>
                
                <div id="primary" class="aux-primary" style="padding-top: 0 !important;">
                    <div class="content" role="main"  >
                        
                        <div id="SHOWINFOBLOCK_BASE" class="hidden">
                        <div class="wp-block-image top-image"><figure class="aligncenter size-full"><img loading="lazy" src="{BANNER}" alt="" class="wp-image-241" srcset="{BANNER} 1000w" sizes="(max-width: 1000px) 100vw, 1000px" width="1000" height="300"></figure></div>
                        <div class="wp-block-nk-awb nk-awb alignfull skewed-purple nk-awb-1gzeUS"><div class="nk-awb-wrap nk-awb-rendered" data-awb-type="color" style="margin-left: -268.483px; margin-right: -280.5px;"><div class="nk-awb-overlay" style="background-color: #660066;"></div></div><div class="wp-block-nk-awb nk-awb in-skewed-purple nk-awb-1QgPRm"><div class="wp-block-columns"><div class="wp-block-column" style="flex-basis:66.66%"><br><h2>{TITLE}</h2><p>{DESCLONG}</p></div><div class="wp-block-column" style="flex-basis:33.33%"><div class="wp-block-group has-background" style="background-color:#d6c2d6"><div class="wp-block-group__inner-container" style="color: black; margin-left: 0.5em;">
                            <h5 style="margin-bottom: 0 !important;">When</h5><p style="margin-left: 1em;">{WHEN}</p>
                            <h5 style="margin-bottom: 0 !important;">Where</h5><p style="margin-left: 1em;">{WHERE}</p>
                            <h5 style="margin-bottom: 0 !important;">Price</h5><p style="margin-left: 1em;">{PRICE}</p>
                            <h5 style="margin-bottom: 0 !important;">Language</h5><p style="margin-left: 1em;">{LANG}</p>
                            </div></div></div></div></div></div>
                            <div style="height:100px" aria-hidden="true" class="wp-block-spacer"></div>
                            <p>{GALLERY}</p>
                            <div style="height:100px" aria-hidden="true" class="wp-block-spacer"></div>
                        </div>

                        TEST1233211233211233214DOTCOMWPP
                        
                        <div class="hidden" id="RESERVEBUTTON">
                            <div class="wp-block-buttons aligncenter"><div class="wp-block-button"><a class="wp-block-button__link" href="/shows/reserve-tickets">RESERVE TICKETS</a></div></div>
                        </div>

                        <div id="SHOWINFOBLOCK">
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
                        </div>
                    </div><!-- end content -->
                </div><!-- end primary -->

                <script type="text/javascript">
                    
                    var getStrBetween = function(s, a, b){
                        var start = s.search(a);
                        var end = s.search(b);
                        var res = s.substr(start+a.length, end-start-a.length);
                        return res;
                    };
                    
                    var showinfobaseblock = document.getElementById('SHOWINFOBLOCK_BASE');
                    var showinfoblock = document.getElementById('SHOWINFOBLOCK');
                    
                    var title = getStrBetween(showinfoblock.innerText, "{TITLE}", "{/TITLE}");
                    var desc = getStrBetween(showinfoblock.innerHTML, "{DESCLONG}", "{/DESCLONG}");
                    var when = getStrBetween(showinfoblock.innerText, "{WHEN}", "{/WHEN}");
                    var where = getStrBetween(showinfoblock.innerText, "{WHERE}", "{/WHERE}");
                    var lang = getStrBetween(showinfoblock.innerText, "{LANG}", "{/LANG}");
                    var price = getStrBetween(showinfoblock.innerHTML, "{PRICE}", "{/PRICE}");
                    var bannerdiv = getStrBetween(showinfoblock.innerHTML, "{BANNER}", "{/BANNER}");
                    var banner = bannerdiv.substr(bannerdiv.search('src="')+5);
                    banner = banner.substr(0, banner.search('"'))
                    var gallery = getStrBetween(showinfoblock.innerHTML, "{GALLERY}", "{/GALLERY}");
                    console.log(gallery);
                    
                    var months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
                    when = when.split(" – ");
					console.log(when);
                    var whenstr = "";
                    for(var i=0; i<when.length; i++){
                        var d = new Date(when[i]);
                        var dt = d.getDate()+" "+months[d.getMonth()]+" "+d.getFullYear()+", " + d.getHours()+":"+(d.getMinutes()<10?'0':'') + d.getMinutes();
                        if(i>0){
                            whenstr += "<br>";
                        }
                        whenstr += dt;
                    }
                    
                    showinfoblock.innerHTML = showinfobaseblock.innerHTML;
                    showinfoblock.innerHTML = showinfoblock.innerHTML.replace("{TITLE}", title);
                    showinfoblock.innerHTML = showinfoblock.innerHTML.replace("{DESCLONG}", desc);
                    showinfoblock.innerHTML = showinfoblock.innerHTML.replace("{WHEN}", whenstr);
                    showinfoblock.innerHTML = showinfoblock.innerHTML.replace("{WHERE}", where);
                    showinfoblock.innerHTML = showinfoblock.innerHTML.replace("{LANG}", lang);
                    showinfoblock.innerHTML = showinfoblock.innerHTML.replace("{PRICE}", price);
                    showinfoblock.innerHTML = showinfoblock.innerHTML.replace(/{BANNER}/g, banner);
                <?php if(in_array('shows', $catnames)){?>
                    showinfoblock.innerHTML = showinfoblock.innerHTML.replace("{GALLERY}", document.getElementById("RESERVEBUTTON").innerHTML+"{GALLERY}");
                <?php }?>
                    showinfoblock.innerHTML = showinfoblock.innerHTML.replace("{GALLERY}", gallery);
                </script>

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