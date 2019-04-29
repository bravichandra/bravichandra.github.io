<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
session_start();
//error_reporting(E_ALL);
class Crmbeta extends CI_Controller {
	/**
	 * Properties
	 */

	public $_data;
	public $_user_id;
	public $_parent_users=array();
	public $_parent_users_all=array();

	/**
	 * Constructor
	 */

	public function __construct()
	{

		parent::__construct();
		$this->output->nocache();

		//Load Helpers 

        $this->load->helper('form');

        $this->load->helper('cookie');

        $this->load->library('session');

        //Load Models

		$this->load->model('home_model', 'home');

        $this->load->model('crm_model', 'crm');

        $this->load->model('campaign_model', 'campaign');

		$this->load->model('product_model', 'productModel');

		

		if(!$this->config->item('is_local'))

		{

			include(CDOC_ROOT."members/library/Am/Lite.php"); 

			Am_Lite::getInstance()->checkAccess(array(2,6,5,9,10,14,15,18,28,30,31,32), 'Restricted access'); //  This array is Updated by Dev@4489 on 23-Oct-2015

			// 9  is for Scripter Pro 3 Month

			// 10 is for Scripter Pro 1 Year			

			$amember_username = Am_Lite::getInstance()->getUsername();

	        // Get user from DB by username

	        if($user_id = $this->home->get_user_by_username($amember_username))

	        {

	        	$this->_data['user_id'] = $user_id;

	        }

	        else 

			{

				// Get Full Name

				$amember_full_username = Am_Lite::getInstance()->getName();

				$name = explode(" ", $amember_full_username);

				//Insert Register User information into database.

				$this->_data['user_id'] = $this->home->registration(array('username'=>$amember_username, 'first_name'=>$name['0'], 'last_name'=>$name['1']));

				$just_registered = TRUE;

			}

			$haveSubscriptions = Am_Lite::getInstance()->haveSubscriptions(array('6','2','9','10','14','15','18','28','5','3','30','31','32'));//  This array is Updated by Dev@4489 on 17-April-2014

			// 9  is for Scripter Pro 3 Month

			// 10 is for Scripter Pro 1 Year



			// Check User Subscription PAID OR FREE

			$this->_data['is_paid'] = !empty($haveSubscriptions) ? TRUE : FALSE;

			

			//By Dev@4489

			//Modify access

			$eSubscribe = Am_Lite::getInstance()->haveSubscriptions(array('3','5','6','10','14','15','32'));//Scripter Pro for Editing  By Dev@4489 24-Oct-2015

			//Pro Lite Subscription

			$PLSubscribe = Am_Lite::getInstance()->haveSubscriptions(array('18','28'));

			if($PLSubscribe && !$eSubscribe) $this->_data['is_prolite'] = TRUE;

			if($eSubscribe) $this->_data['eScripter'] = TRUE;

			// interviewer

			$interviewer = Am_Lite::getInstance()->haveSubscriptions(array('30','31'));// products

			if($interviewer) $this->_data['einterviewer'] = TRUE;			

			////

			

		}else 

        {

			// For local testing 

        	$amember_username = "a_ehmad";

	        // Get user from DB by username

	        if($user_id = $this->home->get_user_by_username($amember_username))

	        {

	        	$this->_data['user_id'] = $user_id;

	        }

	        else 

			{

				// Get Full Name

				$amember_full_username = "Fraz Ahmed";

				$name = explode(" ", $amember_full_username);

				//Insert Register User information into database.

				$this->_data['user_id'] = $this->home->registration(array('username'=>$amember_username, 'first_name'=>$name['0'], 'last_name'=>$name['1']));

				$just_registered = TRUE;

			}

			$this->_data['user_id'] = 2;

        	$this->_data['is_paid'] = TRUE;

        }

        //Shared User Information
        $this->load->helper('scripts');
        $this->_data['AMuserShares'] = amb_share_verify($this->_data);        
        //End of Shared User Information

        $this->_data['cloguser_id'] = $this->_data['user_id'];

		//Shared Access to CRM
		//if($this->_data['AMuserShares']['crm']==0) redirect(base_url('/'));


		//By Dev@4489
		

		//Timezone

		$this->_data['tzone']="America/Chicago";

		$where = array();

		$where['user_id'] = $this->_data['user_id'];

		$where['field_type'] = 'timezone';

		$user_info = $this->home->getUserData($where);

		if($user_info) {

			$user_info = $user_info[0];

			if(isset($user_info->value)) $this->_data['tzone']=$user_info->value;			

		}

		date_default_timezone_set($this->_data['tzone']);

		//Record owners

		$record_owners = array();

		$record_owners[] = $this->_data['user_id'];

		if(isset($this->_data['is_prolite'])) {

			$parent_id = $this->home->SharedUser($this->_data['user_id']);

		} else $parent_id = $this->_data['user_id'];

		if($parent_id) {

			$record_owners[] = $parent_id;

			$share_ids = $this->home->getSharedUsers($parent_id);
			if($share_ids)
			foreach($share_ids as $shrid) $record_owners[] = $shrid->user_id;

			$record_owners = array_unique($record_owners);

		}

		$this->_parent_users = $record_owners;
		$this->_parent_users_all = $record_owners;

		//For Lite user access
		if(isset($this->_data['is_prolite'])) {
			$shareduser = $this->home->SharedUserInfo($this->_data['user_id']);
			if($shareduser) {
				if($shareduser->accessview=="Own") $this->_parent_users = array($this->_data['user_id']);
			}
		}
		

	   $this->_user_id = $this->_data['user_id'];

       $_SESSION['ss_user_id'] = $this->_user_id;

       //CONTACTS
		$where = array();
		$where['user_id'] = isset($this->_data['eLusrNotBS'])?$this->_data['eLusrNotBS']:$this->_user_id;
		$where['field_type'] = 'custom';
		$user_info = $this->home->getUserData($where);
		if($user_info) $user_info = $user_info[0];
		$custom = array();
		if(isset($user_info->value)) {
			$custom=unserialize($user_info->value);
			if(isset($custom['kcount'])) unset($custom['kcount']);
		}
		$this->_data['custom']=$custom;

		//Numeric custom fields

		$where = array();
		$where['user_id'] = isset($this->_data['eLusrNotBS'])?$this->_data['eLusrNotBS']:$this->_user_id;
		$where['field_type'] = 'customNum';
		$user_info = $this->home->getUserData($where);
		if($user_info) $user_info = $user_info[0];
		$customNum = array();

		if(isset($user_info->value)) {
			$customNum=unserialize($user_info->value);
		}

		$this->_data['customNum']=$customNum;	   

	   //By Dev@4489

	   //$this->interviewer_plan_access();

		/**  active campaign data */

		$active_campaign_data =  $this->campaign->get_campaign_active($this->_user_id);

		if($active_campaign_data == false) 

		{

			$tempCampaign = array('campaign_id'=>0,'product_id'=>0);

			$active_campaign_data = (object)$tempCampaign;

		} else if(empty($is_product)) $active_campaign_data->product_id=0;		

		$this->_data['campaign_info'] = $active_campaign_data;		
	}

	//Test CRMBETA
	public function crmbetatest()
	{
		echo "CRM BETA TEST ".$_SESSION['cimport_no_2'];
		echo " - r:".$_SESSION['cimport_row'];
		return;
	}
	//Test CRMBETA
	public function crmbetatest2()
	{
		$_SESSION['cimport_no_2']=0;
		$_SESSION['cimport_row']=0;
		return;
	}

