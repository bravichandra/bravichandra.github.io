<div class="search_lookup">
    <div class="search">
        <label>                        
            <input type="text" id="rlskey" class="searchkey" value="<?php echo $searchkey?>" placeholder="Find Record" /> 
            <input type="button" class="buttonM bBlue" value="Search" onclick="Records_searchLike();" />
        </label>
    </div>
</div>
<table style='background: none repeat scroll 0 0 #E6E6E6; width:95%' class='tDefault rsldtskTable'>
    <thead>
        <tr>
            <th class='no-border'>Opportunity Name</th>
            <th class='no-border'>Contact Name</th>
            <th class='no-border'>Account Name</th>
        </tr>
    </thead>
    <tbody>
        <?php 
			foreach($opportunities as $crow=>$cval)    {
			//echo '<pre>'; print_r($cval); echo '</pre>';
		?>
        <tr>
             <td class='no-border'><a href="javascript:void(0);" data_uns="<?php  echo $cval->unsubscribed;?>" data_id="<?php echo $cval->oppt_id;?>" 
             onclick="Records_setLookup(this);"><?php echo trim($cval->oppt_name);?></a></td>
            <td class='no-border'><?php echo $cval->user_first;  ?> <?php echo $cval->user_last;  ?></td>
            <td class='no-border'><?php echo $cval->account_title;  ?></td>
        </tr>
        <?php }?>
    </tbody>
</table>
<div><?php //echo $records_info ?></div>
<div align="center" id="morepages"><?php echo $this->pagination->create_links();?></div>