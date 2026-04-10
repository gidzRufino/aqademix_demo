<?php
/**
 * Description of Vm_model
 * This functions to manage visitor management
 * @author cyrus
 */
class Vm_model extends CI_Model {
	function __construct()
    {
        parent::__construct();
    }

   function vm_accounts()
   {
      $sy = 2016;
      $this->db = $this->eskwela->db($sy);
      $this->db->select('*');
      $this->db->from('vm_accounts');
      $query = $this->db->get();
      return $query->result();
   }

   function display_log()
   {
      $sy = 2016;
      $todate = date("m/d/y");
      $this->db = $this->eskwela->db($sy);
      $this->db->select('*');
      $this->db->from('vm_log');
      $this->db->join('vm_accounts', 'vm_log.log_va_id = vm_accounts.va_id', 'left');
      $this->db->join('profile', 'vm_log.log_user_id = profile.user_id', 'left');
      $this->db->join('department', 'vm_log.log_dept = department.dept_id', 'left');
      // $this->db->where('vm_log.log_date', $todate);
      $query = $this->db->get();
      return $query->result();
   }

   function vm_get_vid()
   {
      $sy = 2016;
      $account_type = 88;
      $this->db = $this->eskwela->db($sy);
      $this->db->select('*');
      $this->db->from('profile');
      $this->db->join('vm_accounts', 'profile.status = vm_accounts.va_id', 'left');
      $this->db->where('profile.account_type', $account_type);
      $query = $this->db->get();
      return $query->result();
   }

   function display_log_vm($vm)
   {
      $sy = 2016;
      $this->db = $this->eskwela->db($sy);
      $this->db->select('*');
      $this->db->from('vm_log');
      $this->db->join('profile', 'vm_log.log_user_id = profile.user_id', 'left');
      $this->db->order_by('log_id', 'DESC');
      $this->db->where('vm_log.log_va_id', $vm);
      $query = $this->db->get();
      return $query->result();
   }

   function display_vm_profile($vm)
   {
      $sy = 2016;
      $this->db = $this->eskwela->db($sy);
      $this->db->select('*');
      $this->db->from('vm_accounts');
      $this->db->where('vm_accounts.va_id', $vm);
      $query = $this->db->get();
      return $query->row();  
   }

   function display_log_vid($uid)
   {
      $sy = 2016;
      $this->db = $this->eskwela->db($sy);
      $this->db->select('*');
      $this->db->from('vm_log');
      $this->db->join('vm_accounts', 'vm_log.log_va_id = vm_accounts.va_id', 'left');
      $this->db->order_by('log_id', 'DESC');
      $this->db->where('vm_log.log_user_id', $uid);
      $query = $this->db->get();
      return $query->result();
   }

   function display_vid_profile($uid)
   {
      $sy = 2016;
      $this->db = $this->eskwela->db($sy);
      $this->db->select('*');
      $this->db->from('profile');
      $this->db->where('profile.user_id', $uid);
      $query = $this->db->get();
      return $query->row();  
   }

   function vm_get_id()
   {
      $sy = 2016;
      $account_type = 88;
      $this->db = $this->eskwela->db($sy);
      $this->db->select('*');
      $this->db->from('profile');
      $this->db->where('profile.account_type', $account_type);
      $query = $this->db->get();
      return $query->result();
   }
    
   function vm_dept()
   {
      $this->db->select('*');
      $this->db->from('department');
      $query = $this->db->get();
      return $query->result();
   }
    
   function save_new_profile($lname, $fname, $cname, $sdept, $svid, $avatar)
   {
      $data = array(
         'va_lastname' => $lname,
         'va_firstname' => $fname,
         'va_company' => $cname,
         'va_dept' => $sdept,
         'va_uid' => $svid,
         'va_avatar' => $avatar,
      );
      $this->db->insert('vm_accounts', $data);
      return $this->db->insert_id();
   }
   
