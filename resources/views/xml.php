<?php
echo '<?xml version="1.0" encoding="UTF-8" ?>';?>
<rss version="2.0">
    <channel>
        <title><?=$trail['name']. ' Status Feed';?></title>
        <link>http://trailstatus.io</link>
        <description>Keep you up-to-date on trail closures</description>
        <item>
            <title><?=$trail['name'] . ' is ' . $trail['status']?></title>
            <link>http://trailstatus.io</link>
            <description><?=$trail['name'] . ' is ' . $trail['status'] . ' as of '. $trail['date'].'.'?></description>
        </item>
    </channel>
</rss> 