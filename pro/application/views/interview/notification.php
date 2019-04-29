<?php            
	if($this->session->flashdata('message'))
	{ 
	  echo '<div class="alert success-info alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$this->session->flashdata('message').'</div>';
	}           
	
	if($this->session->flashdata('error'))
	{ 
	  echo '<div class="alert error-info alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$this->session->flashdata('error').'</div>';
	}           
?> 