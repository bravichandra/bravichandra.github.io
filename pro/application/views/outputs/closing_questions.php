<?php $this->load->view('common/meta_outputs');?>
<title><?php if(isset($uCustTemplate['template_title'])) echo $uCustTemplate['template_title'];?></title>
</head>
<body>
	<div id="content">
	<?php if($action != 'download'){?>		<?php 	$this->load->view('common/logo');?>	<?php } ?>
	<h1 align="center"><?php if(isset($uCustTemplate['template_title'])) echo $uCustTemplate['template_title'];?></h1>
		<p class="topTxt"  >
			<?php echo $P_Q1->value; ?>  for 
			<?php 
				if($campaign_info->campaign_target == '1'){	
						 echo $campaign_info->individual;
					}else{ 
						echo $campaign_info->organization;
				}
			?>
		</p>
        <?php if($action != 'download' && $action!='download2') {
			include_once('interactive/go-through-button.php');
		}?>
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="output">
            <?php 
                if(!empty($template_content)) {
                    foreach($template_content as $tpldata) {
            ?>
            <tr>
                <td><?php echo $tpldata->sect_content;?></td>
            </tr>
            <?php /*?><tr><td class="border-bottom">&nbsp;</td></tr><?php */?>
            <?php			
                    }
                } else if(!empty($template_sections)) {
                    foreach($template_sections as $tsection) {	
            ?>
            <tr>
                <td>
                    <?php 
                        $content_id=$tsection->content_id;
                        include('custom_content/custom_etemplate_data.php');
                    ?>
                </td>
            </tr>
            <?php /*?><tr><td class="border-bottom">&nbsp;</td></tr><?php */?>
            <?php			
                    }
                }		
            ?>
        </table>
</div>
<?php echo $this->load->view('common/footer_outputs');?>
