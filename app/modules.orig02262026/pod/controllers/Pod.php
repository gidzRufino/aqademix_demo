<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * 
 */

class pod extends MX_Controller {
    //put your code here
    function __construct() {
        parent::__construct();
        $this->load->model('pod_model');
    	// $this->load->library('Mobile_Detect');
        date_default_timezone_set("Asia/Manila");
        if(!$this->session->has_userdata('is_logged_in') || !$this->session->is_logged_in){
            header('Location: '.base_url());
            exit;
        } 
    }
    
    public function dashboard()
    {
        $start = $this->uri->segment(3);
        $end = $this->uri->segment(4);
        // $data['attendance'] = $this->pod_model->attendance_list($start, $end);
        // $data['all_time'] = $this->pod_model->all_time();
        $data['tardy_today'] = $this->pod_model->tardy_today();
        $data['modules'] = 'pod';
        $data['main_content'] = 'default';
        echo Modules::run('templates/main_content', $data);
    }

    public function edashboard()
    {
        $start = $this->uri->segment(3);
        $end = $this->uri->segment(4);
        // $data['attendance'] = $this->pod_model->attendance_list($start, $end);
        // $data['all_time'] = $this->pod_model->all_time();
        $data['tardy_today'] = $this->pod_model->etardy_today();
        $data['modules'] = 'pod';
        $data['main_content'] = 'edefault';
        echo Modules::run('templates/main_content', $data);
    }

    public function all_time()
    {
        $sel = $this->uri->segment(3);
        if ($sel) { 
            
        }
        $data['level'] = $this->pod_model->grade_level();
        $data['modules'] = 'pod';
        $data['main_content'] = 'alltime';
        echo Modules::run('templates/main_content', $data);
    }

    public function fetch_record()
    {
        $quarter = $this->pod_model->quarter();
        $sy = $this->session->userdata('school_year');
        $dnow = date('Y-m-d');
        $sel = $this->input->post('sel');
        $info1 = ''; $info2 = ''; $info3 = ''; $info4 = '';
        foreach ($quarter as $q) {
            if ($q->school_year==$sy) {
                // $quarter_now = $q->quarter;
                $dfrom = $q->from_date;
                $dto = $q->to_date;
                if ($sel=='all') {
                    $rec = $this->pod_model->all_time($dfrom, $dto);
                }elseif ($sel=='gs') {
                    $rec = $this->pod_model->all_time_gs($dfrom, $dto);
                }elseif ($sel=='hs') {
                    $rec = $this->pod_model->all_time_hs($dfrom, $dto);
                }else{
                    $rec = $this->pod_model->all_time_gid(base64_decode($sel), $dfrom, $dto);
                }
                foreach ($rec as $rec) {
                    $tcounts = $rec->total;
                    switch (true) {
                     case $tcounts < 3:
                        $bar = 'bg-success';
                        break;
                     case $tcounts < 5:
                        $bar = 'bg-primary';
                        break;
                     case $tcounts < 7:
                        $bar = 'bg-info';
                        break;
                     case $tcounts < 9:
                        $bar = 'bg-warning';
                        break;
                     case $tcounts >= 9:
                        $bar = 'bg-danger';
                        break;
                     default:
                        # code...
                        break;
                    }
            
                    switch ($q->quarter) {
                        case 'First Quarter':
                            $que = 1;
                            $link1 = "'".base64_encode($rec->l_st_id)."'";
                            $irow1 = '<tr class="'.$bar.'">
                                   <td class="text-center" onclick="open_account('.$link1.')">'.$rec->lastname.', '.$rec->firstname.'</td>
                                   <td class="text-center">'.$rec->level.'</td>
                                   <td class="text-center">'.$rec->section.'</td>
                                   <td class="text-center">'.$rec->total.'</td>
                                </tr>';
                            $info1 = $info1.''.$irow1;
                           break;
                        case 'Second Quarter':
                            $que = 2;
                            $link2 = "'".base64_encode($rec->l_st_id)."'";
                            $irow2 = '<tr class="'.$bar.'">
                                   <td class="text-center" onclick="open_account('.$link2.')">'.$rec->lastname.', '.$rec->firstname.'</td>
                                   <td class="text-center">'.$rec->level.'</td>
                                   <td class="text-center">'.$rec->section.'</td>
                                   <td class="text-center">'.$rec->total.'</td>
                                </tr>';
                            $info2 = $info2.''.$irow2;
                           break;
                        case 'Third Quarter':
                            $que = 3;
                            $link3 = "'".base64_encode($rec->l_st_id)."'";
                            $irow3= '<tr class="'.$bar.'">
                                   <td class="text-center" onclick="open_account('.$link3.')">'.$rec->lastname.', '.$rec->firstname.'</td>
                                   <td class="text-center">'.$rec->level.'</td>
                                   <td class="text-center">'.$rec->section.'</td>
                                   <td class="text-center">'.$rec->total.'</td>
                                </tr>';
                            $info3 = $info3.''.$irow3;
                           break;
                        case 'Fourth Quarter':
                            $que = 4;
                            $link4 = "'".base64_encode($rec->l_st_id)."'";
                            $irow4 = '<tr class="'.$bar.'">
                                   <td class="text-center" onclick="open_account('.$link4.')">'.$rec->lastname.', '.$rec->firstname.'</td>
                                   <td class="text-center">'.$rec->level.'</td>
                                   <td class="text-center">'.$rec->section.'</td>
                                   <td class="text-center">'.$rec->total.'</td>
                                </tr>';
                            $info4 = $info4.''.$irow4;
                           break;
                    }
                } // foreach record 
            }        
        }
                    echo json_encode(array(
                        'info1'      => $info1,
                        'info2'      => $info2,
                        'info3'      => $info3,
                        'info4'      => $info4,
                        'quarter'   => $que,
                        )
                    );
            
        
    }

