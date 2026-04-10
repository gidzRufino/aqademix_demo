<?php //

class librarymodule_model extends CI_Model {
    
   function __construct()
   {
      parent::__construct();
   }


   function search_data($query)
   {
      $this->db->select('*');
      $this->db->from('lib_general');
      if($query != '')
      {
         $this->db->like('gb_title', $query);
         $this->db->or_like('gb_author', $query);
         $this->db->or_like('gb_co_author', $query);
         $this->db->or_like('gb_sor', $query);
         $this->db->or_like('gb_remarks', $query);
         $this->db->or_like('gb_topical_terms', $query);
      }
      // $this->db->order_by('gb_id', 'DESC');
      return $this->db->get();
   }

   public function show_sy()
   {
      $this->db->select('school_year');
      $this->db->from('settings');
      $query = $this->db->get();
      return $query->row();
   }

   // function get_brecords($from, $to)
   function get_brecords()
   {
      $this->db->select('*');
      $this->db->from('lib_transaction');
      $this->db->join('lib_book', 'lib_transaction.tr_bk_id = lib_book.bk_id', 'left');
      $this->db->join('lib_general', 'lib_book.bk_gb_id = lib_general.gb_id', 'left');
      $this->db->join('profile', 'lib_transaction.tr_eu_id = profile.user_id', 'left');
      // $this->db->where('lib_transaction.tr_due_date >', $from);
      // $this->db->where('lib_transaction.tr_due_date <', $to);
      $query = $this->db->get();
      return $query->result();
   }

   function show_profile($eu_id)
   {
      $this->db->select('*');
      $this->db->from('profile');
      $this->db->where('profile.user_id', $eu_id);
      $query = $this->db->get();
      return $query->row();
   }

   function search_student()
   {
      $sy_now = show_sy();
      $this->db->select('*');
      $this->db->from('profile_students_admission');
      $this->db->join('grade_level', 'profile_students_admission.grade_level_id = grade_level.grade_id', 'left');
      $this->db->join('profile', 'profile_students_admission.user_id = profile.user_id', 'left');
      $this->db->join('profile_address_info', 'profile.add_id = profile_address_info.address_id', 'left');
      $this->db->join('barangay', 'profile_address_info.barangay_id = barangay.barangay_id', 'left');
      $this->db->join('cities', 'profile_address_info.city_id = cities.id', 'left');
      $this->db->join('provinces', 'profile_address_info.province_id = provinces.id', 'left');
      $this->db->order_by('grade_level_id', 'ASC');
      $this->db->where('profile_students_admission.school_year', $sy_now->school_year);
      $query = $this->db->get();
      return $query->result();
   }

   function student_list()
   {
      $sy_now = $this->session->userdata('school_year');
      $this->db->select('*');
      $this->db->from('profile_students_admission');
      $this->db->join('profile', 'profile_students_admission.user_id = profile.user_id', 'left');
      $this->db->where('profile_students_admission.school_year', $sy_now);
      $query = $this->db->get();
      return $query->result();
   }

   function get_gb_items($gb_id)
   {
      $this->db->select('*');
      $this->db->from('lib_book');
      $this->db->where('bk_gb_id', $gb_id);
      $query = $this->db->get();
      return $query->result();
   }
   
   function display_tt()
   {
      $this->db->select('*');
      $this->db->from('lib_topical_term');
      $query = $this->db->get();
      return $query->result();
   }

   function set_image($id, $image)
   {
      $data = array(
         'gb_pic' => $image,
      );   

      $this->db->where('gb_id', $id);
      $this->db->update('lib_general', $data);
   }

   function search_ec()
   {
      $sy_now = show_sy();
      $this->db->select('*');
      $this->db->from('profile_students');
      $this->db->join('profile_students_admission', 'profile_students.user_id = profile_students_admission.user_id', 'left');
      $this->db->join('profile_parents', 'profile_students.parent_id = profile_parents.parent_id', 'left');
      $this->db->where('profile_students_admission.school_year', $sy_now->school_year);
      $query = $this->db->get();
      return $query->result();
   }

