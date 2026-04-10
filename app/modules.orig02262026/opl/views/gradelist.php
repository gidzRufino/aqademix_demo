<div class="border-bottom w-100">
    <label class="text-sm">
        <input type="checkbox" id="allCheck" class="mr-3 ml-3" checked="checked" onclick="recheckAll(this)" />
        All
    </label>
</div>
<div id="classCheck">
    
<?php
switch($type):
    case 'grades':
        if($this->session->isOplAdmin):
            if(count($grades)):
                foreach($grades AS $g):
        ?>
            <div class="border-bottom w-100">
                <label class="text-sm">
                    <input type="checkbox" sub-id="<?php echo $g->grade_id ?>" class="classes mr-3 ml-3" checked="checked" onclick="doCheckAll(this)" />
                    <?php echo $g->level; ?>
                </label>
            </div>
        <?php
                endforeach;
            endif;
        ?>
        <?php
            if(count($college) != 0):
                foreach($college AS $c):
        ?>
            <div class="border-bottom w-100">
                <label class="text-sm">
                    <input type="checkbox" sub-id="<?php echo $c->course_id."-".$c->short_code ?>" class="classes mr-3 ml-3" checked="checked" onclick="doCheckAll(this)" />
                    <?php echo $c->course; ?>
                </label>
            </div>
        <?php
                endforeach;
            endif;
        endif;
    break;
    case 'classes':
        if($this->session->isOplAdmin):
            if(count($section)):
                foreach($section AS $s):
        ?>
            <div class="border-bottom w-100">
                <label class="text-sm">
                    <input type="checkbox" sub-id="<?php echo $s->grade_id."-".$s->section_id ?>" class="classes mr-3 ml-3" checked="checked" onclick="doCheckAll(this)" />
                    <?php echo $s->level." - ".$s->section; ?>
                </label>
            </div>
        <?php
                endforeach;
            endif;
            if(count($classes) != 0):
                foreach($classes AS $c):
        ?>
            <div class="border-bottom w-100">
                <label class="text-sm">
                    <input type="checkbox" sub-id="<?php echo $c->sec_id ?>" class="classes mr-3 ml-3" checked="checked" onclick="doCheckAll(this)" />
                    <?php echo $c->s_desc_title."[".$c->sec_id."]"; ?>
                </label>
            </div>
        <?php
                endforeach;
            endif;
        else:
            if(count($section)):
                foreach($section AS $s):
        ?>
            <div class="border-bottom w-100">
                <label class="text-sm">
                    <input type="checkbox" sub-id="<?php echo $s->grade_id."-".$s->section_id ?>" class="classes mr-3 ml-3" checked="checked" onclick="doCheckAll(this)" />
                    <?php echo $s->level." - ".$s->section; ?>
                </label>
            </div>
        <?php
                endforeach;
            endif;
            if(count($classes) != 0):
                foreach($classes AS $c):
        ?>
            <div class="border-bottom w-100">
                <label class="text-sm">
                    <input type="checkbox" sub-id="<?php echo $c->sec_id ?>" class="classes mr-3 ml-3" checked="checked" onclick="doCheckAll(this)" />
                    <?php echo $c->s_desc_title."[".$c->sec_id."]"; ?>
                </label>
            </div>
        <?php
                endforeach;
            endif;
        endif;
    break;
    case 'subjects':
        if(count($subjects)):
            foreach($subjects AS $s):
        ?>
            <div class="border-bottom w-100">
                <label class="text-sm">
                    <input type="checkbox" sub-id="<?php echo $s->grade_level_id."-".$s->section_id."-".$s->subject_id ?>" class="classes mr-3 ml-3" checked="checked" onclick="doCheckAll(this)" />
                    <?php echo $s->subject."[".$s->short_code."]" ?>
                </label>
            </div>
        <?php
            endforeach;
        endif;
    break;
endswitch;
?>
</div>
