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
$route['dashboard'] = "home/download";
$route['folder/my-folder'] = "home/redirectmain";
$route['dashboard/(:any)'] = "home/download/$1";
$route['step/(:any)'] = "home/step/$1";
$route['folder/team-folder'] = "home/team_folder_view";
$route['crm/settings/teamsearch'] = "home/team_folder_view_crm";
//Trash
$route['folder/trash'] = "home/trash";
$route['folder/trash/(:any)'] = "home/trash/$1";
$route['folder/(:any)'] = "home/download/$1";

$route['preview/(:any)'] = "home/preview/$1";

$route['create-session'] = "home/create_session";
$route['for-team-member'] = "home/team_member";
$route['user-management'] = "home/user_management";

// outputs
$route['output/elevator-pitch'] = "scripts/elevator_pitch";
$route['output/elevator-pitch/(:any)'] = "scripts/elevator_pitch/$1";

$route['output/prospect-pain'] = "scripts/prospect_pain";
$route['output/prospect-pain/(:any)'] = "scripts/prospect_pain/$1";

$route['output/ideal-prospect-profile'] = "scripts/ideal_prospect";
$route['output/ideal-prospect-profile/(:any)'] = "scripts/ideal_prospect/$1";

$route['output/qualifying-questions'] = "home/qualifying_questions";
$route['output/qualifying-questions/(:any)'] = "home/qualifying_questions/$1";

$route['output/pre-qualifying-questions'] = "scripts/pre_qualifying_questions";
$route['output/pre-qualifying-questions/(:any)'] = "scripts/pre_qualifying_questions/$1";

$route['output/hard-qualifying-questions'] = "scripts/hard_qualifying_questions";
$route['output/hard-qualifying-questions/(:any)'] = "scripts/hard_qualifying_questions/$1";

$route['output/questions'] = "scripts/questions";
$route['output/questions/(:any)'] = "scripts/questions/$1";

$route['output/building-interest'] = "scripts/silver_bullets";
$route['output/building-interest/(:any)'] = "scripts/silver_bullets/$1";

$route['output/indirect-cold-call-script'] = "scripts/indirect_call";
$route['output/indirect-cold-call-script/(:any)'] = "scripts/indirect_call/$1";

$route['output/direct-cold-call-script'] = "scripts/direct_call";
$route['output/direct-cold-call-script/(:any)'] = "scripts/direct_call/$1";

$route['output/first-meeting-script'] = "scripts/meeting_script";
$route['output/first-meeting-script/(:any)'] = "scripts/meeting_script/$1";

$route['output/networking-scripts'] = "scripts/networking_scripts";
$route['output/networking-scripts/(:any)'] = "scripts/networking_scripts/$1";

$route['output/meeting-for-coffee-script'] = "scripts/meeting_for_coffee_script";
$route['output/meeting-for-coffee-script/(:any)'] = "scripts/meeting_for_coffee_script/$1";

$route['output/networking-question'] = "scripts/networking_question";
$route['output/networking-question/(:any)'] = "scripts/networking_question/$1";

$route['output/meeting-over-coffee-questions'] = "scripts/meeting_over_coffee_questions";
$route['output/meeting-over-coffee-questions/(:any)'] = "scripts/meeting_over_coffee_questions/$1";

$route['output/objections-map'] = "scripts/objection_map";
$route['output/objections-map/(:any)'] = "scripts/objection_map/$1";

$route['output/voicemail-script'] = "home/voicemail";
$route['output/voicemail-script/(:any)'] = "home/voicemail/$1";

$route['output/pre-call-email-thread'] = "scripts/pre_call";
$route['output/pre-call-email-thread/(:any)'] = "scripts/pre_call/$1"; 

$route['output/pre-call-email-thread-v3'] = "scripts/pre_callv3";
$route['output/pre-call-email-thread-v3/(:any)'] = "scripts/pre_callv3/$1";

