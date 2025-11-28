<?php
class messaging_model extends CI_Model {
    
    
//=============== ads ==================
    function fetch_ads()
    {
        $this->db->select('*');
        $this->db->from('ads');
        // $this->db->where('ad_active', 1);
        $query = $this->db->get();
        return $query;
    }

    function save_ads($ads)
    {
        $this->db->insert('ads', $ads);
        return TRUE;
    }

    function update_ads($id, $data)
    {
        $this->db->where('ad_id', $id);
        $this->db->update('ads', $data);
        return;
    }

    function delete_ads($id) {
        $this->db->where('ad_id', $id);
        $this->db->delete('ads');
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
//=============== ads ==================    
    
    function getStudents()
    {
        $this->db->select('profile_students_admission.status as stat');
        $this->db->select('profile_parents.ice_contact');
        $this->db->select('profile_students.st_id');
        $this->db->select('profile.user_id');
        $this->db->from('profile_students');
        $this->db->join('profile', 'profile.user_id = profile_students.user_id', 'left');
        $this->db->join('profile_students_admission', 'profile_students_admission.user_id = profile.user_id ','left');
        $this->db->join('profile_parents', 'profile.user_id = profile_parents.parent_id ','left');
	$this->db->order_by('lastname', 'ASC');
        $query = $this->db->get();
        return $query;
    }
    
    function checkScanTime($section_id)
    {
        $this->db->where('section_id', $section_id);
        $q = $this->db->get('section');
        if($q->num_rows()>0):
            return $q->row();
        else:
            return FALSE;
        endif;
    }
    
    function hasTextCredit($st_id)
    {
        $this->db->where('date', date('Y-m-d'));
        $this->db->where('att_st_id', $st_id);
        $att = $this->db->get('attendance_sheet');
        if($att->num_rows()>0):
            $count = $att->row()->scan_count;
        else:
            $count = 0;
        endif;
        if($count >= 2):
            return FALSE;
        else:
            return TRUE;
        endif;
    }
    
    function saveSMSCount($user_id)
    {
        $this->db->where('date', date('Y-m-d'));
        $this->db->where('att_st_id', $user_id);
        $att = $this->db->get('attendance_sheet');
        if($att->num_rows()>0):
            $count = $att->row()->scan_count;
            $saveCount = $count+1;
            $this->db->where('date', date('Y-m-d'));
            $this->db->where('att_st_id', $user_id);
            if($this->db->update('attendance_sheet',array('scan_count' => $saveCount))):
                return TRUE;
            endif;
        endif;
    }
    
    function saveText($details)
    {
        if($this->db->insert('sms', $details)):
            return TRUE;
        else:
            return FALSE;
        endif;
    }
    
    function saveAnnouncement($details)
    {
        $this->db->insert('ticker', $details);
        return;
    }

    function shortcode()
    {
        $this->db->select("*");
        $this->db->from("settings");
        $query = $this->db->get();
        return $query->row();
    }
    
    function getSMSList($status, $cat) 
    {
        date_default_timezone_set('Asia/Manila');
        $from = date('Y-m-d 00:00:01');
        $to = date('Y-m-d 23:59:59');
        if($cat!=NULL):
            $this->db->where('sms_cat', $cat);
        endif;
        
        ($status==NULL?'':$this->db->where('sms_status', $status));
        $this->db->where("sms_datetime between '" . $from . "' and'" . $to . "'");
        $query = $this->db->get('sms');
        return $query->result();
    }

    function apicode()
    {
        $this->db->select('*');
        $this->db->from('settings');
        $query = $this->db->get();
        return $query->row();
    }

    function texttest($lid)
    {
        $this->db->select('*');
        $this->db->from('attendance_log_book');
        $this->db->where('log_id', $lid);
        $query = $this->db->get();
        return $query->row();
    }

    function lookup($rfid)
    {
        $this->db->select('*');
        $this->db->from('profile');
        $this->db->join('profile_parents', 'profile.user_id = profile_parents.parent_id', 'left');
        $this->db->where('rfid', $rfid);
        $query = $this->db->get();
        return $query->row();
    }

    function fetch_user($st_id)
    {
        $this->db->select('*');
        $this->db->from('profile_students');
        $this->db->join('profile', 'profile_students.user_id = profile.user_id', 'left');
        $this->db->join('profile_parents', 'profile.user_id = profile_parents.parent_id', 'left');
        $this->db->where('st_id', $st_id);
        $query = $this->db->get();
        return $query->row();
    }

    function logtext($data, $log_id)
    {   
        $this->db->where('sms_id', $log_id);
        $this->db->update('sms', $data);
        return;
    }

    function getAnnouncement($status)
    {
        $this->db->where('active', $status);
        $this->db->order_by('timestamp', 'ASC');
        $query = $this->db->get('ticker');
        return $query;
    }
    
    function updateAnnouncement($id, $details)
    {
        $this->db->where('id', $id);
        $this->db->update('ticker', $details);
        return;
    }
    
    function deleteAnnouncement($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('ticker');
    }
    function saveMessage($sendto, $sendFrom, $Message, $parentMsgId)
    {
        
        $data = array(
            'msg_from' => $sendFrom,
            'msg_to' => $sendto,
            'msg_content' => $Message,
            'msg_read' => 0,
            'parent_msg_id' => $parentMsgId,
        );
        $this->db->insert('messaging', $data);
        if($parentMsgId==0)
        {
            $pMId = array(
                'parent_msg_id' => $this->db->insert_id()
            );
            
        $this->db->where('msg_id', $this->db->insert_id()); 
        $this->db->update('messaging', $pMId);
            return;
        }else{
            return;
        }
    }
    
    function getMessages($from) //this will display in my Messages
    {
        $this->db->select('msg_from, msg_to');
        $this->db->from('messaging');
        $this->db->where('msg_from', $from);
        $this->db->order_by('msg_id', 'desc');
        $this->db->limit('1');
        
        $query = $this->db->get();
        if($query->num_rows()>0){
            $msgFrom = $query->row();
            
            $this->db->select('*');
            $this->db->from('messaging');
            $this->db->join('profile', 'profile.user_id = messaging.msg_to', 'left');
            $this->db->join('profile_info', 'profile_info.u_id = profile.user_id', 'left');
            $this->db->where('msg_from', $from);
            //$this->db->where('msg_to', $from);
            $this->db->group_by('msg_to');
            $this->db->order_by('msg_id', 'desc');
        }else{
            $this->db->select('*');
            $this->db->from('messaging');
            $this->db->join('profile', 'profile.user_id = messaging.msg_from', 'left');
            $this->db->join('profile_info', 'profile_info.u_id = profile.user_id', 'left');
            //$this->db->where('msg_from', $from);
            $this->db->where('msg_to', $from);
           // $this->db->group_by('msg_to');
        }
        
        $query = $this->db->get();
        $data = array(
            'num_rows' => $query->num_rows(),
            'result' => $query->result(),
        );
        
        return $data;
    }
    
    function getIndividualMessages($from)
    {
        $this->db->select('msg_from, msg_to, parent_msg_id');
        $this->db->from('messaging');
        $this->db->where('msg_from', $from);
        $this->db->order_by('msg_id', 'desc');
        $this->db->limit('1');
        $query = $this->db->get();
        
        if($query->num_rows()>0){
            $msgFrom = $query->row();
            $this->db->select('*');
            $this->db->from('messaging');        
            $this->db->join('profile', 'profile.user_id = messaging.msg_from', 'left');
            $this->db->join('profile_info', 'profile_info.u_id = profile.user_id', 'left');
            $this->db->where('parent_msg_id', $msgFrom->parent_msg_id);  
            $this->db->order_by('msg_id', 'asc');
        }else{   
            $this->db->select('*');
            $this->db->from('messaging');        
            $this->db->join('profile', 'profile.user_id = messaging.msg_from', 'left');
            $this->db->join('profile_info', 'profile_info.u_id = profile.user_id', 'left');
            $this->db->where('parent_msg_id', $msgFrom->parent_msg_id); 
        //$this->db->or_where('msg_from', $msgFrom->msg_to);
        }
//            
        

        $query2 = $this->db->get();
        
        $data = array(
            'reply' => $msgFrom->msg_from,
            'sent' => $query2->result(),
            'parent_msg_id'=>$msgFrom->parent_msg_id
        );
        
        return $data;

    }
    
    function getAllNum()
    {
        $this->db->group_by('cd_mobile');
        $query = $this->db->get('contact_details');
        
        return $query->result();
        
    }
    
    
    function save_tardy($data)
    {
        $this->db->insert('tardy', $data);
        return $this->db->insert_id();
    }
    
    function fetch_unrecorded_spr()
    {
        $attendance_sheet = 'attendance_sheet_aug';
        $this->db->select('*');
        $this->db->select($attendance_sheet.'.time_in as as_time_in');
        $this->db->select($attendance_sheet.'.time_in_pm as as_time_in_pm');
        $this->db->select('profile_students_admission.section_id as sect_id');
        $this->db->from($attendance_sheet);
        $this->db->join('profile_students_admission', $attendance_sheet.'.att_st_id = profile_students_admission.st_id', 'left');
        $this->db->join('profile', 'profile_students_admission.user_id = profile.user_id', 'left');
        // $this->db->join('section', 'profile_students.section_id = section.section_id', 'left');
        $this->db->where($attendance_sheet.'.counted', 0);
        $this->db->where($attendance_sheet.'.att_st_id!=', '');
        $this->db->where('profile.account_type', 5);
        $this->db->limit(200);
        $query = $this->db->get();
        return $query->result();
    }

    function check_tardy($st_id, $date)
    {
        $this->db->select('*');
        $this->db->from('tardy');
        $this->db->where('l_date', $date);
        $this->db->where('l_st_id', $st_id);
        $this->db->where('l_status <', 3);
        $query = $this->db->get();
        return $query;
    }

    function check_spr($stid)
    {
        $this->db->select('*');
        $this->db->select('gs_spr_attendance.spr_id as st_spr');
        $this->db->from('gs_spr_attendance');
        $this->db->join('gs_spr', 'gs_spr_attendance.spr_id = gs_spr.spr_id', 'left');
        $this->db->where('gs_spr.st_id', $stid);
        $query = $this->db->get();
        return $query;
    }

    function gen_spr_att($details)
    {
        // $this->db->get('gs_spr_attendance');
        $this->db->insert('gs_spr_attendance', $details);
        return;
    }

    function save_spr_details($st_id, $year, $grade_level)
    {
        $settings = Modules::run('main/getSet');
        $this->db->where('st_id', $st_id);
        $this->db->where('school_year', $year);
        $this->db->where('grade_level_id', $grade_level);
        $spr = $this->db->get('gs_spr');
        if($spr->num_rows() == 0):
            $sprDetails = array(
                'st_id' => $st_id,
                'grade_level_id' => $grade_level,
                'school_name'    => $settings->set_school_name,
                'school_year'    => $year,
            );
            
            $this->db->insert('gs_spr', $sprDetails);
            return $this->db->insert_id();
        endif;    
    }
    
    function update_sheet($st_id, $psheet)
    {
        // $data = array('counted' => 1, );
        $attendance_sheet = 'attendance_sheet_jul';
        $this->db->set('counted', 1);
        $this->db->where('att_id', $psheet);
        $this->db->update($attendance_sheet);
        return;
    }

    function update_spr($spr_id, $mdata)
    {
        $this->db->where('spr_id', $spr_id);
        $this->db->update('gs_spr_attendance', $mdata);
        return;
    }
    
    function getSection($id)
    {
        $this->db->select('*');
        $this->db->from('section');
        // $this->db->join('grade_level', 'section.grade_level_id = grade_level.grade_id', 'left');
        $this->db->where('section_id', $id);
        $query = $this->db->get();
        return $query->row();
    }
}