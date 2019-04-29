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
            <th class='no-border'>Name</th>
            <th class='no-border'>Account Name</th>
            <th class='no-border'>Email Address</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($contacts as $crow)    {?>
        <tr>
            <td class='no-border'><a href="javascript:void(0);" data_uns="<?php  echo $crow->unsubscribed;?>" data_id="<?php echo $crow->contact_id;?>" onclick="Records_setLookup(this);"><?php echo trim($crow->user_first.' '.$crow->user_last);?></a></td>
            <td class='no-border'><?php echo $crow->account_name;?></td>
            <td class='no-border' id="mail_<?php echo $crow->contact_id;?>"><?php if($crow->email) echo '<a href="mailto:'.$crow->email.'">'.$crow->email.'</a>';?></td>
        </tr>
        <?php }?>
    </tbody>
</table>
<div><?php echo $records_info ?></div>
<div align="center" id="morepages"><?php echo $this->pagination->create_links();?></div>