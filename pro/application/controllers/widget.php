<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//error_reporting(E_ALL);
class Widget extends CI_Controller {

	public $_data;

	public $_parent_users=array();
	public $_parent_users_all=array();

	public function __construct()	
	{
		parent::__construct();
		$this->output->nocache();
		$this->load->model('home_model', 'home');
		$this->load->model('crm_model', 'crm');
		$this->load->helper('scripts');
		//error_reporting(E_ALL);
		//ini_set("display_errors", 1);
	}

	public function index($id = NULL)
	{
		echo "index";
	}

	public function forms($id = NULL)
	{
		//echo "form $id";
		if(!$id) return;
		$listrow = $this->crm->getCatlistrow($id);
		if(!$listrow) return;
		$listform = $listrow['form']?json_decode($listrow['form']):'';
		if(!$listform) return;
		$listrow['form']=$listform;
		$this->_data['listrow']=$listrow;
		$section = $listrow['section']==2?'account':'contact';

		$parent_id = $listrow['userid'];
		$userid = $listrow['userid'];
		$saUser = $this->home->SharedUser($userid);
		if($saUser) {
			$parent_id = $saUser;
		}

		//Record owners
		$record_owners = array();
		$record_owners[] = $userid;

		if($parent_id) {
			$record_owners[] = $parent_id;
			$share_ids = $this->home->getSharedUsers($parent_id);
			if($share_ids)
			foreach($share_ids as $shrid) $record_owners[] = $shrid->user_id;
			$record_owners = array_unique($record_owners);
		}

		$this->_parent_users = $record_owners;
		$this->_parent_users_all = $record_owners;
		$lists = array();
		//Save category list form
		if($this->input->post('clfaction')=="saveListform") {
			$frecord=$this->input->post('list');
			$lists=$frecord;
			$frecord['userid'] = $userid;
			$frecord['share_user_id'] = $userid;
			//print_r($frecord);
			$er = $this->saveContactForm($frecord,$id);
			$this->_data['er']=$er;
		}
		$this->_data['list']=$lists;

		//Group User Custom fields
		$where = array();
		//CONTACTS
		$where = array();
		$where['user_id'] = $parent_id;
		$where['field_type'] = 'custom';
		$user_info = $this->home->getUserData($where);
		if($user_info) $user_info = $user_info[0];
		$custom = array();
		if(isset($user_info->value)) {
			$custom=unserialize($user_info->value);
			if(isset($custom['kcount'])) unset($custom['kcount']);
		}
		$this->_data['custom']=$custom;

		//ACCOUNTS
		$where = array();
		$where['user_id'] = $parent_id;
		$where['field_type'] = 'customa';
		$user_info = $this->home->getUserData($where);
		if($user_info) $user_info = $user_info[0];
		$customa = array();
		if(isset($user_info->value)) {
			$customa=unserialize($user_info->value);
			if(isset($customa['kcount'])) unset($customa['kcount']);
		}
		$this->_data['customa']=$customa;

		//Lead Source
		$where = array();
		$where['user_id'] = $parent_id;
		$where['field_type'] = 'lead';
		$user_info = $this->home->getUserData($where);
		if($user_info) $user_info = $user_info[0];
		$lead = array();
		if(isset($user_info->value)) $lead=json_decode($user_info->value);
		if(empty($lead)) $lead = $this->config->item('lead');
		$this->_data['lead']=$lead;

		//Salutation
		$salutation = $this->config->item('salutation');
		$this->_data['salutation']=$salutation;

		//Type
		$account_types = $this->config->item('account_types');
		$this->_data['account_types']=$account_types;

		//Industry
		$industries = $this->config->item('industries');
		$this->_data['industries']=$industries;

		//Rating
		$ratings = $this->config->item('ratings');
		$this->_data['ratings']=$ratings;

		//List Forms
		$dbcontact_fields = import_fields($section);
		//print_r($dbcontact_fields);
		//print_r($listrow);

		

		$this->_data['contact_fields']=$dbcontact_fields;
		$this->load->view('widget/list-widget-form', $this->_data);
	}

