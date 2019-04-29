<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home_model extends CI_Model 
{
	/**
	 * Properties
	 */
	private $_table_users;
	private $_table_values;
	private $_table_plains;
	private $_table_close;
	private $_table_building_credibilities;
	private $_table_building_interests;
	private $_table_ideal_prospects;
	private $_table_objections;
	private $_table_qualifying;
	private $_table_products;
	private $_table_product_data;
	private $_table_credibility;
	private $_table_credibility_data;
	private $_table_objection;
	private $_table_objection_data;
	private $_table_user_data;
	private $_table_session;
	private $_table_team_sessions;
	private $_table_credibility_main;	
	private $_table_user_info;

	/**
	 * Constructor
	 */

    function __construct()
    {
        parent::__construct();

        //Define Table names

        $this->_table_users		 				= $this->config->item('table_users');
        $this->_table_values 	 				= $this->config->item('table_values');
        $this->_table_plains 	 				= $this->config->item('table_plains');
        $this->_table_close 	 				= $this->config->item('table_close');
        $this->_table_objections 				= $this->config->item('table_objections');
        $this->_table_qualifying 				= $this->config->item('table_qualifying');
        $this->_table_product_data 				= $this->config->item('table_product_data');
        $this->_table_building_credibilities 	= $this->config->item('table_building_credibilities');
        $this->_table_building_interests 		= $this->config->item('table_building_interests');
        $this->_table_ideal_prospects 			= $this->config->item('table_ideal_prospects');
        $this->_table_products 					= $this->config->item('table_products');
        $this->_table_product_data 				= $this->config->item('table_product_data');
        $this->_table_credibility 				= $this->config->item('table_credibility');
        $this->_table_credibility_data 			= $this->config->item('table_credibility_data');
        $this->_table_objection 				= $this->config->item('table_objection');
        $this->_table_objection_data 			= $this->config->item('table_objection_data');
        $this->_table_user_data 				= $this->config->item('table_user_data');
        $this->_table_session 	 				= $this->config->item('table_session');
        $this->_table_team_sessions 			= $this->config->item('table_team_sessions');
		$this->_table_credibility_main 			= $this->config->item('table_credibility_main');
		$this->_table_campaign 					= $this->config->item('table_campaigns');
		$this->_table_tech_value 				= $this->config->item('table_tech_value');
		$this->_table_biz_value 				= $this->config->item('table_biz_value');
		$this->_table_per_value 				= $this->config->item('table_per_value');
		$this->_table_campaign_comm 			= $this->config->item('table_campaign_comm');
		$this->_table_tech_qualify 				= $this->config->item('table_tech_qualify');
		$this->_table_tech_pain 				= $this->config->item('table_tech_pain');
		$this->_table_biz_qualify 				= $this->config->item('table_biz_qualify');
		$this->_table_biz_pain 					= $this->config->item('table_biz_pain');
		$this->_table_per_qualify 				= $this->config->item('table_per_qualify');
		$this->_table_per_pain 					= $this->config->item('table_per_pain');
		$this->_table_user_info 				= $this->config->item('table_user_info');
        $this->load->library('session');
    }
    
	//-----------------------------------------------------------------------

    public function get_all_users_sessions() 
    {
    	$query = $this->db->get($this->_table_session);
    	if ($query->num_rows() > 0)
    	{
    		return $query->result();
    	}
    }

	//-----------------------------------------------------------------------

    public function get_single_user_info($user_id) 
    {
    	$this->db->select('*');
    	$this->db->where('user_id', $user_id);
    	$query = $this->db->get($this->_table_users);
    	if ($query->num_rows() > 0)
    	{
    		return $query->row();
    	}
    }
	public function update_email_count($user_id,$ecount) 
    {
		$updateData = array(
			'user_id' => $user_id,
			'email_count' => $ecount
		);
    	$this->db->where('user_id', $user_id);
		$this->db->update($this->_table_users,$updateData);
		return true;
		//echo $this->db->last_query();
    }
	//-----------------------------------------------------------------------
    public function get_all_users_products() 
    {
		$this->db->where('trash',0);
    	$query = $this->db->get($this->_table_products);
    	if ($query->num_rows() > 0)
    	{
    		return $query->result();
    	}
    }

	//-----------------------------------------------------------------------
    public function get_all_users_credibilities() 
    {
		$this->db->where('trash',0);
    	$query = $this->db->get($this->_table_credibility);
    	if ($query->num_rows() > 0)
    	{
    		return $query->result();
    	}
    }
	
	//-----------------------------------------------------------------------
    public function get_all_users_objections() 
    {
    	$query = $this->db->get($this->_table_objection);
    	if ($query->num_rows() > 0)
    	{
    		return $query->result();
    	}
    }
	//-------------------------------------------------------------------------    
    function delete_session_products($session_id) 
    {
    	$this->db->where('session_id', $session_id);
		$this->db->delete($this->_table_products);
		return TRUE;
    }

	//-------------------------------------------------------------------------    
	//-------------------------------------------------------------------------    
    function delete_session_credibilities($session_id) 
    {
    	$this->db->where('session_id', $session_id);

		$this->db->delete($this->_table_credibility);

		return TRUE;
    }

//-------------------------------------------------------------------------    

    function delete_session_objections($session_id) 
    {
    	$this->db->where('session_id', $session_id);

		$this->db->delete($this->_table_objection);

		return TRUE;
    }

//-------------------------------------------------------------------------    

    function delete_session_users_data($session_id) 
    {
    	$this->db->where('session_id', $session_id);

		$this->db->delete($this->_table_user_data);

		return TRUE;
    }   

//-----------------------------------------------------------------------

    public function get_all_users_data() 
    {
    	$query = $this->db->get($this->_table_user_data);

    	if ($query->num_rows() > 0)
    	{
    		return $query->result();
    	}
    }

//-----------------------------------------------------------------------

    /**
     * Update User Information
     * @param $data array
     */

    public function get_all_users() 
    {
    	$query = $this->db->get($this->_table_users);

    	if ($query->num_rows() > 0)
    	{
    		return $query->result();
    	}
    }

//-----------------------------------------------------------------------

    /**
     * Get Draft Sessions where Status == 2
     * @param $user_id integer
     */

    public function get_draft_sessions($user_id) 
    {
    	$this->db->where('status', '2');

    	$query = $this->db->get($this->_table_session);

    	if ($query->num_rows() > 0)
    	{
    		return $query->result();
    	}
    }   

//-----------------------------------------------------------------------

    /**
     * Update User Information
     * @param $data array
     */

    public function get_all_sessions_ids($userid) 
    {
    	$this->db->where('user_id', $userid);

    	$query = $this->db->get($this->_table_session);

    	if ($query->num_rows() > 0)
    	{
    		return $query->result();
    	}
    }

//-----------------------------------------------------------------------

    /**
     * Update User Information
     * @param $data array
     */

    public function addSession($data) 
    {
    	$this->db->insert($this->_table_session, $data);

    	return $this->db->insert_id();;
    }

//-----------------------------------------------------------------------

    /**
     * Insert User Information
     * @param $data array
     * @return Last inserted ID
     */

    public function update_session_ids($session_id, $user_id) 
    {
    	$data = array('session_id' => $session_id);
    	$this->db->where('user_id',$user_id);
    	$this->db->update($this->_table_products, $data);
    	$this->db->where('user_id',$user_id);
    	$this->db->update($this->_table_credibility, $data);
    	$this->db->where('user_id',$user_id);
    	$this->db->update($this->_table_objection, $data);
    	$this->db->where('user_id',$user_id);
    	$this->db->update($this->_table_user_data, $data);

		return TRUE;
    }

//-----------------------------------------------------------------------

    /**
     * Insert User Information
     * @param $data array
     * @return Last inserted ID
     */

    public function registration($data) 
    {
    	$this->db->insert($this->_table_users, $data);

    	return $this->db->insert_id();
    }

//-----------------------------------------------------------------------

    /**
     * Insert User Information
     * @param $data array
     * @return Last inserted ID
     */

    public function update_session($data) 
    {
    	$this->db->where('session_id', $this->session->userdata('ss_session_id'));

    	$this->db->update($this->_table_session, $data);

		return TRUE;
    }

//-----------------------------------------------------------------------

    /**
     * Get Session ID is Available OR Not
     */

    public function getSessionId($user_id) 
    {
    	$this->db->where('user_id', $user_id);

    	$query = $this->db->get($this->_table_session);

    	if ($query->num_rows() > 0)
    	{
    		return $query->row()->session_id;
    	}
    }    

//-----------------------------------------------------------------------

    /**
     * Update User Information
     * @param $data array
     */

    public function update_registration($data, $user_id) 
    {
		unset($data['submit']);

		unset($data['id']);

    	$this->db->where('user_id', $user_id);

    	$query = $this->db->update($this->_table_users, $data);

    	return TRUE;
    }

//-----------------------------------------------------------------------

    /**
     * Update User Information
     * @param $data array
     */

    public function update_user_info($username,$data) 
    {
    	$this->db->where('username', $username);

    	$query = $this->db->update($this->_table_users, $data);

    	return TRUE;
    }

//-----------------------------------------------------------------------

    /**
     * Update Description
     * @param $data array
     * @param $table_name string
     */

    public function update_description($table_name, $data, $id) 
    {
    	//Get table name
    	$table_name = $this->_get_table_name($table_name);

    	if($table_name == 'product_data')
    	{
    		$this->db->where('product_data_id', $id);
    	}

    	if($table_name == 'user_data')
    	{
    		$this->db->where('user_data_id', $id);
    	}

        if($table_name == 'credibility_data')
    	{
    		$this->db->where('c_data_id', $id);
    	}

        if($table_name == 'objection_data')
    	{
    		$this->db->where('obj_data_id', $id);
    	}

    	$query = $this->db->update($table_name, $data);

    	return TRUE;
    }   

//-----------------------------------------------------------------------

    /**
     * Update Description
     * @param $data array
     * @param $table_name string
     */

    public function update_description_users($table_name, $data) 
    {
    	$user_id = $_SESSION['ss_user_id'];

    	$this->db->where('user_id', $user_id);

    	$query = $this->db->update($table_name, $data);

    	return TRUE;
    }

//-----------------------------------------------------------------------

    /**
     * Update Session Name
     * @param $data array
     * @param $session_id integer
     */ 

    public function update_session_name($session_id, $data) 
    {
    	$this->db->where('session_id', $session_id);

    	$query = $this->db->update($this->_table_session, $data);

    	return TRUE;
    }

//-----------------------------------------------------------------------

    /**
     * Update User Information
     * @param $data array
     */

    public function get_general_data($user_id) 
    {
        $this->db->where('user_id', $user_id);

    	$query = $this->db->get($this->_table_users);

    	if ($query->num_rows() > 0)
    	{
    		return $query->row();
    	}
    }

    /**
     * Check Product is Available OR Not
     */
    public function check_product($user_id) 
    {
		$this->db->where('trash',0);
    	$this->db->where('user_id', $user_id);
    	$query = $this->db->get($this->_table_products);
    	if ($query->num_rows() > 0)
    	{
    		return $query->row()->product_id;
    	}
    } 
	
    /**
     * Check Credibility is Available OR Not
     */

    public function check_credibility($user_id, $session_id=NULL) 
    {
    	$this->db->where('user_id', $user_id);
    	$this->db->where('status', 1);
		$this->db->where('trash',0);
    	$query = $this->db->get($this->_table_credibility);
    	if ($query->num_rows() > 0)
    	{
    		return $query->row()->c_id;
    	}
    } 
	
    /**
     * Check Objection is Available OR Not
     */

    public function check_objection() 
    {
    	$user_id = $_SESSION['ss_user_id'];
    	$this->db->where('user_id', $user_id);
    	$query = $this->db->get($this->_table_objection);
    	if ($query->num_rows() > 0)
    	{
    		return $query->row()->obj_id;
    	}
    } 

    /**
     * Check Table
     * @param $user_id Integer
     */
    public function check_table($user_id)
    {
    	$status0 = 'Deactive';
    	$status1 = 'Deactive';
    	$status2 = 'Deactive';
    	$status3 = 'Deactive';
    	$status4 = 'Deactive';
    	$status5 = 'Deactive';
    	$status6 = 'Deactive';
    	$status7 = 'Deactive';
    	$status8 = 'Deactive';
       	$this->db->where('user_id', $user_id);
       	$this->db->where('is_filled', TRUE);
    	$step1 = $this->db->get($this->_table_values);
    	$this->db->where('user_id', $user_id);

    	$this->db->where('is_filled', TRUE);

    	$step2 = $this->db->get($this->_table_plains);
    	

    	$this->db->where('user_id', $user_id);

    	$this->db->where('is_filled', TRUE);

    	$step3 = $this->db->get($this->_table_ideal_prospects);
    	

    	$this->db->where('user_id', $user_id);

    	$this->db->where('is_filled', TRUE);

    	$step4 = $this->db->get($this->_table_qualifying);
    	

    	$this->db->where('user_id', $user_id);

    	$this->db->where('is_filled', TRUE);

    	$step5 = $this->db->get($this->_table_building_credibilities);
    	

    	$this->db->where('user_id', $user_id);

    	$this->db->where('is_filled', TRUE);

    	$step6 = $this->db->get($this->_table_building_interests);

    	

    	$this->db->where('user_id', $user_id);

    	$this->db->where('is_filled', TRUE);

    	$step7 = $this->db->get($this->_table_close);
    	

    	$this->db->where('user_id', $user_id);

    	$this->db->where('is_filled', TRUE);

    	$step8 = $this->db->get($this->_table_objections);
    	

    	if ($step1->num_rows() > 0){$status0 = 'Active';}

        if ($step1->num_rows() > 0){$status1 = 'Active';}

    	if ($step2->num_rows() > 0){$status2 = 'Active';}

        if ($step3->num_rows() > 0){$status3 = 'Active';}

        if ($step4->num_rows() > 0){$status4 = 'Active';}

        if ($step5->num_rows() > 0){$status5 = 'Active';}

        if ($step6->num_rows() > 0){$status6 = 'Active';}

        if ($step7->num_rows() > 0){$status7 = 'Active';}

        if ($step8->num_rows() > 0){$status8 = 'Active';}


    	return $data = array(

    		'step0' => $status0,

	    	'step1' => $status1, 

	    	'step2' => $status2,

	    	'step3' => $status3, 

	    	'step4' => $status4,

	    	'step5' => $status5, 

	    	'step6' => $status6,

	    	'step7' => $status7, 

	    	'step8' => $status8

	    	);
    }

    /**
     * Check Table
     * @param $user_id Integer
     */

    public function get_step($user_id)
    {
    	$status1 = '';

    	$status2 = '';

    	$status3 = '';

    	$status4 = '';

    	$status5 = '';

    	$status6 = '';

    	$status7 = '';

    	$status8 = '';
    	

       	$this->db->where('user_id', $user_id);

       	$this->db->where('is_filled', TRUE);

    	$step1 = $this->db->get($this->_table_values);


    	$this->db->where('user_id', $user_id);

    	$this->db->where('is_filled', TRUE);

    	$step2 = $this->db->get($this->_table_plains);


    	$this->db->where('user_id', $user_id);

    	$this->db->where('is_filled', TRUE);

    	$step3 = $this->db->get($this->_table_ideal_prospects);
    	

    	$this->db->where('user_id', $user_id);

    	$this->db->where('is_filled', TRUE);

    	$step4 = $this->db->get($this->_table_qualifying);
    	

    	$this->db->where('user_id', $user_id);

    	$this->db->where('is_filled', TRUE);

    	$step5 = $this->db->get($this->_table_building_credibilities);
    	

    	$this->db->where('user_id', $user_id);

    	$this->db->where('is_filled', TRUE);

    	$step6 = $this->db->get($this->_table_building_interests);
    	

    	$this->db->where('user_id', $user_id);

    	$this->db->where('is_filled', TRUE);

    	$step7 = $this->db->get($this->_table_close);


    	$this->db->where('user_id', $user_id);

    	$this->db->where('is_filled', TRUE);

    	$step8 = $this->db->get($this->_table_objections);


        if ($step1->num_rows() > 0){$status1 = '1';}

    	if ($step2->num_rows() > 0){$status2 = '1';}

        if ($step3->num_rows() > 0){$status3 = '1';}

        if ($step4->num_rows() > 0){$status4 = '1';}

        if ($step5->num_rows() > 0){$status5 = '1';}

        if ($step6->num_rows() > 0){$status6 = '1';}

        if ($step7->num_rows() > 0){$status7 = '1';}

        if ($step8->num_rows() > 0){$status8 = '1';}


    	return $data = array(

	    	'step1' => $status1, 

	    	'step2' => $status2,

	    	'step3' => $status3, 

	    	'step4' => $status4,

	    	'step5' => $status5, 

	    	'step6' => $status6,

	    	'step7' => $status7, 

	    	'step8' => $status8

	    	);
    }

//------------------------------------------------------------------------   

    /**
     * Get user by username
     * @param $username string
     * @return integer
     */

    public function get_user_by_username($username) 
    {
    	$this->db->where('username', $username);

    	$query = $this->db->get($this->_table_users);

    	if ($query->num_rows() > 0)
    	{
    		return $query->row()->user_id;
    	}
    }

    /**
     * Get All Sessions
     * @param $data array
     * @param $table_name string
     */

    public function get_all_sessions() 
    {
    	$this->db->where('user_id', $_SESSION['ss_user_id']);
    	$query = $this->db->get($this->_table_session);

    	if ($query->num_rows() > 0)
    	{
    		return $query->result();
    	}
    }

    /**
     * Update Sessions
     * @param $session_id integer
     */

    public function update_all_sessions($session_id, $status) 
    {
    	$this->db->where('session_id',$session_id);
    	$data = array('status' => $status);
    	$query = $this->db->update($this->_table_session, $data);
    	return TRUE;
    }

    /**
     * Get session ID  by user_id
     * @param $user_id integer
     * @return integer
     */

    public function get_user_session_id($user_id) 
    {
    	$this->db->where('user_id', $user_id);
    	$this->db->where('status', '1');
    	$query = $this->db->get($this->_table_session);
    	if ($query->num_rows() > 0)
    	{
    		return $query->row()->session_id;
    	}
    }    
 
    /**
     * Get session ID  by user_id
     * @param $user_id integer
     * @return integer
     */

    public function get_session_status($session_id) 
    {
    	$this->db->where('session_id', $session_id);
    	$this->db->where('status', '2');
    	$query = $this->db->get($this->_table_session);
    	if ($query->num_rows() > 0)
    	{
    		return $query->row()->status;
    	}
    }

    /**
     * Get All data
     * @param $user_id integer
     * @param $table_name
     * @return object
     */

    public function get_data($user_id, $table_name) 
    {
    	$this->db->where('user_id', $user_id);
    	//$this->db->where('session_id',$session_id);
    	$query = $this->db->get($table_name);
    	if ($query->num_rows() > 0)
    	{
    		return $query->row();
    	}
    }

    /**
     * Update Record
     * @param $user_id integer
     * @param $table_name string
     * @return TRUE
     */

    public function update($user_id, $table_name, $session_id) 
    {
    	return $this->_set($table_name, 'update', $session_id);
    }
	
    /**
     * Add New Product 
     * @return Array
     */

    public function addProduct($status, $active_session_id, $session_name = 'default') 
    {
    	if($status == '0')
    	{
    			 $session_data = array('user_id' => $_SESSION['ss_user_id'], 'session_name' => $this->input->post('session_name'), 'status' => $status);

				 $this->db->insert($this->_table_session, $session_data);

				 $session_id =  $this->db->insert_id();
    	}
    	else 
    	{
	    	if($active_session_id)
	    	{
				 $session_id = $active_session_id;
	    	}
	    	elseif($this->session->userdata('ss_session_id'))
	    	{
				 $session_id = $this->session->userdata('ss_session_id');
	    	}
	    	else 
	    	{
	    		/*if($status == '1')
	    		{
	    			$session_name = $session_name ? $session_name : 'default';
	    		}
	    		else 
	    		{
	    			$session_name = $session_name;
	    		}*/
				
				 $progresvalue = array(
							   "start" => true,
							   "product" => false,
							   "value"=> false,
							   "value2" => false,
							   "value3" => false,
							   "pain" => false,
							   "ideal_prospect_environment" => false,
							   "sales_process" => false,
							   "credibility" => false,
							   "qualify" => false,
							   "interest" => false,
							   "objection" => false
							  );
				$progressvaluetosave = json_encode($progresvalue);
				
	    		 $session_data = array('user_id' => $_SESSION['ss_user_id'], 'session_name' => $session_name,'progress_data'=> $progressvaluetosave, 'status' => $status);

				 $this->db->insert($this->_table_session, $session_data);

				 $session_id =  $this->db->insert_id();
	    	}
    	}

    	$products = array();
		$products['user_id'] = $_SESSION['ss_user_id'];
		$products['session_id']= $session_id;
		$this->db->insert($this->_table_products, $products);
		$product_id = $this->db->insert_id();
		
		/** 
		 * WE ARE ADDING  question_id IN TABLE FILED AND GIVE 1, 2,3 STATIC ID FOR IDENTIFY QUESTION 
		 * PLEASE SEE DOC  UPDATE VERSION DOC 
		 */
		
		$value_data = array(
							'product_id' => $product_id, 
							'field_type' => 'tech_value', 
							'value' => '[Technical value 1]',
							'question_id' => 1,
							
							);
        $this->db->insert($this->_table_product_data, $value_data);
		
		$value_data2 = array(
							'product_id' => $product_id, 
							'field_type' => 'tech_value', 
							'value' => '[Technical value 2]',
							'question_id' => 2,
							
							);
        $this->db->insert($this->_table_product_data, $value_data2);
		
		$value_data3 = array(
							'product_id' => $product_id, 
							'field_type' => 'tech_value', 
							'value' => '[Technical value 3]',
							'question_id' => 3,							
							);
							
        $this->db->insert($this->_table_product_data, $value_data3);
		
		/** add business benefits
		 *   need 9 question box in value 10 page the add 9 coumn for value2 (bunisess benefit for product_data_table)
		 */
		
		/* 
		 $bus_value_data = array('product_id' => $product_id, 'field_type' => 'bus_value', 'value' => '[business value 1]');
         $this->db->insert($this->_table_product_data, $bus_value_data); 
		*/
		
		$j = 1;
		for($j;$j<= 9; $j++){
			$bus_value_data = array('product_id' => $product_id, 'field_type' => 'bus_value', 'value' => '[business value'.$j.']','question_id' => $j);
			$this->db->insert($this->_table_product_data, $bus_value_data);
		}
        
		/** add personal benefits answer field baes on business benefit . 
		 *  for each business benefit there are a answer for personal benefit 
		 *  so we need to add this type of question for personal benefit
		 */
		 
		/* $pers_value_data = array('product_id' => $product_id, 'field_type' => 'pers_value', 'value' => '[personal value 1]');
        $this->db->insert($this->_table_product_data, $pers_value_data); */
		
		$e = 1;
		for($e;$e<= 9; $e++){
			$pers_value_data = array('product_id' => $product_id, 'field_type' => 'pers_value', 'value' => '[Personal value'.$e.']','question_id' => $e);
			$this->db->insert($this->_table_product_data, $pers_value_data);
		}
		
		/**
		 *  There are total 3 man techinal pain answer based on techincal benefit so we need to make this 
		 *  entry before
		 */
		 
		$m = 1;
		for($m; $m<= 3; $m++){	
            		
			$pain_data = array('product_id' => $product_id, 'field_type' => 'tech_pain', 'value' => '[technical pain'.$m.']','question_id' => $m);
			$this->db->insert($this->_table_product_data, $pain_data);
		} 
		
		
        $pain_detail_data = array('product_id' => $product_id, 'field_type' => 'desc_tech_pain', 'value' => '[cause of technical pain 1]');
        $this->db->insert($this->_table_product_data, $pain_detail_data);
		
		/**
		 *   Add 3 technical qualify  answer for each Technical pain answer  
		 */
	    $tq = 1;
		for($tq;$tq<= 3; $tq++){
			$qualify_data = array('product_id' => $product_id, 'field_type' => 'tech_qualify', 'value' => '[technical qualifying question'.$tq.']','question_id' => $tq);
			$this->db->insert($this->_table_product_data, $qualify_data);
		}
		
        $qualify_detail_data = array('product_id' => $product_id, 'field_type' => 'desc_tech_qualify', 'value' => '[technical qualifying question 2]');
        $this->db->insert($this->_table_product_data, $qualify_detail_data);
		
		
		/**
		 *  There are total 9 main bussines pain answer based on bussines benefit so we need to make this 
		 *  entry before
		 */
		$k = 1;
		for($k;$k<= 9; $k++){		
			$buss_pain_data = array('product_id' => $product_id, 'field_type' => 'bus_pain', 'value' => '[business pain'.$k.']','question_id' => $k);
			$this->db->insert($this->_table_product_data, $buss_pain_data);
		} 
		
		/**
		 *  There are total 9 main personal pain answer based on personal benefit so we need to make this 
		 *  entry before
		 */
		$n = 1;
		for($n;$n<=9;$n++){	
			$personal_pain_data = array('product_id' => $product_id, 'field_type' => 'pers_pain', 'value' => '[personal pain'.$n.']','question_id' => $n);
			$this->db->insert($this->_table_product_data,$personal_pain_data);
		}
		
		/**
		 *  add 9 new business  qualify answer for each answer in business pain 
		 */
		$bq = 1;
		for($bq;$bq<= 9; $bq++){
			$buss_qualify_data = array('product_id' => $product_id, 'field_type' => 'bus_qualify', 'value' => '[bunisess qualifying question'.$bq.']','question_id' => $bq);
			$this->db->insert($this->_table_product_data, $buss_qualify_data);
		}
				
		/**
		 *   add 9 personal qualify answer for each answer in personal pain
		 */
		$pq = 1;
		for($pq;$pq<= 9; $pq++){
			$pers_qualify_data = array('product_id' => $product_id, 'field_type' => 'pers_qualify', 'value' => '[personal qualifying question'.$pq.']','question_id' => $pq);
			$this->db->insert($this->_table_product_data, $pers_qualify_data);
		}
		
		$product_data_22 = array('product_id' => $product_id, 'field_type' => 'target-audience', 'value' => 'Target Audience');
        $this->db->insert($this->_table_product_data, $product_data_22);
		
		$product_data_33 = array('product_id' => $product_id, 'field_type' => 'direct_campaign', 'value' => 'individual');
        $this->db->insert($this->_table_product_data, $product_data_33);
		
		$product_data_1 = array('product_id' => $product_id, 'field_type' => 'P_Q1', 'value' => '[my product]');
        $this->db->insert($this->_table_product_data, $product_data_1);
        
		$product_data_2 = array('product_id' => $product_id, 'field_type' => 'P_Q3', 'value' => '[product function]');
        $this->db->insert($this->_table_product_data, $product_data_2);
        $data = array('product_id' => $product_id, 'session_id' => $session_id);
		return $data;
    }
	
    /**
     * Update Record
	 *
     */
    public function getProductId() 
    {
    	
		$user_id = $_SESSION['ss_user_id'];
    	$this->db->where('user_id', $user_id);
		$this->db->where('trash',0);
		$query = $this->db->get($this->_table_products);
        if ($query->num_rows() > 0)
    	{
    		return $query->row()->product_id;
    	}
    }

    /**
     * 
     */
    public function check_bus_value($product_id) 
    {
    	$this->db->where('field_type', 'bus_value');
    	$this->db->where('product_id', $product_id);
		$query = $this->db->get($this->_table_product_data);

        if ($query->num_rows() > 0)
    	{
    		return FALSE;
    	}
    	else
    	{
    		return TRUE;
    	}
    }

    /**
     * Count Technical Question
     */

    public function count_tech_qus($product_id) 
    {
    	$this->db->where('field_type', 'tech_value');
    	$this->db->where('product_id', $product_id);
		$query = $this->db->get($this->_table_product_data);
        return $query->num_rows();
    }

    /**
     * Count Technical Question
     */
    public function count_bus_qus($product_id)
    {
    	$this->db->where('field_type', 'bus_value');
    	$this->db->where('product_id', $product_id);
		$query = $this->db->get($this->_table_product_data);
        return $query->num_rows();
    }

    /**
     * Count Technical Question
     */
    public function count_pers_qus($product_id) 
    {
    	$this->db->where('field_type', 'pers_value');
    	$this->db->where('product_id', $product_id);
		$query = $this->db->get($this->_table_product_data);
        return $query->num_rows();
    }

    /**
     * 
     */

	public function check_pers_value($product_id) 
    {
    	$this->db->where('field_type', 'pers_value');
    	$this->db->where('product_id', $product_id);
		$query = $this->db->get($this->_table_product_data);
        if ($query->num_rows() > 0)
    	{
    		return FALSE;
    	}
    	else
    	{
    		return TRUE;
    	}
    }
    
	/**
     *  @brief Brief
     *  
     *  @param [in] $sessionId Parameter_Description
     *  @return Return_Description
     *  
     *  @details Details
     */
    public function addCredibility($sessionId) 
    {
    	$credibility = array();
		$credibility['user_id'] = $_SESSION['ss_user_id'];
		$credibility['session_id'] = $sessionId;
		$this->db->insert($this->_table_credibility, $credibility);

		return $this->db->insert_id();
    }
    
	/**
     *  @brief Brief
     *  
     *  @param [in] $session_id Parameter_Description
     *  @return Return_Description
     *  
     *  @details Details
     */
    public function getCredibilityId($user_id) 
    {
    	// $user_id = $_SESSION['ss_user_id'];
    	$this->db->where('user_id', $user_id);
		$this->db->where('status', 1);
		$this->db->where('trash',0);
		$query = $this->db->get($this->_table_credibility);
        if ($query->num_rows() > 0)
    	{
    		return $query->row()->c_id;
    	}
    }  
	
    /**
     *   add objcetion function
     */
    public function addObjection($session_id) 
    {
    	$objection = array();
		$objection['user_id'] = $_SESSION['ss_user_id'];
		$objection['session_id'] = $session_id;
		$this->db->insert($this->_table_objection, $objection);
		return $this->db->insert_id();
    }
	
    /**
     *  Get objection_id 
     */
    public function getObjectionId($session_id) 
    {
    	$user_id = $_SESSION['ss_user_id'];
    	//$this->db->where('user_id', $user_id);
    	$this->db->where('session_id',$session_id);
		$query = $this->db->get($this->_table_objection);
        if ($query->num_rows() > 0)
    	{
    		return $query->row()->obj_id;
    	}
    }

    /**
     * Get All Cuustom Fields
	 *
     * @param integer $user_id
     * @param string $type
     */

    public function get_custome_fields($user_id, $type, $session_id) 
    {

    	if($type == 'sales-process')
    	{
    		$this->db->where('field_type', 'close');
    	}
    	else if($type == 'interest')
    	{
    		$this->db->where('field_type', 'interest');
    	}
    	else if($type == 'target')
    	{
    		$this->db->where('field_type', 'target');
    	}
    	else if($type == 'users')
    	{
    		$this->db->where('field_type', 'users');
    	}
        else if($type == 'summary')
    	{
    		$this->db->where('field_type', 'summary');
    	}
    	else if($type == 'interestB1')
    	{
    		$this->db->where('field_type', 'interestB1');
    	}
    	else if($type == 'interestB2')
    	{
    		$this->db->where('field_type', 'interestB2');
    	}

    	//$this->db->where('user_id', $_SESSION['ss_user_id']);
    	$this->db->where('session_id', $session_id);
		$query = $this->db->get($this->_table_user_data);

        if ($query->num_rows() > 0)
    	{
    		return $query->result();
    	}
    }
    /**
     *  @brief get full table name with shart name
     *  
     *  @param string $shortname Parameter_Description
     *  @return Return_Description
     *  
     *  @details Details
     */
    private function _get_table_name($shortname) 
    {
    	switch ($shortname) {

    		case 'tpd':
    		return $this->_table_product_data;
    		break;
			
    		case 'tud':
    		return $this->_table_user_data;
    		break;
    		case 'tcd':
    		return $this->_table_credibility_data;
    		break;

    		case 'tod':
    		return $this->_table_objection_data;
    		break;
    		
    		case 'tbc':
    		return $this->_table_building_credibilities;
    		break;
    		
    		case 'tbi':
    		return $this->_table_building_interests;
    		break;

    		case 'tcl':
    		return $this->_table_close;
    		break;
    		
    		case 'tip':
    		return $this->_table_ideal_prospects;
    		break;
    		

    		case 'tob':
    		return $this->_table_objections;
    		break;
    		
    		case 'tpa':
    		return $this->_table_plains;
    		break;
    		
    		case 'tql':
    		return $this->_table_qualifying;
    		break;
    		
    		case 'tvl':
    		return $this->_table_values;
    		break;
    	}
    }

 
    /**
     * Get Progress Bar Data
     */
    public function get_progress_data($session_id) 
    {
    		$this->db->where('campaign_id', $session_id);
			$this->db->where('trash',0);
			$query = $this->db->get($this->_table_campaign);
        	if ($query->num_rows() > 0)
    		{
    			return $query->row()->progress_data;
    		}
    }
    
	/**
     *  @brief Brief
     *  
     *  @param [in] $data Parameter_Description
     *  @return Return_Description
     *  
     *  @details Details
     */
    private function _refine_steps($data) 
    {
    	if(gettype($data) == "array") 
		{
			$is_null = TRUE;
			foreach ($data as $key => $value)
			{
				$is_null = $this->_refine_steps($value);

				if($is_null == FALSE)
				{
					return FALSE;
				}
			}
			return $is_null;
		}
		else 
		{
			if($data == '' || $data == NULL)
			{
				return FALSE;
			}
			else 
			{
				return TRUE;
			}
		}
    }
    
	/**
     *  @brief Brief
     *  
     *  @param [in] $data Parameter_Description
     *  @param [in] $session_id Parameter_Description
     *  @return Return_Description
     *  
     *  @details Details
     */
    private function _update_progress($data, $session_id) 
    {	
    	// Get existing progress data from Database
    	$progress_data = $this->get_progress_data($session_id);
		
    	if(empty($progress_data))
    	{
    		$array = array();
    	}
    	else 
    	{
    		// Decode Progress Bar Data
    		$array = (array)json_decode($progress_data);
    	}

    	$is_filled = TRUE;
        
    	$array[$data['step']] = $is_filled;
        
        // This is Code is Added by Punit 
        // Code Starts Here
		if($data['step'] == 'sales_process')
		{
			$MyNewData = array("custom_content"=>TRUE);        
            $array = array_merge($array, $MyNewData);
		}
		
		if($data['step'] == 'interest')
        {
            $MyNewData = array("objection"=>true);        
            $array = array_merge($array, $MyNewData);
        }
        if(isset($data['form_submit']) && $data['form_submit'] == 'Continue' && $data['step'] == 'ideal_prospect_environment')
        {
            $MyNewData = array("ideal_prospect_environment"=>true);        
            $array = array_merge($array, $MyNewData);
        }
    	$encode_data = json_encode($array);
    	$update_data = array('progress_data' => $encode_data);
		
		// var_dump($update_data);
		
    	$this->db->where('campaign_id', $session_id);		
		// var_dump($update_data); die();
		$query = $this->db->update($this->_table_campaign, $update_data);
		// echo $this->db->last_query();
		
		
    }
    /**
     *  @brief Brief
     *  
     *  @param [in] $ignore_table_name Parameter_Description
     *  @param [in] $action Parameter_Description
     *  @param [in] $session_id Parameter_Description
     *  @return Return_Description
     *  
     *  @details Details
     */
    private function _set($ignore_table_name, $action, $session_id) 
    {
    	$data = $_POST;
    	// Update user progress
    	// $this->_update_progress($data, $session_id);
		foreach ($data as $table_name=>$table_data)
		{	
			// var_dump($table_data);
			$table = explode('_', $table_name);
			$table_name = $table['0'];
			$count = count($table);
			if($count > 1)
			{
				 $id = $table['1'];
			}			
	    	if( isset($table_name) && !empty($table_name) && $table_name == 'tpd') 
			{
				
				$table_name = $this->_get_table_name($table_name); // Get table full name
			    foreach($table_data as $field_key=>$value_data) 
			    {
					foreach ($value_data as $key => $value)
					{
						if($key == 'new')
				        {
				        	foreach ($value as $v)
				        	{
				        		// Insert Products Data into Database
				        		$product_data = array('product_id' => $id, 'field_type' => $field_key, 'value' => $v);
				        		
								// echo "this is one in tthis filed"; die();
								
								$this->db->insert($table_name, $product_data);

				        		if($field_key == 'tech_value')
				        		{
				        			$pain_data = array('product_id' => $id, 'field_type' => 'tech_pain', 'value' => '');

				        			$this->db->insert($table_name, $pain_data);

				        			$pain_detail_data = array('product_id' => $id, 'field_type' => 'desc_tech_pain', 'value' => '');

				        			$this->db->insert($table_name, $pain_detail_data);
				        			

				        			$qualify_data = array('product_id' => $id, 'field_type' => 'tech_qualify', 'value' => '');

				        			$this->db->insert($table_name, $qualify_data);
				        		}
				        		elseif ($field_key == 'bus_value')
				        		{
				        			$pain_data = array('product_id' => $id, 'field_type' => 'bus_pain', 'value' => '');
				        			$this->db->insert($table_name, $pain_data);
				        			$pain_detail_data = array('product_id' => $id, 'field_type' => 'desc_bus_pain', 'value' => '');
				        			$this->db->insert($table_name, $pain_detail_data);
				        			$qualify_data = array('product_id' => $id, 'field_type' => 'bus_qualify', 'value' => '');

				        			$this->db->insert($table_name, $qualify_data);
				        		}
				        		elseif ($field_key == 'pers_value')
				        		{
				        			$pain_data = array('product_id' => $id, 'field_type' => 'pers_pain', 'value' => '');
				        			$this->db->insert($table_name, $pain_data);
				        			$pain_detail_data = array('product_id' => $id, 'field_type' => 'desc_pers_pain', 'value' => '');
				        			$this->db->insert($table_name, $pain_detail_data);
				        			$qualify_data = array('product_id' => $id, 'field_type' => 'pers_qualify', 'value' => '');
				        			$this->db->insert($table_name, $qualify_data);
				        		}

				        	if($field_key == 'tech_pain')
				        		{
				        			$qualify_data = array('product_id' => $id, 'field_type' => 'tech_qualify', 'value' => '');
				        			$this->db->insert($table_name, $qualify_data);
				        		}
				        		elseif ($field_key == 'bus_pain')
				        		{
				        			$qualify_data = array('product_id' => $id, 'field_type' => 'bus_qualify', 'value' => '');

				        			$this->db->insert($table_name, $qualify_data);
				        		}
				        		elseif ($field_key == 'pers_pain')
				        		{
				        			$qualify_data = array('product_id' => $id, 'field_type' => 'pers_qualify', 'value' => '');
				        			$this->db->insert($table_name, $qualify_data);
				        		}
				        	}
				        }
				        else 
				        {
					        foreach ($value as $v)
					        	{
					        		// Update Products Data into Database
					        		$product_data = array('product_id' => $id, 'field_type' => $field_key, 'value' => $v);
					        		$this->db->where('product_data_id', $key);
					        		$this->db->update($table_name, $product_data);
					        	}
				        }
					}
			    }
			}

			if( isset($table_name) && !empty($table_name) && $table_name == 'tud') 
			{
				$table_name = $this->_get_table_name($table_name); // Get table full name

			    foreach($table_data as $field_key=>$value_data) 
			    {
					foreach ($value_data as $key => $value)
					{
						if($key == 'new')
				        {
				        	foreach ($value as $v)
				        	{
				        		// Insert Products Data into Database

				        		$user_data = array('user_id' => $_SESSION['ss_user_id'], 'session_id' => $session_id,'field_type' => $field_key, 'value' => $v);

				        		$this->db->insert($table_name, $user_data);
				        	}
				        }
				        else 
				        {
					        foreach ($value as $v)
					        	{
						        	$user_data = array('user_id' => $_SESSION['ss_user_id'], 'session_id' => $session_id, 'field_type' => $field_key, 'value' => $v);

									$this->db->where('user_data_id', $key);

									$this->db->update($table_name, $user_data);
					        	}
				        }
					}

			    }
			}

		if( isset($table_name) && !empty($table_name) && $table_name == 'tcd') 
			{
				$table_name = $this->_get_table_name($table_name); // Get table full name

			    foreach($table_data as $field_key=>$value_data) 
			    {
					foreach ($value_data as $key => $value)
					{
						if($key == 'new')
				        {
				        	foreach ($value as $v)
				        	{
				        		// Insert Products Data into Database

				        		$user_data = array('c_id' => $id, 'field_type' => $field_key, 'value' => $v);

				        		$this->db->insert($table_name, $user_data);
				        	}
				        }
				        else 
				        {
					        foreach ($value as $v)
					        	{			        	
						        	$user_data = array('c_id' => $id, 'field_type' => $field_key, 'value' => $v);

									$this->db->where('c_data_id', $key);

									$this->db->update($table_name, $user_data);
					        	}
				        }
					}
			    }
			}

			if( isset($table_name) && !empty($table_name) && $table_name == 'tod') 
			{
				$table_name = $this->_get_table_name($table_name); // Get table full name

			    foreach($table_data as $field_key=>$value_data) 
			    {
					foreach ($value_data as $key => $value)
					{
						if($key == 'new')
				        {
				        	foreach ($value as $v)
				        	{
				        		// Insert Products Data into Database

				        		$user_data = array('obj_id' => $id, 'field_type' => $field_key, 'value' => $v);

				        		$this->db->insert($table_name, $user_data);
				        	}
				        }
				        else 
				        {
				        	foreach ($value as $v)
				        	{				        	
					        	$user_data = array('obj_id' => $id,'field_type' => $field_key, 'value' => $v);

								$this->db->where('obj_data_id', $key);

								$this->db->update($table_name, $user_data);
				        	}

				        }
					}
			    }
			}
		}

    	return TRUE;
    }

    /**
     * Insert all steps information
     * @param $table_name string
     * @return Last inserted ID
     */

    public function add($table_name, $session_id) 
    {
    	return $this->_set($table_name, 'add', $session_id);
    	//return $this->db->insert_id();
    }
	
	/**
	 *  update menu progress bar
	 *  
	 *  @param integer $session_id current session id i.e. campaign id
	 *  @return boolean
	 */
	public function update_progress_menu($session_id){
	
		// echo $session_id;
		$data = $_POST;
		$this->_update_progress($data, $session_id);
		return true;
	}
	
	public function update_progress_menu_manual($data,$session_id)
	{
		$this->_update_progress($data, $session_id);
		return true;
	}
	
    /**
     * 
     * Check if all the fields are filled-in
     * @param $data
     */
    private function _is_all_fileds_filled($data, $table_name)
    {
    	$filled = TRUE;
    	$call_method = "refine_data_".$table_name;
    	$data = $this->{$call_method}($data, $table_name);
    	foreach ($data as $key=>$value)
    	{
    		if(empty($value))
    		{
    			$filled = FALSE;
    		}
    	}	
    	return $filled;
    }

    /**
     * Get All Credibilities
     */
	public function get_value_pain($id, $type) 
	{
		$this->db

				->select('product_data_id AS id, field_type, value, question_id,Qus_status');

				 $this->db->where('product_id', $id);

				 if($type == 'T')
				 {
				 	$this->db->where('field_type', 'tech_value');
				 }
				 elseif ($type == 'B')
				 {
				 	$this->db->where('field_type', 'bus_value');
				 }
				 elseif ($type == 'P')
				 {
				 	$this->db->where('field_type', 'pers_value');
				 }
				 elseif ($type == 'PT')
				 {
				 	$this->db->where('field_type', 'tech_pain'); 
				 }
				 elseif ($type == 'PB')
				 {
				 	$this->db->where('field_type', 'bus_pain'); 
				 }
				 elseif ($type == 'PP')
				 {
				 	$this->db->where('field_type', 'pers_pain');
				 }
	 			elseif ($type == 'DT')
				 {
				 	$this->db->where('field_type', 'desc_tech_pain'); 
				 }
				 elseif ($type == 'DB')
				 {
				 	$this->db->where('field_type', 'desc_bus_pain'); 
				 }
				 elseif ($type == 'DP')
				 {
				 	$this->db->where('field_type', 'desc_pers_pain'); 
				 }
				 elseif ($type == 'QT')
				 {
				 	$this->db->where('field_type', 'tech_qualify'); 
				 }
				 elseif ($type == 'QB')
				 {
				 	$this->db->where('field_type', 'bus_qualify'); 
				 }
				 elseif ($type == 'QP')
				 {
				 	$this->db->where('field_type', 'pers_qualify');
				 }
				elseif ($type == 'QTS')
				 {
				 	$this->db->where('field_type', 'single_tech_qualify'); 
				 }
				 elseif ($type == 'QBS')
				 {
				 	$this->db->where('field_type', 'single_bus_qualify'); 
				 }
				 elseif ($type == 'QPS')
				 {
				 	$this->db->where('field_type', 'single_pers_qualify');
				 }
		 			elseif ($type == 'QDT')
				 {
				 	$this->db->where('field_type', 'desc_tech_qualify'); 
				 }
				 elseif ($type == 'QDB')
				 {
				 	$this->db->where('field_type', 'desc_bus_qualify'); 
				 }
				 elseif ($type == 'QDP')
				 {
				 	$this->db->where('field_type', 'desc_pers_qualify'); 
				 }
	 			elseif ($type == 'P1')
				 {
				 	$this->db->where('field_type', 'P_Q1');
				 }
				elseif ($type == 'P2')
				 {
				 	$this->db->where('field_type', 'P_Q2');
				 }
				elseif ($type == 'P3')
				 {
				 	$this->db->where('field_type', 'P_Q3');
				 }
				elseif ($type == 'P4')
				 {
				 	$this->db->where('field_type', 'P_Q4');
				 }
				elseif ($type == 'P5')
				 {
				 	$this->db->where('field_type', 'P_Q5');
				 }
				elseif ($type == 'Pain1')
				 {
				 	$this->db->where('field_type', 'pain_Q1');
				 }
				elseif ($type == 'Pain3')
				 {
				 	$this->db->where('field_type', 'pain_Q3');
				 }
				elseif ($type == 'Pain5')
				 {
				 	$this->db->where('field_type', 'pain_Q5');
				 }

				 $this->db->where('product_id', $id);

			$query = $this->db->get($this->_table_product_data);
			
			if($query->num_rows > 0)
			{
				return $data = $query->result();
			}
	}

    /**
     * Get All Credibilities
     */

	public function get_all_credibilities($user_id,$session_id)
	{
		//$this->db->where('user_id', $user_id);
		$this->db->where('session_id', $session_id);
		$this->db->where('trash',0);
		$query = $this->db->get($this->_table_credibility);
		if($query->num_rows > 0)
		{
				return $query->result();
		}
	}
	
	/**
     * Get All Credibilities
     */

	public function get_all_credibilities_new($user_id)
	{
		
		$user_id = $_SESSION['ss_user_id'];
		$this->db->where('user_id', $user_id);
		$this->db->where('status', '1');
		$this->db->where('trash',0);
		$query = $this->db->get($this->_table_credibility);
		// echo $this->db->last_query();
		if($query->num_rows > 0)
		{
			return $query->result();
		}
		return NULL;
		
	}
	
    /**
     * Get All Products
     */
	public function get_all_products($user_id, $session_id)
	{
    	//$this->db->where('user_id', $user_id);
    	$this->db->where('session_id', $session_id);
		$this->db->where('trash',0);
		$query = $this->db->get($this->_table_products);
		if($query->num_rows > 0)
		{
			return $query->result();
		}
	}

    /**
     * Get All Objections
     */
	public function get_all_objections($user_id, $session_id)
	{
		//$this->db->where('user_id', $user_id);

		$this->db->where('session_id', $session_id);
		$query = $this->db->get($this->_table_objection);
		if($query->num_rows > 0)
		{
			return $query->result();
		}
	}	

    /**
     * Get All Objection Questions
     */
	public function get_meta_data($id, $type, $table_name)
	{
		$table_name = $this->_get_table_name($table_name); // Get table full name
		if($type == 'credibility')
		{
			$this->db

					->select('c_data_id AS id, field_type, value')
					->where('c_id', $id);
		}
		elseif ($type == 'product')
		{
			$this->db

					->select('product_data_id AS id, field_type, value')
					->where('product_id', $id);
		}
		elseif ($type == 'objection')
		{
			$this->db

					->select('obj_data_id AS id, field_type, value')

					->where('obj_id', $id);
		}

		$query = $this->db->get($table_name);

		if($query->num_rows > 0)
			{
				$data = $query->result();

				return $this->_convert_to_array($data);
			}
	}
	/**
	 *  @brief Brief
	 *  
	 *  @param [in] $data Parameter_Description
	 *  @return Return_Description
	 *  
	 *  @details Details
	 */
	private function _convert_to_array($data) 
	{
		foreach ($data as $obj)
		{
			$arr[$obj->field_type] = array(

				'value'	=>	$obj->value,

				'id'	=>	$obj->id

			);
		}

		return $arr;
	}

    /**
     * 
     * Refine Value Table
     * @param $data
     */
    function refine_data_values($data, $table_name)
    {
    	unset($data['P2']);
    	unset($data['P2_D']);
    	unset($data['P2_TB']);
    	unset($data['P2_BB']);
    	unset($data['P2_PB']);
    	unset($data['P3']);
    	unset($data['P3_D']);
    	unset($data['P3_TB']);
    	unset($data['P3_BB']);
    	unset($data['P3_PB']);
    	return $data;
    }


    /**
     * 
     * Refine Pains Table
     * @param $data
     */
    function refine_data_plains($data, $table_name)
    {
    	$refine_value_data = $this->get_data($_SESSION['ss_user_id'], 'values');

    	//For Technical Benefits
    	if($refine_value_data->P2_TB == NULL)
    	{
    		unset($data['TP_2']);
    	}

        if($refine_value_data->P3_TB == NULL)
    	{
    		unset($data['TP_3']);
    	}

    	//For Bussiness Benefits

        if($refine_value_data->P2_BB == NULL)
    	{
    		unset($data['TP_5']);
    	}

    	if($refine_value_data->P3_BB == NULL)
    	{
    		unset($data['TP_6']);
    	}

    	//For Personal Benefits

        if($refine_value_data->P2_PB == NULL)
    	{
    		unset($data['TP_8']);
    	}

    	if($refine_value_data->P3_PB == NULL)
    	{
    		unset($data['TP_9']);
    	}

    	return $data;
    }

    /**
     * 
     * Refine Ideal Prospects Table
     * @param $data
     */
    function refine_data_ideal_prospects($data, $table_name)
    {
    	$refine_pains_data = $this->get_data($_SESSION['ss_user_id'], 'plains');
    	if($refine_pains_data->TP_2 == NULL)
    	{
    		unset($data['IP_8']);
    	}

        if($refine_pains_data->TP_3 == NULL)
    	{
    		unset($data['IP_9']);
    	}

        if($refine_pains_data->BP_2 == NULL)
    	{
    		unset($data['IP_12']);
    	}

        if($refine_pains_data->BP_3 == NULL)
    	{
    		unset($data['IP_13']);
    	}

        	if($refine_pains_data->PP_2 == NULL)
    	{
    		unset($data['IP_16']);
    	}
        if($refine_pains_data->PP_3 == NULL)
    	{
    		unset($data['IP_17']);
    	}
    	return $data;
    }

    /**
     * 
     * Refine Qulifying Table
     * @param $data
     */
    function refine_data_qualifying($data, $table_name)
    {
    	$refine_ideal_prospects_data = $this->get_data($_SESSION['ss_user_id'], 'ideal_prospects');

        if($refine_ideal_prospects_data->IP_8 == NULL)
    	{
    		unset($data['QQ_8']);
    	}

        if($refine_ideal_prospects_data->IP_9 == NULL)
    	{
    		unset($data['QQ_9']);
    	}

        if($refine_ideal_prospects_data->IP_12 == NULL)
    	{
    		unset($data['QQ_12']);
    	}

        if($refine_ideal_prospects_data->IP_13 == NULL)
    	{
    		unset($data['QQ_13']);
    	}

        if($refine_ideal_prospects_data->IP_16 == NULL)
    	{
    		unset($data['QQ_16']);
    	}

        if($refine_ideal_prospects_data->IP_17 == NULL)
    	{
    		unset($data['QQ_17']);
    	}

    	return $data;
    }

    /** 
     * Refine Building Credibilities Table
	 *
     * @param $data
     */

    function refine_data_building_credibilities($data, $table_name)
    {
    	return $data;
    }    

    /**
     * Refine Building Interest Table
	 *
     * @param $data
     */

    function refine_data_building_interests($data, $table_name)
    {
    	return $data;
    }

    /** 
     * Refine Building Objections Table
     * @param $data
     */

    function refine_data_objections($data, $table_name)
    {
    	return $data;
    } 
    /**
     * Refine Close Table
	 *
     * @param $data
     */
    function refine_data_close($data, $table_name)
    {
    	return $data;
    } 
	
    /**
     *  @brief Brief
     *  
     *  @return Return_Description
     *  
     *  @details Details
     */
    function addExtra ()
    {
    	$array = array($_POST['table_name'] => array($_POST['field_name'] => array('new' => array())));

    	// Update user progress

    	//$this->_update_progress($data);

		foreach ($array as $table_name=>$table_data)
		{	
			$table = explode('_', $table_name);

			$table_name = $table['0'];

			$count = count($table);

			if($count > 1)
			{
				 $id = $table['1'];
			}

	    	if( isset($table_name) && !empty($table_name) && $table_name == 'tpd') 
			{
				$table_name = $this->_get_table_name($table_name); // Get table full name

				$insert_id = '';

			    foreach($table_data as $field_key=>$value_data) 
			    {
		        	// Insert Products Data into Database
		        	
					/***  find alst question_id inseart into database */ 
					
					$this->db->select('max(question_id) as maxqusid');
					$this->db->where('product_id',$id);
					$this->db->where('field_type',$field_key);
					$getmaxidresult = $this->db->get($this->_table_product_data);
					
					// echo $this->db->last_query();
					
					if($getmaxidresult->num_rows > 0)
					{
						$question_id = $getmaxidresult->row()->maxqusid;
					}
					
					$next_question_id =$question_id + 1;
					
					$product_data = array('product_id' => $id, 'field_type' => $field_key, 'value' => '','question_id' => $next_question_id);
		        	$this->db->insert($table_name, $product_data);
		        	$insert_id =  $this->db->insert_id();

		        		if($field_key == 'tech_value')
		        		{
							$pain_data = array('product_id' => $id, 'field_type' => 'tech_pain', 'value' => '','question_id' => $next_question_id);
		        			$this->db->insert($table_name, $pain_data);
							$pain_detail_data = array('product_id' => $id, 'field_type' => 'desc_tech_pain', 'value' => '');
		        			$this->db->insert($table_name, $pain_detail_data);
							$qualify_data = array('product_id' => $id, 'field_type' => 'tech_qualify', 'value' => '','question_id' => $next_question_id);
		        			$this->db->insert($table_name, $qualify_data);    			
							$qualify_detail_data = array('product_id' => $id, 'field_type' => 'desc_tech_qualify', 'value' => '');
		        			$this->db->insert($table_name, $qualify_detail_data);
		        		
							/** make a loop and cread question for business value,businees tech personal value, persoal tech */
							
							
							$startpoint = ($question_id*3)+1;
							$endpoint = $startpoint +2;
							
							for($startpoint;$startpoint <= $endpoint;++$startpoint)
							{
								
								$bus_value_data = array('product_id' => $id, 'field_type' => 'bus_value', 'value' => '','question_id' => $startpoint);
								$this->db->insert($table_name, $bus_value_data);
								
								$per_value_data = array('product_id' => $id, 'field_type' => 'pers_value', 'value' => '','question_id' => $startpoint);
								$this->db->insert($table_name, $per_value_data);
								
								$bus_pain_data = array('product_id' => $id, 'field_type' => 'bus_pain', 'value' => '','question_id' => $startpoint);
								$this->db->insert($table_name, $bus_pain_data);
							
								$pers_pain_data = array('product_id' => $id, 'field_type' => 'pers_pain', 'value' => '','question_id' => $startpoint);
								$this->db->insert($table_name, $pers_pain_data);
								
								$bus_qualify_data = array('product_id' => $id, 'field_type' => 'bus_qualify', 'value' => '','question_id' => $startpoint);
								$this->db->insert($table_name, $bus_qualify_data);
								
								$pers_qualify_data = array('product_id' => $id, 'field_type' => 'pers_qualify', 'value' => '','question_id' => $startpoint);
								$this->db->insert($table_name, $pers_qualify_data);
								
							}
							
						}
		        		elseif ($field_key == 'bus_value')
		        		{
		        			
							
							$pain_data = array('product_id' => $id, 'field_type' => 'bus_pain', 'value' => '','question_id' => $next_question_id);
		        			$this->db->insert($table_name, $pain_data);
		        			$pain_detail_data = array('product_id' => $id, 'field_type' => 'desc_bus_pain', 'value' => '');
		        			$this->db->insert($table_name, $pain_detail_data);
		        			$qualify_data = array('product_id' => $id, 'field_type' => 'bus_qualify', 'value' => '','question_id' => $next_question_id);
		        			$this->db->insert($table_name, $qualify_data);
		        			$qualify_detail_data = array('product_id' => $id, 'field_type' => 'desc_bus_qualify', 'value' => '');
		        			$this->db->insert($table_name, $qualify_detail_data);
							
							$pers_pain_data = array('product_id' => $id, 'field_type' => 'pers_pain', 'value' => '','question_id' => $next_question_id);
		        			$this->db->insert($table_name, $pers_pain_data);
							
							$pers_qualify_data = array('product_id' => $id, 'field_type' => 'pers_qualify', 'value' => '','question_id' => $next_question_id);
		        			$this->db->insert($table_name, $pers_qualify_data);
							
							
		        		}
		        		elseif ($field_key == 'pers_value')
		        		{
		        			$pain_data = array('product_id' => $id, 'field_type' => 'pers_pain', 'value' => '','question_id' => $next_question_id);
		        			$this->db->insert($table_name, $pain_data);
		        			$pain_detail_data = array('product_id' => $id, 'field_type' => 'desc_pers_pain', 'value' => '');
		        			$this->db->insert($table_name, $pain_detail_data);
		        			$qualify_data = array('product_id' => $id, 'field_type' => 'pers_qualify', 'value' => '','question_id' => $next_question_id);
		        			$this->db->insert($table_name, $qualify_data);
		        			$qualify_detail_data = array('product_id' => $id, 'field_type' => 'desc_pers_qualify', 'value' => '');
		        			$this->db->insert($table_name, $qualify_detail_data);
		        		}
			    }
			    return $insert_id;
			}
		}
    }
	
    /**
     *  @brief Brief
     *  
     *  @return Return_Description
     *  
     *  @details Details
     */
    function addExtraPain()
    {
    	$array = array($_POST['table_name'] => array($_POST['field_name'] => array('new' => array())));

		foreach ($array as $table_name=>$table_data)
		{	
			$table = explode('_', $table_name);

			$table_name = $table['0'];

			$count = count($table);

			if($count > 1)
			{
				 $id = $table['1'];
			}

	    	if( isset($table_name) && !empty($table_name) && $table_name == 'tpd') 
			{
				$table_name = $this->_get_table_name($table_name); // Get table full name
				$insert_id = '';
			    foreach($table_data as $field_key=>$value_data) 
			    {
		        	// Insert Products Data into Database
		        	$product_data = array('product_id' => $id, 'field_type' => $field_key, 'value' => '');
		        	$this->db->insert($table_name, $product_data);
		        	$insert_id =  $this->db->insert_id();

		        	if($field_key == 'tech_pain')
		        		{
		        			$qualify_data = array('product_id' => $id, 'field_type' => 'tech_qualify', 'value' => '');

		        			$this->db->insert($table_name, $qualify_data);
		        			$qualify_detail_data = array('product_id' => $id, 'field_type' => 'desc_tech_qualify', 'value' => '');

		        			$this->db->insert($table_name, $qualify_detail_data);
		        			
		        			$desc_tech_pain = array('product_id' => $id, 'field_type' => 'desc_tech_pain', 'value' => '');

		        			$this->db->insert($table_name, $desc_tech_pain);

		        			$detail_insert_id =  $this->db->insert_id();
		        		}
		        		elseif ($field_key == 'bus_pain')
		        		{		        			
		        			$qualify_data = array('product_id' => $id, 'field_type' => 'bus_qualify', 'value' => '');

		        			$this->db->insert($table_name, $qualify_data);
		        			
		        			$qualify_detail_data = array('product_id' => $id, 'field_type' => 'desc_bus_qualify', 'value' => '');

		        			$this->db->insert($table_name, $qualify_detail_data);
		        			
		        			$desc_bus_pain = array('product_id' => $id, 'field_type' => 'desc_bus_pain', 'value' => '');

		        			$this->db->insert($table_name, $desc_bus_pain);

		        			$detail_insert_id =  $this->db->insert_id();
		        		}
		        		elseif ($field_key == 'pers_pain')
		        		{		        			
		        			$qualify_data = array('product_id' => $id, 'field_type' => 'pers_qualify', 'value' => '');

		        			$this->db->insert($table_name, $qualify_data);
		        			
		        			$qualify_detail_data = array('product_id' => $id, 'field_type' => 'desc_pers_qualify', 'value' => '');

		        			$this->db->insert($table_name, $qualify_detail_data);
		        			
		        			$desc_pers_pain = array('product_id' => $id, 'field_type' => 'desc_pers_pain', 'value' => '');

		        			$this->db->insert($table_name, $desc_pers_pain);

		        			$detail_insert_id =  $this->db->insert_id();
		        		}
			    }

			    $result = array('id' => $insert_id, 'd_id' => $detail_insert_id);

			    return $result;
			}
		}
    }
	
    /**
     *  @brief Brief
     *  
     *  @return Return_Description
     *  
     *  @details Details
     */
    function addExtraQualify()
    {
    	$array = array($_POST['table_name'] => array($_POST['field_name'] => array('new' => array())));
		foreach ($array as $table_name=>$table_data)
		{	
			$table = explode('_', $table_name);

			$table_name = $table['0'];

			$count = count($table);

			if($count > 1)
			{
				 $id = $table['1'];
			}

	    	if( isset($table_name) && !empty($table_name) && $table_name == 'tpd') 
			{
				$table_name = $this->_get_table_name($table_name); // Get table full name
				$insert_id = '';

			    foreach($table_data as $field_key=>$value_data) 
			    {
		        	// Insert Products Data into Database

		        	$product_data = array('product_id' => $id, 'field_type' => $field_key, 'value' => '');

		        	$this->db->insert($table_name, $product_data);

		        	$insert_id =  $this->db->insert_id();

		        	if($field_key == 'tech_qualify')
		        		{
		        			$qualify_detail_data = array('product_id' => $id, 'field_type' => 'desc_tech_qualify', 'value' => '');

		        			$this->db->insert($table_name, $qualify_detail_data);

		        			$detail_insert_id =  $this->db->insert_id();
		        		}
		        		elseif ($field_key == 'bus_qualify')
		        		{		        			
		        			$qualify_detail_data = array('product_id' => $id, 'field_type' => 'desc_bus_qualify', 'value' => '');

		        			$this->db->insert($table_name, $qualify_detail_data);

		        			$detail_insert_id =  $this->db->insert_id();
		        		}
		        		elseif ($field_key == 'pers_qualify')
		        		{		        			
		        			$qualify_detail_data = array('product_id' => $id, 'field_type' => 'desc_tech_qualify', 'value' => '');

		        			$this->db->insert($table_name, $qualify_detail_data);

		        			$detail_insert_id =  $this->db->insert_id();
		        		}
			    }

			    $result = array('id' => $insert_id, 'd_id' => $detail_insert_id);
			    return $result;
			}
		}
    }
    /**
     *  @brief Brief
     *  
     *  @param [in] $productId Parameter_Description
     *  @return Return_Description
     *  
     *  @details Details
     */
    function deleteProduct($productId) 
    {
		//Move to trash
		if($isdelete==0) {
			$upd = array('trash' => 1);
			$this->db->where('product_id',$productId);
			$this->db->update($this->_table_products,$upd);
			return TRUE;
		}
		//Restore
		if($isdelete==2) {
			$upd = array('trash' => 0);
			$this->db->where('product_id',$productId);
			$this->db->update($this->_table_products,$upd);
			return TRUE;
		}
    	$this->db->where('product_id', $productId);
		$this->db->where('trash',1);
		$this->db->delete($this->_table_products);

		return TRUE;
    }

//-------------------------------------------------------------------------

    function deleteCredibility($credibility_id) 
    {
    	$this->db->where('c_id', $credibility_id);

		$this->db->delete($this->_table_credibility);

		return TRUE;
    }

//-------------------------------------------------------------------------    

    function deleteQus($qusId) 
    {
    	$this->db->where('product_data_id', $qusId);
		// echo $this->_table_product_data; 
		$this->db->delete($this->_table_product_data);
		// echo $this->db->last_query();
		return TRUE;
    }

//-------------------------------------------------------------------------    

    function deleteSession($sessionId) 
    {
    	$this->db->where('session_id', $sessionId);

		$this->db->delete($this->_table_session);

		return TRUE;
    }

//-------------------------------------------------------------------------    

    function deleteDraftSessions($sessionId) 
    {
    	$this->db->where('session_id', $sessionId);

		$this->db->delete($this->_table_session);

		return TRUE;
    }

//-------------------------------------------------------------------------    

    function deleteQusPQ($qusId, $detail_id) 
    {
    	$this->db->where_in('product_data_id', array($qusId, $detail_id));

		$this->db->delete($this->_table_product_data);

		return TRUE;
    }

    public function getPainValues($p_id,$type)
    {
    		$this->db->where('product_id', $p_id);

    		if($type == 'T')
    		{
    			$this->db->where('field_type', 'tech_value');
    		}

    		if($type == 'B')
    		{
    			$this->db->where('field_type', 'bus_value');
    		}

    		if($type == 'P')
    		{
    			$this->db->where('field_type', 'pers_value');
    		}

			$query = $this->db->get($this->_table_product_data);

			if($query->num_rows > 0)
			{
				return $query->row();
			}
    }

    public function checkValues($p_id,$type)
    {
    		if($type == 'T')
    		{
    			$this->db->where('field_type', 'tech_pain');
    		}

    		if($type == 'B')
    		{
    			$this->db->where('field_type', 'bus_pain');
    		}

    		if($type == 'P')
    		{
    			$this->db->where('field_type', 'pers_pain');
    		}

    		$this->db->where('product_id', $p_id);

			$query = $this->db->get($this->_table_product_data);

			if($query->num_rows > 0)
			{
				return '1';
			}
			else
			{
				return '0';
			}
    }

//-----------------------------------------------------------------    

    public function addData($session_data, $session_id)
    {
    	// Different Counters

    	$targetCounter = 0;

    	foreach($session_data as $field_key=>$value_data) 
	    {
			// Insert Products Data into Database

        	$user_data = array(

        		'user_id' => $_SESSION['ss_user_id'],

        	 	'session_id' => $session_id,

        	 	'field_type' => $value_data->field_type,

        	 	'value' => $value_data->value

        	);

        	// Add default Target Values

        	if($user_data['field_type'] == 'target') {

        		if(!$user_data['value'] AND $targetCounter == 0) {

        			$user_data['value'] = "[target geography]";

        		} elseif(!$user_data['value'] AND $targetCounter == 1) {

        			$user_data['value'] = "[smallest prospect]";

        		} elseif(!$user_data['value'] AND $targetCounter == 2) {

        			$user_data['value'] = "[largest prospect]";

        		} elseif(!$user_data['value'] AND $targetCounter == 3) {

        			$user_data['value'] = "[target industries]";

        		} elseif(!$user_data['value'] AND $targetCounter == 4) {

        			$user_data['value'] = "[excluded industries]";

        		} elseif(!$user_data['value'] AND $targetCounter == 5) {

        			$user_data['value'] = "[target department]";

        		} elseif(!$user_data['value'] AND $targetCounter == 6) {

        			$user_data['value'] = "[target department]";

        		} elseif(!$user_data['value'] AND $targetCounter == 7) {

        			$user_data['value'] = "[target title]";

        		} elseif(!$user_data['value'] AND $targetCounter == 8) {

        			$user_data['value'] = "[target title]";

        		}

        		$targetCounter++;
        	}

        	$this->db->insert($this->_table_user_data, $user_data);

		}

		return True;
    }

//-----------------------------------------------------------------    

    public function addSessionCredibility($data)
    {
		$this->db->insert($this->_table_credibility_data, $data);
		return TRUE;
    }

//-----------------------------------------------------------------

    public function addSessionObjection($data)
    {
		$this->db->insert($this->_table_objection_data, $data);
		return TRUE;
    }

//-----------------------------------------------------------------------

    /**
     * Search User fot Team Member
     * Enter description here ...
     * @param $search_name string
     */

    public function searchUser($search_name) 
    {
    	//$select = 'user_id, username, first_name, last_name, CONCAT(first_name," ",last_name) AS name';

    	/*$this->db->select('user_id, username, first_name, last_name');


    	$this->db->like('username', $search_name);

    	$this->db->or_like('first_name', $search_name);

    	$this->db->or_like('last_name', $search_name);
    	

    	$this->db->where("CONCAT(first_name, ' ', last_name) LIKE '%".$search_name."%'", NULL, FALSE);

    	//$this->db->or_like('name', $search_name);*/
    	

    	$query = $this->db->query("SELECT `user_id`, `username`, `first_name`, `last_name` FROM (".$this->_table_users.") WHERE CONCAT(first_name, ' ', last_name) LIKE '%".$search_name."%' OR `username` LIKE '%".$search_name."%' OR `first_name` LIKE '%".$search_name."%' OR `last_name` LIKE '%".$search_name."%' ");

    	if ($query->num_rows() > 0)
    	{
    		return $query->result();
    	}
    }

//-----------------------------------------------------------------------


    /**
     * Search User fot Template
     * Enter description here ...
     * @param $template_name string , Added by Aavid Developer on 26- March -2014
     */

    public function searchTemplate($template_name) 
    {
    	$query = $this->db->query("SELECT `TemplateId`, `TemplateName`, `Description` FROM templates WHERE `TemplateName` LIKE '%".$template_name."%' OR `Description` LIKE '%".$template_name."%'");
        if ($query->num_rows() > 0)
    	{
    		return $query->result();
    	}
    }

//-----------------------------------------------------------------------
    /**
     */

    public function get_requester_session_id($user_id) 
    {
    	$this->db->where('user_id', $user_id);

    	$query = $this->db->get($this->_table_session);

    	if ($query->num_rows() > 0)
    	{
    		return $query->row()->session_id;
    	}
    }

//-----------------------------------------------------------------------

    /**
     * Add User into Team Session Table
     * @param $data array
     * @return Last inserted ID
     */

    public function addUser($data) 
    {
    	$this->db->insert($this->_table_team_sessions, $data);

    	return $this->db->insert_id();
    }

//-----------------------------------------------------------------------

    /**
     * Check If User is already in team_session table
     * @param integer $receiver_id
     * @return boolean|string
     */

    public function alreadyExist($receiver_id,$sender_id) 
    {
    	//$this->db->where('receiver_id', $receiver_id);

    	//$query = $this->db->get($this->_table_team_sessions);
        $query = $this->db->get_where($this->_table_team_sessions,array('receiver_id'=>$receiver_id , 'sender_id'=>$sender_id));
    	if ($query->num_rows() > 0)
    	{
    		//return TRUE;
    		return $query->row()->receiver_id;
    	}
    }
//-----------------------------------------------------------------------

    /**
     * Function for getting Tempalate Information from its Id
     * Created By aavid Develeloper on 26- March - 2014
     */

    public function GetTemplate($TemplateId) 
    {
    	//$this->db->where('TemplateId', $TemplateId);

    	$query = $this->db->query(' SELECT * FROM templates where TemplateId='.$TemplateId);
        //return TRUE;
    	return $query;
    	
    }
//-----------------------------------------------------------------------

    /**
     * Get All Requests
     * @param unknown_type $user_id
     * @param string $for
     */

    public function getAllRequests($user_id, $for) 
    {
        if($for == 'sender')
    	{
    		$this->db->where('sender_id', $user_id);
			$this->db->where('status', '1');
    	}
    	else 
    	{
    		$this->db->where('receiver_id', $user_id);
    		$this->db->where('status', '1');
    	}

    	$query = $this->db->get($this->_table_team_sessions);

    	if ($query->num_rows() > 0)
    	{
    		return $query->result();
    	}
    }

	/**
	 *   get all new request for connection
	 */
	public function getAllRequestsNew($user_id, $for) 
    {
        $this->db->where('receiver_id', $user_id);
    	$this->db->where('status', '0');
    	$query = $this->db->get($this->_table_team_sessions);
    	if ($query->num_rows() > 0)
    	{
    		return $query->result();
    	}
		return array();
    }

    /**
     * Get All Receiver Requests
     * @param unknown_type $user_id
     * @param string $for
     */

    public function getAllReceiverRequests($user_id) 
    {
    	$this->db->where('receiver_id', $user_id);

    	$this->db->where('status', '1');

    	$query = $this->db->get($this->_table_team_sessions);

    	if ($query->num_rows() > 0)
    	{
    		return $query->result();
    	}
    }

//-----------------------------------------------------------------------

    /**
     * 
     * Get User Detail for Invitation and Management Listing page
     * @param integer $user_id
     * @param string $for
     */

    public function getDetailForManagementListing($user_id, $for) 
    {
    	$this->db->select('user_id, username, first_name, last_name');
    	$this->db->where('user_id', $user_id);
    	$query = $this->db->get($this->_table_users);
		// echo $this->db->last_query();
    	if ($query->num_rows() > 0)
    	{
    		return $query->row();
    	}
    }
  
    /*
    function deleteFrndRequest($frnd_id, $action) 
    {
    	if($action == 'rec')
    	{
    		$this->db->where('receiver_id', $frnd_id);
    	}
    	else 
    	{
    		$this->db->where('sender_id', $frnd_id);
    	}

		$this->db->delete($this->_table_team_sessions);

		return TRUE;
    }
    */
    function deleteFrndRequest($frnd_id, $action,$sender_id,$team_session_id) 
    {
    	if($action == 'rec')
    	{
    		$this->db->where('receiver_id', $frnd_id);
                $this->db->where('t_session_id', $team_session_id);
    	}
    	else 
    	{
    		$this->db->where('sender_id', $frnd_id);
                $this->db->where('t_session_id', $team_session_id);
    	}

		$this->db->delete($this->_table_team_sessions);

		return TRUE;
    }

//-----------------------------------------------------------------------

    /**
     * Invitaion Accept
     * @param $invitation_user_id integer
     */

    public function invitaionAccept($invitation_user_id) 
    {
    	$this->db->where('receiver_id',$invitation_user_id);

    	$data = array('status' => '1');
    	$query = $this->db->update($this->_table_team_sessions, $data);

    	return TRUE;
    }

//-----------------------------------------------------------------------

    /**
     * Get All Requests
     * @param unknown_type $user_id
     * @param string $for
     */

    public function acceptInvitations($user_id)
    {
    	$this->db->where('sender_id', $user_id);

    	$this->db->where('status', '1');

    	$query = $this->db->get($this->_table_team_sessions);

    	if ($query->num_rows() > 0)
    	{
    		return $query->result();
    	}
    }

//-----------------------------------------------------------------------

    /**
     * Get All Requests
     * @param unknown_type $user_id
     * @param string $for
     */

    public function acceptInvitationsReceiver($user_id)
    {
    	$this->db->where('receiver_id', $user_id);

    	$this->db->where('status', '1');
    	
    	$query = $this->db->get($this->_table_team_sessions);

    	if ($query->num_rows() > 0)
    	{
    		return $query->result();
    	}
    }

//-----------------------------------------------------------------------

    /**
     * Get All Sessions
     * @param $data array
     * @param $table_name string
     */

    public function get_all_team_sessions($user_id) 
    {
    	$this->db->where('user_id', $user_id);
		$this->db->where('trash',0);
    	$query = $this->db->get($this->_table_products);
    	if($query->num_rows() > 0)
    	{
    		return $query->result();
    	}
		return array();
    }

	/**
	*	get all product with product id
	*/	
    public function get_products_by_sessionId($product_id) 
    {
    	$this->db->where('product_id', $product_id);
		$this->db->where('trash',0);
    	$query = $this->db->get($this->_table_products);
    	if ($query->num_rows() > 0)
    	{
    		return $query->result();
    	}
		return array();
    }

//-----------------------------------------------------------------------

    public function get_all_product_data($p_data_id) 
    {
    	$this->db->where('product_id', $p_data_id);

    	$query = $this->db->get($this->_table_product_data);

    	if ($query->num_rows() > 0)
    	{
    		return $query->result();
    	}
    }

	/**
	 *  add new product in product table
	 *  
	 *  @params array $data all key value for product table data
	 */
    public function add_own_products($data) 
    {
 		$this->db->insert($this->_table_products, $data);
 		return $this->db->insert_id();
    }
	
	/**
	 *  add new product in product table
	 *  
	 *  @params array $data all key value for product table data
	 */
    public function add_own_products_data($data) 
    {
 		$this->db->insert($this->_table_product_data, $data);
 		return $this->db->insert_id();
    }
	
	/**
	 *   depreciated  function
	 */
    public function add_own_session($session_data) 
    {
 		$this->db->insert($this->_table_session, $session_data);
 		return $this->db->insert_id();
    }
	
    public function CheckUserVal($UserId,$SessionId) 
    {
 		$VerifyQuery = $this->db->get_where('tbl_value', array('SessionId' => $SessionId));
                
                return $VerifyQuery;
    }
	
	/**
	 * Function to update question on value section
	 */
	public function updateValueSecQuestionStatsus($question_id,$status)
	{	
		$data = array(
               'Qus_status' => $status,
            );
			
		$this->db->where('product_data_id', $question_id);
		$this->db->update('product_data', $data); 
		return true;
	}
	//-----------------------------------------------------------------------
	//SHARING LITE USRES
	//by Dev@4489
    /**
     * Check If User is already in tbl_user_shared table for Team Sharing
     * @param integer $receiver_id
     * @return boolean|string
     */

    public function sharealreadyExist($receiver_id) 
    {
        $query = $this->db->get_where("tbl_user_shared",array('userto'=>$receiver_id));
    	if ($query->num_rows() > 0)
    	{
    		return "Y";//Lite user exists
    	}
		$query = $this->db->get_where("users",array('user_id'=>$receiver_id));
    	if ($query->num_rows() > 0)
    	{
    		return $query->row()->username;//Lite username
    	}
		return "N";//No User
    }
//-----------------------------------------------------------------------
	//by Dev@4489
    /**
     * Add User into User Share Table
     * @param $data array
     */

    public function addtoShareUser($data) 
    {
    	$this->db->insert("tbl_user_shared", $data);
    }

//-----------------------------------------------------------------------
	//by Dev@4489
	/**
     * Get All shared users
     * @param unknown_type $user_id
     * @param string $for
     */

    public function getSharedUsers($user_id) 
    {
		$this->db->select('user_id,username,first_name,last_name,access,accessview');
		$this->db->from('tbl_user_shared');
		$this->db->join('users', 'users.user_id = tbl_user_shared.userto','left');
		$this->db->where('userfrom', $user_id);
		$query = $this->db->get();
    	if ($query->num_rows() > 0)
    	{
    		return $query->result();
    	}
    }
	
//-----------------------------------------------------------------------
	//by Dev@4489
	/**
     * Remove shared users
     * @param $user_id,$reciever
     */

    public function UnShareUser($user_id,$shareuser_id) 
    {
		$this->db->where('userfrom', $user_id);
		$this->db->where('userto', (int)$shareuser_id);
		return $this->db->delete('tbl_user_shared');
    }
	//by Dev@4489
	/**
     * Get Share user
     * @param $user_id
     */

    public function SharedUser($user_id) 
    {
		$this->db->select('userfrom');
		$this->db->from('tbl_user_shared');
		$this->db->where('userto', $user_id);
		$query = $this->db->get();
    	if ($query->num_rows() > 0)
    	{
    		return $query->row()->userfrom;//Share user ID
    	}
		return 0;
    }
    //by Dev@4489
    /**
     * Get Shared user information
     * @param $user_id
     */

    public function SharedUserInfo($user_id) 
    {
        $this->db->from('tbl_user_shared');
        $this->db->where('userto', $user_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0)
        {
            return $query->row();
        }
        return 0;
    }
		
	//End of SHARING LITE USRES
	//Save User Data
	public function saveUserData($data,$where=array()) 
    {
		if($where) {
			foreach($where as $wi=>$wval) 
			$this->db->where($wi, $wval);
			$this->db->update($this->_table_user_info, $data);
		} else 
    		$this->db->insert($this->_table_user_info, $data);
    }
	//Get user data
	public function getUserData($where) 
    {
		foreach($where as $wi=>$wval) 
			$this->db->where($wi, $wval);
		$query = $this->db->get($this->_table_user_info);
		$this->db->last_query();
		return $query->result();
    }
    
    //Get user data
    public function getEmailSubjects($userids) 
    {
        $this->db->where_in('user_id', $userids);
        $this->db->where('field_type','Email-Subjects');
        $query = $this->db->get($this->_table_user_info);
        //echo $this->db->last_query();
        return $query->result();
    }

    

    //Get pro user invitation
    public function get_pro_invite($from,$to)
    {
        $this->db->where("(sender_id=$from and receiver_id=$to) OR (sender_id=$to and receiver_id=$from)",NULL,FALSE);
        $query = $this->db->get($this->_table_team_sessions);
        if ($query->num_rows() > 0)
        {
            return $query->row();
        }
        return false;
    }
    //Delete pro user invitation
    public function delete_pro_invite($from,$id)
    {
        $this->db->where("(sender_id=$from OR receiver_id=$from)",NULL,FALSE);
        $this->db->where('t_session_id',$id);
        $this->db->delete($this->_table_team_sessions);
    }
    //Save List User access
    public function saveLiteUserAccess($data,$where=array()) 
    {
		if($where) {                  
            $this->db->where('userfrom', $where['from']);
            $this->db->where('userto', $where['to']);
            $this->db->update('tbl_user_shared', $data);
        } else {	
            $this->db->insert('tbl_user_shared', $data);
        }            
        //echo $this->db->last_query();
    }

    //Get user meta data by key & id(optional)
    public function getUserMeta($key,$userid=0) 
    {
        if($userid) $this->db->where('user_id', $userid);
        $this->db->where('field_type',$key);
        $this->db->order_by("updated","asc");
        $query = $this->db->get($this->_table_user_info);
        return $query->result();
    }

    //Get user meta with like custom query
    public function getUserMetaCustomize($key,$where,$userid=0) 
    {
        $this->db->where($where,NULL,FALSE);
        if($userid) $this->db->where('user_id', $userid);
        $this->db->where('field_type',$key);
        $query = $this->db->get($this->_table_user_info);        
        return $query->row();
    }    

    //Save mailchimp campaigns to user meta
    public function saveMailchimpCampaigns($edata,$id=0) 
    {
        if($id) {
            $this->db->where('user_info_id', $id);
            $this->db->set('value', 'CONCAT(value,\''.$edata.'\')', FALSE);
            $this->db->update($this->_table_user_info);            
            return $id;
        } else {
            $this->db->insert($this->_table_user_info, $edata);
            return $this->db->insert_id();
        }        
    }
		
}

/* End of file home_model.php */

/* Location: ./application/models/home_model.php */