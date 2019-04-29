<?php

if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

session_start();

class Chrome extends CI_Controller
{
    /**
     *
     * Properties
     *
     */
    private $_api_key;

    private $_verify_key;

    private $_api_url;

    private $_format;

    private $_fields = [];

    private $_data;

    //--------------------------------------------------------------

    /**
     *
     * Constructor
     *
     */
    public function __construct()
    {
        parent::__construct();

        $this->output->nocache();

        $this->load->helper('form');

        $this->load->library('session');

        $this->_api_key = '4j626eK2ghfKxvCTV2dF';

        $this->_verify_key = 'K2ghfKxv';

        $this->_api_url = 'https://salesscripter.com/members/api/';

        $this->_format = 'json';

        $this->load->model('home_model', 'home');

        $this->load->model('campaign_model', 'campaign');

        $this->load->model('product_model', 'productModel');

        $this->load->model('chromeapp_model', 'chrapp');

        $this->load->model('crm_model', 'crm');

        $this->load->model('email_model', 'email');

        $this->load->model('link_model', 'link');

        $this->load->model('emailevent_model', 'email_event');

        $this->load->model('linkevent_model', 'link_event');

        $this->load->model('userdevice_model', 'user_device');

        $this->load->library('Uuid', 'uuid');

        $this->load->library('array_group_by', 'array_group_by');

        $this->load->model('user_model', 'user');
    }

    //--------------------------------------------------------------

    //Account Login

    public function login()
    {
        $ssparms = ['ssuser' => $this->input->post('txt_ss_loginname'), 'sspword' => $this->input->post('txt_ss_loginpword')];

        $amember_api = 'e9AHVS8lMlc4xdiHeKeP';

        $act_url = 'https://salesscripter.com/members/api/check-access/by-login-pass?_key=' . $amember_api . '&login=' . $ssparms['ssuser'] . '&pass=' . $ssparms['sspword'];

        $ch = curl_init($act_url);

        curl_setopt($ch, CURLOPT_HEADER, 0);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $output = curl_exec($ch);

        $info = curl_getinfo($ch);

        curl_close($ch);

        //echo $output."<pre>";print_r($info);

        if ($output && $info['http_code'] == 200) {
            $amemb = json_decode($output);

            if (!$amemb->ok) {
                echo 'Invalid Login details';

                exit;
            }

            if (!isset($amemb->subscriptions)) {
                echo 'No Subscriptions';

                exit;
            }

            if ($ssparms['ssuser'] == 'test63test') {

                //print_r($amemb->subscriptions);

                //echo ($amemb->subscriptions);
            }

            echo '1';//echo "Subscribed.";

            exit;
        }

        //echo "Unable to Login.";
    }

    /**
     *
     * templates
     *
     * Get Email Templates
     *
     */
    public function Templates()
    {
        $ssparms = ['ssuser' => $this->input->post('txt_ss_loginname'), 'sspword' => $this->input->post('txt_ss_loginpword')];

        $user_name = $ssparms['ssuser'];

        $amuser = $this->chrapp->getUser($user_name);

        $userid = $amuser['user_id'];

        $_SESSION['ss_user_id'] = $userid;

        $alltemplates = $this->campaign->get_Email_templates();

        $message = '';

        $cmpid = 0;

        $active_campaign_data = $this->campaign->get_campaign_active($userid);

        if ($active_campaign_data) {
            $cmpid = $active_campaign_data->campaign_id;
        }

        $_data['drop_campaign'] = $this->campaign->get_drop_campaign();

        $_data['drop_company'] = $this->campaign->get_drop_company();

        $_data['drop_name'] = $this->campaign->get_drop_name_profiles();

        //$this->load->view('common/drop_menu', $_data);

        //Campaign Dropdowns

        $camaign_dropdown_data = $this->load->view('chrome/campaign_dropdowns', $_data, true);

        $message .= $camaign_dropdown_data;

        $message .= '<div id="template_list">';

        if ($alltemplates) {
            $email_templates = [];

            foreach ($alltemplates as $atemplate) {
                $etemplate = $this->chrapp->ucustom_template($atemplate->temp_id, $cmpid, $userid);

                if ($etemplate && $etemplate->temp_title) {
                    $atemplate->temp_title = $etemplate->temp_title;
                }

                $email_templates[] = $atemplate;
            }

            $message .= 'Email Templates <select id="ss_email_template">';

            $message .= '<option value="">Select Template</option>';

            $tempid = 0;

            foreach ($email_templates as $t):

                if (in_array($t->temp_id, [68, 69, 70, 71]) !== false) {
                    continue;
                }

            if ($tempid == $t->temp_id) {
                continue;
            }

            $message .= '<option value="' . $t->temp_id . '-' . $t->sect_id . '">' . $t->temp_title . '</option>';

            $tempid = $t->temp_id;

            endforeach;

            $message .= '</select>';
        }

        //Saved email templates list
        $where = ['userid' => $userid];
        $uemail_templates = $this->crm->get_uemail_templates($where);

        if ($uemail_templates) {
            $et1 = '';
            //$et2='';

            foreach ($uemail_templates as $et) {
                //if($et->schparent==-1) $et1 .='<option value="T'.$et->tid.'">'.$et->tempname.'</option>';
                //else
                if ($et->schparent == 0) {
                    $et2 .= '<option value="' . $et->tid . '">' . ($et->tempname ? $et->tempname : $et->subject) . '</option>';
                }
            }
            //if($et1) $et1='<optgroup label="Email Threads">'.$et1.'</optgroup>';
            //if($et2) $et2='<optgroup label="Email Templates">'.$et2.'</optgroup>';
            $uemail_templates = '<option value="">Select Template</option>' . $et2;

            $message .= ' Saved Email Templates <select id="ss_uemail_template">' . $uemail_templates;
            $message .= '</select>';
        }

        $message .= '</div>';

        //$message = "Sales Scripter";

        echo $message;

        //exit;
    }

