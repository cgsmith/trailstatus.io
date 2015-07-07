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
            margin-top: -3em;
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
<div id="container">
    <div class="content">
        <div class="title">John Muir Trail System</div>
        <div class="<?=$status?>"><?=strtoupper($status)?></div>
        <div class="updated">Last updated: <?=$date;?></div>
    </div>
</div>
<div id="footer">
    <a href="https://github.com/cgsmith/trailstatus.io">About/Github/Feedback</a>
</div>
</body>
</html>