	public function form($id = NULL)
	{
		//echo "form $id";
		if(!$id) return;
		$listrow = $this->crm->getCatlistrow($id);
		if(!$listrow) return;
		$listform = $listrow['form']?json_decode($listrow['form']):'';
		if(!$listform) return;

		$listrow['form']=$listform;
		$this->_data['listrow']=$listrow;
		$section = $listrow['section']==2?'account':'contact';

		$prouser = $listrow['userid'];
		$saUser = $this->home->SharedUser($prouser);
		if($saUser) $prouser = $saUser;





		//Group User Custom fields
		$where = array();
		//CONTACTS
		$where = array();
		$where['user_id'] = $prouser;
		$where['field_type'] = 'custom';
		$user_info = $this->home->getUserData($where);
		if($user_info) $user_info = $user_info[0];
		$custom = array();
		if(isset($user_info->value)) {
			$custom=unserialize($user_info->value);
			if(isset($custom['kcount'])) unset($custom['kcount']);
		}
		$this->_data['custom']=$custom;

		//ACCOUNTS
		$where = array();
		$where['user_id'] = $prouser;
		$where['field_type'] = 'customa';
		$user_info = $this->home->getUserData($where);
		if($user_info) $user_info = $user_info[0];
		$customa = array();
		if(isset($user_info->value)) {
			$customa=unserialize($user_info->value);
			if(isset($customa['kcount'])) unset($customa['kcount']);
		}
		$this->_data['customa']=$customa;

		//Lead Source
		$where = array();
		$where['user_id'] = $prouser;
		$where['field_type'] = 'lead';
		$user_info = $this->home->getUserData($where);
		if($user_info) $user_info = $user_info[0];
		$lead = array();
		if(isset($user_info->value)) $lead=json_decode($user_info->value);
		if(empty($lead)) $lead = $this->config->item('lead');
		$this->_data['lead']=$lead;

		//Salutation
		$salutation = $this->config->item('salutation');
		$this->_data['salutation']=$salutation;

		//Type
		$account_types = $this->config->item('account_types');
		$this->_data['account_types']=$account_types;

		//Industry
		$industries = $this->config->item('industries');
		$this->_data['industries']=$industries;

		//Rating
		$ratings = $this->config->item('ratings');
		$this->_data['ratings']=$ratings;



		//List Forms
		$dbcontact_fields = import_fields($section);
		//print_r($dbcontact_fields);
		//print_r($listrow);
		$this->_data['contact_fields']=$dbcontact_fields;
		$this->load->view('widget/list-widget-form', $this->_data);
	}


