
               <table class="table table-bordered datatable" id="table_export">
                    <thead>
                        <tr>
                            <th width="80"><div><?php echo get_phrase('photo');?></div></th>
                            <th><div><?php echo get_phrase('name');?></div></th>
                            <th><div><?php echo get_phrase('email');?></div></th>
                             <th><div><?php echo get_phrase('sex');?></div></th>
                            <th><div><?php echo get_phrase('qualification');?></div></th>
                            <th><div><?php echo get_phrase('Date of Joining');?></div></th>
                            <th><div><?php echo get_phrase('Id Card/ILP No.');?></div></th>
                            <th><div><?php echo get_phrase('Address');?></div></th>
                            <th><div><?php echo get_phrase('number');?></div></th>
                            <th><div><?php echo get_phrase('Trained/Untrained');?></div></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                                $teachers	=	$this->db->get('teacher' )->result_array();
                                foreach($teachers as $row):?>
                        <tr>
                            <td><img src="<?php echo $this->crud_model->get_image_url('teacher',$row['teacher_id']);?>" class="img-circle" width="30" /></td>
                            <td><?php echo $row['name'];?></td>
                            <td><?php echo $row['email'];?></td>
                            <td><?php echo $row['sex'];?></td>
                            <td><?php echo $row['qualification'];?></td>
                            <td><?php echo $row['doj'];?></td>
                            <td><?php echo $row['idno'];?></td>
                            <td><?php echo $row['address'];?></td>
                            <td><?php echo $row['phone'];?></td>
                            <td><?php echo $row['training'];?></td>
                            
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>



<!-----  DATA TABLE EXPORT CONFIGURATIONS ---->                      
<script type="text/javascript">

	jQuery(document).ready(function($)
	{
		

		var datatable = $("#table_export").dataTable();
		
		$(".dataTables_wrapper select").select2({
			minimumResultsForSearch: -1
		});
	});
		
</script>