    public function ck($section_id)
    {
        $result = Modules::run('registrar/getSection', $section_id);
        if ($result->time_in!='00:00:00') {
            print_r('hey! time in is: '.$result->time_in);
        }
        print_r('what?'.$result->time_in);
    }

    public function esearch($id=NULL)
    {
        $st_id = base64_decode($id);
        if ($id) {
            $profile = $this->pod_model->e_profile($st_id);
            $data['profile'] = $profile;
            $sec_id = $profile->section_id;
            // $data['adviser'] = $this->pod_model->adviser($sec_id);
            $data['tardies'] = $this->pod_model->account_tardy($st_id);
        }
        // $data['id'] = base64_decode($id);
        $data['modules'] = 'pod';
        $data['main_content'] = 'esearch';
        echo Modules::run('templates/main_content', $data);   
    }

    public function search($id=NULL)
    {
        $st_id = base64_decode($id);
        if ($id) {
            $profile = $this->pod_model->st_profile($st_id);
            $data['profile'] = $profile;
            $sec_id = $profile->section_id;
            $data['quarter'] = $this->pod_model->quarter();
            $data['adviser'] = $this->pod_model->adviser($sec_id);
            $data['tardies'] = $this->pod_model->account_tardy($st_id);
        }
        // $data['id'] = base64_decode($id);
        $data['modules'] = 'pod';
        $data['main_content'] = 'search';
        echo Modules::run('templates/main_content', $data);   
    }

