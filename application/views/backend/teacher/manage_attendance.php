<hr />
    <table cellpadding="0" cellspacing="0" border="0" class="table table-bordered">
        <thead>
            <tr>
                <th><?php echo get_phrase('select_date');?></th>
                <th><?php echo get_phrase('select_month');?></th>
                <th><?php echo get_phrase('select_year');?></th>
                <th><?php echo get_phrase('select_class');?></th>
                <th><?php echo get_phrase('select_section');?></th>
                <th><?php echo get_phrase('Action');?></th>
           </tr>
       </thead>
        <tbody>
            <form method="post" action="<?php echo base_url();?>index.php?teacher/attendance_selector" class="form">
                <tr class="gradeA">
                    <td>
                        <select name="date" class="form-control">
                            <?php for($i=1;$i<=31;$i++):?>
                                <option value="<?php echo $i;?>" 
                                    <?php if(isset($date) && $date==$i)echo 'selected="selected"';?>>
                                        <?php echo $i;?>
                                            </option>
                            <?php endfor;?>
                        </select>
                    </td>
                    <td>
                        <select name="month" class="form-control">
                            <?php 
                            for($i=1;$i<=12;$i++):
                                if($i==1)$m='january';
                                else if($i==2)$m='february';
                                else if($i==3)$m='march';
                                else if($i==4)$m='april';
                                else if($i==5)$m='may';
                                else if($i==6)$m='june';
                                else if($i==7)$m='july';
                                else if($i==8)$m='august';
                                else if($i==9)$m='september';
                                else if($i==10)$m='october';
                                else if($i==11)$m='november';
                                else if($i==12)$m='december';
                            ?>
                                <option value="<?php echo $i;?>"
                                    <?php if($month==$i)echo 'selected="selected"';?>>
                                        <?php echo $m;?>
                                            </option>
                            <?php 
                            endfor;
                            ?>
                        </select>
                    </td>
                    <td>
                        <select name="year" class="form-control">
                            <?php for($i=2020;$i>=2010;$i--):?>
                                <option value="<?php echo $i;?>"
                                    <?php if(isset($year) && $year==$i)echo 'selected="selected"';?>>
                                        <?php echo $i;?>
                                            </option>
                            <?php endfor;?>
                        </select>
                    </td>
                    <td>
                        <select name="class_id" class="form-control" data-validate="required" id="class_id" 
                                data-message-required="<?php echo get_phrase('value_required');?>"
                                    onchange="return get_class_sections(this.value)">
                              <option value=""><?php echo get_phrase('select');?></option>
                              <?php 
                                $classes = $this->db->get('class')->result_array();
                                foreach($classes as $row):
                                    ?>
                                    <option value="<?php echo $row['class_id'];?>"
                                <?php if(isset($class_id) && $class_id==$row['class_id'])echo 'selected="selected"';?>>
                                    <?php echo $row['name'];?>
                                        </option>
                                <?php
                                endforeach;
                              ?>
                          </select>

                    </td>
                    <td>
                        <select name="section_id" class="form-control" id="section_selector_holder">
                                    <option value=""><?php echo get_phrase('select_class_first');?>
                                        
                                    </option>
                                    
                                </select>
                    </td>
                    <td align="center"><input type="submit" value="<?php echo get_phrase('manage_attendance');?>" class="btn btn-info"/></td>
                </tr>
            </form>
        </tbody>
    </table>
<hr />



<?php if($date!='' && $month!='' && $year!='' && $class_id!='' && $section_id!=''):?>

<center>
    <div class="row">
        <div class="col-sm-offset-4 col-sm-4">
        
            <div class="tile-stats tile-white-gray">
                <div class="icon"><i class="entypo-suitcase"></i></div>
                <?php
                    $full_date  =   $year.'-'.$month.'-'.$date;
                    $timestamp  = strtotime($full_date);
                    $day        = strtolower(date('l', $timestamp));
                 ?>
                <h2><?php echo ucwords($day);?></h2>
                <?php
                    $class_name = $this->db->get_where('class' , array('class_id' => $class_id))->row()->name;
                    $section_name = $this->db->get_where('section' , array('section_id' => $section_id))->row()->name;
                ?>
                <h3>Attendance of <?php echo ($class_name);?></h3>
                <p>section <?php echo ($section_name);?></p>
                <p><?php echo $date.'-'.$month.'-'.$year;?></p>
            </div>
            <a href="#" id="update_attendance_button" onclick="return update_attendance()" 
                class="btn btn-info">
                    Update Attendance
            </a>
        </div>

    </div>