    /**
     *
     * templates
     *
     * Get Email Templates
     *
     */
    public function listTemplates()
    {
        $ssparms = ['ssuser' => $this->input->post('txt_ss_loginname'), 'sspword' => $this->input->post('txt_ss_loginpword')];

        $user_name = $ssparms['ssuser'];

        $amuser = $this->chrapp->getUser($user_name);

        $userid = $amuser['user_id'];

        $_SESSION['ss_user_id'] = $userid;

        //Save sales pitch dropdowns

        if ($userid) {
            if ($this->input->post('activedropname')) {
                $newactivedrop_id = $this->input->post('activedropname');

                $this->campaign->incativeAllcredibility();

                $this->campaign->activedropname($newactivedrop_id);
            }

            if ($this->input->post('activecompaignname')) {
                $newactive_cam = $this->input->post('activecompaignname');

                $this->campaign->incativeAllCampaign();

                $this->campaign->activeSingleCampaign($newactive_cam);
            }

            if ($this->input->post('activecompanyname')) {
                $newactive_cam = $this->input->post('activecompanyname');

                $this->campaign->inAnctiveallcompany();

                $this->campaign->activateCompany($newactive_cam);
            }
        }

        ////

        $alltemplates = $this->campaign->get_Email_templates();

        $message = '';

        $cmpid = 0;

        $active_campaign_data = $this->campaign->get_campaign_active($userid);

        if ($active_campaign_data) {
            $cmpid = $active_campaign_data->campaign_id;
        }

        if ($alltemplates) {
            $email_templates = [];

            foreach ($alltemplates as $atemplate) {
                $etemplate = $this->chrapp->ucustom_template($atemplate->temp_id, $cmpid, $userid);

                if ($etemplate && $etemplate->temp_title) {
                    $atemplate->temp_title = $etemplate->temp_title;
                }

                $email_templates[] = $atemplate;
            }

            $message .= 'Email Templates: <select id="ss_email_template">';

            $message .= '<option value="">Select Template</option>';

            $tempid = 0;

            foreach ($email_templates as $t):

                if ($tempid == $t->temp_id) {
                    continue;
                }

            $message .= '<option value="' . $t->temp_id . '-' . $t->sect_id . '">' . $t->temp_title . '</option>';

            $tempid = $t->temp_id;

            endforeach;

            $message .= '</select>';
        }

        //Saved email templates list
        $where = ['userid' => $userid];
        $uemail_templates = $this->crm->get_uemail_templates($where);

        if ($uemail_templates) {
            $et1 = '';
            //$et2='';

            foreach ($uemail_templates as $et) {
                //if($et->schparent==-1) $et1 .='<option value="T'.$et->tid.'">'.$et->tempname.'</option>';
                //else
                if ($et->schparent == 0) {
                    $et2 .= '<option value="' . $et->tid . '">' . ($et->tempname ? $et->tempname : $et->subject) . '</option>';
                }
            }
            //if($et1) $et1='<optgroup label="Email Threads">'.$et1.'</optgroup>';
            //if($et2) $et2='<optgroup label="Email Templates">'.$et2.'</optgroup>';
            $uemail_templates = '<option value="">Select Template</option>' . $et2;

            $message .= ' Saved Email Templates <select id="ss_uemail_template">' . $uemail_templates;
            $message .= '</select>';
        }

        $message .= '</div>';

        //$message = "Sales Scripter";

        echo $message;

        //exit;
    }

    //Get Email Template Data

