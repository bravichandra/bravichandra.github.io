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
    $account_types= array("Prospect","Customer - Direct","Customer - Channel","Channel Partner / Reseller","Installation Partner","Technology Partner","Other");
    $industries = array("Agriculture","Apparel","Banking","Biotechnology","Chemicals","Communications","Construction","Consulting","Education","Electronics","Energy","Engineering","Entertainment","Environmental","Finance","Food & Beverage","Government","Healthcare","Hospitality","Insurance","Machinery","Manufacturing","Media","Not For Profit","Recreation","Retail","Shipping","Technology","Telecommunications","Transportation","Utilities","Other");
    ?>
    <!-- LIST POPUP -->
    <div id="crmlistpopup">
        <div class="formRow" style="border-bottom: 1px solid #999999 !important;">
            <div class="qrbox">
                <div class="abox1"><span>Add to List</span></div>
                <div class="abox2"><a href="javascript:void(0)" onclick="hide_catlist()"><span class="ui-icon ui-icon-closethick">close</span></a></div><br clear="all" />
            </div>            
            <form action="<?php echo current_url();?>" id="frmCatg" method="post">
                <input type="hidden" name="action" id="ecatlist" value="srchrectolist" />
                <input type="hidden" name="catrecids" id="catrecids" value="" />
                <div id="gh_anbox">
                    <div>
                        <div class="qebox">
                            <div class="erbox"></div>
                            <label><b>Contacts List</b></label>
                            <div class="box" title="List" id="catglist">
                                <?php foreach($catlist as $crow)    {?>
                                <div>
                                    <input type="checkbox" value="<?php echo $crow->id;?>" class="catlist" name="record[catg][]"/> <?php echo $crow->name;?>
                                </div>
                                <?php }?>
                            </div><br clear="all"><hr>
                            <label><b>Accounts List</b></label>
                            <div class="box" title="List" id="catglist">
                                <?php foreach($catlist2 as $crow)    {?>
                                <div>
                                    <input type="checkbox" value="<?php echo $crow->id;?>" class="catlist" name="record[catg2][]"/> <?php echo $crow->name;?>
                                </div>
                                <?php }?>
                            </div>
                        </div><br clear="all" />

                        <div align="center" style="margin-top: 5px;margin-bottom: 5px;">
                            <a href="javascript:void(0);" class="buttonM bGreen" onclick="hide_catlist()">Cancel</a>
                            <a href="javascript:void(0);" class="buttonM bRed" onclick="save_catlist()">Save</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Main content -->

    <div class="main-wrapper">

        <div class="crmlite">

        <?php if($er) {?>

        <div class="crm-error"><?php echo implode("<br />",$er);?></div>

        <?php }?>

        <!-- Main content -->

        <form method="post" onsubmit="return search_record();" action="<?php echo current_url();?>">

            <input type="hidden" name="action" value="search" />

        <?php if(!$search_listc && !$search_lista && !$search_listt) {?>    

        <table cellpadding="0" cellspacing="0" border="0" class="contact-edit" style="margin-top: 0px;margin-bottom: 0px;width: 100%;">

            <tr>

                <td class="title" colspan="4">

                    <div class="quatabs">

                        <div class="active"><a href="javascript:void(0);" rel="box1">Contacts</a></div>

                        <div><a href="javascript:void(0);" rel="box2">Accounts</a></div>

                        <div><a href="javascript:void(0);" rel="box3">Advanced Lookup</a></div>

                    </div>

                </td>

            </tr>

        </table>



            <table cellpadding="0" cellspacing="0" border="0" class="box1 tabbox contact-edit" style="margin-top: 0px;margin-bottom: 0px;width: 100%;">            

                <tr>

                    <th class="one">Name</th><td class="two">

                    <input type="text" value="<?php if(isset($record[contact][user_first])) echo form_prep($record[contact][user_first])?>" name="record[contact][user_first]" id="user_first" /></td>

                    <th class="one">Title</th><td class="two"><input type="text" value="<?php if(isset($record[contact][user_title])) echo form_prep($record[contact][user_title])?>" name="record[contact][user_title]" /></td>

                </tr>

                <tr>

                    <th class="one">Department</th><td class="two"><input type="text" value="<?php if(isset($record[contact][department])) echo form_prep($record[contact][department])?>" name="record[contact][department]" /></td>

                    <th class="one">Birthdate</th><td class="two"><input type="text" value="<?php if(isset($record[contact][birthdate])) echo form_prep($record[contact][birthdate])?>" name="record[contact][birthdate]" id="birthdate" /></td>

                </tr>

                <tr>                

                    <th class="one">Lead Source</th><td><select name="record[contact][lead_source]" id="lead_source">

                        <option value="">None</option>

                           <?php foreach($lead as $led){ ?>
                 		 <option value="<?php echo $led ?>"<?php $sel='';if(isset($record[lead_source]) && $record[lead_source]==$led) echo $sel=' selected="selected"'?>><?php echo $led; ?></option>
				           <?php }  ?>
                    </select></td>

                    <th class="one">Email</th><td class="two"><input type="text" value="<?php if(isset($record[contact][email])) echo form_prep($record[contact][email])?>" name="record[contact][email]" /></td>

                </tr>

                <tr>

                    <th class="one">Mailing Street</th><td class="two"><input type="text" value="<?php if(isset($record[contact][amail][street])) echo form_prep($record[contact][amail][street])?>" name="record[contact][amail][street]" /></td>

                    <th class="one">Mailing City</th><td class="two"><input type="text" value="<?php if(isset($record[contact][amail][city])) echo form_prep($record[contact][amail][city])?>" name="record[contact][amail][city]" /></td>

                </tr>

                <tr>

                    <th class="one">Mailing State/Province</th><td class="two"><input type="text" value="<?php if(isset($record[contact][amail][state])) echo form_prep($record[contact][amail][state])?>" name="record[contact][amail][state]" /></td>

                    <th class="one">Mailing Zip/Postal Code</th><td class="two"><input type="text" value="<?php if(isset($record[contact][amail][zipcode])) echo form_prep($record[contact][amail][zipcode])?>" name="record[contact][amail][zipcode]" /></td>

                </tr>

                <tr>

                    <th class="one">Mailing Country</th><td class="two"><input type="text" value="<?php if(isset($record[contact][amail][country])) echo form_prep($record[contact][amail][country])?>" name="record[contact][amail][country]" /></td>

                    <th class="one">Description</th><td class="two"><input type="text" value="<?php if(isset($record[contact][description])) echo form_prep($record[contact][description])?>" name="record[contact][description]" /></td>

                </tr>

                <?php     

                    foreach($custom as $ck=>$cv){ 

                        $kc++;

                        if($kc>1 && $kc%2==1) echo '</tr>';

                        if($kc%2==1) echo '<tr>';?>

                    <th class="one"><?php echo $cv?></th>

                    <td class="two">

                    <input type="text" value="<?php if(isset($record[contact][Ccustom][ck])) echo form_prep($record[contact][Ccustom][$ck])?>" name="record[contact][Ccustom][<?php echo $ck?>]" id="<?php echo $ck?>" maxlength="100" /></td>

                    <?php }    

                    echo '</tr>'; ?>

                

            </table>

        

            <table cellpadding="0" cellspacing="0" border="0"  class="box2 tabbox contact-edit" style="display: none;margin-top: 0px;margin-bottom: 0px;width: 100%;">

                <tr>

                    <th class="one">Account Name</th><td class="two"><input type="text" value="<?php if(isset($record[account][account_name])) echo form_prep($record[account][account_name])?>" name="record[account][account_name]" id="account_name" /></td>

                    <th class="one">Industry</th><td class="two"><select name="record[account][industry]">

                        <option value="">None</option>

                        <?php $sel='';foreach($industries as $aval){?>

                        <option value="<?php echo $aval;?>"<?php if(isset($record[account][industry]) && $record[account][industry]==$aval) echo $sel=' selected="selected"'?>><?php echo $aval;?></option>

                        <?php }?>

                        </select></td>

                </tr>

                <tr>

                    <th class="one">Type</th><td class="two"><select name="record[account][account_type]">

                        <option value="">None</option>

                        <?php $sel='';foreach($account_types as $aval){?>

                        <option value="<?php echo $aval;?>"<?php if(isset($record[account][account_type]) && $record[account][account_type]==$aval) echo $sel=' selected="selected"'?>><?php echo $aval;?></option>

                        <?php }?>

                        </select></td>

                        <th class="one">Annual Revenue</th><td class="two"><input type="text" value="<?php if(isset($record[account][revenue]) && $record[account][revenue]) echo form_prep($record[account][revenue])?>" name="record[account][revenue]" /></td>

                </tr>

                <tr>

                    <th class="one">Employees</th><td class="two"><input type="text" value="<?php if(isset($record[account][employees]) && $record[account][employees]) echo form_prep($record[account][employees])?>" name="record[account][employees]" /></td>

                    <th class="one">SIC Code</th><td class="two"><input type="text" value="<?php if(isset($record[account][siccode])) echo form_prep($record[account][siccode])?>" name="record[account][siccode]" /></td>

                </tr>

                <tr>

                    <th class="one">Billing Street</th><td class="two"><input type="text" value="<?php if(isset($record[account][billing][street])) echo form_prep($record[account][billing][street])?>" name="record[account][billing][street]" /></td><th class="one">Shipping Street</th><td class="two"><input type="text" value="<?php if(isset($record[account][shipping][street])) echo form_prep($record[account][shipping][street])?>" name="record[account][shipping][street]" /></td>

                </tr>

                <tr>

                    <th class="one">Billing City</th><td class="two"><input type="text" value="<?php if(isset($record[account][billing][city])) echo form_prep($record[account][billing][city])?>" name="record[account][billing][city]" /></td><th class="one">Shipping City</th><td class="two"><input type="text" value="<?php if(isset($record[account][shipping][city])) echo form_prep($record[account][shipping][city])?>" name="record[account][shipping][city]" /></td>

                </tr>

                <tr>

                    <th class="one">Billing State/Province</th><td class="two"><input type="text" value="<?php if(isset($record[account][billing][state])) echo form_prep($record[account][billing][state])?>" name="record[account][billing][state]" /></td><th class="one">Shipping State/Province</th><td class="two"><input type="text" value="<?php if(isset($record[account][shipping][state])) echo form_prep($record[account][shipping][state])?>" name="record[account][shipping][state]" /></td>

                </tr>

                <tr>

                    <th class="one">Billing Zip/Postal Code</th><td class="two"><input type="text" value="<?php if(isset($record[account][billing][zipcode])) echo form_prep($record[account][billing][zipcode])?>" name="record[account][billing][zipcode]" /></td><th class="one">Shipping Zip/Postal Code</th><td class="two"><input type="text" value="<?php if(isset($record[account][shipping][zipcode])) echo form_prep($record[account][shipping][zipcode])?>" name="record[account][shipping][zipcode]" /></td>

                </tr>

                <tr>

                    <th class="one">Billing Country</th><td class="two"><input type="text" value="<?php if(isset($record[account][billing][country])) echo form_prep($record[account][billing][country])?>" name="record[account][billing][country]" /></td><th class="one">Shipping Country</th><td class="two"><input type="text" value="<?php if(isset($record[account][shipping][country])) echo form_prep($record[account][shipping][country])?>" name="record[account][shipping][country]" /></td>

                </tr>
                
                <tr>

                    <th class="one">Description</th><td class="two"><input type="text" value="<?php if(isset($record[account][description]) && $record[account][description]) echo form_prep($record[account][description])?>" name="record[account][description]" /></td>

                    <th class="one">&nbsp;</th><td class="two">&nbsp;</td>

                </tr>

                

                <?php     foreach($customa as $ck=>$cv){ 

                            $kc++;

                            if($kc>1 && $kc%2==1) echo '</tr>';

                            if($kc%2==1) echo '<tr>';?>

                        <th class="one"><?php echo $cv?></th>

                        <td class="two">

                        <input type="text" value="<?php if(isset($record[account][Acustom][$ck])) echo form_prep($record[account][Acustom][$ck])?>" name="record[account][Acustom][<?php echo $ck?>]" id="<?php echo $ck?>" maxlength="100" /></td>

                        <?php }    

                        echo '</tr>'; ?>

            </table>

            <table cellpadding="0" cellspacing="0" border="0"  class="box3 tabbox contact-edit" style="display: none;margin-top: 0px;margin-bottom: 0px;width: 100%;">

                <tr>

                    <th class="title" colspan="4">Contact</th>

                </tr>

                <!-- More Search -->

                <tr>

                    <th class="one">Search by Field: </th>

                    <td class="two">

                        <input type="hidden" id="colftype1" value="<?php if(isset($record[contact][colftype])) echo form_prep($record[contact][colftype])?>" name="record[contact][colftype]"/>

                        <select name="record[contact][colsearch]" onchange="searchField(this,1)">

                            <option value="">Search Field</option>

                            <?php 

                                foreach($contact_fields as $col) {

                                    echo '<option value="'.$col[0].'" '.((isset($record[contact][colsearch]) && $record[contact][colsearch]==$col[0])?' selected="selected"':'').' ctype="'.$col[2].'">'.$col[1].'</option>';

                                }

                            ?>

                        </select>

                        <select id="colstype1" name="record[contact][colstype]" onchange="searchFieldMode(this,1)">

                            <option value="">Search Type</option>                        

                            <?php 

                                $colftype = (isset($record[contact][colftype]) && $record[contact][colftype])?$record[contact][colftype]:'';

                                $colstype = (isset($record[contact][colstype]) && $record[contact][colstype])?$record[contact][colstype]:'';

                                if($colftype==1) {

                                    echo '<option value="4" '.($colstype=='4'?' selected="selected"':'').'>Contains</option>';

                                } else if($colftype==2) {

                                    echo '<option value="1" '.($colstype=='1'?' selected="selected"':'').'>Less than</option>';

                                    echo '<option value="2" '.($colstype=='2'?' selected="selected"':'').'>Greater than</option>';

                                    echo '<option value="3" '.($colstype=='3'?' selected="selected"':'').'>Between</option>';

                                    echo '<option value="4" '.($colstype=='4'?' selected="selected"':'').'>Contains</option>';

                                }

                            ?>

                        </select>

                    </td>

                    <td class="two">

                        <input type="text" value="<?php if(isset($record[contact][colsfield1])) echo form_prep($record[contact][colsfield1])?>" name="record[contact][colsfield1]" id="colsfield11" <?php if($colstype=='') echo 'style="display: none;"';?> />&nbsp;

                    </td>

                    <td class="two">

                        <input type="text" value="<?php if(isset($record[contact][colsfield2])) echo form_prep($record[contact][colsfield2])?>" name="record[contact][colsfield2]" id="colsfield21" <?php if($colstype=='' || $colstype==4) echo 'style="display: none;"';?>/>&nbsp;

                    </td>

                </tr>

                <!-- end of More Search -->

                <tr>

                    <th class="title" colspan="4">Account</th>

                </tr>

                <!-- More Search -->

                <tr>

                    <th class="one">Search by Field: </th>

                    <td class="two">

                        <input type="hidden" id="colftype2" value="<?php if(isset($record[account][colftype])) echo form_prep($record[account][colftype])?>" name="record[account][colftype]"/>

                        <select name="record[account][colsearch]" onchange="searchField(this,2)">

                            <option value="">Search Field</option>

                            <?php 

                                foreach($account_fields as $col) {

                                    echo '<option value="'.$col[0].'" '.((isset($record[account][colsearch]) && $record[account][colsearch]==$col[0])?' selected="selected"':'').' ctype="'.$col[2].'">'.$col[1].'</option>';

                                }

                            ?>

                        </select>

                        <select id="colstype2" name="record[account][colstype]" onchange="searchFieldMode(this,2)">

                            <option value="">Search Type</option>                        

                            <?php 

                                $colftype = (isset($record[account][colftype]) && $record[account][colftype])?$record[account][colftype]:'';

                                $colstype = (isset($record[account][colstype]) && $record[account][colstype])?$record[account][colstype]:'';

                                if($colftype==1) {

                                    echo '<option value="4" '.($colstype=='4'?' selected="selected"':'').'>Contains</option>';

                                } else if($colftype==2) {

                                    echo '<option value="1" '.($colstype=='1'?' selected="selected"':'').'>Less than</option>';

                                    echo '<option value="2" '.($colstype=='2'?' selected="selected"':'').'>Greater than</option>';

                                    echo '<option value="3" '.($colstype=='3'?' selected="selected"':'').'>Between</option>';

                                    echo '<option value="4" '.($colstype=='4'?' selected="selected"':'').'>Contains</option>';

                                }

                            ?>

                        </select>

                    </td>

                    <td class="two">

                        <input type="text" value="<?php if(isset($record[account][colsfield1])) echo form_prep($record[account][colsfield1])?>" name="record[account][colsfield1]" id="colsfield12" <?php if($colstype=='') echo 'style="display: none;"';?> />&nbsp;

                    </td>

                    <td class="two">

                        <input type="text" value="<?php if(isset($record[account][colsfield2])) echo form_prep($record[account][colsfield2])?>" name="record[account][colsfield2]" id="colsfield22" <?php if($colstype=='' || $colstype==4) echo 'style="display: none;"';?>/>&nbsp;

                    </td>

                </tr>

                <!-- end of More Search -->
                
                
                
                <tr>

                    <th class="title" colspan="4">Tasks</th>

                </tr>

                <!-- More Search -->

                <tr>

                    <th class="one">Search by Field: </th>

                    <td class="two">

                        <input type="hidden" id="colftype3" value="<?php if(isset($record[task][colftype])) echo form_prep($record[task][colftype])?>" name="record[task][colftype]"/>

                        <select name="record[task][colsearch]" onchange="searchField(this,3)">

                            <option value="">Search Field</option>

                            <?php 

                                foreach($task_fields as $col) {
								
								 // echo '<pre>'; print_r($col); echo '</pre>';

                                    echo '<option value="'.$col[0].'" '.((isset($record[task][colsearch]) && $record[task][colsearch]==$col[0])?' selected="selected"':'').' ctype="'.$col[2].'">'.$col[1].'</option>';

                                }

                            ?>

                        </select>

                        <select id="colstype3" name="record[task][colstype]" onchange="searchFieldMode(this,3)">

                            <option value="">Search Type</option>                        

                            <?php 

                                $colftype = (isset($record[task][colftype]) && $record[task][colftype])?$record[task][colftype]:'';

                                $colstype = (isset($record[task][colstype]) && $record[task][colstype])?$record[task][colstype]:'';

                                if($colftype==1) {
                                    echo '<option value="4" '.($colstype=='4'?' selected="selected"':'').'>Contains</option>';

                                } 
                            ?>

                        </select>

                    </td>

                    <td class="two">

                        <input type="text" value="<?php if(isset($record[task][colsfield1])) echo form_prep($record[task][colsfield1])?>" name="record[task][colsfield1]" id="colsfield13" <?php if($colstype=='') echo 'style="display: none;"';?> />&nbsp;

                    </td>

                    <td class="two">

                        <input type="text" value="<?php if(isset($record[task][colsfield2])) echo form_prep($record[task][colsfield2])?>" name="record[task][colsfield2]" id="colsfield23" <?php if($colstype=='' || $colstype==4) echo 'style="display: none;"';?>/>&nbsp;

                    </td>

                </tr>

                <!-- end of More Search -->
                
                

            </table>



            <table cellpadding="0" cellspacing="0" border="0" class="contact-edit" style="margin-top: 0px;margin-bottom: 0px;width: 100%;">

                <tr>

                    <td colspan="4" align="center">

                        <div class="fluid" style="margin-top:15px;">

                            <input type="submit" class="buttonM bBlue" name="form_submit" value="Search" />

                        </div>

                    </td>

                </tr>

            </table>



        <?php }?>   

        <?php if($search_listc || $search_lista || $search_listt) {?>
          
        <div class="crm-menu">
            <a href="javascript:void(0);" onclick="catlist_popup()" class="buttonM bBlack addtolist">Add to List</a>
            <div align="left">
                <div class="quatabs">
                     <div class="<?php if($search_listc) echo 'active'; else echo ''; ?>"><a href="javascript:void(0);" rel="box1">Contacts</a></div>
                     <div class="<?php if($search_lista) echo 'active'; else echo ''; ?>"><a href="javascript:void(0);" rel="box2">Accounts</a></div>
                    <div class="<?php if($search_listt) echo 'active'; else echo ''; ?>"><a href="javascript:void(0);" rel="box3">Tasks</a></div>
                </div>
            </div>
        </div>
        <div class="box1 tabbox" style="display:<?php if($search_listc) echo 'block'; else echo 'none'; ?>">
        <table style='background: none repeat scroll 0 0 #E6E6E6; width:95%' class='tDefault dtskTable'>

            <thead>

                <tr>
                    <th style="width: 40px;"><input type="checkbox" id="selectallc" /></th>
                    <th class='no-border'>Contact</th>

                    <th class='no-border'>Account</th>

                    <th class='no-border'>Record Owner</th>

                    <th class='no-border' style="width:100px;">Phone</th>

                    <th class='no-border'  style="width:140px;">Quality Points</th>

                </tr>

            </thead>

            <tbody>

                <?php foreach($search_listc as $crow)    {?>

                <tr>
                    <td class='no-border'><input type="checkbox" value="<?php echo 'C-'.$crow->contact_id;?>" name="recids[]" class="rcselect" /></td>

                    <td class='no-border'>

                    <?php if(isset($crow->user_first)) {?>

                    <a href="<?php echo base_url(); ?>crm/contacts/view/<?php echo $crow->contact_id;?>"><?php echo $crow->user_first.' '.$crow->user_last;?></a>

                    <?php }?>    

                    </td>

                    <td class='no-border'>

                    <?php if(isset($crow->account_id)) {?>

                    <a href="<?php echo base_url(); ?>crm/accounts/view/<?php echo $crow->account_id;?>"><?php echo $crow->account_name;?></a>

                    <?php }?>

                    </td>

                    <td class='no-border'><?php echo ucfirst($crow->usrname);?></td>

                    <td class='no-border'><?php if($crow->phone) echo '<a href="tel:'.$crow->phone.'">'.$crow->phone.'</a>';?></td>

                    <td class='no-border'><?php echo $crow->qpoints;?></td>

                </tr>

                <?php }?>

            </tbody>

        </table>
        </div>
        <div class="box2 tabbox" style="display:<?php if($search_lista) echo 'block'; else echo 'none'; ?>">

        <table style='background: none repeat scroll 0 0 #E6E6E6; width:95%;' class='tDefault dtskTable'>

            <thead>

                <tr>
                    <th style="width: 40px;"><input type="checkbox" id="selectalla" /></th>
                    <th class='no-border'>Account</th>
                    <th class='no-border'>Contact</th>

                    <th class='no-border'>Record Owner</th>

                    <th class='no-border' style="width:100px;">Phone</th>

                    <th class='no-border'  style="width:140px;">Quality Points</th>

                </tr>

            </thead>

            <tbody>

                <?php foreach($search_lista as $crow)    {?>

                <tr>
                    <td class='no-border'><input type="checkbox" value="<?php echo 'A-'.$crow->account_id;?>" name="recids[]" class="rcselect" /></td>

                    <td class='no-border'>

                    <?php if(isset($crow->account_id)) {?>

                    <a href="<?php echo base_url(); ?>crm/accounts/view/<?php echo $crow->account_id;?>"><?php echo $crow->account_name;?></a>

                    <?php }?>

                    </td>

                    <td class='no-border'>

                    <?php if(isset($crow->user_first)) {?>

                    <a href="<?php echo base_url(); ?>crm/contacts/view/<?php echo $crow->contact_id;?>"><?php echo $crow->user_first.' '.$crow->user_last;?></a>

                    <?php }?>    

                    </td>

                    

                    <td class='no-border'><?php echo ucfirst($crow->usrname);?></td>

                    <td class='no-border'><?php if($crow->phone) echo '<a href="tel:'.$crow->phone.'">'.$crow->phone.'</a>';?></td>

                    <td class='no-border'><?php echo $crow->qpoints;?></td>

                </tr>

                <?php }?>

            </tbody>

        </table>
        </div>
        
        
        <div class="box3 tabbox" style="display:<?php if($search_listt) echo 'block'; else echo 'none'; ?>">
        <table style='background: none repeat scroll 0 0 #E6E6E6; width:95%' class='tDefault dtskTable'>

            <thead>

                <tr>
                    <th style="width: 40px;"><?php /*?><input type="checkbox" id="selectallc" /><?php */?></th>
                    
                    <th class='no-border'>Subject</th>                    
                    
                    <th class='no-border'>Contact</th>

                    <th class='no-border'>Account</th>

                    <th class='no-border' style="width:100px;">Phone</th>

                    <th class='no-border'>Due Date</th>

                    <th class='no-border'>Priority</th>

                    <th class='no-border'  style="width:140px;">Quality Points</th>

                </tr>

            </thead>

            <tbody>

                <?php foreach($search_listt as $trow)    { //echo '<pre>'; print_r($trow); echo '</pre>';                	
                    //echo $trow->task_related;
                    if($trow->task_related=='C') {
						$parent_record =$this->crm->get_notes_parent($trow->task_relatedto,'C');
						if($parent_record) {
							//echo '<pre>'; print_r($parent_record); echo '</pre>';
							$contact_id =$trow->task_relatedto;
							$contact_name=ucfirst($parent_record['user_first']." ".$parent_record['user_last']);
							$qpoints = $parent_record['ipoints'];
						}	
					} else if($trow->task_related=='A') {
						$parent_record =$this->crm->get_notes_parent($trow->task_relatedto,'A');
						if($parent_record) {
							$account_id =$trow->task_relatedto;
							$account_name=ucfirst($parent_record['account_name']);
							$qpoints = $parent_record['ipoints'];
						}
					}
                
					?>

                <tr>
                    <td class='no-border'><input type="checkbox" value="<?php echo 'C-'.$trow->contact_id;?>" name="recids[]" class="rcselect" /></td>
                    
                    <td class='no-border'>

                    	<a href="<?php echo base_url(); ?>crm/tasks/view/<?php echo $trow->task_id;?>"><?php echo ucfirst($trow->task_subject);?></a>

                    </td>

                    <td class='no-border'>

                    	<a href="<?php echo base_url(); ?>crm/contacts/view/<?php echo $contact_id;?>"><?php echo $contact_name;?></a>

                    </td>

                    <td class='no-border'>

					<a href="<?php echo base_url(); ?>crm/accounts/view/<?php echo $account_id;?>"><?php echo $account_name;?></a>

                   	</td>
                    
                    <td class='no-border'><?php if($trow->task_phone) echo '<a href="tel:'.$trow->task_phone.'">'.$trow->task_phone.'</a>';?></td>

                    <td class='no-border'><?php echo ucfirst($trow->task_duedate);?></td>

                    <td class='no-border'><?php echo ucfirst($trow->task_priority);?></td>

                    <td class='no-border'><?php echo number_format($qpoints);?></td>

                </tr>

                <?php }?>

            </tbody>

        </table>
        </div>

        <?php }?>

        </form>

        </div>

    </div>

    <!-- Main content ends -->    

