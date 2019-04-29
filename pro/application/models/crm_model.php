<?php

if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}
/**
 *  This is crmlite model class file.
 *
 *  @PHP > 5.2
 *
 *  @version 1.0
 *
 *  @author Bineet Kumar Chaubey
 *
 *  @package Codeigniter
 *  @subpackage salescripter
 *
 *  @link
 *  @see
 */
class Crm_model extends CI_Model
{
    /**
     * Properties
     */
    private $_table_users;

    private $_table_campaign;

    private $_table_crm_contacts;

    private $_table_crm_address;

    private $_table_crm_accounts;

    private $_table_crm_leads;

    private $_table_crm_oppurtinity;

    private $_table_crm_notes;

    private $_table_crm_tasks;

    private $_table_user_shared;

    private $_table_prospect_points;

    private $_table_objections_usage;

    private $_table_objections_count;

    private $_table_interaction_usage;

    private $_table_email_templates;

    private $_table_crm_notifies;

    private $_table_crm_schemail;

    private $_table_crm_custom_values;

    private $_table_crm_docs;

    private $_table_crm_category_list;

    private $_table_crm_category_contacts;

    private $_table_crm_email_tasks;

    private $_table_crm_template_tasks;

    private $_table_crm_mlc_lists;

    private $_table_crm_mc_activities;

    private $_table_user_info;

    private $_table_workflow;

