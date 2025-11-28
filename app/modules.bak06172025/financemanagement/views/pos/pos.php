<?php
$stngs = Modules::run('main/getSet');

$is_admin = $this->session->userdata('is_admin');
$userid = $this->session->userdata('username');
$url_seg = $this->uri->segment(4);
if ($url_seg == '') {
    $use_sy = $default_sy->value;
} else {
    $use_sy = base64_decode($url_seg);
}
$default_sy = $default_sy->value;
?>
<style type="text/css">
    .calcbuts
    {height: 60px; padding-left: 0px; padding-right: 0px;}
    .calcbuts b
    {font-size:22px;}
    .caclbutsi
    {padding-left: 0px; padding-right: 0px; width: 130%;}
</style>

<div class="clearfix"> <!-- Halelujah! our God reigns! -->
    <div class="row">
        <!-- <div class="col-xs-12 col-md-8 col-md-offset-2"> -->
        <div class="col-xs-12 col-md-12">
            <div class="panel panel-default" style="margin-top: 15px;">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default" style="margin-bottom: 2px;">
                                <div class="panel-heading">
                                    <b>Hello!!!</b> Please select the desired account from the drop-down menu. 
                                    <select class="pull-right" onclick="getStudent()" tabindex="-1" id="searchingStudents" style="width: 225px; margin-top: -3px;">
                                        <option>Search Account Name</option>
                                        <option value="NEA">No Existing Account</option>
                                        <?php foreach ($students->result() as $st) {
                                            $id = $st->uid; ?>
                                            <option value="<?php echo base64_encode($id); ?>"><?php echo $st->lastname . ',&nbsp;' . $st->firstname; ?></option>
<?php } ?>
                                    </select>
                                    <input type="hidden" name="no_account" id="no_account" required>
                                    <!-- <input type="hidden" name="default_sy" id="default_sy" value="<?php echo base64_encode($default_sy) ?>" required> -->
                                    <input type="hidden" name="default_sy" id="default_sy" value="<?php echo base64_encode($use_sy) ?>" required>
                                </div>	
                            </div>
                        </div>
                    </div>

