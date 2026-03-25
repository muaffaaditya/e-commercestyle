<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* Base Reset */
        body { 
            font-family: 'Manrope', 'Helvetica Neue', Helvetica, Arial, sans-serif; 
            background-color: #FDFBF7; 
            margin: 0; 
            padding: 20px; 
            -webkit-font-smoothing: antialiased;
        }

        /* Main Container */
        .wrapper {
            width: 100%;
            table-layout: fixed;
            background-color: #FDFBF7;
            padding-bottom: 60px;
            padding-top: 40px;
        }

        .container { 
            max-width: 600px; 
            background: #ffffff; 
            margin: 0 auto; 
            border-radius: 40px; 
            overflow: hidden; 
            box-shadow: 0 30px 60px rgba(17, 19, 24, 0.05); 
            border: 1px solid rgba(0, 0, 0, 0.03);
        }

        /* Header LUXE */
        .header { 
            padding: 60px 40px; 
            text-align: center; 
            background: #111318; 
            color: #ffffff; 
        }
        .logo { 
            font-weight: 900; 
            letter-spacing: 0.5em; 
            font-size: 28px; 
            text-transform: uppercase; 
            margin: 0; 
            color: #ffffff;
        }

        /* Content Area */
        .content { 
            padding: 60px 50px; 
            text-align: center; 
        }
        .badge { 
            font-size: 9px; 
            font-weight: 800; 
            color: #1754cf; 
            text-transform: uppercase; 
            letter-spacing: 0.4em; 
            margin-bottom: 25px; 
            display: inline-block;
            padding: 8px 20px;
            background: #f0f7ff;
            border-radius: 100px;
        }
        .message-box {
            position: relative;
            padding: 0 10px;
        }
        .message { 
            font-size: 20px; 
            color: #111318; 
            line-height: 1.7; 
            font-style: italic; 
            font-weight: 500; 
            margin: 0;
        }
        .divider {
            width: 40px;
            height: 2px;
            background: #1754cf;
            margin: 35px auto;
        }

        /* Premium Button Style */
        .btn-wrapper {
            margin-top: 40px;
        }
        .btn { 
            display: inline-block; 
            padding: 20px 45px; 
            background: linear-gradient(135deg, #1754cf 0%, #0037a5 100%); 
            color: #ffffff !important; 
            text-decoration: none; 
            border-radius: 20px; 
            font-size: 12px; 
            font-weight: 800; 
            text-transform: uppercase; 
            letter-spacing: 0.2em; 
            box-shadow: 0 15px 30px rgba(23, 84, 207, 0.3);
            transition: transform 0.3s ease;
        }

        /* Footer Area */
        .footer { 
            padding: 40px; 
            background: #fafafa; 
            text-align: center; 
            border-top: 1px solid #f1f1f1; 
        }
        .footer-text {
            font-size: 10px; 
            color: #b1b1b1; 
            text-transform: uppercase; 
            letter-spacing: 0.2em; 
            margin: 0;
            line-height: 1.5;
        }
        .footer-link {
            color: #111318;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container">
            <div class="header">
                <h1 class="logo">LUXE</h1>
            </div>

            <div class="content">
                <span class="badge">Inner Circle Exclusive</span>
                <div class="message-box">
                    <p class="message">"{{ $messageContent }}"</p>
                </div>
                <div class="divider"></div>
                
                <div class="btn-wrapper">
                    <a href="{{ url('/inner-circle') }}" class="btn">Enter The Circle</a>
                </div>
            </div>

            <div class="footer">
                <p class="footer-text">
                    This is an automated transmission for verified members.<br/>
                    © 2026 LUXE Premium Terminal. All rights reserved.
                </p>
                <p class="footer-text" style="margin-top: 15px;">
                    <a href="{{ url('/') }}" class="footer-link">Luxe Official Store</a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>