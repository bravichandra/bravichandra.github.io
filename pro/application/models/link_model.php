<?php
/**
 *  link model class for
 *
 *  this model class is responsible to perfome all database related task to link table
 *
 */
class link_model extends CI_Model
{
    /**
     * Constructor
     *
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function create($data)
    {
        $insert_id = $this->db->insert('link', $data);

        if ($insert_id) {
            return $insert_id;
        }

        return false;
    }

    public function read($linkId)
    {
        if ($linkId) {
            $this->db->select('id,link,email_id');
            $this->db->from('link');
            $this->db->where('id', $linkId);

            $query = $this->db->get();

            if ($query->num_rows() > 0) {
                $data = $query->result();

                return $data;
            }
        }

        return false;
    }

    public function getLinkSummary($emailId)
    {
        if ($emailId) {
            $sql = "SELECT l.id as l_id,l.link, l.email_id,l.is_deleted as link_is_deleted,l.created_on as
            link_created_on,l.updated_on as link_updated_on,lv.id as link_event_id,
            lv.link_clicked_time,lv.link_clicked_device_name,lv.link_id,lv.created_on as created_on,lv.updated_on,lv.is_deleted,
            lv.user_agent,lv.location,lv.click_recipient FROM link l INNER JOIN link_event lv ON 
            l.id = lv.link_id where l.email_id='" . $emailId . "' ORDER BY 
            link_created_on DESC,lv.link_clicked_time DESC";

            $query = $this->db->query($sql);
            if ($query->num_rows() > 0) {
                $data = $query->result_array();

                return $data;
            }
        }

        return false;
    }
}
