<?php
/**
 *   main custom controller file 
 *  
 *   Here we can extends main core functionality of default main controller 
 *  
 *  PHP > 5.2
 *  @version 1.2
 *  @author Bineet kumar Chaubey 
 *  @packagege cakephp 
 *  @subpackage Interview scripter  
 *  @see
 *  @link
 */
class My_Controller extends CI_Controller {

    function __construct()
    {
        parent::__construct();
    }
	/**
	 *   load config FIle.
	 */
	public function loadConfig()
	{
		$this->load->model('category_model');
		$this->load->model('attribute_model','attribute');
		$this->load->model('jobprofile_model');
		$this->load->model('user_model');
		$this->load->model('contact_model');
		$this->load->model('question_model','QuestionModel');
		$this->load->helper('common_helper');
		$this->config->load('facebook'); 
		$this->config->load('project'); 
	}
}