   function getprofile($eu_id)
   {
      $this->db->select('*');
      $this->db->from('lib_entity_user');
      $this->db->where('eu_user_id', $eu_id);
      $query = $this->db->get();
      // $count = $query->num_rows();
      // return $count;
      return $query;
   }

   function get_user_info($rfid)
   {
      $this->db->select('*');
      $this->db->from('profile');
      $this->db->join('lib_entity_user', 'profile.user_id = lib_entity_user.eu_user_id', 'right');
      $this->db->where('profile.rfid', $rfid);
      $query = $this->db->get();
      return $query->row();
   }

   function get_lib_profile($eu_id)
   {
      $this->db->select('*');
      $this->db->from('lib_entity_user');
      // $this->db->join('profile', 'lib_entity_user.eu_user_id = profile.user_id', 'left');
      $this->db->where('lib_entity_user.eu_user_id', $eu_id);
      $query = $this->db->get();
      return $query->row();
   }

   function lastentstatus($trans)
   {
      $this->db->select('*');
      $this->db->from('lib_entrance');
      $this->db->join('lib_entity_user', 'lib_entrance.en_id = lib_entity_user.eu_ent_id', 'left');
      $this->db->where('en_id', $trans);
      $query = $this->db->get();
      return $query->row();
   }

   // function display_books()
   // {
   //    $this->db->select('*');
   //    $this->db->from('lib_general');
   //    $this->db->join('lib_book', 'lib_general.gb_id = lib_book.bk_gb_id', 'left');
   //    $this->db->join('lib_author', 'lib_general.gb_au_id = lib_author.au_id', 'left');
   //    $this->db->join('lib_dewey', 'lib_general.gb_dw_id = lib_dewey.dw_id', 'left');
   //    $this->db->join('lib_category', 'lib_general.gb_ca_id = lib_category.ca_id', 'left');
   //    $query = $this->db->get();
   //    return $query->result();
   // }

   // function search_book($book_id)
   // {
   //    $this->db->select('*');
   //    $this->db->from('lib_general');
   //    $this->db->join('lib_book', 'lib_general.gb_id = lib_book.bk_gb_id', 'left');
   //    $this->db->join('lib_author', 'lib_general.gb_au_id = lib_author.au_id', 'left');
   //    $this->db->join('lib_dewey', 'lib_general.gb_dw_id = lib_dewey.dw_id', 'left');
   //    $this->db->join('lib_category', 'lib_general.gb_ca_id = lib_category.ca_id', 'left');
   //    $this->db->where('lib_general.gb_id' $book_id);
   //    $query = $this->db->get();
   //    return $query->row();
   // }

   function display_accounts()
   {
      $this->db->select('*');
      $this->db->from('lib_entity_user');
      $this->db->join('profile', 'lib_entity_user.eu_user_id = profile.user_id', 'left');
      $this->db->order_by('lastname', 'ASC');
      $query = $this->db->get();
      return $query->result();
   }

   function show_account_info($eu_id)
   {
      $this->db->select('*');
      $this->db->from('lib_entity_user');
      $this->db->join('profile', 'lib_entity_user.eu_user_id = profile.user_id', 'left');
      $this->db->where('lib_entity_user.eu_user_id', $eu_id);
      $query = $this->db->get();
      return $query->row();
   }

