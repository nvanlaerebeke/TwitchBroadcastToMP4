<div>
    <table id='list'>
    <?php foreach($streams['streams'] as $stream) { ?>
        <tr style='padding:10px;'>
            <td style='border: 1px solid black; padding:10px;'>
                <a href='/Channel/display/<?php echo $stream['channel']['display_name']; ?>'>
                    <div class='preview'>
                        <?php echo $stream['channel']['status'].'<br />'; ?>
                        <img src='<?php echo $stream['preview']['small']; ?>' /><br />
                    </div>
                </a>
            </td>
        </tr>
    <?php } ?>
    </table>
</div>