</div><br clear="all" />

<link href="<?php echo base_url();?>/css/datepicker.css" rel="stylesheet">

<script src="<?php echo base_url();?>js/bootstrap-datepicker.js"></script>

<script type="text/javascript">

    //Save record

    function search_record(){

        var er=0;

        $(".two input, .two select").each(function(){

            if($(this).val()!="") {

                er=1;

                return;

            }

        });

        if(er==0) {

            alert("Enter search key");

            return false;

        }

        return true;

    }

    //Search by field

    function searchField(dis,csno) {        

        $("#colsfield1"+csno).hide();

        $("#colsfield1"+csno).val('');

        $("#colsfield2"+csno).hide();

        $("#colsfield2"+csno).val('');

        var cftype = $(dis).find(':selected').attr('ctype');

        $("#colftype"+csno).val(cftype);

        var csoptions = '<option value="">Search Type</option>';

        if(cftype=='1') csoptions += '<option value="4">Contains</option>';

        else if(cftype=='2') csoptions += '<option value="1">Less than</option><option value="2">Greater than</option><option value="3">Between</option><option value="4">Contains</option>';

        $("#colstype"+csno).html(csoptions);

    }

    function searchFieldMode(dis,csno) {

        $("#colsfield1"+csno).hide();

        $("#colsfield1"+csno).val('');

        $("#colsfield2"+csno).hide();

        $("#colsfield2"+csno).val('');

        if(dis.value=='') return;

        else if(dis.value=='1' || dis.value=='2' || dis.value=='4') $("#colsfield1"+csno).show();

        else if(dis.value=='3') {$("#colsfield1"+csno).show();$("#colsfield2"+csno).show();}

    }



    //end of search by field

    $(document).ready(function(){

        //search tabs

        $('.quatabs a').click(function(e){

            $('.quatabs div').removeClass("active");

            $(this).parent().addClass("active");

            //$('.quaboxes div').removeClass("active");

            $('.tabbox').hide();

            //$('.quaboxes #'+$(this).attr("rel")).addClass("active");

            $('.tabbox.'+$(this).attr("rel")).show();

        });

        $("#birthdate").datepicker({format: 'mm/dd/yyyy'}).on('changeDate', function(ev){

            $(this).datepicker('hide');

        });

        <?php if($search_listc || $search_lista || $search_listt) {?>

        oTable.fnSort( [ [4,'desc'] ] );

        <?php }?>
        /*Category List*/
        $("#selectallc").change(function(){
            $(".box1 .rcselect").prop("checked",$(this).prop("checked"));
        });
        $("#selectalla").change(function(){
            $(".box2 .rcselect").prop("checked",$(this).prop("checked"));
        }); 

        var oTaskTable = $('.dtskTable').dataTable({
            "bJQueryUI": true,
            "bAutoWidth": false,
            "iDisplayLength": 50,
			"lengthChange": false,
            "sPaginationType": "full_numbers",
            "sDom": '<"H"fl>t<"F"ip>',
            language: {
                searchPlaceholder: "Find Record"
            },
            "deferRender": true,
            /*"columnDefs": [
                { "orderable": false, "targets": 0 }
              ],*/
            "aoColumns": [
                { "bSortable": false },
                { "bSortable": true },
                { "bSortable": true },
                { "bSortable": true },
                { "bSortable": true },
                { "bSortable": true }
            ],
            //"bSort": false,
        });
        oTaskTable.fnSort( [ [5,'desc'] ] ); 

    });

    /*Category List*/
    //Hide Fade
    function hide_catlist(){
        $("#crmlistpopup").hide();
        $(".overlayBackground").hide();
    }
    //Popup
    function catlist_popup() {        
        if($(".rcselect:checked").length==0) {
            alert("Select records");
            return false;
        }
        $("#crmlistpopup .qrbox .abox1 span").html('Add to List');
        $("#crmlistpopup").show();
        $(".overlayBackground").show();
    }
    //Save Catlist
    function save_catlist() 
    {
        if($(".rcselect:checked").length==0) {
            alert("Select records");
            return false;
        }
        if($(".catlist:checked").length==0) {
            alert("Select lists");
            return false;
        }
        var recids = '';
        $(".rcselect:checked").each(function(){
            if(recids) recids += ',';
            recids += $(this).val();
        });
        $("#catrecids").val(recids);
        $.ajax({
            type : 'POST',
            url : '<?php echo current_url();?>',
            data: $("#frmCatg").serialize(),
            cache: false,
            success: function(responce)
            {                
                alert(responce);
                hide_catlist();
                //location.replace("<?php echo current_url();?>");
            }
        });


        
    }
    /*Category List*/

</script>

<!-- Content ends -->

<?php $this->load->view('common/footer'); ?>