    public function getTemplate()
    {
        $ssparms = ['ssuser' => $this->input->post('txt_ss_loginname'), 'sspword' => $this->input->post('txt_ss_loginpword')];

        $user_name = $ssparms['ssuser'];

        $amuser = $this->chrapp->getUser($user_name);

        $userid = $amuser['user_id'];

        $_SESSION['ss_user_id'] = $userid;

        //Get Template

        $tmpid = $this->input->get('sset');

        if ($tmpid) {
            $active_campaign_data = $this->campaign->get_campaign_active($userid);

            $this->_data['campaign_info'] = $active_campaign_data;

            $this->_data['active_name_drop_exp'] = $this->campaign->findActiveNameDropForOutput();

            $company_info_detail = $this->productModel->getCompanyInfo($userid);

            $this->_data['company_info'] = $company_info_detail;

            //Signature

            $where = [];

            $where['user_id'] = $userid;

            $where['field_type'] = 'smtp';

            $user_info = $this->home->getUserData($where);

            if ($user_info) {
                $user_info = $user_info[0];
            }

            if (isset($user_info->value)) {
                $this->_data['aMember'] = unserialize($user_info->value);
            }

            if ($company_info_detail) {
                $this->_data['aMember']['ycompany'] = $company_info_detail->company_name;

                $this->_data['aMember']['ywebsite'] = $company_info_detail->company_website;
            }

            $signature = '';

            if ($this->_data['aMember']) {
                $aMember = $this->_data['aMember'];

                //echo '<pre>'; print_r($aMember); echo '</pre>';

                $signature = '<p><span>' . $aMember['email_signature'] . '</span><br />';

                /*if($aMember['ytitle']) $signature .='<span>'.$aMember['ytitle'].'</span> <br />';

                $signature .='<span>'.$aMember['ycompany'].'</span> <br />';

                if($aMember['yphone'])$signature .='<span>'.$aMember['yphone'].'</span> <br />';

                $signature .='<span><a href="mailto:'.$aMember['yemail'].'">'.$aMember['yemail'].'</a></span> <br />';

                if($aMember['ywebsite']){

                    if(substr($aMember['ywebsite'],0,4)<>"http") $WebsiteHttp = "http://"; else  $WebsiteHttp = "";

                    $signature .='<span><a href="'.$WebsiteHttp.$aMember['ywebsite'].'" target="_blank">'.$aMember['ywebsite'].'</a></span> <br />';

                }*/

                $signature .= '</p>';
            }

            //$ced_esign = $aMember['email_signature'];
            /*$where = array();
            $where['user_id'] = $userid;
            $where['field_type'] = 'smtp';
            $user_info = $this->->getUserData($where);
            if($user_info && isset($user_info[0]))
            {
                $k = unserialize($user_info[0]->value);
                if(isset($k['email_signature']) && $k['email_signature'])
                {
                    $signature =  $k['email_signature'];
                }
            }*/
            //$email_signature = $signature;

            $this->_data['email_signature'] = $signature;

            /*echo $signature;
            exit;*/

            //SAVED EMAIL TEMPLATE
            $uet = $this->input->get('u');
            if ($uet) {
                $emailTemplate = $this->crm->get_uemail_template($tmpid, $userid);
                if ($emailTemplate) {
                    //Replace Email Signature

                    $html = $emailTemplate['content'];
                    $html = str_replace('{email signature}', $this->_data['email_signature'], $html);

                    $subject = $emailTemplate['subject'];

                    $email = ['subject' => $subject, 'ebody' => $html];

                    echo json_encode($email);
                }

                exit;
            }

            //Get Campaign Value page all anwsers

            $this->_data['campaign_output_tech_val_asnwers'] = $this->campaign->getTechValueAnswersAll($active_campaign_data->campaign_id);

            $this->_data['campaign_output_tech_val'] = $this->campaign->getOutputTechValue($active_campaign_data->campaign_id);

            $this->_data['campaign_output_tech_pain'] = $this->campaign->getOutputTechPain($active_campaign_data->campaign_id);

            $this->_data['campaign_output_tech_qualify'] = $this->campaign->getOutputTechQualify($active_campaign_data->campaign_id);

            $this->_data['campaign_tech_summary'] = $this->campaign->getCampaignMetadata($active_campaign_data->campaign_id, 'tech_val_summary');

            $this->_data['sale_process_close1'] = $this->campaign->getCampaignMetadata($active_campaign_data->campaign_id, 'sale_process_close1');

            $this->_data['sale_process_close2'] = $this->campaign->getCampaignMetadata($active_campaign_data->campaign_id, 'sale_process_close2');

            $this->_data['sale_process_close3'] = $this->campaign->getCampaignMetadata($active_campaign_data->campaign_id, 'sale_process_close3');

            // var_dump($this->_data['campaign_biz_summary']) ; die();

            /** product related query **/
            $this->_data['P_Q1'] = $this->productModel->getProMetaData($active_campaign_data->product_id, 'P_Q1');

            $this->_data['product_desc'] = $this->productModel->getProMetaData($active_campaign_data->product_id, 'P_Desc');

            $this->_data['diff1'] = $this->productModel->getProMetaData($active_campaign_data->product_id, 'interestB1');

            $this->_data['diff2'] = $this->productModel->getProMetaData($active_campaign_data->product_id, 'interestB2');

            $this->_data['diff3'] = $this->productModel->getProMetaData($active_campaign_data->product_id, 'interestB3');

            $this->_data['negative_impact1'] = $this->productModel->getProMetaData($active_campaign_data->product_id, 'negative_impact1');

            $this->_data['negative_impact2'] = $this->productModel->getProMetaData($active_campaign_data->product_id, 'negative_impact2');

            $this->_data['negative_impact3'] = $this->productModel->getProMetaData($active_campaign_data->product_id, 'negative_impact3');

            $tsarr = explode('-', $tmpid);

            $tempID = $tsarr[0];

            $sectID = $tsarr[1];

            $template_content = $this->campaign->get_template_content($tempID, $active_campaign_data->campaign_id);

            if ($template_content) {

                //Replace Email Signature

                $html = $template_content[0]->sect_content;

                //$html = str_replace('[Email Signature]',$this->_data['email_signature'],$html);

                $html = str_replace('{email signature}', $this->_data['email_signature'], $html);

                $sub1 = explode('<p><strong>Subject line:', $html);

                $sub2 = explode('</p>', $sub1[1]);

                $subreplace = '<p><strong>Subject line:' . $sub2[0] . '</p>';

                $subject = strip_tags($subreplace);

                $subject = str_replace('Subject line:', '', $subject);

                $html = str_replace($subreplace, '', $html);

                //$html = str_replace("<br />","\n",$html);

                //$html = strip_tags($html);

                $subject = $template_content[0]->sect_subject;

                $email = ['subject' => $subject, 'ebody' => $html];

                echo json_encode($email);

                exit;
            } else {
                $template_sections = $this->campaign->get_template_sections($tempID);

                //print_r($_REQUEST);print_r($template_sections);echo $tempID;exit;

                foreach ($template_sections as $ts) {
                    $this->_data['content_id'] = $ts->content_id;

                    $this->_data['user_id'] = $userid;

                    $this->_data['edittemp'] = 1;

                    $html = $this->load->view('outputs/custom_content/custom_etemplate_data', $this->_data, true);

                    $sub1 = explode('<p><strong>Subject line:', $html);

                    $sub2 = explode('</p>', $sub1[1]);

                    $subreplace = '<p><strong>Subject line:' . $sub2[0] . '</p>';

                    $subject = strip_tags($subreplace);

                    $subject = str_replace('Subject line:', '', $subject);

                    $html = str_replace($subreplace, '', $html);

                    $html = str_replace('{email signature}', $this->_data['email_signature'], $html);

                    //$html = str_replace("<br />","\n",$html);

                    //$html = strip_tags($html);

                    $email = ['subject' => $subject, 'ebody' => $html];

                    echo json_encode($email);

                    //echo $html;

                    //$temp_array[] = array('subject'=>$ts->sect_title,'info'=>$html,'schcount'=>1,'schtype'=>2,'saved'=>0);

                    break;
                }
            }

            //echo json_encode($temp_array);

            exit;
        }
    }

    //track email activity