   function show_account_transactions($eu_id, $sy_id)
   {
      $this->db->select('*');
      $this->db->from('lib_transaction');
      $this->db->join('lib_entity_user', 'lib_transaction.tr_eu_id = lib_entity_user.eu_user_id', 'left');
      $this->db->join('lib_status', 'lib_transaction.tr_st_id = lib_status.st_id', 'left');
      $this->db->join('lib_book', 'lib_transaction.tr_bk_id = lib_book.bk_id', 'left');
      $this->db->join('lib_general', 'lib_book.bk_gb_id = lib_general.gb_id', 'left');
      $this->db->join('lib_author', 'lib_general.gb_au_id = lib_author.au_id', 'left');
      $this->db->where('lib_transaction.tr_eu_id', $eu_id);
      $this->db->where('lib_transaction.tr_sy_id', $sy_id);
      $this->db->order_by('tr_date', 'ASC');
      $query = $this->db->get();
      return $query->result();
   }

   function show_account_visits($eu_id, $sy_id)
   {
      $this->db->select('*');
      $this->db->from('lib_entrance');
      $this->db->join('lib_entity_user', 'lib_entrance.en_eu_id = lib_entity_user.eu_user_id', 'left');
      $this->db->where('lib_entity_user.eu_user_id', $eu_id);
      $this->db->where('lib_entrance.en_sy_id', $sy_id);
      $this->db->order_by('en_date', 'ASC');
      $query = $this->db->get();
      return $query->result();
   }

   function display_authors()
   {
      $this->db->select('*');
      $this->db->from('lib_author');
      $query = $this->db->get();
      return $query->result();
   }

   function display_author($id)
   {
      $this->db->select('*');
      $this->db->from('lib_author');
      $this->db->where('lib_author.au_id', $id);
      $query = $this->db->get();
      return $query->row();
   }

   function display_abook($id)
   {
      $this->db->select('*');
      $this->db->from('lib_general');
      $this->db->join('lib_author', 'lib_general.gb_au_id = lib_author.au_id', 'left');
      // $this->db->join('lib_book', 'lib_general.gb_id = lib_book.bk_gb_id', 'left');
      $this->db->where('lib_general.gb_au_id', $id);
      $query = $this->db->get();
      return $query->result();
   }

   function display_eu_accounts()
   {
      $this->db->select('*');
      $this->db->from('lib_entity_user');
      $query = $this->db->get();
      return $query->result();
   }

   function display_parent()
   {
      $ptype = 4;
      $this->db->select('*');
      $this->db->from('profile');
      $this->db->where('profile.account_type', $ptype);
      $query = $this->db->get();
      return $query->result();
   }

   function display_fns()
   {
      $this->db->select('*');
      $this->db->from('profile_employee');
      $this->db->join('profile', 'profile_employee.user_id = profile.user_id', 'left');
      $query = $this->db->get();
      return $query->result();
   }

   function display_bk_general_inventory()
   {
      $this->db->select('*');
      $this->db->from('lib_book');
      $this->db->join('lib_general', 'lib_book.bk_gb_id = lib_general.gb_id', 'left');
      $this->db->join('lib_publication', 'lib_book.bk_pub_id = lib_publication.pub_id', 'left');
      $this->db->join('lib_author', 'lib_general.gb_au_id = lib_author.au_id', 'left');
      $this->db->join('lib_dewey_category', 'lib_general.gb_dw_id = lib_dewey_category.dwc_id', 'left');
      $this->db->join('lib_status', 'lib_book.bk_st_id = lib_status.st_id', 'left');
      $query = $this->db->get();
      return $query->result();
   }

function display_item_list()
   {
      $this->db->select('*');
      $this->db->from('lib_book');
      $query = $this->db->get();
      return $query->result();
   }

   function display_general_list($cat=null)
   {
      $this->db->select('*');
      $this->db->from('lib_general');
      $this->db->join('lib_category', 'lib_general.gb_ca_id = lib_category.ca_id', 'left');
      if ($cat!=null) {
         $cat = $cat;
         $this->db->where('gb_ca_id', $cat);
      }
      // $this->db->join('lib_book', 'lib_general.gb_id = lib_book.bk_gb_id', 'left');
      // $this->db->join('lib_publication', 'lib_book.bk_pub_id = lib_publication.pub_id', 'left');
      // $this->db->join('lib_dewey_category', 'lib_general.gb_dw_id = lib_dewey_category.dwc_id', 'left');
      // $this->db->join('lib_status', 'lib_book.bk_st_id = lib_status.st_id', 'left');
      $query = $this->db->get();
      return $query->result();
   }

