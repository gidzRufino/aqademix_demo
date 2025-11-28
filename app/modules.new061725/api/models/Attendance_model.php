<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Description of login_model
 *
 * @author genesis
 */
class Attendance_model extends CI_Model {
    
    function getDailyAttendance($st_id, $date)
    {
        $this->db->where('att_st_id', $st_id);
        $this->db->where('date', ($date!=NULL?$date:date('Y-m-d')));
        $q = $this->db->get('attendance_sheet');
        return $q->row();
    }
}
