<?php $this->load->view('common/meta'); ?>	

<?php $this->load->view('common/header'); ?>

<!-- Sidebar begins -->

<div id="sidebar">

    <?php $this->load->view('common/left_navigation'); ?>

	<!-- Secondary nav -->    

    <div class="secNav">

        <div class="clear"></div>

    </div>

</div>



<!-- Sidebar ends --> <!-- Content begins -->

<div id="content">

	<!-- Breadcrumbs line -->

	<?php  		

	$this->load->view('common/crm_nav');

	?>

	<!-- Main content -->

    <div class="main-wrapper">

        <?php if($er) {?>

        <div class="crm-error"><?php echo implode("<br />",$er);?></div>

        <?php }?>

		<!-- Main content -->

        <form method="post" onsubmit="return save_record();" action="<?php echo current_url();?>">

        	<input type="hidden" name="action" value="save" />

        <table cellpadding="0" cellspacing="0" border="0" class="contact-edit">

        	<tr>

            	<th class="title" colspan="2">List Details</th>

            </tr>

            <tr>

                <th class="one" width="300px">Name</th>

                <td class="two"><input type="text" id="name" value="<?php if(isset($record[name])) echo form_prep($record[name])?>" name="record[name]" /></td>                

            </tr>
            <tr>

                <th class="one">Share list with connected users</th>
                <td class="two">
                    <input type="checkbox" value="1" <?php if(isset($record[share]) && $record[share]) echo ' checked="checked"'?> name="record[share]" /> 
                </td>                

            </tr>

            <tr>

                <th class="one">Description</th>

                <td class="two"><textarea style="height:100px;" name="record[info]"><?php if(isset($record[info])) echo $record[info]?></textarea></td>

            </tr>
            <tr>

            	<td colspan="2" align="center">

                    <div class="fluid" style="margin-top:15px;">

                        <input type="submit" class="buttonM bBlue" name="form_submit" value="Save" />
                        <input type="submit" class="buttonM bRed" name="form_submit_done" value="Done" />

                    </div>	

                </td>

            </tr>
            </table>
         	<table  cellpadding="0" cellspacing="0" border="0" class="contact-edit">
            <?php if($section==1) {?>
            <tr>
                <th class="title" colspan="2">List Form (Optional)</th>
            </tr>

            <tr>

                <th class="one" width="300px">Form Title</th>

                <td class="two"><input type="text" id="formtitle" value="<?php if(isset($record[formtitle])) echo form_prep($record[formtitle]); else $record[name];?>" name="record[formtitle]" /></td>                

            </tr>
            <tr>
                <th class="one" width="300px">Form Description</th>
                <td class="two"><textarea rows="5" name="record[forminfo]" style="height:100px;"><?php if(isset($record[forminfo])) echo form_prep($record[forminfo]);?></textarea></td>
            </tr>

            <tr>
                <th class="one">Select Field</th>
                <td class="two">
                    <select id="cfield" class="tbcol" onchange="getField()">
                        <option value="">Select Field</option>
                        <?php foreach($contact_fields as $ri=>$rv){if($ri=='target') continue;?>
                        <option value="<?php echo $ri;?>"><?php echo $rv;?></option>
                        <?php }?>
                    </select>
                </td>
            </tr>
            <tr>
                <th class="one">Selected Fields</th>
                <td class="two">
                    <div>Note: You can drag the fields for selected sorting order</div>
                    <div id="scfields">
                        <ul id="sortable">
                            <?php if(isset($record[form]) && $record[form])
                                foreach ($record[form] as $value) {
                                ?>
                            <li class="ui-state-default"><div class="cfbox '+sfield_id+'"><input type="hidden" name="record[cfield][]" value="<?php echo $value;?>" /><?php echo $contact_fields[$value];?> <span><a href="javascript:void(0);" onclick="delField(this)">X</a></span></div></li>
                            <?php }?>
                        </ul>
                    </div>
                </td>
            </tr>

            <?php if(isset($record['form']) && $record['form'] && isset($record['id']) && $record['id']){?>
            <tr>
                <th class="one" width="300px">List Form Code</th>
                <td class="two"><textarea readonly="readonly" rows="5" style="height:100px;"><?php //echo $listForm;
                    echo '<script src="'.base_url().'js/widget.js?'.$listrow['id'].'" id="ssScriptSrc" type="text/javascript"></script><div id="ssListForm"></div>';
                ?></textarea></td>
            </tr>
            <?php }?>

            <?php }?>

            <tr>

            	<td colspan="2" align="center">

                    <div class="fluid" style="margin-top:15px;">

                        <input type="submit" class="buttonM bBlue" name="form_submit" value="Save" />

                        <input type="submit" class="buttonM bRed" name="form_submit_done" value="Done" />

                    </div>	

                </td>

            </tr>

        </table>

        </form>	

	</div>

    <!-- Main content ends -->

</div>

<script type="text/javascript">

	//Skip hint

	function save_record(){

		if($("#name").val().length==0) {

			alert("Name required");

			$("#name").focus();

			return false;

		}

		return true;

	}

    //Get field to Form
    function getField() {
        var sfield_id = $("#cfield").val();
        if(sfield_id=="") return;
        if($("."+sfield_id).length) {
            alert("Field already selected");
            return;
        }
        var sfield_title = $("#cfield option:selected").text();
        var sfieldbox = '<li class="ui-state-default"><div class="cfbox '+sfield_id+'"><input type="hidden" name="record[cfield][]" value="'+sfield_id+'" />'+sfield_title+' <span><a href="javascript:void(0);" onclick="delField(this)">X</a></span></div></li>';
        $("#sortable").append(sfieldbox);
        $( "#sortable" ).sortable( "refresh" );
    }
    //Delete field box
    function delField(dis){
        if(!confirm('Are you sure you want to delete?')) return;
        var disbox = $(dis).parents('li');
        disbox.remove();
    }

    $(document).ready(function(){
        $( "#sortable" ).sortable();
    });

</script>

<!-- Content ends -->

<?php $this->load->view('common/footer'); ?>