    private $_table_wf_autoactions;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        //Define Table names
        $this->_table_users = $this->config->item('table_users');
        $this->_table_campaign = $this->config->item('table_campaigns');
        $this->_table_crm_contacts = $this->config->item('table_crm_contacts');
        $this->_table_crm_address = $this->config->item('table_crm_address');
        $this->_table_crm_accounts = $this->config->item('table_crm_accounts');
        $this->_table_crm_leads = $this->config->item('table_crm_leads');
        $this->_table_crm_oppurtinity = $this->config->item('table_crm_oppurtinity');
        $this->_table_crm_notes = $this->config->item('table_crm_notes');
        $this->_table_sales_prospecting_basics = $this->config->item('sales_prospecting_basics');
        $this->_table_crm_tasks = $this->config->item('table_crm_tasks');
        $this->_table_user_shared = $this->config->item('table_user_shared');
        $this->_table_prospect_points = $this->config->item('table_prospect_points');
        $this->_table_objections_usage = $this->config->item('table_objections_usage');
        $this->_table_objections_count = $this->config->item('table_objections_count');
        $this->_table_interaction_usage = $this->config->item('table_interaction_usage');
        $this->_table_email_templates = $this->config->item('table_email_templates');
        $this->_table_crm_notifies = $this->config->item('table_crm_notifies');
        $this->_table_crm_schemail = $this->config->item('table_crm_schemail');
        $this->_table_crm_custom_values = $this->config->item('table_crm_custom_values');
        $this->_table_crm_docs = $this->config->item('table_crm_docs');
        $this->_table_crm_category_list = $this->config->item('table_crm_category_list');
        $this->_table_crm_category_contacts = $this->config->item('table_crm_category_contacts');
        $this->_table_crm_email_tasks = $this->config->item('table_crm_email_tasks');
        $this->_table_crm_template_tasks = $this->config->item('table_crm_template_tasks');
        $this->_table_crm_mlc_lists = $this->config->item('table_crm_mlc_lists');
        $this->_table_crm_mc_activities = $this->config->item('table_crm_mc_activities');
        $this->_table_user_info = $this->config->item('table_user_info');
        $this->_table_workflow = $this->config->item('table_workflows');
        $this->_table_wf_autoactions = $this->config->item('table_wf_autoactions');
        $this->load->library('session');
    }

    //ADDRESS
    //Save address
    public function save_address($data)
    {
        $this->db->insert($this->_table_crm_address, $data);
    }

    //Get address
    public function get_address($parent_id, $type, $ptype)
    {
        $this->db->where('parent_id', $parent_id);
        $this->db->where('adr_type', $type);
        $this->db->where('parent_type', $ptype);
        $query = $this->db->get($this->_table_crm_address);
        //echo $this->db->last_query()."<br>";exit;
        return $query->row_array();
    }

    //Delete Contact address
    public function delete_address($rec_id, $ptype, $adrtype = '')
    {
        $this->db->where('parent_id', $rec_id);
        $this->db->where('parent_type', $ptype);
        if ($adrtype) {
            $this->db->where('adr_type', $adrtype);
        }
        $this->db->delete($this->_table_crm_address);
    }

    //Get address search for Contact/Account
    public function address_search($data, $atype, $ptype, $users)
    {
        if ($ptype == 'C') {
            $this->db->select("c.contact_id,c.user_first,c.user_last,c.phone,c.account_id,a.account_name,CONCAT((u.first_name),(' '),(u.last_name)) as usrname,c.ipoints as qpoints");
        } else {
            $this->db->select("a.account_id,a.account_name,a.phone,CONCAT((u.first_name),(' '),(u.last_name)) as usrname,a.ipoints as qpoints");
        }
        $this->db->from($this->_table_crm_address . ' ad');
        if ($ptype == 'C') {
            $this->db->join($this->_table_crm_contacts . ' c', 'c.contact_id = ad.parent_id', 'left');
            $this->db->join($this->_table_crm_accounts . ' a', 'a.account_id = c.account_id', 'left');
        } else {
            $this->db->join($this->_table_crm_accounts . ' a', 'a.account_id = ad.parent_id', 'left');
        }
        $this->db->join($this->_table_users . ' u', 'u.user_id = ' . strtolower($ptype) . '.share_user_id', 'left');
        $this->db->where('ad.adr_type', $atype);
        $this->db->where('ad.parent_type', $ptype);
        $this->db->where_in(strtolower($ptype) . '.share_user_id', $users);
        $nc = count($data);
        if ($nc > 1) {
            $ob = '(';
            $cb = ')';
        }
        $n = 0;
        foreach ($data as $ki => $kval) {
            $n++;
            $sb = '';
            if ($n == 1) {
                if ($ki == 'zipcode') {
                    $this->db->where($ob . "ad.$ki='$kval'", null, false);
                } else {
                    $this->db->where($ob . "ad.$ki LIKE '%$kval%'", null, false);
                }
            } else {
                if ($n == $nc && $cb) {
                    $eb = $cb;
                }
                if ($ki == 'zipcode') {
                    $this->db->or_where("ad.$ki='$kval'" . $eb, null, false);
                } else {
                    $this->db->or_where("ad.$ki LIKE '%$kval%'" . $eb, null, false);
                }
            }
        }
        $this->db->group_by('ad.parent_id');
        $this->db->order_by('qpoints', 'desc');
        $query = $this->db->get();
        //echo $this->db->last_query()."<br>";
        return $query->result();
    }

    //End of Address

    //CONTACT
    //Get search list for Contact
    public function contact_search($data, $users)
    {
        //echo '<pre>'; print_r($data); echo '</pre>';
        $this->db->select("c.*,c.contact_id,c.user_first,c.user_last,c.phone,c.account_id,a.account_name,CONCAT((u.first_name),(' '),(u.last_name)) as usrname,c.ipoints as qpoints");
        $this->db->from($this->_table_crm_contacts . ' c');
        $this->db->join($this->_table_crm_accounts . ' a', 'a.account_id = c.account_id', 'left');
        $this->db->join($this->_table_users . ' u', 'u.user_id = c.share_user_id', 'left');
        $this->db->where_in('c.share_user_id', $users);
        $nc = count($data);
        if ($nc > 1) {
            $ob = '(';
            $cb = ')';
        }
        $n = 0;
        foreach ($data as $ki => $kval) {
            $n++;
            $sb = '';
            if ($n == 1) {
                if ($ki == 'birthdate' || $ki == 'email') {
                    $this->db->where($ob . "c.$ki='$kval'", null, false);
                } else {
                    $this->db->where($ob . "c.$ki LIKE '%$kval%'", null, false);
                }
            } else {
                if ($n == $nc && $cb) {
                    $eb = $cb;
                }
                if ($ki == 'birthdate' || $ki == 'email') {
                    $this->db->or_where("c.$ki='$kval'" . $eb, null, false);
                } else {
                    $this->db->or_where("c.$ki LIKE '%$kval%'" . $eb, null, false);
                }
            }
        }
        $this->db->order_by('qpoints', 'desc');
        $query = $this->db->get();
        // echo $this->db->last_query()."<br>";
        //exit;
        return $query->result();
    }

    //Get Contacts list as array
    public function get_all_contacts2($owner = 0, $target = 0, $parent_ids = [0], $limit = 0, $dtwhere = '')
    {
        $this->db->select("c.contact_id,c.user_title,c.user_first,c.user_last,c.phone,c.email,c.unsubscribed,a.account_name,a.account_site,(SELECT CONCAT((u.first_name),(' '),(u.last_name)) from " . $this->_table_users . ' u where u.user_id = c.share_user_id) as usrname,(SELECT SUM(intpoints) FROM ' . $this->_table_prospect_points . " p WHERE p.rctype='C' and p.contact=c.contact_id) as qpoints");
        //$this->db->select($this->_table_crm_contacts.'.*,'.$this->_table_crm_accounts.'.account_name,'.$this->_table_crm_accounts.'.account_site');
        if ($target) {
            $user_id = $_SESSION['ss_user_id'];
            /*if($parent_ids) $this->db->where_in('c.share_user_id', $parent_ids);
            else $this->db->where("(c.userid=$user_id OR c.share_user_id=$user_id)");*/
            $this->db->where('c.share_user_id', $user_id);
            $this->db->where('c.target', '1');
        } elseif ($owner) {
            $this->db->where('c.share_user_id', $owner);
        } else {
            //$user_id =  $_SESSION['ss_user_id'];
            //$this->db->where('c.userid', $user_id);
            $this->db->where_in('c.userid', $parent_ids);
        }
        $this->db->from($this->_table_crm_contacts . ' c');
        $this->db->join($this->_table_crm_accounts . ' a', 'a.account_id = c.account_id', 'left');
        //$this->db->join($this->_table_users." u", 'u.user_id = c.share_user_id','left');
        if ($dtwhere) {
            $this->db->where($dtwhere, null, false);
        }
        if ($limit) {
            $this->db->limit($limit);
        }
		
        if ($dtwhere) {
            $this->db->order_by('qpoints', 'desc');
        } elseif ($limit) {
            $this->db->order_by('c.user_first', 'asc');
        } else {
            $this->db->order_by('qpoints', 'desc');
        }
        $query = $this->db->get();
        //echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
    }

    public function getContactDetails()
    {
        $response = [];
        $user_id = $_SESSION['ss_user_id'];
        // Select record
        $this->db->select('user_prefix,user_first,user_last,user_title,department,birthdate,lead_source,phone,home_phone,mobile,other_phone,fax,email,assistant,asst_phone,description,create_date,modify_date,unsubscribed,linkedin,website,ipoints,ppoints,mailchimp_last_time,mailchimp_cron_time,mailchimp_cron,mailchimp_list,mailchimp_list_cron');
        $this->db->where_in('userid', $user_id);
        $this->db->order_by('contact_id', 'asc');
        $q = $this->db->get('crm_contacts');
        $response = $q->result_array();

        return $response;
    }

    public function getAccountDetails()
    {
        $response = [];
        $user_id = $_SESSION['ss_user_id'];
        // Select record
        $this->db->select('account_id,userid,share_user_id,account_name,account_parent,account_number,account_site,account_type,industry,revenue,rating,phone,fax,website,ticker_symbol,ownership,employees,siccode,customer_priority,sla_expdate,numlocations,active,sla,sla_serialno,upsell_oppt,description,create_date,modify_date,target,sfid,ipoints,ppoints');
        $this->db->where_in('userid', $user_id);
        $this->db->order_by('account_id', 'asc');
        $q = $this->db->get('crm_accounts');
        $response = $q->result_array();

        return $response;
    }

    //Get Contacts list as array
    public function get_all_contacts_BACKUP($owner = 0, $target = 0, $parent_ids = [0], $limit = 0, $dtwhere = '', $offset = false)
    {
        $this->db->select("c.contact_id,c.user_title,c.user_first,c.user_last,c.phone,c.email,c.unsubscribed,a.account_name,a.account_site,CONCAT((u.first_name),(' '),(u.last_name)) as usrname,(SELECT SUM(intpoints) FROM " . $this->_table_prospect_points . " p WHERE p.rctype='C' and p.contact=c.contact_id) as qpoints");

        //$this->db->select("c.contact_id,c.user_title,c.user_first,c.user_last,c.phone,c.email,c.unsubscribed,a.account_name,a.account_site,CONCAT((u.first_name),(' '),(u.last_name)) as usrname,c.contact_id as qpoints");
        //$this->db->select($this->_table_crm_contacts.'.*,'.$this->_table_crm_accounts.'.account_name,'.$this->_table_crm_accounts.'.account_site');
        if ($target) {
            $user_id = $_SESSION['ss_user_id'];
            /*if($parent_ids) $this->db->where_in('c.share_user_id', $parent_ids);
            else $this->db->where("(c.userid=$user_id OR c.share_user_id=$user_id)");*/
            $this->db->where('c.share_user_id', $user_id);
            $this->db->where('c.target', '1');
        } elseif ($owner) {
            $this->db->where('c.share_user_id', $owner);
        } else {
            //$user_id =  $_SESSION['ss_user_id'];
            //$this->db->where('c.userid', $user_id);
            $this->db->where_in('c.userid', $parent_ids);
        }
        $this->db->from($this->_table_crm_contacts . ' c');
        $this->db->join($this->_table_crm_accounts . ' a', 'a.account_id = c.account_id', 'left');
        $this->db->join($this->_table_users . ' u', 'u.user_id = c.share_user_id', 'left');
        if ($dtwhere) {
            $this->db->where($dtwhere, null, false);
        }
        if ($dtwhere) {
            $this->db->order_by('qpoints', 'desc');
        } elseif ($limit && $offset === false) {
            $this->db->order_by('c.user_first', 'asc');
        } else {
            $this->db->order_by('qpoints', 'desc');
        }
        //if($limit) $this->db->limit($limit,$offset);
        if ($limit) {
            $this->db->limit($limit);
        }
        if ($offset) {
            $this->db->offset($offset);
        }
        $query = $this->db->get();

        //echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
    }

    //Get Contacts list as array
    public function get_all_contacts($owner = 0, $target = 0, $parent_ids = [0], $limit = 0, $dtwhere = '', $offset = false, $category = 0, $sortcol = '', $sortval = 'asc')
    {
        // $this->db->select("c.contact_id,c.user_title,c.user_first,c.user_last,c.phone,c.email,c.unsubscribed,a.account_name,a.account_site,CONCAT((u.first_name),(' '),(u.last_name)) as usrname,(SELECT SUM(intpoints) FROM ".$this->_table_prospect_points." p WHERE p.rctype='C' and p.contact=c.contact_id) as qpoints");

        //$this->db->select("c.contact_id,c.user_title,c.user_first,c.user_last,c.phone,c.email,c.unsubscribed,a.account_name,a.account_site,CONCAT((u.first_name),(' '),(u.last_name)) as usrname,c.contact_id as qpoints");
        //$this->db->select($this->_table_crm_contacts.'.*,'.$this->_table_crm_accounts.'.account_name,'.$this->_table_crm_accounts.'.account_site');

        /*if($target) {
            $user_id =  $_SESSION['ss_user_id'];
            if($parent_ids) $this->db->where_in('c.share_user_id', $parent_ids);
            else $this->db->where("(c.userid=$user_id OR c.share_user_id=$user_id)");
            if($parent_ids) $this->db->where_in("c.share_user_id",$parent_ids);
            else $this->db->where("c.share_user_id",$user_id);
            $this->db->where('c.target', '1');
        } else if($owner) {
            $this->db->where('c.share_user_id', $owner);
        } else {
            $user_id =  $_SESSION['ss_user_id'];
            $this->db->where('c.userid', $user_id);
            $this->db->where_in('c.userid', $parent_ids);
        }*/

        $user_id = $_SESSION['ss_user_id'];
        $this->db->select('count(userfrom) as qrcount,userfrom,accessview');
        $this->db->from('tbl_user_shared');
        $this->db->where('userto', $user_id);
        $record = $this->db->get();
        $result = $record->row_array();
        $count = $result['qrcount'];
        if ($count > 0) {
            $shuser = $result['userfrom'];
            $accessview = $result['accessview'];
        } else {
            $shuser = $user_id;
        }

        $this->db->select("c.*,c.contact_id,c.user_title,c.user_first,c.user_last,c.phone,c.email,c.unsubscribed,a.account_name,a.account_site,CONCAT((u.first_name),(' '),(u.last_name)) as usrname,c.ipoints as qpoints");

        if ($target) {
            $user_id = $_SESSION['ss_user_id'];
            /*if($parent_ids) $this->db->where_in('c.share_user_id', $parent_ids);
            else $this->db->where("(c.userid=$user_id OR c.share_user_id=$user_id)");*/
            if ($accessview == 'Own') {
                $this->db->where('c.share_user_id', $user_id);
                $this->db->where('c.target', '1');
            } else {
                $user_id = $_SESSION['ss_user_id'];
                if ($parent_ids) {
                    $this->db->where_in('c.share_user_id', $parent_ids);
                } else {
                    $this->db->where("(c.userid=$user_id OR c.share_user_id=$user_id)");
                }
                $this->db->where('c.target', '1');
            }
        }

        if ($owner) {
            $user_id = $_SESSION['ss_user_id'];
            //$this->db->where('c.userid', $user_id);
            $this->db->where('c.share_user_id', $user_id);
        } else {
            $user_id = $_SESSION['ss_user_id'];
            if ($accessview == 'Own') {
                $this->db->where('c.share_user_id', $user_id);
            } elseif ($accessview == 'All') {
                $this->db->where("(c.userid='" . $user_id . "' OR c.share_user_id='" . $shuser . "')", null, false);
            } else {
                $this->db->where_in('c.userid', $parent_ids);
            }
        }

        if ($category) {
            $this->db->from($this->_table_crm_category_contacts . ' cr');
            $this->db->join($this->_table_crm_contacts . ' c', 'c.contact_id = cr.record_id', 'left');
        } else {
            $this->db->from($this->_table_crm_contacts . ' c');
        }
        $this->db->join($this->_table_crm_accounts . ' a', 'a.account_id = c.account_id', 'left');
        $this->db->join($this->_table_users . ' u', 'u.user_id = c.share_user_id', 'left');
        if ($category) {
            $this->db->where('cr.category_id', $category);
        }
        if ($dtwhere) {
            $this->db->where($dtwhere, null, false);
        }
		
		
		$this->db->order_by("c.ipoints","desc");	

        /*if ($sortcol) {
            $this->db->order_by($sortcol, $sortval);
        } else {
            if ($dtwhere) {
                $this->db->order_by('c.contact_id', 'asc');
            } elseif ($limit && $offset === false) {
                $this->db->order_by('c.user_first', 'asc');
            } else {
                $this->db->order_by('c.contact_id', 'asc');
            }
        }*/

        //if($limit) $this->db->limit($limit,$offset);
        if ($limit) {
            $this->db->limit($limit);
        }
        if ($offset) {
            $this->db->offset($offset);
        }
        $query = $this->db->get();

        //echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
    }

    public function get_contact_searchlist()
    {
    }

    public function get_selected_custom_fields()
    {
        $user_id = $_SESSION['ss_user_id'];
        $wherec = [];
        $wherec['user_id'] = $this->_user_id;
        $wherec['field_type'] = 'column';
        $user_infoc = $this->home->getUserData($wherec);
        if ($user_infoc) {
            $user_infoc = $user_infoc[0];
        }
        $layout_fields = col_fields();
        $layout_keys = array_keys($layout_fields);
        $contact_fields = [];
        //echo '<pre>'; print_r($layout_keys); echo '</pre>';

        if (isset($user_infoc->value) && $user_infoc->value) {
            //echo "Values in Database";
            $contact_fields = json_decode($user_infoc->value);
            $contact_fields = (array)$contact_fields;
        }
        if (!$contact_fields) {
            //echo "No Values in Database";
            //echo '<pre>'; print_r($layout_keys); echo '</pre>';

            $contact_fields = [];
            foreach ($layout_keys as $key => $value) {
                if ($value == 'user_first' || $value == 'user_title' || $value == 'account_id' || $value == 'phone' || $value == 'email' || $value == 'ipoints') {
                    $contact_fields[$key] = $value;
                }
            }
        }

        //echo '<pre>'; print_r($contact_fields); echo '</pre>';

        $res_arr_keys = [];

        foreach ($contact_fields as $kk => $val) {
            $res_arr_keys[$val] = $val;
        }

        return $res_arr_keys;
    }

    public function get_all_contactslist($owner = 0, $target = 0, $parent_ids = [0], $limit = 0, $dtwhere = '', $offset = false, $category = 0, $sortcol = '', $sortval = 'asc')
    {
        $user_id = $_SESSION['ss_user_id'];

        // $this->db->select("c.contact_id,c.user_title,c.user_first,c.user_last,c.phone,c.email,c.unsubscribed,a.account_name,a.account_site,CONCAT((u.first_name),(' '),(u.last_name)) as usrname,(SELECT SUM(intpoints) FROM ".$this->_table_prospect_points." p WHERE p.rctype='C' and p.contact=c.contact_id) as qpoints");

        //$this->db->select("c.contact_id,c.user_title,c.user_first,c.user_last,c.phone,c.email,c.unsubscribed,a.account_name,a.account_site,CONCAT((u.first_name),(' '),(u.last_name)) as usrname,c.contact_id as qpoints");
        //$this->db->select($this->_table_crm_contacts.'.*,'.$this->_table_crm_accounts.'.account_name,'.$this->_table_crm_accounts.'.account_site');

        /*$this->db->select("c.contact_id,c.user_title,c.user_first,c.user_last,c.phone,c.email,c.unsubscribed,a.account_name,a.account_site,CONCAT((u.first_name),(' '),(u.last_name)) as usrname,c.ipoints as qpoints");
        if($target) {
            $user_id =  $_SESSION['ss_user_id']; */
        /*if($parent_ids) $this->db->where_in('c.share_user_id', $parent_ids);
        else $this->db->where("(c.userid=$user_id OR c.share_user_id=$user_id)");*/
        /*if($parent_ids) $this->db->where_in("c.share_user_id",$parent_ids);
        else $this->db->where("c.share_user_id",$user_id);
        $this->db->where('c.target', '1');
        } else if($owner) {
        $this->db->where('c.share_user_id', $owner);
        } else {
        //$user_id =  $_SESSION['ss_user_id'];
        //$this->db->where('c.userid', $user_id);
        $this->db->where_in('c.userid', $parent_ids);
        }
        if($category) {
        $this->db->from($this->_table_crm_category_contacts." cr");
        $this->db->join($this->_table_crm_contacts." c", 'c.contact_id = cr.record_id','left');
        } else {
        $this->db->from($this->_table_crm_contacts." c");
        }
        $this->db->join($this->_table_crm_accounts." a", 'a.account_id = c.account_id','left');
        $this->db->join($this->_table_users." u", 'u.user_id = c.share_user_id','left');
        if($category) $this->db->where("cr.category_id",$category);
        if($dtwhere) $this->db->where($dtwhere,NULL,FALSE);

        if($sortcol) {
        $this->db->order_by($sortcol,$sortval);
        } else {
        if($dtwhere) $this->db->order_by("qpoints","desc");
        else if($limit && $offset===FALSE) $this->db->order_by("c.user_first","asc");
        else $this->db->order_by("qpoints","desc");
        } */

        //if($limit) $this->db->limit($limit,$offset);
        //if($limit) $this->db->limit($limit);
        //if($offset) $this->db->offset($offset);

        $wherec = [];
        $wherec['user_id'] = $this->_user_id;
        $wherec['field_type'] = 'column';
        $user_infoc = $this->home->getUserData($wherec);
        if ($user_infoc) {
            $user_infoc = $user_infoc[0];
        }
        $layout_fields = col_fields();
        $layout_keys = array_keys($layout_fields);
        $contact_fields = [];
        //echo '<pre>'; print_r($layout_keys); echo '</pre>';

        if (isset($user_infoc->value) && $user_infoc->value) {
            //echo "Values in Database";
            $contact_fields = json_decode($user_infoc->value);
            $contact_fields = (array)$contact_fields;
        }
        if (!$contact_fields) {
            //echo "No Values in Database";
            //echo '<pre>'; print_r($layout_keys); echo '</pre>';

            $contact_fields = [];
            foreach ($layout_keys as $key => $value) {
                if ($value == 'user_first' || $value == 'user_title' || $value == 'account_id' || $value == 'phone' || $value == 'email' || $value == 'ipoints') {
                    $contact_fields[$key] = $value;
                }
            }
        }

        //echo '<pre>'; print_r($contact_fields); echo '</pre>';

        $out = [];
        $layout_out = [];
        foreach ($contact_fields as $key => $value) {
            $out[$value] = $value;
        }

        foreach ($layout_keys as $key => $value) {
            $layout_out[$value] = $value;
        }

        //echo '<pre>'; print_r($out); echo '</pre>';
        //echo '<pre>'; print_r($layout_out); echo '</pre>';

        $res_arr_keys = [];

        //echo '<pre>'; print_r($contact_fields); echo '</pre>';

        ///ss//// SELECT `c`.`contact_id`, CONCAT((c.user_first), (' '), (c.user_last)) as user_first, `c`.`birthdate`, (SELECT account_name FROM crm_accounts WHERE account_id=c.account_id) as account_id, `c`.`phone`, `c`.`email`, `c`.`ipoints`, (Select cval from  crm_custom_values where ckey='field9' and section='C' and recid=c.contact_id) FROM (`crm_contacts` c) WHERE `c`.`userid` = '2910'

        foreach ($contact_fields as $kk => $val) {

            //if (array_key_exists($kk,$out))
            //{
            $res_arr_keys[$val] = $val;
            //}
        }

        //echo '<pre>'; print_r($contact_fields); echo '</pre>';

        //	echo '<pre>'; print_r($res_arr_keys); echo '</pre>';
        $sel_left_q_add = '';
        $sel_left_q_acc = '';
        $sel_left_q_custom = [];
        $sel_q = ' c.contact_id ';
        $ik = 0;
        foreach ($res_arr_keys as $kk => $val) {
            $ik = $ik + 1;
            if ($kk == 'target' || $kk == 'linkedin' || $kk == 'birthdate' || $kk == 'website' || $kk == 'lead_source' || $kk == 'user_title' || $kk == 'department' || $kk == 'create_date' || $kk == 'mobile' || $kk == 'phone' || $kk == 'assistant' || $kk == 'unsubscribed' || $kk == 'email' || $kk == 'asst_phone' || $kk == 'other_phone' || $kk == 'description' || $kk == 'ipoints' || $kk == 'ppoints') {
                if ($sel_q) {
                    $sel_q .= ',';
                }
                $sel_q .= ' c.' . $kk;
            } elseif ($kk == 'user_first') {
                if ($sel_q) {
                    $sel_q .= ',';
                }
                $sel_q .= " CONCAT((c.user_first), (' '), (c.user_last)) as  user_first";
            } elseif ($kk == 'account_id') {
                if ($sel_q) {
                    $sel_q .= ',';
                }
                // $sel_q .= ' (SELECT account_name FROM crm_accounts WHERE account_id=c.account_id) as account_id ';
                $sel_q .= ' ca.account_id as account_id ';
                $sel_left_q_acc = ' LEFT JOIN crm_accounts ca ON c.contact_id = ca.account_id ';
            } elseif ($kk == 'address') {
                if ($sel_q) {
                    $sel_q .= ',';
                }
                $sel_q .= ' cad.city as address ';
                //$sel_q .= ' (SELECT city FROM crm_address WHERE parent_id=c.contact_id) as address ';
                $sel_left_q_add = ' LEFT JOIN crm_address cad ON c.contact_id = cad.parent_id ';
            } elseif ($kk == 'first_name') {
                if ($sel_q) {
                    $sel_q .= ',';
                }
                $sel_q .= " (SELECT CONCAT((u.first_name),(' '),(u.last_name)) from  users u where u.user_id = c.share_user_id) as first_name ";
            } elseif ($kk == 'report_id') {
                if ($sel_q) {
                    $sel_q .= ',';
                }
                $sel_q .= " CONCAT((c.user_first), (' '), (c.user_last)) as report_id ";
            } else {
                if ($sel_q) {
                    $sel_q .= ',';
                }
                // $sel_q .= ' (SELECT cval FROM crm_custom_values  where ckey="'.$val.'" and section="C" and recid=c.contact_id) as '.$kk;

                $sel_q .= " cv$ik.cval AS $kk ";
                $sel_left_q_custom[$ik] = ' INNER JOIN crm_custom_values AS $kk ON ( c.contact_id = mt$ik.recid AND mt$ik.ckey =  "$val" AND mt$ik.section =  "C" )';
                $sel_left_q_custom[$ik] = $val;
            }

            /*else
            {
                if($sel_q) $sel_q .= ",";
                $sel_q .= ' (SELECT cval FROM crm_custom_values WHERE user_id='.$user_id.' AND recid='.$user_id.' AND ckey="") as address ';
            }*/
        }

        //echo $sel_q;

        //print_r($out);
        //print_r($layout_out);

        // $this->db->select("c.contact_id, c.target, (SELECT city FROM crm_address WHERE parent_id=c.contact_id) as Address, (SELECT CONCAT((u.first_name),(' '),(u.last_name)) from ".$this->_table_users." u where u.user_id = c.share_user_id) as usrname,  CONCAT((c.user_first), (' '), (c.user_last)) as nname, c.linkedin, c.birthdate, (SELECT account_name FROM crm_accounts WHERE account_id=c.account_id) as Addresstwo, c.website, c.lead_source, c.user_title, c.department, c.create_date, c.phone, c.modify_date, c.mobile, c.assistant, c.unsubscribed, c.email, c.asst_phone, c.other_phone, c.description, c.ipoints, c.ppoints");

        $this->db->select($sel_q);

        if (count($sel_left_q_custom) > 0) {
            foreach ($sel_left_q_custom as $ke => $val) {
                $this->db->join("crm_custom_values cv$ke", "cv$ke.recid = c.contact_id AND  cv$ke.ckey = '$val' AND cv$ke.section = 'C'");
            }
        }
        if ($sel_left_q_acc) {
            $this->db->join('crm_accounts ca', 'c.contact_id = ca.account_id', 'left');
        }
        if ($sel_left_q_add) {
            $this->db->join('crm_address cad', 'c.contact_id = cad.parent_id', 'left');
        }

        if ($dtwhere) {
            $this->db->where($dtwhere, null, false);
        }

        $this->db->where('c.userid', $user_id);

        //SELECT `c`.`contact_id`, `c`.`target`, (SELECT city FROM crm_address WHERE parent_id=c.contact_id) as Address, (SELECT CONCAT((u.first_name), (' '), (u.last_name)) from users u where u.user_id = c.share_user_id) as usrname, CONCAT(c.user_first, (' '), c.user_last) AS Name, `c`.`linkedin`, `c`.`birthdate`, (SELECT account_name FROM crm_accounts WHERE account_id=c.account_id) as Addresstwo, `c`.`website`, `c`.`lead_source`, `c`.`user_title`, `c`.`department`, `c`.`create_date`, `c`.`phone`, `c`.`modify_date`, `c`.`mobile`, `c`.`assistant`, `c`.`unsubscribed`, `c`.`email`, `c`.`asst_phone`, `c`.`other_phone`, `c`.`description`, `c`.`ipoints`, `c`.`ppoints` FROM (`crm_contacts` c)

        //$this->db->select("c.contact_id,c.user_title,c.user_first,c.user_last,c.phone,c.email,c.unsubscribed,a.account_name,a.account_site,(SELECT CONCAT((u.first_name),(' '),(u.last_name)) from ".$this->_table_users." u where u.user_id = c.share_user_id) as usrname,(SELECT SUM(intpoints) FROM ".$this->_table_prospect_points." p WHERE p.rctype='C' and p.contact=c.contact_id) as qpoints");
        if ($sortcol) {
            $this->db->order_by($sortcol, $sortval);
        }

        $this->db->from($this->_table_crm_contacts . ' c');

        //$query = "SELECT c.contact_id, c.target, (SELECT city FROM crm_address WHERE parent_id=c.contact_id) as Address, (SELECT CONCAT (first_name, ' ', last_name)  FROM  users WHERE user_id=c.share_user_id) as ContactOwner,  CONCAT(c.user_first, ' ', c.user_last) AS Name, c.linkedin, c.birthdate, (SELECT account_name FROM crm_accounts WHERE account_id=c.account_id) as Address, c.website, c.lead_source, c.user_title, c.department, c.create_date, c.phone, c.modify_date, c.mobile, c.assistant, c.unsubscribed, c.email, c.asst_phone, c.other_phone, c.description, c.ipoints, c.ppoints  FROM crm_contacts c";

        if ($limit) {
            $this->db->limit($limit);
        }
        if ($offset) {
            $this->db->offset($offset);
        }
        $query = $this->db->get();

        //	echo $this->db->last_query();

        // echo "<pre>"; print_r($res_arr_keys);  echo "</pre>"; exit;

        //exit;

        $res = [];

        $res['contact'] = $res_arr_keys;
        $res['rowres'] = $query->result();

        //echo "<pre>"; print_r($res);  echo "</pre>"; exit;

        if ($query->num_rows() > 0) {
            return $res;
        }
    }

    public function get_custom_val_option($key, $id)
    {
        $user_id = $_SESSION['ss_user_id'];
        $this->db->select('cval as cv');
        //$this->db->where('userid', $user_id);
        $this->db->where('ckey', $key);
        $this->db->where('recid', $id);
        $this->db->where('section', 'C');
        $this->db->where('user_id', $user_id);
        $query = $this->db->get($this->_table_crm_custom_values);
        //echo $this->db->last_query().'--';
        if ($query->num_rows() > 0) {
            return $query->result();
        }

        return [];
    }

    public function get_custom_account_val_option($key, $id)
    {
        $user_id = $_SESSION['ss_user_id'];
        $this->db->select('cval as cv');
        //$this->db->where('userid', $user_id);
        $this->db->where('ckey', $key);
        $this->db->where('recid', $id);
        $this->db->where('section', 'A');
        $this->db->where('user_id', $user_id);
        $query = $this->db->get($this->_table_crm_custom_values);
        echo $this->db->last_query() . '--';
        if ($query->num_rows() > 0) {
            return $query->result();
        }

        return [];
    }

    public function get_all_contacts_total_latestnew($owner = 0, $target = 0, $parent_ids = [0], $limit = 0, $dtwhere = '', $offset = false, $category = 0, $sortcol = '', $sortval = 'asc')
    {
        $user_id = $_SESSION['ss_user_id'];

        $wherec = [];
        $wherec['user_id'] = $this->_user_id;
        $wherec['field_type'] = 'column';
        $user_infoc = $this->home->getUserData($wherec);
        if ($user_infoc) {
            $user_infoc = $user_infoc[0];
        }
        $layout_fields = col_fields();
        $layout_keys = array_keys($layout_fields);
        $contact_fields = [];
        //echo '<pre>'; print_r($layout_keys); echo '</pre>';

        if (isset($user_infoc->value) && $user_infoc->value) {
            //echo "Values in Database";
            $contact_fields = json_decode($user_infoc->value);
            $contact_fields = (array)$contact_fields;
        }
        if (!$contact_fields) {
            //echo "No Values in Database";
            //echo '<pre>'; print_r($layout_keys); echo '</pre>';

            $contact_fields = [];
            foreach ($layout_keys as $key => $value) {
                if ($value == 'user_first' || $value == 'user_title' || $value == 'account_id' || $value == 'phone' || $value == 'email' || $value == 'ipoints') {
                    $contact_fields[$key] = $value;
                }
            }
        }

        //echo '<pre>'; print_r($contact_fields); echo '</pre>';

        $out = [];
        $layout_out = [];
        foreach ($contact_fields as $key => $value) {
            $out[$value] = $value;
        }

        foreach ($layout_keys as $key => $value) {
            $layout_out[$value] = $value;
        }

        $res_arr_keys = [];

        foreach ($contact_fields as $kk => $val) {

            //if (array_key_exists($kk,$out))
            //{
            $res_arr_keys[$val] = $val;
            //}
        }

        //	echo '<pre>'; print_r($res_arr_keys); echo '</pre>';
        $sel_left_q_add = '';
        $sel_left_q_acc = '';
        $sel_left_q_custom = [];
        $sel_q = ' c.contact_id ';

        $ik = 0;
        foreach ($res_arr_keys as $kk => $val) {
            $ik = $ik + 1;
            if ($kk == 'target' || $kk == 'linkedin' || $kk == 'birthdate' || $kk == 'website' || $kk == 'lead_source' || $kk == 'user_title' || $kk == 'department' || $kk == 'create_date' || $kk == 'mobile' || $kk == 'phone' || $kk == 'assistant' || $kk == 'unsubscribed' || $kk == 'email' || $kk == 'asst_phone' || $kk == 'other_phone' || $kk == 'description' || $kk == 'ipoints' || $kk == 'ppoints') {
                if ($sel_q) {
                    $sel_q .= ',';
                }
                $sel_q .= ' c.' . $kk;
            } elseif ($kk == 'user_first') {
                if ($sel_q) {
                    $sel_q .= ',';
                }
                $sel_q .= " CONCAT((c.user_first), (' '), (c.user_last)) as  user_first";
            } elseif ($kk == 'account_id') {
                if ($sel_q) {
                    $sel_q .= ',';
                }
                // $sel_q .= ' (SELECT account_name FROM crm_accounts WHERE account_id=c.account_id) as account_id ';
                $sel_q .= ' ca.account_id as account_id ';
                $sel_left_q_acc = ' LEFT JOIN crm_accounts ca ON c.contact_id = ca.account_id ';
            } elseif ($kk == 'address') {
                if ($sel_q) {
                    $sel_q .= ',';
                }
                $sel_q .= ' cad.city as address ';
                //$sel_q .= ' (SELECT city FROM crm_address WHERE parent_id=c.contact_id) as address ';
                $sel_left_q_add = ' LEFT JOIN crm_address cad ON c.contact_id = cad.parent_id ';
            } elseif ($kk == 'first_name') {
                if ($sel_q) {
                    $sel_q .= ',';
                }
                $sel_q .= " (SELECT CONCAT((u.first_name),(' '),(u.last_name)) from  users u where u.user_id = c.share_user_id) as first_name ";
            } elseif ($kk == 'report_id') {
                if ($sel_q) {
                    $sel_q .= ',';
                }
                $sel_q .= " CONCAT((c.user_first), (' '), (c.user_last)) as report_id ";
            } else {
                if ($sel_q) {
                    $sel_q .= ',';
                }
                // $sel_q .= ' (SELECT cval FROM crm_custom_values  where ckey="'.$val.'" and section="C" and recid=c.contact_id) as '.$kk;

                $sel_q .= " cv$ik.cval AS $kk ";
                $sel_left_q_custom[$ik] = ' INNER JOIN crm_custom_values AS $kk ON ( c.contact_id = mt$ik.recid AND mt$ik.ckey =  "$val" AND mt$ik.section =  "C" )';
                $sel_left_q_custom[$ik] = $val;
            }
        }

        //$this->db->select($sel_q);

        $this->db->select('count(*) as total');

        if (count($sel_left_q_custom) > 0) {
            foreach ($sel_left_q_custom as $ke => $val) {
                $this->db->join("crm_custom_values cv$ke", "cv$ke.recid = c.contact_id AND  cv$ke.ckey = '$val' AND cv$ke.section = 'C'");
            }
        }
        if ($sel_left_q_acc) {
            $this->db->join('crm_accounts ca', 'c.contact_id = ca.account_id', 'left');
        }
        if ($sel_left_q_add) {
            $this->db->join('crm_address cad', 'c.contact_id = cad.parent_id', 'left');
        }

        if ($dtwhere) {
            $this->db->where($dtwhere, null, false);
        }

        $this->db->select('count(userfrom) as qrcount,userfrom,accessview');
        $this->db->from('tbl_user_shared');
        $this->db->where('userto', $user_id);
        $record = $this->db->get();
        $result = $record->row_array();
        $count = $result['qrcount'];
        if ($count > 0) {
            $shuser = $result['userfrom'];
            $accessview = $result['accessview'];
        }

        if ($accessview == 'Own') {
            $this->db->where('c.share_user_id', $user_id);
        } elseif ($accessview == 'All') {
            $this->db->where("(c.userid='" . $user_id . "' OR c.share_user_id='" . $shuser . "')", null, false);
        } else {
            $this->db->where('c.userid', $user_id);
        }

        //SELECT `c`.`contact_id`, `c`.`target`, (SELECT city FROM crm_address WHERE parent_id=c.contact_id) as Address, (SELECT CONCAT((u.first_name), (' '), (u.last_name)) from users u where u.user_id = c.share_user_id) as usrname, CONCAT(c.user_first, (' '), c.user_last) AS Name, `c`.`linkedin`, `c`.`birthdate`, (SELECT account_name FROM crm_accounts WHERE account_id=c.account_id) as Addresstwo, `c`.`website`, `c`.`lead_source`, `c`.`user_title`, `c`.`department`, `c`.`create_date`, `c`.`phone`, `c`.`modify_date`, `c`.`mobile`, `c`.`assistant`, `c`.`unsubscribed`, `c`.`email`, `c`.`asst_phone`, `c`.`other_phone`, `c`.`description`, `c`.`ipoints`, `c`.`ppoints` FROM (`crm_contacts` c)

        //$this->db->select("c.contact_id,c.user_title,c.user_first,c.user_last,c.phone,c.email,c.unsubscribed,a.account_name,a.account_site,(SELECT CONCAT((u.first_name),(' '),(u.last_name)) from ".$this->_table_users." u where u.user_id = c.share_user_id) as usrname,(SELECT SUM(intpoints) FROM ".$this->_table_prospect_points." p WHERE p.rctype='C' and p.contact=c.contact_id) as qpoints");
        //if($sortcol) {
        //$this->db->order_by($sortcol,$sortval);
        //	}

        $this->db->from($this->_table_crm_contacts . ' c');

        //$query = "SELECT c.contact_id, c.target, (SELECT city FROM crm_address WHERE parent_id=c.contact_id) as Address, (SELECT CONCAT (first_name, ' ', last_name)  FROM  users WHERE user_id=c.share_user_id) as ContactOwner,  CONCAT(c.user_first, ' ', c.user_last) AS Name, c.linkedin, c.birthdate, (SELECT account_name FROM crm_accounts WHERE account_id=c.account_id) as Address, c.website, c.lead_source, c.user_title, c.department, c.create_date, c.phone, c.modify_date, c.mobile, c.assistant, c.unsubscribed, c.email, c.asst_phone, c.other_phone, c.description, c.ipoints, c.ppoints  FROM crm_contacts c";

        //if($limit) $this->db->limit($limit);
        //if($offset) $this->db->offset($offset);
        /*$query = $this->db->get();
        if ($query->num_rows() > 0)
        {
            return $query->num_rows();
            //$row = $query->row_array();
            //return $row['total'];
        }*/

        $query = $this->db->get();
        //echo $this->db->last_query();
        $row = $query->row_array();

        return $row['total'];

        //return 0;
    }

    public function getcontactLabels()
    {
        $user_id = $_SESSION['ss_user_id'];
        $wherec = [];
        $wherec['user_id'] = $this->_user_id;
        $wherec['field_type'] = 'column';
        $user_infoc = $this->home->getUserData($wherec);
        if ($user_infoc) {
            $user_infoc = $user_infoc[0];
        }
        $layout_fields = col_fields();
        $layout_keys = array_keys($layout_fields);
        $contact_fields = [];

        if (isset($user_infoc->value) && $user_infoc->value) {
            //echo "Values in Database";
            $contact_fields = json_decode($user_infoc->value);
            $contact_fields = (array)$contact_fields;
        }
        if (!$contact_fields) {
            $contact_fields = [];
            foreach ($layout_keys as $key => $value) {
                if ($value == 'user_first' || $value == 'user_title' || $value == 'account_id' || $value == 'phone' || $value == 'email' || $value == 'ipoints') {
                    $contact_fields[$key] = $value;
                }
            }
        }

        $res_arr_keys = [];

        foreach ($contact_fields as $kk => $val) {
            $res_arr_keys[$val] = $val;
        }

        return $res_arr_keys;
    }

    public function getaccountLabels()
    {
        $user_id = $_SESSION['ss_user_id'];
        $wherec = [];
        $wherec['user_id'] = $this->_user_id;
        $wherec['field_type'] = 'column_account';
        $user_infoc = $this->home->getUserData($wherec);
        if ($user_infoc) {
            $user_infoc = $user_infoc[0];
        }
        $layout_fields = acol_fields();
        $layout_keys = array_keys($layout_fields);
        $contact_fields = [];

        if (isset($user_infoc->value) && $user_infoc->value) {
            //echo "Values in Database";
            $contact_fields = json_decode($user_infoc->value);
            $contact_fields = (array)$contact_fields;
        }
        if (!$contact_fields) {
            $contact_fields = [];
            foreach ($layout_keys as $key => $value) {
                if ($value == 'account_name' || $value == 'share_user_title' || $value == 'billing' || $value == 'phone' || $value == 'ipoints') {
                    $contact_fields[$key] = $value;
                }
            }
        }

        $res_arr_keys = [];

        foreach ($contact_fields as $kk => $val) {
            $res_arr_keys[$val] = $val;
        }

        return $res_arr_keys;
    }

    public function get_all_contacts_total_latest($owner = 0, $target = 0, $parent_ids = [0], $limit = 0, $dtwhere = '', $offset = false, $category = 0, $sortcol = '', $sortval = 'asc')
    {
        $user_id = $_SESSION['ss_user_id'];
        $this->db->select('count(userfrom) as qrcount,userfrom,accessview');
        $this->db->from('tbl_user_shared');
        $this->db->where('userto', $user_id);
        $record = $this->db->get();
        $result = $record->row_array();
        $count = $result['qrcount'];
        if ($count > 0) {
            $shuser = $result['userfrom'];
            $accessview = $result['accessview'];
        } else {
            $shuser = $user_id;
        }

        $wherec = [];
        $wherec['user_id'] = $this->_user_id;
        $wherec['field_type'] = 'column';
        $user_infoc = $this->home->getUserData($wherec);
        if ($user_infoc) {
            $user_infoc = $user_infoc[0];
        }
        $layout_fields = col_fields();
        $layout_keys = array_keys($layout_fields);
        $contact_fields = [];
        //echo '<pre>'; print_r($layout_keys); echo '</pre>';

        if (isset($user_infoc->value) && $user_infoc->value) {
            //echo "Values in Database";
            $contact_fields = json_decode($user_infoc->value);
            $contact_fields = (array)$contact_fields;
        }
        if (!$contact_fields) {
            //echo "No Values in Database";
            //echo '<pre>'; print_r($layout_keys); echo '</pre>';

            $contact_fields = [];
            foreach ($layout_keys as $key => $value) {
                if ($value == 'user_first' || $value == 'user_title' || $value == 'account_id' || $value == 'phone' || $value == 'email' || $value == 'ipoints') {
                    $contact_fields[$key] = $value;
                }
            }
        }

        //echo '<pre>'; print_r($contact_fields); echo '</pre>';

        $out = [];
        $layout_out = [];
        foreach ($contact_fields as $key => $value) {
            $out[$value] = $value;
        }

        foreach ($layout_keys as $key => $value) {
            $layout_out[$value] = $value;
        }

        $res_arr_keys = [];

        foreach ($contact_fields as $kk => $val) {

            //if (array_key_exists($kk,$out))
            //{
            $res_arr_keys[$val] = $val;
            //}
        }

        //	echo '<pre>'; print_r($res_arr_keys); echo '</pre>';
        $sel_left_q_add = '';
        $sel_left_q_acc = '';
        $sel_left_q_custom = [];
        $sel_q = ' c.contact_id ';

        $ik = 0;
        $points = '';
        foreach ($res_arr_keys as $kk => $val) {
            $ik = $ik + 1;
            if ($kk == 'target' || $kk == 'linkedin' || $kk == 'birthdate' || $kk == 'website' || $kk == 'lead_source' || $kk == 'user_title' || $kk == 'department' || $kk == 'create_date' || $kk == 'mobile' || $kk == 'phone' || $kk == 'assistant' || $kk == 'unsubscribed' || $kk == 'email' || $kk == 'asst_phone' || $kk == 'other_phone' || $kk == 'description' || $kk == 'ipoints' || $kk == 'ppoints') {
                if ($sel_q) {
                    $sel_q .= ',';
                }
                $sel_q .= ' c.' . $kk;

                if ($kk == 'ipoints') {
                    $points = 'S';
                }
            } elseif ($kk == 'user_first') {
                if ($sel_q) {
                    $sel_q .= ',';
                }
                $sel_q .= " CONCAT((c.user_first), (' '), (c.user_last)) as  user_first";
            } elseif ($kk == 'account_id') {
                if ($sel_q) {
                    $sel_q .= ',';
                }
                // $sel_q .= ' (SELECT account_name FROM crm_accounts WHERE account_id=c.account_id) as account_id ';
                $sel_q .= ' ca.account_name as account_id ';
                $sel_left_q_acc = ' LEFT JOIN crm_accounts ca ON c.account_id = ca.account_id ';
            } elseif ($kk == 'address') {
                if ($sel_q) {
                    $sel_q .= ',';
                }
                $sel_q .= ' cad.city as address ';
                //$sel_q .= ' (SELECT city FROM crm_address WHERE parent_id=c.contact_id) as address ';
                $sel_left_q_add = ' LEFT JOIN crm_address cad ON c.contact_id = cad.parent_id ';
            } elseif ($kk == 'share_user_title') {
                if ($sel_q) {
                    $sel_q .= ',';
                }
                $sel_q .= " (SELECT CONCAT((u.first_name),(' '),(u.last_name)) from  users u where u.user_id = c.share_user_id) as share_user_title ";
            } elseif ($kk == 'first_name') {
                if ($sel_q) {
                    $sel_q .= ',';
                }
                $sel_q .= " (SELECT CONCAT((u.first_name),(' '),(u.last_name)) from  users u where u.user_id = c.share_user_id) as first_name ";
            } elseif ($kk == 'report_id') {
                if ($sel_q) {
                    $sel_q .= ',';
                }
                $sel_q .= " CONCAT((c.user_first), (' '), (c.user_last)) as report_id ";
            } else {

            /*	$num = 0;
                $num = $this->getcustomDbfield($val);

             if($num > 0) {
                if($sel_q) $sel_q .= ",";
                // $sel_q .= ' (SELECT cval FROM crm_custom_values  where ckey="'.$val.'" and section="C" and recid=c.contact_id) as '.$kk;

                 $sel_q .= " cv$ik.cval AS $kk ";
                 $sel_left_q_custom[$ik] = ' INNER JOIN crm_custom_values AS $kk ON ( c.contact_id = mt$ik.recid AND mt$ik.ckey =  "$val" AND mt$ik.section =  "C" )' ;
                 $sel_left_q_custom[$ik] = $val;
                 } */
            }
        }

        $this->db->select($sel_q);

        //$this->db->select("count(*) as total");

        if (count($sel_left_q_custom) > 0) {
            foreach ($sel_left_q_custom as $ke => $val) {
                $this->db->join("crm_custom_values cv$ke", "cv$ke.recid = c.contact_id AND  cv$ke.ckey = '$val' AND cv$ke.section = 'C'");
            }
        }
        if ($sel_left_q_acc) {
            $this->db->join('crm_accounts ca', 'c.account_id = ca.account_id', 'left');
        }
        if ($sel_left_q_add) {
            $this->db->join('crm_address cad', 'c.contact_id = cad.parent_id', 'left');
        }

        if ($dtwhere) {
            $this->db->where($dtwhere, null, false);
        }

        if ($target) {
            $user_id = $_SESSION['ss_user_id'];
            /*if($parent_ids) $this->db->where_in('c.share_user_id', $parent_ids);
            else $this->db->where("(c.userid=$user_id OR c.share_user_id=$user_id)");*/
            if ($accessview == 'Own') {
                $this->db->where('c.share_user_id', $user_id);
                $this->db->where('c.target', '1');
            } else {
                $user_id = $_SESSION['ss_user_id'];
                if ($parent_ids) {
                    $this->db->where_in('c.share_user_id', $parent_ids);
                } else {
                    $this->db->where("(c.userid=$user_id OR c.share_user_id=$user_id)");
                }
                $this->db->where('c.target', '1');
            }
        }

        if ($owner) {
            $user_id = $_SESSION['ss_user_id'];
            //$this->db->where('c.userid', $user_id);
            $this->db->where('c.share_user_id', $user_id);
        } else {
            //echo "test123".$accessview;
             if($accessview=="Own") $this->db->where("c.share_user_id",$user_id);
			else if($accessview=="All") 
			{
				$this->db->where('c.userid', $user_id);
				$this->db->or_where("c.share_user_id",$shuser);	
			}
			else
			{
				if($parent_ids) $this->db->where_in('c.share_user_id', $parent_ids);
				else $this->db->where("(c.userid=$user_id OR c.share_user_id=$user_id)");
			}
        }

        //$this->db->or_where("c.share_user_id",$shuser);

        //SELECT `c`.`contact_id`, `c`.`target`, (SELECT city FROM crm_address WHERE parent_id=c.contact_id) as Address, (SELECT CONCAT((u.first_name), (' '), (u.last_name)) from users u where u.user_id = c.share_user_id) as usrname, CONCAT(c.user_first, (' '), c.user_last) AS Name, `c`.`linkedin`, `c`.`birthdate`, (SELECT account_name FROM crm_accounts WHERE account_id=c.account_id) as Addresstwo, `c`.`website`, `c`.`lead_source`, `c`.`user_title`, `c`.`department`, `c`.`create_date`, `c`.`phone`, `c`.`modify_date`, `c`.`mobile`, `c`.`assistant`, `c`.`unsubscribed`, `c`.`email`, `c`.`asst_phone`, `c`.`other_phone`, `c`.`description`, `c`.`ipoints`, `c`.`ppoints` FROM (`crm_contacts` c)

        //$this->db->select("c.contact_id,c.user_title,c.user_first,c.user_last,c.phone,c.email,c.unsubscribed,a.account_name,a.account_site,(SELECT CONCAT((u.first_name),(' '),(u.last_name)) from ".$this->_table_users." u where u.user_id = c.share_user_id) as usrname,(SELECT SUM(intpoints) FROM ".$this->_table_prospect_points." p WHERE p.rctype='C' and p.contact=c.contact_id) as qpoints");
        /*if($sortcol) {
            $this->db->order_by($sortcol,$sortval);
        }
         */
        if ($sortcol) {
            $this->db->order_by($sortcol, $sortval);
        }

        if ($points) {
            $this->db->order_by('c.ipoints', 'desc');
        }

        $this->db->from($this->_table_crm_contacts . ' c');

        //$query = "SELECT c.contact_id, c.target, (SELECT city FROM crm_address WHERE parent_id=c.contact_id) as Address, (SELECT CONCAT (first_name, ' ', last_name)  FROM  users WHERE user_id=c.share_user_id) as ContactOwner,  CONCAT(c.user_first, ' ', c.user_last) AS Name, c.linkedin, c.birthdate, (SELECT account_name FROM crm_accounts WHERE account_id=c.account_id) as Address, c.website, c.lead_source, c.user_title, c.department, c.create_date, c.phone, c.modify_date, c.mobile, c.assistant, c.unsubscribed, c.email, c.asst_phone, c.other_phone, c.description, c.ipoints, c.ppoints  FROM crm_contacts c";
        if (!$sortcol) {
            $tempdb = clone $this->db;
            $num_results = $tempdb->count_all_results();
        } else {
            $tempdbnew = clone $this->db;
            $numbe = $tempdbnew->get();
            $num_results = $numbe->num_rows();
        }

        //echo $num_results;
        if ($limit) {
            $this->db->limit($limit);
        }
        if ($offset) {
            $this->db->offset($offset);
        }
        $query = $this->db->get();

        //echo $this->db->last_query();

        $res = [];

        $res['contact'] = $res_arr_keys;
        $res['rowres'] = $query->result();

        $data_array = ['num_results' => $num_results, 'rowres' => $query->result(), 'contact' => $res_arr_keys];

        /*echo '<pre>'; print_r($data_array); echo '</pre>';
        exit;*/

        return  $data_array;

        if ($query->num_rows() > 0) {
            return $query->num_rows();
            //$row = $query->row_array();
            //return $row['total'];
        }

        return 0;
    }

    //Get Contacts list as array
    public function get_all_contacts_new($owner = 0, $target = 0, $parent_ids = [0], $limit = 0, $dtwhere = '', $offset = false)
    {
        //$this->db->select("c.contact_id,c.user_title,c.user_first,c.user_last,c.phone,c.email,c.unsubscribed,a.account_name,a.account_site,CONCAT((u.first_name),(' '),(u.last_name)) as usrname,(SELECT SUM(intpoints) FROM ".$this->_table_prospect_points." p WHERE p.rctype='C' and p.contact=c.contact_id) as qpoints");

        $this->db->select("c.contact_id,c.user_title,c.user_first,c.user_last,c.phone,c.email,c.unsubscribed,a.account_name,a.account_site,CONCAT((u.first_name),(' '),(u.last_name)) as usrname,c.target as qpoints");

        /*$this->db->select("c.contact_id,c.user_title,c.user_first,c.user_last,c.phone,c.email,c.unsubscribed,
            a.account_name,a.account_site,
        c.contact_id as qpoints");
         */

        //$this->db->select($this->_table_crm_contacts.'.*,'.$this->_table_crm_accounts.'.account_name,'.$this->_table_crm_accounts.'.account_site');
        if ($target) {
            $user_id = $_SESSION['ss_user_id'];
            /*if($parent_ids) $this->db->where_in('c.share_user_id', $parent_ids);
            else $this->db->where("(c.userid=$user_id OR c.share_user_id=$user_id)");*/
            $this->db->where('c.share_user_id', $user_id);
            $this->db->where('c.target', '1');
        } elseif ($owner) {
            $this->db->where('c.share_user_id', $owner);
        } else {
            //$user_id =  $_SESSION['ss_user_id'];
            //$this->db->where('c.userid', $user_id);
            $this->db->where_in('c.userid', $parent_ids);
        }
        $this->db->from($this->_table_crm_contacts . ' c');
        $this->db->join($this->_table_crm_accounts . ' a', 'a.account_id = c.account_id', 'left');
        $this->db->join($this->_table_users . ' u', 'u.user_id = c.share_user_id', 'left');
        if ($dtwhere) {
            $this->db->where($dtwhere, null, false);
        }
        if ($dtwhere) {
            $this->db->order_by('qpoints', 'desc');
        } elseif ($limit && $offset === false) {
            $this->db->order_by('c.user_first', 'asc');
        } else {
            $this->db->order_by('qpoints', 'desc');
        }
        //if($limit) $this->db->limit($limit,$offset);
        if ($limit) {
            $this->db->limit($limit);
        }
        if ($offset) {
            $this->db->offset($offset);
        }
        $query = $this->db->get();

        //echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
    }

    //Get Contacts list as array
    public function get_all_contacts_total($owner = 0, $target = 0, $parent_ids = [0], $limit = 0, $dtwhere = '', $offset = false)
    {
        //$this->db->select("c.contact_id,c.user_title,c.user_first,c.user_last,c.phone,c.email,c.unsubscribed,a.account_name,a.account_site,CONCAT((u.first_name),(' '),(u.last_name)) as usrname,(SELECT SUM(intpoints) FROM ".$this->_table_prospect_points." p WHERE p.rctype='C' and p.contact=c.contact_id) as qpoints");

        $user_id = $_SESSION['ss_user_id'];
        $this->db->select('count(userfrom) as qrcount,userfrom,accessview');
        $this->db->from('tbl_user_shared');
        $this->db->where('userto', $user_id);
        $record = $this->db->get();
        $result = $record->row_array();
        $count = $result['qrcount'];
        if ($count > 0) {
            $shuser = $result['userfrom'];
            $accessview = $result['accessview'];
        } else {
            $shuser = $user_id;
        }

        $this->db->select('count(*) as total');
        if ($target) {
            $user_id = $_SESSION['ss_user_id'];
            if ($accessview == 'Own') {
                $this->db->where('c.share_user_id', $user_id);
                $this->db->where('c.target', '1');
            } else {
                $user_id = $_SESSION['ss_user_id'];
                if ($parent_ids) {
                    $this->db->where_in('c.share_user_id', $parent_ids);
                } else {
                    $this->db->where("(c.userid=$user_id OR c.share_user_id=$user_id)");
                }
                $this->db->where('c.target', '1');
            }
        }

        if ($owner) {
            $user_id = $_SESSION['ss_user_id'];
            $this->db->where('c.share_user_id', $user_id);
        } else {
            if ($accessview == 'Own') {
                $this->db->where('c.share_user_id', $user_id);
            } elseif ($accessview == 'All') {
                $this->db->where("(c.userid='" . $user_id . "' OR c.share_user_id='" . $shuser . "')", null, false);
            } else {
                $this->db->where_in('c.userid', $parent_ids);
            }
        }

        $this->db->from($this->_table_crm_contacts . ' c');
        if ($dtwhere) {
            $this->db->where($dtwhere, null, false);
        }
        $query = $this->db->get();
        $row = $query->row_array();

        return $row['total'];
    }

    //Qaulify points
    public function qualify_points($rctype = 'C', $rid)
    {
        $this->db->select('SUM(intpoints) as total');
        $this->db->where('rctype', $rctype);
        $this->db->where('contact', $rid);
        $this->db->from($this->_table_prospect_points);
        $query = $this->db->get();
        $row = $query->row_array();

        return $row['total'];
    }

    //Search Contact
    public function search_contact($where)
    {
        $this->db->where($where[0], $where[1]);//$where = array('column','value')
        $this->db->where_in('userid', $where[2]);
        $query = $this->db->get($this->_table_crm_contacts);
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }

        return [];
    }

    //Get Contact record
    public function get_contact_next($category_id, $record_id)
    {
        $this->db->select('co.*,c.ipoints as qpoints');
        $this->db->where('co.category_id', $category_id);
        $this->db->where("(record_id>$record_id)");
        $this->db->from($this->_table_crm_category_contacts . ' co');
        $this->db->join($this->_table_crm_contacts . ' c', 'co.record_id = c.contact_id', 'left');
        $this->db->order_by('record_id', 'asc');
        $this->db->limit(1);
        $query = $this->db->get();
        //echo $this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }

        return [];
    }

    public function get_contactinfo_id($contact_id)
    {
       $user_id = $_SESSION['ss_user_id'];
		$this->db->select("c.phone,c.mobile,c.contact_id,c.email,a.account_id,a.account_name as account_title,CONCAT((c.user_first),(' '),(c.user_last)) as contactName");
		$this->db->where('c.contact_id', $contact_id);
		$this->db->from($this->_table_crm_contacts." c");
		$this->db->join($this->_table_crm_accounts." a", 'a.account_id = c.account_id','left');
		$query = $this->db->get();
    	if ($query->row() > 0)
    	{
			return $query->result();
    	}
		return array();
    }

    //Get Contact record
    public function get_contact($contact_id, $parent_ids = [0])
    {
        //echo "Contact ID:".$contact_id;
        $user_id = $_SESSION['ss_user_id'];
        $this->db->select("c.*,a.account_name as account_title,CONCAT((c2.user_first),(' '),(c2.user_last)) as report_title");
        //$this->db->select("c.*,a.account_name as account_title");
        $this->db->where('c.contact_id', $contact_id);
        //$this->db->group_start();
        //$this->db->where('c.userid', $user_id);
        //$this->db->or_where('c.share_user_id', $user_id);
        //$this->db->group_end();
        //$this->db->where("(c.userid=$user_id OR c.share_user_id=$user_id)");
        $this->db->from($this->_table_crm_contacts . ' c');
        $this->db->join($this->_table_crm_accounts . ' a', 'a.account_id = c.account_id', 'left');
        $this->db->join($this->_table_crm_contacts . ' c2', 'c2.contact_id = c.report_id', 'left');

        $query = $this->db->get();

        /*$sql = "SELECT c.*,a.account_name as account_title,CONCAT((c2.user_first),(' '),(c2.user_last)) as report_title
                FROM {$this->_table_crm_contacts} c
                LEFT JOIN {$this->_table_crm_accounts} a ON (a.account_id = c.account_id)
                LEFT JOIN {$this->_table_crm_contacts} c2 ON (c2.contact_id = c.report_id)
                WHERE c.contact_id={$contact_id} AND (c.userid={$user_id} OR c.share_user_id={$user_id})
                ";*/
        /*$sql = "SELECT c.*,a.account_name as account_title,CONCAT((c2.user_first),(' '),(c2.user_last)) as report_title
                FROM {$this->_table_crm_contacts} c
                LEFT JOIN {$this->_table_crm_accounts} a ON (a.account_id = c.account_id)
                LEFT JOIN {$this->_table_crm_contacts} c2 ON (c2.contact_id = c.report_id)
                WHERE c.contact_id=? AND (c.userid=? OR c.share_user_id=?)
                ";
        $query = $this->db->query($sql,array($contact_id,$user_id,$user_id));*/

        //echo $this->db->last_query();exit;

        if ($query->num_rows() > 0) {
            $row = $query->row_array();
            /*
                Contact access conditions
                1. C Created ID, Shared ID
                2. else C Account ID > Created ID, Shared ID
             */
            //custom fields
            $row['custom'] = $this->get_custom_records($contact_id, 'C');
            /*if(!$row['custom']){
                $temp=array();
                $temp[]=array('section'=>'C','ckey'=>'field1','cval'=>$row['custom1_value']);
                $temp[]=array('section'=>'C','ckey'=>'field2','cval'=>$row['custom2_value']);
                $temp[]=array('section'=>'C','ckey'=>'field3','cval'=>$row['custom3_value']);
                $row['custom']= $temp;
            }*/

            $access = 0;
            //echo "$access <pre>";print_r($row);exit;
            if ($user_id == $row['userid'] || $user_id == $row['share_user_id'] || in_array($row['userid'], $parent_ids) !== false) {
                $access = 1;
            } elseif ($row['account_id'] && $this->get_notes_parent($row['account_id'], 'A')) {
                $access = 1;
            }
            if ($access == 1) {
                $row['amail'] = $this->get_address($contact_id, 'amail', 'C');
                //$row['other']=$this->get_address($contact_id,'other','C');
                return $row;
            }
            /*if($row['report_id']) {
                $this->db->select("CONCAT((user_first),(' '),(user_last)) as report_title");
                $this->db->where('contact_id', $row['report_id']);
                $query = $this->db->get($this->_table_crm_contacts);
                echo $this->db->last_query();
                $row2 = $query->row_array();
                $row['report_title']=$row2['report_title'];
            }*/
        }

        return [];
    }
	
	
	public function get_acRecord_updated($where,$fields='*',$type='C') 
    {
		$user_id =  $_SESSION['ss_user_id'];
		$this->db->select('count(userfrom) as qrcount,userfrom,accessview');
		$this->db->from('tbl_user_shared');
		$this->db->where('userto',$user_id);
		$record = $this->db->get();
		$result = $record->row_array();
		$count =  $result['qrcount'];
		if($count>0) {
			$shuser = $result['userfrom'];
			$accessview =  $result['accessview'];
		}
		
		if($accessview=='Own')  $ownq = $user_id;
		else if($accessview=='All')  $ownq = $user_id.",".$shuser;
		else $ownq = implode(',', $this->_parent_users_all);	


		$this->db->select("$fields");		
		$this->db->where($where,NULL,FALSE);
		$this->db->where_in('userid',$ownq);
    	$query = $this->db->get($type=='C'?$this->_table_crm_contacts:$this->_table_crm_accounts);
    	if ($query->num_rows() > 0) return $query->row_array();
		return array();
    } 

    //Save Contact
    public function save_contact($data, $contact_id = 0)
    {
        if ($contact_id) {
            //$this->db->where('userid', $user_id);
            $this->db->where('contact_id', $contact_id);
            //$this->db->where("(userid=$user_id OR share_user_id=$user_id)");
            $this->db->update($this->_table_crm_contacts, $data);
        //echo $this->db->last_query();
        } else {
            if (!isset($data['userid'])) {
                $user_id = $_SESSION['ss_user_id'];
                $data['userid'] = $user_id;
            }
            $this->db->insert($this->_table_crm_contacts, $data);
            //echo $this->db->last_query();
            $contact_id = $this->db->insert_id();
        }

        return $contact_id;
    }

    //Delete contact
    public function delete_contact($contact_id)
    {
        //$user_id = $_SESSION['ss_user_id'];
        //$this->db->where('userid',$user_id);
        $this->db->where('contact_id', $contact_id);
        //$this->db->where("(userid=$user_id OR share_user_id=$user_id)");
        $doneRows = $this->db->delete($this->_table_crm_contacts);
        if ($doneRows) {
            $this->delete_address($contact_id, 'C');
            $this->delete_objectnotes($contact_id, 'C');
            $this->delete_objectdocs($contact_id, 'C');
            $this->delete_objecttasks($contact_id, 'C');
            $this->delete_prospect_points($contact_id, 'C');
            $this->delete_objections($contact_id, 'C');
            $this->delete_interactions($contact_id, 'C');
            //Delete contact scheduled emails
            $where = ['userid' => $_SESSION['ss_user_id'], 'contact' => $contact_id];
            $this->delete_schedule_email(0, $where);
            //delete from category
            $this->delete_record_from_category($contact_id, 1);
        }
    }

    //End of CONTACTS

    //ACCOUNTS
    //Get search list for Account
    public function account_search($data, $users)
    {
        $this->db->select("a.account_id,a.account_name,a.phone,CONCAT((u.first_name),(' '),(u.last_name)) as usrname,a.ipoints as qpoints");
        $this->db->from($this->_table_crm_accounts . ' a');
        $this->db->join($this->_table_users . ' u', 'u.user_id = a.share_user_id', 'left');
        $this->db->where_in('a.share_user_id', $users);
        $nc = count($data);
        if ($nc > 1) {
            $ob = '(';
            $cb = ')';
        }
        $n = 0;
        foreach ($data as $ki => $kval) {
            $n++;
            $sb = '';
            if ($n == 1) {
                if (is_array($kval)) {
                    $this->db->where($ob . $kval[0], null, false);
                } elseif ($ki == 'account_name') {
                    $this->db->where($ob . "a.$ki LIKE '%$kval%'", null, false);
                } else {
                    $this->db->where($ob . "a.$ki='$kval'", null, false);
                }
            } else {
                if ($n == $nc && $cb) {
                    $eb = $cb;
                }
                if (is_array($kval)) {
                    $this->db->where($kval[0], null, false);
                } elseif ($ki == 'account_name') {
                    $this->db->or_where("a.$ki LIKE '%$kval%'" . $eb, null, false);
                } else {
                    $this->db->or_where("a.$ki='$kval'" . $eb, null, false);
                }
            }
        }
        $this->db->order_by('qpoints', 'desc');
        $query = $this->db->get();
        //echo $this->db->last_query()."<br>";
        return $query->result();
    }

    //Get Accounts list as array
    public function get_all_accounts_Backup($owner = 0, $target = 0, $parent_ids = [0], $limit = 0, $dtwhere = '')
    {
        $this->db->select("a.account_id,a.account_name,a.account_site,a.account_type,a.phone,CONCAT((u.first_name),(' '),(u.last_name)) as usrname,(SELECT SUM(intpoints) FROM " . $this->_table_prospect_points . " p WHERE p.rctype='A' and p.contact=a.account_id) as qpoints");
        if ($target) {
            $user_id = $_SESSION['ss_user_id'];
            /*if($parent_ids) $this->db->where_in('a.share_user_id', $parent_ids);
            else $this->db->where("(a.userid=$user_id OR a.share_user_id=$user_id)");*/
            $this->db->where('a.share_user_id', $user_id);
            $this->db->where('a.target', '1');
        } elseif ($owner) {
            $this->db->where('a.share_user_id', $owner);
        } else {
            //$user_id =  $_SESSION['ss_user_id'];
            //$this->db->where('userid', $user_id);
            $this->db->where_in('a.userid', $parent_ids);
        }
        if ($dtwhere) {
            $this->db->where($dtwhere, null, false);
        }
        $this->db->from($this->_table_crm_accounts . ' a');
        $this->db->join($this->_table_users . ' u', 'u.user_id = a.share_user_id', 'left');
        if ($limit) {
            $this->db->limit($limit);
        }
        if ($dtwhere) {
            $this->db->order_by('qpoints', 'desc');
        } elseif ($limit) {
            $this->db->order_by('a.account_name', 'asc');
        } else {
            $this->db->order_by('qpoints', 'desc');
        }
        $query = $this->db->get();
        //$query = $this->db->get($this->_table_crm_accounts);
        if ($query->num_rows() > 0) {
            return $query->result();
        }
    }

    // GET ACCOUNTS LIST LATEST

    public function get_all_accounts_latest($owner = 0, $target = 0, $parent_ids = [0], $limit = 0, $dtwhere = '', $offset = false, $category = 0, $sortcol = '', $sortval = 'asc')
    {
		
        $user_id = $_SESSION['ss_user_id'];
        $this->db->select('count(userfrom) as qrcount,userfrom,accessview');
        $this->db->from('tbl_user_shared');
        $this->db->where('userto', $user_id);
        $record = $this->db->get();
        $result = $record->row_array();
        $count = $result['qrcount'];
        if ($count > 0) {
            $shuser = $result['userfrom'];
            $accessview = $result['accessview'];
        } else {
            $shuser = $user_id;
        }

        $wherec = [];
        $wherec['user_id'] = $this->_user_id;
        $wherec['field_type'] = 'column_account';
        $user_infoc = $this->home->getUserData($wherec);
        if ($user_infoc) {
            $user_infoc = $user_infoc[0];
        }
        $layout_fields = acol_fields();
        $layout_keys = array_keys($layout_fields);
        $contact_fields = [];

        if (isset($user_infoc->value) && $user_infoc->value) {
            //echo "Values in Database";
            $contact_fields = json_decode($user_infoc->value);
            $contact_fields = (array)$contact_fields;
        }
        if (!$contact_fields) {
            //echo "No Values in Database";
            $contact_fields = [];
            foreach ($layout_keys as $key => $value) {
                if ($value == 'account_name' || $value == 'share_user_title' || $value == 'billing' || $value == 'phone' || $value == 'ipoints') {
                    $contact_fields[$key] = $value;
                }
            }
        }

        $out = [];
        $layout_out = [];
        foreach ($contact_fields as $key => $value) {
            $out[$value] = $value;
        }

        foreach ($layout_keys as $key => $value) {
            $layout_out[$value] = $value;
        }

        $res_arr_keys = [];

        foreach ($contact_fields as $kk => $val) {

            //if (array_key_exists($kk,$out))
            //{
            $res_arr_keys[$val] = $val;
            //}
        }

        //echo '<pre>'; print_r($res_arr_keys); echo '</pre>';
        $sel_left_q_add = '';
        $sel_left_q_acc = '';
        $sel_left_user_add = '';
        $sel_left_q_custom = [];
        $sel_q = '  a.account_id ';

        $ik = 0;
        $points = '';
        foreach ($res_arr_keys as $kk => $val) {
            $ik = $ik + 1;
            if ($kk == 'account_name' || $kk == 'account_number' || $kk == 'account_site' || $kk == 'account_type' || $kk == 'industry' || $kk == 'revenue' || $kk == 'rating' || $kk == 'target' || $kk == 'phone' || $kk == 'fax' || $kk == 'website' || $kk == 'ticker_symbol' || $kk == 'ownership' || $kk == 'employees' || $kk == 'siccode' || $kk == 'bstreet' || $kk == 'bcity' || $kk == 'bstate' || $kk == 'bzipcode' || $kk == 'bcountry' || $kk == 'customer_priority' || $kk == 'sla_expdate' || $kk == 'numlocations' || $kk == 'active' || $kk == 'sla' || $kk == 'sla_serialno' || $kk == 'upsell_oppt' || $kk == 'description' || $kk == 'ipoints' || $kk == 'ppoints') {
                if ($sel_q) {
                    $sel_q .= ',';
                }
                $sel_q .= ' a.' . $kk;

                if ($kk == 'ipoints') {
                    $points = 'S';
                }
            } elseif ($kk == 'user_first') {
                if ($sel_q) {
                    $sel_q .= ',';
                }
                $sel_q .= " CONCAT((c.user_first), (' '), (c.user_last)) as  user_first";
            } elseif ($kk == 'billing') {
                if ($sel_q) {
                    $sel_q .= ',';
                }
                $sel_q .= ' cad.city as billing ';
                //$sel_q .= ' (SELECT city FROM crm_address WHERE parent_id=c.contact_id) as address ';
                $sel_left_q_add = ' LEFT JOIN crm_address cad ON a.account_id = cad.parent_id ';
            } elseif ($kk == 'first_name') {
                if ($sel_q) {
                    $sel_q .= ',';
                }
                $sel_q .= " (SELECT CONCAT((u.first_name),(' '),(u.last_name)) from  users u where u.user_id = c.share_user_id) as first_name ";
            } elseif ($kk == 'report_id') {
                if ($sel_q) {
                    $sel_q .= ',';
                }
                $sel_q .= " CONCAT((c.user_first), (' '), (c.user_last)) as report_id ";
            } elseif ($kk == 'share_user_title') {
                if ($sel_q) {
                    $sel_q .= ',';
                }
                $sel_q .= " CONCAT((us.first_name), (' '), (us.last_name)) as share_user_title ";
                //$sel_q .= ' (SELECT city FROM crm_address WHERE parent_id=c.contact_id) as address ';
                $sel_left_user_add = ' LEFT JOIN users us ON a.userid = us.user_id ';
            } else {
            }
        }

        $this->db->select($sel_q);

        //$this->db->select("count(*) as total");

        if (count($sel_left_q_custom) > 0) {
            foreach ($sel_left_q_custom as $ke => $val) {
                $this->db->join("crm_custom_values cv$ke", "cv$ke.recid = a.account_id AND  cv$ke.ckey = '$val' AND cv$ke.section = 'A'");
            }
        }
        if ($sel_left_q_add) {
            $this->db->join("crm_address cad", "a.account_id = cad.parent_id AND cad.parent_type='A'","left");
            //$this->db->where('cad.parent_type', 'A');
        }

        if ($sel_left_user_add) {
            $this->db->join('users us', 'a.share_user_id = us.user_id', 'left');
        }

        if ($dtwhere) {
            $this->db->where($dtwhere, null, false);
        }

        /*if($target) {
            $user_id =  $_SESSION['ss_user_id'];
            $this->db->where("a.share_user_id",$user_id);
            $this->db->where('a.target', '1');
        } else if($owner)
            $this->db->where('a.share_user_id', $owner);
        else {
            $this->db->where_in('a.userid', $parent_ids);
        }	*/

        if ($target) {
            $user_id = $_SESSION['ss_user_id'];
            if ($accessview == 'Own') {
                $this->db->where('a.share_user_id', $user_id);
                $this->db->where('a.target', '1');
            } else {
                $user_id = $_SESSION['ss_user_id'];
                if ($parent_ids) {
                    $this->db->where_in('a.share_user_id', $parent_ids);
                } else {
                    $this->db->where("(a.userid=$user_id OR a.share_user_id=$user_id)");
                }
                $this->db->where('a.target', '1');
            }
        }

        if ($owner) {
            $user_id = $_SESSION['ss_user_id'];
            //$this->db->where('c.userid', $user_id);
            $this->db->where('a.share_user_id', $user_id);
        } else {
            $user_id = $_SESSION['ss_user_id'];
            if ($accessview == 'Own') {
                $this->db->where('a.share_user_id', $user_id);
            } elseif ($accessview == 'All') {
                $this->db->where("(a.userid='" . $user_id . "' OR a.share_user_id='" . $shuser . "')", null, false);
            } else {
                $this->db->where_in('a.userid', $parent_ids);
            }
        }

        //$this->db->where('a.userid', $user_id);
		
		$this->db->group_by('a.account_id');

        if ($sortcol) {
            $this->db->order_by($sortcol, $sortval);
        }

        if ($points) {
            $this->db->order_by('a.ipoints', 'desc');
        }
        //$this->db->order_by("a.account_id","asc");
        $this->db->from($this->_table_crm_accounts . ' a');

        //$this->db->group_by('a.account_id');

        /*if (!$sortcol) {
            $tempdb = clone $this->db;
            //echo $this->db->last_query();
            $num_results = $tempdb->count_all_results();
        } else {
            $tempdbnew = clone $this->db;
            $numbe = $tempdbnew->get();
            $num_results = $numbe->num_rows();
        }*/
		
		$tempdbnew = clone $this->db;
		$numbe = $tempdbnew->get();
		$num_results = $numbe->num_rows();

        if ($limit) {
            $this->db->limit($limit);
        }
        if ($offset) {
            $this->db->offset($offset);
        }
        $query = $this->db->get();
       // echo $this->db->last_query()."<br>";
        $res = array();

        $res['contact'] = $res_arr_keys;
        $res['rowres'] = $query->result();

       //// echo "Number Of Result:".$num_results;
       // exit;

        $data_array = ['num_results' => $num_results, 'rowres' => $query->result(), 'contact' => $res_arr_keys];

        return  $data_array;

        if ($query->num_rows() > 0) {
            return $query->num_rows();
            //$row = $query->row_array();
            //return $row['total'];
        }

        return 0;
        // END LATEST
    }

    // END GET ALL ACCOUNTS LIST TOTAL

    //Get Accounts list as array
    public function get_all_accounts($owner = 0, $target = 0, $parent_ids = [0], $limit = 0, $dtwhere = '', $offset = false, $category = 0, $sortcol = '', $sortval = 'asc')
    {
        //$this->db->select("a.account_id,a.account_name,a.account_site,a.account_type,a.phone,CONCAT((u.first_name),(' '),(u.last_name)) as usrname,(SELECT SUM(intpoints) FROM ".$this->_table_prospect_points." p WHERE p.rctype='A' and p.contact=a.account_id) as qpoints");

        $user_id = $_SESSION['ss_user_id'];
        $this->db->select('count(userfrom) as qrcount,userfrom,accessview');
        $this->db->from('tbl_user_shared');
        $this->db->where('userto', $user_id);
        $record = $this->db->get();
        $result = $record->row_array();
        $count = $result['qrcount'];
        if ($count > 0) {
            $shuser = $result['userfrom'];
            $accessview = $result['accessview'];
        } else {
            $shuser = $user_id;
        }

        $this->db->select("a.account_id,a.account_name,a.account_site,a.account_type,a.phone,CONCAT((u.first_name),(' '),(u.last_name)) as usrname,a.ipoints as qpoints");

        /*if($target) {
            $user_id =  $_SESSION['ss_user_id'];
            if($parent_ids) $this->db->where_in('a.share_user_id', $parent_ids);
            else $this->db->where("(a.userid=$user_id OR a.share_user_id=$user_id)");
            if($parent_ids) $this->db->where_in("a.share_user_id",$parent_ids);
            else $this->db->where("a.share_user_id",$user_id);
            $this->db->where('a.target', '1');
        } else if($owner)
            $this->db->where('a.share_user_id', $owner);
        else {
            $user_id =  $_SESSION['ss_user_id'];
            $this->db->where('userid', $user_id);
            $this->db->where_in('a.userid', $parent_ids);
        }		*/

        if ($target) {
            $user_id = $_SESSION['ss_user_id'];
            if ($accessview == 'Own') {
                $this->db->where('a.share_user_id', $user_id);
                $this->db->where('a.target', '1');
            } else {
                $user_id = $_SESSION['ss_user_id'];
                if ($parent_ids) {
                    $this->db->where_in('a.share_user_id', $parent_ids);
                } else {
                    $this->db->where("(a.userid=$user_id OR a.share_user_id=$user_id)");
                }
                $this->db->where('a.target', '1');
            }
        }

        if ($owner) {
            $user_id = $_SESSION['ss_user_id'];
            //$this->db->where('c.userid', $user_id);
            $this->db->where('a.share_user_id', $user_id);
        } else {
            $user_id = $_SESSION['ss_user_id'];
            if ($accessview == 'Own') {
                $this->db->where('a.share_user_id', $user_id);
            } elseif ($accessview == 'All') {
                $this->db->where("(a.userid='" . $user_id . "' OR a.share_user_id='" . $shuser . "')", null, false);
            } else {
                $this->db->where_in('a.userid', $parent_ids);
            }
        }

        if ($category) {
            $this->db->from($this->_table_crm_category_contacts . ' cr');
            $this->db->join($this->_table_crm_accounts . ' a', 'a.account_id = cr.record_id', 'left');
        } else {
            $this->db->from($this->_table_crm_accounts . ' a');
        }
        $this->db->join($this->_table_users . ' u', 'u.user_id = a.share_user_id', 'left');
        if ($category) {
            $this->db->where('cr.category_id', $category);
        }
        if ($dtwhere) {
            $this->db->where($dtwhere, null, false);
        }

        if ($sortcol) {
            $this->db->order_by($sortcol, $sortval);
        } else {
            if ($dtwhere) {
                $this->db->order_by('qpoints', 'desc');
            } elseif ($limit && $offset === false) {
                $this->db->order_by('a.account_name', 'asc');
            } else {
                $this->db->order_by('qpoints', 'desc');
            }
        }
        /*
        if($dtwhere) $this->db->order_by("qpoints","desc");
        else if($limit && $offset===FALSE) $this->db->order_by("a.account_name","asc");
        else $this->db->order_by("qpoints","desc");*/
        if ($limit) {
            $this->db->limit($limit);
        }
        if ($offset) {
            $this->db->offset($offset);
        }
        $query = $this->db->get();
        //$query = $this->db->get($this->_table_crm_accounts);
        //echo $this->db->last_query()."<br>";
        if ($query->num_rows() > 0) {
            return $query->result();
        }
    }

    //Get Accounts total
    public function get_accounts_total($owner = 0, $target = 0, $parent_ids = [0], $limit = 0, $dtwhere = '', $offset = false)
    {
        $user_id = $_SESSION['ss_user_id'];
        $this->db->select('count(userfrom) as qrcount,userfrom,accessview');
        $this->db->from('tbl_user_shared');
        $this->db->where('userto', $user_id);
        $record = $this->db->get();
        $result = $record->row_array();
        $count = $result['qrcount'];
        if ($count > 0) {
            $shuser = $result['userfrom'];
            $accessview = $result['accessview'];
        } else {
            $shuser = $user_id;
        }

        $this->db->select('count(*) as total');

        /*if($target) {
            $user_id =  $_SESSION['ss_user_id'];
            $this->db->where("a.share_user_id",$user_id);
            $this->db->where('a.target', '1');
        } else if($owner)
            $this->db->where('a.share_user_id', $owner);
        else {
            $this->db->where_in('a.userid', $parent_ids);
        }		*/

        if ($target) {
            $user_id = $_SESSION['ss_user_id'];
            if ($accessview == 'Own') {
                $this->db->where('a.share_user_id', $user_id);
                $this->db->where('a.target', '1');
            } else {
                $user_id = $_SESSION['ss_user_id'];
                if ($parent_ids) {
                    $this->db->where_in('a.share_user_id', $parent_ids);
                } else {
                    $this->db->where("(a.userid=$user_id OR a.share_user_id=$user_id)");
                }
                $this->db->where('a.target', '1');
            }
        }

        if ($owner) {
            $user_id = $_SESSION['ss_user_id'];
            //$this->db->where('c.userid', $user_id);
            $this->db->where('a.share_user_id', $user_id);
        } else {
            $user_id = $_SESSION['ss_user_id'];
            if ($accessview == 'Own') {
                $this->db->where('a.share_user_id', $user_id);
            } elseif ($accessview == 'All') {
                $this->db->where("(c.userid='" . $user_id . "' OR c.share_user_id='" . $shuser . "')", null, false);
            } else {
                $this->db->where_in('a.userid', $parent_ids);
            }
        }

        $this->db->from($this->_table_crm_accounts . ' a');
        if ($dtwhere) {
            $this->db->where($dtwhere, null, false);
        }
        $query = $this->db->get();
        //$query = $this->db->get($this->_table_crm_accounts);
        //echo $this->db->last_query()."<br>";
        //exit;
        $row = $query->row_array();

        return $row['total'];
    }

    //Get Opportunities total
    public function get_opportunity_total($owner = 0, $target = 0, $parent_ids = [0], $limit = 0, $dtwhere = '', $offset = false)
    {
        $user_id = $_SESSION['ss_user_id'];
        $this->db->select('count(userfrom) as qrcount,userfrom,accessview');
        $this->db->from('tbl_user_shared');
        $this->db->where('userto', $user_id);
        $record = $this->db->get();
        $result = $record->row_array();
        $count = $result['qrcount'];
        if ($count > 0) {
            $shuser = $result['userfrom'];
            $accessview = $result['accessview'];
        } else {
            $shuser = $user_id;
        }

        $this->db->select('count(*) as total');

        if ($target) {
            $user_id = $_SESSION['ss_user_id'];
            if ($accessview == 'Own') {
                $this->db->where('c.share_user_id', $user_id);
                $this->db->where('c.target', '1');
            } else {
                $user_id = $_SESSION['ss_user_id'];
                if ($parent_ids) {
                    $this->db->where_in('c.share_user_id', $parent_ids);
                } else {
                    $this->db->where("(c.userid=$user_id OR c.share_user_id=$user_id)");
                }
                $this->db->where('c.target', '1');
            }
        }

        if ($owner) {
            $user_id = $_SESSION['ss_user_id'];
            $this->db->where('o.share_user_id', $user_id);
        } else {
            if ($accessview == 'Own') {
                $this->db->where('o.share_user_id', $user_id);
            } elseif ($accessview == 'All') {
                $this->db->where('o.userid', $user_id);
                $this->db->or_where('o.share_user_id', $shuser);
            } else {
                $this->db->where_in('o.userid', $parent_ids);
            }
        }

        $this->db->from($this->_table_crm_oppurtinity . ' o');
        if ($dtwhere) {
            $this->db->where($dtwhere, null, false);
        }
        $query = $this->db->get();
        //$query = $this->db->get($this->_table_crm_accounts);
        //echo $this->db->last_query()."<br>";
        $row = $query->row_array();

        return $row['total'];
    }

    //Search Account
    public function search_account($where)
    {
        $this->db->where($where[0], $where[1]);//$where = array('column','value')
        $this->db->where_in('userid', $where[2]);
        $query = $this->db->get($this->_table_crm_accounts);
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }

        return [];
    }

    //Get Account record
    public function get_account($account_id, $parent_ids = [0])
    {
        $user_id = $_SESSION['ss_user_id'];
        $this->db->select('a.*,a2.account_name as account_title');
        //$this->db->where('a.userid', $user_id);
        //$this->db->where("(a.userid=$user_id OR a.share_user_id=$user_id)");
        $this->db->where('a.account_id', $account_id);
        $this->db->from($this->_table_crm_accounts . ' a');
        $this->db->join($this->_table_crm_accounts . ' a2', 'a2.account_id = a.account_parent', 'left');
        $query = $this->db->get();
        //echo $this->db->last_query();exit;
        //$query = $this->db->get($this->_table_crm_accounts);
        if ($query->num_rows() > 0) {
            $row = $query->row_array();

            //custom fields
            $row['custom'] = $this->get_custom_records($account_id, 'A');
            /*if(!$row['custom']){
                $temp=array();
                $temp[]=array('section'=>'A','ckey'=>'field1','cval'=>$row['custom1_value']);
                $temp[]=array('section'=>'A','ckey'=>'field2','cval'=>$row['custom2_value']);
                $temp[]=array('section'=>'A','ckey'=>'field3','cval'=>$row['custom3_value']);
                $row['custom']= $temp;
            }*/

            $access = 0;
            if ($user_id == $row['userid'] || $user_id == $row['share_user_id'] || in_array($row['userid'], $parent_ids) !== false) {
                $access = 1;
            }
            if ($access == 1) {
                $row['billing'] = $this->get_address($account_id, 'billing', 'A');
                $row['shipping'] = $this->get_address($account_id, 'shipping', 'A');

                return $row;
            }
        }

        return [];
    }

    //Save Account
    public function save_account($data, $account_id = 0)
    {
        $user_id = $_SESSION['ss_user_id'];
        if ($account_id) {
            //$this->db->where('userid', $user_id);
            //$this->db->where("(userid=$user_id OR share_user_id=$user_id)");
            $this->db->where('account_id', $account_id);
            $this->db->update($this->_table_crm_accounts, $data);
        } else {
            $data['userid'] = $user_id;
            $this->db->insert($this->_table_crm_accounts, $data);
            $account_id = $this->db->insert_id();
        }

        return $account_id;
    }

    //Delete Account
    public function delete_account($account_id)
    {
        $user_id = $_SESSION['ss_user_id'];
        //$this->db->where('userid',$user_id);
        $this->db->where("(userid=$user_id OR share_user_id=$user_id)");
        $this->db->where('account_id', $account_id);
        $doneRows = $this->db->delete($this->_table_crm_accounts);
        if ($doneRows) {
            $this->delete_address($account_id, 'A');
            $this->delete_objectnotes($account_id, 'A');
            $this->delete_objectdocs($account_id, 'A');
            $this->delete_objecttasks($account_id, 'A');
            $this->delete_prospect_points($account_id, 'A');
            $this->delete_objections($account_id, 'A');
            $this->delete_interactions($account_id, 'A');
            //delete from category
            $this->delete_record_from_category($account_id, 2);
        }
    }

    //End of Accounts

    //LEADS- IGNORE IT
    //Get Leads list as array
    /*public function get_all_leads()
    {
        $user_id =  $_SESSION['ss_user_id'];
        $this->db->where('userid', $user_id);
        $query = $this->db->get($this->_table_crm_leads);
        if ($query->num_rows() > 0)
        {
            return $query->result();
        }
    }
    //Get Lead record
    public function get_lead($lead_id)
    {
        $user_id = $_SESSION['ss_user_id'];
        $this->db->where('userid', $user_id);
        $this->db->where('lead_id', $lead_id);
        $query = $this->db->get($this->_table_crm_leads);
        if ($query->num_rows() > 0)
        {
            $row = $query->row_array();
            $row['home']=$this->get_address($lead_id,'home','L');
            return $row;
        }
        return array();
    }
    //Save Lead
    function save_lead($data,$lead_id=0)
    {
       $user_id = $_SESSION['ss_user_id'];
       if($lead_id) {
               $this->db->where('userid', $user_id);
            $this->db->where('lead_id', $lead_id);
               $this->db->update($this->_table_crm_leads,$data);
        } else {
            $data['userid']=$user_id;
               $this->db->insert($this->_table_crm_leads,$data);
               $lead_id = $this->db->insert_id();
        }
       return $lead_id;
    }
    //Delete Lead
    function delete_lead($lead_id)
    {
       $user_id = $_SESSION['ss_user_id'];
       $this->db->where('userid',$user_id);
       $this->db->where('lead_id',$lead_id);
       $this->db->delete($this->_table_crm_leads);
       $this->delete_address($lead_id,'L');
       $this->delete_objectnotes($lead_id,'L');
    }*/

    //End of LEADS

    //OPPORTUNITIES
    //Get Opportunity list as array
    public function get_all_opportunitys($owner = 0, $limit = 0, $dtwhere = '')
    {
        $user_id = $_SESSION['ss_user_id'];
        $this->db->select('count(userfrom) as qrcount,userfrom,accessview');
        $this->db->from('tbl_user_shared');
        $this->db->where('userto', $user_id);
        $record = $this->db->get();
        $result = $record->row_array();
        $count = $result['qrcount'];
        if ($count > 0) {
            $shuser = $result['userfrom'];
            $accessview = $result['accessview'];
        }
        //echo $dtwhere;
        $this->db->select("o.oppt_id,o.oppt_name,o.close_date,o.account_id,a.account_name as account_title,o.amount,o.stage,o.probability,CONCAT((u.first_name),(' '),(u.last_name)) as usrname,o.contact_id,c.user_first,c.user_last");
		
		$this->db->from($this->_table_crm_oppurtinity." o");
		$this->db->join($this->_table_crm_accounts." a", 'a.account_id = o.account_id','left');
		$this->db->join($this->_table_crm_contacts." c", 'c.contact_id = o.contact_id','left');
		$this->db->join($this->_table_users." u", 'u.user_id = o.share_user_id','left');

        if($owner)
		{		
			$user_id =  $_SESSION['ss_user_id'];
			$this->db->where('o.userid', $user_id);
			if($dtwhere) $this->db->where($dtwhere,NULL,FALSE);	
		}
		else {
           if($accessview=="Own") {	
				$this->db->where("o.share_user_id",$user_id);
			 }
			 else if($accessview=="All") {	
			    $this->db->where("o.userid",$user_id);
				$this->db->or_where("o.share_user_id",$shuser);	
			 }
			 else
			 {
			 	$this->db->where("o.userid",$user_id);
				$this->db->or_where("o.share_user_id",$user_id);	
			 }
        }
        //$this->db->where('o.userid', $user_id);
        /*$this->db->from($this->_table_crm_oppurtinity . ' o');
        $this->db->join($this->_table_crm_accounts . ' a', 'a.account_id = o.account_id', 'left');
        $this->db->join($this->_table_crm_contacts . ' c', 'c.contact_id = o.contact_id', 'left');
        $this->db->join($this->_table_users . ' u', 'u.user_id = o.share_user_id', 'left');*/
        if ($limit) {
            $this->db->limit($limit);
        }
        $this->db->order_by('o.close_date', 'asc');
        $query = $this->db->get();
        //echo $this->db->last_query();
        //$query = $this->db->get($this->_table_crm_oppurtinity);
        if ($query->num_rows() > 0) {
            return $query->result();
        }
    }
	
	public function get_all_opportunityssta($owner=0,$stage=0,$limit=0,$dtwhere='' ) 
    {	
	    $user_id =  $_SESSION['ss_user_id'];
		$this->db->select("o.oppt_id,o.oppt_name,o.close_date,o.account_id,a.account_name as account_title,o.amount,o.stage,o.probability,CONCAT((u.first_name),(' '),(u.last_name)) as usrname,o.contact_id,c.user_first,c.user_last");
		
		$this->db->from($this->_table_crm_oppurtinity." o");
		$this->db->join($this->_table_crm_accounts." a", 'a.account_id = o.account_id','left');
		$this->db->join($this->_table_crm_contacts." c", 'c.contact_id = o.contact_id','left');
		$this->db->join($this->_table_users." u", 'u.user_id = o.share_user_id','left');
		
		if($stage != '' && $owner != '') 
		{ 
			$this->db->where('o.stage', $stage);
			$this->db->where("(o.share_user_id=$owner)");
		}
		else if($stage == '' && $owner != '') 
		{ 
			$this->db->where("(o.share_user_id=$owner)");
		}
		else if($stage != '' && $owner == '') 
		{ 
			$this->db->where('o.stage', $stage);
			$this->db->where("(o.share_user_id='".$user_id."')");	
		}
		if($limit) $this->db->limit($limit);
		$this->db->order_by("o.close_date","asc");
		$query = $this->db->get();
		//echo $this->db->last_query();
    	if ($query->num_rows() > 0)
    	{
    		return $query->result();
    	}
    }
	
	
	public function get_sale_opportunity($user,$where) 
    {	
		
		$this->db->select("o.oppt_id,o.oppt_name,o.close_date,o.account_id,a.account_name as account_title,o.amount,CONCAT((u.first_name),(' '),(u.last_name)) as usrname,o.contact_id,c.user_first,c.user_last");
		$this->db->from($this->_table_crm_oppurtinity." o");
		$this->db->join($this->_table_crm_accounts." a", 'a.account_id = o.account_id','left');
		$this->db->join($this->_table_crm_contacts." c", 'c.contact_id = o.contact_id','left');
		$this->db->join($this->_table_users." u", 'u.user_id = o.share_user_id','left');	
		if(is_array($user)) $this->db->where_in('o.share_user_id', $user);
		else $this->db->where('o.share_user_id', $user);
		$this->db->where($where,NULL,FALSE);
    	$query = $this->db->get();
    	if ($query->num_rows() > 0)
    	{
    		return $query->result();
    	}
    }

    //Get Opportunity record
    public function get_opportunity($oppt_id, $parent_ids)
    {
        $user_id = $_SESSION['ss_user_id'];
        $this->db->select('o.*,a.account_name as account_title,c.user_first,c.user_last');
        //$this->db->where('o.userid', $user_id);
        $this->db->where('o.oppt_id', $oppt_id);
        $this->db->from($this->_table_crm_oppurtinity . ' o');
        $this->db->join($this->_table_crm_accounts . ' a', 'a.account_id = o.account_id', 'left');
        $this->db->join($this->_table_crm_contacts . ' c', 'c.contact_id = o.contact_id', 'left');
        $query = $this->db->get();
        //$query = $this->db->get($this->_table_crm_oppurtinity);
        if ($query->num_rows() > 0) {
            $opRow = $query->row_array();
            /*
                Opportunity access conditions
                1. OP created ID, Shared ID
                2. else OP Contact ID > Created ID, Shared ID
                3. else OP Account ID > Created ID, Shared ID
                4. else Otherwise redirect to CONTACTS
             */
            if ($user_id == $opRow['userid'] || $user_id == $opRow['share_user_id'] || in_array($opRow['userid'], $parent_ids) !== false) {
                return $opRow;
            } elseif ($opRow['contact_id'] && $this->get_notes_parent($opRow['contact_id'], 'C')) {
                return $opRow;
            } elseif ($opRow['account_id'] && $this->get_notes_parent($opRow['account_id'], 'A')) {
                return $opRow;
            }
        }

        return [];
    }

    //Save Opportunity
    public function save_opportunity($data, $oppt_id = 0)
    {
        $user_id = $_SESSION['ss_user_id'];
        if ($oppt_id) {
            //$this->db->where('userid', $user_id);
            $this->db->where('oppt_id', $oppt_id);
            $this->db->update($this->_table_crm_oppurtinity, $data);
        } else {
            $data['userid'] = $user_id;
            $this->db->insert($this->_table_crm_oppurtinity, $data);
            $oppt_id = $this->db->insert_id();
        }

        return $oppt_id;
    }

    //Delete Opportunity
    public function delete_opportunity($oppt_id)
    {
        //$user_id = $_SESSION['ss_user_id'];
        //$this->db->where('userid',$user_id);
        $this->db->where('oppt_id', $oppt_id);
        $this->db->delete($this->_table_crm_oppurtinity);
        $this->delete_objectnotes($oppt_id, 'O');
    }

    //End of OPPORTUNITIES

    //NOTES
    //Get Notes list as array
    public function get_all_notes($parent_id, $parent_type, $limit = 0)
    {
        $parentNote = $this->get_notes_parent($parent_id, $parent_type);
        if (!$parentNote) {
            return [];
        }
        //$user_id =  $_SESSION['ss_user_id'];
        $this->db->select("n.sfid,n.notes_info,n.notes_private,n.notes_title,n.upload,n.notes_modify,n.notes_id,CONCAT((u.first_name),(' '),(u.last_name)) as usrname");
        //$this->db->where('notes_user', $user_id);
        $this->db->where('n.notes_parent', $parent_type);
        $this->db->where('n.notes_parentid', $parent_id);
        $this->db->from($this->_table_crm_notes . ' n');
        $this->db->join($this->_table_users . ' u', 'u.user_id = n.notes_user', 'left');
        $this->db->order_by('n.notes_modify', 'desc');
        if ($limit) {
            $this->db->limit($limit);
        }
        $query = $this->db->get();
        //$query = $this->db->get($this->_table_crm_notes);
        //echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            return $query->result();
        }

        return [];
    }

    public function get_all_videos($vtype)
    {
        if ($vtype == 'spb') {
            $table = 'spb_allvideos_list';
        } else {
            $table = 'spt_allvideos_list';
        }
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by('id', 'asc');
        $query = $this->db->get();
        //$query = $this->db->get($this->_table_crm_notes);
        if ($query->num_rows() > 0) {
            return $query->result();
        }

        return [];
    }

    public function get_videotitle($vid)
    {
        $this->db->select('title');
        $this->db->where('id', $vid);
        $this->db->from('spb_allvideos_list');
        $this->db->order_by('id', 'asc');
        $query = $this->db->get();
        if ($query->row() > 0) {
            return $query->result();
        }

        return [];
    }

    public function get_sptvideotitle($vid)
    {
        $this->db->select('title');
        $this->db->where('id', $vid);
        $this->db->from('spt_allvideos_list');
        $this->db->order_by('id', 'asc');
        $query = $this->db->get();
        if ($query->row() > 0) {
            return $query->result();
        }

        return [];
    }

    public function get_checkQuestion($user_id, $qid)
    {
        $this->db->where('uid', $user_id);
        $this->db->where('qid', $qid);
        $query = $this->db->get('sales_users_sanswers');
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }

        return [];
    }

    public function get_checksptQuestion($user_id, $qid)
    {
        $this->db->where('uid', $user_id);
        $this->db->where('qid', $qid);
        $query = $this->db->get('sales_users_sptanswers');
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }

        return [];
    }

    public function spb_checkstatus($qid, $ans)
    {
        $this->db->select('status');
        $this->db->where('question_id', $qid);
        $this->db->where('title', $ans);
        $this->db->from('spb_questions');
        $query = $this->db->get();
        if ($query->row() > 0) {
            return $query->result();
        }

        return [];
    }

    public function spt_checkstatus($qid, $ans)
    {
        $this->db->select('status');
        $this->db->where('question_id', $qid);
        $this->db->where('title', $ans);
        $this->db->from('spt_questions');
        $query = $this->db->get();
        if ($query->row() > 0) {
            return $query->result();
        }

        return [];
    }

    public function save_squestions($data, $answer_id = 0)
    {
        if ($answer_id) {
            //$this->db->where('userid', $user_id);
            $this->db->where('id', $answer_id);
            //$this->db->where("(userid=$user_id OR share_user_id=$user_id)");
            $this->db->update('sales_users_sanswers', $data);
        //echo $this->db->last_query();
        } else {
            $this->db->insert('sales_users_sanswers', $data);
            //echo $this->db->last_query();
            $answer_id = $this->db->insert_id();
        }

        return $answer_id;
    }

    public function save_sptquestions($data, $answer_id = 0)
    {
        if ($answer_id) {
            //$this->db->where('userid', $user_id);
            $this->db->where('id', $answer_id);
            //$this->db->where("(userid=$user_id OR share_user_id=$user_id)");
            $this->db->update('sales_users_sptanswers', $data);
        //echo $this->db->last_query();
        } else {
            $this->db->insert('sales_users_sptanswers', $data);
            //echo $this->db->last_query();
            $answer_id = $this->db->insert_id();
        }

        return $answer_id;
    }

    public function get_all_spbquestions($vid)
    {
        $this->db->select('*');
        $this->db->where('videoid', $vid);
        $this->db->where('question_id', 0);
        $this->db->from('spb_questions');
        $this->db->order_by('id', 'asc');
        $query = $this->db->get();
        //$query = $this->db->get($this->_table_crm_notes);
        if ($query->num_rows() > 0) {
            return $query->result();
        }

        return [];
    }

    public function get_all_sptquestions($vid)
    {
        $this->db->select('*');
        $this->db->where('videoid', $vid);
        $this->db->where('question_id', 0);
        $this->db->from('spt_questions');
        $this->db->order_by('id', 'asc');
        $query = $this->db->get();
        //$query = $this->db->get($this->_table_crm_notes);
        if ($query->num_rows() > 0) {
            return $query->result();
        }

        return [];
    }

    public function get_all_spbqanswers($qid)
    {
        $this->db->select('*');
        $this->db->where('question_id', $qid);
        $this->db->from('spb_questions');
        $this->db->order_by('id', 'asc');
        $query = $this->db->get();
        //$query = $this->db->get($this->_table_crm_notes);
        if ($query->num_rows() > 0) {
            return $query->result();
        }

        return [];
    }

    public function get_all_sptqanswers($qid)
    {
        $this->db->select('*');
        $this->db->where('question_id', $qid);
        $this->db->from('spt_questions');
        $this->db->order_by('id', 'asc');
        $query = $this->db->get();
        //$query = $this->db->get($this->_table_crm_notes);
        if ($query->num_rows() > 0) {
            return $query->result();
        }

        return [];
    }

    public function deleteall_qanwers($user_id, $vid)
    {
        $this->db->where('uid', $user_id);
        $this->db->where('vid', $vid);
        $this->db->delete('sales_users_sanswers');
    }

    public function deleteall_sptqanwers($user_id, $vid)
    {
        $this->db->where('uid', $user_id);
        $this->db->where('vid', $vid);
        $this->db->delete('sales_users_sptanswers');
    }

    //Get Notes record
    public function get_notes($notes_id)
    {
        //$user_id = $_SESSION['ss_user_id'];
        $this->db->where('notes_id', $notes_id);
        //$this->db->where('notes_user', $user_id);
        $query = $this->db->get($this->_table_crm_notes);
        if ($query->num_rows() > 0) {
            $notesRow = $query->row_array();
            $parentNote = $this->get_notes_parent($notesRow['notes_parentid'], $notesRow['notes_parent']);
            if (!$parentNote) {
                return [];
            }

            return $notesRow;
        }

        return [];
    }

    public function get_sprospecting_count($uid)
    {
        //$user_id = $_SESSION['ss_user_id'];
        $this->db->where('userid', $uid);
        //$this->db->where('notes_user', $user_id);
        $query = $this->db->get('sales_prospecting_basics');

        return $query->num_rows();
    }

    public function get_sprospecting_techniques_count($uid)
    {
        //$user_id = $_SESSION['ss_user_id'];
        $this->db->where('userid', $uid);
        //$this->db->where('notes_user', $user_id);
        $query = $this->db->get('sales_prospecting_techniques');

        return $query->num_rows();
    }

    /*public function spbquizdelete($vid,$user_id)
    {
       $this->db->where('uid', $user_id);
       $this->db->where('vid', $vid);
       $this->db->delete("sales_users_sanswers");
    }*/

    public function spbquizstatus($vid, $uid)
    {
        $k = '';
        $user_id = $_SESSION['ss_user_id'];
        $this->db->where('vid', $vid);
        $this->db->where('uid', $user_id);
        //$this->db->where('notes_user', $user_id);
        $query = $this->db->get('sales_users_sanswers');
        if ($query->num_rows() > 0) {
            $this->db->where('vid', $vid);
            $this->db->where('uid', $user_id);
            $this->db->where('status', 'w');
            $query1 = $this->db->get('sales_users_sanswers');
            if ($query1->num_rows() > 0) {
                $k = 'Fail';
            } else {
                $k = 'Passed';
            }
        }

        return $k;
    }

    public function spbquizcnumber($vid, $uid)
    {
        $k = '';
        $user_id = $_SESSION['ss_user_id'];
        $this->db->where('vid', $vid);
        $this->db->where('uid', $user_id);
        //$this->db->where('notes_user', $user_id);
        $query = $this->db->get('sales_users_sanswers');
        if ($query->num_rows() > 0) {
            $this->db->where('vid', $vid);
            $this->db->where('uid', $user_id);
            $this->db->where('status', 'c');
            $query1 = $this->db->get('sales_users_sanswers');
            if ($query1->num_rows() > 0) {
                $k = $query1->num_rows();
            } else {
                $k = 0;
            }
        }

        return $k;
    }

    public function spbquizicnumber($vid, $uid)
    {
        $k = '';
        $user_id = $_SESSION['ss_user_id'];
        $this->db->where('vid', $vid);
        $this->db->where('uid', $user_id);
        //$this->db->where('notes_user', $user_id);
        $query = $this->db->get('sales_users_sanswers');
        if ($query->num_rows() > 0) {
            $this->db->where('vid', $vid);
            $this->db->where('uid', $user_id);
            $this->db->where('status', 'w');
            $query1 = $this->db->get('sales_users_sanswers');
            if ($query1->num_rows() > 0) {
                $k = $query1->num_rows();
            } else {
                $k = 0;
            }
        }

        return $k;
    }

    public function sptquizstatus($vid, $uid)
    {
        $k = '';
        $user_id = $_SESSION['ss_user_id'];
        $this->db->where('vid', $vid);
        $this->db->where('uid', $user_id);
        //$this->db->where('notes_user', $user_id);
        $query = $this->db->get('sales_users_sptanswers');
        if ($query->num_rows() > 0) {
            $this->db->where('vid', $vid);
            $this->db->where('uid', $user_id);
            $this->db->where('status', 'w');
            $query1 = $this->db->get('sales_users_sptanswers');
            if ($query1->num_rows() > 0) {
                $k = 'Fail';
            } else {
                $k = 'Passed';
            }
        }

        return $k;
    }

    public function sptquizcnumber($vid, $uid)
    {
        $k = '';
        $user_id = $_SESSION['ss_user_id'];
        $this->db->where('vid', $vid);
        $this->db->where('uid', $user_id);
        //$this->db->where('notes_user', $user_id);
        $query = $this->db->get('sales_users_sptanswers');
        if ($query->num_rows() > 0) {
            $this->db->where('vid', $vid);
            $this->db->where('uid', $user_id);
            $this->db->where('status', 'c');
            $query1 = $this->db->get('sales_users_sptanswers');
            if ($query1->num_rows() > 0) {
                $k = $query1->num_rows();
            } else {
                $k = 0;
            }
        }

        return $k;
    }

    public function sptquizicnumber($vid, $uid)
    {
        $k = '';
        $user_id = $_SESSION['ss_user_id'];
        $this->db->where('vid', $vid);
        $this->db->where('uid', $user_id);
        //$this->db->where('notes_user', $user_id);
        $query = $this->db->get('sales_users_sptanswers');
        if ($query->num_rows() > 0) {
            $this->db->where('vid', $vid);
            $this->db->where('uid', $user_id);
            $this->db->where('status', 'w');
            $query1 = $this->db->get('sales_users_sptanswers');
            if ($query1->num_rows() > 0) {
                $k = $query1->num_rows();
            } else {
                $k = 0;
            }
        }

        return $k;
    }

    public function get_sprospecting($uid)
    {
        //$user_id = $_SESSION['ss_user_id'];
        $this->db->where('userid', $uid);
        //$this->db->where('notes_user', $user_id);
        $query = $this->db->get('sales_prospecting_basics');
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }

        return [];
    }

    public function get_sprospecting_techniques($uid)
    {
        //$user_id = $_SESSION['ss_user_id'];
        $this->db->where('userid', $uid);
        //$this->db->where('notes_user', $user_id);
        $query = $this->db->get('sales_prospecting_techniques');
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }

        return [];
    }

    //Save Notes
    public function save_notes($data, $notes_id = 0)
    {
        $user_id = $_SESSION['ss_user_id'];
        if ($notes_id) {
            $data['notes_modify'] = date('Y-m-d H:i:s');
            $this->db->where('notes_id', $notes_id);
            //$this->db->where('notes_user', $user_id);
            $this->db->update($this->_table_crm_notes, $data);
        } else {
            $data['notes_user'] = $user_id;
            $data['notes_created'] = date('Y-m-d H:i:s');
            $data['notes_modify'] = date('Y-m-d H:i:s');
            $this->db->insert($this->_table_crm_notes, $data);
            $notes_id = $this->db->insert_id();
        }
        //echo $this->db->last_query();
        return $notes_id;
    }

    //Save Sales Prospecting
    public function sales_prospecting_techniques($record, $srecord)
    {
        $val = $this->input->post('val');
        $status = $this->input->post('status');
        $user_id = $_SESSION['ss_user_id'];
        if ($srecord > 0) {
            $data[$status] = $val;
            $this->db->where('userid', $user_id);
            $this->db->update('sales_prospecting_techniques', $data);
        } else {
            $data['userid'] = $user_id;
            $data[$status] = $val;
            $data['created_dtime'] = date('Y-m-d H:i:s');
            $data['updated_dtime'] = date('Y-m-d H:i:s');
            $this->db->insert('sales_prospecting_techniques', $data);
            $sales_id = $this->db->insert_id();
        }

        return $sales_id;
    }

    public function sales_prospecting($record, $srecord)
    {
        $val = $this->input->post('val');
        $status = $this->input->post('status');
        $user_id = $_SESSION['ss_user_id'];
        if ($srecord > 0) {
            $data[$status] = $val;
            $this->db->where('userid', $user_id);
            $this->db->update('sales_prospecting_basics', $data);
        } else {
            $data['userid'] = $user_id;
            $data[$status] = $val;
            $data['created_dtime'] = date('Y-m-d H:i:s');
            $data['updated_dtime'] = date('Y-m-d H:i:s');
            $this->db->insert('sales_prospecting_basics', $data);
            $sales_id = $this->db->insert_id();
        }

        return $sales_id;
    }

    //Delete Notes
    public function delete_notes($notes_id)
    {
        //$user_id = $_SESSION['ss_user_id'];
        $this->db->where('notes_id', $notes_id);
        //$this->db->where('notes_user', $user_id);
        $this->db->delete($this->_table_crm_notes);
        $this->delete_prospect_points($notes_id, 'N');
    }

    //Search Notes
    public function search_notes($where)
    {
        $this->db->where($where[0], $where[1]);//$where = array('column','value')
        $this->db->where_in('notes_user', $where[2]);
        $query = $this->db->get($this->_table_crm_notes);
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }

        return [];
    }

    //Delete all notes from Specific Object
    public function delete_objectnotes($parent_id, $parent_type)
    {
        //$user_id = $_SESSION['ss_user_id'];
        //$this->db->where('notes_user', $user_id);
        $this->db->where('notes_parent', $parent_type);
        $this->db->where('notes_parentid', $parent_id);
        $this->db->delete($this->_table_crm_notes);
    }

    //Get Notes parent record
    public function get_notes_parent($parent_id, $parent_type = 'C')
    {
        $user_id = $_SESSION['ss_user_id'];
        $this->db->select('count(userfrom) as qrcount,userfrom,accessview');
        $this->db->from('tbl_user_shared');
        $this->db->where('userto', $user_id);
        $record = $this->db->get();
        $result = $record->row_array();
        $count = $result['qrcount'];
        if ($count > 0) {
            $shuser = $result['userfrom'];
            $accessview = $result['accessview'];
        }

        $user_id = $_SESSION['ss_user_id'];
        //$this->db->where('userid', $user_id);

        if ($accessview == 'Own') {
            $this->db->where('share_user_id', $user_id);
        } elseif ($accessview == 'All') {
            $this->db->where("(userid='" . $user_id . "' OR userid='" . $shuser . "')", null, false);
        } else {
            $this->db->where_in('userid', $this->_parent_users);
        }

        //$this->db->where("(userid=$user_id OR share_user_id=$user_id)");
        if ($parent_type == 'A') {
            $this->db->where('account_id', $parent_id);
            $query = $this->db->get($this->_table_crm_accounts);
        } elseif ($parent_type == 'O') {
            $this->db->where('oppt_id', $parent_id);
            $query = $this->db->get($this->_table_crm_oppurtinity);
        } else {
            $this->db->where('contact_id', $parent_id);
            $query = $this->db->get($this->_table_crm_contacts);
        }
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }

        return [];
    }

    //End of NOTES

    //Opportunities with Contact
    public function get_contact_relatedto($parent_id, $parent_type)
    {
        //$user_id =  $_SESSION['ss_user_id'];
        $this->db->select("o.oppt_id,o.oppt_name,o.stage,o.amount,o.close_date,CONCAT((u.first_name),(' '),(u.last_name)) as usrname");
        //$this->db->where('o.userid', $user_id);
        //$this->db->where("(o.userid=$user_id OR o.share_user_id=$user_id)");
        if ($parent_type == 'C') {
            $this->db->where('o.contact_id', $parent_id);
        }
        if ($parent_type == 'A') {
            $this->db->where('o.account_id', $parent_id);
        }
        $this->db->from($this->_table_crm_oppurtinity . ' o');
        $this->db->join($this->_table_users . ' u', 'u.user_id = o.share_user_id', 'left');
        $this->db->order_by('modify_date', 'desc');
        $query = $this->db->get();
        //echo $this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            return $query->result();
        }

        return [];
    }

    //Contacts with Account
    public function get_account_contacts($account_id)
    {
       //$user_id =  $_SESSION['ss_user_id'];
		$this->db->select("c.user_first,c.user_last,c.contact_id,c.user_title,c.email,c.phone,CONCAT((u.first_name),(' '),(u.last_name)) as usrname");
		//$this->db->where('userid', $user_id);
		$this->db->where('c.account_id', $account_id);
		$this->db->from($this->_table_crm_contacts." c");
		$this->db->join($this->_table_users." u", 'u.user_id = c.share_user_id','left');
		$this->db->order_by("c.modify_date","desc");
		$query = $this->db->get();
    	if ($query->num_rows() > 0)
    	{
    		return $query->result();
    	}

    }

    //TASKS

    //Get search list for Task
    public function task_search($data, $users)
    {
        //echo '<pre>'; print_r($data); echo '</pre>';
        $this->db->select("t.task_id,t.task_subject,t.task_priority,t.task_phone,t.task_duedate,t.task_related,t.task_relatedto,CONCAT((u.first_name),(' '),(u.last_name)) as usrname");
        $this->db->from($this->_table_crm_tasks . ' t');
        $this->db->join($this->_table_users . ' u', 'u.user_id = t.share_user_id', 'left');
        $this->db->where_in('t.share_user_id', $users);
        $this->db->group_by('t.task_relatedto');

        $nc = count($data);
        if ($nc > 1) {
            $ob = '(';
            $cb = ')';
        }
        $n = 0;
        foreach ($data as $ki => $kval) {
            $n++;
            $sb = '';
            if ($n == 1) {
                if ($ki == 'task_duedate' || $ki == 'task_created' || $ki == 'task_modified') {
                    $this->db->where($ob . "t.$ki='$kval'", null, false);
                } else {
                    $this->db->where($ob . "t.$ki LIKE '%$kval%'", null, false);
                }
            } else {
                if ($n == $nc && $cb) {
                    $eb = $cb;
                }
                if ($ki == 'task_duedate' || $ki == 'task_created' || $ki == 'task_modified') {
                    $this->db->or_where("t.$ki='$kval'" . $eb, null, false);
                } else {
                    $this->db->or_where("t.$ki LIKE '%$kval%'" . $eb, null, false);
                }
            }
        }
        $this->db->order_by('task_id', 'desc');
        $query = $this->db->get();
        //echo $this->db->last_query()."<br>";
        return $query->result();
    }

    public function get_share_recordings($parent_ids,$contact_id,$limit=0){
        
        $phone = preg_replace('/[^0-9]/', '', $this->getContactPhoneNumber($contact_id));

        $this->db->select('*');
        $this->db->where_in('user_id',$parent_ids);
        $this->db->where("REPLACE(call_to,' ','') LIKE '%$phone'", NULL, FALSE);
        $this->db->from('crm_rc_recordings');
        if($limit) $this->db->limit($limit);

        $query = $this->db->get();
    	if ($query->num_rows() > 0)
    	{
    		return $query->result();
        }
        
		return array();
    }

    public function getContactPhoneNumber($id){
        $this->db->select('phone');
        $this->db->where('contact_id',$id);
        $this->db->from($this->_table_crm_contacts);
        $query = $this->db->get();
        if ($query->num_rows() > 0)
    	{
    		return $query->result()[0]->phone;
    	}  
		return false;
    }

    //Get Task list as array
    public function get_all_tasks($parent_id = 0, $parent_type = '', $limit = 0, $status = '', $dtwhere = '')
    {
        if ($parent_id) {
            $parentNote = $this->get_notes_parent($parent_id, $parent_type);
            if (!$parentNote) {
                return [];
            }
        }
        $user_id = $_SESSION['ss_user_id'];
        //$this->db->select("t.sfid,t.task_subject,t.task_modified,t.task_id,t.task_duedate,t.task_status,t.task_priority,t.task_related,t.task_relatedto,t.task_info,CONCAT((u.first_name),(' '),(u.last_name)) as usrname,t.task_name,(SELECT SUM(intpoints) FROM ".$this->_table_prospect_points." p WHERE p.rctype=t.task_related and p.contact=t.task_relatedto) as qpoints");

        $this->db->select("t.sfid,t.task_subject,t.task_modified,t.task_id,t.task_duedate,t.task_status,t.task_priority,t.task_related,t.task_relatedto,t.task_info,CONCAT((u.first_name),(' '),(u.last_name)) as usrname,t.task_name, IF(t.task_related='C',(SELECT p.ipoints FROM " . $this->_table_crm_contacts . ' p WHERE t.task_relatedto=p.contact_id),(SELECT p.ipoints FROM ' . $this->_table_crm_accounts . ' p WHERE t.task_relatedto=p.account_id)) as qpoints');
        //$this->db->where('userid', $user_id);
        if ($parent_type) {
            $this->db->where('t.task_related', $parent_type);
        }
        if ($parent_id) {
            $this->db->where('t.task_relatedto', $parent_id);
        }
        if ($status == 1) {
            $this->db->where('t.task_status', 'Completed');
        } elseif ($status == 2) {
            $this->db->where('t.task_status !=', 'Completed');
        }
        if ($dtwhere) {
            $this->db->where($dtwhere, null, false);
        } elseif (!$parent_id) {
            $this->db->where('t.share_user_id', $user_id);
        }
        //if($limit && $status==2) $this->db->where('t.task_duedate >', '0000-00-00');
        $this->db->from($this->_table_crm_tasks . ' t');
        $this->db->join($this->_table_users . ' u', 'u.user_id = t.share_user_id', 'left');
        if ($limit && $status == 2) {
            $this->db->order_by('t.task_duedate', 'asc');
        } elseif ($limit >= 0 && $status == 1) {
            $this->db->order_by('t.task_modified', 'desc');
        } else {
            if (!$limit) {
                $this->db->order_by('t.task_duedate', 'asc');
            }
            $this->db->order_by('t.task_modified', 'desc');
        }
        if ($limit) {
            $this->db->limit($limit);
        }
        $query = $this->db->get();
        //$query = $this->db->get($this->_table_crm_tasks);
        //echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            return $query->result();
        }

        return [];
    }

    //Search Task
    public function search_task($where)
    {
        $this->db->where($where[0], $where[1]);//$where = array('column','value')
        $this->db->where_in('userid', $where[2]);
        $query = $this->db->get($this->_table_crm_tasks);
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }

        return [];
    }

    //Search Task by condtions
    public function get_task_bywhere($where)
    {
        $this->db->select('count(*) as tkcount');
        if (isset($where['task_duedate'])) {
            $this->db->where('task_duedate', $where['task_duedate']);
        }
        if (isset($where['task_priority'])) {
            $this->db->where('task_priority', $where['task_priority']);
        }
        if (isset($where['task_status'])) {
            $this->db->where('task_status', $where['task_status']);
        }
        //if(isset($where['share_user_id']))$this->db->where('share_user_id', $where['share_user_id']);
        if (isset($where['task_related'])) {
            $this->db->where('task_related', $where['task_related']);
        }
        if (isset($where['task_relatedto'])) {
            $this->db->where('task_relatedto', $where['task_relatedto']);
        }
        if (isset($where['task_subject'])) {
            $this->db->where('task_subject', $where['task_subject']);
        }
        if (isset($where['mailchimp'])) {
            $this->db->where('mailchimp', $where['mailchimp']);
        }
        $query = $this->db->get($this->_table_crm_tasks);
        if ($query->num_rows() > 0) {
            return $query->row()->tkcount;
        }

        return 0;
    }

    //Get Next Task
    public function get_next_task($parent_id, $parent_type)
    {
        //$user_id =  $_SESSION['ss_user_id'];
        $today = date('Y-m-d');
        $this->db->select('task_subject,task_id');
        //$this->db->where('userid', $user_id);
        $this->db->where('task_related', $parent_type);
        $this->db->where('task_relatedto', $parent_id);
        //$this->db->where("task_duedate >=",$today);
        $this->db->where("task_duedate >= '$today'", null, false);
        $this->db->where('task_status !=', 'Completed');
        $this->db->order_by('task_duedate', 'asc');
        $query = $this->db->get($this->_table_crm_tasks);
        //echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            $taskRow = $query->row_array();
            $parentRow = $this->get_notes_parent($taskRow['task_relatedto'], $taskRow['task_related']);
            if (!$parentRow) {
                return [];
            }

            return $taskRow;
        }

        return [];
    }

    //Get Task record
    public function get_task($task_id)
    {
        $user_id = $_SESSION['ss_user_id'];
        $this->db->where('task_id', $task_id);
        //$this->db->where('userid', $user_id);
        $query = $this->db->get($this->_table_crm_tasks);
        if ($query->num_rows() > 0) {
            $taskRow = $query->row_array();
            //($taskRow);exit;
            $parentRow = $this->get_notes_parent($taskRow['task_relatedto'], $taskRow['task_related']);
            if (!$parentRow) {
                return [];
            }

            return $taskRow;
            //return $query->row_array();
        }

        return [];
    }

    //Save Task
    public function save_task($data, $task_id = 0)
    {
        //echo '<pre>'; print_r($data); echo '</pre>';
        $user_id = isset($_SESSION['ss_user_id']) ? $_SESSION['ss_user_id'] : 0;
        if ($task_id) {
            //$data['task_modified']=date("Y-m-d H:i:s");
            $this->db->where('task_id', $task_id);
            //$this->db->where('userid', $user_id);
            $this->db->update($this->_table_crm_tasks, $data);
        } else {
            if (!isset($data['userid'])) {
                $data['userid'] = $user_id;
            }
            //if dates not set
            if (!isset($data['task_created'])) {
                $data['task_created'] = date('Y-m-d H:i:s');
                $data['task_modified'] = date('Y-m-d H:i:s');
            }
            $this->db->insert($this->_table_crm_tasks, $data);
            $task_id = $this->db->insert_id();
        }
        //echo $this->db->last_query();
        return $task_id;
    }

    //Delete Task
    public function delete_task($task_id)
    {
        //$user_id = $_SESSION['ss_user_id'];
        $this->db->where('task_id', $task_id);
        //$this->db->where('userid', $user_id);
        $this->db->delete($this->_table_crm_tasks);
        $this->delete_prospect_points($task_id, 'T');
        $this->delete_objections($task_id, 'T');
        $this->delete_interactions($task_id, 'T');
    }

    //Delete all Task from Specific Object
    public function delete_objecttasks($parent_id, $parent_type)
    {
        //$user_id = $_SESSION['ss_user_id'];
        //$this->db->where('userid', $user_id);
        $this->db->where('task_related', $parent_type);
        $this->db->where('task_relatedto', $parent_id);
        $this->db->delete($this->_table_crm_tasks);
    }

    //End of Tasks
    //Get Current User shared user ids
    public function get_shared_users($user_id = 0)
    {
        $users_list = $this->get_CurrentUser();
        $user_id = $_SESSION['ss_user_id'];
        //$user_id =  4267;
        //$user_id =  3005;
        $this->db->select("u.user_id,,CONCAT((u.first_name),(' '),(u.last_name)) as usrname");
        $this->db->where('s.userfrom', $user_id);
        $this->db->from($this->_table_user_shared . ' s');
        $this->db->join($this->_table_users . ' u', 'u.user_id = s.userto', 'left');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $users_list = array_merge($users_list, $query->result());
        }

        return $users_list;
    }

    //Get all shared users
    public function get_all_shared_users($user_ids)
    {
        $users_list = [];
        $this->db->select("user_id,CONCAT((first_name),(' '),(last_name)) as usrname");
        $this->db->where_in('user_id', $user_ids);
        $this->db->from($this->_table_users);
        $this->db->order_by('usrname', 'asc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $users_list = $query->result();
        }

        return $users_list;
    }

    public function get_CurrentUser($user_id = 0)
    {
        $users_list = [];
        if (!$user_id) {
            $user_id = $_SESSION['ss_user_id'];
        }
        $this->db->select("user_id,CONCAT((first_name),(' '),(last_name)) as usrname");
        $this->db->where('user_id', $user_id);
        $query = $this->db->get($this->_table_users);
        if ($query->num_rows() > 0) {
            $users_list[] = $query->row();
        }

        return $users_list;
    }

    //Prospect Points
    //Save Points
    public function save_points($data, $update = [])
    {
        $pinfo = [];
        $user_id = isset($_SESSION['ss_user_id']) ? $_SESSION['ss_user_id'] : 0;
        // echo '<pre>'; print_r($data); echo '</pre>';
        if ($update) {
            //echo "Update";
            if (isset($update['userid'])) {
                $user_id = $update['userid'];
            }
            $this->db->where('userid', $user_id);
            $this->db->where('contact', $update['contact']);
            $this->db->where('rctype', $update['rctype']);
            $this->db->where('pdate', $update['pdate']);
            $this->db->where('cat', $update['cat'] ? $update['cat'] : 0);
            $this->db->update($this->_table_prospect_points, $data);
            //echo $this->db->last_query(); exit;
            $pinfo = ['rctype' => $update['rctype'], 'contact' => $update['contact']];
        } else {
            //echo "Insert";
            if (!isset($data['userid'])) {
                $data['userid'] = $user_id;
            }
            $this->db->insert($this->_table_prospect_points, $data);
            //echo $this->db->last_query();exit;
            $pinfo = ['rctype' => $data['rctype'], 'contact' => $data['contact']];
        }
        $this->save_record_prospect_points($pinfo);
    }

    //get Points
    public function get_points($whereis)
    {
        $user_id = isset($_SESSION['ss_user_id']) ? $_SESSION['ss_user_id'] : 0;
        if (isset($whereis['userid'])) {
            $user_id = $whereis['userid'];
        }
        $this->db->where('userid', $user_id);
        $this->db->where('contact', $whereis['contact']);
        $this->db->where('rctype', $whereis['rctype']);
        $this->db->where('pdate', $whereis['pdate']);
        $this->db->where('cat', $whereis['cat']);
        //$this->db->where('userid', $user_id);
        $query = $this->db->get($this->_table_prospect_points);
        //echo $this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }

        return [];
    }
	
	//get Points
	public function get_npoints($whereis) 
    {
		$user_id = isset($_SESSION['ss_user_id'])?$_SESSION['ss_user_id']:0;
		if(isset($whereis['userid'])) $user_id = $whereis['userid'];
		$this->db->where('userid', $user_id);	
		$this->db->where('contact', $whereis['contact']);
		$this->db->where('rctype', $whereis['rctype']);
		$this->db->where('pdate', $whereis['pdate']);
		$this->db->where('cat', $whereis['cat']);
		$this->db->where('cat', $whereis['cat']);
		$this->db->where('noteid', $whereis['noteid']);
    	//$this->db->where('userid', $user_id);
    	$query = $this->db->get($this->_table_prospect_points);
		//echo $this->db->last_query();exit;
    	if ($query->num_rows() > 0)
    	{
			return $query->row_array();
    	}
		return array();
    }

    //Total points Count
    public function get_totalpoints_count($cid, $rctype = 'C', $where = '')
    {
        //$user_id = $_SESSION['ss_user_id'];
        $this->db->select('SUM(intpoints) as ipt,SUM(purpoints) as ppt');
        //$this->db->where('userid', $user_id);
        $this->db->where('contact', $cid);
        $this->db->where('rctype', $rctype);
        if ($where) {
            $this->db->where($where, null, false);
        }
        $this->db->order_by('pdate', 'asc');
        $query = $this->db->get($this->_table_prospect_points);
        //echo $this->db->last_query().'--';
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }

        return [];
    }

    //Total points List
    public function get_points_list($cid, $rctype = 'C', $where = '')
    {
        $user_id = $_SESSION['ss_user_id'];
        $this->db->select('pdate,intpoints as ipt,purpoints as ppt');
        //$this->db->where('userid', $user_id);
        $this->db->where('contact', $cid);
        $this->db->where('rctype', $rctype);
        if ($where) {
            $this->db->where($where, null, false);
        }
        $this->db->order_by('pdate', 'asc');
        $query = $this->db->get($this->_table_prospect_points);
        //echo $this->db->last_query().'--';
        if ($query->num_rows() > 0) {
            return $query->result();
        }

        return [];
    }

    //interviewer applicant quality points
    public function applicant_quality_points($where, $rctype = '')
    {
        $this->db->select('sum(intpoints) as ipt');
        $this->db->from($this->_table_prospect_points);
        $this->db->where($where, null, false);
        $this->db->where('rctype', $rctype);
        $query = $this->db->get();
        //echo $this->db->last_query().'<br>';
        return $query->row_array();
    }

    //Prospect Users
    public function prospect_users($where, $orderby = '', $rctype = '')
    {
        $this->db->select("sum(p.intpoints) as ipt,sum(p.purpoints) as ppt,p.userid as user_id,CONCAT((u.first_name),(' '),(u.last_name)) as usrname");
        $this->db->from($this->_table_prospect_points . ' p');
        $this->db->join($this->_table_users . ' u', 'u.user_id = p.userid', 'left');

        /*$this->db->select("sum(p.intpoints) as ipt,sum(p.purpoints) as ppt,u.user_id,CONCAT((u.first_name),(' '),(u.last_name)) as usrname");
        $this->db->from($this->_table_users." u");
        $this->db->join($this->_table_prospect_points." p", 'u.user_id = p.userid','left');*/

        //$this->db->from($this->_table_prospect_points." p");
        //$this->db->join($this->_table_users." u", 'u.user_id = p.userid','left');
        //if(!$where['p.rctype']) $where .="and p.rctype='C'";
        $this->db->where($where, null, false);
        //echo $rctype;
        if ($rctype == 'CA') {
            $this->db->where('p.rctype', $rctype);
        } else {
            $this->db->where('p.rctype!="CA"', null, false);
        }
        $this->db->group_by('p.userid');
        if ($orderby) {
            $this->db->order_by($orderby, 'desc');
        } else {
            $this->db->order_by('usrname', 'asc');
        }
        $query = $this->db->get();
        //echo $this->db->last_query().'--';
        //exit;
        if ($query->num_rows() > 0) {
            return $query->result();
        }

        return [];
    }

    //Prospect User points
    public function prospect_user_points_OLD($userids, $where, $limit = 0, $rctype = 'C', $offset = 0)
    {
        $this->db->select('userid,pdate,intpoints,purpoints');
        $this->db->from($this->_table_prospect_points);
        $this->db->where_in('userid', $userids);
        $this->db->where($where, null, false);
        if ($rctype) {
            $this->db->where('rctype', $rctype);
        } else {
            $this->db->where('rctype!="CA"', null, false);
        }
        $this->db->order_by('pdate', 'asc');
        if ($limit) {
            $this->db->limit($limit);
        }
        if ($offset) {
            $this->db->offset($offset);
        }
        $query = $this->db->get();
        //echo $this->db->last_query().'--';
        if ($query->num_rows() > 0) {
            return $query->result();
        }

        return [];
    }

    //Prospect User points
    public function prospect_user_points($userids, $where, $limit = 0, $rctype = 'C', $offset = 0)
    {
        $this->db->select('pdate,SUM(intpoints) as intpoints,SUM(purpoints) as purpoints');
        $this->db->from($this->_table_prospect_points);
        $this->db->where_in('userid', $userids);
        $this->db->where($where, null, false);
        if ($rctype) {
            $this->db->where('rctype', $rctype);
        } else {
            $this->db->where('rctype!="CA"', null, false);
        }
        $this->db->group_by('pdate');
        $this->db->order_by('pdate', 'asc');
        if ($limit) {
            $this->db->limit($limit);
        }
        if ($offset) {
            $this->db->offset($offset);
        }
        $query = $this->db->get();
        //echo $this->db->last_query().'--';
        if ($query->num_rows() > 0) {
            return $query->result();
        }

        return [];
    }

    //Prospect User point Dates
    public function prospect_user_points_one($userids, $where, $limit = 0, $rctype = 'C', $offset = 0)
    {
        $this->db->select('pdate');
        $this->db->from($this->_table_prospect_points);
        $this->db->where_in('userid', $userids);
        $this->db->where($where, null, false);
        if ($rctype) {
            $this->db->where('rctype', $rctype);
        } else {
            $this->db->where('rctype!="CA"', null, false);
        }
        $this->db->group_by('pdate');
        $this->db->order_by('pdate', 'asc');
        if ($limit) {
            $this->db->limit($limit);
        }
        if ($offset) {
            $this->db->offset($offset);
        }
        $query = $this->db->get();
        //echo $this->db->last_query().'--';
        if ($query->num_rows() > 0) {
            return $query->result();
        }

        return [];
    }

    //Prospect User points by date
    public function prospect_user_points_two($userids, $pdate, $rctype = 'C')
    {
        $this->db->select('userid,SUM(intpoints) as intpoints,SUM(purpoints) as purpoints');
        $this->db->from($this->_table_prospect_points);
        $this->db->where_in('userid', $userids);
        if ($rctype) {
            $this->db->where('rctype', $rctype);
        } else {
            $this->db->where('rctype!="CA"', null, false);
        }
        $this->db->where('pdate', $pdate);
        $this->db->group_by('userid');
        $this->db->order_by('userid', 'asc');
        if ($limit) {
            $this->db->limit($limit);
        }
        if ($offset) {
            $this->db->offset($offset);
        }
        $query = $this->db->get();
        //echo $this->db->last_query().'--';
        if ($query->num_rows() > 0) {
            return $query->result();
        }

        return [];
    }

    //Delete Prospect Points
    public function delete_prospect_points($recid, $rctype = 'C')
    {
        if ($rctype == 'N') {
            $this->db->where('noteid', $recid);
            $this->db->where('rctype!="CA"', null, false);
        } elseif ($rctype == 'T') {
            $this->db->where('taskid', $recid);
        } else {
            $this->db->where('contact', $recid);
            $this->db->where('rctype', $rctype);
        }
        $this->db->delete($this->_table_prospect_points);
    }

    //OBJECTIONS
    //Check objection
    public function check_objection($obval)
    {
        $this->db->select('obj_id');
        $this->db->where("TRIM(REPLACE((obj_val),(' '),('')))='$obval'", null, false);
        $query = $this->db->get($this->_table_objections_usage);
        if ($query->num_rows() > 0) {
            $row = $query->row_array();

            return $row['obj_id'];
        }

        return 0;
    }

    //Save Objection
    public function save_objection($data)
    {
        $user_id = $_SESSION['ss_user_id'];
        $data['obj_user'] = $user_id;
        $this->db->insert($this->_table_objections_usage, $data);
        //echo $this->db->last_query().'--';
        return $this->db->insert_id();
        /*$user_id = $_SESSION['ss_user_id'];
        if($obj_id) {
                $this->db->where('obj_id', $obj_id);
                $this->db->update($this->_table_objections_usage,$data);
         } else {
             $data['obj_user']=$user_id;
                $this->db->insert($this->_table_objections_usage,$data);
         }*/
    }

    //Check objection date
    public function check_objection_date($objid, $objdate)
    {
        //$this->db->select("obj_id");
        $user_id = $_SESSION['ss_user_id'];
        $this->db->where('objid', $objid);
        $this->db->where('objuser', $user_id);
        $this->db->where('objdate', $objdate);
        $query = $this->db->get($this->_table_objections_count);
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }

        return [];
    }

    //Save Objection Dates
    public function save_objection_date($data, $where = '')
    {
        $user_id = $_SESSION['ss_user_id'];
        if ($where) {
            $this->db->where('objid', $where['objid']);
            $this->db->where('objuser', $user_id);
            $this->db->where('objdate', $where['objdate']);
            $this->db->update($this->_table_objections_count, $data);
        } else {
            $data['objuser'] = $user_id;
            $this->db->insert($this->_table_objections_count, $data);
        }
    }

    //Get objections
    public function get_objections($obCust = '', $obUser = 0)
    {
        $this->db->distinct();
        $this->db->select('obj_val,obj_count,obj_id');
        if ($obUser) {
            $this->db->where('obj_user', $obUser);
        }
        if ($obCust) {
            $this->db->where('obj_custom', $obCust);
        }
        $query = $this->db->get($this->_table_objections_usage);
        //echo $this->db->last_query().'--';
        if ($query->num_rows() > 0) {
            return $query->result();
        }

        return [];
    }

    //Get objections
    public function get_Iobjection($objId)
    {
        $this->db->select('obj_val');
        $this->db->where('obj_id', $objId);
        $query = $this->db->get($this->_table_objections_usage);
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }

        return [];
    }

    //Get objections by filter
    public function get_objections_byfilters($obUser, $where)
    {
        //$this->db->distinct();
        $this->db->select('obv.obj_val,SUM(obc.objcount) as obj_count');
        $this->db->from($this->_table_objections_count . ' obc');
        $this->db->join($this->_table_objections_usage . ' obv', 'obv.obj_id = obc.objid', 'left');
        //if($obUser) $this->db->where('obc.objuser', $obUser);
        if ($obUser) {
            $this->db->where_in('obc.objuser', $obUser);
        }
        $this->db->where($where, null, false);
        $this->db->group_by('obv.obj_val');
        $this->db->order_by('obv.obj_val', 'asc');
        $query = $this->db->get();
        //echo $this->db->last_query().'--';
        if ($query->num_rows() > 0) {
            return $query->result();
        }

        return [];
    }

    //Get objections by filter
    public function get_objections_byfilters2($obUser, $where)
    {
        $this->db->distinct();
        $this->db->select('obv.obj_val,obc.objcount as obj_count');
        $this->db->from($this->_table_objections_count . ' obc');
        $this->db->join($this->_table_objections_usage . ' obv', 'obv.obj_id = obc.objid', 'left');
        if ($obUser) {
            $this->db->where('obc.objuser', $obUser);
        }
        $this->db->where($where, null, false);
        $query = $this->db->get();
        //echo $this->db->last_query().'--';
        if ($query->num_rows() > 0) {
            return $query->result();
        }

        return [];
    }

    //Objections from Objection Map which are newly entered by user
    public function get_objection_Campaign()
    {
        $user_id = $_SESSION['ss_user_id'];
        $this->db->select('o.ob_title');
        $this->db->from('tbl_objections o');
        $this->db->join($this->_table_campaign . ' c', 'c.campaign_id = o.ob_campaign');
        $this->db->where('c.user_id', $user_id);
        $this->db->where('c.trash', 0);
        $this->db->group_by('o.ob_title');
        $this->db->order_by('o.ob_title', 'asc');
        $query = $this->db->get();
        //echo $this->db->last_query().'--';
        if ($query->num_rows() > 0) {
            return $query->result();
        }

        return [];
    }

    //Delete Objections
    public function delete_objections($recid, $rctype = 'C')
    {
        //Delete Objection Counts
        $delete_objcount = 'DELETE t1 FROM ' . $this->_table_objections_count . ' t1 
		  JOIN ' . $this->_table_objections_usage . ' t2 ON t1.objid = t2.obj_id ';
        if ($rctype == 'T') {
            $delete_objcount .= ' WHERE t2.obj_task = ?';
            $this->db->query($delete_objcount, [$recid]);

            //Delete Objections count
            $where = "FIND_IN_SET('" . $recid . "', objtask)";
            $this->db->where($where, null, false);
            $query = $this->db->get($this->_table_objections_count);
            if ($query->num_rows() > 0) {
                $objCountRow = $query->row_array();
                if ($objCountRow['objtask'] == $recid) {
                    $delete_objcount_query = 'DELETE FROM ' . $this->_table_objections_count . ' WHERE objtask = ?';
                    $this->db->query($delete_objcount_query, [$recid]);
                } else {
                    $taskids = explode(',', $objCountRow['objtask']);
                    $tkey = array_search($recid, $taskids);
                    unset($taskids[$tkey]);
                    $taskids = array_filter($taskids);
                    $taskids = implode(',', $taskids);
                    $update_objcount_query = 'UPDATE ' . $this->_table_objections_count . ' SET objtask=?,objcount=objcount-1 WHERE objtask = ?';
                    $this->db->query($update_objcount_query, [$taskids, $objCountRow['objtask']]);
                }
            }
        } else {
            $delete_objcount .= ' WHERE t2.obj_rctype = ? and t2.obj_recid = ?';
            $this->db->query($delete_objcount, [$rctype, $recid]);
        }
        $this->db->flush_cache();
        //Delete Objection Usage
        if ($rctype == 'T') {
            $this->db->where('obj_task', $recid);
        } else {
            $this->db->where('obj_recid', $recid);
            $this->db->where('obj_rctype', $rctype);
        }
        $this->db->delete($this->_table_objections_usage);
    }

    //End of OBJECTIONS
    //INTERACTIONS
    //Check interaction date
    //public function check_interaction_date($intr_sno,$idate,$userid=0)
    public function check_interaction_date($where, $userid = 0)
    {
        if (!$userid) {
            $userid = $_SESSION['ss_user_id'];
        }
        $this->db->select('intr_id,intr_count,intr_info');
        $this->db->where('intr_date', $where['intr_date']);
        $this->db->where('intr_sno', $where['intr_sno']);
        $this->db->where('intr_rctype', $where['intr_rctype']);
        $this->db->where('intr_recid', $where['intr_recid']);
        $query = $this->db->get($this->_table_interaction_usage);
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }

        return [];
    }

    //Save interaction Dates
    public function save_interaction_date($data, $where = '')
    {
        $user_id = isset($_SESSION['ss_user_id']) ? $_SESSION['ss_user_id'] : 0;
        if ($where) {
            $this->db->where('intr_id', $where['intr_id']);
            $this->db->update($this->_table_interaction_usage, $data);
        } else {
            if (!isset($data['intr_user'])) {
                $data['intr_user'] = $user_id;
            }
            $this->db->insert($this->_table_interaction_usage, $data);
        }
        //echo $this->db->last_query().'--';
    }

    //Delete interaction
    public function delete_interactions($recid, $rctype = 'C')
    {
        //Delete Objection Usage
        if ($rctype == 'T') {
            $this->db->where('intr_task', $recid);
        } else {
            $this->db->where('intr_rctype', $rctype);
            $this->db->where('intr_recid', $recid);
        }
        $this->db->delete($this->_table_interaction_usage);
    }

    //Get interaction counts by date wise
    public function get_interaction_counts($user, $where, $options)
    {
        $this->db->select('intr_sno,SUM(intr_count) as ic');
        $this->db->where_in('intr_sno', $options);
        $this->db->where('intr_rctype', 'C');
        if (is_array($user)) {
            $this->db->where_in('intr_user', $user);
        } else {
            $this->db->where('intr_user', $user);
        }
        $this->db->where($where, null, false);
        $this->db->group_by('intr_sno');
        $query = $this->db->get($this->_table_interaction_usage);
        //echo $this->db->last_query().'--';
        //exit;
        if ($query->num_rows() > 0) {
            return $query->result();
        }

        return [];
    }

    //Get interaction counts for all date
    public function get_interaction_date_counts($user, $where, $options)
    {
        $this->db->select('intr_sno,intr_count,intr_date');
        $this->db->where_in('intr_sno', $options);
        if (is_array($user)) {
            $this->db->where_in('intr_user', $user);
        } else {
            $this->db->where('intr_user', $user);
        }
        $this->db->where($where, null, false);
        $this->db->order_by('intr_date', 'asc');
        $query = $this->db->get($this->_table_interaction_usage);
        //echo $this->db->last_query().'--';
        if ($query->num_rows() > 0) {
            return $query->result();
        }

        return [];
    }
    
    public function get_email_reports_subjectemail($user,$where,$options,$limit=10,$offset=0) 
    {
		
		$this->db->distinct();
		$this->db->select("i.intr_info");
		$this->db->from($this->_table_interaction_usage." i");	
		if(is_array($user)) $this->db->where_in('i.intr_user', $user);
		else $this->db->where('i.intr_user', $user);
		$this->db->where($where,NULL,FALSE);
		$this->db->where('i.intr_sno', $options);
    	$query = $this->db->get();
		//echo $this->db->last_query().'--';
		//echo $query->num_rows();
		//exit;
    	if ($query->num_rows() > 0)
    	{
			$response = $query->result_array();
			foreach($response as $res)
			{
				$subjects[] =  $res['intr_info'];
			}
			
    	}
		return $subjects;
    }

    //Get interaction email reports
    public function get_email_reports($user, $where, $options, $limit = 10, $offset = 0)
    {
        $this->db->distinct();
		$this->db->select("i.intr_recid,i.intr_info,i.intr_date,c.user_first,c.user_last,c.email,c.phone,c.account_id,a.account_name");
		$this->db->from($this->_table_interaction_usage." i");
		$this->db->join($this->_table_crm_contacts." c", 'c.contact_id = i.intr_recid');
		$this->db->join($this->_table_crm_accounts." a", 'a.account_id = c.account_id','left');		
		if(is_array($user)) $this->db->where_in('i.intr_user', $user);
		else $this->db->where('i.intr_user', $user);
		$this->db->where($where,NULL,FALSE);
		$this->db->where('i.intr_sno', $options);
		$this->db->where('i.intr_rctype', 'C');
		$this->db->group_by('i.intr_recid');
		$this->db->order_by('i.intr_date', 'desc');
		$this->db->limit($limit);
		$this->db->offset($offset);
    	$query = $this->db->get();
		//echo $this->db->last_query().'--';
    	if ($query->num_rows() > 0)
    	{
			return $query->result();
    	}
		return array();
    }

    //Get interaction email reports count
    public function get_email_reports_count($user, $where, $options)
    {
        $this->db->select('COUNT(DISTINCT i.intr_recid) AS erc');
        $this->db->from($this->_table_interaction_usage . ' i');
        if (is_array($user)) {
            $this->db->where_in('i.intr_user', $user);
        } else {
            $this->db->where('i.intr_user', $user);
        }
        $this->db->where($where, null, false);
        $this->db->where('i.intr_sno', $options);
        $this->db->where('i.intr_rctype', 'C');
        $query = $this->db->get();
        //echo $this->db->last_query().'--';
        return $query->row()->erc;
    }

    //End of INTERACTIONS
    //Email Templates
    //Save email tempate
    public function save_email_template($data, $id = 0)
    {
        $user_id = $_SESSION['ss_user_id'];
        if ($id) {
            $this->db->where('userid', $user_id);
            $this->db->where('tid', $id);
            $this->db->update($this->_table_email_templates, $data);
        } else {
            $data['userid'] = $user_id;
            $this->db->insert($this->_table_email_templates, $data);
            $id = $this->db->insert_id();
        }
        //echo $this->db->last_query().'--'; exit;
        return $id;
    }

    //Delete email tempate
    public function delete_email_template($tid)
    {
        $user_id = $_SESSION['ss_user_id'];
        //Delete email or thread
        $this->db->where('userid', $user_id);
        $this->db->where('tid', $tid);
        $this->db->delete($this->_table_email_templates);
        //Delete sub emails under thread
        $this->db->where('userid', $user_id);
        $this->db->where('schparent', $tid);
        $this->db->delete($this->_table_email_templates);
        //Delete email tasks
        $this->delete_email_tasks($tid);
    }

    //Delete email tempate sub
    public function delete_email_templates_sub($tids)
    {
        $user_id = $_SESSION['ss_user_id'];
        //Delete sub emails under thread
        $this->db->where('userid', $user_id);
        $this->db->where_in('tid', $tids);
        $this->db->delete($this->_table_email_templates);
    }

    //Get user saved email templates
    public function get_uemail_templates($where = null)
    {
        $user_id = $_SESSION['ss_user_id'];
        //$this->db->select("tid,subject");
        $this->db->where('userid', $user_id);
        if ($where) {
            if (isset($where['etype'])) {
                $this->db->where('etype', $where['etype']);
            }
            if (isset($where['tid'])) {
                $this->db->where('tid', $where['tid']);
            }
            if (isset($where['schparent'])) {
                $this->db->where('schparent', $where['schparent']);
            }
        }
        if (!isset($where['etype'])) {
            $this->db->where('etype', 'crm');
        }
        $this->db->order_by('sorder', 'asc');
        $this->db->order_by('tid', 'asc');
        $query = $this->db->get($this->_table_email_templates);
        //echo $this->db->last_query().'--';
        if ($query->num_rows() > 0) {
            return $query->result();
        }

        return [];
    }

    //Get user saved email template
    public function get_uemail_template($id)
    {
        $user_id = $_SESSION['ss_user_id'];
        $this->db->select('content,subject');
        $this->db->where('userid', $user_id);
        $this->db->where('tid', $id);
        $query = $this->db->get($this->_table_email_templates);
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }

        return [];
    }

    //Get user saved email template
    public function get_user_saved_email_template($id, $userid)
    {
        $this->db->select('tempname,content');
        $this->db->where('userid', $userid);
        $this->db->where('tid', $id);
        $query = $this->db->get($this->_table_email_templates);
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }

        return [];
    }

    //Save email notification
    public function save_email_notify($data)
    {
        $this->db->insert($this->_table_crm_notifies, $data);
    }

    //Get user notifications
    public function get_user_notifications($userid, $ofset = 100)
    {
        $limit = 1;
        $narr = ['ncount' => 0, 'nlist' => []];
        //unread messages

        $this->db->select('view');
        $this->db->where('userid', $userid);
        $this->db->where('view', '0');
        $query = $this->db->get($this->_table_crm_notifies);
        $narr['ncount'] = $query->num_rows();
        /*$narr['ncount'] = $this->db
                            ->where('userid', $userid)
                            ->where('view', '0')
                            ->count_all_results($this->_table_crm_notifies);
        echo $this->db->last_query().'--';					*/
        //$this->db->flush_cache();

        //delete already viewed notifications but keep 500 only
        $this->keep_notifies($userid);

        //echo $sql = "select nid,info,datetime from ".$this->_table_crm_notifies." where userid=$userid order by datetime desc limit $offset, $limit";
        //$query = $this->db->query($sql);
        $this->db->select('info,datetime,view');
        $this->db->where('userid', $userid);// if($ofset) $this->db->where("nid <$ofset",NULL,FALSE );
        $this->db->order_by('datetime', 'desc');
        //if(!$ofset) $this->db->limit($limit);
        $this->db->limit($ofset);
        //if($offset) $query = $this->db->get($this->_table_crm_notifies,$offset*$limit,$limit);
        //else
        //{
        //$this->db->limit($limit);
        $query = $this->db->get($this->_table_crm_notifies);
        //}
        /*if($offset) $this->db->limit($offset*$limit,$limit);
        else $this->db->limit($limit);*/
        //echo $this->db->last_query().'--';
        // $this->db->flush_cache();
        if ($query->num_rows() > 0) {
            $narr['nlist'] = $query->result();
        }

        return $narr;
    }

    //Keep last 500 notifications
    public function keep_notifies($userid)
    {
        $total = $this->get_notifies_bystatus($userid, '0');
        if ($total > 500) {
            $viewed = $this->get_notifies_bystatus($userid, '1');
            if ($viewed > 500) {
                $this->del_notifies($userid, $total - 500);
            }
            //$unread = $this->get_notifies_bystatus($userid,'0');
        }
    }

    public function get_notifies_bystatus($userid, $status)
    {
        $this->db->where('userid', $userid);
        if ($status != '0') {
            $this->db->where('view', $status);
        }
        $query = $this->db->get($this->_table_crm_notifies);
        //echo $this->db->last_query().'--';
        return $query->num_rows();
    }

    //Delete user notifications
    public function del_notifies($userid, $limit)
    {
        $this->db->limit($limit);
        $this->db->order_by('nid', 'asc');
        $this->db->where('userid', $userid);
        $this->db->where('view', '1');
        $query = $this->db->get($this->_table_crm_notifies);
        $res = $query->result();
        $rcount = $query->num_rows();
        $i = 0;
        foreach ($res as $re) {
            $i++;
            if ($i < $rcount) {
                $c = ',';
            } else {
                $c = '';
            }
            $k .= $re->nid . $c;
        }
        //echo '<pre>'; print_r($k); echo '</pre>'; exit;
        $this->db->query('delete from crm_notifies where nid in(' . $k . ')');
        //echo $this->db->last_query().'--'; exit;
        if ($query->num_rows() > 0) {
            return $query->result();
        }

        return [];
    }

    //Delete user notifications
    public function delete_notifications()
    {
        $user_id = $_SESSION['ss_user_id'];
        $this->db->where('userid', $user_id);
        $this->db->order_by('datetime', 'asc');
        //$this->db->order_by('datetime', 'asc');
        $this->db->limit(5);
        $this->db->delete($this->_table_crm_notifies);
        //echo $this->db->last_query().'--'; exit;
    }

    //Update user notifications view status
    public function update_notifications()
    {
        /*$user_id = $_SESSION['ss_user_id'];
        $data=array("view"=>'1');
        $this->db->where('userid', $user_id);
        $this->db->where('view', '0');
        $this->db->order_by('id', 'desc');
        $this->db->limit(500);
        $this->db->update($this->_table_crm_notifies,$data);*/

        $user_id = $_SESSION['ss_user_id'];

        $data = ['view' => '1'];

        $this->db->where('userid', $user_id);

        $this->db->where('view', '0');

        $this->db->update($this->_table_crm_notifies, $data);
    }

    //Save scheduled email
    public function save_scheduled_email($data, $id = 0, $schdate = '')
    {
        if ($schdate) {
            $this->db->where($schdate, null, false);
            $this->db->update($this->_table_crm_schemail, $data);
        } elseif ($id) {
            $this->db->where('sch_id', $id);
            $this->db->update($this->_table_crm_schemail, $data);
        } else {
            $user_id = $_SESSION['ss_user_id'];
            $data['sch_user'] = $user_id;
            $this->db->insert($this->_table_crm_schemail, $data);
        }
    }

    //Get scheduled email to sent today
    public function get_scheduled_emails()
    {
        $this->db->select('s.*,c.user_first,c.user_last,c.account_id,c.email,c.userid,c.user_title,c.website,c.phone');
        $this->db->from($this->_table_crm_schemail . ' s');
        $this->db->join($this->_table_crm_contacts . ' c', 'c.contact_id = s.sch_contact');
        $this->db->where('s.sch_date', date('Y-m-d H:i:00'));
        $this->db->where("c.email<>''", null, false);
        $this->db->order_by('s.sch_user', 'asc');
        $this->db->order_by('s.sch_contact', 'asc');
        $this->db->order_by('s.sch_subject', 'asc');
        $query = $this->db->get();
        //echo $this->db->last_query().'--';
        if ($query->num_rows() > 0) {
            return $query->result();
        }

        return [];
    }

    //Get scheduled emails count by datetime
    public function get_scheduled_emails_bytime($date1, $date2)
    {
        $this->db->select('count(*) as smcount');
        $this->db->from($this->_table_crm_schemail);
        //$this->db->where('sch_date', $datetime);
        $this->db->where("(sch_date>='$date1' and sch_date<'$date2')", null, false);
        $query = $this->db->get();	//echo $this->db->last_query().'--';
        return $query->row_array();
    }

    //Get scheduled email of contact
    public function get_scheduled_contact_emails($cid, $limit = 0)
    {
        $user_id = $_SESSION['ss_user_id'];
        $this->db->select("se.*,CONCAT((u.first_name),(' '),(u.last_name)) as usrname");
        $this->db->from($this->_table_crm_schemail . ' se');
        $this->db->join($this->_table_users . ' u', 'u.user_id = se.sch_user', 'left');
        //$this->db->where('se.sch_user', $user_id);
        $this->db->where_in('se.sch_user', $this->_parent_users);
        $this->db->where('se.sch_contact', $cid);
        $this->db->order_by('se.sch_date', 'asc');
        if ($limit) {
            $this->db->limit($limit);
        }
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }

        return [];
    }

    //Delete scheduled email
    public function delete_schedule_email($id, $where = null)
    {
        //delete all future scheduled email for contact
        if ($where) {
            //$this->db->where('sch_user', $where['userid']);
            if (isset($where['contact'])) {
                $this->db->where('sch_contact', $where['contact']);
            }
            //if(isset($where['sdate'])) $this->db->where("sch_date>='".$where['sdate']."'",NULL,FALSE);
            if (isset($where['scid'])) {
                $this->db->where('sch_id', $where['scid']);
            }
        } else {
            //$user_id = $_SESSION['ss_user_id'];
            //$this->db->where('sch_user', $user_id);
            $this->db->where('sch_id', $id);
        }
        $this->db->delete($this->_table_crm_schemail);
    }

    public function delete_mschedule_email($id)
    {
        $sids = explode(',', $id);
        if ($sids) {
            foreach ($sids as $sid) {
                $this->db->where('sch_id', $sid);
                $this->db->delete($this->_table_crm_schemail);
            }
        }
    }

    //Get scheduled email
    public function get_scheduled_email($id)
    {
        $user_id = $_SESSION['ss_user_id'];
        $this->db->where('sch_user', $user_id);
        $this->db->where('sch_id', $id);
        $query = $this->db->get($this->_table_crm_schemail);
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }

        return [];
    }

    //End of Email Templates

    public function get_user_unsubscribes_email($user, $ifdate, $itdate)
    {
        $ifdate = $ifdate . ' 00:00:00';
        $itdate = $itdate . ' 23:59:59';
        $sql = "SELECT * FROM `crm_contacts` where userid='" . $user . "' and unsubscribed=1 and create_date between '" . $ifdate . "' AND '" . $itdate . "'  ORDER BY `create_date` DESC";
        $query = $this->db->query($sql, [$something]);
        if ($query->row() > 0) {
            return $query->result();
        }

        return [];
    }

    public function get_user_unsubscribes_email_count($user, $ifdate, $itdate)
    {
        $ifdate = $ifdate . ' 00:00:00';
        $itdate = $itdate . ' 23:59:59';
        $sql = "SELECT COUNT(DISTINCT contact_id) AS erc FROM `crm_contacts` where userid='" . $user . "' and unsubscribed=1 and create_date between '" . $ifdate . "' AND '" . $itdate . "'  ORDER BY `create_date` DESC";
        $query = $this->db->query($sql, [$something]);
        //echo $this->db->last_query().'--';
        return $query->row()->erc;
    }
    public function get_user_scheduled_subjectemail($user,$dtwhere,$limit=200) 
    {
	
		$this->db->distinct();
		$this->db->select("s.sch_subject");
		$this->db->from($this->_table_crm_schemail." s");
		$this->db->join($this->_table_crm_contacts." c", 'c.contact_id = s.sch_contact');
		if($user) $this->db->where('s.sch_user', $user);
		else $this->db->where_in('s.sch_user', $this->_parent_users);
		//$this->db->where($dtwhere,NULL,FALSE);		
		$this->db->group_by('s.sch_id');
		$this->db->order_by('s.sch_date', 'asc');
		$this->db->limit($limit);
		$this->db->offset($offset);
    	$query = $this->db->get();
    	$response = $query->result_array();
		foreach($response as $res)
		{
			$subjects[] =  $res['sch_subject'];
		}
    	return $subjects;
    }
    public function get_user_scheduled_email($user, $dtwhere, $limit = 200)
    {
       	$this->db->distinct();
		$this->db->select("s.sch_contact,s.sch_id,s.sch_date,s.sch_subject,c.user_first,c.user_last,c.email,c.phone,c.account_id,a.account_name");
		$this->db->from($this->_table_crm_schemail." s");
		$this->db->join($this->_table_crm_contacts." c", 'c.contact_id = s.sch_contact');
		$this->db->join($this->_table_crm_accounts." a", 'a.account_id = c.account_id','left');	
		if($user) $this->db->where('s.sch_user', $user);
		else $this->db->where_in('s.sch_user', $this->_parent_users);
		if($dtwhere) $this->db->where($dtwhere,NULL,FALSE);		
		$this->db->group_by('s.sch_id');
		$this->db->order_by('s.sch_date', 'asc');
		$this->db->limit($limit);
		$this->db->offset($offset);
    	$query = $this->db->get();
		//echo $this->db->last_query().'--';
    	if ($query->num_rows() > 0)
    	{
			return $query->result();
    	}
		return array();
    }

    public function get_user_scheduled_email_count_23042019($user, $dtwhere, $limit = 10)
    {
        $this->db->select('COUNT(DISTINCT s.sch_contact) AS erc');
        $this->db->from($this->_table_crm_schemail . ' s');
        if (is_array($user)) {
            $this->db->where_in('s.sch_user', $user);
        } else {
            $this->db->where('s.sch_user', $user);
        }
        $this->db->where($dtwhere, null, false);
        $query = $this->db->get();
        //echo $this->db->last_query().'--';
        return $query->row()->erc;
    }
    
    public function get_user_scheduled_email_count($user,$limit=10) 
    {
		$this->db->select("COUNT(DISTINCT s.sch_contact) AS erc");
		$this->db->from($this->_table_crm_schemail." s");		
		if($user) $this->db->where('s.sch_user', $user);
		else $this->db->where_in('s.sch_user', $this->_parent_users);
		$this->db->group_by('s.sch_id');
		//$this->db->where($dtwhere,NULL,FALSE);
    	$query = $this->db->get();
		//echo $this->db->last_query().'--';
		return $query->row()->erc;
    }

    //CUSTOM FIELDS
    //Get custom records
    public function get_custom_records($id, $section)
    {
        $this->db->where('recid', $id);
        $this->db->where('section', $section);
        $this->db->order_by('id', 'asc');
        $query = $this->db->get($this->_table_crm_custom_values);

        return $query->result_array();
    }

    //Get custom record
    public function get_custom_record($edata)
    {
        $this->db->where('recid', $edata['recid']);
        $this->db->where('ckey', $edata['ckey']);
        $this->db->where('section', $edata['section']);
        $query = $this->db->get($this->_table_crm_custom_values);
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }

        return [];
    }

    //Save scheduled email
    public function save_custom_record($edata)//$id,$key,$section
    {
        $crow = $this->get_custom_record($edata);
        if ($crow) {
            $this->db->where('id', $crow['id']);
            $this->db->update($this->_table_crm_custom_values, $edata);
        } else {
            if (!isset($edata['user_id'])) {
                $user_id = $_SESSION['ss_user_id'];
                $edata['user_id'] = $user_id;
            }

            $this->db->insert($this->_table_crm_custom_values, $edata);
        }
    }

    //Delete Custom records
    public function delete_custom_record($edata)//$id,$key,$section
    {
        $user_id = $_SESSION['ss_user_id'];
        $this->db->where('recid', $edata['recid']);
        $this->db->where('ckey', $edata['ckey']);
        $this->db->where('section', $edata['section']);
        $this->db->where('user_id', $user_id);
        $this->db->delete($this->_table_crm_custom_values);
    }

    //END OF CUSTOM FIELDS

    //Get custom field search for Contact/Account
    public function custom_search($data, $section, $users, $num = 0)
    {
        if ($section == 'C') {
            $this->db->select("c.contact_id,c.user_first,c.user_last,c.phone,c.account_id,a.account_name,CONCAT((u.first_name),(' '),(u.last_name)) as usrname,c.ipoints as qpoints");
        } else {
            $this->db->select("a.account_id,a.account_name,a.phone,CONCAT((u.first_name),(' '),(u.last_name)) as usrname,a.ipoints as qpoints");
        }
        $this->db->from($this->_table_crm_custom_values . ' ad');
        if ($section == 'C') {
            $ptype = 'c';
            $this->db->join($this->_table_crm_contacts . ' c', 'c.contact_id = ad.recid', 'left');
            $this->db->join($this->_table_crm_accounts . ' a', 'a.account_id = c.account_id', 'left');
        } else {
            $ptype = 'a';
            $this->db->join($this->_table_crm_accounts . ' a', 'a.account_id = ad.recid', 'left');
        }
        $this->db->join($this->_table_users . ' u', 'u.user_id = ' . strtolower($ptype) . '.share_user_id', 'left');

        $this->db->where('ad.section', $section);
        //$this->db->where('ad.parent_type',$ptype);
        $this->db->where_in(strtolower($ptype) . '.share_user_id', $users);
        /*$nc = count($data);
        if($nc>1) {
            $ob="(";
            $cb=")";
        }
        $n=0;*/

        //$this->db->where("ad.ckey LIKE '%$data[0]%'",NULL,FALSE);
        $this->db->where("ad.ckey='$data[0]'", null, false);
        if ($num) {
            $this->db->where($data[1], null, false);
        } else {
            $this->db->where("ad.cval LIKE '%$data[1]%'", null, false);
        }
        /*foreach($data as $ki=>$kval) {
            $n++;
            $sb="";
            /*if($n==1){
                if($ki=="zipcode")
                    $this->db->where($ob."ad.$ki='$kval'",NULL,FALSE);
                else $this->db->where($ob."ad.$ki LIKE '%$kval%'",NULL,FALSE);
            } else {
                if($n==$nc && $cb) $eb=$cb;
                if($ki=="zipcode")
                    $this->db->or_where("ad.$ki='$kval'".$eb,NULL,FALSE);
                else $this->db->or_where("ad.$ki LIKE '%$kval%'".$eb,NULL,FALSE);
            }
        }*/
        $this->db->order_by('qpoints', 'desc');
        $query = $this->db->get();
        //echo $this->db->last_query()."<br>";
        return $query->result();
    }

    //End of Address

    //Documents
    //Save Doc
    public function save_doc($data, $notes_id = 0, $ntype)
    {
        $user_id = $_SESSION['ss_user_id'];
        if ($notes_id) {
            $data['notes_modify'] = date('Y-m-d H:i:s');
            $this->db->where('notes_id', $notes_id);
            //$this->db->where('notes_user', $user_id);
            $this->db->update($this->_table_crm_docs, $data);
        } else {
            if (!isset($data['notes_user'])) {
                $data['notes_user'] = $user_id;
            }
            $data['notes_created'] = date('Y-m-d H:i:s');
            $data['notes_modify'] = date('Y-m-d H:i:s');
            $this->db->insert($this->_table_crm_docs, $data);
            //echo $this->db->last_query();echo $query->num_rows();exit;
            $notes_id = $this->db->insert_id();
        }

        return $notes_id;
    }

    //Get Notes record
    public function get_doc($notes_id)
    {
        //$user_id = $_SESSION['ss_user_id'];
        $this->db->where('notes_id', $notes_id);
        //$this->db->where('notes_user', $user_id);
        $query = $this->db->get($this->_table_crm_docs);
        if ($query->num_rows() > 0) {
            $notesRow = $query->row_array();
            $parentNote = $this->get_notes_parent($notesRow['notes_parentid'], $notesRow['notes_parent']);
            if (!$parentNote) {
                return [];
            }

            return $notesRow;
        }

        return [];
    }

    //Delete Notes
    public function delete_doc($notes_id)
    {
        //$user_id = $_SESSION['ss_user_id'];
        $this->db->where('notes_id', $notes_id);
        //$this->db->where('notes_user', $user_id);
        $this->db->delete($this->_table_crm_docs);
    }

    //Delete all notes from Specific Object
    public function delete_objectdocs($parent_id, $parent_type)
    {
        //$user_id = $_SESSION['ss_user_id'];
        //$this->db->where('notes_user', $user_id);
        $this->db->where('notes_parent', $parent_type);
        $this->db->where('notes_parentid', $parent_id);
        $this->db->delete($this->_table_crm_docs);
    }

    //Get Notes list as array
    public function get_all_docs($parent_id, $parent_type, $limit = 0)
    {
        $parentNote = $this->get_notes_parent($parent_id, $parent_type);
        if (!$parentNote) {
            return [];
        }
        //$user_id =  $_SESSION['ss_user_id'];
        $this->db->select('n.upload,n.notes_title,n.notes_modify,n.notes_id');
        //$this->db->where('notes_user', $user_id);
        $this->db->where('n.notes_parent', $parent_type);
        $this->db->where('n.notes_parentid', $parent_id);
        $this->db->from($this->_table_crm_docs . ' n');
        $this->db->join($this->_table_users . ' u', 'u.user_id = n.notes_user', 'left');
        $this->db->order_by('n.notes_modify', 'desc');
        if ($limit) {
            $this->db->limit($limit);
        }
        $query = $this->db->get();
        //$query = $this->db->get($this->_table_crm_notes);
        //echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            return $query->result();
        }

        return [];
    }

    //end of Documents

    //CATEGORY LIST FOR CONTACT/ACCOUNT
    //Save
    public function save_catlist($data, $id = 0)
    {
        $user_id = $_SESSION['ss_user_id'];
        if ($id) {
            $this->db->where('id', $id);
            $this->db->update($this->_table_crm_category_list, $data);
        } else {
            if (!isset($data['userid'])) {
                $data['userid'] = $user_id;
            }
            $this->db->insert($this->_table_crm_category_list, $data);
            $id = $this->db->insert_id();
        }

        return $id;
    }

    //Get record
    public function get_catlistrow($id)
    {
				
		$user_id =  $_SESSION['ss_user_id'];
		$this->db->select('count(userfrom) as qrcount,userfrom,accessview');
		$this->db->from('tbl_user_shared');
		$this->db->where('userto',$user_id);
		$record = $this->db->get();
		//echo $this->db->last_query();
		$result = $record->row_array();
		$count =  $result['qrcount'];
		if($count>0) {
			 $shuser = $result['userfrom'];
			 $accessview =  $result['accessview'];
		}
		else $shuser = $user_id;
		
		if($accessview=="Own")
		{
			$this->db->where('id', $id);    	
			$usql = "userid={$this->_user_id}";
			$usql .= " OR (userid IN (".$shuser.") and share=1)";	
			$usql = "($usql)";
			$this->db->where($usql,NULL,FALSE);
			$query = $this->db->get($this->_table_crm_category_list);
			if ($query->num_rows() > 0)
			{
				return $query->row_array();
			}
			return array();
		}
		else
		{			
			$this->db->where('id', $id);    	
			$usql = "userid={$this->_user_id}";
			if($this->_parent_users) $usql .= " OR (userid IN (".implode(",", $this->_parent_users).") and share=1)";		
			$usql = "($usql)";
			$this->db->where($usql,NULL,FALSE);
			$query = $this->db->get($this->_table_crm_category_list);
			if ($query->num_rows() > 0)
			{
				return $query->row_array();
			}
			return array();
		}	
    	
	}

    //Delete row
    public function delete_catlist($id)
    {
        $user_id = $_SESSION['ss_user_id'];
        $this->db->where('id', $id);
        $this->db->where('userid', $user_id);
        $this->db->delete($this->_table_crm_category_list);
        $this->delete_category_records($id);
    }

    //Get list as array
    public function get_all_catlist($cparams)
    {
		$user_id =  $_SESSION['ss_user_id'];
		$this->db->select('count(userfrom) as qrcount,userfrom,accessview');
		$this->db->from('tbl_user_shared');
		$this->db->where('userto',$user_id);
		$record = $this->db->get();
		//echo $this->db->last_query();
		$result = $record->row_array();
		$count =  $result['qrcount'];
		if($count>0) {
			 $shuser = $result['userfrom'];
			 $accessview =  $result['accessview'];
		}
		else $shuser = $user_id;
        //get_all_catlist($section=1,$shared=0,$limit=0)
        //$user_id =  $_SESSION['ss_user_id'];
        //$this->db->where('userid', $user_id);
       /* if (isset($cparams['section'])) {
            $this->db->where('section', $cparams['section']);
        }*/
		
		if(isset($cparams['section'])) $section=$cparams['section'];
		
		if($accessview=="Own")
		{
			$usql = "((userid=".$user_id ." OR userid IN (".$shuser.")) and share=1 and section='".$section."')";	
			$usql = "($usql)";
			$this->db->where($usql,NULL,FALSE);
			$this->db->from($this->_table_crm_category_list);
			$this->db->order_by("name","asc");
			if(isset($cparams['limit']) && $cparams['limit'])$this->db->limit($cparams['limit']);			
			$query1 = $this->db->get();	
			//echo $this->db->last_query();	
			if ($query1->num_rows() > 0)
			{
				return $query1->result();
			} 
			return array();	
		}
		else
		{			
			$usql = "((userid=".$user_id ." OR userid IN (".implode(",", $this->_parent_users).")) and section='".$section."')";	
			$usql = "($usql)";
			$this->db->where($usql,NULL,FALSE);
			$this->db->from($this->_table_crm_category_list);
			$this->db->order_by("name","asc");
			if(isset($cparams['limit']) && $cparams['limit'])$this->db->limit($cparams['limit']);
			//echo $this->db->last_query();
			$query1 = $this->db->get();		
			if ($query1->num_rows() > 0)
			{
				return $query1->result();
			} 
			return array();		
		}	
		
        //if(isset($cparams['userid']))$this->db->where_in('userid', $cparams['userid']);
        //if(isset($cparams['share']))$this->db->where('share', $cparams['share']);
       /* $usql = "userid={$this->_user_id}";
        if ($this->_parent_users) {
            $usql .= ' OR (userid IN (' . implode(',', $this->_parent_users) . ') and share=1)';
        }
        $usql = "($usql)";
        $this->db->where($usql, null, false);
        $this->db->from($this->_table_crm_category_list);
        $this->db->order_by('name', 'asc');
        if (isset($cparams['limit']) && $cparams['limit']) {
            $this->db->limit($cparams['limit']);
        }
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }

        return [];*/
    }

    //Save category record
    public function save_category_record($data)
    {
        $this->db->insert($this->_table_crm_category_contacts, $data);
    }

    //Get category record
    public function get_category_record($category_id, $record_id)
    {
        $this->db->where('category_id', $category_id);
        $this->db->where('record_id', $record_id);
        $query = $this->db->get($this->_table_crm_category_contacts);
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }

        return [];
    }

    //Get category records
    public function get_category_records($category_id, $section, $qsearch)
    {
        $this->db->select('count(*) as total');
        $this->db->from($this->_table_crm_category_contacts . ' cr');
        if ($qsearch || 1) {
            if ($section == 1) {
                $this->db->join($this->_table_crm_contacts . ' c', 'c.contact_id = cr.record_id', 'left');
            } else {
                $this->db->join($this->_table_crm_accounts . ' a', 'a.account_id = cr.record_id', 'left');
            }
        }
        $this->db->where('cr.category_id', $category_id);
        if ($section == 1) {
            $this->db->where('c.userid IS NOT NULL', null, false);
        } else {
            $this->db->where('a.userid IS NOT NULL', null, false);
        }
        if ($qsearch) {
            $this->db->where($qsearch, null, false);
        }
        $query = $this->db->get();
        //echo $this->db->last_query();
        $row = $query->row_array();

        return $row['total'];
    }

    //Delete category records
    public function delete_category_records($category_id, $id = 0)
    {
        $this->db->where('category_id', $category_id);
        if (is_array($id)) {
            $this->db->where_in('record_id', $id);
        } elseif ($id) {
            $this->db->where('record_id', $id);
        }
        $this->db->delete($this->_table_crm_category_contacts);
    }

    //Get record categories
    public function get_categories_attached($record_id, $section)
    {
        $this->db->select('c.*,cr.cdate');
        $this->db->from($this->_table_crm_category_contacts . ' cr');
        $this->db->join($this->_table_crm_category_list . ' c', 'c.id = cr.category_id', 'left');
        $this->db->where('cr.record_id', $record_id);
        $this->db->where('c.section', $section);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }

        return [];
    }

    //Get category contacts
    public function get_category_contacts($cat_id)
    {
        //echo "test123".$cat_id;
        $this->db->select('record_id');
        $this->db->from($this->_table_crm_category_contacts . ' cr');
        $this->db->join($this->_table_crm_contacts . ' c', 'c.contact_id = cr.record_id', 'left');
        $this->db->where('c.userid IS NOT NULL', null, false);
        $this->db->where('cr.category_id', $cat_id);

        $query = $this->db->get();
        /*echo $this->db->last_query();
        echo "Num Rows".$query->num_rows();
        exit;*/
        if ($query->num_rows() > 0) {
            return $query->result();
        }

        return [];
    }

    //Delete record from category
    public function delete_record_from_category($rec_id, $section = 1)
    {
        $record_cats = $this->get_categories_attached($rec_id, $section);
        if ($record_cats) {
            foreach ($record_cats as $rcval) {
                $this->delete_category_records($rcval->id, $rec_id);
            }
        }
    }

    //end of CATEGORY LIST FOR CONTACT/ACCOUNT

    //PROSPECT POINTS CALCULATIONS
    //Distinct point types
    public function get_distinct_ptypes()
    {
        $this->db->select('rctype');
        $this->db->from($this->_table_prospect_points);
        $this->db->group_by('rctype');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }

        return [];
    }

    //Distinct record ids
    public function get_distinct_records($rctype)
    {
        $this->db->select('contact');
        $this->db->from($this->_table_prospect_points);
        $this->db->where('rctype', $rctype);
        $this->db->group_by('contact');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }

        return [];
    }

    //Save record prospect points
    public function save_record_prospect_points($pinfo)
    {
        if ($pinfo['rctype'] == 'A') {
            $points = $this->get_totalpoints_count($pinfo['contact'], $pinfo['rctype']);
            $data = ['ipoints' => $points['ipt'], 'ppoints' => $points['ppt']];
            $cid = $this->save_account($data, $pinfo['contact']);
        } elseif ($pinfo['rctype'] == 'C') {
            $points = $this->get_totalpoints_count($pinfo['contact'], $pinfo['rctype']);
            $data = ['ipoints' => $points['ipt'], 'ppoints' => $points['ppt']];
            $cid = $this->save_contact($data, $pinfo['contact']);
        }
    }

    //end of PROSPECT POINTS CALCULATIONS

    //CRM Email Tasks
    //Get email tasks
    public function get_email_tasks($thread_id)
    {
        $this->db->from($this->_table_crm_email_tasks);
        $this->db->where('thread_id', $thread_id);
        //$this->db->order_by("email_id","asc");
        $this->db->order_by('id', 'asc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }

        return [];
    }

    //Save Email task
    public function save_email_task($data, $id = 0)
    {
        if ($id) {
            $this->db->where('id', $id);
            $this->db->update($this->_table_crm_email_tasks, $data);
        } else {
            $this->db->insert($this->_table_crm_email_tasks, $data);
            $id = $this->db->insert_id();
        }

        return $id;
    }

    //Delete email tempate sub
    public function delete_email_tasks($mid, $ids = 0)
    {
        $this->db->where('thread_id', $mid);
        if ($ids) {
            $this->db->where_in('id', $ids);
        }
        $this->db->delete($this->_table_crm_email_tasks);
    }

    //Get user saved email template thread main & sub ids
    public function get_thread_template_ids($threadid)
    {
        $this->db->select('tid');
        $this->db->where('schparent', $threadid);
        $query = $this->db->get($this->_table_email_templates);
        if ($query->num_rows() > 0) {
            return $query->result();
        }

        return [];
    }

    //end of CRM Email Tasks

    //Get Contact for mailchimp
    public function get_contacts($userid)
    {
        $this->db->select('contact_id,email,mailchimp_last_time,user_first,user_last');
        $this->db->where('userid', $userid);
        //$this->db->where('mailchimp_cron', 0);
        $this->db->where("email<>'' and mailchimp_cron_time='0000-00-00 00:00:00'", null, false);
        //$this->db->order_by("mailchimp_last_time","asc");
        $this->db->order_by('mailchimp_cron_time', 'asc');
        $this->db->limit(3);
        $query = $this->db->get($this->_table_crm_contacts);
        //echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            return $query->result();
        }

        return [];
    }

    public function get_hubcontacts($userid)
    {
        $this->db->select('*');
        $this->db->where('userid', $userid);
        $this->db->order_by('mailchimp_cron_time', 'asc');
        $query = $this->db->get($this->_table_crm_contacts);
        if ($query->num_rows() > 0) {
            return $query->result(); 
        }

        return [];
    }

    //Get Contacts count for mailchimp
    public function get_contacts_count($userid)
    {
        $this->db->select('count(*) as count');
        //$this->db->where('mailchimp_cron', 0);
        $this->db->where('userid', $userid);
        $this->db->where("email<>'' and mailchimp_cron_time='0000-00-00 00:00:00'", null, false);
        $query = $this->db->get($this->_table_crm_contacts);
        if ($query->num_rows() > 0) {
            return $query->row()->count;
        }

        return 0;
    }

    //Get Contacts count having mailchimp list id null
    public function get_empty_mclids_contacts_count($userid)
    {
        $this->db->select('count(*) as count');
        $this->db->where('userid', $userid);
        //$this->db->where("email<>'' and mailchimp_list=''",NULL,FALSE);
        $this->db->where("email<>''", null, false);
        $this->db->where('mailchimp_list_cron', 0);
        $query = $this->db->get($this->_table_crm_contacts);
        if ($query->num_rows() > 0) {
            return $query->row()->count;
        }

        return 0;
    }

    //Get Contacts having mailchimp list id is null
    public function get_empty_mclids_contacts($userid)
    {
        $this->db->select('contact_id,email,mailchimp_last_time,user_first,user_last,mailchimp_list');
        $this->db->where('userid', $userid);
        //$this->db->where("email<>'' and mailchimp_list=''",NULL,FALSE);
        $this->db->where("email<>''", null, false);
        $this->db->where('mailchimp_list_cron', 0);
        $this->db->order_by('mailchimp_cron_time', 'asc');
        $this->db->limit(200);
        $query = $this->db->get($this->_table_crm_contacts);
        //echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            return $query->result();
        }

        return [];
    }

    //1. Get Contacts mailchimp list cron count
    public function get_mcContacts_list_cron_count()
    {
        $this->db->select('count(contact_id) as rcount');
        $this->db->from($this->_table_crm_contacts . ' c');
        $this->db->join($this->_table_user_info . ' u', 'u.user_id = c.userid', 'left');
        $this->db->where("c.email<>''", null, false);
        $this->db->where('c.mailchimp_list_cron', 0);
        $this->db->where('u.field_type', 'mailchimp');
        $this->db->where('u.user_info_id IS NOT NULL', null, false);
        $query = $this->db->get();
        //echo $this->db->last_query()."\n";
        if ($query->num_rows() > 0) {
            return $query->row()->rcount;
        }

        return 0;
    }

    //2. Get Contacts mailchimp activities cron count
    public function get_mcContacts_actvts_cron_count()
    {
        $this->db->select('count(contact_id) as rcount');
        $this->db->from($this->_table_crm_contacts . ' c');
        $this->db->join($this->_table_user_info . ' u', 'u.user_id = c.userid', 'left');
        $this->db->where("c.email<>''", null, false);
        $this->db->where("c.mailchimp_list<>''", null, false);
        $this->db->where('c.mailchimp_cron', 0);
        $this->db->where('u.field_type', 'mailchimp');
        $this->db->where('u.user_info_id IS NOT NULL', null, false);
        $query = $this->db->get();
        //echo $this->db->last_query()."\n";
        if ($query->num_rows() > 0) {
            return $query->row()->rcount;
        }

        return 0;
    }

    //3. Get Contacts mailchimp activities convert cron count
    public function get_mcContacts_actvts_convert_cron_count()
    {
        $this->db->select('count(contact_id) as rcount');
        $this->db->from($this->_table_crm_mc_activities);
        $query = $this->db->get();
        //echo $this->db->last_query()."\n";
        if ($query->num_rows() > 0) {
            return $query->row()->rcount;
        }

        return 0;
    }

    //Get Contacts count for mailchimp
    public function get_mclids_contacts_count($userid)
    {
        $this->db->select('count(*) as count');
        $this->db->where('mailchimp_cron', 0);
        $this->db->where('userid', $userid);
        $this->db->where("(email<>'' and mailchimp_list<>'')", null, false);
        $query = $this->db->get($this->_table_crm_contacts);
        if ($query->num_rows() > 0) {
            return $query->row()->count;
        }

        return 0;
    }

    //Get Contact for mailchimp
    public function get_mclids_contacts($userid)
    {
        $this->db->select('contact_id,email,mailchimp_last_time,user_first,user_last,mailchimp_list');
        $this->db->where('userid', $userid);
        $this->db->where('mailchimp_cron', 0);
        $this->db->where("(email<>'' and mailchimp_list<>'')", null, false);
        //$this->db->order_by("mailchimp_last_time","asc");
        $this->db->order_by('mailchimp_cron_time', 'asc');
        $this->db->limit(100);
        $query = $this->db->get($this->_table_crm_contacts);
        //echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            return $query->result();
        }

        return [];
    }

    //Save mailchimp list
    public function save_mclists($data, $id = 0)
    {
        if ($id) {
            $this->db->where('id', $id);
            $this->db->update($this->_table_crm_mlc_lists, $data);
        } else {
            $this->db->insert($this->_table_crm_mlc_lists, $data);
            $id = $this->db->insert_id();
        }

        return $id;
    }

    //update mailchimp contact cron
    public function save_mccontact($data, $where)
    {
        echo 'ZZZ';
        exit;
        $this->db->where($where, null, false);
        $this->db->update($this->_table_crm_contacts, $data);
    }

    //Get mailchimp list
    public function get_mclist($listid, $userid)
    {
        $this->db->where('userid', $userid);
        $this->db->where('listid', $listid);
        $query = $this->db->get($this->_table_crm_mlc_lists);
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }

        return [];
    }

    //Get record which is matching with account selected fields
    public function get_accRecord($where, $fields = '*')
    {
        try {
            //$this->db->select("$fields");
            //$this->db->where('LOWER(account_name)', $this->db->escape($where['account_name']), FALSE);
            //echo 'account_name like binary "'.$this->db->escape($where['account_name']).'"'."\n";
            //echo $where['account_name'].' '."\n";
            //$this->db->where('account_name like binary "'.$this->db->escape($where['account_name']).'"', NULL, FALSE);
            //$this->db->where_in('userid', $where['userid']);
            //$query = $this->db->get($this->_table_crm_accounts);
            //echo $this->db->last_query();
            //if ($query->num_rows() > 0) return $query->row_array();
            echo "select $fields from " . $this->_table_crm_accounts . " WHERE $where;" . "\n";
            //$query = $this->db->query("select $fields from ".$this->_table_crm_accounts." WHERE $where");
            //if ($query->num_rows() > 0) return $query->row_array();
            return [];
        }

        //catch exception
        catch (Exception $e) {
            //echo 'Message: ' .$e->getMessage();exit;
        }
    }

    //Save mailchimp activities instantly
    public function save_mcactivity($data, $id = 0)
    {
        if ($id) {
            $this->db->where('id', $id);
            $this->db->update($this->_table_crm_mc_activities, $data);
        } else {
            $this->db->insert($this->_table_crm_mc_activities, $data);
        }
    }

    //Delete mailchimp activity
    public function delete_mcactivity($id)
    {
        $this->db->where('id', $id);
        $this->db->delete($this->_table_crm_mc_activities);
    }

    //Get mailchim activities
    public function get_mcactivities($limit = 10)
    {
        $this->db->order_by('created', 'asc');
        $this->db->limit($limit);
        $query = $this->db->get($this->_table_crm_mc_activities);
        if ($query->num_rows() > 0) {
            return $query->result();
        }

        return [];
    }

    //Get Contact/Account with selected fields
    public function get_acRecord($where, $fields = '*', $type = 'C')
    {
        $this->db->select("$fields");
        $this->db->where($where, null, false);
        $query = $this->db->get($type == 'C' ? $this->_table_crm_contacts : $this->_table_crm_accounts);
        //echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }

        return [];
    }

    //Set mailchimp cron status to 0 on Contacts
    public function setMailchimpCronStatus()
    {
        $this->db->update($this->_table_crm_contacts, ['mailchimp_cron' => 0]);
    }

    //Mailchimp cron reset to 0 on Contacts
    public function mcCronReset()
    {
        $this->db->update($this->_table_crm_contacts, ['mailchimp_cron' => 0, 'mailchimp_list_cron' => 0]);
    }

    //TEMPLATE TASKS
    //Save TEMPLATE task
    public function save_template_task($data, $id = 0)
    {
        if ($id) {
            $this->db->where('id', $id);
            $this->db->update($this->_table_crm_template_tasks, $data);
        } else {
            $this->db->insert($this->_table_crm_template_tasks, $data);
            $id = $this->db->insert_id();
        }

        return $id;
    }

    //Get email tasks
    public function get_template_tasks($template_id, $campaign_id)
    {
        $this->db->from($this->_table_crm_template_tasks);
        $this->db->where('template_id', $template_id);
        $this->db->where('campaign_id', $campaign_id);
        //$this->db->order_by("email_id","asc");
        $this->db->order_by('id', 'asc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }

        return [];
    }

    //Delete email tempate sub
    public function delete_template_tasks($mid, $ids = 0)
    {
        $this->db->where('template_id', $mid);
        if ($ids) {
            $this->db->where_in('id', $ids);
        }
        $this->db->delete($this->_table_crm_template_tasks);
    }

    //List Widgets
    //Get record
    public function getCatlistrow($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get($this->_table_crm_category_list);
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }

        return [];
    }

    //end of List Widgets

    //WORKFLOWS
    //save workflow
    public function save_workflow($data, $id = 0)
    {
        if ($id) {
            $this->db->where('id', $id);
            $this->db->update($this->_table_workflow, $data);
        } else {
            $this->db->insert($this->_table_workflow, $data);
            $id = $this->db->insert_id();
        }

        return $id;
    }

    //Get workflows
    public function get_workflows($userid)
    {
        $this->db->from($this->_table_workflow);
        $this->db->where('userid', $userid);
        $this->db->order_by('ename', 'asc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }

        return [];
    }

    //Delete workflow
    public function delete_workflow($userid, $ids = 0)
    {
        $this->db->where('userid', $userid);
        if ($ids) {
            $this->db->where_in('id', $ids);
        }
        $this->db->delete($this->_table_workflow);
    }

    //Get workflow
    public function get_workflow($id, $userid)
    {
        $this->db->where('id', $id);
        $this->db->where('userid', $userid);
        $query = $this->db->get($this->_table_workflow);
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }

        return [];
    }

    //Get workflow by trigger type
    public function get_workflow_by_options($where)
    {
        if (isset($where['status'])) {
            $this->db->where('status', $where['status']);
        }
        if (isset($where['id'])) {
            $this->db->where('id', $where['id']);
        }
        if (isset($where['userid'])) {
            $this->db->where('userid', $where['userid']);
        }
        if (isset($where['trigger_event'])) {
            $this->db->where('trigger_event', $where['trigger_event']);
        }
        if (isset($where['trigger_value'])) {
            $this->db->where('trigger_value', $where['trigger_value']);
        }
        if (isset($where['auto_action'])) {
            $this->db->where('auto_action', $where['auto_action']);
        }
        if (isset($where['auto_action_value'])) {
            $this->db->where('auto_action_value', $where['auto_action_value']);
        }
        if (isset($where['process_start_time'])) {
            $this->db->where('process_start_time >=', date('Y-m-d'));
        }
        $query = $this->db->get($this->_table_workflow);
        if ($query->num_rows() > 0) {
            return $query->result();
        }

        return [];
    }

    //save workflow status
    public function save_workflow_status($userid, $ids)
    {
        if ($ids) {
            $this->db->set('status', 'NOT status', false);
            $this->db->where_in('id', $ids);
            $this->db->where('userid', $userid);
            $this->db->update($this->_table_workflow);
        }
    }

    //save workflow action
    public function save_workflow_action($data, $id = 0)
    {
        if ($id) {
            $this->db->where('id', $id);
            $this->db->update($this->_table_wf_autoactions, $data);
        } else {
            $this->db->insert($this->_table_wf_autoactions, $data);
        }
    }

    //Get workflow automated crons
    public function get_workflow_crons($where, $count = 0)
    {
        if ($count) {
            $this->db->select('count(*) as rtotal');
        }
        if (isset($where['automated_no'])) {
            if (is_array($where['automated_no'])) {
                $this->db->where_in('automated_no', $where['automated_no']);
            } else {
                $this->db->where('automated_no', $where['automated_no']);
            }
        }
        $this->db->order_by('userid', 'asc');
        if (isset($where['limit'])) {
            $this->db->limit($where['limit']);
        }
        if (isset($where['offset'])) {
            $this->db->offset($where['offset']);
        }
        $query = $this->db->get($this->_table_wf_autoactions);
        //echo $this->db->last_query();
        if ($count) {
            return $query->row()->rtotal;
        }
        if ($query->num_rows() > 0) {
            return $query->result();
        }

        return [];
    }

    //Delete workflow crons
    public function delete_workflow_cron($id)
    {
        $this->db->where('id', $id);
        $this->db->delete($this->_table_wf_autoactions);
    }

    //end of WORKFLOWS

    public function getcustomDbfield($cval)
    {
        $this->db->select('cvv.id,cvv.ckey,cvv.cval');
        $user_id = $_SESSION['ss_user_id'];

        $this->db->where('cvv.ckey', $cval);
        //	$this->db->where('cvv.cval', $val);
        $this->db->where('cvv.user_id', $user_id);

        $this->db->from($this->_table_crm_custom_values . ' cvv');
        $query = $this->db->get();

        //echo $this->db->last_query();

        if ($query->num_rows() > 0) {
            return $query->num_rows();
        } else {
            return 0;
        }
    }

    //isContactExists
    public function get_contact_by_email($email_id, $user_id)
    {
        $this->db->select('c.mobile,c.contact_id,c.email,c.phone,c.user_first,c.user_last');
        $this->db->where('c.email', $email_id);
        $this->db->where('c.userid', $user_id);
        $this->db->from($this->_table_crm_contacts . ' c');

        $query = $this->db->get();
        if ($query->row() > 0) {
            return $query->result();
        }

        return [];
    }
	
	public function get_task_by_gmail_ids($gmail_message_id, $gmail_thread_id, $user_id)
    {
        $this->db->select('t.gmail_thread_id,t.gmail_message_id,t.userid,t.task_id,t.task_subject');
        $this->db->where('t.gmail_thread_id', $gmail_thread_id);
        $this->db->where('t.gmail_message_id', $gmail_message_id);
        $this->db->where('t.userid', $user_id);
        $this->db->from($this->_table_crm_tasks . ' t');

        $query = $this->db->get();
        if ($query->row() > 0) {
            return $query->result();
        }

        return [];
    }
}
// end of campaigm model class
