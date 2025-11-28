<table class="table table-bordered table-striped">
                <tr>
                    <td>Month</td>
                    <td class="text-center">School Days</td>
                    <td class="text-center">Days Present</td>
                </tr>
                <tr>
                    <td>June</td>
                    <td class="text-center">
                        <?php echo Modules::run('pp/numberOfSchoolDays', 6, $year, $year) ?>
                    </td>
                    <td class="text-center">
                        <?php echo Modules::run('attendance/getIndividualMonthlyAttendance', $student->st_id, 6, $year, $year); ?>
                    </td>
                </tr>
                <tr>
                    <td>July</td>
                    <td class="text-center">
                        <?php echo Modules::run('pp/numberOfSchoolDays', 7, $year, $year) ?>
                    </td>
                    <td class="text-center">
                        <?php echo Modules::run('attendance/getIndividualMonthlyAttendance', $student->st_id, 7, $year, $year); ?>
                    </td>
                </tr>
                <tr>
                    <td>August</td>
                    <td class="text-center">
                        <?php echo Modules::run('pp/numberOfSchoolDays', 8, $year, $year) ?>
                    </td>
                    <td class="text-center">
                        <?php echo Modules::run('attendance/getIndividualMonthlyAttendance', $student->st_id, 8, $year, $year); ?>
                    </td>
                </tr>
                <tr>
                    <td>September</td>
                    <td class="text-center">
                        <?php echo Modules::run('pp/numberOfSchoolDays', 9, $year, $year) ?>
                    </td>
                    <td class="text-center">
                        <?php echo Modules::run('attendance/getIndividualMonthlyAttendance', $student->st_id, 9, $year, $year); ?>
                    </td>
                </tr>
                <tr>
                    <td>October</td>
                    <td class="text-center">
                        <?php echo Modules::run('pp/numberOfSchoolDays', 10, $year, $year) ?>
                    </td>
                    <td class="text-center">
                        <?php echo Modules::run('attendance/getIndividualMonthlyAttendance', $student->st_id, 10, $year, $year); ?>
                    </td>
                </tr>
                <tr>
                    <td>November</td>
                    <td class="text-center">
                        <?php echo Modules::run('pp/numberOfSchoolDays', 11, $year, $year) ?>
                    </td>
                    <td class="text-center">
                        <?php echo Modules::run('attendance/getIndividualMonthlyAttendance', $student->st_id, 11, $year, $year); ?>
                    </td>
                </tr>
                <tr>
                    <td>December</td>
                    <td class="text-center">
                        <?php echo Modules::run('pp/numberOfSchoolDays', 12, $year, $year) ?>
                    </td>
                    <td class="text-center">
                        <?php echo Modules::run('attendance/getIndividualMonthlyAttendance', $student->st_id, 12, $year, $year); ?>
                    </td>
                </tr>
                <tr>
                    <td>January</td>
                    <td class="text-center">
                        <?php echo Modules::run('pp/numberOfSchoolDays', 1, $year+1, $year) ?>
                    </td>
                    <td class="text-center">
                        <?php echo Modules::run('attendance/getIndividualMonthlyAttendance', $student->st_id, 1, $year+1, $year); ?>
                    </td>
                </tr>
                <tr>
                    <td>February</td>
                    <td class="text-center">
                        <?php echo Modules::run('pp/numberOfSchoolDays', 2, $year+1, $year) ?>
                    </td>
                    <td class="text-center">
                        <?php echo Modules::run('attendance/getIndividualMonthlyAttendance', $student->st_id, 2, $year+1, $year); ?>
                    </td>
                </tr>
                <tr>
                    <td>March</td>
                    <td class="text-center">
                        <?php echo Modules::run('pp/numberOfSchoolDays', 3, $year+1, $year) ?>
                    </td>
                    <td class="text-center">
                        <?php echo Modules::run('attendance/getIndividualMonthlyAttendance', $student->st_id, 3, $year+1, $year); ?>
                    </td>
                </tr>
            </table>