	//save contacts imported
	public function save_contacts_imported()
	{
		if($this->input->post('cbaction')=="save_contacts_imported") {
			$json = array('msg'=>'','status'=>false);
			$filename = $this->session->userdata('import_data');
			if(!$filename || !file_exists($filename)) {
				$json['msg']="Import file not found";
				echo json_encode($json);return;
			}

			$record=$this->input->post('record');
			//Category List ID
			$records_listid = (isset($record['listid']) && $record['listid'])?$record['listid']:0;
			//print_r($record);
			$er = array();
			$tbcol = array_filter($record['tbcol']);
			if(!$tbcol) {
				$json['msg']="Select contact fields";
				echo json_encode($json);return;
			}
			//Interaction
			if(!isset($_SESSION['cimport_interaction']))
				$this->getInteraction();

			//Selected mapping fields
			$tabcols = array();
			foreach($record['tbcol'] as $ki=>$kv) {
				if(!$kv) continue;
				$tabcols[$kv]=$record['excol'][$ki];
			}
			//print_r($tabcols);

			//Target Contact
			if(isset($record['target'])) $target=1; else $target=0;
			//Target Account
			if(isset($record['target_account'])) $target_account=1; else $target_account=0;
			//Assign Record Owner
			if(isset($record['share_user_id']) && $record['share_user_id']) $record_owner=$record['share_user_id']; 
			else $record_owner=$this->_user_id;
			//Category List ID
			$records_listid = (isset($record['listid']) && $record['listid'])?$record['listid']:0;					

			$contact_options = array('target'=>$target,'target_account'=>$target_account,'record_owner'=>$record_owner,'records_listid'=>$records_listid);

			$adr = array('street','city','state','zipcode','country');			

			$ext = substr(strrchr($filename,'.'),1);
			$rowdata = array();

			$header = array();
			$arr_data = array();

			$header2 = array();
			$exrows2 = array();
			$keys2 = array();
			$keys3 = array();
			$processed_records = 0;
			$processed_completed = 0;
			$lastRow=0;
			$row=0;
			$dorows = 100;

			$savemap = 0;
			//$pres_cimport_no = $this->session->userdata('cimport_no');
			//$_SESSION['cimport_no_2']=0;
			$pres_cimport_no = $_SESSION['cimport_no_2'];
			if(!$pres_cimport_no) $pres_cimport_no=0;
			if($pres_cimport_no==0) $savemap = 1;
			//echo "1. PINO:$pres_cimport_no ";

			if($ext=="xls" || $ext=="xlsx") {
				$rowstart = $pres_cimport_no==0?$pres_cimport_no+2:$pres_cimport_no+1;
				//echo "2. PINO:$pres_cimport_no ";

				$this->load->library('excel');

				// Use PCLZip rather than ZipArchive
				PHPExcel_Settings::setZipClass(PHPExcel_Settings::PCLZIP);
				$objPHPExcel = PHPExcel_IOFactory::load($filename);

				$lastRow = $objPHPExcel->getActiveSheet()->getHighestRow();
				$highestColumn = $objPHPExcel->getActiveSheet()->getHighestColumn();
				$colNumber = PHPExcel_Cell::columnIndexFromString($highestColumn);

				if($lastRow<=1) {
					$json['msg']="No data in Excel file";
					echo json_encode($json);return;
				}
				if($rowstart>$lastRow) {
					$json['status']=true;
					$json['msg']="Import completed";
					$json['processed']=$lastRow-1;
					$json['completed']=1;
					echo json_encode($json);return;
				}

				$objWorksheet = $objPHPExcel->setActiveSheetIndex(0);

				//get header
				if($savemap) {
					$row=2;
					for($col = 0; $col<$colNumber;$col++) {
						$exval = $objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
						//$alphabet = chr($alphno++);
						$header[] = $exval;//$alphabet;
					}
					$rowdata['header'] = $header;	
				}
				

				for($row=$rowstart,$n=1;$row<=$lastRow && $n<=$dorows;$row++,$n++) {
					$dataRow = array();
					for($col = 0; $col<$colNumber;$col++) {
						$dataRow[] = $objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
					}
					//save $dataRow in crm
					//print_r($dataRow);
					//$this->session->set_userdata('cimport_no', $row);
					//$_SESSION['cimport_no_2'] = $row;
					//echo "3. PINO:$row ";
					//$_SESSION['cimport_row'] = $rowstart.'-'.$row;
					$this->saveContactImported($dataRow,$tabcols,$contact_options);
					//break;
				}
				$processed_records = $row-2;
				$processed_completed = $row>=$lastRow?1:0;
			} else {
				//CSV

				$this->load->library('parsecsv');

				$csv = new Parsecsv();
				$csv->auto($filename);
				$csvdata = $csv->data;

				if(!$csvdata || !is_array($csvdata)) $ermsg = "No data in CSV file";
				else if(count($csvdata)==0) $ermsg = "No data in CSV file";
				if($ermsg) {
					$json['msg']=$ermsg;
					echo json_encode($json);return;
				}				

				$lastRow = count($csvdata);

				$rowdata['values'] = $csvdata;

				$rowstart = $pres_cimport_no==0?0:$pres_cimport_no+1;

				if($rowstart>$lastRow) {
					$json['status']=true;
					$json['msg']="Import completed";
					$json['processed']=$lastRow-1;
					$json['completed']=1;
					echo json_encode($json);return;
				}
				$header = $csvdata[0];
				$rowdata['header'] = $header;

				for($row=$rowstart,$n=1;$row<$lastRow && $n<=$dorows;$row++,$n++) {
					$dataRow = $csvdata[$row];
					//save $dataRow in crm
					//print_r($dataRow);
					$dataRow = array_values($dataRow);
					//print_r($dataRow);
					//$this->session->set_userdata('cimport_no', $row);
					//$_SESSION['cimport_no_2'] = $row;
					$this->saveContactImported($dataRow,$tabcols,$contact_options);
					//break;
				}
				$processed_records = $row;
				$processed_completed = $row>=$lastRow?1:0;
			}

			//mapping
			if($savemap && isset($record['mapping'])){				
				$table_fields = import_fields('contact');
				//echo "Save Mapping";
				//print_r($table_fields);
				//echo "Save Mapping";

				$where = array();
				$where['user_id'] = $this->_user_id;
				$where['field_type'] = 'mapping';
				$user_info = $this->home->getUserData($where);

				$data = array();
				$headers=$rowdata['header'];
				$exheaders = array();
				foreach($tabcols as $key=>$value){
					$exheaders[$table_fields[$key]]=$headers[$value];
					//$exheaders[$key]=$headers[$value];
					$tabcols[$key]=$headers[$value];
				}
				$data1['val'] = $tbcol;
				$data1['excel']=$tabcols;
				$data1['headers']= $exheaders;
				//print_r($data1);
				$data['value']=serialize($data1);
				if($user_info) {
					$this->home->saveUserData($data,$where);
				}
				else {
					$data['user_id'] = $this->_user_id;
					$data['field_type'] = 'mapping';
					$this->home->saveUserData($data);
				}
			}
			//$contacts=$this->input->post('record');
			//print_r($contacts);
			$json['status']=true;
			$json['msg']=$processed_completed?"Import completed, Records processed: $processed_records":"Records processed: $processed_records . Remaining records import inprocess.";
			$json['processed']=$lastRow-1;
			$json['completed']=$processed_completed;
			//Interaction
			if($processed_completed) {
				if(isset($_SESSION['cimport_interaction'])) unset($_SESSION['cimport_interaction']);
			}
			$json['total']=$lastRow;
			$json['row']=$row;
			echo json_encode($json);return;
		}
		return;
	}

	//Save excel/csv contact row
	function saveContactImported($fval,$tabcols,$contact_options) {
		$tbval = array();
		$address = array();
		$tab_account_name = '';
		$custom=array();
		$adr = array('street','city','state','zipcode','country');

		$own = implode(",", $this->_parent_users_all);
		$ownq = " AND userid IN ($own)";

		foreach($tabcols as $ci=>$cv) {
			if(empty($fval["$cv"])) continue;
			//custom
			if(substr($ci,0,5)=="field"){
				$custom[$ci]=$fval["$cv"]; 
				continue;
			}

			if($ci=="account") $tab_account_name = $fval["$cv"];
			else if(in_array($ci,$adr)!==false) $address[$ci]=$fval["$cv"];
			else $tbval[$ci]=$fval["$cv"];
		}
		$_SESSION['cimport_no_2'] = $_SESSION['cimport_no_2']+1;
		if(!$tbval) return;

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
		if($contact_options['target']) $tbval['target']=1; else 
		if(isset($tbval['target'])) {
			if((int)$tbval['target'] || strtolower($tbval['target'])=="y" || $tbval['target']=="YES") $tbval['target']=1;
			else unset($tbval['target']);
		} 

		$tbval['share_user_id']=$contact_options['record_owner'];

		//Contact Account

		if($tab_account_name) {
			$tab_account_id=0;
			//$account_info = $this->crm->get_acRecord("LOWER(account_name)='".strtolower($tab_account_name)."'".$ownq,'account_id','A');
			$account_info = $this->crm->get_acRecord("LOWER(account_name)=".$this->db->escape(strtolower($tab_account_name))." ".$ownq,'account_id','A');
			if($account_info) {
				$tab_account_id = $account_info['account_id'];
			} else {
				$tab_account = array();
				$tab_account['account_name']=$tab_account_name;
				if($target_account) $tab_account['target']=$contact_options['target_account'];
				$tab_account['share_user_id']=$contact_options['record_owner'];
				$tab_account['create_date']=date("Y-m-d H:i:s");
				$tab_account['modify_date']=date("Y-m-d H:i:s");
				//print_r($tab_account);
				$tab_account_id = $this->crm->save_account($tab_account,0);
			}
			$tbval['account_id']=$tab_account_id;
		}

		//verify unique email address
		$redID = 0;
		if($tbval['email']) {
			$email_info = $this->crm->get_acRecord("LOWER(email)='".strtolower($tbval['email'])."'".$ownq,'contact_id','C');
			if($email_info) {
				$redID = $email_info['contact_id'];
				$tbval = array_filter($tbval);
			}
		}
		$cid=0;
		//print_r($tbval);
		$cid = $this->crm->save_contact($tbval,$redID);

		if($cid){
			//Interaction
			if(isset($_SESSION['cimport_interaction']) && $_SESSION['cimport_interaction'])
				$this->saveInteraction($cid,'C');
			//Category List ID & assign record to list
			if($contact_options['records_listid']) {
				$exist_record = $this->crm->get_category_record($contact_options['records_listid'],$cid);
				if(!$exist_record) {
					$info = array('category_id'=>$contact_options['records_listid'],'record_id'=>$cid);
					//print_r($info);
					$this->crm->save_category_record($info);
				}
			}
			//custom
			foreach($custom as $ci=>$cv) {
				$ecdata = array('section'=>'C','recid'=>$cid,'ckey'=>$ci,'cval'=>$cv);
				//print_r($ecdata);
				$this->crm->save_custom_record($ecdata);
			}

			//Address
			if($address) {
				$this->crm->delete_address($cid,'C','amail');
				$address['parent_id']=$cid;
				$address['adr_type']='amail';
				$address['parent_type']='C';
				//print_r($address);
				$this->crm->save_address($address);
			}
		}
	}

