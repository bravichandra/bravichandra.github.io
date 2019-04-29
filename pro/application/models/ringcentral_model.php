<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

use RingCentral\SDK\SDK;

class Ringcentral_model extends CI_Model 
{
    private $_table_crm_contacts;
    private $_table_user_info;
    private $user_id;

    function __construct() {
        parent::__construct();
        $this->user_id = $_SESSION['ss_user_id'];

        require_once(APPPATH . 'libraries/ringcentral/rc/_bootstrap.php');

        $this->_table_crm_contacts		 		= $this->config->item('table_crm_contacts');
        $this->_table_user_info 				= $this->config->item('table_user_info');

        $this->credentials = require(APPPATH . 'libraries/ringcentral/rc/_credentials.php');
        $this->rcsdk = new SDK($this->credentials['clientId'], $this->credentials['clientSecret'], $this->credentials['server'], 'SalesScript', '1.0.0');
        $this->platform = $this->rcsdk->platform();

        $rcInfoData = $this->rcInfo($this->user_id);
        if( $rcInfoData ){
            $rcInfoValue = unserialize($rcInfoData->value);
            $rc_username = $rcInfoValue['username'];
            $rc_extension = $rcInfoValue['extension'];
            $rc_password = base64_decode($rcInfoValue['password']);
        }else{
            echo 'Credentials does not match!';die();
        }

        $cacheDir = APPPATH . DIRECTORY_SEPARATOR . '_cache';
        $file = $cacheDir . DIRECTORY_SEPARATOR . 'platform.json';

        if (!file_exists($cacheDir)) {
            mkdir($cacheDir);
        }

        $cachedAuth = array();

        if (file_exists($file)) {
            $cachedAuth = json_decode(file_get_contents($file), true);
            unlink($file); // dispose cache file, it will be updated if script ends successfully
        }

        $this->platform->auth()->setData($cachedAuth);
        try {
            $this->platform->refresh();
        } catch (Exception $e) {
            $auth = $this->platform->login($rc_username, $rc_extension, $rc_password);
        }
        
    }

    public function verifyCredential($user){
        $extension = $this->platform->get('/account/~/extension/~')->json();
        echo '<pre>'; print_r($extension); echo '<pre>'; exit();
    }

    public function checkUser(){
        return $this->rcInfo;
    }

    public function rcInfo($user_id){
        $this->db->where('user_id',$user_id);
        $this->db->where('field_type','ringcentral');
        $query = $this->db->get($this->_table_user_info);
        return $query->result()[0];
    }

    public function logout(){
        $this->platform->logout();
    }

    public function getCallLogs($contact_id,$page=1,$perPage=10){
        $page = $page ? $page : 1;
        $params = array(
            'page' => $page, 
            'perPage' => $perPage,
            'view'=>'Detailed',
            'dateFrom' => $this->credentials['dateFrom'],
            'type' => 'Voice',
            'showDeleted' => 'false',
            'withRecording' => 'true',
        );
        if( $contact_id != '' ){
            $params['phoneNumber'] = $contact_id;
        }
        return $this->platform->get('/account/~/extension/~/call-log', $params)->json();
    }

    public function createCallLogsTableData($callLogs){
        $result = '';
        
        foreach ($callLogs->records as $call) {
            $direction = $call->direction;
            $recording = $this->platform->get('/account/~/recording/'.$call->recording->id)->json();
            $result .= "
                <tr>
                    <td class='no-border $call->direction'>$call->direction</td>
                    <td class='no-border'><a href='$call->id' class='play-audio'>Play/Download</a></td>
                    <td class='no-border'>".gmdate("H:i:s", $recording->duration)."</a>
                    <td class='no-border'>".date('m-d-Y h:i:s a',strtotime($call->startTime))."</a>
                </tr>
            ";
        }
        return $result;
    }

    public function openCallRecording($id){
        if( isset($_POST['id']) ){
            $id = $_POST['id'];
            $callRecord = $this->platform->get('/account/~/extension/~/call-log/'.$id)->json();
            $extension_id = $callRecord->extension->id;
            $recording_id = $callRecord->recording->id;
    
            // Set Directory
            $dir = date('Y-m-d', strtotime($callRecord->startTime));
            $fdir = "Recordings/${dir}";
    
            $apiResponse = $this->platform->get($callRecord->recording->contentUri);
    
            if (is_dir($fdir) === false)
            {
                mkdir($fdir, 0777, true);
            }
            $ext = ($recording->contentType == 'audio/mpeg') ? 'mp3' : 'wav';
            $file_name = "recording_${extension_id}_${recording_id}.${ext}";
            $location = "${fdir}/${file_name}";
    
            if( !file_exists($location) ){
                if( file_put_contents($location, $apiResponse->raw()) ){
                    return $location;
                }
            }else{
                return $location;
            }
            return false;
        }
        return false;
    }

    public function downloadCallRecording($id){
        $extension = $this->platform->get('/account/~/extension/~')->json();
        $extension_id = $extension->id;
        // Set Directory
        $dir = $this->credentials['dateFrom'];
        $fname = "recordings_${dir}.csv";
        $fdir = "Recordings/${dir}";

        $recording = $this->platform->get('/account/~/recording/'.$id)->json();
        $apiResponse = $this->platform->get($recording->contentUri);
        if (is_dir($fdir) === false)
        {
            mkdir($fdir, 0777, true);
        }
        $ext = ($recording->contentType == 'audio/mpeg') ? 'mp3' : 'wav';
        $file_name = "recording_${extension_id}_${id}.${ext}";
        $location = "${fdir}/${file_name}";

        if( file_put_contents($location, $apiResponse->raw()) ){
            header('Content-Type: application/octet-stream');
            header("Content-Transfer-Encoding: Binary"); 
            header("Content-disposition: attachment; filename=\"$file_name\""); 
            readfile($location); // do the double-download-dance (dirty but worky)
        }

        unlink($location);
    }

    //Get Contact record
    public function get_contact_phone($contact_id) {
		$this->db->select("phone");
		$this->db->where('contact_id', $contact_id);
		$this->db->from($this->_table_crm_contacts);
        $query = $this->db->get();
        $result = $query->result();
    	return $result[0]->phone;
    }
}