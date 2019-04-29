<?php
/**
 *  linkevent model class for
 *
 *  this model class is responsible to perfome all database related task to link_event table
 *
 */
class linkevent_model extends CI_Model
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
        $insert_id = $this->db->insert('link_event', $data);
        if ($insert_id) {
            return $insert_id;
        }

        return false;
    }

    public function getLinkEventCount($linkId)
    {
        if ($linkId) {
            $this->db->select('id,link_id');
            $this->db->from('link_event');
            $this->db->where('link_id', $linkId);

            $query = $this->db->get();

            return $query->num_rows();
        }
        return false;
    }
}
