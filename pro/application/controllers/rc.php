<?php    
if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, origin");

session_start();

class Rc extends CI_Controller {

    private $user_id;

    function __construct() {
        parent::__construct();
        $this->load->model('rc_model', 'rc');
        $this->load->model('home_model', 'home');
        $this->user_id = $_SESSION['ss_user_id'];

    }

    public function saveRCData(){
        $result = false;
        if( isset($_POST['call']) && $this->user_id ){
            $call = json_decode($this->input->post('call'));
    
            if( $filename = $this->rc->downloadCallrecording($call) ){
                if( $this->rc->saveRecordingInfo($call,$filename) ){
                    $result = true;
                }
            }
        }

        echo json_encode($result.' -From Pro');
    }

    public function saveRingCentralInfo(){
        $display = isset($_POST['display']) ? 1 : 0;
        $appkey = $this->input->post('appkey');
        $appSecret = $this->input->post('appSecret');

        $input = [
            'appkey' => $appkey,
            'appSecret' => base64_encode($appSecret),
            'display' => $display
        ];

        $data = [
            'user_id' => $this->user_id,
            'field_type' => 'ringcentral',
            'value' => serialize($input)
        ];

        $where = [
            'user_id' => $this->user_id,
            'field_type' => 'ringcentral'
        ];

        if( $this->home->getUserData($where) ){
            $this->home->saveUserData($data,$where);
        }else{
            $this->home->saveUserData($data);
        }

        echo json_encode('success');die();
    }

}