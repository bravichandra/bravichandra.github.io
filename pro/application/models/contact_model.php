<?php
/**
 *  This is coatact class file
 *   
 *  
 *  
 *  PHP > 5.2
 *  @version 1.1
 *  @author Bineet kumar chaubey
 *  @package Codeigniter
 *  @subpackage InterviewScripter
 *  @link
 *  @see
 */
class contact_model extends CI_Model {
	 
	/**
	 * Constructor 
	 *
	 */
	 
    function __construct()
    {
                parent::__construct();               

    }
     /**
     * Function name  : getcontacts
     * Function Use   :This function is use to fetch contact records of particular user.
     * Function Param :NULL
     * Return Value:Result. 
     */ 
	public function getcontacts()
	{
            $userid=$this->session->userdata('userid');
            $result=$this->db->query("select * from contacts where user_id='$userid'");
            return $result;
        }
  //End of getcontacts Function
   /**
     * Function name  : addcontact
     * Function Use   :This function is use to insert contact of particualr user.
     * Function Param :$name,$gender,$physical,$personality,$sense_humor,$integrity,$intelligence,$availability,$level_baggage
     * Return Value:Result. 
     */ 
	public function addcontact($name,$gender)
	{
            $userid=$this->session->userdata('userid');
           // echo "INSERT INTO `contacts`(`user_id`, `contact_name`, `gender`, `physical_apperance`, `personality`, `sense_of_humor`, `intelligence`, `integrity`, `availability`, `level_of_baggage`) 
           //                            VALUES ('$userid','$name','$gender','$physical','$personality','$sense_humor','$integrity','$intelligence','$availability','$level_baggage')";exit;
            
            $query=$this->db->query("INSERT INTO `contacts`(`user_id`, `contact_name`, `gender`) 
                                         VALUES ('$userid','$name','$gender')");
           return $query;
        }
  //End of getcontacts Function
        

/**
     * Function name  : getcontactbyid
     * Function Use   :This function is use to fetch contact records of particular contact.
     * Function Param :$contactid
     * Return Value:Result. 
     */ 
	public function getcontactbyid($contactid)
        {
	    $userid=$this->session->userdata('userid');
            $result=$this->db->query("select * from contacts where user_id='$userid' AND contact_id='$contactid'");
            return $result;
        }
        //End of getcontactbyid Function
/**
     * Function name  : gettheirinterest 
     * Function Use   :This function is use to fetch contact records of particular contact.
     * Function Param :$contactid,$date
     * Return Value:Result. 
     */ 
	public function gettheirinterest($contactid,$date)
        {
            $dateformat=  date('Y-m-d',strtotime ( $date ));
            $userid=$this->session->userdata('userid');
            $result=$this->db->query("select total_her_interest_you from interaction where contact_id='$contactid' AND created_date='$dateformat'");
            return $result;
        }
        //End of gettheirinterest Function
   
        
        /**
     * Function name  : getyourinterest 
     * Function Use   :This function is use to fetch contact records of particular contact.
     * Function Param :$contactid,$date
     * Return Value:Result. 
     */ 
	public function getyourinterest($contactid,$date)
        {
            $dateformat=  date('Y-m-d',strtotime ( $date ));
            $userid=$this->session->userdata('userid');
            $result=$this->db->query("select total_your_interest_her from interaction where contact_id='$contactid' AND created_date='$dateformat'");
            return $result;
        }
        //End of getyourinterest Function
    /**
 * Function name  : getdisplayinterest 
 * Function Use   :This function is use to fetch contact records of particular contact.
 * Function Param :$contactid,$date
 * Return Value:Result. 
 */ 
	public function getdisplayinterest($contactid,$date)
        {
            $dateformat=  date('Y-m-d',strtotime ( $date ));
            $userid=$this->session->userdata('userid');
            $result=$this->db->query("select total_interest_you_display from interaction where contact_id='$contactid' AND created_date='$dateformat'");
            return $result;
        }
        //End of getdisplayinterest Function
    
        
   /**
     * Function name  : getinteraction
     * Function Use   :This function is use to fetch contact records of particular contact.
     * Function Param :$contactid
     * Return Value:Result. 
     */ 
	public function getlastinteraction($contactid,$catid)
        {
	    $userid=$this->session->userdata('userid');
            $result=$this->db->query("select max(created_date) as Created_Date from interaction where contact_id='$contactid' AND cat_id='$catid' AND user_id='$userid'");
            $createddate=$result->row()->Created_Date;
           return $createddate;
        }
        //End of getlastinteraction Function
     
    /**
     * Function name  : getinterest 
     * Function Use   :This function is use to fetch contact records of particular contact.
     * Function Param :$contactid,$date
     * Return Value:Result. 
     */ 
	public function getinterest($contactid,$date)
        {
            $dateformat=  date('Y-m-d',strtotime ( $date ));
            $userid=$this->session->userdata('userid');
            $result=$this->db->query("select total_her_interest_you,total_interest_you_display,total_your_interest_her from interaction where contact_id='$contactid' AND created_date='$dateformat'");
            return $result;
        }
        //End of getinterest Function
       /**
     * Function name  : checkcreateddate 
     * Function Use   :This function is use to check created date.
     * Function Param :$contactid
     * Return Value:Result. 
     */   
       public function checkcreateddate($contactid=0)
        {
            $result=$this->db->query("select created_date from contacts where contact_id='$contactid'");
            $createddate=$result->row()->created_date;
            return $createddate;
        }
    
    /**
     * Function name  :  gettotaltheirinterest
     * Function Use   :This function is use to sum the therir interest.
     * Function Param :$contactid
     * Return Value:Result. 
     */   
       public function gettotaltheirinterest($contactid=0,$Date="")
        {
           if($Date!="")
           {
               $query="SELECT SUM(total_her_interest_you) as TotalTheirInterest FROM interaction where contact_id='$contactid' AND created_date='$Date'";
           }
           else
           {
               $query="SELECT SUM(total_her_interest_you) as TotalTheirInterest FROM interaction where contact_id='$contactid'";
           }
                $result=$this->db->query($query);
                return $result;
        }
    /**
     * Function name  :  gettotaltheirinterest
     * Function Use   :This function is use to sum the their interest.
     * Function Param :$contactid
     * Return Value:Result. 
     */   
       public function gettotaltheirinterestbydate($contactid=0)
        {
            $result=$this->db->query("SELECT SUM(total_her_interest_you) as TotalTheirInterest FROM interaction where contact_id='$contactid'");
            return $result;
        }
    /**
     * Function name  :  gettotalinterestyoudisplay
     * Function Use   :This function is use to sum the Interest You Display.
     * Function Param :$contactid
     * Return Value:Result. 
     */   
       public function gettotalinterestyoudisplay($contactid=0)
        {
            $result=$this->db->query("SELECT SUM(total_your_interest_her) as TotalInterestYouDisplay FROM interaction where contact_id='$contactid'");
            return $result;
        }
    /**
     * Function name  :  deletecontact
     * Function Use   :This function is use to delete contact
     * Function Param :$contactid
     * Return Value:Result. 
     */   
       public function deletecontact($contactid=0)
        {
            $userid=$this->session->userdata('userid');
            $result=$this->db->query("delete from contacts where contact_id='$contactid' AND user_id='$userid'");
            $result=$this->db->query("delete from interaction where contact_id='$contactid' AND user_id='$userid'");
            return $result;
        }
     /**
     * Function name  :  GetTotalHerInterest($contactid,$fromdate)
     * Function Use   :This function is use to get the total of her interest.
     * Return Value:Result. 
     */   
       public function GetTotalHerInterest($contactid=0,$date="")
        {
           $date= date('Y-m-d',strtotime ( $date ));
            $userid=$this->session->userdata('userid');
            $result=$this->db->query("SELECT sum(total_her_interest_you) TotalHerInterest FROM interaction WHERE contact_id='$contactid' AND `created_date`<='$date' ");
            return $result;
        }
     /**
     * Function name  :  GetInterestYouDIsplay($contactid,$fromdate)
     * Function Use   :This function is use to get the total of her interest.
     * Return Value:Result. 
     */   
       public function GetInterestYouDIsplay($contactid=0,$date="")
        {
           $date= date('Y-m-d',strtotime ( $date ));
            $userid=$this->session->userdata('userid');
            $result=$this->db->query("SELECT sum(total_interest_you_display) TotalInterestDisplay FROM interaction WHERE contact_id='$contactid' AND `created_date`<='$date' ");
            return $result;
        }
        

         
      public function addfacebookcontact($name,$gender,$pic,$fbId)
	{

            $userid=$this->session->userdata('userid');

       

            $query=$this->db->query("INSERT INTO `contacts`(user_id,contact_name, gender,image_url,fb_id) 

             VALUES ('$userid','$name','$gender','$pic','$fbId')");

           return $query;

        }

public function getfacebookcontacts($fbId)

	{

            $userid=$this->session->userdata('userid');

            $result=$this->db->query("select * from contacts where user_id='$userid' and fb_id='$fbId'");

            return $result;

        }






}
  