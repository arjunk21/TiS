<?php
add_filter( 'gform_field_validation_3_9', 'domain_validation', 10, 4 );
function domain_validation( $result, $value, $form, $field ) {
   
   $email = explode( '@', rgpost( "input_9" ) );
   $demail = array_pop($email);
    $domain = parse_url(rgpost( 'input_12' ), PHP_URL_HOST);
    if ( $result['is_valid'] 
      
    && $demail !== $domain ) {
        $result['is_valid'] = false;
        $result['message']  = 'Please enter your business mail, similar to your domain.';
    }
  
    return $result;
}
?>
