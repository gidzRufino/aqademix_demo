<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of academic
 *
 * @author genesis
 */
class customize extends MX_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('Pdf');
        $this->load->library('csvimport');
        $this->load->library('csvreader');
        $this->load->dbutil();
        $this->load->helper('file');
        $this->load->model('customize_model');
    }

    public function printReportCard($short_name, $student, $admitted, $school_year, $grading)
    {
        $data['short_name'] = $short_name;
        $data['admitted'] = $admitted;
        $data['term'] = $grading;
        $data['student'] = $student;
        $data['sy'] = $school_year;
        switch ($short_name):
            case 'csfl':
                if ($student->grade_id == 1 || $student->grade_id == 14 || $student->grade_id == 15 || $student->grade_id == 16):
                    $this->load->view($short_name . '/reportCard_kinder', $data);
                else:
                    $this->load->view($short_name . '/reportCard', $data);
                endif;
                break;
            default:
                $this->load->view($short_name . '/reportCard', $data);
                break;
        endswitch;
    }

    public function generateReportCard($short_name, $student, $term, $behavior, $core, $school_year)
    {
        $data['core_val'] = $core;
        $data['behavior'] = $behavior;
        $data['term'] = $term;
        $data['short_name'] = $short_name;
        $data['student'] = $student;
        $data['sy'] = $school_year;
        $this->load->view($short_name . '/generateReportCard', $data);
    }

    function getBHrate()
    {
        $data['stid'] = $this->input->post('stid');
        $data['term'] = $this->input->post('term');
        $data['sy'] = $this->input->post('sy');
        $id = $this->input->post('id');
        $short_name = $this->input->post('short_name');
        $dept_id = $this->input->post('dept_id');
        $data['bhrate'] = Modules::run('reports/getBhRate', $id, $dept_id);
        // $data['bhrate'] = Modules::run('reports/getBhRate', $id);
        $this->load->view($short_name . '/displayCoreValues', $data);
    }

    function eligForm($short_name, $stid)
    {
        $data['school'] = $this->customize_model->getPreSkulInfo(base64_decode($stid));
        $this->load->view($short_name . '/eligForm', $data);
    }

    function printF137($data)
    {
        $short_name = $data['settings']->short_name;
        $this->load->view($short_name . '/gs_frontpage', $data);
    }

    function getPreSchoolInfo($stid)
    {
        return $this->customize_model->getPreSkulInfo(base64_decode($stid));
    }

    function cotMsg($name, $level)
    {
        ?>
        <h3>TO WHOM IT MAY CONCERN:</h3>
        <p style="text-indent: 10em; font-size: 14px">This is to certify that this is a true <b>Elementary School Record</b> of
            <u>&nbsp;&nbsp;&nbsp;&nbsp;
                <?php echo $name ?>&nbsp;&nbsp;&nbsp;&nbsp;
            </u>.</p>
        <p style="font-size: 14px">He/She is eligible for transfer and admission to <b><u>&nbsp;&nbsp;&nbsp;
                    <?php echo $level ?>&nbsp;&nbsp;&nbsp;&nbsp;
                </u></b></p>
        <?php
    }

    function getPreSchoolSubj()
    {
        return $this->customize_model->getPreSchoolSubj();
    }

    function getSubjDetails($id)
    {
        return $this->customize_model->getSubjDetails($id);
    }

    function updateLLCrate()
    {
        $rate = $this->input->post('value');
        $stid = $this->input->post('st_id');
        $sy = $this->input->post('school_year');
        $details = $this->input->post('details');
        $info = explode('-', $details);
        $d_id = $info[0];
        $grading = $info[1];

        $this->customize_model->updateLLCrate($stid, $rate, $d_id, $grading, $sy);
    }

    function getLLCrate($stid, $d_id, $grading, $sy)
    {
        return $this->customize_model->getLLCrate($stid, $d_id, $grading, $sy);
    }

    function textWithBullet($msg)
    {
        return '<ul><li> ' . $msg . ' </li></ul>';
    }

    function master_sheet($short_name, $data, $term)
    {
        if ($term == 0):
            $this->load->view($short_name . '/master_sheet_final', $data);
        else:
            $this->load->view($short_name . '/master_sheet', $data);
        endif;
    }

}
