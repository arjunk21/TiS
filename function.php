<?php
/*This file is part of TIS.


*/

add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );
function my_theme_enqueue_styles() {
    $parenthandle = 'parent-style'; 
    $theme = wp_get_theme();
    wp_enqueue_style( $parenthandle, get_template_directory_uri() . '/style.css', 
        array(),  // if the parent theme code has a dependency, copy it to here
        $theme->parent()->get('Version')
    );
    wp_enqueue_style( 'child-style', get_stylesheet_uri(),
        array( $parenthandle ),
        $theme->get('Version') // this only works if you have Version in the style header
    );

}
add_action( 'wp_head', 'tis_google_analytics', 10 );
function tis_google_analytics() { ?>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-211435377-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', 'UA-211435377-1');
  gtag('config', 'G-SCYPQ6EJJF');
</script>

<?php }

add_action('admin_head', 'hide_field');
function hide_field() {
  echo '<style>
    .acf-field-61690c025d525, .acf-field-619c5125cd236, .acf-field-615fee977a160 {display: none;}
  </style>';
}
add_filter( 'gform_column_input_3_7_3', 'set_column', 10, 5 );
add_filter( 'gform_column_input_1_7_3', 'set_column', 10, 5 );
function set_column( $input_info, $field, $column, $value, $form_id ) {
    return array( 'type' => 'select', 'choices' => 'Select,Male,Female' );
}

add_filter( 'gform_column_input_3_7_5', 'nationality_form3', 10, 5 );
add_filter( 'gform_column_input_1_7_5', 'nationality_form3', 10, 5 );
function nationality_form3( $input_info, $field, $column, $value, $form_id ) {
    return array( 'type' => 'select', 'choices' => 'Select,Afghan,Albanian,Algerian,American,Andorran,Angolan,Antiguans,Argentinean,Armenian,Australian,Austrian,Azerbaijani,Bahamian,Bahraini,Bangladeshi,Barbadian,Barbudans,Batswana,Belarusian,Belgian,Belizean,Beninese,Bhutanese,Bolivian,Bosnian,Brazilian,British,Bruneian,Bulgarian,Burkinabe,Burmese,Burundian,Cambodian,Cameroonian,Canadian,Cape Verdean,Central African,Chadian,Chilean,Chinese,Colombian,Comoran,Congolese,Congolese,Costa Rican,Croatian,Cuban,Cypriot,Czech,Danish,Djibouti,Dominican,Dominican,Dutch,Dutchman,Dutchwoman,East Timorese,Ecuadorean,Egyptian,Emirian,Equatorial Guinean,Eritrean,Estonian,Ethiopian,Fijian,Filipino,Finnish,French,Gabonese,Gambian,Georgian,German,Ghanaian,Greek,Grenadian,Guatemalan,Guinea-Bissauan,Guinean,Guyanese,Haitian,Herzegovinian,Honduran,Hungarian,I-Kiribati,Icelander,Indian,Indonesian,Iranian,Iraqi,Irish,Irish,Israeli,Italian,Ivorian,Jamaican,Japanese,Jordanian,Kazakhstani,Kenyan,Kittian and Nevisian,Kuwaiti,Kyrgyz,Laotian,Latvian,Lebanese,Liberian,Libyan,Liechtensteiner,Lithuanian,Luxembourger,Macedonian,Malagasy,Malawian,Malaysian,Maldivan,Malian,Maltese,Marshallese,Mauritanian,Mauritian,Mexican,Micronesian,Moldovan,Monacan,Mongolian,Moroccan,Mosotho,Motswana,Mozambican,Namibian,Nauruan,Nepalese,Netherlander,New Zealander,Ni-Vanuatu,Nicaraguan,Nigerian,Nigerien,North Korean,Northern Irish,Norwegian,Omani,Pakistani,Palauan,Panamanian,Papua New Guinean,Paraguayan,Peruvian,Polish,Portuguese,Qatari,Romanian,Russian,Rwandan,Saint Lucian,Salvadoran,Samoan,San Marinese,Sao Tomean,Saudi,Scottish,Senegalese,Serbian,Seychellois,Sierra Leonean,Singaporean,Slovakian Slovenian,Solomon Islander,Somali,South African,South Korean,Spanish,Sri Lankan,Sudanese,Surinamer,Swazi,Swedish,Swiss,Syrian,Taiwanese,Tajik,Tanzanian,Thai,Togolese,Tongan,Trinidadian or Tobagonian,Tunisian,Turkish,Tuvaluan,Ugandan,Ukrainian,Uruguayan,Uzbekistani,Venezuelan,Vietnamese,Welsh Welsh,Yemenite,Zambian,Zimbabwean' );
}

add_action('wp_head', 'acf_head');
function acf_head(){ acf_form_head();}
add_shortcode('review-form', 'review_form');
function review_form(){
   ?>
<div>
	<?php
		acf_form(array(
		'post_id'		=> 'new_post',
		'post_title'	=> true,
		'post_content'	=> false,
		'html_submit_button'  => '<input type="submit" class="review-submit" value="%s" />',
		'html_updated_message'  => '<div id="message" class="updated"><p>Thank you, Your review is logged sucessfully, <br/> Add new Review or <a href="./?profiletab=my_reviews">Check your Reviews </a></p></div>',
		'submit_value'		=> 'Submit Your Review',
		'new_post'		=> array(
			'post_type'		=> 'review',
			'post_status'	=> 'publish'
			
		)
		
	));
	?>	
</div>
<?php
}

add_filter( 'enter_title_here', 'job_title_change' );
function job_title_change( $title ){
     $screen = get_current_screen();
  
     if  ( 'job' == $screen->post_type ) {
          $title = 'Enter Position Title';
     }
  
     return $title;
}