<?php if ($this->uri->segment(3) != '') { ?>

                        <div class="row" id="act_exist">
                            <div class="col-xs-12 col-md-12">
                                <div class="panel panel-info" style="margin-bottom: 2px;">
                                    <div class="panel-heading" style="height: 50px;">
                                        <div class="row">
                                            <div class="col-xs-1 col-md-1 text-center">

                                                <!-- count starts -->
                                                <?php
                                                $avatari = $searched_student->avatar;
                                                $student_full_name = "";
                                                $student_full_name = $searched_student->firstname . " " . $searched_student->middlename . " " . $searched_student->lastname;
                                                $student_level_section = $searched_student->level . " / " . $searched_student->section;
                                                $student_id = $searched_student->st_id;
                                                $slevelID = $searched_student->grade_level_id;
                                                $stPlan_id = null;
                                                foreach ($finance_plan as $finance_plan) {
                                                    $splan_desc = $finance_plan->plan_description;
                                                    $studentAccountID = $finance_plan->accounts_id;
                                                    $student_planID = $finance_plan->plan_id;
                                                    $stPlan_id = $finance_plan->plan_id;
                                                }
                                                if ($splan_desc == '') {
                                                    $plan_print = 'Please Select Payment Plan';
                                                } else {
                                                    $plan_print = $splan_desc;
                                                }

                                                $stud_id = $searched_student->st_id;
                                                $tcharge = 0;
                                                $tcredit = 0;
                                                $istCharge = 0;
                                                $istCredit = 0;
                                                $stPlanGen = 1;
                                                $stLevel_id = $searched_student->grade_id;

                                                if ($stPlan_id != null && $stPlan_id != 11) {  // not null payment plan and full scholar code ($stPlan_id=11)
                                                    foreach ($initialLevel as $ist) {
                                                        if ($ist->level_id == $stLevel_id && $ist->plan_id == $stPlan_id && $ist->sy_id == $use_sy || $ist->level_id == $stLevel_id && $ist->plan_id == $stPlanGen && $ist->sy_id == $use_sy) {
                                                            if ($ist->ch_cr == 0) {
                                                                $istCharge = $ist->item_amount;
                                                                $istCredit = 0;
                                                                $tcharge = $tcharge + $istCharge;
                                                                $dis_charge = 'PhP ' . number_format($istCharge, 2, ".", ",");
                                                                $dis_credit = '-';
                                                            } elseif ($ist->ch_cr == 1) {
                                                                $istCharge = 0;
                                                                $istCredit = $ist->item_amount;
                                                                $tcredit = $tcredit + $istCredit;
                                                                $dis_charge = '-';
                                                                $dis_credit = 'PhP ' . number_format($istCredit, 2, ".", ",");
                                                            }
                                                        }
                                                    }
                                                }

                                                foreach ($sTransaction as $st) {
                                                    if ($st->stud_id == $stud_id && $st->sy_id == $use_sy) {

                                                        if ($st->charge_credit == 1) {
                                                            $scredit = $st->d_credit;
                                                            $tcredit = $tcredit + $scredit;
                                                        } elseif ($st->charge_credit == 0) {
                                                            $scharge = $st->d_charge;
                                                            $tcharge = $tcharge + $scharge;
                                                        }
                                                    }
                                                }

                                                $tbalance = $tcharge - $tcredit;

                                                $tbalance_due = 0;
                                                $ar_itemChoice = array();
                                                $ar_balance = array();
                                                $ar_index = 0;
                                                $ar = 0;
                                                $cID = 0;
                                                $stPlanGen = 1;
                                                // print_r($initialLevel);

                                                if ($stPlan_id != null && $stPlan_id != 11) { // not null payment plan and full scholar code
                                                    foreach ($initialLevel as $iL) {
                                                        if ($iL->level_id == $stLevel_id && $iL->plan_id == $stPlan_id && $iL->sy_id == $use_sy || $iL->level_id == $stLevel_id && $iL->plan_id == $stPlanGen && $iL->sy_id == $use_sy) {
                                                            $cID += 1;

                                                            $ar += 1;
                                                            $ar_index = $ar - 1;
                                                            $itm = $iL->item_id;
                                                            $ar_itemChoice[$itm] = $iL->item_description;
                                                            $init_item_id = $iL->item_id;
                                                            $stCharge = 0;
                                                            $stCredit = 0;
                                                            $monthNow = date('n');
                                                            foreach ($sTransaction as $sBal) {
                                                                if ($sBal->stud_id == $stud_id) {
                                                                    if ($sBal->item_id == $init_item_id && $sBal->sy_id == $use_sy) {
                                                                        if ($sBal->charge_credit == 0) {
                                                                            $ssCharge = $sBal->d_charge; // if there is an existing amount
                                                                            $stCharge = $stCharge + $ssCharge;
                                                                        } elseif ($sBal->charge_credit == 1) {
                                                                            $ssCredit = $sBal->d_credit;
                                                                            $stCredit = $stCredit + $ssCredit;
                                                                        }
                                                                    }
                                                                }
                                                            }

                                                            $tAmount = $iL->item_amount;
                                                            $stBalance = $tAmount - $stCredit;
                                                            $tfreq = $iL->schedule_id;

                                                            if ($tfreq == 1) {
                                                                $tmBalance = $tAmount / 9;
                                                            } elseif ($tfreq == 2) {
                                                                $tmBalance = $tAmount / 4;
                                                            } elseif ($tfreq == 3) {
                                                                $tmBalance = $tAmount / 2;
                                                            } elseif ($tfreq == 4) {
                                                                $tmBalance = $tAmount;
                                                            } elseif ($tfreq == 5) {
                                                                $tmBalance = $tAmount / 2;
                                                            }
                                                            ?>

                                                            <input type="hidden" name="item<?php echo $itm ?>" id="item<?php echo $itm ?>" value="<?php echo $iL->item_description ?>" required>

                                                            <?php
                                                            switch ($monthNow) {
                                                                case '1':
                                                                    if ($tfreq == 1) {
                                                                        $balance_due = $tAmount - ($tmBalance * 1) - $stCredit;
                                                                        $due_date = 'January';
                                                                    } elseif ($tfreq == 2) {
                                                                        $balance_due = $tAmount - ($tmBalance * 0) - $stCredit;
                                                                        $due_date = 'February';
                                                                    } elseif ($tfreq == 3) {
                                                                        $balance_due = $tAmount - ($tmBalance * 0) - $stCredit;
                                                                        $due_date = 'November';
                                                                    } elseif ($tfreq == 4) {
                                                                        $balance_due = $tAmount - ($tmBalance * 0) - $stCredit;
                                                                        $due_date = 'June';
                                                                    } elseif ($tfreq == 5) {
                                                                        $balance_due = $tAmount - ($tmBalance * 2) - $stCredit;
                                                                        $due_date = 'April';
                                                                    }
                                                                    break;
                                                                case '2':
                                                                    if ($tfreq == 1) {
                                                                        $balance_due = $tAmount - ($tmBalance * 0) - $stCredit;
                                                                        $due_date = 'February';
                                                                    } elseif ($tfreq == 2) {
                                                                        $balance_due = $tAmount - ($tmBalance * 0) - $stCredit;
                                                                        $due_date = 'February';
                                                                    } elseif ($tfreq == 3) {
                                                                        $balance_due = $tAmount - ($tmBalance * 0) - $stCredit;
                                                                        $due_date = 'November';
                                                                    } elseif ($tfreq == 4) {
                                                                        $balance_due = $tAmount - ($tmBalance * 0) - $stCredit;
                                                                        $due_date = 'June';
                                                                    } elseif ($tfreq == 5) {
                                                                        $balance_due = $tAmount - ($tmBalance * 2) - $stCredit;
                                                                        $due_date = 'April';
                                                                    }
                                                                    break;
                                                                case '3':
                                                                    if ($tfreq == 1) {
                                                                        $balance_due = $tAmount - ($tmBalance * 0) - $stCredit;
                                                                        $due_date = 'March';
                                                                    } elseif ($tfreq == 2) {
                                                                        $balance_due = $tAmount - ($tmBalance * 0) - $stCredit;
                                                                        $due_date = 'February';
                                                                    } elseif ($tfreq == 3) {
                                                                        $balance_due = $tAmount - ($tmBalance * 0) - $stCredit;
                                                                        $due_date = 'November';
                                                                    } elseif ($tfreq == 4) {
                                                                        $balance_due = $tAmount - ($tmBalance * 0) - $stCredit;
                                                                        $due_date = 'June';
                                                                    } elseif ($tfreq == 5) {
                                                                        $balance_due = $tAmount - ($tmBalance * 2) - $stCredit;
                                                                        $due_date = 'April';
                                                                    }
                                                                    break;
                                                                case '4':
                                                                    if ($tfreq == 1) {
                                                                        $balance_due = $tAmount - ($tmBalance * 0) - $stCredit;
                                                                        $due_date = 'April';
                                                                    } elseif ($tfreq == 2) {
                                                                        $balance_due = $tAmount - ($tmBalance * 0) - $stCredit;
                                                                        $due_date = 'February';
                                                                    } elseif ($tfreq == 3) {
                                                                        $balance_due = $tAmount - ($tmBalance * 0) - $stCredit;
                                                                        $due_date = 'November';
                                                                    } elseif ($tfreq == 4) {
                                                                        $balance_due = $tAmount - ($tmBalance * 0) - $stCredit;
                                                                        $due_date = 'June';
                                                                    } elseif ($tfreq == 5) {
                                                                        $balance_due = $tAmount - ($tmBalance * 1) - $stCredit;
                                                                        $due_date = 'April';
                                                                    }
                                                                    break;
                                                                case '5':
                                                                    if ($tfreq == 1) {
                                                                        $balance_due = $tAmount - ($tmBalance * 0) - $stCredit;
                                                                        $due_date = 'May';
                                                                    } elseif ($tfreq == 2) {
                                                                        $balance_due = $tAmount - ($tmBalance * 0) - $stCredit;
                                                                        $due_date = 'February';
                                                                    } elseif ($tfreq == 3) {
                                                                        $balance_due = $tAmount - ($tmBalance * 0) - $stCredit;
                                                                        $due_date = 'November';
                                                                    } elseif ($tfreq == 4) {
                                                                        $balance_due = $tAmount - ($tmBalance * 0) - $stCredit;
                                                                        $due_date = 'June';
                                                                    } elseif ($tfreq == 5) {
                                                                        $balance_due = $tAmount - ($tmBalance * 0) - $stCredit;
                                                                        $due_date = 'April';
                                                                    }
                                                                    break;
                                                                case '6':
                                                                    if ($tfreq == 1) {
                                                                        $balance_due = $tAmount - ($tmBalance * 8) - $stCredit;
                                                                        $due_date = 'June';
                                                                    } elseif ($tfreq == 2) {
                                                                        $balance_due = $tAmount - ($tmBalance * 3) - $stCredit;
                                                                        $due_date = 'August';
                                                                    } elseif ($tfreq == 3) {
                                                                        $balance_due = $tAmount - ($tmBalance * 1) - $stCredit;
                                                                        $due_date = 'July';
                                                                    } elseif ($tfreq == 4) {
                                                                        $balance_due = $tAmount - ($tmBalance * 0) - $stCredit;
                                                                        $due_date = 'June';
                                                                    } elseif ($tfreq == 5) {
                                                                        $balance_due = $tAmount - ($tmBalance * 2) - $stCredit;
                                                                        $due_date = 'April';
                                                                    }
                                                                    break;
                                                                case '7':
                                                                    if ($tfreq == 1) {
                                                                        $balance_due = $tAmount - ($tmBalance * 7) - $stCredit;
                                                                        $due_date = 'July';
                                                                    } elseif ($tfreq == 2) {
                                                                        $balance_due = $tAmount - ($tmBalance * 3) - $stCredit;
                                                                        $due_date = 'August';
                                                                    } elseif ($tfreq == 3) {
                                                                        $balance_due = $tAmount - ($tmBalance * 1) - $stCredit;
                                                                        $due_date = 'July';
                                                                    } elseif ($tfreq == 4) {
                                                                        $balance_due = $tAmount - ($tmBalance * 0) - $stCredit;
                                                                        $due_date = 'June';
                                                                    } elseif ($tfreq == 5) {
                                                                        $balance_due = $tAmount - ($tmBalance * 2) - $stCredit;
                                                                        $due_date = 'April';
                                                                    }
                                                                    break;
                                                                case '8':
                                                                    if ($tfreq == 1) {
                                                                        $balance_due = $tAmount - ($tmBalance * 6) - $stCredit;
                                                                        $due_date = 'August';
                                                                    } elseif ($tfreq == 2) {
                                                                        $balance_due = $tAmount - ($tmBalance * 3) - $stCredit;
                                                                        $due_date = 'August';
                                                                    } elseif ($tfreq == 3) {
                                                                        $balance_due = $tAmount - ($tmBalance * 1) - $stCredit;
                                                                        $due_date = 'July';
                                                                    } elseif ($tfreq == 4) {
                                                                        $balance_due = $tAmount - ($tmBalance * 0) - $stCredit;
                                                                        $due_date = 'June';
                                                                    } elseif ($tfreq == 5) {
                                                                        $balance_due = $tAmount - ($tmBalance * 2) - $stCredit;
                                                                        $due_date = 'April';
                                                                    }
                                                                    break;
                                                                case '9':
                                                                    if ($tfreq == 1) {
                                                                        $balance_due = $tAmount - ($tmBalance * 5) - $stCredit;
                                                                        $due_date = 'September';
                                                                    } elseif ($tfreq == 2) {
                                                                        $balance_due = $tAmount - ($tmBalance * 2) - $stCredit;
                                                                        $due_date = 'October';
                                                                    } elseif ($tfreq == 3) {
                                                                        $balance_due = $tAmount - ($tmBalance * 1) - $stCredit;
                                                                        $due_date = 'July';
                                                                    } elseif ($tfreq == 4) {
                                                                        $balance_due = $tAmount - ($tmBalance * 0) - $stCredit;
                                                                        $due_date = 'June';
                                                                    } elseif ($tfreq == 5) {
                                                                        $balance_due = $tAmount - ($tmBalance * 2) - $stCredit;
                                                                        $due_date = 'April';
                                                                    }
                                                                    break;
                                                                case '10':
                                                                    if ($tfreq == 1) {
                                                                        $balance_due = $tAmount - ($tmBalance * 4) - $stCredit;
                                                                        $due_date = 'October';
                                                                    } elseif ($tfreq == 2) {
                                                                        $balance_due = $tAmount - ($tmBalance * 2) - $stCredit;
                                                                        $due_date = 'October';
                                                                    } elseif ($tfreq == 3) {
                                                                        $balance_due = $tAmount - ($tmBalance * 1) - $stCredit;
                                                                        $due_date = 'July';
                                                                    } elseif ($tfreq == 4) {
                                                                        $balance_due = $tAmount - ($tmBalance * 0) - $stCredit;
                                                                        $due_date = 'June';
                                                                    } elseif ($tfreq == 5) {
                                                                        $balance_due = $tAmount - ($tmBalance * 2) - $stCredit;
                                                                        $due_date = 'April';
                                                                    }
                                                                    break;
                                                                case '11':
                                                                    if ($tfreq == 1) {
                                                                        $balance_due = $tAmount - ($tmBalance * 3) - $stCredit;
                                                                        $due_date = 'November';
                                                                    } elseif ($tfreq == 2) {
                                                                        $balance_due = $tAmount - ($tmBalance * 1) - $stCredit;
                                                                        $due_date = 'December';
                                                                    } elseif ($tfreq == 3) {
                                                                        $balance_due = $tAmount - ($tmBalance * 0) - $stCredit;
                                                                        $due_date = 'November';
                                                                    } elseif ($tfreq == 4) {
                                                                        $balance_due = $tAmount - ($tmBalance * 0) - $stCredit;
                                                                        $due_date = 'June';
                                                                    } elseif ($tfreq == 5) {
                                                                        $balance_due = $tAmount - ($tmBalance * 2) - $stCredit;
                                                                        $due_date = 'April';
                                                                    }
                                                                    break;
                                                                case '12':
                                                                    if ($tfreq == 1) {
                                                                        $balance_due = $tAmount - ($tmBalance * 2) - $stCredit;
                                                                        $due_date = 'December';
                                                                    } elseif ($tfreq == 2) {
                                                                        $balance_due = $tAmount - ($tmBalance * 1) - $stCredit;
                                                                        $due_date = 'December';
                                                                    } elseif ($tfreq == 3) {
                                                                        $balance_due = $tAmount - ($tmBalance * 0) - $stCredit;
                                                                        $due_date = 'November';
                                                                    } elseif ($tfreq == 4) {
                                                                        $balance_due = $tAmount - ($tmBalance * 0) - $stCredit;
                                                                        $due_date = 'June';
                                                                    } elseif ($tfreq == 5) {
                                                                        $balance_due = $tAmount - ($tmBalance * 2) - $stCredit;
                                                                        $due_date = 'April';
                                                                    }
                                                                    break;
                                                                default:
                                                                    $balance_due = $stBalance;
                                                                    break;
                                                            }
                                                            $tbalance_due = $tbalance_due + $balance_due;
                                                            $ar_balance[$cID] = $balance_due;
                                                            ?>

                                                            <input type="hidden" name="bDue<?php echo $itm ?>" id="bDue<?php echo $itm ?>" value="<?php echo number_format($balance_due, 2, ".", ",") ?>" required>

                                                        <?php
                                                        }
                                                    }
                                                }
                                                // print_r($show_extra) ;                 
                                                foreach ($show_extra as $i_soa) {
                                                    if ($i_soa->total_charge != 0 && $i_soa->sy_id) {
                                                        $ar += 1;
                                                        $cID += 1;
                                                        $ar_index = $ar - 1;
                                                        $itms = $i_soa->item_id;
                                                        $ar_itemChoice[$itms] = $i_soa->item_description;
                                                        ?>
                                                        <input type="hidden" name="item<?php echo $itms ?>" id="item<?php echo $itms ?>" value="<?php echo $i_soa->item_description ?>" required>
                                                        <?php
                                                        $tot_credit = $i_soa->total_credit;
                                                        $tot_charge = $i_soa->total_charge;
                                                        $total_balance = $tot_charge - $tot_credit;
                                                        ?>

                                                        <input type="hidden" name="bDue<?php echo $itms ?>" id="bDue<?php echo $itms ?>" value="<?php echo number_format($total_balance, 2, ".", ",") ?>" required>

                                                        <?php
                                                        $tbalance_due = $tbalance_due + $total_balance;
                                                    }
                                                }
                                                ?>

                                                <input type="hidden" name="balance_due" id="balance_due" value="<?php echo number_format($tbalance_due, 2, ".", ",") ?>" required>
                                                <input type="hidden" name="pointID" id="pointID" value="<?php echo $cID ?>" required>

                                                <!-- count end -->
                                                <a href="<?php echo base_url() ?>financemanagement/s8347h/<?php echo base64_encode($searched_student->st_id) ?>/<?php echo base64_encode($use_sy) ?>"><img alt="<?php echo $searched_student->lastname . ", " . $searched_student->firstname; ?> image not available." src="<?php echo base_url() ?>uploads/<?php echo $avatari; ?>" style="left: 5px; height:65px; border:solid white; z-index:5; position: relative; margin-top: -27px; -webkit-box-shadow: 0px 1px 10px rgba(0, 0, 0, 0.3); -moz-box-shadow: 0px 1px 10px rgba(0, 0, 0, 0.3); box-shadow: 0 1px 10px rgba(0, 0, 0, 0.3);"  class="img-circle"/></a>

                                            </div>
                                            <div class="col-xs-11 col-md-11">

                                                <h5 style="color:black; margin: 0 0 0 0px;"><b>Name: </b>&nbsp;<span style="color:#BB0000;"><b><?php echo $searched_student->lastname . ", " . $searched_student->firstname; ?></b></span>&nbsp;&nbsp;<b>Student ID:</b> &nbsp;<span style="color:#BB0000;"><b><?php echo $searched_student->st_id; ?></b></span>&nbsp;&nbsp;<b>Grade Level:</b> &nbsp;<span style="color:#BB0000;"><b><?php echo $searched_student->level; ?></b>&nbsp;&nbsp;</span></h5>
                                                <h5 style="color:black; margin: 0 0 0 0px;"><span style="color:black; margin: 0 0 0 0px;"><b>Payment Plan: </b>&nbsp;<span style="color:blue;" id="planName"><b><?php echo $splan_desc; ?></b></span></h5>
                                            </div>                
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-12">
                                <div class="panel panel-default ">
                                    <div class="panel-heading">
                                        <div class="row" style="font-size:11px;">
                                            <div class="col-xs-3">
                                                <i class="fa fa-cube fa-fw"></i><b>&nbsp;Total Charge:</b><b style="color:green;">&nbsp;&nbsp;PhP &nbsp;<span id="ltcharge" style="color:green;"></span></b><br />
                                            </div>
                                            <div class="col-xs-3">
                                                <i class="fa fa-bar-chart fa-fw"></i><b>&nbsp;Total Credit:</b><b style="color:green;">&nbsp;&nbsp;PhP &nbsp;<span id="ltcredit" style="color:green;"></span></b><br />
                                            </div>
                                            <div class="col-xs-3">
                                                <i class="fa fa-pie-chart fa-fw"></i><b>&nbsp;Total Balance:</b><b style="color:green;">&nbsp;&nbsp;PhP &nbsp;<span id="ltbalance" style="color:green;"></span></b><br />
                                            </div>
                                            <div class="col-xs-3">
                                                <i class="fa fa-area-chart fa-fw"></i><b>&nbsp;Balance Due:</b><b style="color:green;">&nbsp;&nbsp;PhP &nbsp;<span id="ltbalance_due" style="color:green;"></span></b>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- col-lg-3 col-md-3 pull-right -->
                            <div>
                                <input type="hidden" name="htcharge" id="htcharge" value="<?php echo number_format($tcharge, 2, ".", ",") ?>" required>
                                <input type="hidden" name="htcredit" id="htcredit" value="<?php echo number_format($tcredit, 2, ".", ",") ?>" required>
                                <input type="hidden" name="htbalance" id="htbalance" value="<?php echo number_format($tbalance, 2, ".", ",") ?>" required>              
                                <input type="hidden" name="act_id" id="act_id" value="<?php echo base64_encode($stud_id); ?>" required>     
                            </div>
                        </div>	

<?php } ?> 

                    <div class="row" id="act_no_exist">
                        <div class="col-xs-12 col-md-12">
                            <div class="panel panel-info" style="margin-bottom: 2px;">
                                <div class="panel-heading" style="height: 50px;">
                                    <div class="row">
                                        <div class="col-xs-12 col-md-12 text-left">
                                            <span><b>Account Description </b>&nbsp;<input name="acct_desc" id="acct_desc" required><i style="color:red;font-size: 11px;">&nbsp;&nbsp;"<b>Note:</b>&nbsp;Do not use this option to record student's payments. Search for the account name instead."</i> </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row" id="act_details">
                        <div class="col-xs-8 col-md-8 text-center">
                            <div class="panel panel-default" style="margin-bottom: 0px;">
                                <div class="panel-body bg-info" style="padding-top: 0px;">
                                    <div class="col-xs-4">
                                        <h5 style="margin-bottom: 0px;"><b>Referrence #</b></h5>
                                        <input class="text-center" style="color: black; width: 100%;" name="ptRefNum" id="ptRefNum" required>
                                    </div>
                                    <div class="col-xs-4">
                                        <h5 style="margin-bottom: 0px;"><b>Transaction Date</b></h5>
                                        <input name="at_tdate" style="color: black; width: 80%;" type="text" data-date-format="mm-dd-yyyy" id="at_tdate" placeholder="Transaction Date" required>
                                        <button class="btn btn-default" id="calend"  style="font-size: 8px; width: 20%; margin-left: -4px; height: 26px; margin-top: -2px;" onclick="$('#at_tdate').focus()" type="button"><i class="fa fa-calendar fa-lg"></i></button>
                                    </div>
                                    <div class="col-xs-4">
                                        <h5 style="margin-bottom: 0px;"><b>Remarks</b></h5>
                                        <input class="text-center" style="color: black; width: 100%;" name="ptRemarks" id="ptRemarks"  required>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <table id="item_table" class="table table-condensed table-bordered">
                                        <thead class="bg-default">
                                        <th class="text-center">Item Description</th>
                                        <th class="text-center">Amount</th>
                                        <th class="text-center">Action</th>
                                        </thead>
                                    </table>
                                </div>
                            </div>			                			
                        </div>
                        <div class="col-xs-4 col-md-4 text-center">
                            <div class="panel panel-default">
                                <div class="panel-body bg-primary text-center">
                                    <button type="button" class="btn btn-info" id="add_items" style="width: 100%; height: 40px;"><i class="fa fa-plus fa-lg fa-fw"></i><b>Add Items</b></button>
                                    <h4>T O T A L</h4>
                                    <input class="text-center" style="font-size: 25px; font-weight: bold; color: red; width: 100%;" name="pttAmount" id="pttAmount" disabled>
                                    <h4>Amount Tendered</h4>
                                    <input class="text-center" style="font-size: 25px; font-weight: bold; color: green; width: 100%;" name="ptAmountTendered" id="ptAmountTendered" onblur="cash_change()" required>
                                    <h4>C H A N G E</h4>
                                    <input class="text-center" style="font-size: 25px; font-weight: bold; color: blue; width: 100%;" name="ptChange" id="ptChange" disabled>
                                    <div class="row">
                                        <div class="col-xs-12 col-md-12" style="margin-top: 20px;">
                                            <button type="button" class="btn btn-success" id="paynow" style="width: 100%; height: 60px;"><i class="fa fa-thumbs-up fa-lg fa-fw"></i><b>PAY NOW!!!</b></button>
                                            <button type="button" class="btn btn-danger" id="cancel_trans" style="width: 100%; height: 40px; margin-top: 10px;"><b><i class="fa fa-times fa-lg fa-fw"></i>C A N C E L</b></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>   <!-- class="col-xs-4 col-md-4 text-center" -->
                    </div>

                </div> <!-- panel-body -->
                <div class="panel-footer">
                    <div class="row">
                        <div class="col-md-7">
                            <a href="<?php echo base_url() ?>main/dashboard/" class="pull-left"><i class="fa fa-home fa-fw"></i>HOME</a><a href="<?php echo base_url() ?>financemanagement/actz/" style="margin-left: 10px;"><i class="fa fa-users fa-fw"></i>Accounts</a><a href="<?php echo base_url() ?>financemanagement/details/" style="margin-left: 10px;"><i class="fa fa-money fa-fw"></i>Sales of the day</a>
                            <a href="<?php echo base_url() ?>financemanagement/report/" style="margin-left: 10px;"><i class="fa fa-line-chart fa-fw"></i>Expected Total collections per Level</a>
                        </div>

                        <div class="col-md-5">
                            <span class="pull-right"><i class="fa fa-copyright fa-fw" style="font-size: 10px; color: gray;"></i><i style="font-size: 10px; color: gray;">copyright e-sKwela plus v3.1 series 2014</i></span>
                        </div>
                    </div>
                </div>
                <div id="hidden_form" class="hidden">
                    <form id="saveTransaction" action="" method="post">
                        <div class="control-group">
                            <div class="controls">

                                <?php
                                $usrCode = substr($userid, 0, 3);
                                // $usrCode = $userid;
                                $sysRef = date("ymdHis") . "-" . $usrCode;
                                $tdate = date("F d, Y");
                                ?>        

                                <input type="hidden" name="sysGenRef" id="sysGenRef" value="<?php echo base64_encode($sysRef) ?>" required>
                                <input type="hidden" name="ptreferrence" id="ptreferrence" required>  
                                <input type="hidden" name="studIDz" id="studIDz" value="<?php echo $searched_student->st_id; ?>" required> 
                                <input type="hidden" name="studID" id="studID" required> 
                                <!-- <input type="hidden" name="tDate" id="tDate" value="<?php echo $tdate ?>" required> -->
                                <input type="hidden" name="tDate" id="tDate"  required>
                                <input type="hidden" name="userID" id="userID" value="<?php echo $userid ?>" required>
                                <input type="hidden" name="scharge" id="scharge" value="0" required>
                                <input type="hidden" name="scredit" id="scredit" required> 
                                <input type="hidden" name="ptRemark" id="ptRemark" required> 
                                <input type="hidden" name="lastEntry" id="lastEntry" value="" required> 
                                <input type="hidden" name="sy_id" id="sy_id" value="<?php echo $default_sy ?>" required> 
                            </div>
                            <div name="trans_details" id="trans_details">  <!-- detail container -->
                              <!-- <input type="hidden" name="transID" id="transID" required>      -->
                            </div>
                        </div>
                    </form>       	     			
                </div>
            </div>
        </div>	
    </div>
