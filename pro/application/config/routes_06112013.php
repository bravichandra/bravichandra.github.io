<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = "home";
$route['404_override'] = '';

$route['step/(:any)'] = "home/step/$1";
$route['folder/(:any)'] = "home/download/$1";

$route['create-session'] = "home/create_session";
$route['for-team-member'] = "home/team_member";
$route['user-management'] = "home/user_management";

// outputs
$route['output/elevator-pitch'] = "home/elevator_pitch";
$route['output/elevator-pitch/(:any)'] = "home/elevator_pitch/$1";

$route['output/prospect-pain'] = "home/prospect_pain";
$route['output/prospect-pain/(:any)'] = "home/prospect_pain/$1";

$route['output/ideal-prospect-profile'] = "home/ideal_prospect";
$route['output/ideal-prospect-profile/(:any)'] = "home/ideal_prospect/$1";

$route['output/qualifying-questions'] = "home/qualifying_questions";
$route['output/qualifying-questions/(:any)'] = "home/qualifying_questions/$1";

$route['output/building-interest'] = "home/silver_bullets";
$route['output/building-interest/(:any)'] = "home/silver_bullets/$1";

$route['output/indirect-cold-call-script'] = "home/indirect_call";
$route['output/indirect-cold-call-script/(:any)'] = "home/indirect_call/$1";

$route['output/direct-cold-call-script'] = "home/direct_call";
$route['output/direct-cold-call-script/(:any)'] = "home/direct_call/$1";

$route['output/first-meeting-script'] = "home/meeting_script";
$route['output/first-meeting-script/(:any)'] = "home/meeting_script/$1";

$route['output/objections-map'] = "home/objection_map";
$route['output/objections-map/(:any)'] = "home/objection_map/$1";

$route['output/voicemail-script'] = "home/voicemail";
$route['output/voicemail-script/(:any)'] = "home/voicemail/$1";

$route['output/pre-call-email-thread'] = "home/pre_call";
$route['output/pre-call-email-thread/(:any)'] = "home/pre_call/$1";

$route['output/post-call-email-thread'] = "home/post_call";
$route['output/post-call-email-thread/(:any)'] = "home/post_call/$1";

$route['output/post-voicemail-email-thread'] = "home/voicemail_followup";
$route['output/post-voicemail-email-thread/(:any)'] = "home/voicemail_followup/$1";

$route['output/name-drop-statments'] = "home/drop_statement";
$route['output/name-drop-statments/(:any)'] = "home/drop_statement/$1";

$route['output/closing-questions'] = "home/closing_question";
$route['output/closing-questions/(:any)'] = "home/closing_question/$1";

$route['output/sales-presentation'] = "home/presentation";
$route['output/sales-presentation/(:any)'] = "home/presentation/$1";

$route['output/content-marketing-topics'] = "home/content_marketing";
$route['output/content-marketing-topics/(:any)'] = "home/content_marketing/$1";

$route['output/pre-call-email-pain-focus'] = "home/pre_call_email_pain_focus";
$route['output/pre-call-email-pain-focus/(:any)'] = "home/pre_call_email_pain_focus/$1";

$route['output/pre-call-email-product-focus'] = "home/pre_call_email_product_focus";
$route['output/pre-call-email-product-focus/(:any)'] = "home/pre_call_email_product_focus/$1";

$route['output/pre-call-email-value-focus'] = "home/pre_call_email_value_focus";
$route['output/pre-call-email-value-focus/(:any)'] = "home/pre_call_email_value_focus/$1";

$route['output/call-script-focus-product'] = "home/call_script_focus_product";
$route['output/call-script-focus-product/(:any)'] = "home/call_script_focus_product/$1";

$route['output/call-script-focus-pain'] = "home/call_script_focus_pain";
$route['output/call-script-focus-pain/(:any)'] = "home/call_script_focus_pain/$1";

$route['output/call-script-name-drop'] = "home/call_script_name_drop";
$route['output/call-script-name-drop/(:any)'] = "home/call_script_name_drop/$1";

$route['output/voicemail-value-focus'] = "home/voicemail_value_focus";
$route['output/voicemail-value-focus/(:any)'] = "home/voicemail_value_focus/$1";

$route['output/voicemail-value-focus-appoint'] = "home/voicemail_value_focus_appoint";
$route['output/voicemail-value-focus-appoint/(:any)'] = "home/voicemail_value_focus_appoint/$1";

$route['output/voicemail-name-drop-focus'] = "home/voicemail_name_drop_focus";
$route['output/voicemail-name-drop-focus/(:any)'] = "home/voicemail_name_drop_focus/$1";

$route['output/voicemail-name-drop-appoint'] = "home/voicemail_name_drop_focus_appoint";
$route['output/voicemail-name-drop-appoint/(:any)'] = "home/voicemail_name_drop_focus_appoint/$1";

$route['output/voicemail-pain-focus'] = "home/voicemail_pain_focus";
$route['output/voicemail-pain-focus/(:any)'] = "home/voicemail_pain_focus/$1";

$route['output/voicemail-pain-focus-appoint'] = "home/voicemail_pain_focus_appoint";
$route['output/voicemail-pain-focus-appoint/(:any)'] = "home/voicemail_pain_focus_appoint/$1";

$route['output/post-voicemail-name-drop-focus'] = "home/post_voicemail_name_drop_focus";
$route['output/post-voicemail-name-drop-focus/(:any)'] = "home/post_voicemail_name_drop_focus/$1";

$route['output/post-voicemail-pain-focus'] = "home/post_voicemail_pain_focus";
$route['output/post-voicemail-pain-focus/(:any)'] = "home/post_voicemail_pain_focus/$1";

$route['output/post-voicemail-value-focus'] = "home/post_voicemail_value_focus";
$route['output/post-voicemail-value-focus/(:any)'] = "home/post_voicemail_value_focus/$1";

$route['output/product-matrix'] = "home/productMatrix";
$route['output/product-matrix/(:any)'] = "home/productMatrix/$1";

$route['output/sales-letter-pain-focus'] = "home/salesLetterPainFocus";
$route['output/sales-letter-pain-focus/(:any)'] = "home/salesLetterPainFocus/$1";

$route['output/sales-letter-name-drop-focus'] = "home/salesLetterNameDropFocus";
$route['output/sales-letter-name-drop-focus/(:any)'] = "home/salesLetterNameDropFocus/$1";

$route['output/sales-letter-value-focus'] = "home/salesLetterValueFocus";
$route['output/sales-letter-value-focus/(:any)'] = "home/salesLetterValueFocus/$1";


$route['output/internal-referral-email'] = "home/internalReferralEmail";
$route['output/internal-referral-email/(:any)'] = "home/internalReferralEmail/$1";


$route['output/inbound-call-script'] = "home/inboundCallScript";
$route['output/inbound-call-script/(:any)'] = "home/inboundCallScript/$1";

/* End of file routes.php */
/* Location: ./application/config/routes.php */