/*pro*/
add_action('acf/init', 'my_acf_init');
/* Google Maps API */
function my_acf_init() {
acf_update_setting('google_api_key', 'XXXXXXXXXXXXXX');
}
add_shortcode('imp-links','imp_links');
function imp_links(){
	ob_start(); 
?>
        <div style="display: flex; column-gap: 25px; justify-content: center; font-weight:600; flex-wrap: wrap; row-gap: 20px;">
            <a 	href="<?php the_field('website'); ?>" target="_blank" class="visit-site" onclick="gtag('event', 'school_site_visit', { 'event_category' : 'School Page Link Click', 'event_label' : 'Visit Website' });">VISIT WEBSITE</a>
            <a href="<?php the_field('academic_calendar'); ?>" target="_blank" class="calender-download" onclick="gtag('event', 'calendar_download', { 'event_category' : 'School Page Link Click', 'event_label' : 'Academic Calendar' });">ACADEMIC CALENDAR</a>
            <a href="#" class="book-tour" onclick="gtag('event', 'book_tour', { 'event_category' : 'School Page Link Click', 'event_label' : 'Book A Tour' });">BOOK A TOUR</a></div>

<?php

	$output = ob_get_clean();
    return $output;
}
add_shortcode('cpe-date','cpe_date');
function cpe_date(){
	ob_start(); 
	if( have_rows('cpe_registration_detail') ): 
	while( have_rows('cpe_registration_detail') ): the_row();
$from = get_sub_field('valid_from');
	   $till = get_sub_field('valid_till');
?>
        <span><?php echo $from; ?> To <?php echo $till; ?> </span> 
<?php
endwhile;
 endif; 
	$output = ob_get_clean();
    return $output;
}
add_shortcode('edutrust-date','edutrust_date');
function edutrust_date(){
	ob_start(); 
	if( have_rows('edu_trust') ): 
	while( have_rows('edu_trust') ): the_row();
$from = get_sub_field('valid_from');
	   $till = get_sub_field('valid_till');
?>
        <span><?php echo $from; ?> To <?php echo $till; ?> </span> 
<?php
endwhile;
 endif; 
	$output = ob_get_clean();
    return $output;
}
add_shortcode('school-testimonial', 'school_testimonial');
function school_testimonial(){
	ob_start();
$testimonials = get_posts(array(
							'post_type' => 'parent_testimonial',
							'meta_query' => array(
								array(
									'key' => 'school', 
									'value' => get_the_ID(), 
									'type' => 'NUMERIC',
								)
								
							)
						));

						?>
						<?php if( $testimonials ): ?>
<div class="slider_testimonial" >
				
							<div class="testimonial_slides">
							<?php foreach( $testimonials as $testimonial ): ?>
								<?php 
								$photo = get_field('parent_pic', $testimonial->ID);
								$name = get_field('name', $testimonial->ID);
								$rating = get_field('rating', $testimonial->ID);
								$text = get_field('description', $testimonial->ID);
								$output = apply_filters( 'the_content', $testimonial->post_content );
								?>
								<div class="testimonial_slide" >
			
						<div class="testimonial_slide_image" ><img src="<?php echo $photo['url']; ?>" alt="<?php echo $photo['alt']; ?>" width="120" /></div>
						<div class="testimonial_slide_description">
							<h4 class="testimonial_slide_title"><?php echo get_the_title( $testimonial->ID ); ?></h4>
			<div class="testimonial_slide_content"><?php echo $text; ?></div>
						</div>
				</div>
							<?php endforeach; ?>
								</div>
			</div>
						<?php else: echo '<div style="text-align:center">No Parent Testimonial available for this school</div>';
						endif; ?>
<? return ob_get_clean();
}
/*facilities*/
add_shortcode( 'facilities', 'facility_output' );
function facility_output($atts){
    ob_start();
    echo '<ul class="facility-list">';
    global $post;
$taxonomy = 'facility';
$terms = get_the_terms( $post, $taxonomy );
if ( !empty( $terms ) ) {
    foreach ($terms as $term) {
        echo '<li>' . $term->name . '</li>';
    }
}
    echo '</ul>';
    $output = ob_get_clean();
    return $output;
}
add_shortcode( 'school-level', 'school_level' );
function school_level(){
    ob_start();
    global $post;
$taxonomy = 'school_level';
$terms = get_the_terms( $post, $taxonomy );
if ( !empty( $terms ) ) {
    foreach ($terms as $term) {
        echo '<span class="level">' .$term->name.'</span>' ;
    }
}
    $output = ob_get_clean();
    return $output;
}
add_shortcode( 'curriculum', 'curriculum' );
function curriculum(){
    ob_start();
    global $post;
$taxonomy = 'curriculum';
$terms = get_the_terms( $post, $taxonomy );
if ( !empty( $terms ) ) {
    foreach ($terms as $term) {
        echo '<span class="level">' .$term->name.'</span>' ;
    }
}
    $output = ob_get_clean();
    return $output;
}
add_shortcode( 'curri-abb', 'curri_abb' );
function curri_abb(){
    ob_start();
    global $post;
$taxonomy = 'curriculum';
$terms = get_the_terms( $post, $taxonomy );
if ( !empty( $terms ) ) {
    foreach ($terms as $term) {
        $abb = get_field('abb', $term);
        echo '<span class="level">' .$abb.'</span>' ;
    }
}
    $output = ob_get_clean();
    return $output;
}
add_shortcode( 'school-timings', 'school_timings' );
function school_timings(){
    ob_start();
    global $post;
$school_hours = get_field('school_hours');
$start = $school_hours['starts_at'];
$end = $school_hours['ends_at'];
?>
<span><?php echo $start; ?> to <?php echo $end; ?></span>
   <?php $output = ob_get_clean();
    return $output;
}
add_shortcode( 'edu-trust', 'edu_trust' );
function edu_trust(){
    ob_start();
    global $post;
$edu = get_field('edu_trust');
$number = $edu['registration_no'];
$from = $edu['valid_from'];
$till = $edu['valid_till'];
$cpe = get_field('cpe_registration_detail');
$cnumber = $cpe['registration_number'];
$cfrom = $cpe['valid_from'];
$ctill = $cpe['valid_till'];
$location = get_field('cam_location');
$address = explode( ',' , $location['address']);
$map_link = 'https://www.google.com/maps/dir/?api=1&destination=' . $location['lat'] .','. $location['lng'];

?>
<div class="address-school">
       <span> <i class="fas fa-map-marked-alt" style="color: #0070bd; font-size: 20px; margin-right: 6px;"></i> 
        <?php echo esc_html( $location['address'] ); ?></span>
        <a href="<?php echo $map_link ;?>">Get Direction <i class="fa fa-location-arrow" style="color: #000; font-size: 12px;"></i></a>
    </div>
<div class="school-cert" style="margin-bottom:20px">
        <div class="scontact"><a href="tel:<?php echo the_field('phone');?>"><span>&#xe090;</span><?php echo the_field('phone');?></a></div>
        <div class="scontact"><a href="mailto:<?php echo the_field('email');?>"><span>&#xe076;</span>EMAIL US</a></div>
</div>
<div class="school-cert">
<?php if ( $cnumber ): 
echo '<div class="edutrust"><div class="edutitle">CPE REGISTERATION NO.</div>
	<div class="eduno">'  .$cnumber. '</div><span class="validity">' .$cfrom. ' To ' .$ctill. '</span></div>' ;
else:
endif;
if ( $number ): 
echo '<div class="edutrust"><div class="edutitle">EDUtrust REGISTERATION NO.</div>
	<div class="eduno">'  .$number. '</div><span class="validity">' .$from. ' To ' .$till. '</span></div>' ;
else:
endif;
echo '</div>';
	$output = ob_get_clean();
    return $output;
}

