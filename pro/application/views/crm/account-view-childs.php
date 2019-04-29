<div class="subsections"><b>Contacts</b> <a href="<?php echo base_url('crm/contacts/account/'.$account_id);?>">New</a></div>

<div>

    <?php $this->load->view('crm/account-contact-list');?>

</div><hr />

<div class="subsections"><b>Opportunities</b> <a href="<?php echo base_url('crm/opportunities/account/'.$account_id);?>">New</a></div>

<div>

	<?php $this->load->view('crm/contact-oppt-list');?>

</div><hr />

 

<div class="subsections"><b>Open Activities</b> 

	<a href="<?php echo base_url('crm/tasks/accounts/'.$account_id.'/edit');?>">New</a>

</div>

<div>

	<?php $this->load->view('crm/task-open-list');?>

</div><hr />



<div class="subsections"><b>Activity History</b> <a href="<?php echo base_url('crm/tasks/accounts/'.$account_id);?>">View All</a></div>

<div>

	<?php $this->load->view('crm/task-active-list');?>

</div><hr />



<div class="subsections"><b>Notes</b> <a href="<?php echo base_url('crm/notes/accounts/'.$account_id);?>">&nbsp;View All</a> <a href="<?php echo base_url('crm/notes/accounts/'.$account_id.'/edit');?>">New&nbsp;</a></div>

<div>

	<?php $this->load->view('crm/notes-list-few');?>

</div><hr />    

<div class="subsections">

    <b>Attached Documents</b> 

    <a href="<?php echo base_url('crm/docs/accounts/'.$account_id);?>/add">&nbsp;New</a>              

</div>

<div>

    <?php $this->load->view('crm/docs-list-few');?>

</div>
<hr />	