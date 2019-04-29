<?php
/**
 *  emailevent model class for
 *
 *  this model class is responsible to perfome all database related task to email_event table
 *
 */
class emailevent_model extends CI_Model
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
        $insert_id = $this->db->insert('email_event', $data);
        if ($insert_id) {
            return $insert_id;
        }

        return false;
    }

    public function getEmailEventCount($emailId)
    {
        if ($emailId) {
            $this->db->select('id,email_id');
            $this->db->from('email_event');
            $this->db->where('email_id', $emailId);

            $query = $this->db->get();

            return $query->num_rows();
        }
        return false;
    }
}
