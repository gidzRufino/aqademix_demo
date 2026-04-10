<?php

defined('BASEPATH') OR EXIT('nO DIRECT SCRIPT ALLOWED');

class Page extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Page_model');
    }
    public function index() {
        $data['id_items']=$this->Page_model->selectquizitemsid();
        $data['quiztag']=$this->Page_model->selectTag();
        $data['quiztype']=$this->Page_model->selectQuiztype();
        $data['modules'] = 'page';
        $data['main_content'] = 'admin';
        echo Modules::run('templates/main_content', $data);
//        $this->load->view('header');
//        $this->load->view('admin',$data);
//        $this->load->view('footer');
      // echo json_encode($id);
    }
    public function countitems()
    {
        $id=$this->input->post('id');
       echo json_encode($this->Page_model->countitems($id));
    }
    public function multdisplaydata()
    {
        $id=$this->input->post('id');
       echo json_encode($this->Page_model->multdisplay($id));
  
    }
    public function choices()
    {
        $id=$this->input->post('idch');
        echo json_encode($this->Page_model->selectchoices($id));
        //selectchoices
    }

    public function insertQuizitemsdata() {
       $typequiz=$this->input->post('quiztype');
       $query=$this->Page_model->countqi_id();
       $datacount=$this->Page_model->countqq_id();
       $qi_id=null;
       $qq_id=null;
       foreach($datacount as $data)
       {
          $qq_id=$data->qq_id;
       }
       foreach ($query as $value) {
           $qi_id= $value->qi_id;     
       }
       $idcount=$qi_id+1;
       $idcountqq_id=$qq_id+1;
       if($typequiz==1)
       {
           $choicec= $this->input->post('multnumber');
          $items = $this->input->post('itemcounts');
            $qi_id = $this->Page_model->countqi_id();
            $data = array(
                'qt_id' => $this->input->post('quiztype'),
                'date_created' => $this->input->post('datecreated'),
                'date_Activation_key' => $this->input->post('dateactivated'),
                'date_expired' => $this->input->post('dateexpired'),
                'qi_title' => $this->input->post('title'),
                'qtag_id' => $this->input->post('tags'),
                'instruction' => $this->input->post('instruction')
            );
          $this->Page_model->insertQuizitems($data);
           for ($i = 1; $i <= $items; $i++) {
                $question=$this->input->post("question" . $i);
                $fnalquestion= $i." " .$question;
                $answer = array('question' => $fnalquestion,
                    'right_answer' => $this->input->post("right" . $i),
                    'qi_id' => $idcount);
                $this->Page_model->insertQuestion($answer);
                for($choice=0;$choice<$choicec;$choice++)
                {
                    //echo $this->input->post("stated".$choice);
                   $choices =array('choice'=>$this->input->post("choice".$choice),
                                    'choice_stated'=>$this->input->post("stated".$choice),
                            'qi_id'=>$idcount,
                            'qq_id'=>$idcountqq_id,
                            'num_choices'=>$choicec
                            );
                     $this->Page_model->insertchoicesdata($choices);
                }
                $idcountqq_id++;
                 
            }
              
       }
       else if($typequiz==2)
        {
             $items = $this->input->post('itemcounts');
            $qi_id = $this->Page_model->countqi_id();
            $data = array(
                'qt_id' => $this->input->post('quiztype'),
                'date_created' => $this->input->post('datecreated'),
                'date_Activation_key' => $this->input->post('dateactivated'),
                'date_expired' => $this->input->post('dateexpired'),
                'qi_title' => $this->input->post('title'),
                'qtag_id' => $this->input->post('tags'),
                'instruction' => $this->input->post('instruction')
            );
            $this->Page_model->insertQuizitems($data);
            for ($i = 1; $i <= $items; $i++) {

                $answer = array('question' => $this->input->post("question" . $i),
                    'right_answer' => $this->input->post("right" . $i),
                    'qi_id' => $idcount);
                $this->Page_model->insertQuestion($answer);
            }
        }
        else if($typequiz==3)
        {
           $items = $this->input->post('itemcounts');
            $qi_id = $this->Page_model->countqi_id();
            $data = array(
                'qt_id' => $this->input->post('quiztype'),
                'date_created' => $this->input->post('datecreated'),
                'date_Activation_key' => $this->input->post('dateactivated'),
                'date_expired' => $this->input->post('dateexpired'),
                'qi_title' => $this->input->post('title'),
                'qtag_id' => $this->input->post('tags'),
                'instruction' => $this->input->post('instruction')
            );
            $this->Page_model->insertQuizitems($data);
            for ($i = 1; $i <= $items; $i++) {

                $answer = array('question' => $this->input->post("question" . $i),
                    'right_answer' => $this->input->post("right" . $i),
                    'qi_id' =>  $idcount);
                $this->Page_model->insertQuestion($answer);
            }
        }
       redirect($this->index);
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