	//Accounts importing
	//save accounts imported int db
	public function save_accounts_imported()
	{
		if($this->input->post('cbaction')=="save_accounts_imported") {
			$json = array('msg'=>'','status'=>false);
			$filename = $this->session->userdata('aimport_data');
			if(!$filename || !file_exists($filename)) {
				$json['msg']="Import file not found";
				echo json_encode($json);return;
			}

			$record=$this->input->post('record');
			//Category List ID
			$records_listid = (isset($record['listid']) && $record['listid'])?$record['listid']:0;
			//print_r($record);
			$er = array();
			$tbcol = array_filter($record['tbcol']);
			if(!$tbcol) {
				$json['msg']="Select account fields";
				echo json_encode($json);return;
			}
			
			//Interaction
			if(!isset($_SESSION['cimport_interaction']))
				$this->getInteraction();

			//Selected mapping fields
			$tabcols = array();
			foreach($record['tbcol'] as $ki=>$kv) {
				if(!$kv) continue;
				$tabcols[$kv]=$record['excol'][$ki];
			}
			//print_r($tabcols);exit;
			//account_name should be in selected account fields
			if(!isset($tabcols['account_name'])) {
				$json['msg']="Account name required";
				echo json_encode($json);return;
			}

			//Target Contact
			if(isset($record['target'])) $target=1; else $target=0;
			//Assign Record Owner
			if(isset($record['share_user_id']) && $record['share_user_id']) $record_owner=$record['share_user_id']; 
			else $record_owner=$this->_user_id;
			//Category List ID
			$records_listid = (isset($record['listid']) && $record['listid'])?$record['listid']:0;					

			$account_options = array('target'=>$target,'record_owner'=>$record_owner,'records_listid'=>$records_listid);

			$adr = array('bstreet','bcity','bstate','bzipcode','bcountry');
			$adr2 = array('sstreet','scity','sstate','szipcode','scountry');		

			$ext = substr(strrchr($filename,'.'),1);
			$rowdata = array();

			$header = array();
			$arr_data = array();

			$header2 = array();
			$exrows2 = array();
			$keys2 = array();
			$keys3 = array();
			$processed_records = 0;
			$processed_completed = 0;
			$lastRow=0;
			$row=0;
			$dorows = 100;

			$savemap = 0;
			//$pres_cimport_no = $this->session->userdata('cimport_no');
			//$_SESSION['cimport_no_2']=0;
			$pres_cimport_no = $_SESSION['aimport_no_2'];
			if(!$pres_cimport_no) $pres_cimport_no=0;
			if($pres_cimport_no==0) $savemap = 1;
			//echo "1. PINO:$pres_cimport_no ";

			if($ext=="xls" || $ext=="xlsx") {
				$rowstart = $pres_cimport_no==0?$pres_cimport_no+2:$pres_cimport_no+1;
				//echo "2. PINO:$pres_cimport_no ";

				$this->load->library('excel');

				// Use PCLZip rather than ZipArchive
				PHPExcel_Settings::setZipClass(PHPExcel_Settings::PCLZIP);
				$objPHPExcel = PHPExcel_IOFactory::load($filename);

				$lastRow = $objPHPExcel->getActiveSheet()->getHighestRow();
				$highestColumn = $objPHPExcel->getActiveSheet()->getHighestColumn();
				$colNumber = PHPExcel_Cell::columnIndexFromString($highestColumn);

				if($lastRow<=1) {
					$json['msg']="No data in Excel file";
					echo json_encode($json);return;
				}
				if($rowstart>$lastRow) {
					$json['status']=true;
					$json['msg']="Import completed";
					$json['processed']=$lastRow-1;
					$json['completed']=1;
					echo json_encode($json);return;
				}

				$objWorksheet = $objPHPExcel->setActiveSheetIndex(0);

				//get header
				if($savemap) {
					$row=2;
					for($col = 0; $col<$colNumber;$col++) {
						$exval = $objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
						//$alphabet = chr($alphno++);
						$header[] = $exval;//$alphabet;
					}
					$rowdata['header'] = $header;	
				}
				

				for($row=$rowstart,$n=1;$row<=$lastRow && $n<=$dorows;$row++,$n++) {
					$dataRow = array();
					for($col = 0; $col<$colNumber;$col++) {
						$dataRow[] = $objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
					}
					//save $dataRow in crm
					//print_r($dataRow);
					//$this->session->set_userdata('cimport_no', $row);
					//$_SESSION['cimport_no_2'] = $row;
					//echo "3. PINO:$row ";
					//$_SESSION['cimport_row'] = $rowstart.'-'.$row;
					$this->saveAccountImported($dataRow,$tabcols,$account_options);
					//break;
				}
				$processed_records = $row-2;
				$processed_completed = $row>=$lastRow?1:0;
			} else {
				//CSV

				$this->load->library('parsecsv');

				$csv = new Parsecsv();
				$csv->auto($filename);
				$csvdata = $csv->data;

				if(!$csvdata || !is_array($csvdata)) $ermsg = "No data in CSV file";
				else if(count($csvdata)==0) $ermsg = "No data in CSV file";
				if($ermsg) {
					$json['msg']=$ermsg;
					echo json_encode($json);return;
				}				

				$lastRow = count($csvdata);


				$rowdata['values'] = $csvdata;

				$rowstart = $pres_cimport_no==0?0:$pres_cimport_no+1;
				//print_r($csvdata);
				//echo "$rowstart";

				if($rowstart>$lastRow) {
					$json['status']=true;
					$json['msg']="Import completed";
					$json['processed']=$lastRow-1;
					$json['completed']=1;
					echo json_encode($json);return;
				}
				$header = $csvdata[0];
				$rowdata['header'] = $header;

				for($row=$rowstart,$n=1;$row<$lastRow && $n<=$dorows;$row++,$n++) {
					$dataRow = $csvdata[$row];
					//save $dataRow in crm
					//print_r($dataRow);
					$dataRow = array_values($dataRow);
					//print_r($dataRow);
					//$this->session->set_userdata('cimport_no', $row);
					//$_SESSION['cimport_no_2'] = $row;
					$this->saveAccountImported($dataRow,$tabcols,$account_options);
					//break;
				}
				$processed_records = $row;
				$processed_completed = $row>=$lastRow?1:0;
			}

			//mapping
			if($savemap && isset($record['mapping'])){				
				$table_fields = import_fields('account');
				//echo "Save Mapping";
				//print_r($table_fields);
				//echo "Save Mapping";

				$where = array();
				$where['user_id'] = $this->_user_id;
				$where['field_type'] = 'amapping';
				$user_info = $this->home->getUserData($where);

				$data = array();
				$headers=$rowdata['header'];
				$exheaders = array();
				foreach($tabcols as $key=>$value){
					$exheaders[$table_fields[$key]]=$headers[$value];
					//$exheaders[$key]=$headers[$value];
					$tabcols[$key]=$headers[$value];
				}
				$data1['val'] = $tbcol;
				$data1['excel']=$tabcols;
				$data1['headers']= $exheaders;
				//print_r($data1);
				$data['value']=serialize($data1);
				if($user_info) {
					$this->home->saveUserData($data,$where);
				}
				else {
					$data['user_id'] = $this->_user_id;
					$data['field_type'] = 'amapping';
					$this->home->saveUserData($data);
				}
			}
			//$contacts=$this->input->post('record');
			//print_r($contacts);
			$json['status']=true;
			$json['msg']=$processed_completed?"Import completed, Records processed: $processed_records":"Records processed: $processed_records . Remaining records import inprocess.";
			$json['processed']=$lastRow-1;
			$json['completed']=$processed_completed;
			//Interaction
			if($processed_completed) {
				if(isset($_SESSION['cimport_interaction'])) unset($_SESSION['cimport_interaction']);
			}
			$json['total']=$lastRow;
			$json['row']=$row;
			echo json_encode($json);return;
		}
		return;
	}

	//Save excel/csv account row
	function saveAccountImported($fval,$tabcols,$account_options) {
		$tbval = array();
		$address = array();
		$address2 = array();		
		$custom=array();
		$adr = array('bstreet','bcity','bstate','bzipcode','bcountry');
		$adr2 = array('sstreet','scity','sstate','szipcode','scountry');

		$own = implode(",", $this->_parent_users);
		$ownq = " AND userid IN ($own)";

		foreach($tabcols as $ci=>$cv) {
			if(empty($fval["$cv"])) continue;
			//custom
			if(substr($ci,0,5)=="field"){
				$custom[$ci]=$fval["$cv"]; 
				continue;
			}

			if(in_array($ci,$adr)!==false) $address[substr($ci,1)]=$fval["$cv"];
			else $tbval[$ci]=$fval["$cv"];
		}
		$_SESSION['aimport_no_2'] = $_SESSION['aimport_no_2']+1;
		if(!$tbval) return;


		$tbval['create_date']=date("Y-m-d H:i:s");
		$tbval['modify_date']=date("Y-m-d H:i:s");
		if(isset($tbval['sla_expdate']) && !empty($tbval['sla_expdate'])) {
			if(empty($tbval['sla_expdate'])) unset($tbval['sla_expdate']);
			else {
				$tmpdate = explode("/",$tbval['sla_expdate']);//m/d/y-012
				if(count($tmpdate)==3) 
					$tbval['sla_expdate']="{$tmpdate[2]}-{$tmpdate[0]}-{$tmpdate[1]}";//y-m-d 201	
				else unset($tbval['sla_expdate']);
			}
		}

		//Target Contact
		if($account_options['target']) $tbval['target']=1; else 
		if(isset($tbval['target'])) {
			if((int)$tbval['target'] || strtolower($tbval['target'])=="y" || $tbval['target']=="YES") $tbval['target']=1;
			else unset($tbval['target']);
		} 

		if(isset($tbval['revenue'])) $tbval['revenue']=(float)$tbval['revenue'];
		if(isset($tbval['employees'])) $tbval['employees']=(int)$tbval['employees'];
		if(isset($tbval['numlocations'])) $tbval['numlocations']=(int)$tbval['numlocations'];				

		$tbval['share_user_id']=$account_options['record_owner'];
		$cid=0;
		//print_r($tbval);
		//exit;
		//return;
		$account_info = $this->crm->get_acRecord("LOWER(account_name)=".$this->db->escape(strtolower($tbval['account_name']))." ".$ownq,'account_id','A');
		if($account_info) $cid = $account_info['account_id'];
		$cid = $this->crm->save_account($tbval,$cid);

		if($cid){
		
			//Interaction
			if(isset($_SESSION['cimport_interaction']) && $_SESSION['cimport_interaction'])
			$this->saveInteraction($cid,'A');
			
			
			//Category List ID & assign record to list
			if($account_options['records_listid']) {
				$exist_record = $this->crm->get_category_record($account_options['records_listid'],$cid);
				if(!$exist_record) {
					$info = array('category_id'=>$account_options['records_listid'],'record_id'=>$cid);
					//print_r($info);
					$this->crm->save_category_record($info);
				}
			}
			//custom
			foreach($custom as $ci=>$cv) {
				$ecdata = array('section'=>'A','recid'=>$cid,'ckey'=>$ci,'cval'=>$cv);
				//print_r($ecdata);
				$this->crm->save_custom_record($ecdata);
			}

			//Address
			if($address) {
				$this->crm->delete_address($cid,'A','billing');
				$address['parent_id']=$cid;
				$address['adr_type']='billing';
				$address['parent_type']='A';
				//print_r($address);
				$this->crm->save_address($address);
			}
		}
		//exit;
	}

	//End of Accounts Excel/CSV file imported
	//Delete task records
	public function deleteTasks()
	{
		$json = array('msg'=>'Deleting tasks....','status'=>false,'done'=>0,'rcount'=>0,'completed'=>0);
		$dorows = 50;
		$done=$this->input->post('done');
		$done = $done?(int)$done:0;
		$rcount = 0;
		if($this->input->post('action')=="deleteall") {			
			$records=$this->input->post('recids');
			$rcount = count($records);
			if($records) {
				for($i=$done,$j=1;$i<$rcount && $j<=$dorows;$i++,$j++) {
					$this->crm->delete_task($records[$i]);
					$done++;
				}
			}
			if($rcount==$done) {
				$json['completed'] = 1;
				$json['msg'] = "Selected recored deleted.";
			}
			else $json['msg'] = "Deleted $done out of $rcount. Remaining are deleting....";
			$json['status'] = true;
		}
		$json['done'] = $done;
		$json['rcount'] = $rcount;
		echo json_encode($json);return;
	}