$route['output/linkedin-value-thread'] = "scripts/linkedin_value_thread";
$route['output/linkedin-value-thread/(:any)'] = "scripts/linkedin_value_thread/$1";

$route['output/linkedin-pain-thread'] = "scripts/linkedin_pain_thread";
$route['output/linkedin-pain-thread/(:any)'] = "scripts/linkedin_pain_thread/$1";

$route['output/post-call-email-thread'] = "home/post_call";
$route['output/post-call-email-thread/(:any)'] = "home/post_call/$1";

$route['output/post-voicemail-email-thread'] = "home/voicemail_followup";
$route['output/post-voicemail-email-thread/(:any)'] = "home/voicemail_followup/$1";

$route['output/name-drop-statments'] = "scripts/drop_statement";
$route['output/name-drop-statments/(:any)'] = "scripts/drop_statement/$1";

$route['output/closing-questions'] = "scripts/closing_question";
$route['output/closing-questions/(:any)'] = "scripts/closing_question/$1"; 

$route['output/sales-presentation'] = "scripts/presentation";
$route['output/sales-presentation/(:any)'] = "scripts/presentation/$1";

$route['output/content-marketing-topics'] = "scripts/content_marketing";
$route['output/content-marketing-topics/(:any)'] = "scripts/content_marketing/$1";

$route['output/email-marketing-topics'] = "scripts/email_marketing_topics";
$route['output/email-marketing-topics/(:any)'] = "scripts/email_marketing_topics/$1";

$route['output/pre-call-email-pain-focus'] = "scripts/pre_call_email_pain_focus";
$route['output/pre-call-email-pain-focus/(:any)'] = "scripts/pre_call_email_pain_focus/$1";

$route['output/pre-call-email-technical-value-focus'] = "scripts/pre_call_email_technical_value_focus";
$route['output/pre-call-email-technical-value-focus/(:any)'] = "scripts/pre_call_email_technical_value_focus/$1";


$route['output/saw-you-on-linkedin-value-focus'] = "scripts/saw_you_on_linkedin_value_focus";
$route['output/saw-you-on-linkedin-value-focus/(:any)'] = "scripts/saw_you_on_linkedin_value_focus/$1";

$route['output/saw-you-on-linkedin-pain-focus'] = "scripts/saw_you_on_linkedin_pain_focus";
$route['output/saw-you-on-linkedin-pain-focus/(:any)'] = "scripts/saw_you_on_linkedin_pain_focus/$1";

$route['output/saw-you-on-linkedin-email-thread'] = "scripts/saw_value";
$route['output/saw-you-on-linkedin-email-thread/(:any)'] = "scripts/saw_value/$1";

$route['output/saw-you-on-linkedin-email-thread-v3'] = "scripts/saw_valuev3";
$route['output/saw-you-on-linkedin-email-thread-v3/(:any)'] = "scripts/saw_valuev3/$1";

$route['output/linkedin-technical-value'] = "scripts/linkedin_technical_value";
$route['output/linkedin-technical-value/(:any)'] = "scripts/linkedin_technical_value/$1";

$route['output/linkedin-business-value'] = "scripts/linkedin_business_value";
$route['output/linkedin-business-value/(:any)'] = "scripts/linkedin_business_value/$1";

$route['output/linkedin-personal-value'] = "scripts/linkedin_personal_value";
$route['output/linkedin-personal-value/(:any)'] = "scripts/linkedin_personal_value/$1";

$route['output/linkedin-technical-pain'] = "scripts/linkedin_technical_pain";
$route['output/linkedin-technical-pain/(:any)'] = "scripts/linkedin_technical_pain/$1";

$route['output/linkedin-business-pain'] = "scripts/linkedin_business_pain";
$route['output/linkedin-business-pain/(:any)'] = "scripts/linkedin_business_pain/$1";

$route['output/linkedin-personal-pain'] = "scripts/linkedin_personal_pain";
$route['output/linkedin-personal-pain/(:any)'] = "scripts/linkedin_personal_pain/$1";

