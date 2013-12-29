<div>
    <table id='list'> 
    <?php foreach($games['top'] as $game) { ?>
        <tr style='padding:10px;'>
            <td style='border: 1px solid black; padding:10px;'>
                <a href='Stream/display/?game=<?php echo urlencode($game['game']['name']); ?>'>
                    <div class='preview'>
                        <?php echo $game['game']['name'].'<br />'; ?>
                        <img src='<?php echo $game['game']['logo']['small']; ?>' /><br />
                    </div>
                </a>
            </td>
        </tr>
    <?php } ?>
    </table>
</div>