	//INTERACTIONS
	//Get Interaction
	public function getInteraction()
	{
		//starting input
		$record_intr=$this->input->post('record2');
		/*if(!isset($record_intr['interaction'])) {
			$_SESSION['cimport_interaction']=0;
			return;
		}*/
		//echo "<pre>";print_r($record_intr);echo "</pre>";exit;

		$catg = 0;

		$er = array();

		//if(empty($record_intr['record_id'])) $er['record_id']=$this->_data['parent_name']." required";
		////$record_intr['record_id'] = 'CONTACT ID';

		$ci_intro = 0;
		if(isset($_SESSION['cimport_interaction'])) return;

		$catg = 1;

		if(empty($record_intr['idate'])) {
			//$er['idate']="Date required";
			//echo "1 ";
			$_SESSION['cimport_interaction']=0;
			return;
		}

		//validate by section notes

		$notes = '';

		$points = 0;

		$pursuit = 0;

		$objection = "";

		$objections = array();

		//Track Interactions

		$interactions = array();

		//echo "<pre>";print_r($record_intr);echo "</pre>";exit;

		//echo "<pre>";						

		if($catg) {				
			$categories = crm_introptions();
			//Cheched Options
			$CatgintOptions = $categories['category'];

			foreach($record_intr['secnotes'] as $si=>$snval) {

				if(count($record_intr['opt'][$si])>0 || !empty($snval)) {

					$chkval = $si;//1n1 <cat>n<sect>

					$chkval = explode("n",$chkval);//cat-sect

					//$sec_val = $categories[$chkval[0]]['sections'][$chkval[1]];
					$sect = $chkval[1];
					if($sect==1) $sec_val = $categories['category'][$chkval[0]][1];
					else $sec_val = $categories['sections'][$chkval[1]];

					//print_r($sec_val);

					$sec_opt = $sec_val['options'];

					//print_r($sec_opt);

					//$notes = $sec_val[''];

					$notes .= $sec_val['name'].":\n";

					if(count($record_intr['opt'][$si])>0) {	

						//Editable points for Scripter User

						$epoints = 1;

						if($this->_data['is_prolite']) $epoints = 0;

						$points_qp = $record_intr['qp'][$si];

						$points_pp = $record_intr['pp'][$si];

						foreach($record_intr['opt'][$si] as $oi=>$oval) {

							//objections

							$objId = 0;

							if($si==$catg."n4") {

								if($oval=="O") {//other objection

									$objection = $record_intr['opto_txt'.$catg][$oi];

									$objId = $record_intr['opto_id'.$catg][$oi];

									//if(empty($record_intr['opto_select'.$catg]) && empty($record_intr['opto_txt'.$catg])) $er['objection']="Objection other value required";

									if(empty($objection)) {
										$er['objection']="Objection other value required";
										continue;
									}

									if($objection) {

										$notes .= "-".$objection."\n";

										$objOther = end($sec_opt);

										//Editable points for Scripter User

										if($epoints) {

											//$notes .= "Quality Points: ".$points_qp[$oval]."\n";

											$points += $points_qp[$oi];

											$pursuit += $points_pp[$oi];

										} else {

											//$notes .= "Quality Points: ".$objOther['points']."\n";

											$points += $objOther['points'];

											$pursuit += $objOther['pursuit'];	

										}

										$objections[] = array($objection,'Y');

										//Track Interactions

										if($objId) $interactions[] = array('c'=>$chkval[0],'s'=>$chkval[1],'o'=>$objId,'i'=>'O');

										else 

											$interactions[] = array('c'=>$chkval[0],'s'=>$chkval[1],'o'=>count($objections)-1,'i'=>'CO');

									}

									continue;

								} else $objections[] = array($sec_opt[$oval]['name'],'');

							}

							//Track Interactions								

							$interactions[] = array('c'=>$chkval[0],'s'=>$chkval[1],'o'=>$oval,'i'=>'I');

							

							$notes .= "-".$sec_opt[$oval]['name']."\n";

							//Quality Points

							//Editable points for Scripter User

							if($epoints) {

								//$notes .= "Quality Points: ".$points_qp[$oval]."\n";

								$points += $points_qp[$oval];

								$pursuit += $points_pp[$oval];

							} else {

								//$notes .= "Quality Points: ".$sec_opt[$oval]['points']."\n";

								$points += $sec_opt[$oval]['points'];

								$pursuit += $sec_opt[$oval]['pursuit'];

							}

						}

					} 

					if($snval) {

						$notes .= "-".trim($snval)."\n";

					}

					$notes .= "\n";

				}

			}	

			//Schedule Follow-Up Task
			$notes1 = "";
			$sft_no_er = 1;
			if(!empty($record_intr['sch'][$catg]) || !empty($record_intr['schnotes'][$catg])) {
				$notes1 .= "Schedule Follow-Up Task:\n";
				if($record_intr['sch'][$catg]) {
					if($record_intr['sch'][$catg]=="O") {
						if(empty($record_intr['sch_txt'.$catg])) {
							//$er['sch']="Schedule Follow-Up Task other value required";
							$sft_no_er=1;
						}
						else $record_intr['sch'][$catg]=$record_intr['sch_txt'.$catg];
					}
				}

				if($record_intr['sch'][$catg]) $notes1 .= "-".$record_intr['sch'][$catg]."\n";
				if(!empty($record_intr['schnotes'][$catg])) 
					$notes1 .= "-".$record_intr['schnotes'][$catg]."\n";
			}
			if($sft_no_er) $notes .= $notes1;
		}

		if(empty($notes)) $er['notes']="Please check options";
		if($er) {
			//echo "Required inputs for Interaction";
			//print_r($er);echo "2 ";
			$_SESSION['cimport_interaction']=0;
			return;
		}
		//prepare interaction session
		$intro_items = array();
		$tmpdate = explode("/",$record_intr['idate']);//m/d/y-012
		$idate="{$tmpdate[2]}-{$tmpdate[0]}-{$tmpdate[1]}";//y-m-d 201
		$intro_items['idate']=$idate;
		$intro_items['notes']=$notes;
		$intro_items['points']=$points;
		$intro_items['pursuit']=$pursuit;
		$intro_items['objections']=$objections;
		$intro_items['objection']=$objection;
		$intro_items['interactions']=$interactions;
		if($record_intr['sch'][$catg]) {
			if(!empty($record_intr['sdate'][$catg])) {
				$tmpdate = explode("/",$record_intr['sdate'][$catg]);//m/d/y-012
				$schdate="{$tmpdate[2]}-{$tmpdate[0]}-{$tmpdate[1]}";//y-m-d 201
			} else $schdate=date("Y-m-d");
			$intro_items['schft']=array('sch'=>$record_intr['sch'][$catg],'date'=>$schdate);	
		}
		$_SESSION['cimport_interaction']=$intro_items;
		//print_r($intro_items);
		//exit;
	}
	//Save interaction
	public function saveInteraction($contact_id,$type)
	{
		//print_r($_SESSION);
		//create interaction when interaction exists
		if(!isset($_SESSION['cimport_interaction'])) return;
		if(!$_SESSION['cimport_interaction']) return;
		$record_intr = $_SESSION['cimport_interaction'];
		$record_intr['record_id'] = $contact_id;
		$idate=$record_intr['idate'];
		$notes=$record_intr['notes'];		
		$points=$record_intr['points'];
		$pursuit=$record_intr['pursuit'];
		$objections=$record_intr['objections'];
		$objection=$record_intr['objection'];
		$interactions=$record_intr['interactions'];
		$catg =1;

		//Create completed task : Log a Call

		$taskdata = array(

					//'task_subject'=>$categories[$catg]['name'],
					'task_subject'=>'Interaction',

					'task_priority'=>'Normal',

					'task_status'=>strtotime($idate)>time()?'In Progress':'Completed',

					'task_duedate'=>$idate,

					'task_related'=>$type,

					'task_relatedto'=>$record_intr['record_id'],

					'share_user_id'=>$this->_user_id,

					'task_created'=>$idate." 00:00:00",

					'task_modified'=>$idate." 00:00:00",

					'task_info'=>$notes

					);

		$tid = $this->crm->save_task($taskdata,0);



		//check points and save

		$where = array('contact'=>$record_intr['record_id'],'cat'=>$catg,'pdate'=>$idate,'rctype'=>$type);

		$cont_points = $this->crm->get_points($where);

		//print_r($cont_points);

		if($cont_points) {

			$update_data = array(

					'contact'=>$record_intr['record_id'],

					'cat'=>$catg,

					'pdate'=>$idate,

					'rctype'=>$type

					);

			$points_data = array(

					'intpoints'=>$cont_points['intpoints']+$points,

					'purpoints'=>$cont_points['purpoints']+$pursuit,

					'taskid'=>$tid

					);

			$this->crm->save_points($points_data,$update_data);

		} else {

			$points_data = array(

					'contact'=>$record_intr['record_id'],

					'rctype'=>$type,

					'pdate'=>$idate,

					'intpoints'=>$points,

					'purpoints'=>$pursuit,

					'taskid'=>$tid,

					'cat'=>$catg

					);

			$this->crm->save_points($points_data);

		}
		//print_r($points_data);


		//Objection

		$cobjectIds = array();

		if($objections || $objection) {

			//$objdate = date("Y-m-d");

			$objdate = $idate;

			//Saving Objection usages

			foreach($objections as $obid=>$obval) {

				$objval = strtolower(str_replace(" ","",$obval[0]));

				$objid = $this->crm->check_objection($objval);

				if(!$objid) {

					$update = array('obj_val'=>$obval[0],'obj_custom'=>$obval[1],'obj_rctype'=>$type,'obj_recid'=>$record_intr['record_id'],'obj_task'=>$tid);

					$objid=$this->crm->save_objection($update);

				}

				if($objid && $obval[1]=="Y") $cobjectIds[$obid] = $objid;

				$objectn = $this->crm->check_objection_date($objid,$objdate);

				if($objectn) {

					$objtasks = $tid;

					if($objectn['objtask']) $objtasks = $objectn['objtask'].",".$objtasks;

					$update = array('objcount'=>$objectn['objcount']+1,'objtask'=>$objtasks);

					$this->crm->save_objection_date($update,$objectn);

				} else {

					$update = array('objid'=>$objid,'objdate'=>$objdate,'objtask'=>$tid);

					$this->crm->save_objection_date($update);

				}

			}

		}


		//Track Interactions Saving

		if($interactions) {

			//$intr_date = date("Y-m-d");

			$intr_date = $idate;

			foreach($interactions as $ival) {

				$intr_sno=$ival['c']."-".$ival['s']."-".$ival['o'];

				if($ival['i']=="CO") {

					$ival['o']=$cobjectIds[$ival['o']];

					if(!$ival['o']) continue;

					$ival['i']="O";

				}

				if($ival['i']=="O") $intr_sno=$ival['c']."-".$ival['s']."-O".$ival['o'];

				//$intrdata = $this->crm->check_interaction_date($intr_sno,$intr_date);
				$where = array('intr_sno'=>$intr_sno,'intr_date'=>$intr_date,'intr_rctype'=>$type,'intr_recid'=>$record_intr['record_id']);
				$intrdata = $this->crm->check_interaction_date($where);

				if($intrdata) {

					$update = array('intr_count'=>$intrdata['intr_count']+1);
					$this->crm->save_interaction_date($update,$intrdata);

				} else {

					$update = array(

						'intr_cat'=>$ival['c'],

						'intr_sect'=>$ival['s'],

						'intr_opt'=>$ival['o'],

						'intr_otype'=>$ival['i'],

						'intr_sno'=>$intr_sno,

						'intr_rctype'=>$type,

						'intr_recid'=>$record_intr['record_id'],

						'intr_task'=>$tid,

						'intr_date'=>$intr_date);

					$this->crm->save_interaction_date($update);

				}

			}

		}

		//Schedule Follow up Task

		if($record_intr['schft']) {
			$schft = $record_intr['schft'];
			$schdate=$schft['date'];

			$taskdata = array(
						'task_subject'=>$schft['sch'],
						'task_priority'=>'Normal',
						'task_status'=>'In Progress',
						'task_related'=>$type,
						'task_relatedto'=>$record_intr['record_id'],
						'share_user_id'=>$this->_user_id,
						'task_duedate'=>$schdate,
						'task_info'=>$notes
						);
			$tid = $this->crm->save_task($taskdata,0);
		}
		//echo "created"; exit;
	}
	
	
	