$route['output/post_call_email_technical_value_focus'] = "scripts/post_call_email_technical_value_focus";
$route['output/post_call_email_technical_value_focus/(:any)'] = "scripts/post_call_email_technical_value_focus/$1";

$route['output/post_call_email_business_value_focus'] = "scripts/post_call_email_business_value_focus";
$route['output/post_call_email_business_value_focus/(:any)'] = "scripts/post_call_email_business_value_focus/$1";

$route['output/post_call_email_personal_value_focus'] = "scripts/post_call_email_personal_value_focus";
$route['output/post_call_email_personal_value_focus/(:any)'] = "scripts/post_call_email_personal_value_focus/$1";

$route['output/post_call_email_technical_pain_focus'] = "scripts/post_call_email_technical_pain_focus";
$route['output/post_call_email_technical_pain_focus/(:any)'] = "scripts/post_call_email_technical_pain_focus/$1";

$route['output/post_voice_email_business_pain_focus'] = "scripts/post_voice_email_business_pain_focus";
$route['output/post_voice_email_business_pain_focus/(:any)'] = "scripts/post_voice_email_business_pain_focus/$1";

$route['output/post_voice_email_personal_pain_focus'] = "scripts/post_voice_email_personal_pain_focus";
$route['output/post_voice_email_personal_pain_focus/(:any)'] = "scripts/post_voice_email_personal_pain_focus/$1";

$route['output/post-voicemail-email-product'] = "scripts/post_voicemail_email_product";
$route['output/post-voicemail-email-product/(:any)'] = "scripts/post_voicemail_email_product/$1";

$route['output/pre_call_email_technical_pain'] = "scripts/pre_call_email_technical_pain";
$route['output/pre_call_email_technical_pain/(:any)'] = "scripts/pre_call_email_technical_pain/$1";

$route['output/pre_call_email_business_pain'] = "scripts/pre_call_email_business_pain";
$route['output/pre_call_email_business_pain/(:any)'] = "scripts/pre_call_email_business_pain/$1";

$route['output/pre_call_email_personal_pain'] = "scripts/pre_call_email_personal_pain";
$route['output/pre_call_email_personal_pain/(:any)'] = "scripts/pre_call_email_personal_pain/$1";

$route['output/pre_call_email_technical_qualify'] = "scripts/pre_call_email_technical_qualify";
$route['output/pre_call_email_technical_qualify/(:any)'] = "scripts/pre_call_email_technical_qualify/$1";

$route['output/pre_call_email_business_qualify'] = "scripts/pre_call_email_business_qualify";
$route['output/pre_call_email_business_qualify/(:any)'] = "scripts/pre_call_email_business_qualify/$1";

$route['output/pre_call_email_personal_qualify'] = "scripts/pre_call_email_personal_qualify";
$route['output/pre_call_email_personal_qualify/(:any)'] = "scripts/pre_call_email_personal_qualify/$1";

$route['output/pre_call_email_business_value_focus'] = "scripts/pre_call_email_business_value_focus";
$route['output/pre_call_email_business_value_focus/(:any)'] = "scripts/pre_call_email_business_value_focus/$1";

$route['output/pre_call_email_personal_value_focus'] = "scripts/pre_call_email_personal_value_focus";
$route['output/pre_call_email_personal_value_focus/(:any)'] = "scripts/pre_call_email_personal_value_focus/$1";

$route['output/pre-call-email-product-focus'] = "scripts/pre_call_email_product_focus";
$route['output/pre-call-email-product-focus/(:any)'] = "scripts/pre_call_email_product_focus/$1";

$route['output/pre-call-email-value-focus'] = "home/pre_call_email_value_focus";
$route['output/pre-call-email-value-focus/(:any)'] = "home/pre_call_email_value_focus/$1";