/*school fee*/
add_shortcode( 'school-fee', 'school_fee' );
function school_fee() {
ob_start(); ?>
  <?php if( have_rows('fee_detail') ): ?>
	<div class="fee">
	<?php while( have_rows('fee_detail') ): the_row(); 
		$name = get_sub_field('class');
		$age = get_sub_field('age');
		$fee = get_sub_field('fee');
		$eal = get_field('eal');
		?>
                    <div class="fee-detail" >
						<b><?php echo $name;?> (Age <?php echo $age;?>)</b>: $<?php echo number_format($fee);?>
                           

		</div>
                <?php endwhile; ?>
			</div> 
<div class="fee-bottom"><div class="fee-detail">Application Fee: <?php $application_fee = get_field('application_fee');?> $<?php echo number_format($application_fee);?></div>
	<div class="fee-detail"><?php if ( !empty( $eal ) ) { ?> EAL (English As Additional Language):  $  <?php echo number_format($eal); } ?>  </div>
</div>
<?php endif; ?>
<?php
	return ob_get_clean();
}

/*Awards */

add_shortcode('award-section', 'award_section');
function award_section(){
    ob_start();
    global $post;
    $taxonomy = 'accredation';
$terms = get_the_terms( $post, $taxonomy );
$extra = get_field('extra_curricular_activities');
    echo '<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(340px, 1fr)); gap:40px; margin: auto; text-align: center; border-top:1px solid #f2f2f2; border-bottom:1px solid #f2f2f2;);">';
    if ( !empty( $terms ) ) {
echo '<div style="padding: 7% 3%; max-width: 90%; margin: auto;"><h3>ACCREDITATION</h3><div class="acdre-logo">';
    foreach ($terms as $term) {
      $image_id = get_field('accredation_logo', $term, false); 
$image = wp_get_attachment_image_src($image_id, $size);
echo  '<img src="'.$image[0].'" />'; }
	echo '</div> </div>';
}
if ( !empty( $extra ) ) {
echo '<div style="padding: 7% 3%; max-width: 90%; margin: auto;"><h3>EXTRA CURRICULAR ACTIVITIES</h3>' .$extra. '</div>'; }
    echo '</div>';
    return ob_get_clean();
}

/*Directory */

add_shortcode('directory', 'directory');
function directory(){
ob_start();
get_template_part('directory');
return ob_get_clean();
}

/*Gallery*/
add_shortcode( 'school-gallery', 'school_gallery' );
function school_gallery() {
ob_start();
  $images = get_field('gallery');
if ( $images ): ?>
        <div class="et_pb_module et_pb_gallery  et_pb_gallery_grid et_pb_bg_layout_light clearfix">
            <div class="et_pb_gallery_items et_post_gallery clearfix" <?php if ( wp_is_mobile() ) : ?> 
   data-per_page="4"
<?php else : ?>
    data-per_page="8"
<?php endif; ?> >
                <?php  foreach($images as $image):   ?>           
                    
                
                <div class="et_pb_gallery_item et_pb_grid_item et_pb_bg_layout_light" style="display: block;">
                    <div class="et_pb_gallery_image landscape">
                        <a href="<?php echo $image['url'];?>" >
                            <img src="<?php echo $image['url'];?>" >
                            <span class="et_overlay et_pb_inline_icon" data-icon="U"></span>
                        </a>
                    </div>
                </div>                            
                <?php endforeach; ?>

			</div> </div>
<?php else: 
    echo get_the_post_thumbnail( $page->ID, 'large' );
endif; 

	return ob_get_clean();
}
add_shortcode('school-news', 'school_news');
function school_news(){
	ob_start();
$newses = get_posts(array(
							'post_type' => 'post',
							'meta_query' => array(
								array(
									'key' => 'news_school', 
									'value' => get_the_ID(), 
									'type' => 'NUMERIC',
								)
							)
						));

						?>
						<?php if( $newses ): ?>
<div class="news" >
				
							
							<?php foreach( $newses as $news ): 

	?>
	
					<div class="news-tile">
							<?php echo get_the_post_thumbnail( $news->ID, 'medium' ); ?>
            <h4 class="title"><a href="<?php echo get_permalink( $news->ID ); ?>">
                     <?php echo get_the_title( $news->ID ); ?> </a></h4>
						
							
						</div>
							<?php endforeach; ?>
								
			</div>
						<?php 
						else: 
						    echo '<div style="text-align:center">No News or Events Avaialble</div>';
						endif; ?>
<? return ob_get_clean();
}
add_shortcode('user-review', 'user_review');
function user_review(){
	ob_start();
$reviews = get_posts(array(
							'post_type' => 'review',
							'posts_per_page' => '4',
							'meta_query' => array(
								array(
									'key' => 'school', 
									'value' => '"' . get_the_ID() . '"', 
									'compare' => 'LIKE'
								)
							)
						));
 if( $reviews ): ?>
<div class="user-reviews" >
				
							<div class="review">
							<?php foreach( $reviews as $review ): ?>
								<?php
								$overall_ratings = get_field('overall_rating', $review->ID);
								$text = get_field('comment', $review->ID);
								$author_id=$review->post_author;
								$star = $overall_ratings;
							    $field_name = "school_rating"; 
	                            update_field($field_name, $star, $review->ID);
								?>


								<div class="review-item" >
			
						<div class="review_image" ><img src="<?php echo esc_url( get_avatar_url( $author_id ) ); ?>"  width="80" /> </div>
						<div class="review_description">
							<h4 class="review_title"><?php echo get_the_title( $review->ID ); ?></h4>
							<?php 
for($x=1;$x<=$star;$x++) {
        echo '<span class="star">&#xe033;</span>';
    }
    if (strpos($star,'.')) {
        echo '<span class="star">&#xe032;</span>';
        $x++;
    }
    while ($x<=5) {
        echo '<span class="star">&#xe031;</span>';
        $x++;
    }
 ?>
								<div class="review_comment"><?php echo mb_strimwidth($text, 0, 100, '...'); ?></div>
							<span><b>By- <?php echo the_author_meta( 'user_nicename', $author_id );?></b></span>
							
						</div>
					
				
				</div>
			
								
							<?php endforeach; ?>
								</div>
	
			</div>
<?php 
	else: 
echo '<span class="no-review">Currently No Reviews Are Available For This School</span>' ;
	endif; 

return ob_get_clean();
}
add_shortcode('my-review', 'my_review');
function my_review(){
	ob_start();
 if ( is_user_logged_in() ):

    global $current_user;
    wp_get_current_user();
    $author_query = array('post_type' => 'review', 'post_status' => 'publish', 'posts_per_page' => '3','author' => $current_user->ID);
    $author_posts = new WP_Query( $author_query ); ?>
<div class="user-reviews" >
   <?php while($author_posts->have_posts()) : $author_posts->the_post();
	$rating = get_field('rating');
	$text = get_field('comment');
	$reviewed_school = get_field('review-school-select');
    ?>

       
				<div class="review">
						
								<div class="user-review-item" >
						<div class="review_description">
<span> Your Review for<?php if( $reviewed_school ): ?>
    <h6><?php echo esc_html( $reviewed_school->post_title ); ?></h6>
<?php endif; ?></span>
							<h6 class="review_title"><?php echo get_the_title(); ?></h6>
								<div class="review_comment"><?php echo $text; ?>
									
</div>

							</div>
					</div>
								</div>
	
<?php endwhile; ?>
</div>
<?php else :
 echo "not logged in";
endif;
return ob_get_clean();
}

