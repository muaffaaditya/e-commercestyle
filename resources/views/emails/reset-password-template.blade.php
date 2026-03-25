<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LUXE | Reset Password</title>
    <style>
        /* Gaya font cadangan jika Manrope tidak tersedia di client email */
        body {
            margin: 0;
            padding: 0;
            background-color: #f6f6f8;
            font-family: 'Manrope', 'Helvetica Neue', Helvetica, Arial, sans-serif;
            -webkit-font-smoothing: antialiased;
        }
        .wrapper {
            width: 100%;
            table-layout: fixed;
            background-color: #f6f6f8;
            padding-bottom: 40px;
            padding-top: 40px;
        }
        .container {
            max-width: 600px;
            background-color: #ffffff;
            margin: 0 auto;
            border-radius: 32px; /* Melengkung mewah sesuai desain Admin */
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0,0,0,0.04);
        }
        .header {
            background-color: #111318;
            padding: 50px 40px;
            text-align: center;
        }
        .logo-text {
            color: #ffffff;
            font-size: 28px;
            font-weight: 800;
            letter-spacing: -1px;
            margin: 0;
            text-transform: uppercase;
        }
        .content {
            padding: 50px 40px;
            text-align: center;
        }
        .title {
            color: #111318;
            font-size: 24px;
            font-weight: 800;
            margin-bottom: 20px;
            letter-spacing: -0.5px;
        }
        .text {
            color: #64748b;
            font-size: 15px;
            line-height: 1.8;
            margin-bottom: 35px;
        }
        .btn-container {
            margin-bottom: 35px;
        }
        .btn {
            display: inline-block;
            background-color: #1754cf;
            color: #ffffff !important;
            padding: 18px 40px;
            border-radius: 100px;
            text-decoration: none;
            font-weight: 700;
            font-size: 13px;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            box-shadow: 0 10px 20px rgba(23, 84, 207, 0.2);
        }
        .divider {
            height: 1px;
            background-color: #f1f5f9;
            margin: 40px 0;
        }
        .footer {
            padding: 0 40px 40px 40px;
            text-align: center;
        }
        .footer-text {
            color: #94a3b8;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 2px;
            line-height: 1.5;
        }
        .help-text {
            color: #cbd5e1;
            font-size: 12px;
            font-style: italic;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container">
            <div class="header">
                <h1 class="logo-text">LUXE</h1>
            </div>

            <div class="content">
                <h2 class="title">Reset Password Request</h2>
                <p class="text">
                    Kami menerima permintaan untuk mengatur ulang kata sandi akun LUXE Anda. 
                    Klik tombol di bawah ini untuk mengamankan kembali akses ke kurasi koleksi premium Anda.
                </p>
                
                <div class="btn-container">
                    <a href="{{ url('reset-password/'.$token.'?email='.$email) }}" class="btn">Ubah Kata Sandi</a>
                </div>

                <div class="divider"></div>

                <p class="footer-text" style="color: #64748b; font-size: 12px; text-transform: none; letter-spacing: normal;">
                    Tautan ini akan kedaluwarsa dalam 60 menit untuk keamanan Anda.
                </p>
                
                <p class="help-text">
                    Jika Anda tidak merasa melakukan permintaan ini, abaikan email ini secara aman.
                </p>
            </div>

            <div class="footer">
                <p class="footer-text">
                    &copy; 2026 LUXE Premium Essentials<br>
                    Secure Terminal Access
                </p>
            </div>
        </div>
    </div>
</body>
</html>