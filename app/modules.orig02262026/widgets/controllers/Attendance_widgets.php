<?php if (! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Attendance_widgets extends MX_Controller
{

    public function getCollegeAttendanceUpdates($presents = NULL)
    {
        $pasttime = time();
        while ((time() - $pasttime) < 30):
            $attendance = Modules::run('attendance/getNumberOfCollegePresent', date('Y-m-d'));
            if ($attendance->num_rows() > $presents || $attendance->num_rows() < $presents):
                $array = array(
                    'time' => time(),
                    'presents' => $attendance->num_rows
                );


                echo json_encode($array);
                break;
            else:
                sleep(5);
                continue;
            endif;
        endwhile;

        if ($attendance->num_rows() == $presents):
            $array = array(
                'time' => time(),
                'presents' => $presents
            );


            echo json_encode($array);
        endif;
    }

    public function getAttendanceUpdates($presents = NULL)
    {
        $pasttime = time();
        while ((time() - $pasttime) < 30):
            $attendance = Modules::run('attendance/getNumberOfPresents', date('Y-m-d'));
            if ($attendance->num_rows() > $presents || $attendance->num_rows() < $presents):
                $array = array(
                    'time' => time(),
                    'presents' => $attendance->num_rows
                );


                echo json_encode($array);
                break;
            else:
                sleep(5);
                continue;
            endif;
        endwhile;

        if ($attendance->num_rows() == $presents):
            $array = array(
                'time' => time(),
                'presents' => $presents
            );


            echo json_encode($array);
        endif;
    }

    public function numberOfEmployeePresents()
    {
        $data['numberOfStudents'] = Modules::run('hr/getEmployees');
        $data['numberOfPresents'] = Modules::run('attendance/getNumberOfEmployeePresents', date('Y-m-d'));
        $result = $this->load->view('attendance/presentTeachersAttendance', $data);
        return $result;
    }

    public function numberOfPresents()
    {
        if (!$this->session->is_adviser):
            $data['numberOfStudents'] = Modules::run('registrar/getTotalStudents');
        else:
            $data['numberOfStudents'] = Modules::run('registrar/getAllStudentsBasicInfoByGender', $this->session->advisory, NULL, 1, $this->session->school_year);
        endif;
        $data['numberOfPresents'] = Modules::run('attendance/getNumberOfPresents', date('Y-m-d'));
        $this->load->view('attendance/presentAttendance', $data);
        //return $result;
    }

    public function numberOfPresentCollege()
    {
        $semester = Modules::run('main/getSemester');
        $data['numberOfStudents'] = Modules::run('college/getTotalCollegeStudents', $this->session->userdata('school_year'), $semester, 1);
        $data['numberOfPresents'] = Modules::run('attendance/getNumberOfCollegePresent', date('Y-m-d'));
        $result = $this->load->view('attendance/presentCollegeAttendance', $data);
        return $result;
    }

    public function averageDailyAttendance()
    {
        $firstDay = Modules::run('main/getFirstLastDay', date("F", mktime(0, 0, 0, date('m'), 10)), date('Y'), 'first');
        $lastDay = date('d');
        $data['numberOfSchoolDays'] = Modules::run('main/getNumberOfSchoolDays', $firstDay, $lastDay, null, null);
        $data['numberOfPresents'] = 0;
        $data['level'] = Modules::run('registrar/getAllSection', $this->session->userdata('advisory'));
        //echo $numberOfPresents;
        $this->load->view('attendance/averageDailyAttendance', $data);
    }

    public function getAverageDailyAttendance()
    {
        $data['level'] = Modules::run('registrar/getAllSection', $this->session->userdata('advisory'));
        $firstDay = Modules::run('main/getFirstLastDay', date("F", mktime(0, 0, 0, date('m'), 10)), date('Y'), 'first');
        $lastDay = date('d');
        $numberOfSchoolDays = Modules::run('main/getNumberOfSchoolDays', $firstDay, $lastDay, null, null);
        $numberOfPresents = 0;
        for ($x = 1; $x <= $lastDay; $x++):
            if ($x < 10):
                $x = '0' . $x;
            endif;
            $day = date('D', strtotime(date('Y') . '-' . date('m') . '-' . $x));

            if ($day == 'Sat' || $day == 'Sun') {
            } else {
                $presents = Modules::run('attendance/getNumberOfPresents', date("Y-m-$x"));
                //echo date("m/$x/Y");
                $numberOfPresents += $presents->num_rows();
            }
        endfor;

        echo round(($numberOfPresents / $numberOfSchoolDays));
    }

    public function attendancePerformance($details)
    {
        $d = explode('-', $details['date']);
        $firstDay = Modules::run('main/getFirstLastDay', date("F", mktime(0, 0, 0, $d[1], 10)), $d[0], 'first');
        $lastDay = $d[2];
        $data['numberOfSchoolDays'] = Modules::run('main/getNumberOfSchoolDays', $firstDay, $lastDay);
        //$data['holiday'] = Modules::run('calendar/holidayExist', $d[0]);
        $numberOfPresents = 0;
        for ($x = 1; $x <= $lastDay; $x++):
            if ($x < 10):
                $x = '0' . $x;
            endif;
            $day = date('D', strtotime($details['date']));

            if ($day == 'Sat' || $day == 'Sun') {
            } else {
                $presents = Modules::run('attendance/getNumberOfPresents', $details['date'], $details['section']);
                //echo date("m/$x/Y");
                $numberOfPresents += $presents->num_rows();
            }
        endfor;
        $data['presents'] = $numberOfPresents;

        $data['level'] = Modules::run('registrar/getAllSection', $details['section']);
        $data['advisory'] = Modules::run('academic/getAdvisory', '', $this->session->userdata('school_year'), $details['section']);
        $data['numberOfStudents'] = Modules::run('registrar/getAllStudentsBasicInfoByGender', $details['grade'], NULL, 1, $this->session->userdata('school_year'), null, $details['section']);
        $data['numberOfPresents'] = Modules::run('attendance/getNumberOfPresents', $details['date'], $details['section']);

        $this->load->view('attendance/attendancePerformance', $data);
    }


    public function current() {}
}
