<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Finance_widgets extends MX_Controller {
    
   public function show_students()
   {
      $parent = Modules::run('users/getParentData', $this->session->userdata('user_id'));
      $data['child_links'] = $parent->child_links;
      $result = $this->load->view('finance/showStudents', $data);
      return $result;
        
    }
    
    function getDetailedAccounts()
    {
       $sy_now = $this->session->userdata('school_year');
        if ($sy_now == 2014){
              $sy_id = 2;
          }else if ($sy_now == 2015){
              $sy_id = 3;
          }else if ($sy_now == 2016){
              $sy_id = 4;
          }else if ($sy_now == 2017){
              $sy_id = 5;
          }else if ($sy_now == 2018){
              $sy_id = 6;
          }
        $data['school'] = $sy_id;
        $data['initialLevel'] = Modules::run('financemanagement/showfinInitialPerLevel');
        $data['sTransaction'] = Modules::run('financemanagement/showfinHistoryPerStudent');
        $data['showItems'] = Modules::run('financemanagement/showfinItems');
        $data['show_extra'] = Modules::run('financemanagement/show_added_charge');
        $data['tdetails'] = Modules::run('financemanagement/show_trans_details');
        $data['accountz'] = Modules::run('financemanagement/showfinParentAccount', $this->session->userdata('school_year'), $this->session->userdata('user_id'));
        $this->load->view('finance/detailedAccounts', $data);
    }
}