   function display_bks_bygen($bk_id)
   {
      $this->db->select('*');
      $this->db->from('lib_book');
      $this->db->join('lib_status', 'lib_book.bk_st_id = lib_status.st_id', 'left');
      $this->db->where('lib_book.bk_gb_id', $bk_id);
      $query = $this->db->get();
      return $query->result();
   }

   function display_items_bygen($gen_item)
   {
      $this->db->select('*');
      $this->db->from('lib_book');
      $this->db->where('lib_book.bk_gb_id', $gen_item);
      $query = $this->db->get();
      return $query->result();
   }

   function display_bk_general($uri)
   {
      $this->db->select('*');
      $this->db->from('lib_general');
      $this->db->join('lib_book', 'lib_general.gb_id = lib_book.bk_gb_id', 'left');
      $this->db->join('lib_publication', 'lib_book.bk_pub_id = lib_publication.pub_id', 'left');
      $this->db->join('lib_shelf', 'lib_book.bk_shelf_id = lib_shelf.sh_id', 'left');
      $this->db->join('lib_category', 'lib_general.gb_ca_id = lib_category.ca_id', 'left');
      $this->db->join('lib_author', 'lib_general.gb_au_id = lib_author.au_id', 'left');
      $this->db->join('lib_dewey_category', 'lib_general.gb_dw_id = lib_dewey_category.dwc_id', 'left');
      $this->db->join('lib_dewey', 'lib_dewey_category.dwc_dw_id = lib_dewey.dw_id', 'left');
      $this->db->join('lib_status', 'lib_book.bk_st_id = lib_status.st_id', 'left');
      $this->db->where('lib_general.gb_id', $uri);
      $query = $this->db->get();
      return $query->row();
   }

   function borrowed_items()
   {
      $bstatus = 1;
      $this->db->select('*');
      $this->db->from('lib_book');
      $this->db->join('lib_general', 'lib_book.bk_gb_id = lib_general.gb_id', 'left');
      $this->db->join('lib_transaction', 'lib_book.bk_tr_id = lib_transaction.tr_id', 'left');
      $this->db->join('profile', 'lib_transaction.tr_eu_id = profile.user_id', 'left');
      $this->db->join('profile_students_admission', 'profile.user_id = profile_students_admission.user_id', 'left');
      $this->db->where('lib_book.bk_st_id', $bstatus);
      $query = $this->db->get();
      return $query->result();
   }

   function attendance_now()
   {
      $datenow = date('Y-m-d');
      $sy = $this->session->userdata('school_year');
      $this->db->select('*');
      $this->db->from('lib_entrance');
      $this->db->join('profile', 'lib_entrance.en_eu_id = profile.user_id', 'left');
      $this->db->join('profile_students_admission', 'profile.user_id = profile_students_admission.user_id', 'left');
      $this->db->join('grade_level', 'profile_students_admission.grade_level_id = grade_level.grade_id', 'left');
      $this->db->where('lib_entrance.en_date_in', $datenow);
      $this->db->where('profile_students_admission.school_year', $sy);
      $this->db->order_by('en_id', 'DESC');
      $query = $this->db->get();
      return $query->result();
   }

   function display_dewey()
   { 
      $this->db->select('*');
      $this->db->from('lib_dewey_category');
      $this->db->join('lib_dewey', 'lib_dewey_category.dwc_dw_id = lib_dewey.dw_id', 'left');
      $this->db->order_by('dwc_cat_id', 'ASC');
      $query = $this->db->get();
      return $query->result();
   }