	//Save excel/csv contact row
	function saveContactForm($fval,$id,$ajax=false) {
		$tbval = array();
		$address = array();
		$tab_account_name = '';
		$custom=array();
		$adr = array('street','city','state','zipcode','country');

		$own = implode(",", $this->_parent_users_all);
		$ownq = " AND userid IN ($own)";
		//print_r($fval);print_r($tabcols);
		foreach($fval as $ci=>$cv) {
			if(empty($cv)) continue;
			//custom
			if(substr($ci,0,5)=="field"){
				$custom[$ci]=$cv; 
				continue;
			}

			if($ci=="account") $tab_account_name = $cv;
			else if(in_array($ci,$adr)!==false) $address[$ci]=$cv;
			else $tbval[$ci]=$cv;
		}
		if(!$tbval) return "No data entered";
		if(!isset($tbval['email']) || empty($tbval['email'])) return "Email address required";
		else {
			$this->load->helper('email');
			if (!valid_email($tbval['email'])) return "Enter valid email address";
		}
		//verify unique email address
		$redID = 0;
		if($tbval['email']) {
			$email_info = $this->crm->get_acRecord("LOWER(email)='".strtolower($tbval['email'])."'".$ownq,'contact_id,userid','C');
			if($email_info) return "Email address already exists.";
		}


		$tbval['create_date']=date("Y-m-d H:i:s");
		$tbval['modify_date']=date("Y-m-d H:i:s");
		if(isset($tbval['birthdate']) && !empty($tbval['birthdate'])) {
			if(empty($tbval['birthdate'])) unset($tbval['birthdate']);
			else {
				$tmpdate = explode("/",$tbval['birthdate']);//m/d/y-012
				if(count($tmpdate)==3) 
					$tbval['birthdate']="{$tmpdate[2]}-{$tmpdate[0]}-{$tmpdate[1]}";//y-m-d 201	
				else unset($tbval['birthdate']);
			}
		}

		//Target Contact
		/*if($contact_options['target']) $tbval['target']=1; else 
		if(isset($tbval['target'])) {
			if((int)$tbval['target'] || strtolower($tbval['target'])=="y" || $tbval['target']=="YES") $tbval['target']=1;
			else unset($tbval['target']);
		} */

		////$tbval['share_user_id']=$contact_options['record_owner'];
		//return;
		//Contact Account

		if($tab_account_name) {
			$tab_account_id=0;
			$account_info = $this->crm->get_acRecord("LOWER(account_name)=".$this->db->escape(strtolower($tab_account_name))." ".$ownq,'account_id','A');
			if($account_info) {
				$tab_account_id = $account_info['account_id'];
			} else {
				$tab_account = array();
				$tab_account['account_name']=$tab_account_name;
				if($contact_options['target_account']) $tab_account['target']=$contact_options['target_account'];
				$tab_account['share_user_id']=$contact_options['record_owner'];
				$tab_account['create_date']=date("Y-m-d H:i:s");
				$tab_account['modify_date']=date("Y-m-d H:i:s");//print_r($tab_account);
				$tab_account_id = $this->crm->save_account($tab_account,0);
			}
			$tbval['account_id']=$tab_account_id;
		}
		
		$cid=0;
		//print_r($tbval);
		//return;
		$cid = $this->crm->save_contact($tbval,$redID);

		if($cid){
			//Category List ID & assign record to list
			if($id) {
				$exist_record = $this->crm->get_category_record($id,$cid);
				if(!$exist_record) {
					$info = array('category_id'=>$id,'record_id'=>$cid);
					$this->crm->save_category_record($info);
				}
			}
			//custom
			foreach($custom as $ci=>$cv) {
				$ecdata = array('section'=>'C','recid'=>$cid,'ckey'=>$ci,'cval'=>$cv,'user_id'=>$tbval['userid']);
				//print_r($ecdata);
				$this->crm->save_custom_record($ecdata);
			}

			//Address
			if($address) {
				$address['parent_id']=$cid;
				$address['adr_type']='amail';
				$address['parent_type']='C';
				//print_r($address);
				$this->crm->save_address($address);
			}
		}
		if($ajax==true) return "done";
		redirect(base_url() . 'widget/thanks');
	}

	public function thanks() {
		$this->load->view('widget/thankyou', $this->_data);
	}

	public function error() {
		$this->load->view('widget/form-error', $this->_data);
	}

	function jsonResponse($resp) {
		$status = array('html'=>$resp);
		header('content-type: application/javascript; charset=utf-8');
		echo $_GET['callback'] . "(" . json_encode($status) . ")";
	}

	function postResponse($resp) {
		header('content-type: application/javascript; charset=utf-8');
		echo $_GET['callback'] . "(" . json_encode($resp) . ")";
	}

	//Save posted form
	public function ssformPost($id) {
		//error_reporting(E_ALL);
		if(!$id) {
			$this->postResponse(array('status'=>false,'msg'=>'Invalid form submition.'));
			return;
		}
		$listrow = $this->crm->getCatlistrow($id);
		if(!$listrow) {
			$this->postResponse(array('status'=>false,'msg'=>'Invalid form submition.'));
			return;
		}
		$listform = $listrow['form']?json_decode($listrow['form']):'';
		if(!$listform) {
			$this->postResponse(array('status'=>false,'msg'=>'Invalid form submition.'));
			return;
		}
		$parent_id = $listrow['userid'];
		$userid = $listrow['userid'];
		//Record owners
		$record_owners = array();
		$record_owners[] = $userid;

		if($parent_id) {
			$record_owners[] = $parent_id;
			$share_ids = $this->home->getSharedUsers($parent_id);
			if($share_ids)
			foreach($share_ids as $shrid) $record_owners[] = $shrid->user_id;
			$record_owners = array_unique($record_owners);
		}

		$this->_parent_users = $record_owners;
		$this->_parent_users_all = $record_owners;

		$frecord=$this->input->get('list');
		$frecord['userid'] = $listrow['userid'];
		$frecord['share_user_id'] = $listrow['userid'];
		$er = $this->saveContactForm($frecord,$id,true);
		if($er=="done") {
			$this->postResponse(array('status'=>true,'msg'=>'You have successfully submitted your information.'));
			return;
		} else {
			$this->postResponse(array('status'=>false,'msg'=>$er));
			return;	
		}
		return;
	}

