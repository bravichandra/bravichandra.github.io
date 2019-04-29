<table style='background: none repeat scroll 0 0 #E6E6E6; width:100%' class='tDefault dsTable'>
    <thead>
        <tr>
            <th class='no-border'>Account Name</th>
            <th class='no-border'>Account Site</th>
            <th class='no-border'>Account Owner Alias</th>
            <th class='no-border'>Type</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($accounts as $crow)    {
			if(!$crow->share_user_id) $crow->share_user_id=$this->_user_id;
			$sUser = $this->crm->get_CurrentUser($crow->share_user_id);
			$crow->share_user_title=ucfirst($sUser[0]->usrname);
		?>
        <tr>
            <td class='no-border'><a href="javascript:void(0);" data_id="<?php echo $crow->account_id;?>" onclick="setLookup(this);"><?php echo $crow->account_name;?></a></td>
            <td class='no-border'><?php echo $crow->account_site;?></td>
            <td class='no-border'><?php echo $crow->share_user_title;?></td>
            <td class='no-border'><?php echo $crow->account_type;?></td>
        </tr>
        <?php }?>
    </tbody>
</table>