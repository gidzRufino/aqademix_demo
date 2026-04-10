<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of gradingsystem
 *
 * @author genesis
 */
class gradingsystem extends MX_Controller {

    //put your code here

    public function __construct() {
        parent::__construct();
        $this->load->model('gradingsystem_model');
    }
    
    public function cleanAssessment()
    {
        $this->db->where('section_id', 3);
        $this->db->join('gs_assessment','gs_raw_score.assess_id = gs_assessment.assess_id','left');
        $q = $this->db->get('gs_raw_score');
        foreach ($q->result() as $qr):
            $this->db->where('assess_id', $qr->assess_id);
            if($this->db->delete('gs_raw_score')):
                $this->db->where('assess_id', $qr->assess_id);
                if($this->db->delete('gs_assessment')):
                    echo $qr->assess_id.' successfully deleted <br />';
                endif;
            endif;
        endforeach;
    }
    
//    function finalgradeUpdate()
//    {
//        $i = 0;
//        $this->eskwela->db(2016);
//        $this->db->where('grading', 0);
//        $this->db->where('school_year', 2016);
//        $q=$this->db->get('gs_final_card');
//        foreach ($q->result() as $report)
//        {
//            
//            $update =array('final_rating' => $report->final_rating - 1, 'is_final' => 0);
//            $this->db->where('id', $report->id);
//            if($this->db->update('gs_final_card', $update)):
//                $i++;
//            endif;
//            
//        }
//        
//        echo "Successfully updated $i records";
//        
//    }
    
    function gs_update()
    {
//          $sql = "ALTER TABLE `esk_gs_final_card` ADD `is_manual` INT NOT NULL AFTER `is_final`;";
//          if($this->db->query($sql)):
//              echo "Successfully Updated";
//          endif;
        $i = 0;
        $this->db->where('school_year', 2017);
        $q = $this->db->get('gs_asses_category');
        foreach ($q->result() as $r):
            switch ($r->category_name):
                case 'Written Work':
                    $details = array('component_id' => 1);
                    
                break;
                case 'Performance Task':
                    $details = array('component_id' => 2);
                    
                break;
                case 'Quarterly Assessment':
                    $details = array('component_id' => 3);
                    
                break;    
                    
            endswitch;
                $this->db->where('category_name', $r->category_name);
                if($this->db->update('gs_asses_category', $details)):
                    $i++;
                endif;
        endforeach;
        echo $i;
    }
    
    function transmutationUpdate()
    {       
            $array = array('to_grade'=> '55.99');
            $this->db->where('trans_id', 28);
        if($this->db->update('gs_transmutation', $array)):
            echo 'Transmutation Successfully Updated';
        endif;
        
    }
    
    function cleanUpDoubles($section_id=NULL)
    {
        $sql = 'DELETE n1 FROM esk_gs_final_assessment n1, esk_gs_final_assessment n2 WHERE n1.as_id < n2.as_id AND n1.st_id = n2.st_id AND n1.section_id = n2.section_id AND n1.subject_id = n2.subject_id AND n1.first = n2.first';
        if($this->db->query($sql)):
            echo 'Duplicates removed<br /><br /><br />';
        endif;
        
    }
    
      
    function fourExams()
    {
        $array = array(
            '1' => 'Prelim',
            '2' => 'Midterm',
            '3' => 'Semi Final',
            '4' => 'Final'  
        );   
        return $array;
    } 
    
    function twoExams()
    {
        $array = array(
            '5'
        );
    }
    
    function addSubComponent()
    {
        $component = $this->input->post('component');
        $result = json_decode($this->gradingsystem_model->addSubComponent($component));
        if($result->status):
            $data = array('status'=> TRUE, 'id'=>$result->id);
        else:    
            $data = array('status'=> FALSE);
        endif;
        
        echo json_encode($data);
    }
    
    function addComponent()
    {
        $component = $this->input->post('component');
        $result = json_decode($this->gradingsystem_model->addComponent($component));
        if($result->status):
            $data = array('status'=> TRUE, 'id'=>$result->id);
        else:    
            $data = array('status'=> FALSE);
        endif;
        
        echo json_encode($data);
    }
    
    function saveSpecialization($details, $user_id, $spec_id, $school_year)
    {
        $specs = $this->gradingsystem_model->saveSpecialization($details, $user_id, $spec_id, $school_year);
        return $specs;
    }
    
    function recordInGr()
    { 
        $details = array(
            'st_id' => $this->input->post('st_id'),  
            'in_gr_id' => $this->input->post('in_gr_id'),  
            'subject_id' => $this->input->post('subject_id'),  
            'rating' => $this->input->post('rating'),  
            'term' => $this->input->post('term'),  
            'school_year' => $this->input->post('school_year'),  
        );
        
            $saveResult = $this->gradingsystem_model->recordInGr($details, $this->input->post('in_gr_id'), $this->input->post('term'), $this->input->post('school_year'),$this->input->post('st_id'),$this->input->post('subject_id'));
        if ($saveResult) {
            $msg = '<div id="alert-info" style="position:absolute; top:50%; left:45%; z-index:2000;" class="alert alert-success" data-dismiss="alert-message">
                <h4>Rating Recorded Successfully!</h4>

            </div>';
        } else {
            $msg = '<div id="alert-info"  style="position:absolute; top:50%; left:45%; z-index:2000;" class="alert alert-success" data-dismiss="alert-message">
                <h4>Rating Updated Successfully!</h4>

            </div>';
        }
        
         echo json_encode(array('msg' => $msg));
    }
    
    function getInGrDetails($sub_id, $st_id, $term, $year, $in_gr_id = NULL)
    {
        $ingr = $this->gradingsystem_model->getInGr($sub_id, $st_id, $term, $year, $in_gr_id);
        return $ingr;
    }
    
    function getInGr()
    {
        $data['subject_id'] = $this->input->post('subject_id');
        $data['st_id']= $this->input->post('st_id');
        $data['term'] = $this->input->post('term');
        $data['sy']= $this->input->post('school_year');
        $data['getInGrDetails'] = $this->gradingsystem_model->getInGr_details($this->input->post('subject_id'));
        $this->load->view('in_gr', $data);
    }
    
    function dataInterpret($assess_id)
    {
        $q = $this->gradingsystem_model->getAssessResult($assess_id);
        $a=0;
        $p=0;
        $ap=0;
        $d=0;
        $b=0;
        $total = 0;
        foreach ($q as $q):
            $total++;
            $result = ($q->raw_score/$q->no_items);
            $final = Modules::run('gradingsystem/new_gs/getTransmutation', ($result*100));
            $flg = Modules::run('gradingsystem/getEquivalent', $final);
            switch($flg):
                case 'A':
                    $a += 1;
                break;    
                case 'P':
                    $p += 1;
                break;    
                case 'AP':
                    $ap +=1;
                break;    
                case 'D':
                    $d += 1;
                break;
                case 'B':
                    $b += 1;
                break;    
            endswitch;
        endforeach;
        
        return json_encode(array('a'=>$a, 'p'=> $p, 'ap'=>$ap, 'd'=>$d, 'b'=>$b, 'total' => $total));
        
       
    }
    
