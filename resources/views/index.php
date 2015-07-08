<html>
<head>
    <title>TrailStatus.io</title>

    <link href='//fonts.googleapis.com/css?family=PT+Sans+Narrow:700' rel='stylesheet' type='text/css'>

    <style>
        body {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            font-weight: 700;
            font-family: 'PT Sans Narrow';
        }
        html, #container {
            text-align: center;
            height: 100%;
        }
        body > #container { height: auto; min-height: 100%; }

        .content {
            text-align: center;
            display: inline-block;
        }

        .title {
            font-size: 72px;
            margin-bottom: 40px;
        }

        .open {
            font-size: 72px;
            background-color: green;
        }

        .closed {
            font-size: 72px;
            background-color: red;
        }

        .updated {
            color: grey;
        }

        #footer {
            clear: both;
            position: relative;
            z-index: 10;
            height: 3em;
            margin-top: -6em;
        }

        .fb-like {
            text-align: center;
            display: inline-block;
        }

    </style>
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-19054663-12', 'auto');
        ga('send', 'pageview');

    </script>
</head>
<body>
<div id="fb-root"></div>
<script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.3&appId=189584151200106";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
<div id="container">
    <div class="content">
        <div class="title">John Muir Trail System</div>
        <div class="<?=$trail->status?>"><?=strtoupper($trail->status)?></div><br/>
        <div class="recording"><audio id="audio1" src="recording.wav" controls preload="auto" autobuffer></audio></div>
        <div class="updated">Last updated: <?=$trail->updated;?></div>
    </div>
</div>
<div id="footer">
    <a href="https://github.com/cgsmith/trailstatus.io">About/Github/Feedback</a><br/>
    <a href="http://trailstatus.io/john-muir/json">JSON?</a> |
    <a href="http://trailstatus.io/john-muir/xml">XML?</a> |
    <a href="https://ifttt.com/recipes/305632-john-muir-trail-updates-via-text">IFTTT?</a> <br/>
    <div class="fb-like" data-href="http://trailstatus.io" data-layout="standard" data-action="like" data-show-faces="true" data-share="true"></div>
</div>
</body>
</html>