    public function trackActivity()
    {

        //error_reporting(E_ALL);

        //ini_set("display_errors", 1);

        $ssparms = ['ssuser' => $this->input->post('txt_ss_loginname'), 'sspword' => $this->input->post('txt_ss_loginpword')];

        $user_name = $ssparms['ssuser'];

        $amuser = $this->chrapp->getUser($user_name);

        if (!$amuser) {
            return;
        }

        $userid = $amuser['user_id'];

        $_SESSION['ss_user_id'] = $userid;

        $params = ['email' => $this->input->post('email'), 'subject' => $this->input->post('subject'), 'ebody' => $this->input->post('ebody'), 'etname' => $this->input->post('etname')];

        //print_r($params);

        $params['email'] = array_unique($params['email']);

        $params['email'] = array_filter($params['email']);

        if (empty($params['email'])) {
            return;
        }

        $task_email_content = $params['ebody'];

        $this->load->helper('scripts');

        //$categories = crm_options();
        $categories = crm_introptions();

        $c = 2;

        $s = 1;

        $opt = 1;

        $sec_val = $categories['category'][$c][$s];

        $sec_opt = $sec_val['options'];

        $points = $sec_opt[$opt]['points'];

        $pursuit = $sec_opt[$opt]['pursuit'];

        $iname = $sec_opt[$opt]['name'];

        $idate = date('Y-m-d');

        $template_name = $params['etname'];

        foreach ($params['email'] as $eml) {
            $contact = $this->chrapp->get_contact($eml, $userid);

            if (!$contact) {
                continue;
            }

            $parent_id = $contact['contact_id'];

            //Task

            $taskdata = [

                    'task_subject' => 'Email Sent',

                    'task_name' => $template_name,

                    'task_priority' => 'Normal',

                    'task_status' => 'Completed',

                    'task_duedate' => $idate,

                    'task_related' => 'C',

                    'task_relatedto' => $parent_id,

                    'share_user_id' => $userid,

                    'userid' => $userid,

                    'task_created' => $idate . ' 00:00:00',

                    'task_modified' => $idate . ' 00:00:00',

                    'task_info' => $task_email_content,

                    ];

            $tid = $this->crm->save_task($taskdata, 0);

            //check points and save

            $where = ['contact' => $parent_id, 'cat' => $c, 'pdate' => $idate, 'rctype' => 'C'];

            $cont_points = $this->crm->get_points($where);

            //print_r($cont_points);

            if ($cont_points) {
                $update_data = [

                        'contact' => $parent_id,

                        'cat' => $c,

                        'pdate' => $idate,

                        'rctype' => 'C',

                        ];

                $points_data = [

                        'intpoints' => $cont_points['intpoints'] + $points,

                        'purpoints' => $cont_points['purpoints'] + $pursuit,

                        'taskid' => $tid,

                        ];

                $this->crm->save_points($points_data, $update_data);
            } else {
                $points_data = [

                        'contact' => $parent_id,

                        'rctype' => 'C',

                        'pdate' => $idate,

                        'intpoints' => $points,

                        'purpoints' => $pursuit,

                        'taskid' => $tid,

                        'cat' => $c,

                        ];

                $this->crm->save_points($points_data);
            }

            //Interaction Usage

            $intr_sno = $c . '-' . $s . '-' . $opt;

            $intrdata = $this->crm->check_interaction_date($intr_sno, $idate, $userid);

            if ($intrdata) {
                $update = ['intr_count' => $intrdata['intr_count'] + 1];

                //update email template info

                if ($template_name) {
                    if ($intrdata['intr_info']) {
                        $etinfo = json_decode($intrdata['intr_info']);

                        if (isset($etinfo->tnames)) {
                            $etinfo->tnames[] = $template_name;
                        } else {
                            $etinfo->tnames = [$template_name];
                        }

                        $etinfo->tnames = array_unique($etinfo->tnames);

                        $etinfo = json_encode($etinfo);
                    } else {
                        $etinfo = ['tnames' => [$template_name]];

                        $etinfo = json_encode($etinfo);
                    }

                    $update['intr_info'] = $etinfo;
                }

                $this->crm->save_interaction_date($update, $intrdata);
            } else {
                $update = [

                    'intr_cat' => $c,

                    'intr_sect' => $s,

                    'intr_opt' => $opt,

                    'intr_otype' => 'I',

                    'intr_sno' => $intr_sno,

                    'intr_rctype' => 'C',

                    'intr_recid' => $parent_id,

                    'intr_user' => $userid,

                    'intr_task' => $tid,

                    'intr_date' => $idate, ];

                //Insert Email template info

                if ($template_name) {
                    $etinfo = ['tnames' => [$template_name]];

                    $etinfo = json_encode($etinfo);

                    $update['intr_info'] = $etinfo;
                }

                $this->crm->save_interaction_date($update);
            }
        }

        return;
    }

    //Campaign Dropdowns
    public function sscampaigns()
    {

        //error_reporting(E_ALL);
        //ini_set("display_errors", 1);

        $ssparms = ['ssuser' => $this->input->post('txt_ss_loginname'), 'sspword' => $this->input->post('txt_ss_loginpword')];
        //$ssparms = array("ssuser"=>$this->input->get('txt_ss_loginname'),"sspword"=>$this->input->get('txt_ss_loginpword'));
        $user_name = $ssparms['ssuser'];
        $amuser = $this->chrapp->getUser($user_name);
        if (!$amuser) {
            echo '';
            exit;
        }

        $userid = $amuser['user_id'];
        $_SESSION['ss_user_id'] = $userid;

        $message = '';
        $cmpid = 0;

        $active_campaign_data = $this->campaign->get_campaign_active($userid);
        if ($active_campaign_data) {
            $cmpid = $active_campaign_data->campaign_id;
        }
        $campaigns = $this->chrapp->get_campaigns();
        $drop_company = $this->chrapp->get_companies();
        $drop_name = $this->campaign->get_drop_name_profiles();
        $namedrops = [];
        if ($drop_name) {
            foreach ($drop_name as $rec) {
                $namedrops[] = ['id' => $rec->c_id, 'title' => $rec->value ? $rec->value : $rec->credibility_name, 'status' => $rec->status];
            }
        }

        //default templates
        $def_temps = [];
        $def_temps[] = ['id' => '', 'title' => 'Select Template'];
        $alltemplates = $this->campaign->get_Email_templates();
        if ($alltemplates) {
            $email_templates = [];
            foreach ($alltemplates as $atemplate) {
                $etemplate = $this->chrapp->ucustom_template($atemplate->temp_id, $cmpid, $userid);
                if ($etemplate && $etemplate->temp_title) {
                    $atemplate->temp_title = $etemplate->temp_title;
                }
                $email_templates[] = $atemplate;
            }
            $tempid = 0;
            foreach ($email_templates as $t):
                if (in_array($t->temp_id, [68, 69, 70, 71]) !== false) {
                    continue;
                }
            if ($tempid == $t->temp_id) {
                continue;
            }
            $def_temps[] = ['id' => $t->temp_id . '-' . $t->sect_id, 'title' => $t->temp_title];
            $tempid = $t->temp_id;
            endforeach;
        }

        //Saved email templates list
        $saved_temps = [];
        $saved_temps[] = ['id' => '', 'title' => 'Select Template'];
        $where = ['userid' => $userid];
        $uemail_templates = $this->crm->get_uemail_templates($where);

        if ($uemail_templates) {
            foreach ($uemail_templates as $et) {
                if ($et->schparent == 0) {
                    $saved_temps[] = ['id' => $et->tid, 'title' => ($et->tempname ? $et->tempname : $et->subject)];
                }
            }
        }

        $dropdowns = ['campaigns' => $campaigns, 'companies' => $drop_company, 'namedrops' => $namedrops, 'default' => $def_temps, 'saved' => $saved_temps];
        echo json_encode($dropdowns);

        return;
    }