if( function_exists('acf_add_options_page') ) {
	
	acf_add_options_page(array(
		'page_title' 	=> 'TIS Settings',
		'menu_title'	=> 'TIS Settings',
		'menu_slug' 	=> 'tis-settings',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	));
	
}

add_shortcode('fslider', 'featured_school');
function featured_school(){
	ob_start();
	
 get_template_part('featured-slider');
	
return ob_get_clean();
}



add_shortcode('compare', 'schools_compare');
function schools_compare(){
	ob_start();
    get_template_part('compare');
    return ob_get_clean();
}


add_filter('gform_field_value_semail', 'semail');
function semail($value){
	$smails = get_field('email');
   return $smails;
}
add_filter('gform_field_value_sname', 'sname');
function sname($value){
	$name = get_the_title();
   return $name;
}
function school_count(  ) {
ob_start();
   $count_posts = wp_count_posts( 'school' )->publish;
echo $count_posts;
	
return ob_get_clean();
}
add_shortcode( 'school-count', 'school_count' );

/* add_shortcode('campus-location','campus_location');
function campus_location(){
    ob_start(); 
    $location = get_field('cam_location');
    $map_link = 'https://www.google.com/maps/dir/?api=1&destination=' . $location['lat'] .','. $location['lng'];
    ?>
    
    <span><?php echo esc_html( $location['address'] ); ?></span> <span ><a href="<?php echo $map_link; ?>" target="_blank"> <i class="fa fa-location-arrow" aria-hidden="true"></i></a></span>
   
   <?php return ob_get_clean();
} */

add_shortcode('curriculum-offered', 'curriculum_offered');
function curriculum_offered(){
	ob_start();
	$terms = get_terms( array(
  'taxonomy' => 'curriculum',
  'hide_empty' => false,
) );
echo '<table><thead><tr><th >Name</th><th >No. Schools</th><th >Info</th></tr></thead><tbody>';
foreach ($terms as $term){ 
    echo '<tr><th >'.$term->name.'</th><th ><span style="color:#0070bd; margin:0 5px"> <i class="fas fa-school"></i> '.$term->count.'</span></th><th ><a href="'.get_term_link($term).'"><i class="fas fa-info"></i> Learn More</a></th></tr>';
 }
echo '</tbody>
</table>';
return ob_get_clean();
}
add_shortcode( 'nonprofit-count', 'nonprofit_count' );
function nonprofit_count( $atts ) {
ob_start();
	 $atts = shortcode_atts( array(
        'location' => null,
    ), $atts );
$posts = get_posts(array(
        'post_type'     => 'school',
        'meta_key'      => 'non_profit',
        'meta_value'    => 'Yes',
		'country' => $atts['location'],
    ));
    echo count($posts);
	
return ob_get_clean();
}
add_shortcode('single-school', 'single_school');
function single_school(){
    ob_start();
    get_template_part('school-top');
    return ob_get_clean();
}

add_shortcode('school-top-info', 'school_top_info');
function school_top_info(){
    ob_start();
    $logo = get_field('logo');
    $np = get_field('non_profit');
    $fy = get_field('year_founded'); 
     echo '<div style="display:flex; flex-wrap:wrap; align-items: center; justify-content: space-around;"><div><img width="160" src="' .$logo.'"></div><div style="display: grid; font-size: 40px; color: #4a4949; line-height: 1em;"><span style="font-size:16px">Founded In</span>' .$fy. '</div><div>'; if ($np == 'Yes')  { echo '<div style="display:grid"><span style="font-size:16px">Non Profit</span><img style="margin:auto" width="40" src="/wp-content/uploads/sites/2/2022/01/nprofit.png" /></div>';} echo '</div></div>';
    return ob_get_clean();
}
add_shortcode('nonprofit', 'nonprofit');
function nonprofit() {
	ob_start();
$non_profit = get_field('non_profit');
	 if ($non_profit == 'Yes')  { echo '<img src="/wp-content/uploads/2021/10/nprofitschool-2.png" />';}
	return ob_get_clean();
	
}

add_shortcode('location-filter', 'location_filter');
function location_filter(){
    ob_start(); ?>
    <div class="marker-filter">
        <?php $field_key = "field_619f15e03ee4b";
									$field = get_field_object($field_key);
	 
if( $field ){

	foreach( $field['choices'] as $k => $v ){
	   echo  '<span class="filter-box"><input type="checkbox" name="'.$k.'" value="'.$k.'" id="'.$k.'" checked onchange="filterMarker(this.value);"><label for="'.$k.'">'.$v.'</label></span>' ;
	
	}
} ?>
        </div> <?php
    return ob_get_clean();
}
add_shortcode( 'map-directory', 'map_directory' ); 
function map_directory() {
        $args = array(
                'post_type'      => 'school',
                'posts_per_page' => -1,
				
	);

        $the_query = new WP_Query($args);
        ob_start();
        get_template_part('map-directory');
        return ob_get_clean();
}
         