</div>

<!-- Modals -->

<div id="confirm_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header bg-default text-center">
                <button type="button" class="close"  style="margin-top: -10px;" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            </div>
            <div class="modal-body">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <h3 class="panel-title">Confirm Payment</h3>
                    </div>
                    <div class="panel-body">
                        <span>Do you want to submit this transaction?</span>
                    </div>
                    <div class="panel-footer">
                        <button type="button" class="btn btn-success pull-right" id="yes_submit" style="width: 50%; height: 60px;"><b><i class="fa fa-check fa-fw"></i>yes</b></button>
                        <button type="button" class="btn btn-danger pull-right" data-dismiss="modal" style="width: 50%; height: 60px;"><b><i class="fa fa-times fa-fw"></i>no</b></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="cancel_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header bg-default text-center">
                <button type="button" class="close"  style="margin-top: -10px;" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            </div>
            <div class="modal-body">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <h3 class="panel-title">Cancel Transaction</h3>
                    </div>
                    <div class="panel-body">
                        <span>No data will be saved if you continue. Do you want to cancel this transaction? </span>
                    </div>
                    <div class="panel-footer">
                        <button type="button" class="btn btn-success pull-right" id="yes_cancel" style="width: 50%; height: 60px;"><b><i class="fa fa-check fa-fw"></i>yes</b></button>
                        <button type="button" class="btn btn-danger pull-right" data-dismiss="modal" style="width: 50%; height: 60px;"><b><i class="fa fa-times fa-fw"></i>no</b></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="item_picker" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header bg-default text-center">
                <button type="button" class="close"  style="margin-top: -10px;" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <!-- <h3 class="modal-title" id="myModalLabel">Item Picker</h3> -->
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 col-xs-12">
                        <!-- <h3 style="margin-top: 15px;">Select an Item</h3> -->
                        <div id="pick_item_div" >
                            <select class="pull-right" tabindex="-1" id="pick_item" name="pick_item" style="width: 100%; font-size: 17px; margin-bottom: 15px;">
                                <!-- <option id="select_default" selected="selected">Select an Item</option> -->
                                <option></option>

                                <?php
                                $item_count = 1;
                                foreach ($ar_itemChoice as $key => $value) {
                                    echo '<option value="' . $key . '">' . $value . '</option>';
                                    $item_count++;
                                }
                                ?>

                            </select>
                        </div>
                        <div id="pick_item_non" >
                            <select class="pull-right" tabindex="-1" id="pick_item_noa" name="pick_item_noa" style="width: 100%; font-size: 17px; margin-bottom: 15px;">
                                <!-- <option id="select_default" selected="selected">Select an Item</option> -->
                                <option></option>

                                <?php
                                $item_count = 1;
                                foreach ($showItems as $all_items) {
                                    echo '<option value="' . $all_items->item_id . '">' . $all_items->item_description . '</option>';
                                    $item_count++;
                                }
                                ?>

                            </select>

                            <?php
                            foreach ($showItems as $all_items) {
                                ?>

                                <input type="hidden" name="no_item<?php echo $all_items->item_id ?>" id="no_item<?php echo $all_items->item_id ?>" value="<?php echo $all_items->item_description ?>"  required>

                                <?php
                            }
                            ?>
                        </div>	 
                        <!-- <h3>Amount</h3> -->
                        <input type="hidden" name="last_item_number" id="last_item_number" value="<?php echo $item_count; ?>" required>
                        <input type="hidden" name="hide_id" id="hide_id"  required>
                        <input type="hidden" name="trans_ident" id="trans_ident"  required>
                        <input type="hidden" name="rec_amount" id="rec_amount"  required>
                        <input class="text-center" style="font-size: 24px; color: red; width: 100%; height: 55px;" name="input_amount" id="input_amount" required>
                        <div class="row" style="margin-top: 15px;">
                            <div class="col-md-9 col-xs-9" style="padding-right: 0px; margin-right: -18px;">
                                <div class="col-md-12 col-xs-12" style="padding: 0px; width: 90%;">
                                    <div class="col-md-4 col-xs-4 calcbuts">
                                        <button  type="button" class="btn btn-primary calci" id="b7" style="width: 100%; height: 100%;"><b>7</b></button>
                                    </div>
                                    <div class="col-md-4 col-xs-4 calcbuts">
                                        <button  type="button" class="btn btn-primary calci"  id="b8"style="width: 100%; height: 100%;"><b>8</b></button>
                                    </div>
                                    <div class="col-md-4 col-xs-4 calcbuts">
                                        <button  type="button" class="btn btn-primary calci"  id="b9" style="width: 100%; height: 100%;"><b>9</b></button>
                                    </div>
                                </div>
                                <div class="col-md-12 col-xs-12" style="padding: 0px; width: 90%;">
                                    <div class="col-md-4 col-xs-4 calcbuts">
                                        <button  type="button" class="btn btn-primary calci"  id="b4" style="width: 100%; height: 100%;"><b>4</b></button>
                                    </div>
                                    <div class="col-md-4 col-xs-4 calcbuts">
                                        <button  type="button" class="btn btn-primary calci"  id="b5" style="width: 100%; height: 100%;"><b>5</b></button>
                                    </div>
                                    <div class="col-md-4 col-xs-4 calcbuts">
                                        <button  type="button" class="btn btn-primary calci"  id="b6" style="width: 100%; height: 100%;"><b>6</b></button>
                                    </div>
                                </div>
                                <div class="col-md-12 col-xs-12" style="padding: 0px; width: 90%;">
                                    <div class="col-md-4 col-xs-4 calcbuts">
                                        <button  type="button" class="btn btn-primary calci"  id="b1" style="width: 100%; height: 100%;"><b>1</b></button>
                                    </div>
                                    <div class="col-md-4 col-xs-4 calcbuts">
                                        <button  type="button" class="btn btn-primary calci"  id="b2" style="width: 100%; height: 100%;"><b>2</b></button>
                                    </div>
                                    <div class="col-md-4 col-xs-4 calcbuts">
                                        <button  type="button" class="btn btn-primary calci"  id="b3" style="width: 100%; height: 100%;"><b>3</b></button>
                                    </div>
                                </div>
                                <div class="col-md-12 col-xs-12" style="padding: 0px; width: 90%;">
                                    <div class="col-md-4 col-xs-4 calcbuts">
                                        <button  type="button" class="btn btn-primary calci"  id="bdot" style="width: 100%; height: 100%;"><b>.</b></button>
                                    </div>
                                    <div class="col-md-4 col-xs-4 calcbuts">
                                        <button  type="button" class="btn btn-primary calci"  id="b0" style="width: 100%; height: 100%;"><b>0</b></button>
                                    </div>
                                    <div class="col-md-4 col-xs-4 calcbuts">
                                        <button  type="button" class="btn btn-primary calci"  id="b00" style="width: 100%; height: 100%;"><b>00</b></button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-xs-3" style="padding-left: 0px;">
                                <div class="col-md-12 col-xs-12 caclbutsi">
                                    <button type="button" class="btn btn-primary" id="delentry" style="width: 100%; height: 60px;"><b><i class="fa fa-angle-double-left fa-fw"></i>Back</b></button>
                                    <button type="button" class="btn btn-success" id="add_item_btn" style="width: 100%; height: 120px;"><b>Add<br />Item<br />to<br />list</br /><i class="fa fa-list-alt fa-fw"></i></b></button>
                                    <button type="button" data-dismiss="modal" class="btn btn-danger" style="width: 100%; height: 60px;"><b>Cancel</b></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>	  		
            </div>
        </div>
    </div> 