$route['output/pre-call-email-namedrop-focus'] = "scripts/pre_call_email_namedrop_focus";     
$route['output/pre-call-email-namedrop-focus/(:any)'] = "scripts/pre_call_email_namedrop_focus/$1";   

$route['output/last-attempt-email-technical-value'] = "scripts/last_attempt_email_technical_value";      
$route['output/last-attempt-email-technical-value/(:any)'] = "scripts/last_attempt_email_technical_value/$1";    

$route['output/last-attempt-email-business-value'] = "scripts/last_attempt_email_business_value";      
$route['output/last-attempt-email-business-value/(:any)'] = "scripts/last_attempt_email_business_value/$1";    

$route['output/last-attempt-email-personal-value'] = "scripts/last_attempt_email_personal_value";      
$route['output/last-attempt-email-personal-value/(:any)'] = "scripts/last_attempt_email_personal_value/$1";    

$route['output/call-script-focus-product'] = "scripts/call_script_focus_product";
$route['output/call-script-focus-product/(:any)'] = "scripts/call_script_focus_product/$1";

$route['output/call-script-webinar-follow-up'] = "scripts/call_script_webinar_follow_up";
$route['output/call-script-webinar-follow-up/(:any)'] = "scripts/call_script_webinar_follow_up/$1";

$route['output/call_script_email_follow_up_qualify'] = "scripts/call_script_emailfollowupandqualify";
$route['output/call_script_email_follow_up_qualify/(:any)'] = "scripts/call_script_emailfollowupandqualify/$1";

$route['output/call-script-focus-pain'] = "scripts/call_script_focus_pain";
$route['output/call-script-focus-pain/(:any)'] = "scripts/call_script_focus_pain/$1";

$route['output/call-script-name-drop'] = "scripts/call_script_name_drop";
$route['output/call-script-name-drop/(:any)'] = "scripts/call_script_name_drop/$1";

$route['output/call-script-technical-focus'] = "scripts/call_script_technical_focus";
$route['output/call-script-technical-focus/(:any)'] = "scripts/call_script_technical_focus/$1";

$route['output/call-script-business-focus'] = "scripts/call_script_business_focus";
$route['output/call-script-business-focus/(:any)'] = "scripts/call_script_business_focus/$1";

$route['output/call-script-personal-focus'] = "scripts/call_script_personal_focus";
$route['output/call-script-personal-focus/(:any)'] = "scripts/call_script_personal_focus/$1";

$route['output/voicemail-value-focus'] = "home/voicemail_value_focus";
$route['output/voicemail-value-focus/(:any)'] = "home/voicemail_value_focus/$1";

$route['output/voicemail-value-focus-appoint'] = "home/voicemail_value_focus_appoint";
$route['output/voicemail-value-focus-appoint/(:any)'] = "home/voicemail_value_focus_appoint/$1";

$route['output/voicemail-script-technical-value'] = "scripts/voicemail_script_technical_value";
$route['output/voicemail-script-technical-value/(:any)'] = "scripts/voicemail_script_technical_value/$1";

$route['output/voicemail-script-technical-value-long'] = "scripts/voicemail_script_technical_value_long";
$route['output/voicemail-script-technical-value-long/(:any)'] = "scripts/voicemail_script_technical_value_long/$1";

$route['output/voicemail-script-technical-value-appointment'] = "scripts/voicemail_script_technical_value_appointment";
$route['output/voicemail-script-technical-value-appointment/(:any)'] = "scripts/voicemail_script_technical_value_appointment/$1";

$route['output/voicemail-script-business-value'] = "scripts/voicemail_script_business_value";
$route['output/voicemail-script-business-value/(:any)'] = "scripts/voicemail_script_business_value/$1";

$route['output/voicemail-script-business-value-long'] = "scripts/voicemail_script_business_value_long";
$route['output/voicemail-script-business-value-long/(:any)'] = "scripts/voicemail_script_business_value_long/$1";

