<h1 class="sub-dev-head"><?php echo $parts[$partid]['title'];?></h1>
<div class="scroll-bar_sf">
<p>
    <p>If I could ask you real quick:</p>
        <p><span class="red-area">(Ask 3 to 5 of the questions below)</span></p>
        
            <?php /*?><?php if (isset($campaign_output_tech_qualify)):?>
                <ul>
                    <?php foreach ($campaign_output_tech_qualify as $single_tech_qualify):?>
                        <?php // print_r($single_tech_value) ?>
                        <li><span class="<?php echo 'dynamic_value edit_area'; ?>" id="tqd_<?php echo $single_tech_qualify->tech_q_id ?>_<?php echo $campaign_info->campaign_id; ?>"><?php echo $single_tech_qualify->value;?></span></li>
                    <?php endforeach;?>
                </ul>
            <?php endif;?><?php */?> 
            <?php if (isset($campaign_output_qualify)) echo $campaign_output_qualify;?>
            <br/>
</p>
</div>