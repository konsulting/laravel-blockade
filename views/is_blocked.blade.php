<!DOCTYPE html>
<html>
<head>
    <title>Under Development.</title>

    <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

    <meta name="viewport" content="width=device-width,initial-scale=1">

    <style>
        html, body {
            height: 100%;
        }

        body {
            margin: 0;
            padding: 0;
            width: 100%;
            color: #B0BEC5;
            font-weight: 100;
            font-family: 'Lato', sans-serif;
        }

        .container {
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            height: 100%;
        }

        .content {
            text-align: center;
            display: inline-block;
        }

        .title {
            font-size: 3.5rem;
            margin-bottom: 40px;
        }

        form {
            font-size: 24px;
        }

        .form-control {
            border: 1px solid #B0BEC5;
            -webkit-border-radius: 0;
            -moz-border-radius: 0;
            border-radius: 0;
            font-size: 1.75rem;
            line-height: 2rem;
            padding: 10px;
            color: #B0BEC5;
            margin-bottom: 20px;
        }

        .btn {
            border: 1px solid #B0BEC5;
            background-color: #B0BEC5;
            color: white;
            -webkit-border-radius: 0;
            -moz-border-radius: 0;
            border-radius: 0;
            font-size: 1.75rem;
            line-height: 2rem;
            padding: 10px 20px;
            font-weight: 100;
            font-family: 'Lato', sans-serif;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #b8c6cd;
        }

        @media only screen and (min-width: 475px) {
            .title {
                font-size: 5rem;
            }
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
                <input title="Blockade Password" type="password" class="form-control"
                       name="{{ config('blockade.key') }}" value="">
                <button type="submit" class="btn">Enter</button>
            </form>
        @endif
    </div>
</div>
</body>
</html>
