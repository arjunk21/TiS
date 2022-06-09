<?php
function side_buttons() { $blog_id = get_current_blog_id();
   if ( 1 == $blog_id ) {
    } else { ?>

<div class="side-buttons">
        <a class="sb1"><i class="fa fa-concierge-bell" style="font-size:24px"></i> CONCIERGE</a>
        <a class="sb2" href="<?php echo home_url(); ?>/contact-us"><i class="fa fa-envelope" style="font-size:24px"></i>ENQUIRY</a>
        <a class="sb3" href="<?php echo home_url(); ?>/register"><i class="fa fa-pencil" style="font-size:24px"></i>WRITE REVIEW</a>
      </div>

<?php } 
}
add_action( 'wp_footer', 'side_buttons', 100 ); 
?>