	//Email Reports
	public function EmailReportStatus() {
		$json = array('msg'=>'','status'=>false);
		if($this->input->post('action')<>"report") {
			$json['msg']="Invalid Action";
			echo json_encode($json);return;
		}
		$record=$this->input->post('record');

		$er = ""; 
		$catg=2;
		if($record['efilter']!='escheduled')
		{
			if(empty($record['ifdate'])) $er .= "From date required<br>";
			if(empty($record['itdate'])) $er .= "To date required<br>";
			if($record['ifdate'] && $record['itdate']) {
				$dt = explode("/",$record['ifdate']);//m/d/y-012
				$ifdate="{$dt[2]}-{$dt[0]}-{$dt[1]}";//y-m-d 201
				$dt = explode("/",$record['itdate']);//m/d/y-012
				$itdate="{$dt[2]}-{$dt[0]}-{$dt[1]}";//y-m-d 201
				if(strtotime($ifdate)>strtotime($itdate)) $er .= "End date should be after from date<br>";
			}
		}
		if(empty($record['efilter'])) $er .= "Email filter required";
		if($er) {
			$json['msg']=$er;
			echo json_encode($json);return;
		}
		
		if($record['efilter']=='escheduled')
		{
			//echo "<pre>"; print_r($this->_parent_users); echo "</pre>";
			$suser = $record['user'];
			if(!$suser) $user = "";
			$user = $suser;
			//$dtwhere = "(s.sch_date BETWEEN '$ifdate' AND '$itdate')";
			$contacts_count = $this->crm->get_user_scheduled_email_count($user);
		}
		else if($record['efilter']=='unsubscribes')
		{
			$suser = $record['user'];
			if(!$suser) $suser = $this->_parent_users;
			$user = $suser[0];
			$dt = explode("/",$record['itdate']);
			$itdate=$dt[2]."-".$dt[0]."-".$dt[1];
			
			$dt1 = explode("/",$record['ifdate']);
			$ifdate=$dt1[2]."-".$dt1[0]."-".$dt1[1];
			$contacts_count = $this->crm->get_user_unsubscribes_email_count($user,$ifdate,$itdate);
		}
		else
		{

			$suser = $record['user'];
			if(!$suser) $suser = $this->_parent_users;
			$dtwhere = "(i.intr_date BETWEEN '$ifdate' AND '$itdate')";
			if($record['subject']) {
				$dtwhere .= " AND i.intr_info like '%".$record['subject']."%' ";
			}
			$contacts_count = $this->crm->get_email_reports_count($suser,$dtwhere,$record['efilter']);
	
			//Counts
			$dtwhere = "(intr_date BETWEEN '$ifdate' AND '$itdate')";
			if($record['subject']) $dtwhere .= " AND intr_info like '%".$record['subject']."%' ";
			$ereportcounts = array();
			$ereportcounts['s'] = $this->crm->get_interaction_counts($suser,$dtwhere,"2-1-1");
			$ereportcounts['v'] = $this->crm->get_interaction_counts($suser,$dtwhere,"2-1-5");
			$ereportcounts['c'] = $this->crm->get_interaction_counts($suser,$dtwhere,"2-1-7");
		}	
		//echo $contacts_count;
		$this->_data['ereportcounts']=$ereportcounts;
		$html = $this->load->view('crm/email-report-status', $this->_data,true);
		$json['msg']=$html;
		$json['total']=$contacts_count;
		$json['status']=true;
		echo json_encode($json);return;		
	}
	

	//Email Reports
	public function EmailReportStatus_23042019() {
		$json = array('msg'=>'','status'=>false);
		if($this->input->post('action')<>"report") {
			$json['msg']="Invalid Action";
			echo json_encode($json);return;
		}
		$record=$this->input->post('record');

		$er = "";
		$catg=2;
		if(empty($record['ifdate'])) $er .= "From date required<br>";
		if(empty($record['itdate'])) $er .= "To date required<br>";
		if($record['ifdate'] && $record['itdate']) {
			$dt = explode("/",$record['ifdate']);//m/d/y-012
			$ifdate="{$dt[2]}-{$dt[0]}-{$dt[1]}";//y-m-d 201
			$dt = explode("/",$record['itdate']);//m/d/y-012
			$itdate="{$dt[2]}-{$dt[0]}-{$dt[1]}";//y-m-d 201
			if(strtotime($ifdate)>strtotime($itdate)) $er .= "End date should be after from date<br>";
		}
		if(empty($record['efilter'])) $er .= "Email filter required";
		if($er) {
			$json['msg']=$er;
			echo json_encode($json);return;
		}
		
		
		if($record['efilter']=='escheduled')
		{
			$suser = $record['user'];
			if(!$suser) $suser = $this->_parent_users;
			$user = $suser[0];
			$dtwhere = "(s.sch_date BETWEEN '$ifdate' AND '$itdate')";
			$contacts_count = $this->crm->get_user_scheduled_email_count($user,$dtwhere);
		}
		else if($record['efilter']=='unsubscribes')
		{
			$suser = $record['user'];
			if(!$suser) $suser = $this->_parent_users;
			$user = $suser[0];
			$dt = explode("/",$record['itdate']);
			$itdate=$dt[2]."-".$dt[0]."-".$dt[1];
			
			$dt1 = explode("/",$record['ifdate']);
			$ifdate=$dt1[2]."-".$dt1[0]."-".$dt1[1];
			$contacts_count = $this->crm->get_user_unsubscribes_email_count($user,$ifdate,$itdate);
		}
		else
		{

			$suser = $record['user'];
			if(!$suser) $suser = $this->_parent_users;
			$dtwhere = "(i.intr_date BETWEEN '$ifdate' AND '$itdate')";
			if($record['subject']) {
				$dtwhere .= " AND i.intr_info like '%".$record['subject']."%' ";
			}
			$contacts_count = $this->crm->get_email_reports_count($suser,$dtwhere,$record['efilter']);
	
			//Counts
			$dtwhere = "(intr_date BETWEEN '$ifdate' AND '$itdate')";
			if($record['subject']) $dtwhere .= " AND intr_info like '%".$record['subject']."%' ";
			$ereportcounts = array();
			$ereportcounts['s'] = $this->crm->get_interaction_counts($suser,$dtwhere,"2-1-1");
			$ereportcounts['v'] = $this->crm->get_interaction_counts($suser,$dtwhere,"2-1-5");
			$ereportcounts['c'] = $this->crm->get_interaction_counts($suser,$dtwhere,"2-1-7");
		}	
		$this->_data['ereportcounts']=$ereportcounts;
		$html = $this->load->view('crm/email-report-status', $this->_data,true);
		$json['msg']=$html;
		$json['total']=$contacts_count;
		$json['status']=true;
		echo json_encode($json);return;		
	}
	
	
		
