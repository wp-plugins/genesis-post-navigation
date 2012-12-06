<?php

function gpn_custom_css() {
	

	// design settings array

	$gpn_design	= get_option('gpn-settings');	

	$gpn_bg	= $gpn_design['gpn_bg'];

	$gpn_bg_hover	= $gpn_design['gpn_bg_hover'];

	$text_color	= $gpn_design['text_color'];

	$text_hover	= $gpn_design['text_hover'];

		
	// Stores CSS in a string and hooks it in head tag

	$gpn_css = '

#after-post-nav {
	margin:20px;}

.gps-nav-next{
	
	background: none repeat scroll 0 0 '.$gpn_bg.';
    border-radius:  0 30px 30px 0;
   -webkit-border-radius:  0 30px 30px 0;
   -moz-border-radius:  0 30px 30px 0;
   -o-border-radius:  0 30px 30px 0;
    padding: 10px;
    float: right;                                          
    margin: 5px 0;
	display : block; 
	cursor : pointer;
	}

    

.gps-nav-prev{

	 background: none repeat scroll 0 0 '.$gpn_bg.';
	 border-radius:30px 0 0 30px;
	 -moz-border-radius:30px 0 0 30px;
	 -webkit-border-radius:30px 0 0 30px;
	 -o-border-radius:30px 0 0 30px;
	 padding: 10px;
	 float: left;
	 margin: 5px 0;
	 display : block; 
	 cursor : pointer;
	 }

   

.gps-nav-prev a, .gps-nav-next a{
	     display : block;
	     color: '.$text_color.' !important;
	     text-decoration: none;}

.gps-nav-next:hover, .gps-nav-prev:hover{
	
		 background: '.$gpn_bg_hover.' ;
		 padding-left:20px;
		-webkit-transition: all 0.5s ease-in-out;
		-moz-transition: all 0.5s ease-in-out;
		-o-transition: all 0.5s ease-in-out;
		-ms-transition: all 0.5s ease-in-out;}

.gps-nav-prev a:hover{
        color: '.$text_hover.' !important; 
        padding-left:20px;
       -webkit-transition: all 0.5s ease-in-out;
       -moz-transition: all 0.5s ease-in-out;
       -o-transition: all 0.5s ease-in-out;
       -ms-transition: all 0.5s ease-in-out;}

.gps-nav-next a:hover{
	
        padding-right:20px;
        color: '.$text_hover.' !important; 
       -webkit-transition: all 0.5s ease-in-out;
       -moz-transition: all 0.5s ease-in-out;
       -o-transition: all 0.5s ease-in-out;
       -ms-transition: all 0.5s ease-in-out;
        }';

return $gpn_css;

}
	
add_action('wp_head','gpn_generate_css');

function gpn_generate_css(){
	if(is_singular()) {
	echo '<style>'.  gpn_custom_css()  .'</style>' ;
	}
}