    function getSet($school_year)
    {
        $settings = $this->gradingsystem_model->getSettings($school_year);
        return $settings;
    }
    
    function checkIfCardLock($st_id, $sy)
    {
        $lock = $this->gradingsystem_model->checkIfCardLock($st_id, $sy);
        if($lock):
            return TRUE;
        else:
            return FALSE;
        endif;
    }
    
    function lockFinalCard($st_id, $sy)
    {
        if($this->gradingsystem_model->lockFinalCard($st_id, $sy)):
            echo json_encode(array('status' => TRUE)) ;
        else:
            echo json_encode(array('status' => FALSE)) ;
        endif;
        
    }
    
    
    function getTopPerformerPerSubject($level, $subject, $grading, $school_year)
    {
        $getTops = Modules::load('gradingsystem/gs_tops');
        $generate = $getTops->getTopTenPerSubject($level, $subject, $grading, $school_year);
        return $generate;
    }
    
    function getTopTenPerLevel()
    {
        $topTen = Modules::load('gradingsystem/gs_tops');
        return $topTen;
    }
    
    function getTopPerformerPerLevel($level, $grading, $school_year)
    {
        $subject = Modules::run('academic/getSubjects');
        
        foreach($subject as $s):
           if($s->subject_id<=4 || $s->subject_id==9):
               $topTen = $this->getTopPerformerPerSubject($level, $s->subject_id, $grading, $school_year) ;
               $data = array(
                    'subject' => $s->subject,
                    'topTen'  => $topTen
                );   
                echo Modules::run('widgets/getWidget', 'gradingsystem_widget', 'topPerformer', $data);  
           endif;
           
            
        endforeach; 
    }
    
    function topPerformer()
    {
        $data['ro_year'] = Modules::run('registrar/getROYear');
        $data['gradeLevel'] = Modules::run('registrar/getGradeLevel');
        $data['modules'] = "gradingsystem";
        $data['main_content'] = 'topPerformer';
        echo Modules::run('templates/main_content', $data);
    }
    
    function getAssessCatBySubject($subject_id, $school_year = NULL)
    {
        $cat = $this->gradingsystem_model->getAssessCatBySubject($subject_id, $school_year);
        return $cat;
    }
    
    function getPromotionalReport($grade_id, $school_year=NULL)
    {
        $promotion = $this->gradingsystem_model->getPromotionalReport($grade_id, $school_year);
        if($promotion->num_rows()>0):
            foreach ($promotion->result() as $prom):
                $pro_m += $prom->pro_m;
                $pro_f += $prom->pro_f;
                $re_m += $prom->re_m;
                $re_f += $prom->re_f;
                $irr_m += $prom->irr_m;
                $irr_f += $prom->irr_f;
                $b_m += $prom->b_m;
                $b_f += $prom->b_f;
                $d_m += $prom->d_m;
                $d_f += $prom->d_f;
                $ap_m += $prom->ap_m;
                $ap_f += $prom->ap_f;
                $p_m += $prom->p_m;
                $p_f += $prom->p_f;
                $a_m += $prom->a_m;
                $a_f += $prom->a_f;
            endforeach;
        endif;
        
        $result = json_encode(
                    array(
                        'pro_m' => $pro_m,
                        'pro_f' => $pro_f,
                        're_m' => $re_m,
                        're_f' => $re_f,
                        'irr_m' => $irr_m,
                        'irr_f' => $irr_f,
                        'b_m' => $b_m,
                        'b_f' => $b_f,
                        'd_m' => $d_m,
                        'd_f' => $d_f,
                        'ap_m' => $ap_m,
                        'ap_f' => $ap_f,
                        'p_m' => $p_m,
                        'p_f' => $p_f,
                        'a_m' => $a_m,
                        'a_f' => $a_f,
                    )
                );
               // print_r($result);
        return $result;
    }
    
    public function savePromotion($grade_id, $section_id, $column, $value, $school_year)
    {
        $this->gradingsystem_model->savePromotion($section_id,$grade_id, $column, $value, $school_year);
        return;
    }
    
    public function saveGeneralAverage($section_id, $st_id, $subject_id, $school_year, $rating)
    {
        $final = array(
            'final' => $rating
        );
        
        $this->gradingsystem_model->saveGeneralAverage($final, $section_id, $subject_id, $st_id, $school_year);
        return;
    }
    
    public function saveFinalAverage($st_id, $finalRating, $school_year)
    {
        $final = array(
            'st_id' => $st_id,
            'subject_id' => 0,
            'final_rating' => $finalRating,
            'school_year' => $school_year
        );
        
        $this->gradingsystem_model->saveFinalAverage($final, $st_id, 0, $school_year);
    }


    public function deleteKPUPS()
    {
        $custom = $this->input->post('custom');
        $name = $this->input->post('name');
        $id = $this->input->post('id');
//        if($custom==0):
//             $this->gradingsystem_model->modifyKPUPS('Knowledge', 15);
//             $this->gradingsystem_model->modifyKPUPS('Process', 25);
//             $this->gradingsystem_model->modifyKPUPS('Understanding', 30);
//             $this->gradingsystem_model->modifyKPUPS('Product', 30);
//        endif;
//        
        if($this->gradingsystem_model->deleteKPUPS($id)):
            echo json_encode(
                    array('msg' => 'Criteria Successfully Deleted', 'status' => TRUE)
                    );
        else:
            echo json_encode(
                    array('msg' => 'Error Occured while Deleting', 'status' => FALSE)
                    );
        endif;
    }
    
    public function saveKPUPS()
    {
        $details = array(
            'kpup_default'   => $this->input->post('custom'),
        );
        
        $this->gradingsystem_model->saveTransmutation($details);
        
        if($this->input->post('custom')==0):
        
            $k = $this->input->post('k');
            $this->gradingsystem_model->modifyKPUPS('Knowledge', $k, $this->input->post('subject_id'));
            $proc = $this->input->post('proc');
            $this->gradingsystem_model->modifyKPUPS('Process', $proc, $this->input->post('subject_id'));
            $u = $this->input->post('u');
            $this->gradingsystem_model->modifyKPUPS('Understanding', $u, $this->input->post('subject_id'));
            $prod = $this->input->post('prod');
            $this->gradingsystem_model->modifyKPUPS('Product', $prod, $this->input->post('subject_id'));
         
        else:
             $this->gradingsystem_model->modifyKPUPS('Knowledge', 15,0);
             $this->gradingsystem_model->modifyKPUPS('Process', 25,0);
             $this->gradingsystem_model->modifyKPUPS('Understanding', 30,0);
             $this->gradingsystem_model->modifyKPUPS('Product', 30,0);
        endif;
        
        $hasAddedCriteria = $this->input->post('hasAddedCriteria');
        $addedCriteria = $this->input->post('addedCriteria');
        if($hasAddedCriteria==0):
             echo json_encode(
                    array('msg' => 'There is no added Criteria', 'status' => FALSE, 'alert' =>'Successfully Set')
                    );
            
        else:
               $j = json_decode($addedCriteria);
            foreach ($j->addedCriteria as $j)
            {
                $this->gradingsystem_model->modifyKPUPS($j->name, $j->value, $this->input->post('subject_id'));
            }
            echo json_encode(
                    array('msg' => 'Criteria Successfully Set', 'status' => TRUE)
                    );
        endif;
    }
    