    //Get templates based on dropdown change
    public function sstemplates()
    {
        $ssparms = ['ssuser' => $this->input->post('txt_ss_loginname'), 'sspword' => $this->input->post('txt_ss_loginpword')];
        //$ssparms = array("ssuser"=>$this->input->get('txt_ss_loginname'),"sspword"=>$this->input->get('txt_ss_loginpword'));

        $user_name = $ssparms['ssuser'];
        $amuser = $this->chrapp->getUser($user_name);
        if (!$amuser) {
            echo '';
            exit;
        }
        $userid = $amuser['user_id'];
        $_SESSION['ss_user_id'] = $userid;

        //Save sales pitch dropdowns

        if ($userid) {
            if ($this->input->post('activedropname')) {
                $newactivedrop_id = $this->input->post('activedropname');
                $this->campaign->incativeAllcredibility();
                $this->campaign->activedropname($newactivedrop_id);
            }

            if ($this->input->post('activecompaignname')) {
                $newactive_cam = $this->input->post('activecompaignname');
                $this->campaign->incativeAllCampaign();
                $this->campaign->activeSingleCampaign($newactive_cam);
            }

            if ($this->input->post('activecompanyname')) {
                $newactive_cam = $this->input->post('activecompanyname');
                $this->campaign->inAnctiveallcompany();
                $this->campaign->activateCompany($newactive_cam);
            }
        }

        ////

        $alltemplates = $this->campaign->get_Email_templates();

        $cmpid = 0;
        $active_campaign_data = $this->campaign->get_campaign_active($userid);
        if ($active_campaign_data) {
            $cmpid = $active_campaign_data->campaign_id;
        }

        //default templates
        $def_temps = [];
        $def_temps[] = ['id' => '', 'title' => 'Select Template'];
        $alltemplates = $this->campaign->get_Email_templates();
        if ($alltemplates) {
            $email_templates = [];
            foreach ($alltemplates as $atemplate) {
                $etemplate = $this->chrapp->ucustom_template($atemplate->temp_id, $cmpid, $userid);
                if ($etemplate && $etemplate->temp_title) {
                    $atemplate->temp_title = $etemplate->temp_title;
                }
                $email_templates[] = $atemplate;
            }
            $tempid = 0;
            foreach ($email_templates as $t):
                if (in_array($t->temp_id, [68, 69, 70, 71]) !== false) {
                    continue;
                }
            if ($tempid == $t->temp_id) {
                continue;
            }
            $def_temps[] = ['id' => $t->temp_id . '-' . $t->sect_id, 'title' => $t->temp_title];
            $tempid = $t->temp_id;
            endforeach;
        }

        //Saved email templates list
        $saved_temps = [];
        $saved_temps[] = ['id' => '', 'title' => 'Select Template'];
        $where = ['userid' => $userid];
        $uemail_templates = $this->crm->get_uemail_templates($where);

        if ($uemail_templates) {
            foreach ($uemail_templates as $et) {
                if ($et->schparent == 0) {
                    $saved_temps[] = ['id' => $et->tid, 'title' => ($et->tempname ? $et->tempname : $et->subject)];
                }
            }
        }

        $dropdowns = ['default' => $def_temps, 'saved' => $saved_temps];
        echo json_encode($dropdowns);

        return;
    }

    public function isContactExists()
    {
        $userName = $this->input->post('txt_ss_loginname');

        $email = $this->input->post('email');

        $amUser = $this->chrapp->getUser($userName);

        if (!$amUser) {
            echo json_encode(['result' => false]);

            return;
        }

        $userId = $amUser['user_id'];

        $_SESSION['ss_user_id'] = $userId;

        if ($userId) {
            if ($email) {
                $contactInfo = $this->crm->get_contact_by_email($email, $userId);
                if (!empty($contactInfo)) {
                    $output = ['result' => true, 'message' => 'Email id exists'];
                } else {
                    $output = ['result' => false, 'message' => 'Email id does not exists'];
                }
            } else {
                $output = ['result' => false, 'message' => 'Invalid email id'];
            }
        } else {
            $output = ['result' => false, 'message' => 'Invalid user'];
        }
        echo json_encode($output);

        return;
    }

    public function saveContact()
    {
        $userName = $this->input->post('txt_ss_loginname');
        $firstName = $this->input->post('first_name');
        $lastName = $this->input->post('last_name');
        $email = $this->input->post('email');

        $amUser = $this->chrapp->getUser($userName);

        if (!$amUser) {
            echo json_encode(['result' => false]);

            return;
        }

        $userId = $amUser['user_id'];

        $_SESSION['ss_user_id'] = $userId;

        $contactData = ['user_first' => $firstName, 'user_last' => $lastName, 'email' => $email,  'share_user_id' => $userId];

        if ($userId) {
            if ($firstName && $email) {
                $isContactExists = $this->crm->get_contact_by_email($email, $userId);
                if (!empty($isContactExists)) {
                    $output = ['result' => false, 'data' => $contactData, 'message' => 'Contact already exists'];
                    echo json_encode($output);

                    return;
                }
                $contactInfo = $this->crm->save_contact($contactData);
                if ($contactInfo) {
                    $output = ['result' => true, 'data' => $contactInfo, 'message' => 'Contact saved successfully'];
                } else {
                    $output = ['result' => false, 'data' => $contactInfo, 'message' => 'Contact not saved'];
                }
            } else {
                $output = ['result' => false, 'message' => 'Invalid input data'];
            }
        } else {
            $output = ['result' => false, 'message' => 'Invalid user'];
        }
        echo json_encode($output);

        return;
    }