$route['output/voicemail-script-business-value-appointment'] = "scripts/voicemail_script_business_value_appointment";
$route['output/voicemail-script-business-value-appointment/(:any)'] = "scripts/voicemail_script_business_value_appointment/$1";

$route['output/voicemail-script-personal-value'] = "scripts/voicemail_script_personal_value";
$route['output/voicemail-script-personal-value/(:any)'] = "scripts/voicemail_script_personal_value/$1";

$route['output/voicemail-script-personal-value-long'] = "scripts/voicemail_script_personal_value_long";
$route['output/voicemail-script-personal-value-long/(:any)'] = "scripts/voicemail_script_personal_value_long/$1";

$route['output/voicemail-script-personal-value-appointment'] = "scripts/voicemail_script_personal_value_appointment";
$route['output/voicemail-script-personal-value-appointment/(:any)'] = "scripts/voicemail_script_personal_value_appointment/$1";

$route['output/voicemail-script-technical-pain'] = "scripts/voicemail_script_technical_pain";
$route['output/voicemail-script-technical-pain/(:any)'] = "scripts/voicemail_script_technical_pain/$1";

$route['output/voicemail-script-technical-pain-appointment'] = "scripts/voicemail_script_technical_pain_appointment";
$route['output/voicemail-script-technical-pain-appointment/(:any)'] = "scripts/voicemail_script_technical_pain_appointment/$1";

$route['output/voicemail-script-business-pain'] = "scripts/voicemail_script_business_pain";
$route['output/voicemail-script-business-pain/(:any)'] = "scripts/voicemail_script_business_pain/$1";

$route['output/voicemail-script-business-pain-appointment'] = "scripts/voicemail_script_business_pain_appointment";
$route['output/voicemail-script-business-pain-appointment/(:any)'] = "scripts/voicemail_script_business_pain_appointment/$1";

$route['output/voicemail-script-personal-pain'] = "scripts/voicemail_script_personal_pain";
$route['output/voicemail-script-personal-pain/(:any)'] = "scripts/voicemail_script_personal_pain/$1";

$route['output/voicemail-script-personal-pain-appointment'] = "scripts/voicemail_script_personal_pain_appointment";
$route['output/voicemail-script-personal-pain-appointment/(:any)'] = "scripts/voicemail_script_personal_pain_appointment/$1";


$route['output/voicemail-name-drop-focus'] = "scripts/voicemail_name_drop_focus";
$route['output/voicemail-name-drop-focus/(:any)'] = "scripts/voicemail_name_drop_focus/$1";

$route['output/voicemail-name-drop-appoint'] = "scripts/voicemail_name_drop_focus_appoint";
$route['output/voicemail-name-drop-appoint/(:any)'] = "scripts/voicemail_name_drop_focus_appoint/$1";

$route['output/voicemail-script-product'] = "scripts/voicemail_script_product";
$route['output/voicemail-script-product/(:any)'] = "scripts/voicemail_script_product/$1";

$route['output/voicemail-script-product-appoint'] = "scripts/voicemail_script_product_appoint";
$route['output/voicemail-script-product-appoint/(:any)'] = "scripts/voicemail_script_product_appoint/$1";

$route['output/voicemail-pain-focus'] = "home/voicemail_pain_focus";
$route['output/voicemail-pain-focus/(:any)'] = "home/voicemail_pain_focus/$1";

$route['output/voicemail-pain-focus-appoint'] = "home/voicemail_pain_focus_appoint";
$route['output/voicemail-pain-focus-appoint/(:any)'] = "home/voicemail_pain_focus_appoint/$1";

$route['output/post-voicemail-name-drop-focus'] = "scripts/post_voicemail_name_drop_focus";
$route['output/post-voicemail-name-drop-focus/(:any)'] = "scripts/post_voicemail_name_drop_focus/$1";

$route['output/post-voicemail-pain-focus'] = "home/post_voicemail_pain_focus";
$route['output/post-voicemail-pain-focus/(:any)'] = "home/post_voicemail_pain_focus/$1";

