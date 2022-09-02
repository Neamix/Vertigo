<html>
    <head>
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans:wght@400;700&display=swap" rel="stylesheet">
        <style>
            body {
                background-color: #f2f2f2;
                display: flex;
                justify-content: center;
                align-items: center;
                flex-direction: column;
                height: 100%;
                font-family: 'PT Sans', sans-serif;
            }

            .container {
                background: #fff;
                max-width: 380px;
                width: 100%;
                padding: 20px;
            }

            .title {
                font-size: 17px;
            }

            .bold {
                font-weight: 700;
            }

            .btn {
                width: 100%;
                padding: 10px;
                border: none;
                background: #006ee6;
                color: #fff;
                font-weight: bold;
                border-radius: 3px;
                margin: 5px 0;
                position: relative;
            }
            
            a {
                color: #006ee6 ;
                word-break: break-all;
            }

            .cover_link {
                position: absolute;
                width: 100%;
                height: 100%;
                top: 0;
                left: 0;
            }
        </style>
    </head>
    <body>
        <img src="https://drive.google.com/uc?id=17F6Qtca-NWWLC1RQRN3Hk-igyOTZsGk3" class="mt-2" style="width: 221px; margin: 15px 0;">
        <div class="container">
            <span class="bold">Hello {{$data['name']}},</span>
            <br>
            <p class="pt-2"> Click the button to {{$data['type']}} your password for your {{ env('APP_NAME') }} account.</p>
            <button class="btn ">
            <a href="{{ url($data['url']) }}" class="cover_link">
            </a>
            {{$data['type']}} Password
            </button>
            <p class="pt-2">
            Button not working for you? Copy the url below into your browser.
            </p>
            <a href="{{ url($data['url']) }}">
            {{ url($data['url']) }}
            </a>
            <p>
            Thank you,<br>
            The {{ env('APP_NAME') }} Team
            </p>
        </div>
    </body>
</html>