    public function getSettings($total = NULL, $score = NULL )
    {
        $settings = $this->gradingsystem_model->getSettings($this->session->userdata('school_year'));
        if($settings->by_base!=0):
            $base = $settings->base;
            $remaining = 100 - $base;
            $result = ((($score / $total) * $remaining) + $base);
            return $result;
        else:
            $formula = $settings->formula;
            //echo $formula.'<br />';
            $formula = str_replace('RS', $score, $formula);
            $formula = str_replace('TS', $total, $formula);
            $formula = str_replace('divide', '/', $formula);
            $formula = str_replace('times', '*', $formula);
            $formula = str_replace('plus', '+', $formula);
           //echo $formula.'<br />';
            //$answer = '5*6';
            return $this->calculate_string($formula);
            
        endif;
    }
    
    function calculate_string( $mathString )    
    {
        $mathString = trim($mathString);     // trim white spaces
        $mathString = preg_replace('[^0-9\+-\*\/\(\) ]', '', $mathString); // remove any non-numbers chars; exception for math operators

        $compute = create_function("", "return (" . $mathString . ");" );
        return 0 + $compute();
    }
    
    public function getDO_settings($subject_id = NULL, $school_year=NULL)
    {
        $components = $this->gradingsystem_model->getDO_settings($subject_id, $school_year);
        return $components;
    }
    
    public function saveGS()
    {
        $array = array(
            $this->input->post('column') => $this->input->post('gs_used')
        );
        
        $this->gradingsystem_model->saveGS($array, $this->session->userdata('school_year'));
    }
    
    public function getCustomizedList($gid = NULL)
    {
        $values = $this->gradingsystem_model->getCustomizedList($gid);
        return $values;
    }
    
    public function getListOfValues($gid = NULL, $id = NULL)
    {
        $values = $this->gradingsystem_model->getListOfValues($gid, $id);
        return $values;
    }
    
    public function getCoreValuesInSelect()
    {
        $values = $this->gradingsystem_model->getCoreValues();
        echo '<option>Select Option</option>';
        foreach($values as $v):
        ?>
                
                <option value="<?php echo $v->core_id ?>"><?php echo $v->core_values ?></option>    
        <?php        
        endforeach;
    }
    
    public function getCoreValues()
    {
        $values = $this->gradingsystem_model->getCoreValues();
        return $values;
    }

    public function getBehaviorRate($bh_group=NULL)
    {
        $behavior = $this->gradingsystem_model->getBehaviorRate($bh_group);
        return $behavior;
    }

    public function getCustomizedListInSelect()
    {
        $list = $this->getListOfValues();
        echo '<option>Select Option</option>';
        foreach($list->result() as $l):
        ?>
                
                <option value="<?php echo $l->bh_id ?>"><?php echo $l->bh_name ?></option>    
        <?php        
        endforeach;
    }
    
    public function addBHSettings()
    {
        $table = $this->input->post('table');
        $cat_id = $this->input->post('cat_id');
        $value = $this->input->post('value');
        
        switch($table):
            case 'gs_behavior_core_values':
                $details = array(
                    'core_values' => $value
                );
            break;    
            case 'gs_behavior_rate':
                $details = array(
                    'bh_name' => $value,
                    'bh_group' => $cat_id
                );
                
            break;    
            case 'gs_behavior_rate_customized':
                $details = array(
                    'bhs_indicators' => $value,
                    'bhs_group_id' => $cat_id
                );
            break;    
        endswitch;
        
        $result = $this->gradingsystem_model->addBHSettings($details, $table);
        if($result):
            echo json_encode(array('status'=>TRUE));
        else:
            echo json_encode(array('status'=>FALSE));
        endif;
    }
    
    public function behSettings()
    {
        $school_settings = Modules::run('main/getSet');
        $gs_settings = $this->gradingsystem_model->getSettings($this->session->userdata('school_year'));
        $data['coreValues'] = $this->gradingsystem_model->getCoreValues();
        $data['listOfValues'] = $this->gradingsystem_model->getListOfValues()->result();
        if($gs_settings->customized_beh_settings):
            $this->load->view(strtolower($school_settings->short_name).'_behavior_settings', $data);
        else:
            $this->load->view('behavior_settings', $data);
        endif;
    }
    
    public function gs_settings()
    {
        
        $settings = Modules::run('main/getSet');
        $data['short_name'] = strtolower($settings->short_name);
        $data['category'] = $this->gradingsystem_model->getAssessCategoryWithoutPreTest();
        $data['gs_settings'] = $this->gradingsystem_model->getSettings($this->session->userdata('school_year'));
       
        if($data['gs_settings']->customized):
            $data['subjects'] = Modules::run('academic/getSubjects');
            $data['components'] = $this->gradingsystem_model->getComponents();
            $this->load->view(strtolower($settings->short_name).'_gs_settings', $data);
        else:
            $data['subjects'] = Modules::run('academic/getSubjects');
            $data['components'] = $this->gradingsystem_model->getComponents();
            $this->load->view('gs_settings', $data);
        endif;
        
    }

    public function settings()
    {
        $data['category'] = $this->gradingsystem_model->getAssessCategoryWithoutPreTest();
        $data['gs_settings'] = $this->gradingsystem_model->getSettings($this->session->userdata('school_year'));
        $data['subjects'] = $this->gradingsystem_model->subjectWComponents();
        $data['modules'] = "gradingsystem";
        if($data['gs_settings']->customized):
            $data['main_content'] = 'custom_gs_settings';
        else:
            $data['main_content'] = 'gs_settings';
        endif;
        
        echo Modules::run('templates/main_content', $data);
    }
    
    function editSettings()
    {
        $value = $this->input->post('value');
        $column = $this->input->post('column');
        
        if($this->gradingsystem_model->editSettings($column, $value)):
            echo 'Successfully Updated';
        else:
            echo 'Sorry Something went Wrong';
        endif;
    }
    
    public function saveTransmutation()
    {
        $byBase = $this->input->post('byBase');
        $base = $this->input->post('base');
        $formula = $this->input->post('formula');
        if($byBase==1 && $base=="")
        {
            $base = 65;
        }
        
        $details = array(
            'by_base'   => $byBase,
            'base'      => $base,
            'formula'   => $formula
        );
        
        $isSave = $this->gradingsystem_model->saveTransmutation($details);
        if($isSave):
            echo json_encode(
                    array('msg' => 'Raw Score Transmutation Successfully Set', 'status' => TRUE)
                    );
        else:
            echo json_encode(
                    array('msg' => 'Internal Error Occured, Please Contact System Admin', 'status' => FALSE)
                    );
        endif;
    }
    
        
    public function getTransmutation($total, $score) {
        
        //$result = (((($score / $total) + 1) * .5) * 100);
        //$result = ((($score / $total) * 35) + 65);
        $result = $this->getSettings($total, $score);
        //echo $result;
        return round($result, 3);
    }
    