$route['output/post-voicemail-value-focus'] = "home/post_voicemail_value_focus";
$route['output/post-voicemail-value-focus/(:any)'] = "home/post_voicemail_value_focus/$1";

$route['output/product-matrix'] = "scripts/productMatrix";
$route['output/product-matrix/(:any)'] = "scripts/productMatrix/$1";

$route['output/sales-letter-pain-focus'] = "home/salesLetterPainFocus";
$route['output/sales-letter-pain-focus/(:any)'] = "home/salesLetterPainFocus/$1";

$route['output/sales-letter-name-drop-focus'] = "home/salesLetterNameDropFocus";
$route['output/sales-letter-name-drop-focus/(:any)'] = "home/salesLetterNameDropFocus/$1";

$route['output/sales-letter-value-focus'] = "home/salesLetterValueFocus";
$route['output/sales-letter-value-focus/(:any)'] = "home/salesLetterValueFocus/$1";

$route['output/internal-referral-email'] = "scripts/internalReferralEmail";
$route['output/internal-referral-email/(:any)'] = "scripts/internalReferralEmail/$1";

$route['output/your-information'] = "scripts/your_information";
$route['output/your-information/(:any)'] = "scripts/your_information/$1";

//By Dev@4489
$route['output/post-call-email-value-focus'] = "scripts/post_call_email_value_focus";
$route['output/post-call-email-value-focus/(:any)'] = "scripts/post_call_email_value_focus/$1";

$route['output/checking-back-in-email-pain'] = "scripts/checking_back_in_email_pain";
$route['output/checking-back-in-email-pain/(:any)'] = "scripts/checking_back_in_email_pain/$1";

$route['output/post-call-email-pain-focus'] = "scripts/post_call_email_pain_focus";
$route['output/post-call-email-pain-focus/(:any)'] = "scripts/post_call_email_pain_focus/$1";

$route['output/custom-objections-map'] = "scripts/custom_objection_map";
$route['output/custom-objections-map/(:any)'] = "scripts/custom_objection_map/$1";
////

$route['output/post-call-email-technical-business-value-focus'] = "scripts/post_call_email_technical_business_value_focus";
$route['output/post-call-email-technical-business-value-focus/(:any)'] = "scripts/post_call_email_technical_business_value_focus/$1";

$route['output/post-call-email-business-technical-value-focus'] = "scripts/post_call_email_business_technical_value_focus";
$route['output/post-call-email-business-technical-value-focus/(:any)'] = "scripts/post_call_email_business_technical_value_focus/$1";

$route['output/inbound-call-script'] = "scripts/inboundCallScript";
$route['output/inbound-call-script/(:any)'] = "scripts/inboundCallScript/$1";

$route['output/campaign-development'] = "home/CampaignDevelopment";
$route['output/campaign-development/(:any)'] = "home/CampaignDevelopment/$1";

$route['paincampaignkit'] = "home/PainCampaignKit";
$route['valuecampaignkit'] = "home/ValueCampaignKit";
$route['namedropcampaignkit'] = "home/NameDropCampaignKit";


//Added by Developer-A
$route['output/indirect-cold-call-script'] = "scripts/indirect_call_developer";
$route['output/indirect-cold-call-script/(:any)'] = "scripts/indirect_call_developer/$1";

$route['output/call-script-focus-pain'] = "scripts/call_script_focus_pain_developer";
$route['output/call-script-focus-pain/(:any)'] = "scripts/call_script_focus_pain_developer/$1";

$route['output/call-script-name-drop'] = "scripts/call_script_name_drop_developer";
$route['output/call-script-name-drop/(:any)'] = "scripts/call_script_name_drop_developer/$1";

$route['output/call-script-focus-product'] = "scripts/call_script_focus_product_developer";
$route['output/call-script-focus-product/(:any)'] = "scripts/call_script_focus_product_developer/$1";