</div>

<div id="tend_picker" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header bg-default text-center">
                <button type="button" class="close"  style="margin-top: -10px;" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <!-- <h3 class="modal-title" id="myModalLabel">Item Picker</h3> -->
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 col-xs-12">
                        <h3 style="margin-top: 15px;">Enter Tendered Amount</h3>

                        <!-- <h3>Amount</h3> -->
                        <input class="text-center" tabindex="-1" style="font-size: 24px; color: red; width: 100%; height: 55px;" name="tendered_amount" id="tendered_amount" required>
                        <div class="row" style="margin-top: 15px;">
                            <div class="col-md-9 col-xs-9" style="padding-right: 0px; margin-right: -18px;">
                                <div class="col-md-12 col-xs-12" style="padding: 0px; width: 90%;">
                                    <div class="col-md-4 col-xs-4 calcbuts">
                                        <button  type="button" class="btn btn-primary calcit" id="b7" style="width: 100%; height: 100%;"><b>7</b></button>
                                    </div>
                                    <div class="col-md-4 col-xs-4 calcbuts">
                                        <button  type="button" class="btn btn-primary calcit"  id="b8"style="width: 100%; height: 100%;"><b>8</b></button>
                                    </div>
                                    <div class="col-md-4 col-xs-4 calcbuts">
                                        <button  type="button" class="btn btn-primary calcit"  id="b9" style="width: 100%; height: 100%;"><b>9</b></button>
                                    </div>
                                </div>
                                <div class="col-md-12 col-xs-12" style="padding: 0px; width: 90%;">
                                    <div class="col-md-4 col-xs-4 calcbuts">
                                        <button  type="button" class="btn btn-primary calcit"  id="b4" style="width: 100%; height: 100%;"><b>4</b></button>
                                    </div>
                                    <div class="col-md-4 col-xs-4 calcbuts">
                                        <button  type="button" class="btn btn-primary calcit"  id="b5" style="width: 100%; height: 100%;"><b>5</b></button>
                                    </div>
                                    <div class="col-md-4 col-xs-4 calcbuts">
                                        <button  type="button" class="btn btn-primary calcit"  id="b6" style="width: 100%; height: 100%;"><b>6</b></button>
                                    </div>
                                </div>
                                <div class="col-md-12 col-xs-12" style="padding: 0px; width: 90%;">
                                    <div class="col-md-4 col-xs-4 calcbuts">
                                        <button  type="button" class="btn btn-primary calcit"  id="b1" style="width: 100%; height: 100%;"><b>1</b></button>
                                    </div>
                                    <div class="col-md-4 col-xs-4 calcbuts">
                                        <button  type="button" class="btn btn-primary calcit"  id="b2" style="width: 100%; height: 100%;"><b>2</b></button>
                                    </div>
                                    <div class="col-md-4 col-xs-4 calcbuts">
                                        <button  type="button" class="btn btn-primary calcit"  id="b3" style="width: 100%; height: 100%;"><b>3</b></button>
                                    </div>
                                </div>
                                <div class="col-md-12 col-xs-12" style="padding: 0px; width: 90%;">
                                    <div class="col-md-4 col-xs-4 calcbuts">
                                        <button  type="button" class="btn btn-primary calcit"  id="bdot" style="width: 100%; height: 100%;"><b>.</b></button>
                                    </div>
                                    <div class="col-md-4 col-xs-4 calcbuts">
                                        <button  type="button" class="btn btn-primary calcit"  id="b0" style="width: 100%; height: 100%;"><b>0</b></button>
                                    </div>
                                    <div class="col-md-4 col-xs-4 calcbuts">
                                        <button  type="button" class="btn btn-primary calcit"  id="b00" style="width: 100%; height: 100%;"><b>00</b></button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-xs-3" style="padding-left: 0px;">
                                <div class="col-md-12 col-xs-12 caclbutsi">
                                    <button type="button" class="btn btn-primary" id="delentryi" style="width: 100%; height: 60px;"><b><i class="fa fa-angle-double-left fa-fw"></i>Back</b></button>
                                    <button type="button" class="btn btn-success" id="add_tender" style="width: 100%; height: 120px;"><b>Add<br />Amount</br /><i class="fa fa-list-alt fa-fw"></i></b></button>
                                    <button type="button" data-dismiss="modal" class="btn btn-danger" style="width: 100%; height: 60px;"><b>Cancel</b></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>	  		
            </div>
        </div>
    </div> 