    public function getTop()
    {
        $co_curricular = Modules::load('gradingsystem/co_curricular');
        $c_function = $co_curricular->$function($data);
    }
       
    public function co_curricular($function, $data=NULL)
    {
        $co_curricular = Modules::load('gradingsystem/co_curricular');
        $c_function = $co_curricular->$function($data);
        return $c_function;
    }
    
    public function subject($subject_id, $section_id)
    {
        $user_id = $this->session->userdata('user_id');
        $data['getQuarterSettings'] = $this->gradingsystem_model->getQuarterSettings();
        $data['getWeightSettings'] = $this->gradingsystem_model->getWeightSettings();
        $data['getSubject'] = Modules::run('academic/mySubject', $user_id);
        if(Modules::run('main/isMobile'))
        {
            if (!$this->session->userdata('is_logged_in')) {
                echo Modules::run('mobile/index');
            } else {
                if ($this->session->userdata('position_id') == 4) {
                    $data['students'] = Modules::run('registrar/getStudentListForParent');
                    $data['modules'] = "gradingsystem";
                    $data['main_content'] = 'mobile/parentsClassRecord';
                } else {
                    $data['modules'] = "gradingsystem";
                    $data['main_content'] = 'mobile/subject';
                }
                echo Modules::run('mobile/main_content', $data);
            }
        } else {
            if ($this->session->userdata('position_id') == 4) {
                $data['students'] = Modules::run('registrar/getStudentListForParent');
                $data['main_content'] = 'parentsClassRecord';
            } else {
                $data['main_content'] = 'default';
            }
            $data['modules'] = 'gradingsystem';
            echo Modules::run('templates/main_content', $data);
        }
    }


    public function saveImportAssessment($details)
    {
        $id = $this->gradingsystem_model->saveAssessment($details);
        return $id['id'];
    }

    public function saveAssessment() {
        $details = array(
            'assess_title' => $this->input->post('title'),
            'assess_date' => $this->input->post('date'),
            'section_id' => $this->input->post('section_id'),
            'subject_id' => $this->input->post('subject_id'),
            'faculty_id' => $this->input->post('faculty_id'),
            'no_items' => $this->input->post('no_items'),
            'quiz_cat' => $this->input->post('quiz_cat'),
            'term' => $this->input->post('term'),
            'school_year' => $this->session->userdata('school_year'),
        );

        $saveAssessment = Modules::run('gradingsystem/gradingsystem_temp_model/saveAssessment', $details);
        
        Modules::run('daily_lesson_log/updateDll', $this->input->post('dll_id'), $saveAssessment['id']);
        
        if ($saveAssessment['status']) {

            Modules::run('web_sync/updateSyncController', 'gs_assessment', 'assess_id', $saveAssessment['id'], 'create', 4);

            echo '<div id="alert-success" class="alert-info"  style="position:absolute; top:50%; left:45%;" id="notify" data-dismiss="alert-message">
                <h4>Assessment Saved Successfully!</h4>

            </div>';
        }
    }

    public function index() {
        $user_id = $this->session->userdata('username');
        $data['getQuarterSettings'] = $this->gradingsystem_model->getQuarterSettings();
        $data['getWeightSettings'] = $this->gradingsystem_model->getWeightSettings();
        $data['getSubject'] = Modules::run('academic/mySubject', $user_id, $this->session->userdata('school_year'));
        $data['ro_year'] = Modules::run('registrar/getROYear');
        if(Modules::run('main/isMobile'))
        {
            if (!$this->session->userdata('is_logged_in')) {
                echo Modules::run('mobile/index');
            } else {
                if ($this->session->userdata('position_id') == 4) {
                    $data['students'] = Modules::run('registrar/getStudentListForParent');
                    $data['modules'] = "gradingsystem";
                    $data['main_content'] = 'mobile/parentsClassRecord';
                } else {
                    $data['getAllDLL'] = Modules::run('daily_lesson_log/getAllDLL', $this->session->userdata('username'));
                    $data['modules'] = "gradingsystem";
                    $data['main_content'] = 'mobile/default';
                }
                echo Modules::run('mobile/main_content', $data);
            }
        } else {
            if ($this->session->userdata('position_id') == 4) {
                $data['students'] = Modules::run('registrar/getStudentListForParent');
                $data['main_content'] = 'parentsClassRecord';
            } else {
                $data['getAllDLL'] = Modules::run('daily_lesson_log/getAllDLL', $this->session->userdata('username'));
                $data['main_content'] = 'default';
            }
            $data['modules'] = 'gradingsystem';
            echo Modules::run('templates/main_content', $data);
        }
    }

    public function getAssessment() {
        $section_id = $this->input->post('section_id');
        $subject_id = $this->input->post('subject_id');
        $term = $this->input->post('term');
        $school_year = $this->input->post('school_year');
        $assessment = $this->gradingsystem_model->getAssessment($section_id, $subject_id, '', $term, $school_year);
        //print_r($assessment->result());
        echo '<option>Select Assessment Title / Date </option>';
        foreach ($assessment->result() as $assess) {
            ?>                        
            <option value="<?php echo $assess->assess_id ?>"><?php echo $assess->assess_title . ' ( ' . $assess->assess_date . ' )' ?></option>

        <?php
        }
    }

    public function getAssessmentDetails($qcode, $school_year = NULL) {
        
        $gs_settings = $this->gradingsystem_model->getSettings($school_year);
        $assess = $this->gradingsystem_model->getAssessment('', '', $qcode, '');
        $data['getAssessment'] = $assess->row();
        $data['school_year'] = $school_year;
        $data['gs_settings'] = $gs_settings;
        if(Modules::run('main/isMobile'))
        {
            switch($gs_settings->gs_used):
                case 1:
                     $this->load->view('forms/mobile/getAssessmentTable', $data);
                    break;
                case 2:
                     $this->load->view('forms/mobile/new_gs_getAssessmentTable', $data);
                     //$this->load->view('forms/mobile/getAssessmentTable', $data);
                    
                    break;
                default :
                    $this->load->view('forms/mobile/getAssessmentTable', $data);
                    break;
            endswitch;
        } else {
            switch($gs_settings->gs_used):
                case 1:
                     $this->load->view('forms/getAssessmentTable', $data);
                    break;
                case 2:
                     $this->load->view('forms/new_gs_GetAssessmentTable', $data);
                    
                    break;
                default :
                    $this->load->view('classRecordTable', $data);
                    break;
            endswitch;
           
        }

        //print_r($assessment->result());
    }

    public function getIndividualAssessment() {
        $student_id = $this->input->post('st_id');
        $subject_id = $this->input->post('subject_id');
        $qcode = $this->input->post('qcode');
        $term = $this->input->post('term');

        $assessment = $this->gradingsystem_model->getIndividualAssessment($student_id, $subject_id, $qcode, $term);
        $data['profile'] = Modules::run('registrar/getSingleStudent', $student_id);
        $data['individualAssessment'] = $assessment;
        $this->load->view('individualAssessment', $data);
    }
    