add_shortcode( 'schools-onmap', 'schools_onmap' ); 
function schools_onmap() {
        $args = array(
                'post_type'      => 'school',
                'posts_per_page' => -1,
				
	);

        $the_query = new WP_Query($args);
        ob_start();
         ?>
        
        
<div class="map-container"><div class="wrap"><div class="acf-map"> 
<?php
        while ( $the_query->have_posts() ): $the_query->the_post();
        $location = get_field('cam_location');
        $title = get_the_title(); 
		$logo = get_field('logo');
		$rating = get_field('school_rating');
		$year = get_field('year_founded');
		$phone =get_field('phone');
		$web = get_field('website');
		$semail = get_field('email');
		$scat = get_field('non_profit');
		$zone = get_field('zone');
$address = explode( ", " , $location['address']);
   $city = $address[3];
        if( !empty($location) ){
        ?>
        	<div class="marker" data-zone="<?php echo $zone; ?>" data-city="<?php echo $city; ?>" data-lat="<?php echo $location['lat']; ?>" data-lng="<?php echo $location['lng']; ?>"><div class="marker-detail">
				<div class="map-title"><img src="<?php echo $logo; ?>"><h4><?php the_title(); ?></h4></div>
                       <div class="map-detail">
                           <div class="address"><p><?php echo $location['address']; ?></p> </div> 
                            <div style="display:flex">
                                <a onclick="gtag('event', 'click_to_call', { 'event_category' : 'Map Call Click', 'event_label' : 'Call Now' });" href="tel:<?php echo $phone; ?>"><span class="map-icon">&#xe090;</span></a>
                            <a onclick="gtag('event', 'email_send', { 'event_category' : 'Map Send mail Click', 'event_label' : 'Send Mail' });" href="mailto:<?php echo $semail; ?>"><span class="map-icon">&#xe010;</span></a>
                            </div></div>
                            <div class="map-bottom">
						   <?php if ($scat == 'Yes')  echo '<img width="35" src="/wp-content/uploads/sites/2/2022/01/nprofit.png" />'; ?>
						   <a onclick="gtag('event', 'book_tour', { 'event_category' : 'Map Tour Book Click', 'event_label' : 'Book A School Tour' });" target="_blank" href="<?php echo site_url( '/book/');?>?school_name=<?php echo $title; ?>&school_mail=<?php echo $semail; ?>">
						       <img class="map-link" src="/images/book-tour.png"></a>
                                <a onclick="gtag('event', 'school_site_visit', { 'event_category' : 'Map Site Visit Click', 'event_label' : 'Visit Website' });" target="_blank" href="<?php echo $web; ?>"><img class="map-link" src="/images/visit-site.png"></a> 
                                <div style="display: flex;flex-direction: column;align-items: center;"><b><?php if ($rating == 0){} else{echo $rating;} ?></b><img class="map-link" src="/images/user-rating.png"></div> 
						   <a href="<?php the_permalink(); ?>"> <img class="map-link" src="/images/read-more.png"></a> 
						   </div>
				</div></div>
			<?php
        }
        endwhile;
        echo '</div></div>';
        wp_reset_postdata();
  return ob_get_clean();
}

//global featured school
add_shortcode('global-featured-school', 'global_featured_school');
function global_featured_school(){
	ob_start();
 if ( $gfschools = get_field('global_featured', 'option') ) {  
  $fglobal = new WP_Query( array( 
    'post_type' => 'school', 
    'post__in' => $gfschools,
	'orderby' =>  'post__in',
  ) );
	 if ( $fglobal->have_posts()) : 
$imageurl = wp_get_attachment_image_src($post_id);	?>
<div class="gfslider"><div class="globalf-slider"><div class="gfeatured_slides">
<?php    while ( $fglobal->have_posts()): $fglobal->the_post();
?>
 <div class="featured_slide">
				<div class="gfslide">
					<div class="gfslide_inner">
						<div class="gfslide_image et_pb_column et_pb_column_3_4" ><img  src="<?php echo get_the_post_thumbnail_url(); ?>" />
<div class="gfslide_description">
<h4 class="gfslide_title et_pb_column et_pb_column_1_4" style="margin-bottom:0px;"><?php echo get_the_title(); ?></h4><div class="gfslide_content et_pb_column et_pb_column_3_4" ><?php the_field('short_intro'); ?>
							</div>
							</div>
						</div>
<div class="gflinks et_pb_column et_pb_column_1_4">
<a href="#"><img class="img-fluid" src="/images/user-rating.png"></a><span>&nbsp;</span><a onclick="gtag('event', 'school_site_visit', { 'event_category' : 'Global Sider link', 'event_label' : 'Visit Website' });" target="_blank" href="<?php the_field('website'); ?>"><img class="img-fluid" src="/images/visit-site.png"></a><span>&nbsp;</span>
	<a onclick="gtag('event', 'book_tour', { 'event_category' : 'Global Sider link', 'event_label' : 'Book A Tour' });" href="<?php the_field('read_more'); ?>"><img class="img-fluid" src="/images/book-tour.png"></a><span>&nbsp;</span><a href="<?php the_field('read_more'); ?>"><img class="img-fluid" src="/images/read-more.png"></a> 
</div>
 </div>					</div>
					</div>
  <?php endwhile;
    wp_reset_postdata(); ?>
	</div>
</div>
</div>
  <?php endif; ?>	
<?php }
return ob_get_clean();
}