    function convert() // add computation to excess minutes
    {
        $start = $this->uri->segment(3);
        $end = $this->uri->segment(4);
        $attendance = $this->pod_model->attendance_list($start, $end);
        $count = 0;
        foreach ($attendance as $st) {
            $rec_in_am = $st->st_time_in;                       // base attendance am class
            $rec_in_pm = $st->st_time_in_pm;                    // base attendance pm class
            if ($rec_in_am!='00:00:00') {                       // if am class
               if ($st->at_time_in>=806&&$st->lastname!="") {   // if am student is late
                  $m_in = substr($st->at_time_in, -2);
                  $h_in = substr($st->at_time_in, 0, -2);
                  $t_in = $h_in.':'.$m_in.':00';
                  if ($t_in!='13:00:00') {
                        $count++;
                      $amtardy = array(
                        'l_st_id'       => $st->att_st_id, 
                        'l_grade_id'    => $st->grade_id,
                        'l_date'        => $st->date,
                        'l_time_in'     => $rec_in_am,
                        'l_actual_time_in'    => $t_in,
                        'l_att_id'      => $st->att_id,
                        );
                      $tid = $this->pod_model->save_tardy($amtardy);
                      print_r('Tardy Detected: '.$st->att_st_id.' date: '.$st->date.' time: '.$t_in.' id:'.$tid.'<br/>');
                    }
                }
            }elseif ($rec_in_pm!='00:00:00') {                      // if pm class
               if ($st->at_time_in_pm>=1236&&$st->lastname!="") {   // if pm student is late
                  $m_in = substr($st->at_time_in_pm, -2);
                  $h_in = substr($st->at_time_in_pm, 0, -2);
                  $t_in = $h_in.':'.$m_in.':00';
                  if ($t_in!='13:00:00') {
                  $count++;
                      $pmtardy = array(
                        'l_st_id'       => $st->att_st_id, 
                        'l_grade_id'    => $st->grade_id,
                        'l_date'        => $st->date,
                        'l_time_in'     => $rec_in_pm,
                        'l_actual_time_in'    => $t_in,
                        'l_att_id'      => $st->att_id,
                        );
                      $tid = $this->pod_model->save_tardy($pmtardy);
                      print_r('Tardy Detected: '.$st->att_st_id.' date: '.$st->date.' time: '.$t_in.' id:'.$tid.'<br/>');
                    }
                }
            }
        }
        print_r('Total Tardy Detected: '.$count);
    }

    function save_action()
    {
        $ir_id = $this->input->post('ir_id');
        $ir_sel = $this->input->post('ir_sel');
        $ir_remarks = $this->input->post('ir_remarks');

        $update = array(
                'l_status' => $ir_sel,
                'l_remarks' => $ir_remarks,
        );

        $this->pod_model->update_tardy($update, $ir_id);
    }

    function calculate()
    {
        // sleep(1);
        $st_id = base64_decode($this->input->post('st_id'));
        $quarter = $this->pod_model->quarter();
        $sy = $this->session->userdata('school_year');
        $dnow = date('Y-m-d');
        foreach ($quarter as $q) {
            if ($q->school_year==$sy) {
                if ($dnow>=$q->from_date&&$dnow<=$q->to_date) {
                   $quarter_now = $q->quarter;
                   $dfrom = $q->from_date;
                   $dto = $q->to_date;
                }
            }
        }

        $saccount = $this->pod_model->st_profile($st_id);
        $ssummary = $this->pod_model->st_summary($st_id, $dfrom, $dto);
        $sname = $saccount->lastname.', '.$saccount->firstname;
        $slevel = $saccount->level;
        $scounts = $ssummary->total;
        echo json_encode(array(
            'st_id'         => $st_id,
            'sname'         => $sname,
            'slevel'        => $slevel,
            'scounts'       => $scounts,
            )
        );
    }

    function searchEmployeeAccounts($value, $year=NULL)
    {
        $student = $this->pod_model->searchEmployeeAccounts($value, $year);
        echo '<ul>';
        foreach ($student as $s):
        ?>
                <li style="font-size:18px;" onclick="$('#searchName').hide(), $('#searchBox').val('<?php echo $s->lastname.' '.$s->firstname ?>'), loadDetails('<?php echo base64_encode($s->emp_id) ?>','<?php echo $year ?>')" ><?php echo strtoupper($s->lastname.', '.$s->firstname) ?></li>   
        <?php        
        endforeach;
        echo '</ul>';
        
    }

    function save_manual()
    {
        $st_id = $this->input->post('st_id');
        $ir_sel = $this->input->post('ir_sel');
        $ir_remarks = $this->input->post('ir_remarks');
        $grade_id = $this->input->post('grade_id');
        $ir_time_a = $this->input->post('ir_time');
        $ir_time_a = $ir_time_a.':00';
        $ir_time = date('H:i:s');
        $ir_date = date('Y-m-d');

        $input = array(
            'l_st_id'           => base64_decode($st_id), 
            'l_grade_id'        => $grade_id,
            'l_date'            => $ir_date,
            'l_time_in'         => $ir_time,
            'l_actual_time_in'  => $ir_time_a,
            'l_status'          => $ir_sel,
            'l_remarks'         => $ir_remarks,
        );
        $this->pod_model->save_tardy($input);

    }


        
}

