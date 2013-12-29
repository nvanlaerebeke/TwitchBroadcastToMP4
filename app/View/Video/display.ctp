<div style='border: 1px solid black;'>
    <table>
        <tr style='padding:10px;'>
            <td style='padding:10px;'>
                <img src='<?php echo $broadcast['preview']; ?>' /> 
            </td>
            <td>
                <table>
                    <tr>
                        <td>Title</td>
                        <td><?php echo $broadcast['title']; ?></td>
                    </tr>
                    <tr>
                        <td>Lenght</td>
                        <td><?php echo gmdate("H:i:s", $broadcast['length']); ?></td>
                    </tr>
                </table>
                <div style='margin-top:20px;'>
                    <h1>Current status</h1> 
                    <table>
                        <tr>
                            <td>Download %</td>
                            <td>
                                <?php
                                    if($canview) {
                                        echo '100%';
                                    } else {
                                        echo (($totaldownloadsize != 0) ? (round(($downloadedsize /  $totaldownloadsize) * 100, 2)) : 0) . '% <br />';
                                    }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Downloaded Parts </td>
                            <td>
                                <?php
                                    echo $downloaded. '/'.count($video_info);
                                ?>
                            </td>
                        </tr>                        
                        <tr>
                            <td>Converting</td>
                            <td>
                                <?php
                                    $converted = 0;
                                    foreach($ffmpegjobs as $job) {
                                        if($job['Ffmpegjob']['status'] == 'Done' && $job['Ffmpegjob']['type'] == 'Conversion') {
                                            $converted++;
                                        }
                                    }
                                    echo ($converted == 0) ? 'Queued' : $converted. '/'.count($video_info);
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Merging</td>
                            <td>
                                <?php
                                    foreach($ffmpegjobs as $job) {
                                        if($job['Ffmpegjob']['type'] == 'Combining') {
                                            if($job['Ffmpegjob']['status'] == 'Done') {
                                                $status = 'Done';
                                            } elseif($job['Ffmpegjob']['status'] == 'Busy') {
                                                $status = 'Working';
                                            } else {
                                                $status = 'Failed';
                                            }
                                            break;
                                        }
                                    }
                                    echo (empty($status)) ? 'Queued' : $status;                                
                                ?>
                            </td>
                        </tr>                        
                    </table>
                </div>
            </td>
        </tr>
    </table>
    <div style='width:100%; text-align:center; font-size:2em;'>
        <?php
            if($canview) { 
                echo $this->Html->link('Watch', '/final/'.$video_info[0]['broadcast_id']. DS .$video_info[0]['broadcast_id'].'.mp4');
            } else {
                echo "Preparing, please wait ...";
            }
        ?>
    </div>
</div>