   function update_v_profile($data, $svisitor)
   {
      $this->db->where('va_id', $svisitor);
      $this->db->update('vm_accounts', $data);
      return;
   }

   function update_profile($data, $svid)
   {
      $this->db->where('user_id', $svid);
      $this->db->update('profile', $data);
      return;
   }

   function save_vm_login($userid, $lgdate, $lgin, $sdept, $va_id, $avatar)
   {
      $data = array(
         'log_user_id' => $userid, 
         'log_va_id' => $va_id,
         'log_in' => $lgin,
         'log_date' => $lgdate,
         'log_dept' => $sdept,
         'log_avatar' => $avatar,
      );
      $this->db->insert('vm_log', $data);
      return $this->db->insert_id();
   }

   function update_profile_logout($user, $userid)
   {
      $this->db->where('user_id',$userid);
      $this->db->update('profile', $user);
      return;
   }

   function update_log_logout($log, $logid)
   {
      $this->db->where('log_id', $logid);
      $this->db->update('vm_log', $log);
      return;  
   }

   function update_vm_logout($vm, $vmid)
   {
      $this->db->where('va_id', $vmid);
      $this->db->update('vm_accounts', $vm);
      return;
   }
   
  //   function addCategory($data)
  //   {
  //       $data = array(
  //               'category' => $data
  //           );
  //       if($this->db->insert('stg_library_category', $data))
		// {
		// 	$query = $this->getCategory();
		// 	return $query;
		// }else{
		// 	return false;
		// }
     	  
  //   }
	
  //  function addBookSubjectRelation($bookid, $subjectid){
  //       $data = array(
  //           'book_id'=>$bookid,
  //           'subject_id'=>$subjectid[0]
  //       );
  //       $this->db->insert('stg_library_books_subject_relation', $data);
  //       return;
  //   }
  //   //function get
  //   function getBookSubjectsOfBook($bookid){
  //       $this->db->select('*');
  //       $this->db->from('stg_library_books_subject_relation');
  //       $this->db->join('stg_library_books_subjects', 'stg_library_books_subjects.book_subject_id = stg_library_books_subject_relation.subject_id', 'left'); 
  //       $this->db->where('book_id', $bookid);
  //       $query = $this->db->get();
  //       return $query->result();
  //   }

  //   function getBorrowedBook()
  //   {
  //       $this->db->select('*');
  //       $this->db->select('stg_library_books.book_id as bookid');
  //       $this->db->from('stg_library_books');
  //       $this->db->join('stg_library_category', 'stg_library_books.book_category_id= stg_library_category.category_id', 'left');
  //       $this->db->join('stg_library_books_desc', 'stg_library_books.book_id = stg_library_books_desc.book_desc_id', 'left');
  //       $this->db->join('stg_library_book_status', 'stg_library_books.book_id = stg_library_book_status.book_id', 'left');
  //       $this->db->join('stg_calendar', 'stg_library_books_desc.book_date_acquired = stg_calendar.cal_id', 'left');
  //       $this->db->join('stg_profile', 'stg_library_book_status.borrowed_by_id = stg_profile.user_id', 'left');
      
  //       $this->db->where('book_status', 1);
  //       $this->db->limit(10);
  //       $query = $this->db->get();
  //       $result = $query->result(); 
  //       foreach($result as $r){
  //           $subject = '';
  //           $subids = explode(",", $r->book_subjects_ids);
  //           foreach($subids as $subid){
  //               $this->db->select('subject');
  //               $this->db->from('stg_library_books_subjects');
  //               $this->db->where('book_subject_id', $subid);
  //               $querys = $this->db->get();
  //               $results = $querys->result();
  //               foreach($results as $rs){
  //                   $subject = $subject.$rs->subject.', ';
  //               }
  //           }
            
  //           $subject = substr($subject, 0, -2);
  //           $r->book_subjects_ids = $subject;
  //       }
        
  //       return $query->result();
  //   }
}
	