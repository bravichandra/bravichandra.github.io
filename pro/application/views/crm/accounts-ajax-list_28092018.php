<table style='background: none repeat scroll 0 0 #E6E6E6; width:95%' class='tDefault dtskTable'>
    <thead>
        <tr class="rheader">
        	<th class='no-border'><?php if(!isset($listall)){?><input type="checkbox" id="selectall" /><?php }?></th>
            <th class='no-border'><a href="javascript:void(0)" data-col="name" 
            data-sort="<?php echo ($sortcol=='name' && $sortval=='asc'?'desc':'asc');?>" class="rhsort">
            Account Name</a></th>
            <?php if(!isset($mine)){?><th class='no-border'><a href="javascript:void(0)" data-col="owner" 
            data-sort="<?php echo ($sortcol=='owner' && $sortval=='asc'?'desc':'asc');?>" class="rhsort">Record Owner</a></th><?php }?>
            <th class='no-border'>Billing City</th>
            <th class='no-border'><a href="javascript:void(0)" data-col="phone" data-sort="<?php echo ($sortcol=='phone' && $sortval=='asc'?'desc':'asc');?>" class="rhsort">
            Phone</a></th>
            <th class='no-border alcenter'><a href="javascript:void(0)" data-col="qp" data-sort="<?php echo ($sortcol=='qp' && $sortval=='asc'?'desc':'asc');?>" 
            class="rhsort">Quality Points</a></th>
        </tr>
    </thead>
    <tbody>
    	<?php foreach($accounts as $crow)    {
			$billing=$this->crm->get_address($crow->account_id,'billing','A');
            //$crow->qpoints = $this->crm->qualify_points('A',$crow->account_id);
		?>
        <tr>
        	<td class='no-border'><input type="checkbox" value="<?php echo $crow->account_id;?>" name="recids[]" class="rcselect" /></td>
            <td class='no-border'><a href="<?php echo base_url(); ?>crm/accounts/view/<?php echo $crow->account_id;?>"><?php echo $crow->account_name;?></a></td>
            <?php if(!isset($mine)){?><td class='no-border'><?php echo ucfirst($crow->usrname);?></td><?php }?>
            <td class='no-border'><?php if(isset($billing[city])) echo $billing[city]?></td>
            <td class='no-border'><?php if($crow->phone) echo '<a href="tel:'.$crow->phone.'">'.$crow->phone.'</a>';?></td>
            <td class='no-border alcenter'><?php echo ($crow->qpoints?$crow->qpoints:'');?></td>
        </tr>
        <?php }?>
    </tbody>
</table>
<div><?php echo $records_info ?></div>
<div align="center" id="morepages"><?php echo $this->pagination->create_links();?></div>