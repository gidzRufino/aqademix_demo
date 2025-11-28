<?php

class Portal_model extends CI_Model {

    function fetchSubjectGrades($st_id, $sub_id){
        return $this->db->select('gsa_grade, gsa_term_id, gsa_sub_id')
                        ->where('gsa_st_id', $st_id)
                        ->where('gsa_sub_id', $sub_id)
                        ->where('gsa_school_year', $this->session->school_year)
                        ->get('c_gs_final_grade')->result();
    }

    function fetchCollegeSubjects($st_id){
        return $this->db->select('c_subjects.sub_code, c_subjects.s_id')
                        ->join('profile_students_c_load', 'profile_students.user_id = profile_students_c_load.cl_user_id')
                        ->join('c_subjects', 'profile_students_c_load.cl_sub_id = c_subjects.s_id')
                        ->where('profile_students.st_id', $st_id)
                        ->get('profile_students')->result();
    }

    function fetchChildren($parent_id){
        return $this->db->select('child_links')
                        ->where('u_id', $parent_id)
                        ->get('user_accounts')->row();
    }

    function fetchCollegeLevel($st_id){
        return $this->db->select('profile.firstname, profile.middlename, profile.lastname, profile.avatar, c_courses.short_code, profile_students_c_admission.year_level')
                            ->join('profile', 'profile_students.user_id = profile.user_id')
                            ->join('profile_students_c_admission', 'profile_students.st_id = profile_students_c_admission.st_id')
                            ->join('c_courses', 'profile_students_c_admission.course_id = c_courses.course_id')
                            ->where('profile_students.st_id', $st_id)
                            ->get('profile_students')->row();
    }

    function fetchGradeSchoolLevel($st_id){
        return $this->db->select('profile.firstname, profile.middlename, profile.lastname, profile.avatar, grade_level.level, section.section')
                            ->join('profile', 'profile_students.user_id = profile.user_id')
                            ->join('profile_students_admission', 'profile_students.st_id = profile_students_admission.st_id')
                            ->join('section', 'profile_students_admission.section_id = section.section_id')
                            ->join('grade_level', 'section.grade_level_id = grade_level.grade_id')
                            ->where('profile_students.st_id', $st_id)
                            ->get('profile_students')->row();
    }

    function fetchStudents($parent_id){
        return $this->db->select('profile.firstname, profile.middlename, profile.lastname, profile.avatar, profile_students.st_id')
                        ->join('profile_students', 'profile_parents.parent_id = profile_students.parent_id', 'LEFT')
                        ->join('profile', 'profile_students.user_id = profile.user_id')
                        ->where('profile_parents.father_id', $parent_id)
                        ->or_where('profile_parents.mother_id', $parent_id)
                        ->or_where('profile_parents.parent_id', $parent_id)
                        ->get('profile_parents');
    }

    function fetchAssessment($st_id, $sub_id, $cat){
        return $this->db->select('gs_assessment.no_items, gs_raw_score.raw_score')
                        ->join('gs_raw_score', 'gs_assessment.assess_id = gs_raw_score.assess_id', 'LEFT')
                        ->where('gs_assessment.subject_id', $sub_id)
                        ->where('gs_raw_score.st_id', $st_id)
                        ->where('gs_assessment.quiz_cat', $cat)
                        ->get('gs_assessment')->result();
    }

    function fetchAssessmentCat($st_id, $sub_id){
        return $this->db->select('gs_asses_category.code, gs_asses_category.weight')
                        ->join('subjects_settings', 'profile_students_admission.grade_level_id = subjects_settings.grade_level_id', 'LEFT')
                        ->join('gs_asses_category', 'subjects_settings.sub_id = gs_asses_category.subject_id')
                        ->where('profile_students_admission.st_id', $st_id)
                        ->where('subjects_settings.sub_id', $sub_id)
                        ->get('profile_students_admission');
    }

    function fetchGradeSchoolSubjects($st_id){
        return $this->db->select('subjects.subject_id, subjects.subject')
                        ->join('profile_students_admission', 'subjects_settings.grade_level_id = profile_students_admission.grade_level_id', 'LEFT')
                        ->join('subjects', 'subjects_settings.sub_id = subjects.subject_id')
                        ->where('profile_students_admission.st_id', $st_id)
                        ->get('subjects_settings')->result();
    }

    function fetchStudentDetails($st_id) {
        return $this->db->select('profile.avatar, profile.firstname, profile.middlename, profile.lastname, profile.temp_bdate, profile_address_info.street, barangay.barangay, cities.mun_city, provinces.province, profile_address_info.country, profile_address_info.zip_code, grade_level.level, section.section, c_courses.short_code, profile_students_c_admission.year_level')
                        ->join('profile', 'profile_students.user_id = profile.user_id', 'left')
                        ->join('profile_address_info', 'profile.add_id = profile_address_info.address_id', 'left')
                        ->join('barangay', 'profile_address_info.barangay_id = barangay.barangay_id', 'left')
                        ->join('cities', 'profile_address_info.city_id = cities.id', 'left')
                        ->join('provinces', 'profile_address_info.province_id = provinces.id', 'left')
                        ->join('profile_students_admission', 'profile.user_id = profile_students_admission.user_id', 'left')
                        ->join('grade_level', 'profile_students_admission.grade_level_id = grade_level.grade_id', 'left')
                        ->join('section', 'profile_students_admission.section_id = section.section_id', 'left')
                        ->join('profile_students_c_admission', 'profile.user_id = profile_students_c_admission.user_id', 'left')
                        ->join('c_courses', 'profile_students_c_admission.course_id = c_courses.course_id', 'left')
                        ->where('profile_students.st_id', $st_id)
                        ->get('profile_students')->row();
    }

}
