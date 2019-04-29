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
<table style='background: none repeat scroll 0 0 #E6E6E6; width:95%' class='tDefault dtskTable scontact-list'>
    <thead>
        <tr class="rheader">
			<th class='no-border'><?php if(!isset($listall)){?><input type="checkbox" id="selectall" /><?php }?></th>
            <?php /*?><th class='no-border'><a href="javascript:void(0)" data-col="name" data-sort="<?php echo ($sortcol=='name' && $sortval=='asc'?'desc':'asc');?>" class="rhsort">Name</a></th>
            <th class='no-border'><a href="javascript:void(0)" data-col="title" data-sort="<?php echo ($sortcol=='title' && $sortval=='asc'?'desc':'asc');?>" class="rhsort">Title</a></th>
            <th class='no-border' style="width:180px;"><a href="javascript:void(0)" data-col="account" data-sort="<?php echo ($sortcol=='account' && $sortval=='asc'?'desc':'asc');?>" class="rhsort">Account</a></th>
            <th class='no-border' style="width:100px;"><a href="javascript:void(0)" data-col="phone" data-sort="<?php echo ($sortcol=='phone' && $sortval=='asc'?'desc':'asc');?>" class="rhsort">Phone</a></th>
            <th class='no-border' style="width:150px;"><a href="javascript:void(0)" data-col="email" data-sort="<?php echo ($sortcol=='email' && $sortval=='asc'?'desc':'asc');?>" class="rhsort">Email</a></th>
            <th style="width:140px;" class='no-border alcenter'><a href="javascript:void(0)" data-col="qp" data-sort="<?php echo ($sortcol=='qp' && $sortval=='asc'?'desc':'asc');?>" class="rhsort">Quality Points</a></th><?php */?>
            <?php /*?><th class='no-border'>Task</th><?php */?>
            
            <?php
			//	echo '<pre>'; print_r($contact_customField_values); echo '</pre>';
				 foreach($selectedcolumns as $ke => $val) {
				 if($ke!='no_mapping'){
				?>
                <?php /*?><th class='no-border'><a href="javascript:void(0)" data-col="<?php echo  $ke; ?>" data-sort="<?php echo ($sortcol==$ke && $sortval=='asc'?'desc':'asc');?>" class="rhsort"><?php if(isset($columnlabels[$ke]['label'])) { echo $columnlabels[$ke]['label'];} else {echo $contact_customField_values[$ke]['label'];} ?></a></th><?php */?>
                
                
                 <th class='no-border <?php if($columnlabels[$ke]['size']=='L') echo "large"; if($columnlabels[$ke]['size']=='S') echo "small"; if($columnlabels[$ke]['size']=='M') echo "medium"; if($contact_customField_values[$ke]['label']) echo "medium"; ?>'><a href="javascript:void(0)"  class=""><?php if(isset($columnlabels[$ke]['label'])) { echo $columnlabels[$ke]['label'];} else {echo $contact_customField_values[$ke]['label'];} ?></a></th>
             <?php }} ?>
        </tr>
    </thead>
    <tbody>
    
         <?php // echo '<pre>'; print_r($columnlabels); echo '</pre>'; ?>
         
         <?php // echo '<pre>'; print_r($contacts); echo '</pre>'; ?>
    
    	<?php foreach($contacts as $kk => $crow)    {
			//$next_task = $this->crm->get_next_task($crow->contact_id,'C');
            //$crow->qpoints = $this->crm->qualify_points('C',$crow->contact_id);
			
			//echo '<pre>'; print_r($crow); echo '</pre>';
		?>
        <tr>
			<td class='no-border' style="width:20px; text-align:center;"><input type="checkbox" value="<?php echo $crow['contact_id'];?>" name="recids[]" class="rcselect" /></td>
                <?php //echo "<pre>"; print_r($crow); echo "</pre>"; ?>
                
                <?php    
				 $ref_id = $crow['contact_id'];
			//	$crow = json_decode(json_encode($crow), true);
				$i = 0;
				foreach($selectedcolumns  as $selk => $selval){
				
				 $i = $i +1;
				 //echo "2222".$selval;
					// echo "<br/>"; 
				    if (array_key_exists($selk, $crow)) {
				   //  echo "123".$selk;
					// echo "<br/>";
					//echo $i."xxxx";
					//echo "<br/>";
					
				}
				 else {
				  $crow[$selk] = "";
				   //echo "111";
				   // echo "<br/>";
				   //echo $i."yyy";
					//echo "<br/>";
				 }
				} 
				$tempcrow = array();
				
				foreach($selectedcolumns as $kc => $kv){
				  $tempcrow[$kc] =  $crow[$kc];
				}
				//echo "<pre>"; print_r($tempcrow); echo "</pre>";
				?>
				
                
             <?php foreach($tempcrow as $key => $val) { 
			 	//echo "<pre>"; print_r($key); echo "</pre>";
			     if($key == 'contact_id') {
				   $conid = $ref_id;
				   continue;
				 }
			 ?>
              <?php if($key == 'phone') {?>
              <td style=" text-align:center;"><?php if($val) echo '<a href="tel:'.$val.'">'.$val.'</a>';?></td>
			 <?php } else if($key == 'email'){?>
			<td style=" text-align:center;"><?php if($val) echo '<a href="mailto:'.$val.'">'.$val.'</a>';?></td>
			 <?php } else if($key == 'user_first'){?>
            <td style=" text-align:center;"><a href="<?php echo base_url(); ?>crm/contacts/view/<?php echo $ref_id;?>"><?php echo $val;?></a></td>
			 <?php } else if($key == 'create_date'){?>
            <td style=" text-align:center;"><?php echo date("m-d-Y", strtotime($val));?></td>
			 <?php } else { if($key != 'no_mapping') { ?>
			 <td style=" text-align:center;"> <?php echo $val;  // if($key == 'target' || $key =='linkedin' || $key =='birthdate' || $key =='website' || $key =='lead_source' || $key =='user_title' || $key =='department' || $key =='create_date' || $key =='mobile' || $key =='phone' || $key =='assistant' || $key =='unsubscribed' || $key =='email' || $key =='asst_phone' || $key =='other_phone' || $key =='description' || $key =='ipoints' || $key =='ppoints' || $key == 'account_id' || $key == 'address' || $key == 'first_name' || $key == 'report_id') {  ?>
              <?php // echo $val; }else {  // $x = get_custom_fields($key,$ref_id); echo $x[0]->cv;
			  //} ?> </td>
			  <?php }}} ?> 
         
            <?php /*?><td class='no-border'><?php if($next_task){?><a href="<?php echo base_url(); ?>crm/tasks/view/<?php echo $next_task[task_id];?>"><?php echo ucfirst($next_task[task_subject])?></a><?php }?></td><?php */?>
        </tr>
        <?php }?>
    </tbody>
</table>
<div><?php echo $records_info ?></div>
<div align="center" id="morepages"><?php echo $this->pagination->create_links();?></div>