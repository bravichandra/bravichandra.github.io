<h1 class="sub-dev-head"><?php echo $parts[$partid]['title'];?></h1>
<div class="scroll-bar_sf">
<p>Oh, OK. Well, as we talk with other <span class="dynamic_value "><?php 
                if($campaign_info->campaign_target == '1'){	
                        echo $campaign_info->individual;
                    }else{
                        echo $campaign_info->organization;
                }
            ?></span>, we have noticed that they often express challenges with <span class="red-area">(or concerns around)</span> :</p><br/>
            
                    <?php if (isset($campaign_output_tech_pain)):?>
                        <ul>
                            <?php foreach ($campaign_output_tech_pain as $single_tech_pain):?>
                                <li><span class="<?php echo 'dynamic_value edit_area' ;?>" id="tpnd_<?php echo $single_tech_pain->tech_p_id ?>_<?php  echo $campaign_info->campaign_id; ?>"><?php echo ucfirst($single_tech_pain->value);?></span></li>
                            <?php endforeach;?>
                        </ul>
                    <?php endif;?> 
            <br/>
            <p>Can you relate to any of those?</p>
            <p><span class="red-area">-or-</span></p>
            <p>Which one of those are you most concerned with?</p>
</div>