<?php
	$kcount = $custom?$custom['kcount']:1;
	if($custom) unset($custom['kcount']);
	$kcounta = $customa?$customa['kcount']:1;
	if($customa) unset($customa['kcount']);
?>
		<table cellpadding="0" cellspacing="0" border="0" class="contact-edit" style="margin-top: 0px;margin-bottom: 0px;" >

            <tbody>

	            <tr>

	                <td class="title" colspan="5">

	                    <div class="quatabs">

	                        <div class="active"><a href="javascript:void(0);" rel="box1">Contacts</a></div>

	                        <div><a href="javascript:void(0);" rel="box2">Accounts</a></div>

	                    </div>

	                    <input type="hidden" value="1" id="ctab" />

	                </td>

	            </tr>

	        </tbody>

	    </table>

	    <table cellpadding="0" cellspacing="0" border="0" class="box1 tabbox contact-edit" style="margin-top: 0px;margin-bottom: 0px;" >

            <tbody id="frmsfield">

	            <tr class="custom">

	                <th class="one"></th>

	                <td class="two"><b>Custom Field Label </b>

	                	<input type="hidden" name="custom[kcount]" value="<?php echo $kcount?>" id="kcount" />

	                </td>

	                <td class="two" colspan="3"><b>Set as numeric to allow sorting and searching</b></td>

	            </tr>

	           <?php  if(!$custom){ ?>

	            <tr class="custom1">

	                <th class="one" width="200px">Custom Fields 1</th>

	                <td class="two">

	                	<input type="text" value="<?php if(isset($custom['field1'])) echo form_prep($custom['field1'])?>" name="custom[field1]" id="field1" />                 	

	                </td>

	                <td class="one">

	                    <input type="checkbox" class="chkcustomNum" value="field1" name="customNum[]" />

	                </td>

	                <td class="one">&nbsp;</td>

	                <td width="400px">&nbsp;</td>

	            </tr>

	            <?php }

				else {

					$i=1;

					 foreach($custom as $key=>$value){ ?>

	                <tr class="custom<?php echo $n =str_replace("field", "", $key);?>">

	                     <th class="one" width="200px">Custom Field <span class="csno"><?php echo $i;?> </span></th>

	                     <td class="two">

	                        <input type="text" value="<?php echo $value; ?>" name="custom[<?php echo $key; ?>]" id="<?php echo $key; ?>" /> 

	                     </td>

	                     <td class="one">

	                        <input type="checkbox" class="chkcustomNum" value="<?php echo $key; ?>" <?php if(in_array($key,$customNum)) echo ' checked="checked"';?>  name="customNum[]" />

	                     </td>

	                     <td class="one">                   

		                    <?php if(($key=="field1")) {  //echo $key; ?>

		                    <?php } else { ?>

		                    <span style="float:right;cursor:pointer;color: #FF0415;font-weight: bold;padding-left: 20px;" onclick="deletesch(<?php echo $n =str_replace("field", "", $key); ?>,'')">X</span><?php } ?>

	                     </td>

	                     <td width="400px">&nbsp;</td>

	                </tr>

				<?php $i++;	

					}

				}

				?>

            </tbody>

        </table>

        <table cellpadding="0" cellspacing="0" border="0" class="box2 tabbox contact-edit" style="display:none;margin-top: 0px;margin-bottom: 0px;" >

            <tbody id="afrmsfield">

	            <tr class="tcustom">

	                <th class="one"></th>

	                <td class="two"><b>Custom Field Label </b>

	                	<input type="hidden" name="customa[kcount]" value="<?php echo $kcounta?>" id="akcount" />

	                </td>

	                <td class="two" colspan="3"><b>Set as numeric to allow sorting and searching</b></td>

	            </tr>

	           <?php  if(!$customa){ ?>

	            <tr class="acustom1">

	                <th class="one" width="200px">Custom Fields 1</th>

	                <td class="two">

	                	<input type="text" value="<?php if(isset($customa['field1'])) echo form_prep($customa['field1'])?>" name="customa[field1]" id="afield1" />                 	

	                </td>

	                <td class="one">

	                    <input type="checkbox" class="chkcustomNum" value="field1" name="customNuma[]" />

	                </td>

	                <td class="one">&nbsp;</td>

	                <td width="400px">&nbsp;</td>

	            </tr>

	            <?php }

				else {

					$i=1;

					 foreach($customa as $key=>$value){ ?>

	                <tr class="acustom<?php echo $n =str_replace("field", "", $key);?>">

	                     <th class="one" width="200px">Custom Field <span class="csno"><?php echo $i;?> </span></th>

	                     <td class="two">

	                        <input type="text" value="<?php echo $value; ?>" name="customa[<?php echo $key; ?>]" id="a<?php echo $key; ?>" /> 

	                     </td>

	                     <td class="one">

	                        <input type="checkbox" class="chkcustomNum" value="<?php echo $key; ?>" <?php if(in_array($key,$customNuma)) echo ' checked="checked"';?>  name="customNuma[]" />

	                     </td>

	                     <td class="one">                   

		                    <?php if(($key=="field1")) {  //echo $key; ?>

		                    <?php } else { ?>

		                    <span style="float:right;cursor:pointer;color: #FF0415;font-weight: bold;padding-left: 20px;" onclick="deletesch(<?php echo $n =str_replace("field", "", $key); ?>,'a')">X</span>

		                    <?php } ?>

	                     </td>

	                     <td width="400px">&nbsp;</td>

	                </tr>

				<?php $i++;	

					}

				}

				?>

            </tbody>

        </table>