   function display_dewey_gen()
   { 
      $this->db->select('*');
      $this->db->from('lib_dewey');
      // $this->db->join('lib_dewey', 'lib_dewey_category.dwc_dw_id = lib_dewey.dw_id', 'left');
      $query = $this->db->get();
      return $query->result();
   }

   function display_dewey_category()
   {
      $this->db->select('*');
      $this->db->from('lib_dewey_category');
      $query = $this->db->get();
      return $query->result();
   }

   function display_lib_general_com()
   {
      $this->db->select('*');
      $this->db->from('lib_general');
      $this->db->join('lib_author', 'lib_general.gb_au_id = lib_author.au_id', 'left');
      $this->db->join('lib_dewey_category', 'lib_general.gb_dw_id = lib_dewey_category.dwc_id', 'left');
      $query = $this->db->get();
      return $query->result();
   }

   function display_a_book($bk_id)
   {
      $this->db->select('*');
      $this->db->from('lib_book');
      $this->db->join('lib_general', 'lib_book.bk_gb_id = lib_general.gb_id', 'left');
      $this->db->join('lib_shelf', 'lib_book.bk_shelf_id = lib_shelf.sh_id', 'left');
      $this->db->join('lib_dewey_category', 'lib_general.gb_dw_id = lib_dewey_category.dwc_id', 'left');
      $this->db->join('lib_dewey', 'lib_dewey_category.dwc_dw_id = lib_dewey.dw_id', 'left');
      $this->db->join('lib_author', 'lib_general.gb_au_id = lib_author.au_id', 'left');
      $this->db->join('lib_publication', 'lib_book.bk_pub_id = lib_publication.pub_id', 'left');
      $this->db->join('lib_status', 'lib_book.bk_st_id = lib_status.st_id', 'left');
      $this->db->where('lib_book.bk_id', $bk_id);
      $query = $this->db->get();
      return $query->row();      
   }

   function show_item_transactions($item_id)
   {
      $this->db->select('*');
      $this->db->from('lib_transaction');
      $this->db->join('profile', 'lib_transaction.tr_eu_id = profile.user_id', 'left');
      $this->db->join('lib_status', 'lib_transaction.tr_st_id = lib_status.st_id', 'left');
      $this->db->join('lib_book', 'lib_transaction.tr_bk_id = lib_book.bk_id', 'left');
      $this->db->join('lib_general', 'lib_book.bk_gb_id = lib_general.gb_id', 'left');
      $this->db->join('lib_author', 'lib_general.gb_au_id = lib_author.au_id', 'left');
      $this->db->where('lib_transaction.tr_bk_id', $item_id);
      $this->db->order_by('tr_date', 'ASC');
      $query = $this->db->get();
      return $query->result();
   }

   function show_item_infographics($gb_id)
   {
      $this->db->select('*');
      $this->db->from('lib_book');
      $this->db->join('lib_general', 'lib_book.bk_gb_id = lib_general.gb_id', 'left');
      $this->db->join('lib_status', 'lib_book.bk_st_id = lib_status.st_id', 'left');
      $this->db->where('lib_book.bk_gb_id', $gb_id);
      $query = $this->db->get();
      return $query->result();
   }

   function display_shelf()
   {
      $this->db->select('*');
      $this->db->from('lib_shelf');
      $query = $this->db->get();
      return $query->result();
   }

   function display_category()
   {
      $this->db->select('*');
      $this->db->from('lib_category');
      $query = $this->db->get();
      return $query->result();
   }
   
   function lib_publication()
   {
      $this->db->select('*');
      $this->db->from('lib_publication');
      $query = $this->db->get();
      return $query->result();
   }
   
   function lib_status()
   {
      $this->db->select('*');
      $this->db->from('lib_status');
      $query = $this->db->get();
      return $query->result();
   }

   function save_new_author($au_name, $au_address, $au_website, $au_email)
   {
      $data = array(
         'au_name' => $au_name,
         'au_address' => $au_address,
         'au_web' => $au_website,
         'au_email' => $au_email,
      );
      $this->db->insert('lib_author', $data);
      return $this->db->insert_id();  
   }