</center>
<hr />

<div class="row" id="attendance_list">
    <div class="col-sm-offset-3 col-md-6">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <td><?php echo get_phrase('roll');?></td>
                    <td><?php echo get_phrase('name');?></td>
                    <td><?php echo get_phrase('status');?></td>
                </tr>
            </thead>
            <tbody>

                <?php 
                    $students   =   $this->db->get_where('student' , array('class_id'=>$class_id,'section_id'=>$section_id))->result_array();
                        foreach($students as $row):?>
                        <tr class="gradeA">
                            <td><?php echo $row['roll'];?></td>
                            <td><?php echo $row['name'];?></td>
                            <?php 
                                //inserting blank data for students attendance if unavailable
                                $verify_data    =   array(  'student_id' => $row['student_id'],
                                                            'date' => $full_date);
                                $query = $this->db->get_where('attendance' , $verify_data);
                                if($query->num_rows() < 1)
                                $this->db->insert('attendance' , $verify_data);
                                
                                //showing the attendance status editing option
                                $attendance = $this->db->get_where('attendance' , $verify_data)->row();
                                $status     = $attendance->status;
                            ?>
                        <?php if ($status == 1):?>
                            <td align="center">
                              <span class="badge badge-success"><?php echo get_phrase('present');?></span>  
                            </td>
                        <?php endif;?>
                        <?php if ($status == 2):?>
                            <td align="center">
                              <span class="badge badge-danger"><?php echo get_phrase('absent');?></span>  
                            </td>
                        <?php endif;?>
                        <?php if ($status == 0):?>
                            <td></td>
                        <?php endif;?>
                        </tr>
                    <?php endforeach;?>
            </tbody>
        </table>
    </div>
</div>




<div class="row" id="update_attendance">

<!-- STUDENT's attendance submission form here -->
<form method="post" 
    action="<?php echo base_url();?>index.php?teacher/manage_attendance/<?php echo $date.'/'.$month.'/'.$year.'/'.$class_id.'/'.$section_id;?>">
        <div class="col-sm-offset-3 col-md-6">
            <table  class="table table-bordered">
                <thead>
                    <tr class="gradeA">
                        <th><?php echo get_phrase('roll');?></th>
                        <th><?php echo get_phrase('name');?></th>
                        <th><?php echo get_phrase('status');?></th>
                    </tr>
                </thead>
                <tbody>
                        
                    <?php 
                    //STUDENTS ATTENDANCE
                    $students   =   $this->db->get_where('student' , array('class_id'=>$class_id,'section_id'=>$section_id))->result_array();
                        
                    foreach($students as $row)
                    {
                        ?>
                        <tr class="gradeA">
                            <td><?php echo $row['roll'];?></td>
                            <td><?php echo $row['name'];?></td>
                            <td align="center">
                                <?php 
                                //inserting blank data for students attendance if unavailable
                                $verify_data    =   array(  'student_id' => $row['student_id'],
                                                            'date' => $full_date);
                                $query = $this->db->get_where('attendance' , $verify_data);
                                if($query->num_rows() < 1)
                                $this->db->insert('attendance' , $verify_data);
                                
                                //showing the attendance status editing option
                                $attendance = $this->db->get_where('attendance' , $verify_data)->row();
                                $status     = $attendance->status;
                                ?>
                                
                                
                                <label>
                                    <input type="radio" class="option-input radio" name="status_<?php echo $row['student_id'];?>" value="2"  <?php if($status == 2||$status == 0)echo 'checked'?> />
                                Absent
                                </label>
                                <label>
                                    <input type="radio" class="option-input radio" name="status_<?php echo $row['student_id'];?>" value="1"  <?php if($status == 1)echo 'checked'?> />
                                Present
                                </label>
                                
                            </td>
                        </tr>
                        <?php 
                    }
                    ?>
                </tbody>
            </table>
            <input type="hidden" name="date" value="<?php echo $full_date;?>" />
            <center>
                <input type="submit" class="btn btn-info" value="save changes">
            </center>
        </div>
    
    
</form>
</div>
<?php endif;?>

<script type="text/javascript">

    $("#update_attendance").hide();

    function update_attendance() {

        $("#attendance_list").hide();
        $("#update_attendance_button").hide();
        $("#update_attendance").show();

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
</script>