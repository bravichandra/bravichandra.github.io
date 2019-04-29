<div class="main-wrapper">
<style>
/* table tr td{
border: 1px solid !important;
padding: 2px;
} */
.small_column
{
	width:4%;
	padding: 4px !important;
}
table tr td:nth-child(2), tr td:nth-child(3), table tr td:nth-child(4), table tr td:nth-child(5)
{
	width:7% !important;
	padding: 4px !important;
}
<?php if(!isset($eScripter)) {//Only for Pro User?>
table#sscts tr td:nth-child(5)
{
	display:none;
}
<?php }?>
td .buttonM {width:60px; text-align:center;padding: 7px 15px;}
</style>	
	<div class="main-wrapper">
		<!-- Main content -->	
		<table id="sscts" style='margin: 6px 30px;width: 95%;background: none repeat scroll 0 0 #E6E6E6;' class='tDefault'>
			<tr>
			<th style='text-align:center' class='no-border'>
            	Title
            </th>
            <th width='10%' style='text-align:center' class='no-border'>Primary Script</th>
			<th colspan='4' width='28%' style='text-align:center' class='no-border'>Version</th>
			</tr>
            <?php 
					foreach($all_templates as $key => $vtemp) {
					  $ik = $ik +1;
					  if($vtemp->prosp_new == 1){
						$temp = $key; break;
					  }
					  else {
						$temp = 0;
					  }
					}			
					
					foreach($all_templates as $key =>$vtemp) {
					if(!isset($vtemp->temp_id)) continue;	
					if(isset($temphides[$vtemp->temp_id])) continue;
					$tmptitle = isset($etemplate[$vtemp->temp_id])?$etemplate[$vtemp->temp_id]:$vtemp->temp_title;
			?>
            <tr>
			<td class='no-border'><?php if($tmptitle=='Qualifying Questions') echo "Questions"; else echo $tmptitle; ?></td>
            <td width='10%' align="center" class='no-border pscript'>
            	<div style="display:inline-block;"><input type="radio" name="primary_script" value="1" <?php if($key == $temp) echo "checked='checked'"; ?> onchange="primaryScript(<?php echo $vtemp->temp_id; ?>,this);" /></div>
            </td>
			<td width='7%' class='no-border'><a href="<?php echo base_url().'output/'.$vtemp->temp_slug; ?>" target="_blank" title="View" class="buttonM bBlue">View</a></td>
			<td width='7%' class='no-border'><a href="<?php echo base_url().'output/'.$vtemp->temp_slug; ?>/download" title="Download" class="buttonM bBlue" onclick="return download_template(this);">Download</a></td>
            <td width='7%' class='no-border dont-consider' style="display:block;">
            	<?php if($vtemp->temp_id==72){ ?>            		
	            <a  href="<?php echo base_url().'output/'.$vtemp->temp_slug; ?>/objection1" target="_blank" title="View Interactive Script" class="buttonM bBlue">Interactive</a>
            	<?php } else { ?>            		
	            <a  href="<?php echo base_url().'output/'.$vtemp->temp_slug; ?>/intro" target="_blank" title="View Interactive Script" class="buttonM bBlue">Interactive</a>
                <?php }?>
            </td>
            <?php if(isset($eScripter)) {//Hide edit button for Pro Lite?>
            <td width='7%' class='no-border dont-consider'><a href="<?php echo ($vtemp->temp_id==72?base_url().'step/objection':base_url().'home/etemplate/'.$vtemp->temp_id); ?>" class="buttonM bGreen">Edit</a></td>
            <?php }?>
			</tr>
            <?php }?>
		</table>				     
	</div>
</div>
<?php if(isset($eScripter) && $eScripter){?>
<div class="wrapper" align="right"><a  href="<?php echo base_url();?>ehide/1" class="hide-temps">Edit List</a></div>
<?php }?>