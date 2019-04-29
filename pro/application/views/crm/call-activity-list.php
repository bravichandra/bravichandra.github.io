<?php if($call_recordings){?><table style='margin: 6px 30px;width: 95%;background: none repeat scroll 0 0 #E6E6E6;' class='tDefault crmtab'>
    <thead>
        <tr>                        
            <?php //if($crmlite=="contact"){?>
            <th class='no-border' width="150px">Direction</th>            
            <th class='no-border'>Recording</th>                      
            <th class='no-border' style="width:130px;">Date/Time </th>
        </tr>
    </thead>
    <tbody>
    <?php 
    $location = base_url().'Recordings/';
    foreach ($call_recordings as $key => $record) { ?>
        <tr>
            <td class='no-border'><?php echo $record->direction ?></td>
            <td class='no-border'><a class="play-download" href="<?php echo $location.date('Y-m-d', ($record->call_date/1000)).'/'.$record->recording; ?>">Play/Download</a></td>
            <td class='no-border'><?php echo date('d-m-Y h:i a', ($record->call_date/1000)); ?></td>
        </tr>
    <?php } ?>
    </tbody>
</table><?php }?>

<script>
    $('.play-download').click(function(e){
        e.preventDefault();
        src = $(this).attr('href');
        parent = $(this).parent();
        parent.html(`
            <audio controls autoplay>
                <source src="`+src+`" type="audio/mpeg">
                Your browser does not support the audio element.
            </audio>
        `);
        return false;
    });
</script>