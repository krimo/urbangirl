<?php
/*
Plugin Name: Ug Custom Login
Plugin URI: http://krimohafsaoui.com
Description: This plugin customizes the WordPress login screen.
Version: 1.0
Author: Krimo Hafsaoui
Author URI: http://krimohafsaoui.com
License: GPLv2
*/

// add a new logo to the login page
function ug_login_logo() { ?>
    <style type="text/css">
    	body.login {
    		background: #222;
    	}
        .login #login h1 a {
            background-image: url( <?php echo plugins_url( 'media/logo.png' , __FILE__ ); ?> );
            background-size: 94% auto;
            height:45px;
        }
        .login #nav, .login #backtoblog {
			text-shadow: none;
		}
		.login form {
			-webkit-box-shadow: 0 4px 10px -1px rgba(0, 0, 0, 1);
			box-shadow: 0 4px 10px -1px rgba(0, 0, 0, 1);
			border-radius: 0;
		}

		.wp-core-ui .button-primary {
			border-style: solid;
			border-width: 0;
			cursor: pointer;
			font-family: "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;
			font-weight: 300;
			line-height: 1;
			margin: 0 0 1.25em;
			position: relative;
			text-decoration: none;
			text-align: center;
			display: inline-block;
			padding-top: 0.75em;
			padding-right: 1.5em;
			padding-bottom: 0.8125em;
			padding-left: 1.5em;
			font-size: 1em;
			background: #ee145b;
			border-color: #c10e48;
			box-shadow: none;
			color: white;
			border-radius: 0;
		}

		.wp-core-ui .button-primary:hover {
			background: #cc145b;
			text-shadow: none;
			box-shadow: none;
		}
    </style>
<?php }
add_action( 'login_enqueue_scripts', 'ug_login_logo' );
 ?>