	//Prepare List Form
	public function ssform($id = NULL)
	{
		
		if(!$id) {
			$this->jsonResponse('');
			return;
		}
		$listrow = $this->crm->getCatlistrow($id);
		if(!$listrow) {
			$this->jsonResponse('');
			return;
		}
		$listform = $listrow['form']?json_decode($listrow['form']):'';
		if(!$listform) {
			$this->jsonResponse('');
			return;
		}
		$listrow['form']=$listform;
		$this->_data['listrow']=$listrow;
		$section = $listrow['section']==2?'account':'contact';

		$parent_id = $listrow['userid'];
		$userid = $listrow['userid'];
		$saUser = $this->home->SharedUser($userid);
		if($saUser) {
			$parent_id = $saUser;
		}

		//Record owners
		$record_owners = array();
		$record_owners[] = $userid;

		if($parent_id) {
			$record_owners[] = $parent_id;
			$share_ids = $this->home->getSharedUsers($parent_id);
			if($share_ids)
			foreach($share_ids as $shrid) $record_owners[] = $shrid->user_id;
			$record_owners = array_unique($record_owners);
		}

		$this->_parent_users = $record_owners;
		$this->_parent_users_all = $record_owners;
		$lists = array();		
		$this->_data['list']=$lists;

		//Group User Custom fields
		$where = array();
		//CONTACTS
		$where = array();
		$where['user_id'] = $parent_id;
		$where['field_type'] = 'custom';
		$user_info = $this->home->getUserData($where);
		if($user_info) $user_info = $user_info[0];
		$custom = array();
		if(isset($user_info->value)) {
			$custom=unserialize($user_info->value);
			if(isset($custom['kcount'])) unset($custom['kcount']);
		}
		$this->_data['custom']=$custom;

		//ACCOUNTS
		$where = array();
		$where['user_id'] = $parent_id;
		$where['field_type'] = 'customa';
		$user_info = $this->home->getUserData($where);
		if($user_info) $user_info = $user_info[0];
		$customa = array();
		if(isset($user_info->value)) {
			$customa=unserialize($user_info->value);
			if(isset($customa['kcount'])) unset($customa['kcount']);
		}
		$this->_data['customa']=$customa;

		//Lead Source
		$where = array();
		$where['user_id'] = $parent_id;
		$where['field_type'] = 'lead';
		$user_info = $this->home->getUserData($where);
		if($user_info) $user_info = $user_info[0];
		$lead = array();
		if(isset($user_info->value)) $lead=json_decode($user_info->value);
		if(empty($lead)) $lead = $this->config->item('lead');
		$this->_data['lead']=$lead;

		//Salutation
		$salutation = $this->config->item('salutation');
		$this->_data['salutation']=$salutation;

		//Type
		$account_types = $this->config->item('account_types');
		$this->_data['account_types']=$account_types;

		//Industry
		$industries = $this->config->item('industries');
		$this->_data['industries']=$industries;

		//Rating
		$ratings = $this->config->item('ratings');
		$this->_data['ratings']=$ratings;

		//List Forms
		$dbcontact_fields = import_fields($section);		

		$this->_data['contact_fields']=$dbcontact_fields;

		$html = $this->load->view('widget/list-widget-form', $this->_data,true);
		$this->jsonResponse($html);
		return;
	}

}

/* End of file widget.php */

/* Location: ./application/controllers/widget.php */