<div>
    <div>
        <form action="<?php echo $this->Html->url(array('controller' => 'Stream', 'action' => 'Search')); ?>" id="/Game/SearchForm" method="post" accept-charset="utf-8">
            <div style="display:none;"><input type="hidden" name="_method" value="POST"></div>
            <div class="input text">
                <label for="Search">Search:</label>
                <input name="data[Search]" type="text" id="Search">
            </div>
            <div class="submit">
                <input type="submit" value="Search">
            </div>
        </form>
    </div>
    <hr style='margin:0px 0px 10px 0px;' />
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