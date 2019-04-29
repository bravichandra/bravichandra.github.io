<?php
/**
 *  userdevice model class for
 *
 *  this model class is responsible to perfome all database related task to link table
 *
 */
class userdevice_model extends CI_Model
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
        if ($data) {
            $insert_id = $this->db->insert('user_device', $data);

            if ($insert_id) {
                return $insert_id;
            }
        }

        return false;
    }

    public function read($userId)
    {
        if ($userId) {
            $this->db->select('id,token,userId,user_agent,browser_name');
            $this->db->from('user_device');
            $this->db->where('id', $userId);

            $query = $this->db->get();

            if ($query->num_rows() > 0) {
                $data = $query->result();

                return $data;
            }
        }

        return false;
    }

    public function gettokenbyuserid($user_id)
    {
        if ($user_id) {
            $query = $this->db->query("select id,token,user_id,user_agent,browser_name from user_device where user_id='$user_id'");       
            if ($query->num_rows > 0) {
                return $query->row();
            } else {
                return false;
            }
        }

        return false;
    }

    public function update($userData)
    {
        if ($userData) {
            $this->db->where('id', $userData['id']);
            $res = $this->db->update('user_device', ['token' => $userData['token'], 'updated_on' => $userData['updated_on']]);
            if ($res) {
                return true;
            }
        }

        return false;
    }
}
