<?php
/*
Plugin Name: DDL Chatbot
Version: 1.0.0
Description: Declares a plugin that creates a chatbot popup.
Author: Dental Design
Author URI: https://dental-design.marketing/
License: GPL2
*/


/*-----------------------------------------------------------------------------------*/
/* ADD OPTIONS TO ADMIN */
/*-----------------------------------------------------------------------------------*/

/* --------------------- REGISTER OPTIONS --------------------- */

function add_chatbot_options_page() {

  $icon = plugin_dir_url( __FILE__ ) . '/assets/img/chatbot-icon.svg';

	add_menu_page (
		'Chatbot Options',
		'DDL Chatbot',
		'manage_options',
		'chatbot-options-page',
		'display_chatbot_options_page',
    $icon
	);

}

add_action( 'admin_menu', 'add_chatbot_options_page' );


/* --------------------- STYLE THE ICON --------------------- */

function admin_chatbot_icon_style() {
  echo '<style>
    #toplevel_page_chatbot-options-page .wp-menu-image img {
      max-width: 22px;
      max-height: 22px; 
      padding: 6px 0 0 !important; 
    }
  </style>';
}

add_action('admin_head', 'admin_chatbot_icon_style');


/* --------------------- DISPLAY OPTIONS FORM --------------------- */

function display_chatbot_options_page() {

	echo '<h1 style="margin: 30px 0 40px;">Chatbot Options</h1>';

	echo '<form method="post" action="options.php">';

	do_settings_sections( 'chatbot-options-page' );
	settings_fields( 'chatbot-options' );

	submit_button();

	echo '</form>';

}


/* --------------------- DIALOG SETTINGS SECTION --------------------- */

function admin_init_chatbot_dialog() {

	add_settings_section (
		'chatbot-dialog-section',
		'Pop-up Options',
		'chatbot_dialog_section_message',
		'chatbot-options-page'
	);

  
  /* --- SECTION MESSAGE --- */

  function chatbot_dialog_section_message() {
    echo "Use these options to control the pop-up.";
  }


  /* --- ADD FIELDS --- */

  add_settings_field (
    'chatbot-iframe-script-textarea',
    'Zapier embed script:',
    'render_chatbot_iframe_script_textarea',
    'chatbot-options-page',
    'chatbot-dialog-section'
  );

  add_settings_field(
    'chatbot-onload-checkbox',
    esc_attr__('Show chatbot on load?', 'chatbot-onload-checkbox-label'),
    'render_chatbot_onload_checkbox',
    'chatbot-options-page',
    'chatbot-dialog-section',
    array( 
      'type'         => 'checkbox',
      'option_group' => 'chatbot-onload-checkbox', 
      'name'         => 'chatbot-onload-checkbox',
      'label_for'    => 'chatbot-onload-checkbox',
      'value'        => (empty(get_option('chatbot-options-page')['chatbot-onload-checkbox'])) ? 0 : get_option('unitizr_options')['chatbot-onload-checkbox'],
      'description'  => __( 'Tick to show pop-up when page loads', 'chatbot-onload-checkbox-label' ),
      'checked'      => (!isset(get_option('chatbot-options-page')['chatbot-onload-checkbox'])) ? 0 : get_option('chatbot-options-page')['chatbot-onload-checkbox'],
    )
  ); 


  /* --- REGISTER FIELDS --- */

  register_setting ('chatbot-options','chatbot-iframe-script-textarea');
  register_setting ('chatbot-options','chatbot-onload-checkbox');

}

add_action( 'admin_init', 'admin_init_chatbot_dialog' );


/* --- RENDER FIELDS --- */

function render_chatbot_iframe_script_textarea() {

	$input = get_option( 'chatbot-iframe-script-textarea' );
  echo '<textarea style="width:700px;" name="chatbot-iframe-script-textarea" rows="10" cols="50" id="chatbot-iframe-script-textarea" class="large-text code">' . $input . '</textarea>
  <p class="description" id="tagline-description">Do not include iframe, just the script (e.g. https://interfaces.zapier.com/embed/chatbot/XXXXXXXXXXXXXXXXXXXXXXXXX)</p>';

}

function render_chatbot_onload_checkbox($args){ 

  $checked = '';
  $options = get_option($args['option_group']);
  $value   = ( !isset( $options[$args['name']] ) ) ? null : $options[$args['name']];
  if($value) { $checked = ' checked="checked" '; }
  $html  = '';
  $html .= '<input id="' . esc_attr( $args['name'] ) . '" name="' . esc_attr( $args['option_group'] . '['.$args['name'].']') .'" type="checkbox" ' . $checked . '/>';
  $html .= '<span class="wndspan">' . esc_html( $args['description'] ) .'</span>';
  echo $html;

}


/*-----------------------------------------------------------------------------------*/
/* ENQUEUE STYLES & SCRIPTS */
/*-----------------------------------------------------------------------------------*/

function chatbot_scripts() {

  $chatbotScript = get_option('chatbot-iframe-script-textarea');

  if($chatbotScript) { 

    wp_enqueue_style( 'chatbot-styles', plugins_url('/assets/css/chatbot-style.css', __FILE__), array(), '', 'all' );
    wp_enqueue_script( 'chatbot-script', plugins_url('/assets/js/chatbot-script.js', __FILE__), array(), '', true ); 

  } 

}

add_action( 'wp_enqueue_scripts', 'chatbot_scripts' );


/*-----------------------------------------------------------------------------------*/
/* ADD BUTTON AND DIALOG TO FOOTER */
/*-----------------------------------------------------------------------------------*/

function add_chatbot_dialog() {

  $chatbotScript = get_option('chatbot-iframe-script-textarea');
  $chatbotOnload = get_option('chatbot-onload-checkbox');
  $chatbotOnloadValue = ( !isset($chatbotOnload['chatbot-onload-checkbox'] ) ) ? '' : $chatbotOnload['chatbot-onload-checkbox'];

  echo '<div class="chatbot' . ($chatbotOnloadValue == true ? ' chatbot--onload' : '') . '">
  <button class="chatbot__btn chatbot__btn--closed" id="chatToggle" type="button" aria-label="Open chat dialog" aria-haspopup="true" aria-controls="chatDialog" aria-expanded="false"><span class="chatbot__txt">Chat now</span><span class="chatbot__icon"></span></button>
  <div class="chatbot__dialog chatbot__dialog--closed" id="chatDialog" role="dialog" aria-modal="true" aria-hidden="true"><iframe data-src="' . $chatbotScript . '" height="100%" width="100%" allow="clipboard-write *" style="border: none;"></iframe></div>
  </div>';
}

add_action( 'wp_footer', 'add_chatbot_dialog' );

?>