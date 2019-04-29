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

<?php
$ringCentral = $this->home->getUserData([
    'user_id'=>$this->_user_id,
    'field_type'=>'ringcentral'
]);
$rc = unserialize($ringCentral[0]->value);
if( $rc['display'] == 1 ){
?>
<div class="subsections"><b>Call Recordings</b></div>
<div>
    <?php $this->load->view('crm/call-activity-list');?>
</div><hr />
<?php } ?>