    public function getIndividualAssessmentForPrint($student_id, $subject_id, $qcode, $term)
    {
        $assessment = $this->gradingsystem_model->getIndividualAssessmentForPrint($student_id, $subject_id, $qcode, $term);
        //print_r($assessment);
        return $assessment;
    }

    public function getAssessmentBySectionForPrint($section_id, $subject_id, $qcode, $term)
    {
        $assessment = $this->gradingsystem_model->getAssessmentBySectionForPrint($section_id, $subject_id, $qcode, $term);
        return $assessment;
    }
    
    public function getAssessmentPerTeacher($faculty_id, $section_id, $subject_id, $qcode, $term, $school_year=NULL)
    {
        $assessment = $this->gradingsystem_model->getAssessmentPerTeacher($faculty_id, $section_id, $subject_id, $qcode, $term, $school_year);
        return $assessment;
    }


    public function getRawScore($student_id = null, $qcode = null) {
        $score = $this->gradingsystem_model->getRawScore($student_id, $qcode);
        return $score;
    }
        
    public function recordImportScore($id_number, $score, $total, $quizCode)
    {
        $gs_settings = $this->gradingsystem_model->getSettings($this->session->userdata('school_year'));
        if($gs_settings->gs_used==1):
            $equivalent = $this->getTransmutation($total, $score);

            $saveResult = $this->gradingsystem_model->recordScore($id_number, $score, $quizCode, $equivalent);
        else:
            $this->gradingsystem_model->recordScore($id_number, $score, $quizCode, '');
        endif;
    }


    public function recordScore() {
        $total = $this->input->post('total');
        $student = $this->input->post('recordStudent');
        $score = $this->input->post('rawScore');
        $quizCode = $this->input->post('quizCode');
        $subject = $this->input->post('subject_id');
        $gs_settings = $this->gradingsystem_model->getSettings($this->session->userdata('school_year'));
        if($gs_settings->gs_used==1):
            if($subject=='BGB'):
                $equivalent = $score;
            else:
                $equivalent = $this->getTransmutation($total, $score);
            endif;
            $saveResult = $this->gradingsystem_model->recordScore($student, $score, $quizCode, $equivalent);
        else:
            $saveResult = $this->gradingsystem_model->recordScore($student, $score, $quizCode, '');
        endif;
        if ($saveResult) {
            $msg = '<div id="alert-info" style="position:absolute; top:50%; left:45%; z-index:2000;" class="alert alert-success" data-dismiss="alert-message">
                <h4>Score Recorded Successfully!</h4>

            </div>';
        } else {
            $msg = '<div id="alert-info"  style="position:absolute; top:50%; left:45%; z-index:2000;" class="alert alert-success" data-dismiss="alert-message">
                <h4>Score Updated Successfully!</h4>

            </div>';
        }


        echo json_encode(array('msg' => $msg, 'equivalent' => $equivalent));
    }

    public function getRowSort() {
        $sortBy = $this->input->post('sortBy');
        $qcode = $this->input->post('qcode');
        $control = $this->input->post('sortControl');
        $result = $this->gradingsystem_model->getRawScoreSort($sortBy, $qcode, $control);
        ?>
        <tr> 
            <td>Students</td> 
            <td style="text-align:center;">Raw Score &nbsp; 
                <a style="font-size:12px;" href="<?php echo base_url() . 'gradingsystem/viewClassRecord/' ?>">
                    [ View Class Record ]
                </a>

            </td> 
            <td style="cursor:pointer" onclick ="sortByPercentage('equivalent')">Percentage</td>    
        </tr> 
        <?php
        foreach ($result->result() as $st) {
            ?>
            <tr>        
                <td style="font-size:10px;" id=""><?php echo $st->user_id . ' ' . $st->firstname . ' ' . $st->lastname ?></td> 

                <td style="text-align: center; font-size:14px;" id="<?php echo $st->user_id ?>" >

            <?php if ($result->num_rows() > 0) {
                echo $st->raw_score;
            } ?>
                </td>
                <td <?php if ($st->equivalent < 75) {
                echo "style='color:red;'";
            } ?> id="<?php echo $st->user_id ?>_result" >
            <?php if ($result->num_rows() > 0) {
                echo $st->equivalent;
            }
            ?>
                </td>
            </tr>
            <?php
        }
    }

     public function getClassRecord($subject_id = null, $section_id = null, $department = null, $term = NULL, $school_year = NULL) 
    {
        $this->load->helper('file');
        $settings = Modules::run('main/getSet');
        $gs_settings = $this->gradingsystem_model->getSettings($school_year);
        $data['gs_settings'] = $gs_settings;
        $data['classRecord'] = $this->gradingsystem_model->getClassRecord($subject_id, $section_id, $term);
        $data['subject_id'] = $subject_id;
        $data['section_id'] = $section_id;
        $data['term'] = $term;
        $data['school_year'] = $school_year;
        $grade_level = Modules::run('registrar/getGradeLevelBySectionId', $section_id);
        $cat = Modules::run('gradingsystem/getAssessCatBySubject', $subject_id, $school_year);
            if($cat->num_rows()>0):
                $sub_id = $subject_id;
            else:
                $sub_id = '0';
            endif;
            
        //echo $sub_id;
        if($gs_settings->used_specialization && $subject_id == 10):
                switch ($grade_level->grade_level_id):
                    case 10:
                    case 11:
                        $getSpecs = Modules::run('academic/getSpecificSubjectAssignment',$this->session->userdata('employee_id'), $section_id, $subject_id);
                        $data['students'] = Modules::run('academic/getStudentWspecializedSubject', $getSpecs->specs_id, $grade_level->grade_level_id);
                    break;   
                    default:
                        $data['students'] = Modules::run('registrar/getAllStudentsForExternal', '', $section_id);
                    break;
                endswitch;
            else:
                
                $data['students'] = Modules::run('registrar/getAllStudentsForExternal', '', $section_id);
            endif;
        if(Modules::run('main/isMobile'))
        {
            $this->load->view('mobile/classRecordTable', $data);
        }else{
            switch($gs_settings->gs_used):
                case 1:
                    $this->load->view('classRecordTable', $data);
                    break;
                case 2:
                    if(file_exists(APPPATH.'modules/gradingsystem/views/'. strtolower($settings->short_name).'_classRecordTable.php')):
                        if($gs_settings->customized_calculation):
                            $data['category'] = Modules::run('gradingsystem/new_gs/getCustomComponentList', $subject_id);
                        else:
                            $data['category'] = $this->gradingsystem_model->getAssessCategory($sub_id, $school_year);
                        endif;
                        $this->load->view(strtolower($settings->short_name).'_classRecordTable', $data); 
                    else:
                        $data['category'] = $this->gradingsystem_model->getAssessCategory($sub_id, $school_year);
                        $this->load->view('new_gs_classRecordTable', $data);
                    endif;
                break;
                default :
                    $this->load->view('classRecordTable', $data);
                    break;
            endswitch;
        }
    }
    
