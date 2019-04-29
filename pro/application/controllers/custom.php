<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//error_reporting(E_ALL);
class custom extends CI_Controller {
	/**
	 * Properties
	 */
	private $_data;
	private $_user_id;

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

        $this->load->model('campaign_model', 'campaign');

        $this->load->model('product_model', 'productModel');

		

		if(!$this->config->item('is_local'))

		{

			include(CDOC_ROOT."members/library/Am/Lite.php"); 

                      

            //Am_Lite::getInstance()->checkAccess(array(2,6,5), 'Restricted access');

			//Am_Lite::getInstance()->checkAccess(array(2,6,5,9,10), 'Restricted access'); //  This array is Updated by Aavid developer on 17-April-2014
			//Am_Lite::getInstance()->checkAccess(array(2,6,5,9,10,14,15), 'Restricted access'); //  This array is Updated by Aavid developer on 17-April-2014
			Am_Lite::getInstance()->checkAccess(array(2,6,5,9,10,14,15,18,28,32), 'Restricted access'); //  By Dev@4489 24-Oct-2015

			// 9  is for Scripter Pro 3 Month

			// 10 is for Scripter Pro 1 Year
			// 18 is for Pro Lite 1 Year

			

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



            //$haveSubscriptions = Am_Lite::getInstance()->haveSubscriptions(array('6','2'));

			//$haveSubscriptions = Am_Lite::getInstance()->haveSubscriptions(array('6','2','9','10'));//  This array is Updated by Aavid developer on 17-April-2014
			$haveSubscriptions = Am_Lite::getInstance()->haveSubscriptions(array('6','2','9','10','14','15','18','28','5','3','32'));//  By Dev@4489 24-Oct-2015

			// 9  is for Scripter Pro 3 Month

			// 10 is for Scripter Pro 1 Year



			// Check User Subscription PAID OR FREE

			$this->_data['is_paid'] = !empty($haveSubscriptions) ? TRUE : FALSE;
			//aMember Profile
			$this->_data['aMember'] = array('yname'=>'','yemail'=>'','yphone'=>'');
			$amember_data = Am_Lite::getInstance()->getUser();
			if($amember_data) {
				$this->_data['aMember'] = array('yname'=>ucfirst($amember_data['name_f'].' '.$amember_data['name_l']),'yemail'=>$amember_data['email'],'yphone'=>$amember_data['phone']);
			}

			

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

	   

	   $this->_user_id = $this->_data['user_id'];

       $_SESSION['ss_user_id'] = $this->_user_id;



       if(isset($just_registered))

       {

       		// Add pre-filled session

	   		$redirect = base_url().'folder/my-folder';

	   		// $redirect = base_url().'memeber/member';	

	   		// $this->newSession($redirect, 1, "My first product profile");

			$this->defaultNewproduct($redirect, 1, "My first product profile");

			

       }

	   

		// Check if Product is Add or Not

		$is_product = $this->home->check_product($this->_user_id);

		if(empty($is_product))

		{

			// Add Product into Database

			$status = '2';

			$redirect = base_url().'folder/my-folder';

			$this->defaultNewproduct($redirect, 1, "My first product profile");	

		}

		

		if($session_id = $this->home->get_session_status($this->session->userdata('ss_session_id')))

        {

        	$this->_data['session_status'] = TRUE;

        }

        else 

        {

        	$this->_data['session_status'] = FALSE;

        }



        

		$active_session_id = NULL;

        // Get Active SESSION ID

        if(isset($user_session_id) AND (!$this->session->userdata('ss_session_id')))


        {

        	$this->_data['active_session_id'] = $user_session_id;

        }

        else 

        {

        	$this->_data['active_session_id'] = $this->session->userdata('ss_session_id');

        }

		

        $this->_data['all_sessions'] = $this->home->get_all_sessions();

        $this->_data['total_sessions'] = count($this->_data['all_sessions']);



		/**  now find all active campaign data name drop , company name etc */

		$active_campaign_data =  $this->campaign->get_campaign_active($this->_user_id);

		if($active_campaign_data == false)

		{

			$this->session->set_flashdata('session_msg','Please Create campaign ,company profile and name drop');

			redirect(base_url()."folder/my-folder");

		}

		

		/** campaign info data */

		$this->_data['campaign_info'] = $active_campaign_data;
		//By Dev@4489
		//Qualify questions with responses
		$this->_data['campaign_output_qualify'] = $this->qualify_list_show($active_campaign_data->campaign_id);
		//Get Campaign Value page all anwsers
		$this->_data['campaign_output_tech_val_asnwers'] = $this->campaign->getTechValueAnswersAll($active_campaign_data->campaign_id);
		////

		$this->_data['campaign_output_tech_val'] = $this->campaign->getOutputTechValue($active_campaign_data->campaign_id,1);

		$this->_data['campaign_output_biz_val'] = $this->campaign->getOutputBizValue($active_campaign_data->campaign_id);

		$this->_data['campaign_output_per_val'] = $this->campaign->getOutputPerValue($active_campaign_data->campaign_id);

		$this->_data['campaign_output_tech_pain'] = $this->campaign->getOutputTechPain($active_campaign_data->campaign_id,1);

		$this->_data['campaign_output_biz_pain'] = $this->campaign->getOutputBizPain($active_campaign_data->campaign_id);

		$this->_data['campaign_output_per_pain'] = $this->campaign->getOutputPerPain($active_campaign_data->campaign_id);

		$this->_data['campaign_output_tech_qualify'] = $this->campaign->getOutputTechQualify($active_campaign_data->campaign_id,1);

		$this->_data['campaign_output_biz_qualify'] = $this->campaign->getOutputBizQualify($active_campaign_data->campaign_id);

		$this->_data['campaign_output_per_qualify'] = $this->campaign->getOutputPerQualify($active_campaign_data->campaign_id);

		

		$this->_data['campaign_tech_summary'] = $this->campaign->getCampaignMetadata($active_campaign_data->campaign_id,'tech_val_summary');

		$this->_data['campaign_biz_summary'] = $this->campaign->getCampaignMetadata($active_campaign_data->campaign_id,'bus_val_summary');

		$this->_data['campaign_per_summary'] = $this->campaign->getCampaignMetadata($active_campaign_data->campaign_id,'per_val_summary');

		$this->_data['sale_process_close1'] = $this->campaign->getCampaignMetadata($active_campaign_data->campaign_id,'sale_process_close1');

		$this->_data['sale_process_close2'] = $this->campaign->getCampaignMetadata($active_campaign_data->campaign_id,'sale_process_close2');

		$this->_data['sale_process_close3'] = $this->campaign->getCampaignMetadata($active_campaign_data->campaign_id,'sale_process_close3');

		

		// var_dump($this->_data['campaign_biz_summary']) ; die();

		/** product related query **/

		$this->_data['P_Q1'] = $this->productModel->getProMetaData($active_campaign_data->product_id,'P_Q1');

		$this->_data['product_desc'] = $this->productModel->getProMetaData($active_campaign_data->product_id,'P_Desc');

		$this->_data['diff1'] = $this->productModel->getProMetaData($active_campaign_data->product_id,'interestB1');

		$this->_data['diff2'] = $this->productModel->getProMetaData($active_campaign_data->product_id,'interestB2');

		$this->_data['diff3'] = $this->productModel->getProMetaData($active_campaign_data->product_id,'interestB3');

		

		$this->_data['negative_impact1'] = $this->productModel->getProMetaData($active_campaign_data->product_id,'negative_impact1');

		$this->_data['negative_impact2'] = $this->productModel->getProMetaData($active_campaign_data->product_id,'negative_impact2');

		$this->_data['negative_impact3'] = $this->productModel->getProMetaData($active_campaign_data->product_id,'negative_impact3');

		

		/**  get active session name data */

		$this->_data['active_name_drop_exp'] = $this->campaign->findActiveNameDropForOutput();

		

		/* var_dump($this->_data['active_name_drop_exp']);

		 */  

		/**  find data about company profile **/

		$company_info_detail = $this->productModel->getCompanyInfo($this->_user_id);

		$this->_data['company_info'] = $company_info_detail;

		$this->_data['company_meta'] = $this->productModel->getAllMetaValue($company_info_detail->company_id);	

	}


