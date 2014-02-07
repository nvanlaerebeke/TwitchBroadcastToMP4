<div>
    <table id='list'> 
    <?php
        for($i = 0; $i < count($broadcasts['videos']); $i++) { 
        ?>
        <tr style='padding:10px;'>
            <td style='border: 1px solid black; padding:10px;'>
                <a href='<?php echo $this->Html->url(array('controller' => 'Video', 'action' => 'display', urlencode($broadcasts['videos'][$i]['_id'])), true); ?>'>
                    <div class='preview'>
                        <?php echo $broadcasts['videos'][$i]['title'].'<br />'; ?>
                        <img src='<?php echo $broadcasts['videos'][$i]['preview']; ?>' /><br />
                        Length: <?php echo gmdate("H:i:s", $broadcasts['videos'][$i]['length']); ?>
                    </div>
                </a>
            </td>
        </tr>
    <?php } ?>
    </table>
</div>