    public function classRecordDetails($section_id, $subject_id, $term, $year=NULL)
    {
        $settings = Modules::run('main/getSet');
        $gs_settings = $this->gradingsystem_model->getSettings($year);
        $data['gs_used'] = $gs_settings->gs_used;
        $data['section_id'] = $section_id;
        $data['subject_id'] = $subject_id;
        $data['term'] = $term;
        $data['school_year'] = $year;
        switch($gs_settings->gs_used):
            case 1:
                $this->load->view('classRecordDetails', $data);
            break;
            case 2:
                if($gs_settings->customized):
                    $this->load->view(strtolower($settings->short_name).'_gs_classRecordDetails', $data);
                else:
                    $this->load->view('new_gs_classRecordDetails', $data);
                endif;
            break;
            default :
                $this->load->view('classRecordDetails', $data);
            break;
        endswitch;
    } 
        
    public function getIndividualClassRecord($st_id, $details, $section_id, $term, $year)
    {
        $data['st_id'] = $st_id;
        $data['details'] = $details;
        $data['term'] = $term;
        $data['year'] = $year;
        $data['section_id'] = $section_id;
        echo Modules::run('widgets/getWidget', 'gradingsystem_widget', 'classRecordWidget', $data);
    }
    
    public function getIndividualProgressChart($student_id, $term,$year=NULL,$subject_id=NULL  )
    {
        $data['student'] = Modules::run('registrar/getSingleStudent', base64_decode($student_id), $year);
        $data['subject_id'] = $subject_id;
        $data['term'] = $term;
        $data['school_year'] = $year;

        echo json_encode(array(
            'main' => Modules::run('widgets/getWidget', 'gradingsystem_widget', 'individualProgressReport', $data),
            'gpa' => Modules::run('widgets/getWidget', 'gradingsystem_widget', 'currentGPA', $data)
            )
        );
    }
    
    public function getClassProgressReport($section_id, $subject_id, $term, $year)
    {
        $gs_settings = $this->gradingsystem_model->getSettings($year);
        $data['section_id'] = $section_id;
        $data['subject_id'] = $subject_id;
        $data['term'] = $term;
        $data['school_year'] = $year;
        switch($gs_settings->gs_used):
            case 1:
                $this->load->view('getClassProgressReport', $data);
                break;
            case 2:
                $this->load->view('new_gs_getClassProgressReport', $data);
                break;
            default :
                $this->load->view('getClassProgressReport', $data);
            break;
        endswitch;
    }
    
    public function getCPR_graph($qcode, $section_id, $subject_id, $term=NULL)
    {
        $gs_settings = $this->gradingsystem_model->getSettings($this->session->userdata('school_year'));
        $data['details'] = $this->gradingsystem_model->getRawScore('', $qcode);
        $data['assessment'] = $this->gradingsystem_model->getAssessment($section_id, $subject_id, $qcode, $term);
        $data['subject_id'] = $subject_id;
        $data['term'] = $term;
        switch($gs_settings->gs_used):
            case 1:
                $this->load->view('cpr_graph', $data);
                break;
            case 2:
                $this->load->view('new_gs_cpr_graph', $data);
                break;
            default :
                $this->load->view('cpr_graph', $data);
            break;
        endswitch;
    }

    public function getTotalScoreByStudent($student_id = null, $category_id = null, $term = NULL, $subject_id = NULL, $faculty_id = NULL) {
        $gs_settings = $this->gradingsystem_model->getSettings($this->session->userdata('school_year'));
        if($gs_settings->customized):
            $score = Modules::run('gradingsystem/new_gs/getTotalScoreByStudent',$student_id, $category_id, $term, $subject_id);
        else:
            $score = $this->gradingsystem_model->getTotalScoreByStudent($student_id, $category_id, $term, $subject_id, $faculty_id);
        endif;
        
        return $score;
    }

    public function getEachScoreByStudent($student_id = null, $category_id = null, $term = NULL, $subject_id = NULL, $option = NULL, $section_id=NULL, $faculty_id = NULL) {
        
        $gs_settings = $this->gradingsystem_model->getSettings($this->session->userdata('school_year'));
        if($gs_settings->customized):
            $score = Modules::run('gradingsystem/new_gs/getEachScoreByStudent',$student_id, $category_id, $term, $subject_id, $option, $section_id);
        else:
            $score = $this->gradingsystem_model->getEachScoreByStudent($student_id, $category_id, $term, $subject_id, $option, $section_id, $faculty_id);
        endif;

        return $score;
    }

    public function getBGBLetterGrade($numberGrade) {
        $trans = $this->gradingsystem_model->getBGBLetterGrade($numberGrade);
        return $trans;
    }
    
    public function getLetterGrade($numberGrade) {
        $trans = $this->gradingsystem_model->getLetterGrade($numberGrade);
        return $trans;
    }
    
    public function getBGBEquivalent($numberGrade)
    {
        $plg = $this->gradingsystem_model->getBGBEquivalent($numberGrade);
        foreach($plg->result() as $plg){
            if( $numberGrade >= $plg->from_grade && $numberGrade <= $plg->to_grade){
                return $plg->grade;
            }
        }
    }
    
    function getNumItems($assess_id)
    {
        $items = $this->gradingsystem_model->getNumItems($assess_id);
        return $items->no_items;
    }
    
    function getDescriptor($assess_id, $raw_score)
    {
        $total = $this->getNumItems($assess_id);
        $number_grade = ($raw_score/$total)*100;
        if($number_grade>=90):
            $letter = 'O';
        elseif($number_grade<90 && $number_grade>=85):
            $letter = 'VS';
        elseif($number_grade<85 && $number_grade>=80):
            $letter = 'S';
        elseif($number_grade<80 && $number_grade>=75):
            $letter = 'FS'; 
        else:
            $letter = 'F';
        endif;
        
        return $letter;
    }
    
    public function getEquivalent($numberGrade)
    {
        $plg = $this->getLetterGrade($numberGrade);
        foreach($plg->result() as $plg){
            if( $numberGrade >= $plg->from_grade && $numberGrade <= $plg->to_grade){
                return $plg->letter_grade;
            }
        }
    }

    public function getAssessCategoryWithoutPreTest($department) {
        $cat = $this->gradingsystem_model->getAssessCategoryWithoutPreTest($department);
        return $cat;
    }
    
    public function getAssessCategory($subject_id, $year) {
        $cat = $this->gradingsystem_model->getAssessCategory($subject_id, $year);
        return $cat;
    }

    public function getAssessCatDropdown($subject_id=NULL, $year = NULL) {
        $gs_settings = $this->gradingsystem_model->getSettings($this->session->userdata('school_year'));
        if($gs_settings->customized):
            $cat = $this->gradingsystem_model->getCustomAssessCategory($subject_id, $year);
            foreach ($cat as $category) {
                ?>                        
                <option value="<?php echo $category->code ?>"><?php echo $category->sub_component ?></option>

            <?php
            } 
        else:   
            $cat = $this->gradingsystem_model->getAssessCategory($subject_id, $year);
            foreach ($cat as $category) {
                ?>                        
                <option value="<?php echo $category->code ?>"><?php echo $category->component ?></option>

            <?php
            } 
        endif;
        
    }

