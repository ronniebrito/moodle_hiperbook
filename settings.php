<?php  //$Id: settings.php,v 1.1.2.3 2008/01/24 20:29:36 skodak Exp $

require_once($CFG->dirroot.'/mod/hiperbook/lib.php');

				 
$settings->add(new admin_setting_configtextarea('default_template_pages', get_string('default_template_pages', 'hiperbook'),
                   get_string('default_template_pages_description', 'hiperbook'), "termplate inicial" ));

$settings->add(new admin_setting_configtextarea('default_template_hotwords', get_string('default_template_hotwords', 'hiperbook'),
                   get_string('default_template_hotwords_description', 'hiperbook'), "termplate inicial" ));
				   
$settings->add(new admin_setting_configtextarea('default_template_tips', get_string('default_template_tips', 'hiperbook'),
                   get_string('default_template_tips_description', 'hiperbook'), "termplate inicial" ));

$settings->add(new admin_setting_configtextarea('default_template_suggestions', get_string('default_template_suggestions', 'hiperbook'),
                   get_string('default_template_suggestions_description', 'hiperbook'), "termplate inicial" ));
				   
	
$settings->add(new admin_setting_configtextarea('default_template_css', get_string('default_template_css', 'hiperbook'),
                   get_string('default_template_css_description', 'hiperbook'), "template inicial" ));			   


?>