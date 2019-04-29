<?php if($atasks_list){?><table style='margin: 6px 30px;width: 95%;background: none repeat scroll 0 0 #E6E6E6;' class='tDefault crmtab'>
    <thead>
        <tr>                        
            <th class='no-border' style="width:100px;">Action</th>
            <?php //if($crmlite=="contact"){?>
            <th class='no-border' width="150px">Type</th>            
            <th class='no-border'>Details</th>            
            <?php /*?><?php }else{?>
            <th class='no-border'>Subject</th>
            <th class='no-border' style="width:120px;">Record Owner</th>
            <?php }?>   <?php */?>         
            <th class='no-border' style="width:130px;">Date Modified </th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($atasks_list as $crow){?>
        <tr>
            <td class='no-border'><a href="<?php echo base_url("crm/tasks/edit/".$crow->task_id);?>">Edit</a> | <a href="<?php echo base_url("crm/tasks/delete/".$crow->task_id);?>" onclick="if(!confirm('Are you sure you want to delete this task?')) return false;">Delete</a></td>
            <td class='no-border'><a href="<?php echo base_url(); ?>crm/tasks/view/<?php echo $crow->task_id;?>"><?php echo $crow->task_subject;?></a></td>
            <?php //if($crmlite=="contact"){?>
             <td class='no-border'>
            	<?php 
					$subject = $crow->task_subject;
					$p = array("Phone Call:","Email:","Meeting:","Marketing:","Networking:","Current Environment:","Engagement:","Objections:","Closing:","Schedule Follow-Up Task:");
					$task_info1 = $crow->task_info;					
					foreach($p as $k)
					{
						$task_info1 = str_replace($k,"",$task_info1);
					}
					$str = trim(preg_replace('/\s+/', ' ', $task_info1));
					$str1 = trim(str_replace("-",", ",$str));
					$str2= trim(str_replace(" ,",",",$str1));
					$str3 =  substr($str2,1);
					if($subject=='Interaction') echo $str3;
					else echo ucfirst($crow->task_name);
				?>
            </td>
            <?php /*?><?php }else{?> 
            <td class='no-border'><?php echo ucfirst($crow->usrname);?></td>
            <?php }?> <?php */?>           
            <td class='no-border'><?php echo date("m/d/Y",strtotime($crow->task_modified))?></td>
        </tr>
        <?php }?>
    </tbody>
</table><?php }?>