</div>

<!-- End Modals -->


<?php if ($this->uri->segment(3) != '') { ?>

    <script type="text/javascript">
        $(document).ready(function () {
            $("#searchingStudents").select2();
            $("#pick_item").select2();
            $("#pick_item_noa").select2();
            $('#at_tdate').datepicker();
            $("#act_no_exist").css('display', 'none');
            $("#pick_item_div").css('display', 'block');
            $("#pick_item_non").css('display', 'none');

            var jtcharge = document.getElementById("htcharge").value;
            var jtcredit = document.getElementById("htcredit").value;
            var jtbalance = document.getElementById("htbalance").value;
            var jtbalance_due = document.getElementById("balance_due").value;
            var jact_id = document.getElementById("act_id").value;
            // document.getElementById('lact_id').innerHTML = jact_id;
            document.getElementById('ltcharge').innerHTML = jtcharge;
            document.getElementById('ltcredit').innerHTML = jtcredit;
            document.getElementById('ltbalance').innerHTML = jtbalance;
            document.getElementById('ltbalance_due').innerHTML = jtbalance_due;
            document.getElementById('no_account').value = 'no';
        });

    </script>

<?php } else { ?>

    <script type="text/javascript">
        $(document).ready(function () {
            $("#searchingStudents").select2();
            $("#pick_item_noa").select2();
            $("#pick_item").select2();
            $('#at_tdate').datepicker();
            $("#act_no_exist").css('display', 'none');
            $("#act_details").css('display', 'none');
            $("#pick_item_div").css('display', 'none');
            $("#pick_item_non").css('display', 'block');
            document.getElementById('no_account').value = 'yes';
        });

    </script>

<?php } ?>

