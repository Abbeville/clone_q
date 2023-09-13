<?php

    /* get disk space free (in bytes) */
    $df = disk_free_space("/var/www");
    /* and get disk space total (in bytes)  */
    $dt = disk_total_space("/var/www");
    /* now we calculate the disk space used (in bytes) */
    $du = $dt - $df;
    /* percentage of disk used - this will be used to also set the width % of the progress bar */
    $dp = sprintf('%.2f',($du / $dt) * 100);

    /* and we formate the size from bytes to MB, GB, etc. */
    $df = formatSize($df);
    $du = formatSize($du);
    $dt = formatSize($dt);

    function formatSize( $bytes )
    {
            $types = array( 'B', 'KB', 'MB', 'GB', 'TB' );
            for( $i = 0; $bytes >= 1024 && $i < ( count( $types ) -1 ); $bytes /= 1024, $i++ );
                    return( round( $bytes, 2 ) . " " . $types[$i] );
    }

    ?>
    
    
    
    
        <style>

    .progs {
            border: 2px solid #5E96E4;
            height: 32px;
            width: 100%;
            margin: 30px auto;
    }
    .progs .prgbar {
            background: #ADD8E6;
            width: <?php echo $dp; ?>%;
            position: relative;
            height: 32px;
            z-index: 999;
    }
    .progs .prgtext {
            color: #808080;
            text-align: center;
            font-size: 13px;
            padding: 9px 0 0;
            width: 100%;
            position: absolute;
            z-index: 1000;
    }
    .progs .prginfo {
            margin: 3px 0;
            color:#A9A9A9;
    }

    </style>