add_shortcode('job-detail','job_detail');
function job_detail(){
    ob_start();
    global $post;
$school = get_field('sg_school');
$date = get_field('important_dates');
$apply_by = $date['apply_by'];
$pdate = $date['publish_date'];
$sdate = $date['start_date'];
$contract = get_field('contract_length');
$jtype = get_field('job_type');
if( $school ):
	        switch_to_blog( $school['site_id'] ); 
	        foreach ($school['selected_posts'] as $post):
$permalink = get_permalink( );
        $title = get_the_title( );
        $logo = get_field('logo');
?>
				 <div class="organisation"><div class="joblogo"><img src="<?php the_field('logo', $acf_post->ID); ?>"></div><a href="<?php echo esc_url( $permalink ); ?>">Learn more About School >></a>  </div>
   <?php endforeach; 
				restore_current_blog(); 
   else: ?>
				<div class="organisation"><div class="joblogo"><img src="/wp-content/uploads/2021/10/TIS-Grey.svg"></div>	<h3><a href="/about-us">The International Schools</a></h3></div>
				<?php  
				endif; ?>
<div class="job-side-table">
	
	<div class="job-side-title"><div class="jobt-title">Employement Type</div><div class="jobt-title">Role Type</div><?php if($contract) echo '<div class="jobt-title">Contract length</div>' ; ?><div class="jobt-title">Last date Of Submission:</div> <div class="jobt-title">DATE PUBLISHED:</div> <div class="jobt-title">Date Of Joining/Start:</div></div>
				<div class="job-side-info">
				    <div class="jobt-info"><?php echo esc_html($jtype['label']); ?></div>
					<div class="jobt-info"><?php the_field('role_type'); ?></div>
					<?php if($contract) echo '<div class="jobt-info">'.$contract.' years</div>' ; ?>
					<div class="jobt-info"><?php echo $apply_by; ?></div> 
					<div class="jobt-info"><?php echo $pdate; ?></div> 
					<div class="jobt-info"><?php echo $sdate; ?></div> 
					</div> </div>

<?php				
	$output = ob_get_clean();
    return $output;

}


/*Directory */
add_shortcode('all-jobs', 'all_jobs');
function all_jobs(){
ob_start();
get_template_part('joblist');
	
 return ob_get_clean();
}
add_shortcode('globalslider', 'global_slider');
function global_slider($atts){
	ob_start();
	$atts = shortcode_atts( array(
        'country' => null,
    ), $atts );
	$name = $atts['country'];
	
 if ( $featured_schools = get_field($name, 'option') ) {  
  $projects_query = new WP_Query( array( 
    'post_type' => 'school', 
    'post__in' => $featured_schools,
	'orderby' =>  'post__in',
	
    
  ) );
	 if ( $projects_query->have_posts()) : 
$imageurl = wp_get_attachment_image_src($post_id);	?>
<div class="gtslider"><div class="global-slider"><div class="global_slides">
<?php    while ( $projects_query->have_posts()): $projects_query->the_post(); 
?>

 <div class="global_slide">
				<div class="gtslide">
					<div class="featured_slide_inner">
						<div class="gtslide_image" ><img src="<?php echo get_the_post_thumbnail_url(); ?>" />
						</div>
						<div class="gtslide_description">
							<a href="<?php echo get_permalink() ?>"><h4 class="gtslide_title"><?php echo get_the_title(); ?></h4></a>
							<div class="gtslide_content"> <?php echo wp_trim_words( the_field('brief_intro'), 60, '...' ); ?>
							
							</div>
							</div> </div>
					</div></div>
  <?php endwhile;
    wp_reset_postdata(); ?>
	
	
</div>
	</div> </div>
							
				
  <?php endif; ?>	
<?php }
return ob_get_clean();
}

