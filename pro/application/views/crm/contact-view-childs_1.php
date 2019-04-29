<div class="subsections"><b>Opportunities</b> <a href="<?php echo base_url('crm/opportunities/contact/'.$contact_id);?>">New</a></div>

<div>

    <?php $this->load->view('crm/contact-oppt-list');?>

</div><hr />

 

<div class="subsections"><b>Open Activities</b> 

    <a href="<?php echo base_url('crm/tasks/contacts/'.$contact_id.'/edit');?>">New</a>

</div>

<div>

    <?php $this->load->view('crm/task-open-list');?>

</div><hr />



<div class="subsections"><b>Activity History</b> <a href="<?php echo base_url('crm/tasks/contacts/'.$contact_id);?>">View All</a></div>

<div>

    <?php $this->load->view('crm/task-active-list');?>

</div><hr />



<div class="subsections"><b>Notes</b> <a href="<?php echo base_url('crm/notes/contacts/'.$contact_id);?>">&nbsp;View All</a> <a href="<?php echo base_url('crm/notes/contacts/'.$contact_id.'/edit');?>">New&nbsp;</a></div>

<div>

    <?php $this->load->view('crm/notes-list-few');?>

</div><hr />

<div class="subsections">

    <b>Attached Documents</b> 

    <a href="<?php echo base_url('crm/docs/contacts/'.$contact_id);?>/add">&nbsp;New</a>              

</div>

<div>

    <?php $this->load->view('crm/docs-list-few');?>

</div><hr />        

<div class="subsections"><b>Scheduled Emails</b> <a href="<?php echo base_url('crm/emails/contacts/'.$contact_id);?>">&nbsp;View All</a></div>

<div>

    <?php $this->load->view('crm/email-list-few');?>

</div>
<hr />  