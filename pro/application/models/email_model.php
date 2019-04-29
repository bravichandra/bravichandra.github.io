<?php
/**
 *  email model class for
 *
 *  this model class is responsible to perfome all database related task to email table
 *
 */
class email_model extends CI_Model
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
        $insert_id = $this->db->insert('email', $data);
        if ($insert_id) {
            return $insert_id;
        }

        return false;
    }

    public function read($emailId)
    {
        if ($emailId) {
            $this->db->select('id,name,subject,gmail_message_id,gmail_thread_id,user_id,recipient');
            $this->db->from('email');
            $this->db->where('id', $emailId);
            $query = $this->db->get();
            if ($query->num_rows() > 0) {
                $data = $query->result();

                return $data;
            }
        }

        return false;
    }

    public function update($emailData)
    {
        if ($emailData) {
            $this->db->where('id', $emailData['id']);
            $res = $this->db->update('email', ['gmail_thread_id' => $emailData['gmail_thread_id'], 'gmail_message_id' => $emailData['gmail_message_id'], ]);
            if ($res) {
                return true;
            }
        }

        return false;
    }

    public function getEmailSummary($userId)
    {
        if ($userId) {
            $sql = "SELECT e.id as email_id,e.name, e.user_id, e.subject,e.gmail_message_id,e.gmail_thread_id,e.email_sent_time,
            e.is_deleted as email_is_deleted,e.updated_on as email_updated_on,e.cc_recipient,e.bcc_recipient,e.recipient,
            ev.id as email_event_id,ev.email_read_time,ev.email_clicked_device_name,ev.email_id as event_email_id, 
            ev.is_deleted,ev.user_agent,ev.read_recipient,ev.updated_on,ev.is_deleted,
            ev.is_deleted,e.created_on as email_created_on,ev.created_on as ev_email_created_on FROM email e left join email_event ev on
            e.id = ev.email_id where e.user_id='" . $userId . "' ORDER BY email_created_on DESC ,ev.email_read_time DESC limit 100";

            $query = $this->db->query($sql);
            if ($query->num_rows() > 0) {
                $data = $query->result_array();

                return $data;
            }
        }

        return false;
    }
}