    public function postEmail()
    {
        $userName = $this->input->post('txt_ss_loginname');

        $amUser = $this->chrapp->getUser($userName);

        if (!$amUser) {
            echo json_encode(['result' => false]);

            return;
        }

        $userId = $amUser['user_id'];

        $_SESSION['ss_user_id'] = $userId;

        if ($userId) {
            if ($this->input->post('id')) {
                $emailData = ['id' => $this->input->post('id'), 'name' => $this->input->post('name'), 'subject' => $this->input->post('subject'), 'gmail_message_id' => $this->input->post('gmail_message_id'), 'gmail_thread_id' => $this->input->post('gmail_thread_id'), 'email_sent_time' => date('Y-m-d\TH:i:s\Z'), 'cc_recipient' => $this->input->post('cc_recipient'), 'bcc_recipient' => $this->input->post('bcc_recipient'), 'recipient' => $this->input->post('recipient'), 'created_on' => date('Y-m-d\TH:i:s\Z'), 'updated_on' => date('Y-m-d\TH:i:s\Z'), 'is_deleted' => 0, 'user_id' => $userId];
                $res = $this->email->create($emailData);
                log_message('message', 'Email saved result');
                if ($res) {
                    $links = json_decode($this->input->post('links'), true);
                    if (!empty($links)) {
                        for ($i = 0; $i < count($links); $i++) {
                            $linkData = ['id' => $links[$i]['linkId'], 'link' => $links[$i]['link']['link'],
                            'email_id' => $this->input->post('id'), 'created_on' => date('Y-m-d\TH:i:s\Z'),
                            'updated_on' => date('Y-m-d\TH:i:s\Z'), 'is_deleted' => 0, ];
                            $this->link->create($linkData);
                        }
                    } else {
                        error_log('Link array is empty');
                    }
                    $output = ['result' => true, 'data' => $res, 'message' => 'Email saved successfully'];
                    log_message('message', 'Email saved successfully');
                } else {
                    $output = ['result' => false, 'message' => 'Email not saved'];
                }
            } else {
                $output = ['result' => false, 'message' => 'Invalid email id'];
            }
        } else {
            $output = ['result' => false, 'message' => 'Invalid user'];
        }
        echo json_encode($output);

        return;
    }

    public function postEmailEvent()
    {
        log_message('error', 'Inside Post Email Event---------' . $this->uri);
        $image = '6wzwc+flkuJiYGDg9fRwCQLSjCDMwQQkJ5QH3wNSbCVBfsEMYJC3jH
        0ikOLxdHEMqZiTnJCQAOSxMDB+E7cIBcl7uvq5rHNKaAIA';
        $pngImage = $this->uri->segment('3');
        $email = explode('.png', $pngImage)[0];

        if ($email) {
            $res = $this->email->read($email);
            if ($res) {
                $recipient = json_decode($res[0]->recipient);
                $recipientEmail = $recipient[0]->emailAddress;
                $emailEventData = ['id' => $this->uuid->v4(), 'email_read_time' => date('Y-m-d\TH:i:s\Z'), 'email_clicked_device_name' => '', 'email_id' => $email, 'created_on' => date('Y-m-d\TH:i:s\Z'), 'updated_on' => date('Y-m-d\TH:i:s\Z'), 'is_deleted' => 0,
                    'user_agent' => '', 'read_recipient' => $recipientEmail, ];
                $this->email_event->create($emailEventData);

                $emailEventCount = $this->email_event->getEmailEventCount($email);
                $this->sendNotification($res[0], 'emailTrack', $emailEventCount);
                log_message('error', 'created email event entry---------');
            }
        }
        echo gzinflate(base64_decode($image));

        return;
    }

    public function postLinkEvent()
    {
        $linkId = $this->input->get('ss__id', true);
        $ssUrl = $this->input->get('ss__url', true);
        $force = $this->input->get('force', true);

        if (!preg_match('/http|https/', $ssUrl)) {
            $ssUrl = 'https://' . $ssUrl;
        }
        if ($force) {
            header('Location:' . $ssUrl);

            return;
        }
        if ($linkId) {
            $linkRes = $this->link->read($linkId);
            if ($linkRes) {
                $emailId = $linkRes[0]->email_id;
                $emailRes = $this->email->read($emailId);
                if ($emailRes) {
                    $recipient = json_decode($emailRes[0]->recipient);
                    $recipientEmail = $recipient[0]->emailAddress;
                    $linkEventData = ['id' => $this->uuid->v4(), 'link_clicked_time' => date('Y-m-d\TH:i:s\Z'), 'link_clicked_device_name' => '', 'link_id' => $linkId, 'created_on' => date('Y-m-d\TH:i:s\Z'), 'updated_on' => date('Y-m-d\TH:i:s\Z'), 'is_deleted' => 0,
                'user_agent' => '', 'location' => '', 'click_recipient' => $recipientEmail, ];
                    $this->link_event->create($linkEventData);

                    $linkEventCount = $this->link_event->getLinkEventCount($linkId);
                    $this->sendNotification(
                        $emailRes[0],
                        'linkTrack',
                        $linkEventCount,
                        $linkRes[0]
                    );
                    header('Location:' . $ssUrl);
                } else {
                    error_log('Email not found');
                    header('Location:' . $ssUrl);
                }
            } else {
                error_log('Link not found');
                header('Location:' . $ssUrl);
            }
        }
        header('Location:' . $ssUrl);
    }

    public function updateEmail()
    {
        $userName = $this->input->post('txt_ss_loginname');

        $amUser = $this->chrapp->getUser($userName);

        if (!$amUser) {
            echo json_encode(['result' => false]);

            return;
        }

        $userId = $amUser['user_id'];
        $_SESSION['ss_user_id'] = $userId;
        if ($userId) {
            $emailData = ['id' => $this->input->post('email_id'), 'gmail_message_id' => $this->input->post('gmail_message_id'), 'gmail_thread_id' => $this->input->post('gmail_thread_id'), 'updated_on' => date('Y-m-d\TH:i:s\Z')];
            $res = $this->email->update($emailData);

            if ($res) {
                $output = ['result' => true, 'message' => 'Email updated successfully'];
            } else {
                $output = ['result' => false, 'message' => 'Email not updated'];
            }
        } else {
            $output = ['result' => false, 'message' => 'Invalid user'];
        }
        echo json_encode($output);

        return;
    }

