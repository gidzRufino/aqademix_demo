<page size="legal" layout="portrait" style="padding-bottom:60px">
    <div style="height: 100%; padding: 30px 50px;">
        <div style="height: 100%; padding: 0 20px; border: 2px solid black">
            <table width="100%">
                <thead>
                    <tr>
                        <th colspan='1' >
                            <img src="<?php echo base_url() . 'images/forms/' . $settings->set_logo ?>" alt="" style="height: 150px;">
                        </th>
                        <th colspan="3">
                            <div>
                                <h1><?php echo $settings->set_school_name?></h1>
                            </div>
                            <div>
                                <h3><?php echo $settings->set_school_address?></h3>
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody>

                        <tr>
                            <td style="border:none"> <span style="font-weight: bold; font-size: 14px;">Students Name:</span></td>
                            <td ><?php echo $details->firstname; ?></td>
                            <td ><?php echo $details->middlename; ?></td>
                            <td ><?php echo $details->lastname; ?></td>
                        </tr>

                    
                    <tr>
                        <td ><h3>Date of Birth:</h3><?php echo Date('m/d/Y', strtotime($details->temp_bdate)); ?></td>
                        <td><h3>Place of Birth:</h3>N/A</td>
                        <td><h3>Sex:</h3><?php echo $details->sex; ?></td>
                        <td><h3>Religion:</h3><?php echo $details->religion; ?></td>
                    </tr>
                    <?php if($details->str_id != 0): ?>
                    <tr>
                        <td><h3>Grade Level: </h3><?php echo $details->level; ?></td>
                        <td><h3>Semester:</h3> First Sem</td>
                        <td><h3>Date of Enrolled:</h3>N/A</td>
                        <td><h3>School Year:</h3><?php echo $details->school_year; ?></td> 
                    </tr>
                    <tr>
                        <td><h3>Strand:</h3><?php echo $details->strand; ?></td>
                    </tr>
                    <?php else: ?>
                    <tr>
                        <td><h3>Grade Level: </h3><?php echo $details->level; ?></td>
                        <td><h3>Semester:</h3> First Sem</td>
                        <td><h3>Date of Enrolled:</h3>N/A</td>
                        <td><h3>School Year:</h3><?php echo $details->school_year; ?></td> 
                    </tr>
                    <?php endif; ?>
                    <tr>
                        <td colspan="4" style="border:none"><h2>Contact Information</h2></td>
                    </tr>
                    <tr>
                        <?php
                            $street = ($details->street != '') ? $details->street.", " : '';
                            $barangay = ($details->barangay != '') ? $details->barangay.", " : '';
                            $city = ($details->mun_city != '') ? $details->mun_city.", " : '';
                            $province = ($details->province != '') ? $details->province.", " : '';
                            $country = ($details->country != '') ? $details->country.", " : '';
                            $address = $street.$barangay.$city.$province.$country.$details->zip_code;
                        ?>
                        <td colspan="2"><h3>Address</h3><?php echo $address; ?></td>
                        <td><h3>Contact Number:</h3><?php echo ($details->cd_mobile != '') ? $details->cd_mobile : 'N/A'; ?></td>
                        <td><h3>Email:</h3><?php echo ($details->cd_email != '') ? $details->cd_email : 'N/A'; ?></td>
                    </tr>
                    <tr>
                        <td colspan="4" style="border:none"><h2>Family Information</h2></td>
                    </tr>
                    <tr>
                        <td style="border: 0px;"><h5>Father's Details:</h5></td>
                    </tr>
                    <tr>
                        <td style="border:none"><span style="font-weight: bold; font-size: 14px;">Father's Name:</span></td>
                        <td ><?php echo ($details->f_firstname != '') ? $details->f_firstname : 'No Details'; ?></td>
                        <td ><?php echo ($details->f_middlename != '') ? $details->f_middlename : 'No Details'; ?></td>
                        <td ><?php echo ($details->f_lastname != '') ? $details->f_lastname : 'No Details'; ?></td>
                    </tr>
                    <tr>
                        <td><h3>Contact Number:</h3><?php echo ($details->f_mobile != '') ? $details->f_mobile : 'N/A'; ?></td>
                        <td><h3>Educational Attainment:</h3><?php echo ($details->f_educ != 0) ? $details->f_att : 'N/A'; ?></td>
                        <td><h3>Profession/Occupation</h3><?php echo ($details->f_occ != 0) ? $details->f_occup : 'N/A'; ?></td>
                        <td><h3>Father's Office Name</h3><?php echo $details->f_office_name; ?></td>
                    </tr>
                    <tr>
                        <td style="border: 0px; margin-bottom: 1px;"><h5>Father's Office Address:</h5></td>
                    </tr>
                    <tr>
                        <td><h3>Street</h3><?php echo $details->f_street; ?></td>
                        <td><h3>Barangay</h3><?php echo $details->f_barangay; ?></td>
                        <td><h3>City</h3><?php echo $details->f_city; ?></td>
                        <td><h3>Province</h3><?php echo $details->f_prov; ?></td>
                    </tr>
                    <tr>
                        <td style="border: 0px;"><h5>Mother's Details:</h5></td>
                    </tr>
                    <tr>
                        <td style="border:none"><span style="font-weight: bold; font-size: 14px;">Mother's Maiden Name:</span></td>
                        <td ><?php echo $details->m_firstname; ?></td>
                        <td ><?php echo $details->m_middlename; ?></td>
                        <td ><?php echo $details->m_lastname; ?></td>
                    </tr>
                    <tr>
                        <td><h3>Contact Number:</h3><?php echo $details->m_mobile; ?></td>
                        <td><h3>Educational Attainment:</h3><?php echo ($details->m_educ != '') ? $details->m_att : 'N/A'; ?></td>
                        <td><h3>Profession/Occupation:</h3><?php echo $details->m_occup; ?></td>
                        <td><h3>Mother's Office Name:</h3><?php echo $details->m_office_name; ?></td>
                    </tr>
                    <tr>
                        <td style="border: 0px;"><h5>Mother's Office Address:</h5></td>
                    </tr>
                    <tr>
                        <td><h3>Street</h3><?php echo $details->m_street; ?></td>
                        <td><h3>Barangay</h3><?php echo $details->m_barangay; ?></td>
                        <td><h3>City</h3><?php echo $details->m_city; ?></td>
                        <td><h3>Province</h3><?php echo $details->m_prov; ?></td>
                    </tr>

                    
                    <tr>
                        <td colspan="4" style="border:none"><h2>Emergency Contact</h2></td>
                    </tr>
                    <tr>
                        <td><h3>Contact Name:</h3><?php echo $details->ice_name; ?></td>
                        <td><h3>Contact Number:</h3><?php echo $details->ice_contact; ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</page>