add_shortcode('topschools', 'topschools');
function topschools($atts){
	
	$atts = shortcode_atts( array(
        'for' => null,
    ), $atts );
	$for = $atts['for'];

 $posts = get_field($for, 'option');
ob_start();
	    if( $posts ):
	        // switch to multisite
	        switch_to_blog( $posts['site_id'] ); ?>
	        <div class="gtslider"><div class="global-slider"><div class="global_slides">   
	        <style>.global_slides { display: grid; grid-template-columns: repeat( auto-fill, minmax(250px, 1fr) ); gap: 30px; grid-auto-rows: minmax(100px, auto); } 
	        .gtslide_image { max-height: 180px; overflow: hidden; border-radius: 10px 10px 0 0;} .gtslide_description { padding: 12px; } 
	        .global_slide { background: #fff; box-shadow: rgb(0 0 0 / 35%) 0px 5px 15px; border-radius: 10px; }</style>
	            <?php foreach ($posts['selected_posts'] as $post): // variable must be called $post (IMPORTANT) ?>
	                <?php setup_postdata($post); ?>
	                
	                    <div class="global_slide">
				<div class="gtslide">
					<div class="featured_slide_inner">
						<div class="gtslide_image" ><img src="<?php echo get_the_post_thumbnail_url($post); ?>" />
						</div>
						<div class="gtslide_description">
							<a href="<?php echo get_permalink($post) ?>"><h5 class="gtslide_title"><?php echo get_the_title($post); ?></h5></a>
							<div class="gtslide_content"> <?php echo wp_trim_words( get_field('brief_intro', $post), 20, '...' ); ?><br>
							<a href="<?php echo get_permalink($post) ?>">Read More</h5></a>
							</div>
							</div> </div>
					</div></div>
	            <?php endforeach; ?>
	        </div>
	</div> </div>
	        <?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>
	        <?php restore_current_blog(); // IMPORTANT switch back to current site?>
	    <?php endif; 
	    
	    return ob_get_clean();
}
add_shortcode( 'global-events', 'global_events' );
function global_events( ) {
    ob_start();
    
   $blog_ids = array( 2, 4, 6, 7, 8, 10 );

foreach( $blog_ids as $id ) {

    switch_to_blog( $id );
$blogname = get_blog_details();
    $args = array( 'post_type' => 'post',
	'post_status' => 'publish',
	'posts_per_page' => 3,
	'orderby' => 'date',
	'paged'  => $paged,
	'order' => 'DESC',); 
    $query = new WP_Query( $args );

    if( $query->have_posts() ) :
        
        echo '<div class="region-events"><h3>EVENTS IN ' .$blogname->blogname. '</h3>';
       echo '<div class="events">';
    while( $query->have_posts()) : $query->the_post() ;
    
    ?>
       <div class="event">
						<div class="event_image" ><img src="<?php echo get_the_post_thumbnail_url(); ?>" />
						</div>
						<div class="event_description">
							<a href="<?php echo get_permalink() ?>"><h4 class="event_title"><?php echo get_the_title(); ?></h4></a>
							<div class="event_content"> <?php echo wp_trim_words( get_the_content(), 40, '...' ); ?>
							
							</div>
							</div> </div>

  <?php  endwhile;
  echo '</div></div>';
    endif;
    wp_reset_postdata();

    restore_current_blog();

}
return ob_get_clean();
}

add_shortcode( 'latest-events', 'latest_events' );
function latest_events(){
     ob_start();
    $blog_ids = array( 2, 4, 6, 7, 8, 10 );
$posts = array();
foreach( $blog_ids as $id ){
		switch_to_blog( $id );
		$args = array( 'post_type' => 'post',
	'post_status' => 'publish',
	'posts_per_page' => 2,
	'orderby' => 'date',
	'order' => 'DESC',);
		$blog_posts = get_posts( $args );
		foreach( $blog_posts as $blog_post ){
			array_push( $posts, array(
						  'title' => $blog_post->post_title,
						  'link' => get_permalink( $blog_post->ID ),
						  'img' => get_the_post_thumbnail_url($blog_post->ID),
						  'content' => apply_filters( 'the_content', wp_trim_words(get_the_content(null, false, $blog_post->ID), 40, '...')),
						  ) );
		}
		 wp_reset_postdata();
		restore_current_blog();
	} 
	echo '<div class="events">';
	foreach( $posts as $post ) { ?>
    <div class="event">
						<div class="event_image" ><img src="<?php echo $post['img']; ?>" />	</div>
						<div class="event_description">
							<a href="<?php echo $post['link']; ?>"><h4 class="event_title"><?php echo $post['title']; ?></h4></a>
							<div class="event_content"> <?php echo $post['content']; ?></div>
							</div> </div>
							
 <?php  }
 echo '</div>';
return ob_get_clean(); }

add_shortcode( 'schools', 'global_school_count' );
function global_school_count(){
     ob_start();
     $total_network = 0;
    $blog_ids = array( 2, 4, 6, 7, 8, 10 );
foreach( $blog_ids as $id ){
		switch_to_blog( $id );
		$args = array( 'post_type' => 'school', 'numberposts'   => -1, 'post_status' => 'publish',);
		$total_posts = count( get_posts( $args ) );
		$total_network += $total_posts;
		 wp_reset_postdata();
		restore_current_blog();
	} 
		echo '<span>'.$total_network.'</span>';
	
return ob_get_clean(); }
/*home top rated */
add_shortcode('top-rated-schools', 'top_rated_schools');
function top_rated_schools(){
ob_start();
$rating = get_field('school_rating');
$schools = new WP_Query(array(
	'post_type' => 'school',
	'posts_per_page' => '6',
    'orderby' => 'meta_value', 
    'meta_key' => 'school_rating',
    'order' => 'DESC',
	)); 
if($schools -> have_posts()): ?>
    <div class="rated-schools">
        <style>.rated-schools{display: grid; flex-wrap: wrap; grid-template-columns: repeat( auto-fill, minmax(250px, 1fr) ); column-gap: 20px; row-gap: 20px; margin: auto; width:90%;}
        .rated-name { position: relative; top: 60%; left: 10%; max-width: 75%; transition: 0.5s ease; color: #fff; font-weight: 800; } .rated-item:hover .rated-txt { opacity: 1; bottom: 8%; }
        .rated-item{background-size: cover; height: 240px; background-blend-mode: overlay; background-color: #4f5052b5; border-radius: 8px;} .rated-item:hover .rated-name { top: 5%; }
         .grid-btn { background: #10d6ff; color: #01020a; margin: 0 10px; padding: 5px 8px; border-radius: 4px; } .rated-item:hover .rated-overlay { background: #010a0fad; }
        .rated-overlay { position: relative; height: 100%; width: 100%; border-radius: 8px; transition: .5s ease; }.rated-overlay .number { font-size: 100px; font-weight: 800; position: absolute; right: 2%; color: #fff; opacity: 0.4; bottom: 12%; }
        .rated-txt { color: white; font-size: 12px; position: absolute; opacity: 0; transition: 0.5s ease; left: 8%; bottom: 0%; } .rating { display: flex; justify-content: space-between; align-items: center; font-size: 20px; text-align: center; margin: 10px; } .trview{font-size:10px;}
        </style>
   <?php while($schools -> have_posts()): $schools -> the_post(); $count++;
   $index = $schools->current_post + 1;
   $web = get_field('website');
   $image = wp_get_attachment_url( get_post_thumbnail_id($post->ID), 'thumbnail' );
   $star = get_field('school_rating');
   $trview = get_field('number_of_review');
   ?> <div>
 <div class="rated-item" style="background-image: url('<?php echo $image; ?>')">
     <div class="rated-overlay">
         <h4 class="rated-name"><?php echo the_title();?></h4> <span class="number"><?php echo $index; ?></span>
 <div class="rated-txt"><a href="<?php echo $web; ?>" class="grid-btn">visit website</a>
<a href="<?php the_permalink(); ?>" class="grid-btn">read more</a></div>
</div>

	</div>
	 <div class="rating">
<?php 
for($x=1;$x<=$star;$x++) {
        echo '<span class="star">&#xe033;</span>';
    }
    if (strpos($star,'.')) {
        echo '<span class="star">&#xe032;</span>';
        $x++;
    }
    while ($x<=5) {
        echo '<span class="star">&#xe031;</span>';
        $x++;
    }
 ?><span class="trview">( <?php echo $trview; ?> Review)</span></div></div>
	<?php endwhile; ?>
	</div>
<?php endif; 
return ob_get_clean();
}

//single review
add_action('acf/save_post', 'rating_total', 20);
function rating_total( $post_id ) {
if( have_rows('your_rating') ):
    while( have_rows('your_rating') ): the_row();
    $fee = get_sub_field('fees');
        $curri = get_sub_field('curriculum');
        $loc = get_sub_field('location');
        $faci = get_sub_field('facilities');
    
        endwhile; 
 endif; 
 
 $total = ($fee + $loc + $faci + $curri)/4;
 update_field('field_615fee977a160', $total, $post_id);
}

//number of review
function acf_save_post_number_review ($post_id) {
  $review_number = get_field('number_of_review');
  $reviews_of_post = get_posts( array(
        'post_type' => 'review',
        'posts_per_page' => -1,
        'meta_query' => array(
            array(
                'key' => 'review-school-select',
                'value' => get_the_ID(),
            'type' => 'NUMERIC',
            ),
        ),
    ) );
  
    $number_review = count($reviews_of_post);
     update_field('field_619c5125cd236', $number_review, $post_id);
 
}

add_action('acf/save_post', 'acf_save_post_number_review', 20);


//school rating
add_action('acf/save_post', 'update_ratings', 20);
function update_ratings ($post_id) {
  $total_rating = 0;
    $reviews_of_post = get_posts( array(
        'post_type' => 'review',
        'posts_per_page' => -1,
        'meta_query' => array(
            array(
                'key' => 'review-school-select',
                'value' => get_the_ID(),
            'type' => 'NUMERIC',
            ),
        ),
    ) );
    foreach ( $reviews_of_post as $review ) {
        $overall_rating = get_field('overall_rating', 'post_' .$review->ID);
       $total_rating += $overall_rating;
    }
  	$school_rating = $total_rating/count($reviews_of_post);
  	
	update_field('school_rating', $school_rating, $post_id);
	
}
add_shortcode('multi-campus', 'multi_campus');
function multi_campus(){
ob_start();
$campuses = get_field('campuses');
$count = count($campuses);
if( $campuses ): ?>
<b>OTHER CAMPUS LOCATION :</b> (<?php echo $count; ?>) Alternate School Locations
							
							 <?php foreach( $campuses as $campus ): 
							     $link = get_permalink( $campus->ID );
        $title = get_the_title( $campus->ID );
        $logo = get_field( 'logo', $campus->ID );
        $location = get_field('cam_location', $campus->ID);
							 
							 ?>
								<a onclick="gtag('event', 'other_campus', { 'event_category' : 'School Page Link Click', 'event_label' : 'View Other Campus' });" href="<?php echo $link; ?>" target="_blank">
									<div style="margin-top: 10px; display: grid; grid-template-columns: auto auto; align-items: center; padding: 0 10px; box-shadow: 0px 1px 7px 0px #cdc8c8;">
										<img width="60" src="<?php echo $logo; ?>" > <span><?php echo esc_html( $location['address'] ); ?></span>
										</div>
									</a>
							<?php endforeach; ?>
							
						<?php endif; ?>
<? return ob_get_clean();
}
function um_mycustomtab_add_tab( $tabs ) {
    $tabs['welcome'] = array(
		'name'            => 'Welcome',
		'icon'            => 'um-icon-android-hand',
		'custom'          => true
	);

	if ( !isset( UM()->options()->options['profile_tab_' . 'welcom'] ) ) {
		UM()->options()->update( 'profile_tab_' . 'welcome', true );
	}
	$tabs['my_reviews'] = array(
		'name'            => 'My Reviews',
		'icon'            => 'um-faicon-comments',
		'custom'          => true
	);

	if ( !isset( UM()->options()->options['profile_tab_' . 'my_reviews'] ) ) {
		UM()->options()->update( 'profile_tab_' . 'my_reviews', true );
	}

	$tabs['add_review'] = array(
		'name'            => 'Add Review',
		'icon'            => 'um-icon-android-add',
		'custom'          => true
	);

	if ( !isset( UM()->options()->options['profile_tab_' . 'add_review'] ) ) {
		UM()->options()->update( 'profile_tab_' . 'add_review', true );
	}

	return $tabs;
}

add_filter( 'um_profile_tabs', 'um_mycustomtab_add_tab', 10 );
function um_profile_content_welcome( $args ) {
	echo do_shortcode( '[showmodule id="1467"]' );
}
add_action( 'um_profile_content_welcome', 'um_profile_content_welcome' );

function um_profile_content_my_reviews( $args ) {
	echo do_shortcode( '[my-review]' );
}
add_action( 'um_profile_content_my_reviews', 'um_profile_content_my_reviews' );

function um_profile_content_add_review( $args ) {
	echo do_shortcode( '[showmodule id="4784"]' );
}
add_action( 'um_profile_content_add_review', 'um_profile_content_add_review' );

function review_form_related_school($form){
    
    foreach($form['fields'] as $field){
        
        if($field['inputType'] != 'select' || strpos($field['cssClass'], 'related-school-name') === false)
            continue;
        
        $posts = get_posts('numberposts=-1&post_status=publish&post_type=school&orderby=title&order=ASC');
        
        foreach($posts as $post){
            $choices[] = array('text' => $post->post_title, 'value' => $post->ID);
        }
        
        $field['choices'] = $choices;
        
    }
    
    return $form;
} add_filter('gform_pre_render', 'review_form_related_school');

function side_buttons() { 
    ?>
    <script>
jQuery(function($){$("input[type=text], textarea").keypress(function(a){if(!String.fromCharCode(a.which).match(/[A-Za-z0-9&. ]/))return!1}),
$("input[type=text], textarea").bind("copy paste",function(a){var b=new RegExp("@"),c=String.fromCharCode(event.charCode?event.charCode:event.which);
if(!b.test(c))return alert("Not allowed to paste"),a.preventDefault(),!1})})
</script>
    
   <?php $blog_id = get_current_blog_id();
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
function add_featured_image_column($defaults) {
    $defaults['featured_image'] = 'School Image';
    return $defaults;
}
add_filter('manage_school_posts_columns', 'add_featured_image_column');
 
function show_featured_image_column($column_name, $post_id) {
    if ($column_name == 'featured_image') {
        echo get_the_post_thumbnail($post_id, array( 80, 40 )); 
    }
}
add_action('manage_school_posts_custom_column', 'show_featured_image_column', 10, 2);
add_filter('gform_validation', 'reject_urls_in_textarea', 10, 2);

function reject_urls_in_textarea($validation_result)
{

	// Get the form object from the validation result
	$form = $validation_result["form"];
		
	//Loop through the form fields
	foreach($form['fields'] as &$field)
	{
	
		if ( $field->type == 'text' || $field->type == 'textarea' )
		{
			// Get the submitted value from the $_POST
			$field_value = rgpost("input_{$field['id']}");
			$pattern = '#[-a-zA-Z0-9@:%_\+.~\#?&//=]{2,256}\.[a-z]{2,4}\b(\/[-a-zA-Z0-9@:%_\+.~\#?&//=]*)?#si';
			
			if (preg_match_all($pattern, $field_value))
			{
				//Fail the validation for the entire form
				$validation_result['is_valid'] = false;
				
				//Mark the specific field that failed and add a custom validation message
				$field['failed_validation'] = true;
				$field['validation_message'] = 'Urls [Links] or [Emails] are not allowed in this field.';
				
				//Assign our modified $form object back to the validation result
				$validation_result['form'] = $form;
			}
			
			else
			{
				//Huston we are a go!
				continue;
			}			
		}
		
		else
		{
			//!textarea 
			continue;
		}
	}	
	//Return validated result
	return $validation_result;
}

