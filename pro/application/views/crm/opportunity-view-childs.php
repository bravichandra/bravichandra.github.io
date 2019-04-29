<div class="subsections"><b>Open Activities</b> 

	<a href="<?php echo base_url('crm/tasks/opportunities/'.$opporunity_id.'/edit');?>">New</a>

</div>

<div>

	<?php $this->load->view('crm/task-open-list');?>

</div><hr />


<div class="subsections"><b>Activity History</b> <a href="<?php echo base_url('crm/tasks/opportunities/'.$opporunity_id);?>">View All</a></div>

<div>

	<?php $this->load->view('crm/task-active-list');?>

</div><hr />
<div class="subsections"><b>Notes</b> <a href="<?php echo base_url('crm/notes/opportunities/'.$opporunity_id);?>">&nbsp;View All</a> <a href="<?php echo base_url('crm/notes/opportunities/'.$opporunity_id.'/edit');?>">New&nbsp;</a></div>

<div>

    <?php $this->load->view('crm/notes-list-few');?>

</div><hr />