$route['output/call-script-webinar-follow-up'] = "scripts/call_script_webinar_follow_up_developer";
$route['output/call-script-webinar-follow-up/(:any)'] = "scripts/call_script_webinar_follow_up_developer/$1";

$route['output/call_script_email_follow_up_qualify'] = "scripts/call_script_emailfollowupandqualify_developer";
$route['output/call_script_email_follow_up_qualify/(:any)'] = "scripts/call_script_emailfollowupandqualify_developer/$1";

$route['output/call-script-technical-focus'] = "scripts/call_script_technical_focus_developer";
$route['output/call-script-technical-focus/(:any)'] = "scripts/call_script_technical_focus_developer/$1";

$route['output/call-script-business-focus'] = "scripts/call_script_business_focus_developer";
$route['output/call-script-business-focus/(:any)'] = "scripts/call_script_business_focus_developer/$1";

$route['output/call-script-personal-focus'] = "scripts/call_script_personal_focus_developer";
$route['output/call-script-personal-focus/(:any)'] = "scripts/call_script_personal_focus_developer/$1";

$route['output/inbound-call-script'] = "scripts/inboundCallScript_developer";
$route['output/inbound-call-script/(:any)'] = "scripts/inboundCallScript_developer/$1";

$route['output/call-script-quick-close'] = "scripts/call_script_quick_close_developer";
$route['output/call-script-quick-close/(:any)'] = "scripts/call_script_quick_close_developer/$1";

$route['output/pre-call-email-thread-vshort'] = "scripts/pre_callv3short";
$route['output/pre-call-email-thread-vshort/(:any)'] = "scripts/pre_callv3short/$1";

$route['output/custom-script'] = "scripts/custom_script_developer";
$route['output/custom-script/(:any)'] = "scripts/custom_script_developer/$1";
$route['output/i(:any)'] = "scripts/interview_emails";
$route['output/i(:any)/(:any)'] = "scripts/interview_emails/$2";

$route['folder/new-user-training'] = "scripts/new_user_training";
//$route['folder/sales-prospecting-101'] = "scripts/sales_prospecting_101";
//$route['folder/role-play-software'] = "scripts/role_play_software";
$route['folder/sales-prospecting-basics'] = "scripts/sales_prospecting_basics";
$route['folder/sales-prospecting-techniques'] = "scripts/sales_prospecting_techniques";
$route['folder/sales-prospecting-basics-details'] = "scripts/sales_prospecting_basics_details";
$route['folder/sales-prospecting-advanced'] = "scripts/sales_prospecting_advanced";
$route['folder/sales-training'] = "scripts/sales_training";
$route['folder/crm-training'] = "scripts/crm_training";		
$route['folder/prebuilt-campaigns'] = "home/prebuilt_campaigns";
$route['folder/question-trees'] = "home/question_trees";
// Editable Template by Dev@4489
$route['home/etemplate'] = "home/editable_tempalte";
$route['home/etemplate/(:any)'] = "home/editable_tempalte/$1";
$route['home/campaign-coordinates'] = "home/campaign_coordinates";
$route['home/potential-campaigns'] = "home/potential_campaigns";
$route['ehide/(:any)'] = "home/hidetemplates/$1";

//CRM LITE by Dev@4489
$route['crm/contacts'] = "crm/contacts";
$route['crm/contacts/(:any)'] = "crm/contacts/$1";
$route['crm/accounts'] = "crm/accounts";
$route['crm/accounts/(:any)'] = "crm/accounts/$1";
$route['crm/oppurtunities'] = "crm/oppurtunities";
$route['crm/oppurtunities/(:any)'] = "crm/oppurtunities/$1";
$route['crm/tasks'] = "crm/tasks";
$route['crm/tasks/(:any)'] = "crm/tasks/$1";


//$route['folder/my-folder'] = "crm/accounts";


$route['user/jobprofile'] = "user/home";
//$route['crm/settings/sign'] = "home/sign";
/* End of file routes.php */
/* Location: ./application/config/routes.php */