	public function SaleReportStatus() {
		$json = array('msg'=>'','status'=>false);
		if($this->input->post('action')<>"report") {
			$json['msg']="Invalid Action";
			echo json_encode($json);return;
		}
		$record=$this->input->post('record');

		$er = "";
		$catg=2;
		if(empty($record['ifdate'])) $er .= "From date required<br>";
		if(empty($record['itdate'])) $er .= "To date required<br>";
		if($record['ifdate'] && $record['itdate']) {
			$dt = explode("/",$record['ifdate']);//m/d/y-012
			$ifdate="{$dt[2]}-{$dt[0]}-{$dt[1]}";//y-m-d 201
			$dt = explode("/",$record['itdate']);//m/d/y-012
			$itdate="{$dt[2]}-{$dt[0]}-{$dt[1]}";//y-m-d 201
			if(strtotime($ifdate)>strtotime($itdate)) $er .= "End date should be after from date<br>";
		}
		if(empty($record['stage'])) $er .= "Stage filter required";
		if($er) {
			$json['msg']=$er;
			echo json_encode($json);return;
		}
		/*$done = $done?(int)$done:0;
		$erptotal=$record['erptotal'];
		$done=$record['erpdone'];
		$contacts_count = $erptotal?(int)$erptotal:0;
		if(!$contacts_count) {
			$json['msg']="No email reports";
			echo json_encode($json);return;
		}*/

		$dorows = 200;

		
		$suser = $record['user'];
		if(!$suser) $suser = $this->_parent_users;
		$dtwhere = "(o.close_date BETWEEN '$ifdate' AND '$itdate')";
		if($record['stage']) {
			$dtwhere .= " AND o.stage like '%".$record['stage']."%' ";
		}
		
		$opportunities = $this->crm->get_sale_opportunity($suser,$dtwhere);
		
		//echo '<pre>'; print_r($opportunities); echo '</pre>';
		//exit;
		
		$trs = array();
		$t3 = array();
		$totalAmount = 0;
		foreach($opportunities as $ni=>$opportunity) {
			$done++;
			
			$col3 = '';
			if($opportunity->usrname) {
                $col3 = ucfirst($opportunity->usrname);
            }
			$col4 = '';
			if($opportunity->contact_id) {
                $col4 = '<a href="'.base_url('crm/contacts/view').'/'.$opportunity->contact_id.'">'.ucfirst($opportunity->user_last).'</a>';
            }
			$col5 = '';
			if($opportunity->account_id) {
                $col5 = '<a href="'.base_url('crm/accounts/view').'/'.$opportunity->account_id.'">'.ucfirst($opportunity->account_title).'</a>';
            }
			$col6 = '';
			if($opportunity->amount) {
                $col6 = $opportunity->amount;      
				if($col6) { 
					$col6 = '<b>$'.number_format($col6).'</b>';
					$totalAmount = $totalAmount+$opportunity->amount;      
				}
            }
			$col7 = '';
			if($opportunity->close_date) {
                $col7 = $opportunity->close_date;       
            }
			if($record['efilter']=="escheduled")	$recidval = $contact->sch_id;
			else $recidval = $opportunity->contact_id;
			$t2 = array(
				$col3,
				$col4,
				$col5,
				$col6,
				$col7
			);
			$trs[] = $t2;							
		}		
		$completed = $done>=$contacts_count?1:0;
		$json['trs']=$trs;
		$json['type']=$record['efilter'];
		$json['status']=true;
		$json['msg']=$completed?"Sales report listing completed.":"$done out of $contacts_count records displayed, Remaining records listing inprocess.";
		$json['done']=$done;
		$json['total']=$contacts_count;
		$json['totalAmount']=$totalAmount;
		$json['completed']=$completed;
		echo json_encode($json);return;	
	}
	
	
	public function getallSubjectsEmails() 
	{
		$record=$this->input->post('action');
		$user=$this->input->post('uid');
		$ename=$this->input->post('ename');
		$ifdate=$this->input->post('ifdate');
		$itdate=$this->input->post('itdate');
		if($record == 'Emails') 
		{
			$ifdate = date("Y-m-d",strtotime($ifdate));
			$itdate = date("Y-m-d",strtotime($itdate));
			$suser = $user;
			if(!$suser) $suser = $this->_parent_users;
			$dtwhere = "(i.intr_date BETWEEN '$ifdate' AND '$itdate')";
			$data = $this->crm->get_email_reports_subjectemail($suser,$dtwhere,$ename,$dorows,$done);
			foreach($data as $key=>$val)
			{
				$k = str_replace('{"subjects":{"',"",$val);
				$k = explode(":",$k);
				$k = $k[1];
				$k = str_replace('"}}',"",$k);
				$k = ltrim($k,'"');
				$splitted = explode('","', $k);
				$result = str_replace(',"subjects"',"",$splitted[0]); //ABC DEF GHEE JUL
				if($result!="") $subjects[] = $result;
			}
			$subjects = array_unique($subjects);
			echo json_encode($subjects); 
		}
		else if($record == 'Scheduled') 
		{
			$data = $this->crm->get_user_scheduled_subjectemail($user);
			echo json_encode($data); 
		}
	}
	
	
	public function deleteSEmails() 
	{
		$record=$this->input->post('rcid');
		$this->crm->delete_mschedule_email($record);
	}
	
	
		//Email Reports
	public function EmailReports() {
		$json = array('msg'=>'','status'=>false);
		if($this->input->post('action')<>"report") {
			$json['msg']="Invalid Action";
			echo json_encode($json);return;
		}
		$record=$this->input->post('record');

		$er = "";
		$catg=2;
		if($record['efilter'] != 'escheduled')
		{
			if(empty($record['ifdate'])) $er .= "From date required<br>";
			if(empty($record['itdate'])) $er .= "To date required<br>";
			if($record['ifdate'] && $record['itdate']) {
				$dt = explode("/",$record['ifdate']);//m/d/y-012
				$ifdate="{$dt[2]}-{$dt[0]}-{$dt[1]}";//y-m-d 201
				$dt = explode("/",$record['itdate']);//m/d/y-012
				$itdate="{$dt[2]}-{$dt[0]}-{$dt[1]}";//y-m-d 201
				if(strtotime($ifdate)>strtotime($itdate)) $er .= "End date should be after from date<br>";
			}
		}
		if(empty($record['efilter'])) $er .= "Email filter required";
		if($er) {
			$json['msg']=$er;
			echo json_encode($json);return;
		}
		$done=$record['erpdone'];
		$done = $done?(int)$done:0;
		$erptotal=$record['erptotal'];
		$contacts_count = $erptotal?(int)$erptotal:0;
		if(!$contacts_count) {
			$json['msg']="No email reports";
			echo json_encode($json);return;
		}

		$dorows = 200;

		
		
		if($record['efilter'] == 'escheduled') {
			/*$suser = $record['user'];
			if(!$suser) $user = "";
			$user = $suser;
			//$dtwhere = "(s.sch_date BETWEEN '$ifdate' AND '$itdate')";
			$contacts = $this->crm->get_user_scheduled_email($user);*/
			
			$suser = $record['user'];
			if(!$suser) $user = "";
			$user = $suser;
			if($record['subject']) {
				$s = str_replace("'","\'",$record['subject']);
				$dtwhere = "s.sch_subject like '%".$s."%' ";
			}
			$contacts = $this->crm->get_user_scheduled_email($user,$dtwhere);
		}
		else if($record['efilter'] == 'unsubscribes') 
		{
			$suser = $record['user'];
			if(!$suser) $suser = $this->_parent_users;
			$user = $suser[0];
			$dt = explode("/",$record['itdate']);
			$itdate=$dt[2]."-".$dt[0]."-".$dt[1];			
			$dt1 = explode("/",$record['ifdate']);
			$ifdate=$dt1[2]."-".$dt1[0]."-".$dt1[1];
			$contacts = $this->crm->get_user_unsubscribes_email($user,$ifdate,$itdate);
			
			//echo '<pre>'; print_r($contacts); echo '</pre>';
			
		}
		else
		{
			$suser = $record['user'];
			if(!$suser) $suser = $this->_parent_users;
			$dtwhere = "(i.intr_date BETWEEN '$ifdate' AND '$itdate')";
			if($record['subject']) {
				$dtwhere .= " AND i.intr_info like '%".$record['subject']."%' ";
			}
			$contacts = $this->crm->get_email_reports($suser,$dtwhere,$record['efilter'],$dorows,$done);
		}
		//echo '<pre>'; print_r($contacts); echo '</pre>';
		//exit;
		
		$trs = array();
		foreach($contacts as $ni=>$contact) {
			$done++;
			
		
			if($record['efilter'] == 'unsubscribes')
			{
				$sch_contact = $contact->contact_id;
				$ucontact = $this->crm->get_contactinfo_id($sch_contact);
				//echo '<pre>'; print_r($ucontact); echo '</pre>';
			}
			$einfo = array();
            if($contact->intr_info){
                $einfo = json_decode($contact->intr_info);
            }
			$col3 = '';
			if($contact->account_id) {
                $col3 = '<a href="'.base_url('crm/accounts/view').'/'.$contact->account_id.'">'.ucfirst($contact->account_name).'</a>';
            }
            $col6 = '';
            $esinfo = array();
            if($contact->intr_info){
                $esinfo = json_decode($contact->intr_info);
                if(isset($esinfo->subjects)) {
                    $esubjects = (array)$esinfo->subjects;
                    if($esubjects) {
                    	$esubjects = array_unique($esubjects);
                    	$col6 .= implode('<br><hr>',$esubjects);		
                    }                    
                }                                   
            }
			
			if($record['efilter'] != 'unsubscribes')
			{
				if($contact->sch_subject){
                	$col6 = $contact->sch_subject;               
            	}
        	}
			
			$col7='';		
			if($einfo) {									
				if($record['efilter']=="2-1-7")	{
					$einfo = $einfo->elinks;
					foreach($einfo as $elink) $col7 .= '<a href="'.$elink.'" target="_blank">'.$elink.'</a><br>';
				}
				else {
					$col7 .= implode('<br>',$contact->sch_date);
				}
				
			}
			if($record['efilter']=="escheduled")	
			{
				$col7 .= date("m-d-Y",strtotime($contact->sch_date));
			}
			else
			{
				$col7 .= date("m-d-Y",strtotime($contact->intr_date));
			}
			
			if($record['efilter']=="escheduled")	$recidval = $contact->sch_id;
			else $recidval = $contact->intr_recid;
			if($record['efilter'] == 'unsubscribes')
			{
				$col6 = "";
				$col7 = "";
				$t2 = array(
					'<input type="checkbox" value="'.$ucontact[0]->contact_id.'"  name="recids[]" class="rcselect"/>',
					'<a href="'.base_url('crm/contacts/view').'/'.$ucontact[0]->contact_id.'">'.$ucontact[0]->contactName.'</a>',
					'<a href="'.base_url('crm/accounts/view').'/'.$ucontact[0]->account_title.'">'.ucfirst($ucontact[0]->account_title).'</a>',
					($ucontact[0]->mobile?'<a href="tel:'.$ucontact[0]->mobile.'">'.$ucontact[0]->mobile.'</a>':''),
					($ucontact[0]->email?'<a href="mailto:'.$ucontact[0]->email.'">'.$ucontact[0]->email.'</a>':''),
					$col6,
					$col7
				);
				$trs[] = $t2;	
			}
			else if($record['efilter'] == 'escheduled')
			{
				$t2 = array(
					'<input type="checkbox" value="'.$recidval.'"  name="recids[]" class="rcselect"/>',
					'<a href="'.base_url('crm/contacts/view').'/'.$contact->sch_contact.'">'.ucfirst($contact->user_first.' '.$contact->user_last).'</a>',
					$col3,
					($contact->phone?'<a href="tel:'.$contact->phone.'">'.$contact->phone.'</a>':''),
					($contact->email?'<a href="mailto:'.$contact->email.'">'.$contact->email.'</a>':''),
					$col6,
					$col7
				);
				$trs[] = $t2;	
			}
			else
			{
				$t2 = array(
					'<input type="checkbox" value="'.$recidval.'"  name="recids[]" class="rcselect"/>',
					'<a href="'.base_url('crm/contacts/view').'/'.$contact->sch_contact.'">'.ucfirst($contact->user_first.' '.$contact->user_last).'</a>',
					$col3,
					($contact->phone?'<a href="tel:'.$contact->phone.'">'.$contact->phone.'</a>':''),
					($contact->email?'<a href="mailto:'.$contact->email.'">'.$contact->email.'</a>':''),
					$col6,
					$col7
				);
				$trs[] = $t2;	
			}						
		}
		
		//echo "<pre>"; print_r($trs); echo "</pre>";
		//exit;
		$completed = $done>=$contacts_count?1:0;
		$json['trs']=$trs;
		$json['type']=$record['efilter'];
		$json['status']=true;
		$json['msg']=$completed?"Email report listing completed.":"$done out of $contacts_count records displayed, Remaining records listing inprocess.";
		$json['done']=$done;
		$json['total']=$contacts_count;
		$json['completed']=$completed;
		echo json_encode($json);return;	
	}
	

