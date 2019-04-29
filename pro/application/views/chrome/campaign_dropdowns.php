<div style="background: none;height: auto;">
   <div class="bc" style="margin-top: 36px;margin-bottom: 10px;">
      <?php
         $attributes = ['id' => 'frm_ssdropmenu', 'method' => 'post'];
         echo form_open('', $attributes);
         ?>
      <ul id="breadcrumbs" class="breadcrumbs" style="list-style-type: none;">
         <li id="sales_pitch"><span> Sales Pitch </span></li>
         <li>
            <?php if (count($drop_campaign) > 0) {
             ?>
            <select name="activecompaignname" id="ss_activecompaignname">
               <option value="">Select</option>
               <?php foreach ($drop_campaign  as $singlecampaign) {
                 ?>
               <option value="<?php echo $singlecampaign->campaign_id ?>"  <?php if ($singlecampaign->status == 1) {
                     echo 'selected';
                 } ?> ><?php echo $singlecampaign->campaign_name ?> </option>
               <?php
             } ?>
            </select>
            <?php
         } ?>
         </li>
         <li> <span>Name Drop </span></li>
         <li>
            <?php if (count($drop_name) > 0) {
             ?>
            <select name="activedropname" id="ss_activedropname">
               <option value="">Select</option>
               <?php foreach ($drop_name  as $singledropname) {
                 ?>
               <option value="<?php echo $singledropname->c_id ?>"  <?php if ($singledropname->status == 1) {
                     echo 'selected';
                 } ?>  ><?php //echo $singledropname->credibility_name?><?php echo($singledropname->value ? $singledropname->value : $singledropname->credibility_name); ?></option>
               <?php
             } ?>
            </select>
            <?php
         } ?>	
         </li>
         <li><span> Company </span></li>
         <li>
            <?php if (count($drop_company) > 0) {
             ?>
            <select name="activecompanyname" id="ss_activecompanyname">
               <option value="">Select</option>
               <?php foreach ($drop_company  as $singlecompany) {
                 ?>
               <option value="<?php echo $singlecompany->company_id; ?>" <?php if ($singlecompany->status == 1) {
                     echo 'selected';
                 } ?>   ><?php echo $singlecompany->company_name; ?> </option>
               <?php
             } ?>
            </select>
            <?php
         } ?>
         </li>
      </ul>
      </form>
   </div>
</div>
<br clear="all" /><br clear="all" />