<?php
$this->load->helper('file');
$this->load->helper('download');

$new_report=$this->dbutil->csv_from_result($report);

//print_r($new_report);
write_file('db_backup/employee.csv',$new_report);
//write_file('db_backup/'.$report->row()->level.'_'.$report->row()->section.'.csv',$new_report);
$newCsvData = array();
if (($handle = fopen('db_backup/employee.csv', "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $header[] = 'ID Number';
        $header[] = 'Name';
        $header[] = 'Designation';
        $header[] = 'Cont_person';
        $header[] = 'Address';
        $header[] = 'Contact_Num';
        $header[] = 'Tin_Number';
        $header[] = 'SSS';
        $header[] = 'Phil_Health';
        $header[] = 'Blood_type';
        $header[] = 'Birthdate';
        $newCsvData[] = $header;
    }
    fclose($handle);
}

$handle = fopen('db_backup/employee.csv', 'w');
$x=0;
//print_r($newCsvData);
foreach ($newCsvData as $line) {
   $x++;
   if($x==1):
       fputcsv($handle, $line);
   endif;  
}
foreach ($report->result() as $row)
{
    if($row->street!=""):
        $address = $row->street.', '.$row->barangay.', '.$row->city_municipality.', '.$row->province.', '.$row->zip_code;
    else:
        $address = $row->barangay.', '.$row->city_municipality.', '.$row->province.', '.$row->zip_code;
    endif;
    $data[0] = $row->ID_Number;
    $data[1] = $row->firstname.' '.substr($row->middlename, 0,1).'. '.$row->lastname;
    $data[2] = $row->position;
    $data[3] = $row->incase_name;
    $data[4] = $address;
    $data[5] = $row->incase_contact;
    $data[6] = $row->tin;
    $data[7] = $row->sss;
    $data[8] = $row->phil_health;
    $data[9] = $row->blood_type;
    $data[10] =  str_replace("-","/",$row->cal_date); 
   
    
    fputcsv($handle, $data);
    
}

//    fputcsv($handle, $report->result());


fclose($handle);

echo '<h6>employee.csv is successfully exported</h6>';

//array_to_csv($array, 'sample.csv');

?>
<button class="btn btn-success" onclick="window.history.back()"><< Back</button>