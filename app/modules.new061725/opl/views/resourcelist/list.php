<section class="card card-cyan card-outline mb-0">
    <div class="card-header">
        <p><i class="fas fa-info-circle fa-2x"></i> </p>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <table class="table table-info table-striped mt-0" style="width:100%">
                <tr>
                    <th class="text-center" style="width:20px;">#</th>
                    <th class="text-center col-lg-3">Title</th>
                    <!-- <th class="text-center col-lg-4">Details</th> -->
                    <th class="text-center col-lg-2">Topic</th>
                    <th class="text-center col-lg-2">Tags</th>
                </tr>
                <?php 
                    if(count($resources) != 0):
                        $i=1;
                        foreach($resources as $resource):
                            
                    ?>
                    <tr class="pointer" onclick="document.location='<?php echo base_url('opl/opl_resourcelist/resourceDetails/'. $resource->resource_id . '/'. $school_year)?>'">
                        <td class="text-center"><?php echo $i++; ?></td>
                        <td class="text-center col-lg-3"><?php echo ucwords(strtolower($resource->resource_title)) ?></td>
                        <!-- <td class="text-center col-lg-3"><?php echo substr($resource->resource_details,0,50).'...' ?></td> -->
                        <td class="text-center col-lg-3"><?php echo $resource->topic ?></td>
                        <td class="text-center col-lg-3"><?php echo $resource->tags ?></td>
                    </tr>
                        
                    <?php
                        endforeach;
                    else:
                        ?>
                        <tr><td class="text-center" colspan="5"><h3>No Resources Available</h3></td></tr>
                        <?php
                    endif;
                    ?>
            </table>
        </div>
    </div>
     
    <div class="d-flex justify-content-center">
        <?php  echo $links;?>
    </div>
</section>
    
    