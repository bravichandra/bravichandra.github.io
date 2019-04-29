<?php $this->load->view('common/meta_outputs');?>
<title>Sales Letter &#45; Name Drop Focus</title>
</head>

<body>

<div id="content">
<?php echo $this->load->view('common/logo');?>
	<h1 align="center">Sales Letter &#45; Name Drop Focus</h1>

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
		        
		        <?php if (isset($credibilities)):?>
		        	<?php $i = 1; foreach ($credibilities as $credibility):?>
		        		<?php 
		        				if($i > 1) {break;} //We need only first record
			       				$data = $this->home->get_meta_data($credibility->c_id, 'credibility', 'tcd');
			       				
		       					$customer_id = isset($data['customer']['id']) ? $data['customer']['id']: NULL;
		       					$customer_value = isset($data['customer']['value']) ? $data['customer']['value'] : '[past or current client]';
		       					
		       					$provided_id = isset($data['provided']['id']) ? $data['provided']['id'] : NULL;
		       					$provided_value = isset($data['provided']['value']) ? $data['provided']['value'] : '[technical improvement]';
		       					
		       					$when_id = isset($data['when']['id']) ? $data['when']['id']: NULL;
		       					$when_value = isset($data['when']['value']) ? $data['when']['value']: '[business improvement]';
		       				?>
		        	<?php $i++; endforeach;?>
		        For example, we worked with 
		        <span class="dynamic_value edit_area" id="edit_<?php echo $credibility->c_id;?>_<?php echo $customer_id;?>__customer__tcd"><?php echo $customer_value;?></span> 
		        and helped them to 
		        <span class="dynamic_value edit_area" id="edit_<?php echo $credibility->c_id;?>_<?php echo $provided_id;?>__provided__tcd"><?php echo $provided_value;?></span> 
		        and this led to 
		        <span class="dynamic_value edit_area" id="edit_<?php echo $credibility->c_id;?>_<?php echo $when_id;?>__when__tcd"><?php echo $when_value;?></span>.
		        <?php endif;?>
		        
		        </p>
		        
		        <p>From our research, we may be able to drive similar benefits for organization and that is the purpose for the purpose for me reaching out to you.</p>
		        
		        <p>I will call your office over the next few weeks to schedule a 
		        <span class="dynamic_value edit_area" id="edit_<?php echo $user_id;?>_<?php echo (isset($sales_process['0']->user_data_id) ? $sales_process['0']->user_data_id : Null);?>__close__tud"><?php echo (isset($sales_process['0']->value) ? $sales_process['0']->value : Null);?></span> 
		         to  
		        <span class="dynamic_value edit_area" id="edit_<?php echo $user_id;?>_<?php echo (isset($sales_process['1']->user_data_id) ? $sales_process['1']->user_data_id : Null);?>__close__tud"><?php echo (isset($sales_process['1']->value) ? $sales_process['1']->value : Null);?></span>. 
		        If you would like to schedule that meeting ahead of us connecting over the phone, simply send an email to the address in my signature with your availability and I will look forward to talking with you then.</p>
		        
		        <p>Best Regards,</p>
		        <p> 
		        	<span class="dynamic_value">[Your Name]</span> <br/>
		            <span class="dynamic_value">[Your Title]</span> <br/>
		            <span class="dynamic_value">[Your Company]</span> <br/>
		            <span class="dynamic_value">[Your Phone Number]</span> <br/>
		            <span class="dynamic_value">[Your Email Address]</span> <br/>
		        </p>
			</td>
		</tr>
		
	</table>
</div>	
<?php echo $this->load->view('common/footer_outputs');?> 