   function save_new_dds($bk_dds_code, $bk_dds_desc, $bk_deweys)
   {
      $data = array(
         'dwc_cat_id' => $bk_dds_code,
         'dwc_description' => $bk_dds_desc,
         'dwc_dw_id' => $bk_deweys,
      );
      $this->db->insert('lib_dewey_category', $data);
      return $this->db->insert_id();
   }

   function save_new_tt($bk_tt)
   {
      $data = array(
         'tt_topical_term' => $bk_tt,
      );
      $this->db->insert('lib_topical_term', $data);
      return $this->db->insert_id();
   }

   function save_new_publication($pb_name, $pb_address, $pb_contactnum, $pb_contactperson, $pb_web, $pb_email)
   {
      $data = array(
         'pub_publication' => $pb_name, 
         'pub_address' => $pb_address, 
         'pub_contact_number' => $pb_contactnum, 
         'pub_contact_person' => $pb_contactperson, 
         'pub_web' => $pb_web, 
         'pub_email' => $pb_email,
      ) ;
      $this->db->insert('lib_publication', $data);
      return $this->db->insert_id(); 
   }

   function saveAccount($eu_id, $eu_status)
   {
      $data = array(
         'eu_user_id' => $eu_id,
         'eu_status' => $eu_status,
      );
      $this->db->insert('lib_entity_user', $data);
      return $this->db->insert_id();
   }

   function save_new_genbook($gb_ss, $gb_other_auth, $gb_id, $gb_title, $gb_sub_title, $gb_auth, $gb_sor, $gb_volume, $gb_dw, $gb_ca_id, $gb_remarks, $gb_tt)
   {
      $data = array(
         'gb_id' => $gb_id,
         'gb_title' => $gb_title,
         'gb_sub_title' => $gb_sub_title,
         'gb_author' => $gb_auth,
         'gb_co_author' => $gb_other_auth,
         'gb_sor' => $gb_sor,
         'gb_volume' => $gb_volume,
         'gb_dw' => $gb_dw,
         'gb_ca_id' => $gb_ca_id,
         'gb_remarks' => $gb_remarks,
         'gb_series_statement' => $gb_ss,
         'gb_topical_terms' => $gb_tt,
      );
      $this->db->insert('lib_general', $data);
      return $this->db->insert_id();
   }

   function save_new_book($bk_id, $bk_gb_id, $bk_call_number, $bk_access_number, $bk_extent, $bk_pub_id, $bk_pub_date, $bk_serial_num, $bk_rfid, $bk_copyright, $bk_st_id, $bk_st_date, $bk_cost_price, $bk_date_acquired, $bk_edition, $bk_isbn, $bk_dimension, $bk_shelf_id, $bk_fn_id, $bk_borrow_days, $bk_physical_desc, $bk_source, $bk_tr_id)
   {
      $data = array(
         'bk_id' => $bk_id,
         'bk_gb_id' => $bk_gb_id, 
         'bk_pub_id' => $bk_pub_id,
         'bk_call_number' => $bk_call_number, 
         'bk_pub_date' => $bk_pub_date,
         'bk_serial_num' => $bk_serial_num, 
         'bk_rfid' => $bk_rfid, 
         'bk_copyright_yr' => $bk_copyright,
         'bk_st_id' => $bk_st_id, 
         'bk_st_date' => $bk_st_date,
         'bk_cost_price' => $bk_cost_price, 
         'bk_date_acquired' => $bk_date_acquired, 
         'bk_edition' => $bk_edition, 
         'bk_isbn' => $bk_isbn, 
         'bk_shelf_id' => $bk_shelf_id, 
         'bk_fn_id' => $bk_fn_id, 
         'bk_borrow_days' => $bk_borrow_days, 
         'bk_physical_desc' => $bk_physical_desc, 
         'bk_source' => $bk_source,
         'bk_tr_id' => $bk_tr_id,
      );
      $this->db->insert('lib_book', $data);
      return $this->db->insert_id();
   }

