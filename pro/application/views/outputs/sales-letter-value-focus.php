<?php $this->load->view('common/meta_outputs');?>
<title>Sales Letter &#45; Value Focus</title>
</head>
<body>
<div id="content">
<?php echo $this->load->view('common/logo');?>
	<h1 align="center">Sales Letter &#45; Value Focus</h1>

	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="output">
		<tr><td class="border">&nbsp;</td></tr>
		<tr>
			<td>
				<p>
		            <span class="dynamic_value">[Your Company]</span> <br />
		            <span class="dynamic_value">[Company Address]</span> <br />
		            <span class="dynamic_value">[City, State Zip]</span> <br /> <br />
		        </p>
		        <p>
		            <span class="dynamic_value">[Date]</span> <br /> <br />
		            
		            <span class="dynamic_value">[Target Prospect]</span> <br />
		            <span class="dynamic_value">[Target Contact Title]</span> <br />
		            <span class="dynamic_value">[Target Company]</span> <br />
		            <span class="dynamic_value">[Target Company Address]</span> <br />
		            <span class="dynamic_value">[City, State Zip]</span>
		        </p>
		    	
		        <p>Dear Mr./Ms. <span class="dynamic_value">[Prospect Last Name]</span>,</p>
		        
		        <p>I am with <span class="dynamic_value">[Your Company]</span> and we help 
		        <span class="dynamic_value edit_area" id="edit_<?php echo $user_id;?>_<?php echo (isset($custome_fields['1']->user_data_id) ? $custome_fields['1']->user_data_id : Null);?>__users__tud"><?php echo (isset($custome_fields['1']->value) ? $custome_fields['1']->value : Null);?></span> to 
		        <span class="<?php echo (!empty($summary['0']->user_data_id) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $user_id;?>_<?php echo (isset($summary['0']->user_data_id) ? $summary['0']->user_data_id : Null);?>__summary__tud"><?php echo (isset($summary['0']->value) ? $summary['0']->value : Null);?></span>.
		        </p>
		        <p>We are able to drive these improvements through the delivery of our 
                            <?php if (isset($products)):?>
                            <?php $i = 0; foreach ($products as $product):?>
                                    <?php $P1 = $this->home->get_value_pain($product->product_id, 'P1');?>
                                    <?php if($i == 0):?>
                                                    <span class="dynamic_value edit_area" id="edit_<?php echo $product->product_id;?>_<?php echo $P1[0]->id;?>__P_Q1__tpd"><?php echo (!empty($P1[0]->value) ? $P1[0]->value : '[my prodcut]');?></span></li>
                                    <?php  endif;?>
                            <?php  $i++; if($i > 2){ $i=0; } 
                                        endforeach;?>
                            <?php endif;?>
		        and this can often lead to 
		        <span class="<?php echo (!empty($summary['0']->user_data_id) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $user_id;?>_<?php echo (isset($summary['0']->user_data_id) ? $summary['0']->user_data_id : Null);?>__summary__tud"><?php echo (isset($summary['0']->value) ? $summary['0']->value : Null);?></span>.
		        </p>
		        
		        <p>I will call your office over the next few weeks to schedule a 
		        <span class="dynamic_value edit_area" id="edit_<?php echo $user_id;?>_<?php echo (isset($sales_process['0']->user_data_id) ? $sales_process['0']->user_data_id : Null);?>__close__tud"><?php echo (isset($sales_process['0']->value) ? $sales_process['0']->value : Null);?></span> 
		         to   
		        <span class="dynamic_value edit_area" id="edit_<?php echo $user_id;?>_<?php echo (isset($sales_process['1']->user_data_id) ? $sales_process['1']->user_data_id : Null);?>__close__tud"><?php echo (isset($sales_process['1']->value) ? $sales_process['1']->value : Null);?></span>. 
		        If you would like to schedule that meeting ahead of us connecting over the phone, simply send an email to the address in my signature with your availability and I will look forward to talking with you then.</p>
		        
		        <p>Best Regards,</p>
		        <p> 
		        	<span class="dynamic_value">[Your Name1]</span> <br /> 
		            <span class="dynamic_value">[Your Title]</span> <br />
		            <span class="dynamic_value">[Your Company]</span> <br />
		            <span class="dynamic_value">[Your Phone Number]</span> <br />
		            <span class="dynamic_value">[Your Email Address]</span> <br />
		        </p>
			</td>
		</tr>
	</table>
</div>	
<?php echo $this->load->view('common/footer_outputs');?> 