	//Email Reports
	public function EmailReports_old23042019() {
		$json = array('msg'=>'','status'=>false);
		if($this->input->post('action')<>"report") {
			$json['msg']="Invalid Action";
			echo json_encode($json);return;
		}
		$record=$this->input->post('record');

		$er = "";
		$catg=2;
		if(empty($record['ifdate'])) $er .= "From date required<br>";
		if(empty($record['itdate'])) $er .= "To date required<br>";
		if($record['ifdate'] && $record['itdate']) {
			$dt = explode("/",$record['ifdate']);//m/d/y-012
			$ifdate="{$dt[2]}-{$dt[0]}-{$dt[1]}";//y-m-d 201
			$dt = explode("/",$record['itdate']);//m/d/y-012
			$itdate="{$dt[2]}-{$dt[0]}-{$dt[1]}";//y-m-d 201
			if(strtotime($ifdate)>strtotime($itdate)) $er .= "End date should be after from date<br>";
		}
		if(empty($record['efilter'])) $er .= "Email filter required";
		if($er) {
			$json['msg']=$er;
			echo json_encode($json);return;
		}
		$done=$record['erpdone'];
		$done = $done?(int)$done:0;
		$erptotal=$record['erptotal'];
		$contacts_count = $erptotal?(int)$erptotal:0;
		if(!$contacts_count) {
			$json['msg']="No email reports";
			echo json_encode($json);return;
		}

		$dorows = 200;

		
		if($record['efilter'] == 'escheduled') {
			$suser = $record['user'];
			if(!$suser) $suser = $this->_parent_users;
			$user = $suser[0];
			$dtwhere = "(s.sch_date BETWEEN '$ifdate' AND '$itdate')";
			$contacts = $this->crm->get_user_scheduled_email($user,$dtwhere);
		}
		else if($record['efilter'] == 'unsubscribes') 
		{
			$suser = $record['user'];
			if(!$suser) $suser = $this->_parent_users;
			$user = $suser[0];
			$dt = explode("/",$record['itdate']);
			$itdate=$dt[2]."-".$dt[0]."-".$dt[1];			
			$dt1 = explode("/",$record['ifdate']);
			$ifdate=$dt1[2]."-".$dt1[0]."-".$dt1[1];
			$contacts = $this->crm->get_user_unsubscribes_email($user,$ifdate,$itdate);
		}
		else
		{
			$suser = $record['user'];
			if(!$suser) $suser = $this->_parent_users;
			$dtwhere = "(i.intr_date BETWEEN '$ifdate' AND '$itdate')";
			if($record['subject']) {
				$dtwhere .= " AND i.intr_info like '%".$record['subject']."%' ";
			}
			$contacts = $this->crm->get_email_reports($suser,$dtwhere,$record['efilter'],$dorows,$done);
		}
		
		$trs = array();
		foreach($contacts as $ni=>$contact) {
			$done++;
			if($record['efilter'] == 'unsubscribes')
			{
				$sch_contact = $contact->contact_id;
				$ucontact = $this->crm->get_contactinfo_id($sch_contact);
				//echo '<pre>'; print_r($ucontact); echo '</pre>';
			}
			$einfo = array();
            if($contact->intr_info){
                $einfo = json_decode($contact->intr_info);
            }
			$col3 = '';
			if($contact->account_id) {
                $col3 = '<a href="'.base_url('crm/accounts/view').'/'.$contact->account_id.'">'.ucfirst($contact->account_name).'</a>';
            }
            $col6 = '';
            $esinfo = array();
            if($contact->intr_info){
                $esinfo = json_decode($contact->intr_info);
                if(isset($esinfo->subjects)) {
                    $esubjects = (array)$esinfo->subjects;
                    if($esubjects) {
                    	$esubjects = array_unique($esubjects);
                    	$col6 .= implode('<br><hr>',$esubjects);		
                    }                    
                }                                   
            }
			
			if($record['efilter'] != 'unsubscribes')
			{
				if($contact->sch_subject){
                	$col6 = $contact->sch_subject;               
            	}
        	}
			
			$col7='';		
			if($einfo) {									
				if($record['efilter']=="2-1-7")	{
					$einfo = $einfo->elinks;
					foreach($einfo as $elink) $col7 .= '<a href="'.$elink.'" target="_blank">'.$elink.'</a><br>';
				} else {
					$col7 .= implode('<br>',$einfo->tnames);
				}
			}	
			
			if($record['efilter']=="escheduled")	$recidval = $contact->sch_id;
			else $recidval = $contact->intr_recid;
			if($record['efilter'] == 'unsubscribes')
			{
				$col6 = "";
				$col7 = "";
				$t2 = array(
					'<input type="checkbox" value="'.$ucontact[0]->contact_id.'"  name="recids[]" class="rcselect"/>',
					'<a href="'.base_url('crm/contacts/view').'/'.$ucontact[0]->contact_id.'">'.$ucontact[0]->contactName.'</a>',
					'<a href="'.base_url('crm/accounts/view').'/'.$ucontact[0]->account_title.'">'.ucfirst($ucontact[0]->account_title).'</a>',
					($ucontact[0]->mobile?'<a href="tel:'.$ucontact[0]->mobile.'">'.$ucontact[0]->mobile.'</a>':''),
					($ucontact[0]->email?'<a href="mailto:'.$ucontact[0]->email.'">'.$ucontact[0]->email.'</a>':''),
					$col6,
					$col7
				);
				$trs[] = $t2;	
			}
			else
			{
				$t2 = array(
					'<input type="checkbox" value="'.$recidval.'"  name="recids[]" class="rcselect"/>',
					'<a href="'.base_url('crm/contacts/view').'/'.$contact->intr_recid.'">'.ucfirst($contact->user_first.' '.$contact->user_last).'</a>',
					$col3,
					($contact->phone?'<a href="tel:'.$contact->phone.'">'.$contact->phone.'</a>':''),
					($contact->email?'<a href="mailto:'.$contact->email.'">'.$contact->email.'</a>':''),
					$col6,
					$col7
				);
				$trs[] = $t2;	
			}
										
		}
		$completed = $done>=$contacts_count?1:0;
		$json['trs']=$trs;
		$json['status']=true;
		$json['type']=$record['efilter'];
		$json['msg']=$completed?"Email report listing completed.":"$done out of $contacts_count records displayed, Remaining records listing inprocess.";
		$json['done']=$done;
		$json['total']=$contacts_count;
		$json['completed']=$completed;
		echo json_encode($json);return;	
	}

	

