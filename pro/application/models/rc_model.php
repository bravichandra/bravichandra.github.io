<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rc_model extends CI_Model 
{
    private $user_id;
    private $rc_table;
    private $location;

    function __construct() {
        parent::__construct();
        $this->rc_table = 'crm_rc_recordings';
        $this->location =  __DIR__.'/../../Recordings/';
        $this->user_id = $_SESSION['ss_user_id'];
    }

    function downloadCallrecording($call){
        $uri = $call->recording->contentUri.'?access_token='.$call->accessToken;
        $date = date('Y-m-d',($call->startTime/1000));
        $fdir = $this->location.$date.'/';
        $filename = 'recording_'.$call->recording->id.'.mp3';

        if (is_dir($fdir) === false)
        {
            mkdir($fdir, 0777, true);
        }
        
        if( !file_exists($fdir.$filename) ){
            if(!file_put_contents($fdir.$filename, fopen($uri, 'r'))){
                return false;
            }
        }
        return $filename;
    }

    function saveRecordingInfo($call,$filename){
        $data = [
            'user_id' =>  $this->user_id,
            'call_from' => $call->from->phoneNumber,
            'call_to' => $call->to->phoneNumber,
            'recording' => $filename,
            'direction' => $call->direction,
            'call_date' => $call->startTime,
            'call_data' => serialize($call)
        ];

        $this->db->insert($this->rc_table,$data);

        return true;
    }
}