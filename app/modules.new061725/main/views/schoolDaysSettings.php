<div class="panel panel-default">
    <div class="panel-heading">
        <h5>Basic Ed Number of School Days</h5>
    </div>
    <div class="panel-body">
        <?php $year = $this->session->school_year; ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 style="text-align: center">Grade School</h4>
                <label>Start Date : </label>
                <span class="dateSet" id="span_gs_start" ondblclick="$(this).hide(), $('#gs_start').show()"><?php echo $settings->bosy ?></span>
                <input type="date" style="display: none; width: 150px" id="gs_start" class='form-control' school-id='<?php echo $settings->school_id; ?>' be="1" sem="0" is-college="0" change-type="1" gs_start="<?php echo $settings->gs_start; ?>" value="<?php echo ($settings->gs_start != '0000-00-00') ? $settings->gs_start : '' ?>" onkeypress="confirmChange(this), $(this).hide(), $('#span_gs_start').show()" />
                <br>
                <label>End Date : </label>
                <span class="dateSet" id="span_gs_end" ondblclick="$(this).hide(), $('#gs_end').show()"><?php echo $settings->eosy ?></span>
                <input type="date" style="display: none; width: 150px" id="gs_end" class='form-control' school-id='<?php echo $settings->school_id; ?>' be="1" sem="0" is-college="0" change-type="0" gs_end="<?php echo $settings->gs_end; ?>" value="<?php echo ($settings->gs_end != '0000-00-00') ? $settings->gs_end : '' ?>" onkeypress="confirmChange(this), $(this).hide(), $('#span_gs_end').show()" />
                <br>
            </div>
            <div class="panel-body">
                <div id="setMonthDate">
                    <table class="table table-bordered">
                        <tr>
                            <?php
                            $gs_start = date('m', strtotime($settings->bosy));
                            $gs_end = date('m', strtotime($settings->eosy));
                            $gsDays = Modules::run('reports/getRawSchoolDays', $year, 2);
                            
                            for ($i = $gs_start; $i <= (12 + $gs_end); $i++):
                                $m = $i;
                                $monthName = date('M', strtotime(date('Y-' . ($m > 12 ? (($m - 12) < 10 ? '0' . ($m - 12) : ($m - 12)) : $m) . '-01')));
                                ?>
                                <td style="text-align: center"><?php echo $monthName ?></td>
                                <?php
                            endfor;
                            ?>
                            <td style="text-align: center">Total</td>
                        </tr>
                        <tr>
                            <?php
                            $gsTotal = 0;
                            for ($i = $gs_start; $i <= (12 + $gs_end); $i++):
                                $m = $i;
                                $n = ($m > 12 ? (($m - 12) < 10 ? '0' . ($m - 12) : ($m - 12)) : $m);
                                $monthName = date('F', strtotime(date('Y-' . ($m > 12 ? (($m - 12) < 10 ? '0' . ($m - 12) : ($m - 12)) : $m) . '-01')));
                                ?>
                                <td class="setNumDays" style="text-align: center" dept="2" id="<?php echo $n ?>"><?php echo $gsDays->$monthName ?></td>
                                <?php
                                $gsTotal += $gsDays->$monthName;
                            endfor;
                            ?>
                            <td style="text-align: center"><?php echo $gsTotal ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 style="text-align: center">Junior High School</h4>
                <label>Start Date : </label>
                <span class="dateSet" id="span_jh_start" ondblclick="$(this).hide(), $('#jh_start').show()"><?php echo $settings->jh_start ?></span>
                <input type="date" style="display: none; width: 150px" id="jh_start" class='form-control' school-id='<?php echo $settings->school_id; ?>' be="2" sem="0" is-college="0" change-type="1" jh_start="<?php echo $settings->jh_start; ?>" value="<?php echo ($settings->jh_start != '0000-00-00') ? $settings->jh_start : '' ?>" onkeypress="confirmChange(this), $(this).hide(), $('#span_jh_start').show()" />
                <br>
                <label>End Date : </label>
                <span class="dateSet" id="span_jh_end" ondblclick="$(this).hide(), $('#jh_end').show()"><?php echo $settings->jh_end ?></span>
                <input type="date" style="display: none; width: 150px" id="jh_end" class='form-control' school-id='<?php echo $settings->school_id; ?>' be="2" sem="0" is-college="0" change-type="0" jh_end="<?php echo $settings->jh_end; ?>" value="<?php echo ($settings->jh_end != '0000-00-00') ? $settings->jh_end : '' ?>" onkeypress="confirmChange(this), $(this).hide(), $('#span_jh_end').show()" />
                <br>
            </div>
            <div class="panel-body">
                <div id="setMonthDate">
                    <table class="table table-bordered">
                        <tr>
                            <?php
                            $jh_start = date('m', strtotime($settings->jh_start));
                            $jh_end = date('m', strtotime($settings->jh_end));
                            $jhDays = Modules::run('reports/getRawSchoolDays', $year, 3);

                            for ($i = $jh_start; $i <= (12 + $jh_end); $i++):
                                $m = $i;
                                $monthName = date('M', strtotime(date('Y-' . ($m > 12 ? (($m - 12) < 10 ? '0' . ($m - 12) : ($m - 12)) : $m) . '-01')));
                                ?>
                                <td style="text-align: center"><?php echo $monthName ?></td>
                                <?php
                            endfor;
                            ?>
                            <td style="text-align: center">Total</td>
                        </tr>
                        <tr>
                            <?php
                            $jhTotal = 0;
                            for ($i = $jh_start; $i <= (12 + $jh_end); $i++):
                                $m = $i;
                                $n = ($m > 12 ? (($m - 12) < 10 ? '0' . ($m - 12) : ($m - 12)) : $m);
                                $monthName = date('F', strtotime(date('Y-' . ($m > 12 ? (($m - 12) < 10 ? '0' . ($m - 12) : ($m - 12)) : $m) . '-01')));
                                ?>
                                <td class="setNumDays" style="text-align: center" dept="3" id="<?php echo $n ?>"><?php echo ($jhDays->$monthName != '' ? $jhDays->$monthName : '') ?></td>
                                <?php
                                $jhTotal += $jhDays->$monthName;
                            endfor;
                            ?>
                            <td style="text-align: center"><?php echo $jhTota ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 style="text-align: center">Senior High School</h4>
                <div class="col-md-6" style="border-right-style: dotted">
                    <label>Start First Sem : </label>
                    <span class="dateSet" id="span_sh_first_start" ondblclick="$(this).hide(), $('#sh_first_start').show()"><?php echo $settings->sh_first_start ?></span>
                    <input type="date" style="display: none; width: 150px" id="sh_first_start" class='form-control' school-id='<?php echo $settings->school_id; ?>' be="3" sem="1" is-college="0" change-type="1" sh_first_start="<?php echo $settings->sh_first_start; ?>" value="<?php echo ($settings->sh_first_start != '0000-00-00') ? $settings->sh_first_start : '' ?>" onkeypress="confirmChange(this), $(this).hide(), $('#span_sh_first_start').show()" />
                    <br>
                    <label>End First Sem : </label>
                    <span class="dateSet" id="span_sh_first_end" ondblclick="$(this).hide(), $('#sh_first_end').show()"><?php echo $settings->sh_first_end ?></span>
                    <input type="date" style="display: none; width: 150px" id="sh_first_end" class='form-control' school-id='<?php echo $settings->school_id; ?>' be="3" sem="1" is-college="0" change-type="0" sh_first_end="<?php echo $settings->sh_first_end; ?>" value="<?php echo ($settings->sh_first_end != '0000-00-00') ? $settings->sh_first_end : '' ?>" onkeypress="confirmChange(this), $(this).hide(), $('#span_sh_first_end').show()" />
                </div>&nbsp;&nbsp;&nbsp;
                <label>Start Second Sem : </label>
                <span class="dateSet" id="span_sh_second_start" ondblclick="$(this).hide(), $('#sh_second_start').show()"><?php echo $settings->sh_second_start ?></span>
                <input type="date" style="display: none; width: 150px" id="sh_second_start" class='form-control' school-id='<?php echo $settings->school_id; ?>' be="3" sem="2" is-college="0" change-type="1" sh_second_start="<?php echo $settings->sh_second_start; ?>" value="<?php echo ($settings->sh_second_start != '0000-00-00') ? $settings->sh_second_start : '' ?>" onkeypress="confirmChange(this), $(this).hide(), $('#span_sh_second_start').show()" />
                <br>&nbsp;&nbsp;&nbsp;
                <label>End Second Sem : </label>
                <span class="dateSet" id="span_sh_second_end" ondblclick="$(this).hide(), $('#sh_second_end').show()"><?php echo $settings->sh_second_end ?></span>
                <input type="date" style="display: none; width: 150px" id="sh_second_end" class='form-control' school-id='<?php echo $settings->school_id; ?>' be="3" sem="2" is-college="0" change-type="0" sh_second_end="<?php echo $settings->sh_second_end; ?>" value="<?php echo ($settings->sh_second_end != '0000-00-00') ? $settings->sh_second_end : '' ?>" onkeypress="confirmChange(this), $(this).hide(), $('#span_sh_second_end').show()" />
                <br>
            </div>
            <div class="panel-body">
                <div id="setMonthDate">
                    <table class="table table-bordered">
                        <tr>
                            <?php
                            $sh_first_start = date('m', strtotime($settings->sh_first_start));
                            $sh_first_end = date('m', strtotime($settings->sh_first_end));
                            $sh_second_start = date('m', strtotime($settings->sh_second_start));
                            $sh_second_end = date('m', strtotime($settings->sh_second_end));
                            $shDays = Modules::run('reports/getRawSchoolDays', $year, 4);

                            for ($i = $sh_first_start; $i <= (12 + $sh_second_end); $i++):
                                $m = $i;
                                $monthName = date('M', strtotime(date('Y-' . ($m > 12 ? (($m - 12) < 10 ? '0' . ($m - 12) : ($m - 12)) : $m) . '-01')));
                                ?>
                                <td style="text-align: center"><?php echo $monthName ?></td>
                                <?php
                            endfor;
                            ?>
                            <td style="text-align: center">Total</td>
                        </tr>
                        <tr>
                            <?php
                            $shTotal = 0;
                            for ($i = $sh_first_start; $i <= (12 + $sh_second_end); $i++):
                                $m = $i;
                                $n = ($m > 12 ? (($m - 12) < 10 ? '0' . ($m - 12) : ($m - 12)) : $m);
                                $monthName = date('F', strtotime(date('Y-' . ($m > 12 ? (($m - 12) < 10 ? '0' . ($m - 12) : ($m - 12)) : $m) . '-01')));
                                ?>
                                <td class="setNumDays" style="text-align: center" dept="4" id="<?php echo $n ?>"><?php echo $shDays->$monthName ?></td>
                                <?php
                            $shTotal += $shDays->$monthName;
                            endfor;
                            ?>
                            <td style="text-align: center"><?php echo $shTotal ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>