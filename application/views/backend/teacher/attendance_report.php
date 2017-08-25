<?php 
    $active_sms_service = $this->db->get_where('settings' , array('type' => 'active_sms_service'))->row()->description;
?>
<hr />
<div class="row">

    <table cellpadding="0" cellspacing="0" border="0" class="table table-bordered">
    	<thead>
        	<tr>
                <th><?php echo get_phrase('select_Name');?></th>
                <th><?php echo get_phrase('select_month');?></th>
                <th><?php echo get_phrase('select_year');?></th>
            	<th><?php echo get_phrase('select_date');?></th>
           </tr>
       </thead>
		<tbody>
        	<form method="post" action="<?php echo base_url();?>index.php?teacher/attendance_repselector" class="form">
                <tr class="gradeA">
                    <td>
                        <select name="student_id" class="form-control">
                            <option value="">Select Name</option>
                            <?php 
                            $students   =   $this->db->get_where('student' , array('class_id'=>$class_id))->result_array();
                                foreach($students as $row):?>
                            <option value="<?php echo $row['student_id'];?>"
                                <?php if(isset($student_id) && $student_id==$row['student_id'])echo 'selected="selected"';?>>
                                    <?php echo $row['name'];?>
                                    "<?php echo $row['section_id']; ?>"
                                        </option>
                            <?php endforeach;?>
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
                    <input type="hidden" name="date" value="1">
                    <input type="hidden" name="class_id" value="<?php echo $class_id;?>">
                    <td align="center"><input type="submit" value="<?php echo get_phrase('View_report');?>" class="btn btn-info"/></td>
                </tr>
            </form>
		</tbody>
	</table>
</div>

<hr />

<center>
    <div class="row">
        <div class="col-sm-offset-4 col-sm-4">
        
            <div class="tile-stats tile-white-gray">
                <div class="icon"><i class="entypo-suitcase"></i></div>
                <?php
                    $class_name = $this->db->get_where('class' , array('class_id' => $class_id))->row()->name;
                    $student_name = $this->db->get_where('student' , array('student_id' => $student_id))->row()->name;
                ?>
                <h3>Attendance of <?php echo ($class_name);?></h3>
                <h3>Student: <?php echo ($student_name);?></h3>
            </div>
        </div>

    </div>
</center>

<hr />


<div class="row" id="attendance_list">
    <div class="col-sm-offset-3 col-md-6">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <td><?php echo get_phrase('date');?></td>
                    <td><?php echo get_phrase('status');?></td>
                </tr>
            </thead>
            <tbody>

                <?php 
                    $attendance   =   $this->db->get_where('attendance' , array('student_id'=>$student_id,'month(date)'=>$month,'year(date)'=>$year))->result_array();
                        foreach($attendance as $row):?>
                       
                        <tr class="gradeA">
                            <td><?php echo $row['date'];?></td>
                            <?php if ($row['status'] == 1):?>
                            <td align="center">
                              <span class="badge badge-success"><?php echo get_phrase('present');?></span>  
                            </td>
                        <?php endif;?>
                        <?php if ($row['status'] == 2):?>
                            <td align="center">
                              <span class="badge badge-danger"><?php echo get_phrase('absent');?></span>  
                            </td>
                        <?php endif;?>
                        <?php if ($row['status'] == 0):?>
                            <td></td>
                        <?php endif;?>
                        </tr>
                    <?php endforeach;?>
            </tbody>
        </table>
    </div>
</div>