<?php

defined('BASEPATH') or exit('NO DIRECT SCRIPT ALLOWED');

class Page_model extends CI_Model {

    function selectgradelevel() {
        $data=$this->db->get('quizgradelevel');
        return $data->result();       
    }
    function insertchoicesdata($datamult)
    {
        $data=$this->db->insert('quizmultiple',$datamult);
        
    }
    function countqi_id()
    {
       $this->db->select_max('qi_id');
       $query = $this->db->get('quizitems');
       return $query->result();
       
    }
    function countqq_id()
    {
       $this->db->select_max('qq_id');
       $query = $this->db->get('quizquestions');
       return $query->result();
    }
   function countitems($id)
    {
       // $this->db->where('qi_id',$id);
       // $datas=$this->db->get('quizquestions');
        $this->db->where('quizquestions.qi_id',$id);
        $this->db->select('quizitems.qt_id,quizitems.instruction,quizitems.qi_title,quizquestions.question,quizquestions.right_answer');
        $this->db->from('quizitems');
        $this->db->join('quizquestions',' quizitems.qi_id= quizquestions.qi_id');
        $datas=$this->db->get();  
        return $datas->result();
       
    }
    function multdisplay($ids)
    {
        $this->db->select('*');
        $this->db->from('quizitems');
        $this->db->join('quizquestions','quizitems.qi_id = quizquestions.qi_id','right');
        $this->db->join('quizmultiple','quizquestions.qq_id = quizmultiple.qq_id','left');
        $this->db->where('quizitems.qi_id',$ids);
        $datas=$this->db->get();  
        return $datas->result();
    }
    function selectchoices($id)
    {
        $this->db->select('*');
        $this->db->from('quizmultiple');
        $this->db->where('qq_id',$id);
    }
            
     function insertQuestion($question)
    {
        $this->db->insert('quizquestions', $question);
    }
    function insertQuizitems($dataQuiz) {//gamit
        $this->db->insert('quizitems', $dataQuiz);
    }

    function selectTag() {
        $data = $this->db->get('quiztag');
        return $data->result();
    }

    function selectQuiztype() {//gamit
        $data = $this->db->get('quiztype');
        return $data->result();
    }

    function addCategory($data){//gamit
        $this->db->insert('quiztype', $data);
    }

    function addTag($data) {//gamit
        $this->db->insert('quiztag', $data);
    }
    function selectquizitemsid()
    {
        $items=$this->db->get('quizitems');
        return $items->result();
    }

}