    public function getEmailSummary()
    {
        $userName = $this->input->get('txt_ss_loginname');

        $amUser = $this->chrapp->getUser($userName);

        if (!$amUser) {
            echo json_encode(['result' => false]);

            return;
        }

        $userId = $amUser['user_id'];
        $_SESSION['ss_user_id'] = $userId;

        if ($userId) {
            $res = $this->email->getEmailSummary($userId);
            if ($res) {
                $grouped = $this->array_group_by->array_group_by($res, 'email_id');

                // print_r($grouped);

                $emailsCollection = [];

                foreach ($grouped as $email_id => $email) {
                    $emailEventsCollection = [];

                    foreach ($email as $email_event_id => $email_event) {
                        if (!empty($email_event['email_event_id'])) {
                            $emailEventModel = (object) [
                            'id' => $email_event['email_event_id'],
                            'email_clicked_device_name' => $email_event['email_clicked_device_name'],
                            'email_id' => $email_event['event_email_id'],
                            'email_read_time' => $email_event['email_read_time'],
                            'is_deleted' => $email_event['is_deleted'],
                            'created_on' => $email_event['created_on'],
                            'updated_on' => $email_event['updated_on'],
                            'user_agent' => $email_event['user_agent'],
                            'read_recipient' => $email_event['read_recipient'],
                            ];
                            array_push($emailEventsCollection, $emailEventModel);
                        }
                    }
                    $emailModel = (object) [
                        'created_on' => $email_event['email_created_on'],
                        'cc_recipient' => $email_event['cc_recipient'],
                        'bcc_recipient' => $email_event['bcc_recipient'],
                        'recipient' => $email_event['recipient'],
                        'email_event_collection' => $emailEventsCollection,
                        'email_sent_time' => $email_event['email_sent_time'],
                        'gmail_message_id' => $email_event['gmail_message_id'],
                        'gmail_thread_id' => $email_event['gmail_thread_id'],
                        'id' => $email_event['email_id'],
                        'is_deleted' => $email_event['email_is_deleted'],
                        'name' => $email_event['name'],
                        'subject' => $email_event['subject'],
                        'updated_on' => $email_event['email_updated_on'],
                        'user_id' => $email_event['user_id'],
                    ];
                    array_push($emailsCollection, $emailModel);
                }

                $output = ['result' => true, 'data' => $emailsCollection, 'message' => 'Sucess'];
            } else {
                $output = ['result' => false, 'message' => 'No EmailSummary Found'];
            }
        } else {
            $output = ['result' => false, 'message' => 'Invalid user'];
        }
        echo json_encode($output);

        return;
    }

    public function getLinkSummary()
    {
        $userName = $this->input->get('txt_ss_loginname');
        $emailId = $this->input->get('email_id');

        $amUser = $this->chrapp->getUser($userName);

        if (!$amUser) {
            echo json_encode(['result' => false]);

            return;
        }

        $userId = $amUser['user_id'];
        $_SESSION['ss_user_id'] = $userId;

        if ($userId) {
            if ($emailId) {
                $resultset = $this->link->getLinkSummary($emailId);
                if ($resultset) {
                    $grouped = $this->array_group_by->array_group_by($resultset, 'l_id');
                    $linksCollection = [];

                    foreach ($grouped as $link_id => $linkFromResultset) {
                        $linkEventsCollection = [];
                        foreach ($linkFromResultset as $link_event_id => $link_event) {
                            if (!empty($link_event['link_id'])) {
                                $linkModel = (object) [
                                'id' => $link_event['link_id'],
                                'link' => $link_event['link'],
                                'email_id' => $link_event['email_id'],
                                'is_deleted' => $link_event['link_is_deleted'],
                                'created_on' => $link_event['link_created_on'],
                                'updated_on' => $link_event['link_updated_on'],
                            ];
                            }
                            if (!empty($link_event['link_event_id'])) {
                                array_push($linkEventsCollection, (object) [
                                'id' => $link_event['link_event_id'],
                                'link_clicked_time' => $link_event['link_clicked_time'],
                                'link_clicked_device_name' => $link_event['link_clicked_device_name'],
                                'link_id' => $link_event['l_id'],
                                'created_on' => $link_event['created_on'],
                                'updated_on' => $link_event['updated_on'],
                                'is_deleted' => $link_event['is_deleted'],
                                'user_agent' => $link_event['user_agent'],
                                'location' => $link_event['location'],
                                'click_recipient' => $link_event['click_recipient'],
                            ]);
                            }
                        }
                        $linkModel->link_event_collection = $linkEventsCollection;
                        array_push($linksCollection, $linkModel);
                    }
                    $output = ['result' => true, 'data' => $linksCollection, 'message' => 'Sucess'];
                } else {
                    $output = ['result' => false, 'message' => 'No EmailSummary Found'];
                }
            } else {
                $output = ['result' => false, 'message' => 'Invalid EmailId '];
            }
        } else {
            $output = ['result' => false, 'message' => 'Invalid user'];
        }
        echo json_encode($output);

        return;
    }

    public function postUserDevice()
    {
        $userName = $this->input->post('txt_ss_loginname');

        $amUser = $this->chrapp->getUser($userName);

        if (!$amUser) {
            echo json_encode(['result' => false]);

            return;
        }
        $userId = $amUser['user_id'];
        $_SESSION['ss_user_id'] = $userId;

        $token = $this->input->post('token');

        if ($userId) {
            $userDeviceData = $this->user_device->gettokenbyuserid($userId);
            if (is_object($userDeviceData) || count(get_object_vars($userDeviceData)) !== 0) {
                $updatedUserDeviceData = ['id' => $userDeviceData->id, 'token' => $token, 'updated_on' => date('Y-m-d\TH:i:s\Z')];
                $res = $this->user_device->update($updatedUserDeviceData);
                if ($res) {
                    log_message('message', 'User device details updated successfully');
                    $output = ['result' => true, 'message' => 'User device details updated successfully'];
                } else {
                    $output = ['result' => false, 'message' => 'User device details not updated'];
                }
            } else {
                $userDeviceData = ['id' => $this->uuid->v4(), 'token' => $this->input->post('token'), 'user_id' => $userId, 'user_agent' => $this->input->post('user_agent'), 'created_on' => date('Y-m-d\TH:i:s\Z'), 'updated_on' => date('Y-m-d\TH:i:s\Z'), 'is_deleted' => 0, 'browser_name' => $this->input->post('browser_name')];
                $res = $this->user_device->create($userDeviceData);
                if ($res) {
                    log_message('message', 'User device details saved successfully');
                    $output = ['result' => true, 'message' => 'User device details saved successfully'];
                } else {
                    $output = ['result' => false, 'message' => 'User device details not saved'];
                }
            }
        } else {
            $output = ['result' => false, 'message' => 'Invalid user'];
        }
        echo json_encode($output);

        return;
    }