	//Dashboard dropdowns
	public function dashboard_statistics() {
		error_reporting(E_ALL);
		ini_set("display_errors", 1);
		$box = $this->input->post('box');
		$userid = $this->input->post('u');
		$timer = $this->input->post('t');
		$_SESSION['ss_user_id']=$this->_data['cloguser_id'];

		//Prospect Users
		$record_owners = array();
		$record_owners[] = $this->_data['user_id'];
		if(isset($this->_data['is_prolite']) && $this->_data['is_prolite']) {
			$parent_id = $this->_data['user_id'];
		} else $parent_id = $this->_data['user_id'];
		if($parent_id) {
			$record_owners[] = $parent_id;
			$share_ids = $this->home->getSharedUsers($parent_id);
			if($share_ids)
			foreach($share_ids as $shrid) $record_owners[] = $shrid->user_id;
			$record_owners = array_unique($record_owners);
		}
		//For Lite user access
		if(isset($this->_data['is_prolite'])) {
			$shareduser = $this->home->SharedUserInfo($this->_data['cloguser_id']);
			if($shareduser) {
				if($shareduser->accessview=="Own") $record_owners = array($this->_data['cloguser_id']);
			}
		}
		$parent_ids = $record_owners;
		if($userid) $parent_ids = array($userid);
		$str_parentids = implode(",",$parent_ids);
		//echo  " $box $userid $timer";
		if($box==1 || $box==2 || $box==3)	{
			//Date Range
			$tDt1 = date("Y-m-d");
			$tDt2 = date("Y-m-d");
			$dtF = "j-M";

			if($timer==1) {$tDt1 = date("Y-m-d");$dtF = "j-M-Y";$cf=0;}
			else if($timer==2) {$tDt1 = date("Y-m-d",strtotime($tDt1)-6*24*60*60);$dtF = "j-M";}
			else if($timer==3) {$tDt1 = date("Y-m-d",strtotime($tDt1)-30*24*60*60);$dtF = "j-M";}
			else if($timer==4){$tDt1 = date("Y-m-01",strtotime($tDt1));$dtF = "j-M";}
			else if($timer==5){
				$dtF = "j-M";
				$tDt1 = date("Y-m-01",strtotime($tDt1));
				$tDt2 = date("Y-m-d",strtotime($tDt1)-24*60*60);
				$tDt1 = date("Y-m-01",strtotime($tDt2));
			} else if($timer==6){
				$tDt1 = date("Y-m-01",strtotime($tDt1));
				$tDt2 = date("Y-m-d",strtotime($tDt1)-24*60*60);
				$tDt1 = date("Y-m-01",strtotime($tDt2)-3*30*24*60*60);
			} else if($timer==7){
				$tDt1 = date("Y-m-01",strtotime($tDt1));
				$tDt2 = date("Y-m-d",strtotime($tDt1)-24*60*60);
				$tDt1 = date("Y-m-01",strtotime($tDt2)-6*30*24*60*60);
			} else if($timer==8){
				$tDt1 = date("Y-m-01",strtotime($tDt1));
				$tDt2 = date("Y-m-d",strtotime($tDt1)-24*60*60);
				$tDt1 = date("Y-m-01",strtotime($tDt2)-12*30*24*60*60);
			}
		}
		//Quality Points
		if($box==1)	{
			//Chart Users
			$pUsers = array();
			$Search = array(",",'"');
			$Replace = array("","");
			//All Prospect Users			
			$shuids = implode(",",$parent_ids);
			$dwhere = "u.user_id in ($shuids)";
			if($timer) $dwhere .= " and (pdate BETWEEN '$tDt1' AND '$tDt2')";
			$datebase_prospect_users = $this->crm->prospect_users($dwhere,'ppt');			
			foreach($datebase_prospect_users as $prosp) {
				$pname = str_replace($Search,$Replace,$prosp->usrname);
				$pUsers[$prosp->user_id]=ucfirst($pname);		
			}

			$rFormat = array('',0);
			$chartData1=array();//Quality Points

			if($timer) $dwhere = " (pdate BETWEEN '$tDt1' AND '$tDt2')"; else $dwhere = "1=1";
			$tDt1 = strtotime($tDt1);
			$tDt2 = strtotime($tDt2);
			//if($pUsers && $oDays && $oUsr) 
			$dates = array();
			$di=-1;
			$cInd=-1;	
			$limit=0;
			$offset = 0;
			if($pUsers && $timer) 
			{
				$UserIds=array_keys($pUsers);
				//['Day 1', 0, 0]
				//$chartData[] = array('Day', $y1, $y2);
				
							
				
				while(1) {
					$offset = $limit;
					$limit += 500;	
					//$user_points = $this->crm->prospect_user_points($UserIds,$dwhere,$limit,'C',$offset);
					$user_points = $this->crm->prospect_user_points($UserIds,$dwhere);

					//echo $this->db->last_query().'--';
					//echo "<pre>";print_r($user_points);echo "<pre>";//exit;
					if(!$user_points) break;		
					foreach($user_points as $uPoints) {
						while($tDt1<strtotime($uPoints->pdate)){
							$ctemp = $rFormat;
							$ctemp[0]= date($dtF,$tDt1);
							$di++;
							$ckey=$di;
							$chartData1[$ckey]= $ctemp;					
							$tDt1 = $tDt1+24*60*60;
						}
						$tDt1=strtotime($uPoints->pdate);
						$cDt = date($dtF,strtotime($uPoints->pdate));				
						if(array_search($cDt,$dates)===FALSE) {
							$di++;
							$ckey=$di;
							$dates[$di]=$cDt;
							$ctemp = $rFormat;
							$ctemp[0]= $cDt;
						} else {
							$ckey=array_search($cDt,$dates);
							$ctemp = $chartData1[$ckey];
						}
						//if($oUsr) $cInd=array_search($uPoints->userid,$UserIds)+1;
						$cInd=1;
						$ctemp[$cInd] += $uPoints->intpoints;
						$chartData1[$ckey]= $ctemp;
						$tDt1 = $tDt1+24*60*60;
					}//echo "SD"; if($limit>=40000) exit;
					break;//sleep(1);
				}			
			}
			//if($oDays && $oUsr) 
			if($timer) 
			{
				while($tDt1<=$tDt2){
					$ctemp = $rFormat;
					$ctemp[0]= date($dtF,$tDt1);
					$di++;
					$ckey=$di;
					$chartData1[$ckey]= $ctemp;			
					$tDt1 = $tDt1+24*60*60;
				}
			}
			//echo "<pre>";
			//print_r($rFormat);print_r($user_points);
			//print_r($chartData1);print_r($chartData2);echo "</pre>";
			//exit;
			$chartData1 = array_values($chartData1);

			$json = array('content'=>$chartData1);
			echo json_encode($json);return;
		}
		//Pursuit Points
		else if($box==2)	{
			//Chart Users
			$pUsers = array();
			$Search = array(",",'"');
			$Replace = array("","");
			//All Prospect Users			
			$shuids = implode(",",$parent_ids);
			$dwhere = "u.user_id in ($shuids)";
			if($timer) $dwhere .= " and (pdate BETWEEN '$tDt1' AND '$tDt2')";
			$datebase_prospect_users = $this->crm->prospect_users($dwhere,'ppt');			
			foreach($datebase_prospect_users as $prosp) {
				$pname = str_replace($Search,$Replace,$prosp->usrname);
				$pUsers[$prosp->user_id]=ucfirst($pname);		
			}

			$rFormat = array('',0);
			$chartData2=array();

			if($timer) $dwhere = " (pdate BETWEEN '$tDt1' AND '$tDt2')"; else $dwhere = "1=1";
			$tDt1 = strtotime($tDt1);
			$tDt2 = strtotime($tDt2);

			$dates = array();
			$di=-1;
			$cInd=-1;	
			$limit=0;
			$offset = 0;
			//if($pUsers && $oDays && $oUsr) 
			if($pUsers && $timer) 
			{
				$UserIds=array_keys($pUsers);
				//['Day 1', 0, 0]
				//$chartData[] = array('Day', $y1, $y2);
						
				
				while(1) {
					$offset = $limit;
					$limit += 500;	
					//$user_points = $this->crm->prospect_user_points($UserIds,$dwhere,$limit,'C',$offset);
					$user_points = $this->crm->prospect_user_points($UserIds,$dwhere);

					//echo $this->db->last_query().'--';
					//echo "<pre>";print_r($user_points);echo "<pre>";//exit;
					if(!$user_points) break;		
					foreach($user_points as $uPoints) {
						while($tDt1<strtotime($uPoints->pdate)){
							$ctemp = $rFormat;
							$ctemp[0]= date($dtF,$tDt1);
							$di++;
							$ckey=$di;
							$chartData2[$ckey]= $ctemp;					
							$tDt1 = $tDt1+24*60*60;
						}
						$tDt1=strtotime($uPoints->pdate);
						$cDt = date($dtF,strtotime($uPoints->pdate));				
						if(array_search($cDt,$dates)===FALSE) {
							$di++;
							$ckey=$di;
							$dates[$di]=$cDt;
							$ctemp2 = $rFormat;
							$ctemp2[0]= $cDt;
						} else {
							$ckey=array_search($cDt,$dates);
							$ctemp2 = $chartData2[$ckey];
						}
						//if($oUsr) $cInd=array_search($uPoints->userid,$UserIds)+1;
						$cInd=1;
						$ctemp2[$cInd] += $uPoints->purpoints;
						$chartData2[$ckey]= $ctemp2;
						$tDt1 = $tDt1+24*60*60;
					}//echo "SD"; if($limit>=40000) exit;
					break;//sleep(1);
				}			
			}
			//if($oDays && $oUsr) 
			if($timer) 
			{
				while($tDt1<=$tDt2){
					$ctemp = $rFormat;
					$ctemp[0]= date($dtF,$tDt1);
					$di++;
					$ckey=$di;
					$chartData2[$ckey]= $ctemp;					
					$tDt1 = $tDt1+24*60*60;
				}
			}
			//echo "<pre>";
			//print_r($rFormat);print_r($user_points);
			//print_r($chartData1);print_r($chartData2);echo "</pre>";
			//exit;
			$chartData2 = array_values($chartData2);

			$json = array('content'=>$chartData2);
			echo json_encode($json);return;
		}
		//Objections Received
		else if($box==3)	{
			//Objections Piechart			
			$odwhere = "obc.objid>0";	
			if($timer) $odwhere .= " and (obc.objdate BETWEEN '$tDt1' AND '$tDt2') ";		
			$Objections = $this->crm->get_objections_byfilters($parent_ids,$odwhere);
			$chartData=array();
			$chartData[] = array('Objection', 'Usage');
			if($Objections) {
				foreach($Objections as $obj) $chartData[] = array($obj->obj_val, round($obj->obj_count));
			}	
			$json = array('content'=>$chartData);
			echo json_encode($json);return;
		}
		//Tasks
		else if($box==5)	{
			$dwhere1 = "t.share_user_id in ($str_parentids)";
			$this->_data['tasks_list'] = $this->crm->get_all_tasks(0,'',5,2,$dwhere1);
			$html = $this->load->view('crm/dashboard-blocks.php', $this->_data, TRUE);
			$json = array('content'=>$html);
			echo json_encode($json);return;
		}
		//Opportunities
		else if($box==6)	{
			$dwhere1 = "o.share_user_id in ($str_parentids)";
			$this->_data['opportunity_list'] = $this->crm->get_all_opportunitys(0,5,$dwhere1);
			$html = $this->load->view('crm/dashboard-blocks.php', $this->_data, TRUE);
			$json = array('content'=>$html);
			echo json_encode($json);return;
		}
		//Target Contacts
		else if($box==7)	{//print_r($parent_ids);
			$this->_data['contact_list'] = $this->crm->get_all_contacts(0,1,$parent_ids,5);
			$html = $this->load->view('crm/dashboard-blocks.php', $this->_data, TRUE);
			$json = array('content'=>$html);
			echo json_encode($json);return;
		}
		//Target Accounts
		else if($box==8)	{
			$this->_data['account_list'] = $this->crm->get_all_accounts(0,1,$parent_ids,5);
			$html = $this->load->view('crm/dashboard-blocks.php', $this->_data, TRUE);
			$json = array('content'=>$html);
			echo json_encode($json);return;
		}
	}

}

/* End of file crmbeta.php */

/* Location: ./application/controllers/crmbeta.php */	