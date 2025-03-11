<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Ustudious</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Blinker:wght@100;200;300;400;600;700;800;900&family=Saira+Condensed:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Blinker', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            text-align: center;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .logo {
            width: 120px;
        }
        .logo-1 {
            width: 72px;
        }

        .message {
            font-size: 18px;
            margin-bottom: 30px;
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #9E1F63;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }

        .footer {
            margin-top: 20px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="container">

            @if (!empty(session()->get('status')) && session()->get('status') ==='true')
                <img class="logo-1" src="{{ asset('img/verified-icon.png')}}" alt="Ustudious Logo" width="80px">
                    <h2><span style="color: #00d97f;font-weight: 600;">
                        {{session()->get('msg')}}
                    </h2>
            @endif
         @if (!empty(session()->get('status')) && session()->get('status') === 'false')
           <img class="logo-1" src="{{ asset('img/not-verified-icon.png')}}" alt="Ustudious Logo" width="80px">
         <h2><span style="color: #d72f37;font-weight: 600;">{{session()->get('msg')}}</span></h2>
            @endif
            <?php $ASSET_PATH = env('ASSET_URL').'/'; ?>
        <img class="logo" src="{{$ASSET_PATH}}img/ustudious-logo.png" alt="Ustudious Logo">
        <h2 style="font-weight: 600;">Welcome to <br> <span style="font-size: 40px; color: #9E1F63;font-weight: 700;">Ustudious</span></h2>
        
        <p class="message">Thank you for registering on our platform. <br> You are now part of the Ustudious  community.</p>
        <a href="https://www.ustudious.com/" class="button" target="_blank">Explore Opportunities</a>
        <p class="footer">If you have any questions, feel free to contact our support team at <strong><a href="mailto:info@ustudious.com">info@ustudious.com</a></strong></p>
    </div>
</body>
</html>