	public function getCustomContent($content_id)
	{
		$this->_data['content_id'] = $content_id;
		return $this->load->view('outputs/custom_content/custom_content_data', $this->_data);
	}
	//By Dev@4489
	//get template section content
	public function getetemplate($content_id)
	{
		$car = explode("-",$content_id);
		$this->_data['content_id'] = $car[1];
		return $this->load->view('outputs/custom_content/custom_etemplate_data', $this->_data);
	}
	//Qualify questions with responses
	public function qualify_resplist_show($qid,$campgid,$qp=0,$level=1) {
		$questp_responses = $this->campaign->getQualifyQuestRespRow($qid,$campgid,$qp,1,1);
		if($questp_responses) {
			foreach ($questp_responses as $qpresp){
				$quest_responses = $this->campaign->getQualifyQuestResps($qid,$campgid,$qpresp->qr_id,1,1);
				echo '<ul>';
				if($quest_responses) {
					foreach ($quest_responses as $qresp){?>
					<li><span class="red-area">If [<?php echo ucfirst($qpresp->qr_response); ?>]:</span> <?php echo ucfirst($qresp->qr_response); ?>
						<?php $this->qualify_resplist_show($qid,$campgid,$qresp->qr_id,$level+1);?>
					</li>
					<?php }
				} else {
					?>
					<li><span class="red-area">If [<?php echo ucfirst($qpresp->qr_response); ?>]</span></li>
					<?php
				}
				echo '</ul>';
			}
		}
	}
	//Qualify questions with responses
	public function qualify_list_show($campgid) {
		$campaign_output_tech_qualify = $this->campaign->getQualifyQuest($campgid,1);
		ob_start();
		if (isset($campaign_output_tech_qualify) && $campaign_output_tech_qualify){
			?>
			<ul>
				<?php foreach ($campaign_output_tech_qualify as $single_tech_qualify):?>
					<?php // print_r($single_tech_value) ?>
					<li><span class="<?php echo 'dynamic_value edit_area'; ?>" id="tqd_<?php echo $single_tech_qualify->tech_q_id ?>_<?php echo $single_tech_qualify->campaign_id; ?>"><?php echo ucfirst($single_tech_qualify->value);?></span>
					<?php $this->qualify_resplist_show($single_tech_qualify->tech_q_id,$campgid,0,1);?>
					</li>
				<?php endforeach;?>
			</ul>
			<?php				
		}
		$Question_responses=ob_get_contents();
		ob_end_clean();
		return $Question_responses;
		
	}
	////
}