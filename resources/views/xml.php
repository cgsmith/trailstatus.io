<?php
$datePublished = new DateTime($trail->updated,new DateTimeZone('America/Chicago'));
?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
    <channel>
        <atom:link href="http://trailstatus.io/john-muir/xml" rel="self" type="application/rss+xml" />
        <title><?=$trail->name. ' Status Feed';?></title>
        <link>http://trailstatus.io</link>
        <description>Keep you up-to-date on trail closures</description>
        <item>
            <title><?=$trail->name . ' is ' . strtoupper($trail->status)?></title>
            <link>http://trailstatus.io</link>
            <pubDate><?=$datePublished->format('r')?></pubDate>
            <description><?=$trail->translation?></description>
            <guid>http://trailstatus.io/john-muir</guid>
        </item>
    </channel>
</rss> 