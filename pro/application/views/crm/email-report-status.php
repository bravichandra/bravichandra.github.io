<?php if(isset($ereportcounts) && $ereportcounts) {?>
<div align="left">
    <h2>STATS:</h2>
    <table cellpadding="0" cellspacing="0" border="0">
        <tr>
            <th>Emails Sent:</th>
            <td><?php if($ereportcounts['s']) echo number_format($ereportcounts['s'][0]->ic); else echo "0";?></td>
        </tr>
        <tr> 
            <th>Emails Opened:</th>
            <td><?php if($ereportcounts['v']) echo number_format($ereportcounts['v'][0]->ic); else echo "0";?></td>
        </tr>
        <tr>
            <th>Open Rate:</th>
            <td><?php if($ereportcounts['v']) echo round(($ereportcounts['v'][0]->ic/$ereportcounts['s'][0]->ic)*100,2).'%'; else echo "N/A"?></td>
        </tr>
        <tr>
            <th>Clicks:</th>
            <td><?php if($ereportcounts['c']) echo number_format($ereportcounts['c'][0]->ic); else echo "0";?></td>
        </tr>
        <tr>
            <th>Click-Through Rate:</th>
            <td><?php if($ereportcounts['c']) echo round(($ereportcounts['c'][0]->ic/$ereportcounts['v'][0]->ic)*100,2).'%'; else echo "N/A"?></td>
        </tr>
    </table>
    <hr>
</div>
<?php }?>