<script type="text/javascript">

    function getStudent()
    {
        var uid = document.getElementById("searchingStudents").value;
        var yr = document.getElementById("default_sy").value;
        var voptions = 'Search by Family Name'
        var nea_option = 'NEA'
        if (uid == voptions) {
            document.getElementById('no_account').value = 'no';
            $("#pick_item_div").css('display', 'block');
            $("#pick_item_non").css('display', 'none');
        } else if (uid == nea_option) {
            document.getElementById('no_account').value = 'yes';
            $("#act_exist").css('display', 'none');
            $("#act_no_exist").css('display', 'block');
            $("#act_details").css('display', 'block');
            $("#pick_item_div").css('display', 'none');
            $("#pick_item_non").css('display', 'block');
        } else {
            document.getElementById('no_account').value = 'no';
            $("#pick_item_div").css('display', 'block');
            $("#pick_item_non").css('display', 'none');
            document.location = '<?php echo base_url() ?>financemanagement/pos/' + uid + '/' + yr;
        }
    }

    $("#yes_submit").click(function ()
    {
        var act = document.getElementById('no_account').value;

        var url1 = "<?php echo base_url() . 'financemanagement/saveTransaction' ?>"; // the script where you handle the form input.
        var url2 = "<?php echo base_url() . 'financemanagement/print_to_or' ?>";
        var finRefNum = document.getElementById("ptRefNum").value;
        document.getElementById("ptreferrence").value = finRefNum;
        var fintAmount = document.getElementById("pttAmount").value;
        fintAmount = string2number(fintAmount);
        // var finDiscount = document.getElementById("ptDiscount").value; 
        var finDiscount = 0;
        var finRemarks = document.getElementById('ptRemarks').value;
        if (finDiscount == "" || finDiscount == 0)
        {
        } else {
            finRemarks = 'Discounted with (PhP ' + finDiscount + ') ' + finRemarks;
            finDiscount = string2number(finDiscount);
            // alert(finDiscount);
            finCredit = fintAmount + finDiscount;
            finDiscount = number2string(finDiscount);
            document.getElementById('ptRemark').value = finRemarks;
        }

        document.getElementById("scredit").value = fintAmount;
        if (act == 'yes') {
            document.getElementById('studID').value = "NEUTRAL_ACCOUNT";
            var act_now = document.getElementById('acct_desc').value;
            finRemarks = '[Neutral Account: ' + act_now + ' ]' + finRemarks;
            document.getElementById('ptRemark').value = finRemarks;
        } else if (act == 'no') {
            var studz = document.getElementById('studIDz').value;
            document.getElementById('studID').value = studz;
            document.getElementById('ptRemark').value = finRemarks;
        }
        var uid = document.getElementById("searchingStudents").value;
        var finPointer = document.getElementById("lastEntry").value;
        var lastItemkey = document.getElementById("last_item_number").value;
        for (dcounter = 1; dcounter <= finPointer; dcounter++) {
            var nifAmount = 'pbdue' + dcounter;
            var finAmount = document.getElementById(nifAmount).innerHTML;
            finAmount = finAmount.slice(4);
            finAmount = string2number(finAmount);
            // alert(finAmount);
            var detail_container = document.getElementById('trans_details');

            var lEntry = document.createElement('input');
            lEntry.type = 'hidden';
            lEntry.name = 'endEntry';
            lEntry.value = finPointer;
            detail_container.appendChild(lEntry);

            var transInfo = document.createElement('input');
            transInfo.type = 'hidden';
            transInfo.name = 'trans_iden'
            transInfo.id = 'trans_iden'
            transInfo.value = document.getElementById('sysGenRef').value;
            detail_container.appendChild(transInfo);
            var trans_num = document.getElementById('sysGenRef').value;

            var amountInput = document.createElement('input');
            amountInput.type = 'hidden';
            amountInput.name = 'dAmount' + dcounter;
            amountInput.id = 'dAmount' + dcounter;
            amountInput.value = finAmount;
            detail_container.appendChild(amountInput);

            var nifItem = 'pItem' + dcounter;
            var finItem = document.getElementById(nifItem).innerHTML;

            var nifID = 'hidid' + dcounter;
            var finItemID = document.getElementById(nifID).value;
            var itemInput = document.createElement('input');
            itemInput.type = 'hidden';
            itemInput.name = 'itemID' + dcounter;
            itemInput.id = 'itemID' + dcounter;
            itemInput.value = finItemID;
            detail_container.appendChild(itemInput);

            var edit_date = document.getElementById('at_tdate').value;
            document.getElementById('tDate').value = edit_date;
            var chargeCredit = document.createElement('input');
            chargeCredit.type = 'hidden';
            chargeCredit.name = 'scharge_credit' + dcounter;
            chargeCredit.id = 'scharge_credit' + dcounter;
            chargeCredit.value = 1;
            detail_container.appendChild(chargeCredit);
        }

        var studz = document.getElementById('act_id').value;
        var d_sy = document.getElementById('default_sy').value;

        $.ajax({
            type: "POST",
            url: url1,
            data: $("#saveTransaction").serialize()+'&csrf_test_name='+$.cookie('csrf_cookie_name'),
            success: function (data) {
                document.location = '<?php echo base_url() ?>financemanagement/pay_confirm/' + trans_num + '/' + d_sy + '/' + studz;
                alert('Transaction Succesfully submitted.');
                // location.reload();

            }
        });

        // alert("Success!!! Transaction already submitted.");
        // document.location = '<?php echo base_url() ?>financemanagement/s8347h/'+studz+'/';
    });

    function go_home()
    {
        document.location = '<?php echo base_url() ?>main/dashboard/';
    }

    function cash_change()
    {
        var item_amount = document.getElementById("pttAmount").value;
        if (item_amount != '') {
            var con_amount = string2number(item_amount);
        } else {
            var con_amount = 0;
        }
        var tend_amount = document.getElementById('ptAmountTendered').value;
        var con_tendered = string2number(tend_amount);

        calc_change = con_tendered - con_amount;
        tot_change = number2string(calc_change);
        document.getElementById('ptChange').value = tot_change;

    }

    $("#cancel_trans").click(function () {
        $("#cancel_modal").modal();
    });

    $("#yes_cancel").click(function () {
        document.location = '<?php echo base_url() ?>financemanagement/pos/';
    });

    var i = 1;
    var totAmount = 0;
    $("#add_item_btn").click(function () {
        var prcs = document.getElementById('trans_ident').value;
        var no_a = document.getElementById('no_account').value;
        if (prcs == 'add') {
            var tm = document.getElementById("input_amount").value;
            var hdn_id = document.getElementById("hide_id").value;
            if (tm == "") {
                alert('Please enter an amount to be allocated for this item.');
            } else {
                if (no_a == 'yes') {
                    var item_index = document.getElementById("pick_item_noa").value;
                    var point_item_desc = 'no_item' + item_index;
                } else if (no_a == 'no') {
                    var item_index = document.getElementById("pick_item").value;
                    var point_item_desc = 'item' + item_index;
                }
                var item_amount = document.getElementById("input_amount").value;
                var item_desc = document.getElementById(point_item_desc).value;
                var tend_amount = document.getElementById('ptAmountTendered').value;
                var con_amount = string2number(item_amount);
                totAmount = con_amount + totAmount;
                var totAmount_display = number2string(totAmount);

                if (tend_amount != "") {
                    con_tendered = string2number(tend_amount);
                    con_tendered = con_tendered - totAmount;
                    var calc_change = number2string(con_tendered);
                    document.getElementById('ptChange').value = calc_change;
                }

                document.getElementById('pttAmount').value = totAmount_display;

                // transfer items to table

                var tbl = document.getElementById("item_table");
                var lastRow = tbl.rows.length; // gets the table's last index
                var iteration = lastRow - 1;
                var row = tbl.insertRow(lastRow);
                row.id = 'row' + i;
                trow = row.id;

                // item column

                var itemCell = row.insertCell(0);
                itemCell.id = 'pItem' + i;
                itemCell.style = 'text-align:center;';
                itemCell.innerHTML = item_desc;

                // balance column

                var bdueCell = row.insertCell(1);
                bdueCell.id = 'pbdue' + i;
                bdueCell.style = 'text-align:center; font-size: 14px; font-weight: bold;';
                bdueCell.innerHTML = 'PhP ' + item_amount;

                // buttons column

                var buttonCell = row.insertCell(2);
                var delButton = document.createElement("button");
                delButton.type = 'button';
                delButton.innerHTML = '<i class="fa fa-trash fa-lg"></i>';
                delButton.className = 'btn btn-danger btn-xs btn-delBtn';
                delButton.id = 'delBtn' + i;
                buttonCell.appendChild(delButton);
                var editButton = document.createElement("button");
                editButton.type = 'button';
                editButton.innerHTML = '<i class="fa fa-pencil fa-lg"></i>';
                editButton.style = 'margin-left: 2px;';
                editButton.className = 'btn btn-primary btn-xs editBtn';
                editButton.id = 'editBtn' + i;
                buttonCell.appendChild(editButton);

                var hidn_id = document.createElement("input");
                hidn_id.type = 'hidden';
                hidn_id.name = 'hidid' + i;
                hidn_id.id = 'hidid' + i;
                hidn_id.value = item_index;
                buttonCell.appendChild(hidn_id);

                document.getElementById("lastEntry").value = i;

                ebtnID = editButton.id;
                var eBtn = document.getElementById(ebtnID);
                document.getElementById(ebtnID).onclick = edit_entry;  // calls a function edit
                dbtnID = delButton.id;
                var dBtn = document.getElementById(dbtnID);
                document.getElementById(dbtnID).onclick = delRow;

                i++;

                $("#item_picker").modal("hide");
            }
        } else if (prcs == 'edit') {
            var tm = document.getElementById("input_amount").value;
            var hdn_id = document.getElementById("hide_id").value;
            if (tm == "") {
                alert('Please enter an amount to be allocated for this item.');
            } else {
                if (no_a == 'yes') {
                    var item_index = document.getElementById("pick_item_noa").value;
                    var point_item_desc = 'no_item' + item_index;
                } else if (no_a == 'no') {
                    var point_item_desc = 'item' + item_index;
                    var item_index = document.getElementById("pick_item").value;
                }
                // var item_index = document.getElementById("pick_item").value;
                var item_amount = document.getElementById("input_amount").value;
                var formr_amount = document.getElementById("rec_amount").value;
                formr_amount = string2number(formr_amount);
                // var point_item_desc = 'item' + item_index;
                var item_desc = document.getElementById(point_item_desc).value;
                var tend_amount = document.getElementById('ptAmountTendered').value;
                var con_amount = string2number(item_amount);
                totAmount = totAmount - formr_amount + con_amount;
                var totAmount_display = number2string(totAmount);

                if (tend_amount != "") {
                    con_tendered = string2number(tend_amount);
                    con_tendered = con_tendered - totAmount;
                    var calc_change = number2string(con_tendered);
                    document.getElementById('ptChange').value = calc_change;
                }

                document.getElementById('pttAmount').value = totAmount_display;
                var get_id = document.getElementById('hide_id').value;

                var point_item = 'pItem' + get_id;
                var point_amount = 'pbdue' + get_id;
                var item_id_hide = 'hidid' + get_id;
                document.getElementById(item_id_hide).value = item_index;
                document.getElementById(point_item).innerHTML = item_desc;
                document.getElementById(point_amount).innerHTML = 'PhP ' + item_amount;
                $("#item_picker").modal("hide");
            }
        }
        // alert(tm);
    });

    function edit_entry() {
        var btn = this;
        var btn_id = btn.id;
        var get_id = btn_id.slice(7);
        var sel_id = 'hidid' + get_id;
        var item_id = 'pItem' + get_id;
        var amount_id = 'pbdue' + get_id;
        var item_name = document.getElementById(item_id).innerHTML;
        var bal_amount = document.getElementById(amount_id).innerHTML;
        var get_sel_id = document.getElementById(sel_id).value;
        bal_amount = bal_amount.slice(4);
        // document.getElementById('select_default').innerHTML = item_name;
        // document.getElementById('select_default').value = get_id;
        // $("#pick_item").select2().select2('val', 'get_sel_id');
        // alert(sel_id);
        $("#pick_item").select2().select2('val', get_sel_id);
        document.getElementById('hide_id').value = get_id;
        document.getElementById('input_amount').value = bal_amount;
        document.getElementById('rec_amount').value = bal_amount;
        document.getElementById('trans_ident').value = 'edit';
        $("#item_picker").modal();
    }

    function delRow()
    {
        var btn = this;
        var btn_id = btn.id;
        var get_id = btn_id.slice(6);
        var amnt_id = 'pbdue' + get_id;
        // alert(amnt_id);
        var del_amount = document.getElementById(amnt_id).innerHTML;
        del_amount = del_amount.slice(4);
        del_amount = string2number(del_amount);
        totAmount = totAmount - del_amount;
        // alert(totAmount);
        cash_change();
        var rowIndex = $(this).closest('td').parent()[0].sectionRowIndex; // This is row Index
        document.getElementById("item_table").deleteRow(rowIndex);
        i = i - 1;
        document.getElementById("lastEntry").value = i;
    }

    $("#pick_item").click(function () {
        var tvalue = document.getElementById('pick_item').value;
        // document.getElementById("hide_id").value = tvalue;
        var tbdue = 'bDue' + tvalue;
        var tBal_due = document.getElementById(tbdue).value;
        document.getElementById("input_amount").placeholder = tBal_due;
        document.getElementById("input_amount").value = tBal_due;
    });

    $("#paynow").click(function () {
        var con_date = document.getElementById("at_tdate").value;
        var con_ref = document.getElementById("ptRefNum").value;
        var con_amount = document.getElementById('ptAmountTendered').value;

        if (!con_date || !con_ref || !con_amount) {
            alert("Please complete all the forms before proceeding. Thank you.");
        } else {
            $("#confirm_modal").modal();
        }
    });


    $("#add_items").click(function () {
        document.getElementById('trans_ident').value = 'add';
        document.getElementById('input_amount').value = "";
        document.getElementById('input_amount').placeholder = "";
        $("#pick_item").select2({placeholder: "Select an Item"});
        $("#item_picker").modal();
    })

    $(".calci").click(function () {

        var btn = this;
        var btn_id = btn.id;
        var get_id = btn_id.slice(1);

        var t_amount = document.getElementById('input_amount').value;
        var check_dot = t_amount.lastIndexOf('.');
        // alert(check_dot+'>'+t_amount);
        var nodot = -1;
        if (get_id == 'dot') {
            if (check_dot == nodot) {
                get_id = '.';
            } else {
                get_id = '';
            }
        }
        var display_amount = t_amount + '' + get_id;
        document.getElementById('input_amount').value = display_amount;
    });

    $("#delentryi").click(function () {
        var t_amount = document.getElementById('tendered_amount').value;
        t_amount = t_amount.slice(0, -1);
        document.getElementById('tendered_amount').value = t_amount;
    });

    $("#delentry").click(function () {
        var t_amount = document.getElementById('input_amount').value;
        t_amount = t_amount.slice(0, -1);
        document.getElementById('input_amount').value = t_amount;
    });

    $("#ptAmountTendered").click(function () {
        $("#tend_picker").modal();
    });

    $("#add_tender").click(function () {
        var tended_amount = document.getElementById('tendered_amount').value;
        document.getElementById('ptAmountTendered').value = tended_amount;
        cash_change();
        $("#tend_picker").modal("hide");
    });

    $(".calcit").click(function () {
        var btn = this;
        var btn_id = btn.id;
        var get_id = btn_id.slice(1);
        var t_amount = document.getElementById('tendered_amount').value;
        var check_dot = t_amount.lastIndexOf('.');
        var nodot = -1;
        if (get_id == 'dot') {
            if (check_dot == nodot) {
                get_id = '.';
            } else {
                get_id = '';
            }
        }
        var display_amount = t_amount + '' + get_id;
        document.getElementById('tendered_amount').value = display_amount;
    });

    function number2string(sNumber)
    {
        //Seperates the components of the number
        var n = sNumber.toString().split(".");
        //Comma-fies the first part
        n[0] = n[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        //Combines the two sections
        return n.join(".");
    }

    function string2number(svariable)
    {
        var cNumber = svariable.replace(/\,/g, '');
        cNumber = parseFloat(cNumber);
        if (isNaN(cNumber) || !cNumber) {
            cNumber = 0;
        }
        return cNumber;
    }

</script>