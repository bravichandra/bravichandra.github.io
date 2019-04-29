<table style='margin: 6px 30px;width: 95%;background: none repeat scroll 0 0 #E6E6E6;' class='tDefault crmtab'>
    <thead>
        <tr>                        
            <th class='no-border' width="150">Type</th>         
            <th class='no-border'>Recording</th>             
            <th class='no-border' width="100">Length</th>             
            <th class='no-border' width="150">Date/Time</th>
        </tr>
    </thead>
    <tbody id="rc-calls"> <tbody>
</table>
<div id="navigation"> </div>
<script>
    $(function() {
        var base_url = "<?php echo base_url(); ?>";
        var contact_id = "<?php echo $this->uri->segment(4); ?>";
        var data = {contact_id:contact_id};
        getCallLogs(data);

        $('body').delegate('.btn-pagination','click',function(){
            var page = $(this).data('page');
            var data = {
                contact_id:contact_id,
                page:page
            }
            getCallLogs(data);
        });

        $('body').delegate('.play-audio','click',function(e){
            e.preventDefault();
            var id = $(this).attr('href');
            var td = $(this).parent();
            td.html('<span>loading...</span>');
            $.post( base_url+"ringcentral/openRecording", {id:id}, function( res ) {
                td.html(JSON.parse(res));
            });
        });

        function getCallLogs(data){
            $('#rc-calls').html('<tr><td align="center" colspan="4">Loading...</td></tr>');
            $('#navigation').html('');
            $.post( base_url+"ringcentral/callLogs", data, function( res ) {
                res = JSON.parse(res);
                if( res == false ){
                    $('#rc-calls').html('<tr><td align="center" colspan="4">No Result</td></tr>');
                }else{
                    $('#rc-calls').html(res.data);
                    $('#navigation').html(res.navigation);
                }
            });
        }

    });
</script>
