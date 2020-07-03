<?php
/*
Plugin Name: Gravity Forms Entry Count
Description: Optionally adds the total count of entries to the Gravity Forms HTML.
Version: 1.0
Author: Creative Freedom
Author URI:   https://creativefreedom.com.au
*/

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
* Gravity Forms - Form Settings
**/

function gf_entry_count_form_tag($form_tag, $form){

	if(rgar($form, 'gf_entry_count_enabled')){

		$form_count = GFFormsModel::get_form_counts( $form['id'] );
		$count = !empty($form_count['total']) ? $form_count['total'] : 0;

		$form_tag = preg_replace( "|action='|", "data-gf-entry-count=\"$count\" action='", $form_tag );
   	
   	}

    return $form_tag;

}

add_filter( 'gform_form_tag', 'gf_entry_count_form_tag', 10, 2 );



/**
* Gravity Forms - Form Settings
**/
function gf_entry_count_settings( $settings, $form ) { 

	$settings[ __( 'Form Options', 'gravityforms' ) ]['gf_entry_count_enabled'] = '
    <tr>
        <th>Entry Count <a href="#" onclick="return false;" onkeypress="return false;" class="gf_tooltip tooltip tooltip_form_description" title="<h6>Entry Count</h6>When enabled, this will add a property to the form tag that includes total numbner of entries submitted to this form."><i class="fa fa-question-circle"></i></a></th>
        <td>
            <input type="checkbox" id="gf_entry_count_enabled" name="gf_entry_count_enabled" value="1" '.(rgar($form, 'gf_entry_count_enabled') == "1" ? "checked" : "").' data="'.rgar($form, 'gf_entry_count_enabled').'">
            <label for="gf_entry_count_enabled">Include entry count in the form HTML</label>
        </td>
    </tr>';

	return $settings;
}

add_filter( 'gform_form_settings', 'gf_entry_count_settings', 10, 2 );


function gf_entry_count_settings_save($form) {
    $form['gf_entry_count_enabled'] = rgpost( 'gf_entry_count_enabled' );
    return $form;
}
add_filter( 'gform_pre_form_settings_save', 'gf_entry_count_settings_save' );