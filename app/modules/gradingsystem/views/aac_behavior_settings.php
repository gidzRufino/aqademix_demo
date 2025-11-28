<div class="col-lg-12">
    <div class="panel panel-green">
        <div class="panel-heading clearfix">
            <h5>Observed Values and Behavioral Statements
            <i onclick="$('#addObservedValues').modal('show')"class="pull-right pointer fa fa-2x fa-plus"></i>
            </h5>
        </div>
        <div class="panel-body" style="height:450px; overflow-y: scroll;">
            <table class="table table-bordered">
                <tr>
                    <th>CORE VALUES</th>
                    <th style="width:41%;">Behavioral Statements</th>
                    <th>Indicators</th>
                </tr>
                <?php 
                foreach ($coreValues as $cv):
                    $bStatements = Modules::run('gradingsystem/getListOfValues', $cv->core_id);
                    //count($bStatements->result());
                ?>
                <tr>
                    <td style="vertical-align: middle; width:10%; text-align: center;"><?php echo $cv->core_values; ?></td>
                    <td colspan="2"><table class="table table-bordered">
                        <?php foreach ($bStatements->result() as $bs): 
                            $customList = Modules::run('gradingsystem/getCustomizedList', $bs->bh_id);
                            ?>
                            <tr>
                                <td style="vertical-align: middle; width:50%;  text-align: left;">
                                    <?php echo $bs->bh_name; ?>
                                </td>
                                <td>
                                    <table class="table table-striped">
                                        <?php foreach($customList->result() as $cL): ?>
                                        <tr>
                                            <td style="vertical-align: middle;"><?php echo $cL->bhs_indicators ?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </table>
                                    
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </table>
                    </td>
                </tr>    
                    
                <?php
                endforeach;
            ?>
                
            </table>
            

        </div>
    </div>
    
</div>