<?php    

if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

session_start();

class Ringcentral extends CI_Controller {

    private $user_id;

    function __construct() {
        parent::__construct();
        if( !$this->input->post('bypass') ){
            $this->load->model('ringcentral_model','rc');
        }
        $this->load->model('home_model', 'home');
        $this->user_id = $_SESSION['ss_user_id'];
    }

    public function verifyUser(){
        $this->rc->verifyCredential();
    }

    public function downloadRecording($id){
        $this->rc->downloadCallRecording($id);
    }

    public function openRecording($id){
        $result = '
            <span style="color:red">Something went wrong!</span>
            ';
        if( $res = $this->rc->openCallRecording($id) ){
            $result = '
            <audio controls>
                <source src="'.base_url().'/'.$res.'" type="audio/wav">
                <source src="'.base_url().'/'.$res.'" type="audio/mpeg">
                Your browser does not support the audio element.
            </audio>
            ';
        }
        echo json_encode(stripslashes($result));
        die();
    }

    public function callLogs(){
        $result = false;
        $contact_id = $_POST['contact_id'];
        $page = $_POST['page'];
        $contact_phone = preg_replace('/[^0-9]/', '', $this->rc->get_contact_phone($contact_id));
        if( $contact_phone ){
            $callLogs = $this->rc->getCallLogs($contact_phone,$page);
            $data = $this->rc->createCallLogsTableData($callLogs);
            $result = [
                'data' => stripslashes($data),
                'navigation' => $this->createNavigation($callLogs->navigation)
            ];
        }
        
        echo json_encode($result);
    }

    public function createNavigation($navigation){
        $result = '';
        if( isset($navigation->previousPage )){
            $page = $this->getPage($navigation->previousPage->uri);
            $result .= '<input data-page="'.$page.'" type="button" class="btn-pagination prev" value="Prev">';        }

        if( isset($navigation->nextPage )){
            $page = $this->getPage($navigation->nextPage->uri);
            $result .= '<input data-page="'.$page.'" type="button" class="btn-pagination next" value="Next">';
        }

        return $result;
    }

    public function getPage($uri){
        $parts = parse_url($uri);
        parse_str($parts['query'], $query);
        return $query['page'];
    }

    public function saveRingCentralInfo(){
        $display = isset($_POST['display']) ? 1 : 0;
        $username = $this->input->post('user_name');
        $extension = $this->input->post('extension');
        $password = $this->input->post('password');

        $input = [
            'username' => $username,
            'extension' => $extension,
            'password' => base64_encode($password),
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