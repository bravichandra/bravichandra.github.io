<style>
.ui-progressbar .ui-progressbar-value {background:#b30814;}
</style>
<div class="formRow"  style="border:none;width:50%; margin: 0 auto;">
      <div class="grid9">
             <div class="grid12" align="center"><h5>Completion Progress</h5></div>
                    <div id="proagress" class="ui-progressbar ui-widget ui-widget-content ui-corner-all" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="80"><div class="ui-progressbar-value ui-widget-header ui-corner-left" style="width: <?php echo (isset($percentage) ?  $percentage.'%' : '0%');?>;"></div>
                    </div>

                    <span class="percent"><strong><?php echo ceil($percentage) . '%';?></strong></span>
       </div>
       <div class="clear"></div>
</div>