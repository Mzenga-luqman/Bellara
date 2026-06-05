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
        .alert { background: #fff9e6; border-left: 4px solid #d8b784; padding: 15px; margin: 15px 0; border-radius: 4px; }
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
            <p>Your appointment is tomorrow!</p>
        </div>

        <div class="content">
            <p>Dear {{ $customerName }},</p>

            <div class="alert">
                <strong>⏰ Reminder:</strong> Your appointment is scheduled for tomorrow at <strong>{{ $bookingTime }}</strong>
            </div>

            <p><strong>{{ $serviceName }}</strong></p>

            <p>We look forward to welcoming you! Please arrive 5-10 minutes early.</p>

            <p style="text-align: center;">
                <a href="{{ url('/bookings/history') }}" class="cta-button">Manage Your Booking</a>
            </p>

            <p><strong>Need to reschedule?</strong> Visit your booking history to make changes.</p>
        </div>

        <div class="footer">
            <p>Bellara Beauty & Spa Lounge</p>
            <p>Mwananyamala Bwawani, Dar es Salaam</p>
        </div>
    </div>
</body>
</html>
