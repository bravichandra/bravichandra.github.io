<?php if($notes_list && $ntype){?><table style='margin: 6px 30px;width: 95%;background: none repeat scroll 0 0 #E6E6E6;' class='tDefault crmtab'>
    <thead>
        <tr>                        
        	<?php if($ivs<>'pool'){?>
            <th class='no-border' style="width:150px;">Action</th>
            <?php }?>
            <th class='no-border' style="width:150px;" ><?php if($ntype=="note" || $ntype=="skill" || $ntype=="exp" || $ntype=="docu") {?>Title<?php } else {?>School<?php } ?></th>
			<?php if($ntype=="docu") {?><th class='no-border' style="width:150px;"  >Document Link</th> <?php }?>
		
			<?php if($ntype=="edu" || $ntype=="exp") {?> <th class='no-border' style="width:150px;"><?php if($ntype=="edu"){ ?>Degree<?php } else if($ntype=="exp") { ?>Company<?php } ?></th><?php } ?>
            <th class='no-border' style="width:150px;"><?php if($ntype=="note" ) { ?>Record Owner <?php } else if($ntype=="edu" || $ntype=="skill" || $ntype=="exp"){?>From <?php } ?></th>
            <th class='no-border' style="width:150px;"><?php if($ntype=="note" ) { ?>Date Modified<?php } else if($ntype=="edu" || $ntype=="skill" || $ntype=="exp") {?>To <?php } ?></th>           
        </tr>
    </thead>
    <tbody>
        <?php foreach($notes_list as $crow)    {?>
        <tr>
        	<?php if($ivs<>'pool'){?>
            <td class='no-border'><a href="<?php echo base_url(); ?>interviewer/notes/<?php echo $ntype; ?>/edit/<?php echo $crow->notes_id;?>">Edit</a> | <a href="<?php echo base_url(); ?>interviewer/notes/<?php echo $ntype; ?>/delete/<?php echo $crow->notes_id;?>" onclick="if(!confirm('Are you sure you want to delete this notes?')) return false;">Delete</a></td>
            <?php }?>			
            <td class='no-border'><?php if($ntype=="note" || $ntype=="skill" || $ntype=="exp" || $ntype=="edu" ) {?><a href="<?php echo base_url(); ?>interviewer/notes/<?php echo $ntype; ?>/view/<?php echo $crow->notes_id;?>"><?php if($ntype=="note" || $ntype=="skill" || $ntype=="exp")  { echo $crow->notes_title;} else if( $ntype=="edu"){ echo $crow->notes_school; }?></a><?php } else { echo $crow->notes_title; } ?></td>
			
			
			<?php if($ntype=="docu") {?><td class='no-border' ><?php if($crow->upload) echo '<a href="'.base_url().'upload/'.$crow->upload.'" target="_blank">View Document </a>';?></td> <?php }?>
			<?php if($ntype=="edu" || $ntype=="exp") {?> <td class='no-border'><?php if($ntype=="exp") { echo $crow->notes_company; } else { echo $crow->notes_degree; } ?></td><?php } ?>
            <td class='no-border'><?php if($ntype=="note"){ echo ucfirst($crow->usrname); } else if($ntype=="edu" || $ntype=="skill" || $ntype=="exp"){ echo $crow->notes_fyear; }?></td>
            <td class='no-border'><?php if($ntype=="note"){ echo date("m/d/Y",strtotime($crow->notes_modify)); } else if($ntype=="edu" || $ntype=="skill" || $ntype=="exp") { echo ($crow->notes_private?'Present':$crow->notes_tyear); } ?></td>
        </tr>
        <?php }?>
    </tbody>
</table><?php }?>