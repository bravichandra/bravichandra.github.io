<style type="text/css">
		.large
		{
			width:200px !important;
			text-align:center !important;
		}
		.medium
		{
			width:100px !important;
			text-align:center !important;
		}
		.small
		{
			width:50px !important;
			text-align:center !important;
		}
</style>
<?php if($section==1) {?>
<table style='background: none repeat scroll 0 0 #E6E6E6; width:95%' class='tDefault dtskTable'>
    <thead>
        <tr class="rheader">
        	 <th class='no-border' style="width:20px;"></th>
			  <?php 
			  
			  foreach($selectedcolumns as $ke => $val) {			
              if($ke!='no_mapping'){
              ?>
			  <th class='no-border <?php if($columnlabels[$ke]['size']=='L') echo "large"; if($columnlabels[$ke]['size']=='S') echo "small"; if($columnlabels[$ke]['size']=='M') echo "medium"; if($contact_customField_values[$ke]['label']) echo "medium"; ?>'><a href="javascript:void(0)"  class=""><?php if(isset($columnlabels[$ke]['label'])) { echo $columnlabels[$ke]['label'];} else {echo $contact_customField_values[$ke]['label'];} ?></a></th>
              
			   <?php }} ?>
        </tr>
    </thead>
    <tbody>
    	<?php
			 foreach($contacts as $kk => $crow)    {
		
		?>
        	  <tr>
			<td class='no-border' style="text-align:center;"><input type="checkbox" value="<?php echo $crow['contact_id'];?>" name="recids[]" class="rcselect" /></td>
                
                <?php    
				$ref_id = $crow['contact_id'];
				$i = 0;
				foreach($selectedcolumns  as $selk => $selval){
				
				 $i = $i +1;
				    if (array_key_exists($selk, $crow)) {
				  
				}
				 else {
				  $crow[$selk] = "";
				 }
				} 
				$tempcrow = array();
				
				foreach($selectedcolumns as $kc => $kv){
				  $tempcrow[$kc] =  $crow[$kc];
				}
				?>
				
                
             <?php foreach($tempcrow as $key => $val) { 
			     if($key == 'contact_id') {
				   $conid = $ref_id;
				   continue;
				 }
			 ?>
              <?php if($key == 'phone') {?>
              <td style="text-align:center;"> <?php if($val) echo '<a href="tel:'.$val.'">'.$val.'</a>';?></td>
			 <?php } else if($key == 'email'){?>
			<td style="text-align:center;"><?php if($val) echo '<a href="mailto:'.$val.'">'.$val.'</a>';?></td>
			 <?php } else if($key == 'user_first'){?>
            <td style="text-align:center;"><a  class="getty" href="<?php echo base_url(); ?>crm/contacts/view/<?php echo $ref_id;?>?cat=<?php echo $cid; ?>" id="<?php echo $ref_id;?>"><?php echo $val;?></a></td>
			 <?php } else { if($key != 'no_mapping') { ?>
			 <td style="text-align:center;"> <?php echo $val;  ?> </td>
			  <?php }}} ?> 
        </tr>
        <?php } ?>
    </tbody>
</table>
<?php } else {?>


<table style='background: none repeat scroll 0 0 #E6E6E6; width:95%' class='tDefault dtskTable'>
    <thead>
        <tr class="rheader">
            <th class='no-border' style="width:20px; text-align:center;">
            <?php 
			
			  
			  foreach($selectedcolumns as $ke => $val) {			
              if($ke!='no_mapping'){
              ?>
			  <th class='<?php if($columnlabels[$ke]['size']=='L') echo "large"; if($columnlabels[$ke]['size']=='S') echo "small"; if($columnlabels[$ke]['size']=='M') echo "medium"; if($contact_customField_values[$ke]['label']) echo "medium"; ?>'><a href="javascript:void(0)"  class=""><?php if(isset($columnlabels[$ke]['label'])) { echo $columnlabels[$ke]['label'];} else {echo $contact_customField_values[$ke]['label'];} ?></a></th>
              
			   <?php }} ?>
        </tr>
    </thead>
    <tbody>
        	<?php
			 foreach($contacts as $kk => $crow)    {
		
		?>
        	  <tr>
			<td class='no-border' style="text-align:center;"><input type="checkbox" value="<?php echo $crow['account_id'];?>" name="recids[]" class="rcselect" /></td>
                
                <?php    
				$ref_id = $crow['account_id'];
				$i = 0;
				foreach($selectedcolumns  as $selk => $selval){
				
				 $i = $i +1;
				    if (array_key_exists($selk, $crow)) {
					
				}
				 else {
				  $crow[$selk] = "";
				 }
				} 
				$tempcrow = array();
				
				foreach($selectedcolumns as $kc => $kv){
				  $tempcrow[$kc] =  $crow[$kc];
				}
				?>
				
                
             <?php foreach($tempcrow as $key => $val) { 
			     if($key == 'account_id') {
				   $conid = $ref_id;
				   continue;
				 }
			 ?>
                
              <?php if($key == 'phone') {?>
              <td  style="text-align:center;"><?php if($val) echo '<a href="tel:'.$val.'">'.$val.'</a>';?></td>
			 <?php } else if($key == 'account_name'){?> 
			  
                <td style="text-align:center;"><a href="<?php echo base_url(); ?>crm/accounts/view/<?php echo $ref_id;?>"><?php echo $val;?></a></td>
			 <?php } else if($key == 'email'){?>
			<td  style="text-align:center;"><?php if($val) echo '<a href="mailto:'.$val.'">'.$val.'</a>';?></td>
			 <?php } else if($key == 'user_first'){?>
            <td  style="text-align:center;"><a  class="getty" href="<?php echo base_url(); ?>crm/contacts/view/<?php echo $ref_id;?>?cat=<?php echo $cid; ?>" id="<?php echo $ref_id;?>"><?php echo $val;?></a></td>
			 <?php } else { if($key != 'no_mapping') { ?>
			 <td  style="text-align:center;"><?php echo $val; ?> </td>
			  <?php }}} ?> 
        </tr>
        <?php } ?>
    </tbody>
</table>
<?php }?>
<div><?php echo $records_info ?></div>
<div align="center" id="morepages"><?php echo $this->pagination->create_links();?></div>