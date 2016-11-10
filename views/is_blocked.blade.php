<!DOCTYPE html>
<html>
<head>
    <title>Under Development.</title>

    <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

    <style>
        html, body {
            height: 100%;
        }

        body {
            margin: 0;
            padding: 0;
            width: 100%;
            color: #B0BEC5;
            display: table;
            font-weight: 100;
            font-family: 'Lato', sans-serif;
        }

        .container {
            text-align: center;
            display: table-cell;
            vertical-align: middle;
        }

        .content {
            text-align: center;
            display: inline-block;
        }

        .title {
            font-size: 72px;
            margin-bottom: 40px;
        }

        form {
            font-size: 24px;
        }

        .form-control {
            border: 1px solid #B0BEC5;
            -webkit-border-radius: 10px;
            -moz-border-radius: 10px;
            border-radius: 10px;
            font-size: 24pt;
            padding-left: 10px;
            padding-right: 10px;
            color: #B0BEC5;
        }

        .btn {
            border: 1px solid #B0BEC5;
            background-color: #B0BEC5;
            color: white;
            -webkit-border-radius: 10px;
            -moz-border-radius: 10px;
            border-radius: 10px;
            font-size: 24pt;
            padding-left: 10px;
            padding-right: 10px;
            font-weight: 100;
            font-family: 'Lato', sans-serif;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="content">
        <div class="title">Under Development.</div>
        @if (config('blockade.show_form'))
            <form action="" method="GET">
                <p><strong>To enter the site, please provide a valid code.</strong></p>
                <input type="password" class="form-control" name="{{ config('blockade.key') }}" value="">
                <button type="submit" class="btn">Enter</button>
            </form>
        @endif
    </div>
</div>
</body>
</html>
