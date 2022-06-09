<?php
$paged = ( get_query_var('paged') == 0 ) ? 1 : get_query_var('paged');
$jobs = new WP_Query(array(
	'post_type' => 'job',
	'post_status' => 'publish',
	'meta_query'        => array(
                    'key'       => 'apply_before',
                    'value'     => date('Ymd'),
                    'type'      => 'DATE',
                    'compare'   => '>='
        ),
        'meta_key'  => 'apply_before',
        'orderby' => array( 'meta_value' => 'ASC' ), 	
)); 	

        while($jobs -> have_posts()): $jobs -> the_post();
				  $jobfor = get_field('job_for');
				  if ($jobfor == 'schools') :  {
				  $location = get_field('job_location');
				  if ($location == 'sg'){ $school = get_field('sg_school'); }
				  if ($location == 'my'){ $school = get_field('my_school'); }
				  if ($location == 'vn'){ $school = get_field('vn_school'); }
				  if ($location == 'ch'){ $school = get_field('ch_school'); }
				  if ($location == 'id'){ $school = get_field('id_school'); }
				  if ($location == 'jp'){ $school = get_field('jp_school'); }
}
else:
    $school = get_field('none');
endif;
$title = get_the_title();
$plink = get_the_permalink();
$applylink = get_field('apply_link');
$date = get_field('important_dates');
$apply_by = get_field('apply_before');
$pdate = get_field('publish_date');
$sdate = $date['start_date'];
$rtype = get_field('role_type');
$contract = get_field('contract_length');
$jtype = get_field('job_type');
$jtclass = esc_attr($jtype['value']);
$location = get_field('job_location');
$info = get_field('short_info');

echo '<div class="job-card" data-location="'.$location.'" data-job-type="'.$jtclass.'" data-role-type="' .$rtype.'" data-employer="' .$jobfor.'" >'; 
	if( $school ):
	        switch_to_blog( $school['site_id'] ); 
	        foreach ($school['selected_posts'] as $post):
?> 
				 <div class="employer"><div class="orglogo"><img src="<?php the_field('logo', $post); ?>" width="186" height="129"></div>
				 <a href="<?php the_permalink($post); ?>">Visit School</a>  </div>
				 <?php  ?>
   <?php endforeach; 
    restore_current_blog(); 
   else: ?>
				<div class="employer"><div class="orglogo"><img src="/wp-content/uploads/2021/10/TIS-Grey.svg" width="186" height="129"></div>	
				<h4><a href="/about-us">The International Schools</a></h4></div>
					<?php endif; ?>



					<div><a href="<?php echo $plink; ?>"><h3><?php echo $title; ?></h3></a>
						<div class="impdates"> <span><span class="job-icon">&#xe085;</span> <?php echo esc_html($jtype['label']); ?></span><?php if($contract) echo'<span>Contract Length: '.$contract.' months </span>'; ?><span class="applyby"><span class="job-icon">&#xe07e;</span> APPLY BEFORE: <?php echo $apply_by; ?></span> <span class="pdate"><span class="job-icon">&#xe078;</span> PUBLISHED DATE: <?php echo $pdate; ?></span> </div>
<p><?php echo wp_trim_words( $info, 60, '...' ); ?></p>
<div class="joblinks"><a class="jobbutton1" onclick="gtag('event', 'job_application', { 'event_category' : 'Job Application Link', 'event_label' : 'Apply To Job' });" target="_blank" href="<?php echo $applylink; ?>">APPLY NOW</a> <a class="jobbutton2" href="<?php echo $plink; ?>">CHECK DETAILS</a> </div>
					</div>
				</div> 
<?php
	 endwhile; ?>
