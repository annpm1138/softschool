<div class="row">
	<div class="col-md-12">
    <!-- <a onClick="printDiv('routine_print')" class="btn btn-default btn-icon icon-left hidden-print pull-right">
                                    Print Routine
                                    <i class="entypo-print"></i>
                                </a> -->
    
    	<!------CONTROL TABS START------>
		<ul class="nav nav-tabs bordered">
			<li class="active">
            	<a href="#list" data-toggle="tab"><i class="entypo-menu"></i> 
					<?php echo get_phrase('class_routine_list');?>
                    	</a></li>
			<li>
            	<a href="#add" data-toggle="tab"><i class="entypo-plus-circled"></i>
					<?php echo get_phrase('add_class_routine');?>
                    	</a></li>
		</ul>
    	<!------CONTROL TABS END------>
        
	
		<div class="tab-content">
            <!----TABLE LISTING STARTS-->
            <div class="tab-pane active" id="list">
				<div class="panel-group joined" id="accordion-test-2">
                	<?php 
					$toggle = true;
					$classes = $this->db->get('class')->result_array();
					foreach($classes as $row):
						?>
                        
                
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                		<h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion-test-2" href="#collapse<?php echo $row['class_id'];?>">
                                        <i class="entypo-rss"></i> Class <?php echo $row['class.name'];?>
                                    </a>
                                    </h4>
                                    
                                </div>
                                
                
                                <div id="collapse<?php echo $row['class_id'];?>" class="panel-collapse collapse <?php if($toggle){echo 'in';$toggle=false;}?>">
                                    <div class="panel-body"  id="routine_print">
                                        <table cellpadding="0" cellspacing="0" border="0"  class="table table-bordered">
                                            <tbody>
                                                <?php 
                                                for($d=1;$d<=7;$d++):
                                                
                                                if($d==1)$day='sunday';
                                                else if($d==2)$day='monday';
                                                else if($d==3)$day='tuesday';
                                                else if($d==4)$day='wednesday';
                                                else if($d==5)$day='thursday';
                                                else if($d==6)$day='friday';
                                                else if($d==7)$day='saturday';
                                                ?>
                                                <tr class="gradeA">
                                                    <td width="100"><?php echo strtoupper($day);?></td>
                                                    <td>
                                                    	<?php
														$this->db->order_by("time_start", "asc");
														$this->db->where('day' , $day);
														$this->db->where('class_id' , $row['class_id']);
														$routines	=	$this->db->get('class_routine')->result_array();
														foreach($routines as $row2):
														?>
														<div class="btn-group" >
															<button class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                                            	<?php echo $this->crud_model->get_subject_name_by_id($row2['subject_id']);?>
																<?php
                                                                    if ($row2['time_start_min'] == 0 && $row2['time_end_min'] == 0) 
                                                                        echo '('.$row2['time_start'].'-'.$row2['time_end'].')';
                                                                    if ($row2['time_start_min'] != 0 || $row2['time_end_min'] != 0)
                                                                        echo '('.$row2['time_start'].':'.$row2['time_start_min'].'-'.$row2['time_end'].':'.$row2['time_end_min'].')';
                                                                ?></br>
                                                                <?php echo $this->crud_model->get_type_name_by_id('section',$row2['section_id']);?></br>
                                                                <?php echo $this->crud_model->get_type_name_by_id('teacher',$row2['teacher_id']);?>
                                                            	<span class="caret"></span>
                                                            </button>
															<ul class="dropdown-menu">
																<li>
                                                                <a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_edit_class_routine/<?php echo $row2['class_routine_id'];?>');">
                                                                    <i class="entypo-pencil"></i>
                                                                        <?php echo get_phrase('edit');?>
                                                                    			</a>
                                                         </li>
                                                         
                                                         <li>
                                                            <a href="#" onclick="confirm_modal('<?php echo base_url();?>index.php?admin/class_routine/delete/<?php echo $row2['class_routine_id'];?>');">
                                                                <i class="entypo-trash"></i>
                                                                    <?php echo get_phrase('delete');?>
                                                                </a>
                                                    		</li>
															</ul>
														</div>
														<?php endforeach;?>

                                                    </td>
                                                </tr>
                                                <?php endfor;?>
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
						<?php
					endforeach;
					?>
  				</div>
			</div>
            <!----TABLE LISTING ENDS--->
            
            
			<!----CREATION FORM STARTS---->
			<div class="tab-pane box" id="add" style="padding: 5px">
                <div class="box-content">
                	<?php echo form_open(base_url() . 'index.php?admin/class_routine/create' , array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top'));?>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo get_phrase('class');?></label>
                                <div class="col-sm-5">
                                    <select name="class_id" class="form-control" style="width:100%;"
                                        onchange="return get_class_sections(this.value); return get_class_subject(this.value)">
                                        <option value=""><?php echo get_phrase('select_class');?></option>
                                    	<?php 
										$classes = $this->db->get('class')->result_array();
										foreach($classes as $row):
										?>
                                    		<option value="<?php echo $row['class_id'];?>"><?php echo $row['name'];?></option>
                                        <?php
										endforeach;
										?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo get_phrase('section');?></label>
                                <div class="col-sm-5">
                                    <select name="section_id" class="form-control" style="width:100%;" id="section_selector_holder" onchange="return get_class_subject(this.value)">
                                        <option value=""><?php echo get_phrase('select_class_first');?></option>
                                        
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo get_phrase('subject');?></label>
                                <div class="col-sm-5">
                                    <select name="subject_id" class="form-control" style="width:100%;" id="subject_selection_holder">
                                        <option value=""><?php echo get_phrase('select_class_first');?></option>
                                    	
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo get_phrase('teacher');?></label>
                                <div class="col-sm-5">
                                    <select name="teacher_id" class="form-control select2" style="width:100%;">
                                    <option value=""><?php echo get_phrase('select');?></option>
                                        <?php 
                                        $teachers = $this->db->get('teacher')->result_array();
                                        foreach($teachers as $row):
                                        ?>
                                            
                                            <option value="<?php echo $row['teacher_id'];?>"><?php echo $row['name'];?></option>
                                        <?php
                                        endforeach;
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo get_phrase('day');?></label>
                                <div class="col-sm-5">
                                    <select name="day" class="form-control selectboxit" style="width:100%;">
                                        <option value="sunday">sunday</option>
                                        <option value="monday">monday</option>
                                        <option value="tuesday">tuesday</option>
                                        <option value="wednesday">wednesday</option>
                                        <option value="thursday">thursday</option>
                                        <option value="friday">friday</option>
                                        <option value="saturday">saturday</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo get_phrase('starting_time');?></label>
                                <div class="col-sm-9">
                                    <div class="col-md-3">
                                        <select name="time_start" class="form-control selectboxit">
                                            <option value=""><?php echo get_phrase('hour');?></option>
    										<?php for($i = 0; $i <= 12 ; $i++):?>
                                                <option value="<?php echo $i;?>"><?php echo $i;?></option>
                                            <?php endfor;?>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <select name="time_start_min" class="form-control selectboxit">
                                            <option value=""><?php echo get_phrase('minutes');?></option>
                                            <?php for($i = 0; $i <= 11 ; $i++):?>
                                                <option value="<?php echo $i * 5;?>"><?php echo $i * 5;?></option>
                                            <?php endfor;?>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <select name="starting_ampm" class="form-control selectboxit">
                                        	<option value="1">am</option>
                                        	<option value="2">pm</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo get_phrase('ending_time');?></label>
                                <div class="col-sm-9">
                                    <div class="col-md-3">
                                        <select name="time_end" class="form-control selectboxit">
                                            <option value=""><?php echo get_phrase('hour');?></option>
    										<?php for($i = 0; $i <= 12 ; $i++):?>
                                                <option value="<?php echo $i;?>"><?php echo $i;?></option>
                                            <?php endfor;?>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <select name="time_end_min" class="form-control selectboxit">
                                            <option value=""><?php echo get_phrase('minutes');?></option>  
                                            <?php for($i = 0; $i <= 11 ; $i++):?>
                                                <option value="<?php echo $i * 5;?>"><?php echo $i * 5;?></option>
                                            <?php endfor;?>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <select name="ending_ampm" class="form-control selectboxit">
                                        	<option value="1">am</option>
                                        	<option value="2">pm</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        <div class="form-group">
                              <div class="col-sm-offset-3 col-sm-5">
                                  <button type="submit" class="btn btn-info"><?php echo get_phrase('add_class_routine');?></button>
                              </div>
							</div>
                    </form>                
                </div>                
			</div>
			<!----CREATION FORM ENDS-->
            
		</div>
	</div>
</div>

<script type="text/javascript">
    function get_class_subject(class_id) {
        $.ajax({
            url: '<?php echo base_url();?>index.php?admin/get_class_subject/' + class_id ,
            success: function(response)
            {
                jQuery('#subject_selection_holder').html(response);
            }
        });
    }
    function get_class_sections(class_id) {

        $.ajax({
            url: '<?php echo base_url();?>index.php?admin/get_class_section/' + class_id ,
            success: function(response)
            {
                jQuery('#section_selector_holder').html(response);
            }
        });

    }
    function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();
     window.close();

     document.body.innerHTML = originalContents;
}

</script>

