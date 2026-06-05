<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px; }
        .header { text-align: center; padding-bottom: 20px; border-bottom: 2px solid #d8b784; }
        .header h1 { color: #b7925f; margin: 0; }
        .content { padding: 20px 0; }
        .message { background: #f9f5f0; padding: 20px; border-radius: 5px; margin: 15px 0; }
        .footer { text-align: center; padding-top: 20px; border-top: 1px solid #ddd; color: #999; font-size: 0.85em; }
        .cta-button { display: inline-block; background: linear-gradient(125deg, #d8b784, #b7925f); color: white; padding: 12px 24px; text-decoration: none; border-radius: 25px; margin: 15px 0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>{{ $title }}</h1>
        </div>

        <div class="content">
            <div class="message">
                {!! nl2br(e($body)) !!}
            </div>

            <p style="text-align: center;">
                <a href="{{ url('/') }}" class="cta-button">Visit Bellara</a>
            </p>
        </div>

        <div class="footer">
            <p>Bellara Beauty & Spa Lounge</p>
            <p>Mwananyamala Bwawani, Dar es Salaam</p>
        </div>
    </div>
</body>
</html>