   function save_new_transaction($tr_id, $tr_st_id, $tr_bk_id, $tr_date, $tr_staff_id, $tr_eu_id, $tr_due_date, $tr_flag, $tr_sy_id)
   {
      $data = array(
         'tr_id' => $tr_id,
         'tr_st_id' => $tr_st_id, 
         'tr_bk_id' => $tr_bk_id, 
         'tr_date' => $tr_date, 
         'tr_staff_id' => $tr_staff_id, 
         'tr_eu_id' => $tr_eu_id, 
         'tr_due_date' => $tr_due_date,
         'tr_flag' => $tr_flag,
         'tr_sy_id' => $tr_sy_id,
      );
      $this->db->insert('lib_transaction', $data);
      return $this->db->insert_id();
   }

   function save_new_bk_transaction($tr_id, $tr_st_id, $tr_bk_id, $tr_date, $tr_staff_id, $tr_eu_id, $tr_remarks)
   {
      $data = array(
         'tr_id' => $tr_id,
         'tr_st_id' => $tr_st_id, 
         'tr_bk_id' => $tr_bk_id, 
         'tr_date' => $tr_date, 
         'tr_staff_id' => $tr_staff_id, 
         'tr_eu_id' => $tr_eu_id, 
         'tr_remarks' => $tr_remarks,
      );
      $this->db->insert('lib_transaction', $data);
      return $this->db->insert_id();
   }   

   function save_entrance_in($eu_id, $time_in, $date_in, $sy_id)
   {
      $data = array(
         'en_eu_id' => $eu_id,
         'en_time_in' => $time_in,
         'en_date_in' => $date_in,
         'en_sy_id' => $sy_id,
         // 'en_date' =>$date,
      );
      $this->db->insert('lib_entrance', $data);
      return $this->db->insert_id();
   }

   function save_entrance_out($ent, $ltrans_id)
   {
      $this->db->where('en_id', $ltrans_id);
      $this->db->update('lib_entrance', $ent);
      return;
   }

   function update_book_info($items, $bk_id)
   {
      $this->db->where('bk_id', $bk_id);
      $this->db->update('lib_book', $items);
      return;
   }

   function edit_bk($items, $bk_id)
   {
      $this->db->where('bk_id', $bk_id);
      $this->db->update('lib_book', $items);
      return;
   }

   function edit_gb($items, $gb_id)
   {
      $this->db->where('gb_id', $gb_id);
      $this->db->update('lib_general', $items);
      return;
   }

   function edit_lib_transaction($trans, $tr_id)
   {
      $this->db->where('tr_id', $tr_id);
      $this->db->update('lib_transaction', $trans);
      return;
   }

   function edit_lib_book($books, $bk_id)
   {
      $this->db->where('bk_id', $bk_id);
      $this->db->update('lib_book', $books);
      return;
   }

   function edit_lib_entity_user($user, $eu_id)
   {
      $this->db->where('eu_user_id', $eu_id);
      $this->db->update('lib_entity_user', $user);
      return;
   }

   function setImage($id, $image)
   {
        
      $data = array(
         'gb_pic' => $image
      );   
            
        $this->db->where('gb_id', $id);
        $this->db->update('lib_general', $data);
   }

   // function editAccountPlan($data, $accounts_id)
   //  {
   //      $this->db->where('accounts_id', $accounts_id);
   //      $this->db->update('fin_accounts', $data);
   //      return;
   //  }

   // function getMenu($position_id)
   // {
   //    $this->db->select('*');
   //    $this->db->from('user_groups');
   //    $this->db->where('position_id', $position_id);
   //    $this->db->join('grade_level', 'fin_initial.level_id = grade_level.grade_id', 'left');
   //    $query = $this->db->get();
   //    return $query->row();
   // }
   
}

?>