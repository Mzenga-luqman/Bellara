<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px; }
        .header { text-align: center; padding-bottom: 20px; border-bottom: 2px solid #d8b784; }
        .header h1 { color: #b7925f; margin: 0; }
        .header p { color: #999; margin: 5px 0 0; font-size: 0.9em; }
        .content { padding: 20px 0; }
        .detail { background: #f9f5f0; padding: 15px; border-radius: 5px; margin: 10px 0; }
        .detail-row { display: flex; justify-content: space-between; padding: 8px 0; }
        .label { font-weight: bold; color: #b7925f; }
        .footer { text-align: center; padding-top: 20px; border-top: 1px solid #ddd; color: #999; font-size: 0.85em; }
        .cta-button { display: inline-block; background: linear-gradient(125deg, #d8b784, #b7925f); color: white; padding: 12px 24px; text-decoration: none; border-radius: 25px; margin: 15px 0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Bellara Beauty & Spa Lounge</h1>
            <p>Your appointment is confirmed!</p>
        </div>

        <div class="content">
            <p>Dear {{ $customerName }},</p>

            <p>Thank you for booking with us! Your appointment details are below:</p>

            <div class="detail">
                <div class="detail-row">
                    <span class="label">Service:</span>
                    <span>{{ $serviceName }}</span>
                </div>
                <div class="detail-row">
                    <span class="label">Date:</span>
                    <span>{{ $bookingDate }}</span>
                </div>
                <div class="detail-row">
                    <span class="label">Time:</span>
                    <span>{{ $bookingTime }}</span>
                </div>
                <div class="detail-row">
                    <span class="label">Price:</span>
                    <span>TSh {{ number_format($price, 2) }}</span>
                </div>
            </div>

            <p>We look forward to pampering you! If you need to reschedule or have any questions, please contact us.</p>

            <p style="text-align: center;">
                <a href="{{ url('/bookings/history') }}" class="cta-button">View Your Bookings</a>
            </p>
        </div>

        <div class="footer">
            <p>Bellara Beauty & Spa Lounge</p>
            <p>Mwananyamala Bwawani, Dar es Salaam</p>
        </div>
    </div>
</body>
</html>