    public function sendNotification($emailReadResponse, $notificationFlag, $trackingEventCount, $linkClickedResponse = [])
    {
        $isFirstReadEventNotification = 'false';
        $tokensArray = [];
        $user_id = $emailReadResponse->user_id;
        $subject = $emailReadResponse->subject;
        $recipient = json_decode($emailReadResponse->recipient);
        $recipientEmail = $recipient[0]->emailAddress;
        $gmailThreadId = $emailReadResponse->gmail_thread_id;
        $gmailMessageId = $emailReadResponse->gmail_message_id;
        $recipientUserName = $emailReadResponse->name;
        // if (preg_match('/\\s/', $recipientUserName)) {
        //     $splitRecipientUserName = explode(' ', $recipientUserName);
        //     $recipientUserName = $splitRecipientUserName[0];
        // }

        if (!empty($linkClickedResponse)) {
            $link = $linkClickedResponse->link;
        }

        //Read User by user_id
        $userDetails = $this->user->getuserbyid($user_id);
        $sentEmailUserName = $userDetails->first_name;

        //Read UserDevice token by user_id
        $userDeviceReadResponse = $this->user_device->gettokenbyuserid($user_id);
        $token = $userDeviceReadResponse->token;
        array_push($tokensArray, $token);
        $registrationIds = $tokensArray;

        if ($trackingEventCount === 1) {
            $isFirstReadEventNotification = 'true';
        }
        if ($notificationFlag === 'emailTrack') {
            $msg = [
                'message' => '',
                'title' => 'Hello, ' . $sentEmailUserName . '!',
                'body' => $recipientUserName . ' just read your mail.' . "\n",
                'tickerText' => '',
                'vibrate' => 1,
                'sound' => 1,
                'largeIcon' => 'large_icon',
                'smallIcon' => 'small_icon',
                'gmailThreadId' => $gmailThreadId,
                'gmailMessageId' => $gmailMessageId,
                'trackingEventCount' => $trackingEventCount,
                'subject' => trim($subject),
                'isFirstReadEventNotification' => $isFirstReadEventNotification,
                'recipientEmail' => $recipientEmail,
                'trackingType' => 'emailTrack',
                'description' => 'Subject:' . ' "' . trim($subject) . '"',
          ];
        } elseif ($notificationFlag === 'linkTrack') {
            $msg = [
                'message' => '',
                'title' => 'Hello, ' . $sentEmailUserName . '!',
                'body' => $recipientUserName . ' just clicked your link.',
                'tickerText' => '',
                'vibrate' => 1,
                'sound' => 1,
                'largeIcon' => 'large_icon',
                'smallIcon' => 'small_icon',
                'gmailThreadId' => $gmailThreadId,
                'gmailMessageId' => $gmailMessageId,
                'trackingEventCount' => $trackingEventCount,
                'isFirstReadEventNotification' => $isFirstReadEventNotification,
                'subject' => trim($subject),
                'recipientEmail' => $recipientEmail,
                'trackingType' => 'linkTrack',
                'description' => 'Link:' . ' "' . trim($link) . '"',
            ];
        }

        $fields = ['registration_ids' => $registrationIds, 'data' => $msg];

        $headers = [
            'Authorization: key=' . $this->config->item('firebase_api_key'),
            'Content-Type: application/json',
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        curl_close($ch);
        error_log('curl result = ' . $result);
        //echo $result;
    }

    public function postPoints()
    {
        $userName = $this->input->post('txt_ss_loginname');

        $email = $this->input->post('email');
        $type = $this->input->post('type');
        $subject = $this->input->post('subject');
        $amUser = $this->chrapp->getUser($userName);

        if (!$amUser) {
            echo json_encode(['result' => false]);

            return;
        }

        $userId = $amUser['user_id'];

        $_SESSION['ss_user_id'] = $userId;

        if ($userId) {
            if ($email && $type) {
                $purPoints = '0';
                if ($type == 'emailTrack') {
                    $points = '1';
                    $taskSubject = 'Email opened';
                    $taskInfo = 'They opened the email';
                } elseif ($type == 'linkTrack') {
                    $points = '3';
                    $taskSubject = 'Link Clicked';
                    $taskInfo = 'They clicked the link';
                }
                $contactInfo = $this->crm->get_contact_by_email($email, $userId);
                if (!empty($contactInfo)) {
                    $contactId = $contactInfo[0]->contact_id;
                    $idate = date('Y-m-d');
                    $c = 2;
                    $where = ['userid' => $userId, 'contact' => $contactId, 'cat' => $c, 'pdate' => $idate, 'rctype' => 'C'];
                    $taskdata = [
                    'task_subject' => $taskSubject,
                    'task_name' => $subject,
                    'task_priority' => 'Normal',
                    'task_status' => 'Completed',
                    'task_duedate' => $idate,
                    'task_related' => 'C',
                    'task_relatedto' => $contactId,
                    'share_user_id' => $userId,
                    'userid' => $userId,
                    'task_created' => $idate . ' 00:00:00',
                    'task_modified' => $idate . ' 00:00:00',
                    'task_info' => $taskInfo,
                    ];
                    $tid = $this->crm->save_task($taskdata, 0);
                    $contpoints = $this->crm->get_points($where);
                    if ($contpoints) {
                        $updateData = [
                        'userid' => $userId,
                        'contact' => $contactId,
                        'cat' => $c,
                        'pdate' => $idate,
                        'rctype' => 'C',
                        ];
                        $pointsData = [
                        'intpoints' => $contpoints['intpoints'] + $points,
                        'purpoints' => $contpoints['purpoints'] + $purPoints,
                        'taskid' => $tid,
                        ];
                        $this->crm->save_points($pointsData, $updateData);
                    } else {
                        $pointsData = [
                        'userid' => $userId,
                        'contact' => $contactId,
                        'rctype' => 'C',
                        'pdate' => $idate,
                        'intpoints' => $points,
                        'purpoints' => $purPoints,
                        'cat' => $c,
                        'taskid' => $tid,
                        ];
                        $res = $this->crm->save_points($pointsData);
                    }
                    $output = ['result' => true, 'message' => 'Points saved successfully'];
                } else {
                    $output = ['result' => false, 'message' => 'Email id does not exists in database'];
                }
            } else {
                $output = ['result' => false, 'message' => 'Invalid email id or type'];
            }
        } else {
            $output = ['result' => false, 'message' => 'Invalid user'];
        }
        echo json_encode($output);

        return;
    }
}

// End of file chrome.php

// Location: ./application/controllers/chrome.php