    function getStudentRecords($student_id) {
        $data['studentInfo'] = Modules::run('registrar/getSingleStudent', $student_id);

        if ($this->agent->is_mobile()):
            $this->load->view('mobile/parentsClassRecordTable', $data);
        else:
            $this->load->view('parentsClassRecordTable', $data);
        endif;
    }

    function recordPartialAssessment($st_id, $section_id, $subject_id, $grading, $school_year, $partialGrade) {
        switch ($grading) {
            case 1:
                $term = 'first';
                break;
            case 2:
                $term = 'second';
                break;
            case 3:
                $term = 'third';
                break;
            case 4:
                $term = 'fourth';
                break;
        }



        $partialAssessmentExist = $this->gradingsystem_model->checkPartialAssessment($st_id, $section_id, $subject_id, $school_year);

        if ($partialAssessmentExist):
            $data = array($term => $partialGrade);

            $this->gradingsystem_model->updatePartialAssessment($st_id, $section_id, $subject_id, $school_year, $data);
        else:
            $assessment = array(
                'st_id' => $st_id,
                'section_id' => $section_id,
                'subject_id' => $subject_id,
                 $term => $partialGrade,
                'school_year' => $school_year,
            );
            $this->gradingsystem_model->savePartialAssessment($assessment);
        endif;
    }

    function getPartialAssessment($st_id, $section_id, $subject_id, $school_year) {
        $assessment = $this->gradingsystem_model->getPartialAssessment($st_id, $section_id, $subject_id, $school_year);
        return $assessment;
    }

    function getPreTestResult($user_id = null, $term, $section_id, $subject_id) {
        $result = $this->gradingsystem_model->getPreTestResult($user_id, $term, $section_id, $subject_id);
        //print_r($result);
        return $result;
    }

    function getHighLowScore($orderBy, $term, $section_id, $subject_id) {
        $orderBy = $this->gradingsystem_model->getHighLowScore($orderBy, $term, $section_id, $subject_id);
        return $orderBy;
    }
    
    function deleteAssessment($qcode = NULL) {
        $this->gradingsystem_model->deleteAssessment($qcode);
        return;
    }
    
    function editAssessment($qcode=NULL, $cat=NULL, $numOfItems=NULL, $term=NULL)
    {
        $data = array(
           'no_items' => $numOfItems,
           'quiz_cat' => $cat,
           'term'     => $term
        );
        
        $this->gradingsystem_model->editAssessment($qcode, $data);
        return;
    }
    
    function validateGrade($st_id, $subject_id, $term, $rate, $section_id=NULL, $grade_id=NULL, $manual=NULL)
    {
        if($manual==NULL):
            $manual = 0;
        endif;
        
        switch($term) {
            case 1:
                $grading = 'first';
                break;
            case 2:
                $grading = 'second';
                break;
            case 3:
                $grading = 'third';
                break;
            case 4:
                $grading = 'fourth';
                break;
        } 
        $record = array('st_id'=> $st_id, 'section_id' => $section_id, 'subject_id'=>$subject_id,  $grading => $rate, 'school_year'=>$this->session->userdata('school_year'), 'is_validated'=>$term);
        if($this->gradingsystem_model->updatePartialAssessment($st_id, $section_id, $subject_id, $this->session->userdata('school_year'),$record)):
            $grade = array(
                'st_id' => $st_id,
                'subject_id' => $subject_id,
                'final_rating' => $rate,
                'grading' => $term,
                'school_year' => $this->session->userdata('school_year'),
                'is_final' => 1,
                'is_manual' => $manual
            );
            $this->gradingsystem_model->saveFinalGrade($grade, $st_id, $subject_id, $term, $this->session->userdata('school_year'));
        endif;
        
        Modules::run('notification_system/department_notification', "Admin", $this->session->userdata('name').' has Finalized the grade of this student ('.$st_id.')', base_url().'registrar/viewDetails/'.base64_encode($st_id));
    }

    function validateGrades($st_id, $subject_id, $term, $rate, $section_id=NULL, $grade_id=NULL, $manual=NULL) {
        if($manual==NULL):
            $manual = 0;
        endif;
        
            if(!$this->isGradeValidated($st_id, $subject_id, $term,$this->session->userdata('school_year'))):
		switch($term) {
		            case 1:
		                $grading = 'first';
		                break;
		            case 2:
		                $grading = 'second';
		                break;
		            case 3:
		                $grading = 'third';
		                break;
		            case 4:
		                $grading = 'fourth';
		                break;
		        }    
                $record = array('st_id'=> $st_id, 'section_id' => $section_id, 'subject_id'=>$subject_id,  $grading => $rate,'is_validated'=>$term);
                if($this->gradingsystem_model->updatePartialAssessment($st_id, $section_id, $subject_id, $this->session->userdata('school_year'),$record)):
                    $grade = array(
                        'st_id' => $st_id,
                        'subject_id' => $subject_id,
                        'final_rating' => $rate,
                        'grading' => $term,
                        'school_year' => $this->session->userdata('school_year'),
                        'is_final' => 1,
                        'is_manual' => $manual
                    );
                    $this->gradingsystem_model->saveFinalGrade($grade, $st_id, $subject_id, $term, $this->session->userdata('school_year'));
                endif;
            else:
		switch ($term) {
		            case 1:
		                $grading = 'first';
		                break;
		            case 2:
		                $grading = 'second';
		                break;
		            case 3:
		                $grading = 'third';
		                break;
		            case 4:
		                $grading = 'fourth';
		                break;
		        }        
                $this->gradingsystem_model->deleteFinalGrade($st_id, $subject_id, $term, $this->session->userdata('school_year'));
                $record = array('st_id'=> $st_id, 'section_id' => $section_id, 'subject_id'=>$subject_id,  $grading => $rate,'is_validated'=>$term);
                $this->gradingsystem_model->updatePartialAssessment($st_id, $section_id, $subject_id, $this->session->userdata('school_year'), $record);
                
                $data = array(
                    'is_validated' => $term
                    );

                $isValidated = $this->gradingsystem_model->validateGrade($data, $st_id, $subject_id, $this->session->userdata('school_year'));
                if($isValidated):
                    $grade = array(
                        'st_id' => $st_id,
                        'subject_id' => $subject_id,
                        'final_rating' => $rate,
                        'grading' => $term,
                        'school_year' => $this->session->userdata('school_year'),
                        'is_final' => 1,
                        'is_manual' => $manual
                    );
                    $this->gradingsystem_model->saveFinalGrade($grade, $st_id, $subject_id, $term, $this->session->userdata('school_year'));
                endif;
            endif;
            
            
        
        
    }
    
    function updateFinalGrade($st_id, $subject_id, $rate, $term, $school_year)
    {
        $grade = array(
            'st_id' => $st_id,
            'subject_id' => $subject_id,
            'final_rating' => $rate,
            'grading' => $term,
            'school_year' => $school_year,
            'is_final'  => 1
        );
        $this->gradingsystem_model->saveFinalGrade($grade, $st_id, $subject_id, $term, $school_year);
    }
    
