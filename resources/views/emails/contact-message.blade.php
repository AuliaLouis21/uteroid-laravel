<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background-color: #DF282A; color: #fff; padding: 15px 20px; border-radius: 4px 4px 0 0; }
        .body { background-color: #f9f9f9; padding: 20px; border: 1px solid #ddd; border-top: none; }
        .footer { font-size: 12px; color: #999; margin-top: 20px; text-align: center; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2 style="margin:0;">Pesan Baru dari Website</h2>
        </div>
        <div class="body">
            <p><strong>From:</strong> {{ $name }}</p>
            <p><strong>Email:</strong> {{ $email }}</p>
            @if($phone)
                <p><strong>Telepon:</strong> {{ $phone }}</p>
            @endif
            <p><strong>Subject:</strong> {{ $mailSubject }}</p>
            <hr style="border:none;border-top:1px solid #ddd;">
            <p>{!! nl2br(e($body)) !!}</p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Utero Group. Email ini dikirim otomatis dari formulir kontak website.
        </div>
    </div>
</body>
</html>
