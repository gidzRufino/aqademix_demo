<?php

defined('BASEPATH') OR EXIT('nO DIRECT SCRIPT ALLOWED');

class Page extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Page_model');
    }

    public function index() {
      
 
        $data['id_items']=$this->Page_model->selectquizitemsid();
        $data['quiztag']=$this->Page_model->selectTag();
        $data['quiztype']=$this->Page_model->selectQuiztype();
        $this->load->view('header');
        $this->load->view('admin',$data);
        $this->load->view('footer');
      // echo json_encode($id);
    }
    public function countitems()
    {
        $id=$this->input->post('id');
       echo json_encode($this->Page_model->countitems($id));
    }
    public function insertQuizitemsdata() {
        $items=$this->input->post('itemcounts');
        $qi_id = $this->Page_model->countqi_id();
        $data = array(
            'qt_id'=>$this->input->post('quiztype'),
            'date_created' => $this->input->post('datecreated'),
            'date_Activation_key' => $this->input->post('dateactivated'),
            'date_expired' => $this->input->post('dateexpired'),
            'qi_title' => $this->input->post('title'),
            'qtype_id'=>$this->input->post('tags'),
            'instruction' => $this->input->post('instruction')
        );
        $this->Page_model->insertQuizitems($data);
        for ($i = 1; $i <= $items; $i++) {

            $answer = array('question' => $this->input->post("question" . $i),
                'right_answer' => $this->input->post("right" . $i),
                'qi_id' => $this->Page_model->countqi_id());
            $this->Page_model->insertQuestion($answer);
        }
        redirect($this->index);
    }
    public function selectid()
    {
        $id=$this->input->post('id');
        echo json_encode( $this->Page_model->selectitems($id));
       
    }
    public function addCategorydata() {
        $data = array('qtuiz_type' => $this->input->post('category'));
        $this->Page_model->addCategory($data);
        redirect($this->index);
    }

    public function addTagdata() {
        $data = array('tag_name' => $this->input->post('tag'));
        $this->Page_model->addTag($data);
        redirect($this->index);
    }

}

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