    function inValidateGrade($st_id, $subject_id, $term, $rate, $section_id=NULL, $grade_id=NULL) 
    {
        $data = array(
            'is_validated' => $term-1
            );

        $isValidated = $this->gradingsystem_model->validateGrade($data, $st_id, $subject_id, $this->session->userdata('school_year'));
        if($isValidated):
            $this->gradingsystem_model->deleteFinalGrade($st_id, $subject_id, $term, $this->session->userdata('school_year'));
        endif;
        Modules::run('notification_system/department_notification', "Admin", $this->session->userdata('name').' has REVOKED the validity of the grade of this student ('.$st_id.')', base_url().'registrar/viewDetails/'.base64_encode($st_id));
    }

    
    function isGradeValidated($st_id, $subject_id, $term, $school_year)
    {
        $isValidated = $this->gradingsystem_model->isGradeValidated($st_id, $subject_id, $term, $school_year);
        return $isValidated;
    }
    
    function getAllFinalGrade( $term, $grade_id, $section_id = NULL, $subject_id = NULL)
    {
        $grades = $this->gradingsystem_model->getAllFinalGrade($grade_id, $section_id, $term, $subject_id);
        return $grades;
    }
    
    function getFinalGrade($st_id, $sub_id, $term, $school_year){
        $final = $this->gradingsystem_model->getFinalGrade($st_id, $sub_id, $term, $school_year);
        if($final->num_rows()==0):
            switch ($term) {
                case 1:
                    $grading = 'first';
                    break;
                case 2:
                    $grading = 'second';
                    break;
                case 3:
                    $grading = 'third';
                    break;
                case 4:
                    $grading = 'fourth';
                    break;
            }    
            $isValidated = $this->gradingsystem_model->isFinalAssessmentValidated($st_id, $sub_id,$school_year);
            if($term==$isValidated->is_validated):
                $rate = $isValidated->$grading;
                $plg = Modules::run('gradingsystem/new_gs/getTransmutation', round($rate, 2));
                $grade = array(
                        'st_id' => $st_id,
                        'subject_id' => $sub_id,
                        'final_rating' => $plg,
                        'grading' => $term,
                        'school_year' => $this->session->userdata('school_year'),
                        'is_final' => 1,
                        'is_manual' => 0
                    );
                $this->gradingsystem_model->saveFinalGrade($grade, $st_id, $sub_id, $term, $this->session->userdata('school_year'));
            endif;
            $final = $this->gradingsystem_model->getFinalGrade($st_id, $sub_id, $term, $school_year);
        endif;
        return $final;
    }
    
    function getGradeForCard($st_id, $sub_id, $school_year)
    {
        $grades = $this->gradingsystem_model->getGradeForCard($st_id, $sub_id, $school_year);
        foreach($grades->result() as $g):
            switch($g->grading):
                case 1:
                    $first = $g->final_rating;
                break;    
                case 2:
                    $second = $g->final_rating;

                break;    
                case 3:
                    $third = $g->final_rating;
                break;    
                case 4:
                    $fourth = $g->final_rating;
                break;    
            endswitch;
        endforeach;
            $json_encode = array('first'=>$first, 'second'=>$second, 'third'=>$third, 'fourth'=> $fourth);
            echo json_encode($json_encode);
        
        
    }

    
    public function getFinalAverage($st_id, $school_year)
    {
        
        $FA = $this->gradingsystem_model->getFinalAverage($st_id, 0, $school_year);
        //echo $FA;
        return $FA;

    }


    function getBH($gs_used=NULL)
    {
        $bh = $this->gradingsystem_model->getBH($gs_used);
        return $bh;
    }
    
    function saveBH($st_id, $rating, $term, $school_year, $bh_id )
    {
        $behavior = array(
            'st_id' => $st_id,
            'rate'  => $rating,
            'bh_id'  => $bh_id,
            'grading'  => $term,
            'school_year'  => $school_year,
        );
        
        $ifBhExist = $this->gradingsystem_model->ifBhExist($st_id,$term, $school_year, $bh_id );
        if($ifBhExist):
            $this->gradingsystem_model->updateBH($behavior,$st_id,$term, $school_year, $bh_id );
        else: 
            $this->gradingsystem_model->insertBH($behavior);
        endif;
    }
    
    function getBHRating($st_id,$term, $school_year, $bh_id=NULL)
    {
        $bh = $this->gradingsystem_model->getBHRating($st_id,$term, $school_year, $bh_id);
        return $bh;
//print_r($bh);
    }
    
    function saveRemarks($st_id, $remarks, $grading, $school_year)
    {
        $remarks = array(
            'st_id'         => $st_id,
            'remarks'       => urldecode($remarks),
            'term'          => $grading,
            'school_year'   => $school_year
        );
        
        $ifRemarkExist = $this->gradingsystem_model->ifRemarkExist($st_id,$grading, $school_year);
        if($ifRemarkExist):
            $this->gradingsystem_model->updateRemarks($remarks, $st_id, $grading, $school_year);
        else:
            $this->gradingsystem_model->insertRemarks($remarks);
        endif;
    }
    
    function getCardRemarks($st_id,$term, $school_year)
    {
        $remarks = $this->gradingsystem_model->getCardRemarks($st_id,$term, $school_year);
        return $remarks;
    }
    
    function getAssessmentById($assess_id)
    {
        $assessCat = $this->gradingsystem_model->getAssessmentById($assess_id);
        return $assessCat;
    }
    
    function getFinalCardByLevel($st_id, $levelCode){
        $final = $this->gradingsystem_model->getFinalCardByLevel(base64_decode($st_id), $levelCode);
        if(!$final):
            return FALSE;
        else:
            return $final;
        endif;
    }
    
    function getSectionAndSubject($details = null) {
        $item = explode('-', $details);
        $settings = $this->gradingsystem_model->getSettings($this->session->userdata('school_year'));
        
        $subject_id = $item[0];
        $section_id = $item[1];
        if ($item[2] <= 10) {
            $grade_id = 0;
        } elseif ($item[2] > 10 && $item[2] <= 14) {
            $grade_id = 1;
        } else {
            $grade_id = 2;
        }
        
//        $cat = $this->gradingsystem_model->getAssessCatBySubject($subject_id);
//        if($settings->gs_used==2):
//            $department = 0;
//            //print_r($cat);
//            if($cat->num_rows()>0):
//                $sub_id = $subject_id;
//            else:
//                $sub_id = '0';
//            endif;
//        else:
//            if($cat->num_rows()>0):
//                $sub_id = $subject_id;
//            else:
//                $sub_id = '0';
//            endif; 
//             //$department = 1;
//        endif;
        //echo $settings->gs_used;
        if($settings->customized_calculation):
            $assessment = Modules::run('gradingsystem/getAssessCatDropdown', $subject_id, $settings->school_year);
        else:
            $assessment = Modules::run('gradingsystem/getAssessCatDropdown', $subject_id, $settings->school_year);
            
        endif;
        //print_r($assessment);
        echo json_encode(array('subject_id' => $subject_id, 'section_id' => $section_id, 'grade_id' => $grade_id, 'assessment' => $assessment));
    }
    

}