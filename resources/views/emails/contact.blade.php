<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesan Kontak Baru</title>
</head>
<body style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #f4f7f6; margin: 0; padding: 0;">
    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color: #f4f7f6; padding: 40px 0;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" border="0" style="background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.05);">
                    <!-- Header -->
                    <tr>
                        <td style="background-color: #7A9C59; padding: 30px; text-align: center;">
                            <h1 style="color: #ffffff; margin: 0; font-size: 24px; letter-spacing: 1px;">RECYCLINK</h1>
                            <p style="color: #e2ebd9; margin: 5px 0 0 0; font-size: 14px;">Pesan Baru dari Pengunjung Website</p>
                        </td>
                    </tr>
                    <!-- Body -->
                    <tr>
                        <td style="padding: 40px 30px;">
                            <p style="margin: 0 0 20px 0; color: #333333; font-size: 16px; line-height: 1.5;">Halo Admin,</p>
                            <p style="margin: 0 0 30px 0; color: #555555; font-size: 15px; line-height: 1.5;">Anda menerima pesan baru melalui formulir kontak. Berikut adalah rincian pengirim:</p>
                            
                            <!-- Info Box -->
                            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color: #f9fbf9; border: 1px solid #e5ebe4; border-radius: 6px;">
                                <tr>
                                    <td style="padding: 20px;">
                                        <p style="margin: 0 0 10px 0; font-size: 14px;">
                                            <span style="color: #888888; display: inline-block; width: 60px;">Nama:</span>
                                            <strong style="color: #333333;">{{ $contactData['name'] }}</strong>
                                        </p>
                                        <p style="margin: 0 0 10px 0; font-size: 14px;">
                                            <span style="color: #888888; display: inline-block; width: 60px;">Email:</span>
                                            <strong style="color: #333333;"><a href="mailto:{{ $contactData['email'] }}" style="color: #7A9C59; text-decoration: none;">{{ $contactData['email'] }}</a></strong>
                                        </p>
                                        <p style="margin: 0; font-size: 14px;">
                                            <span style="color: #888888; display: inline-block; width: 60px;">Subjek:</span>
                                            <strong style="color: #333333;">{{ $contactData['subject'] }}</strong>
                                        </p>
                                    </td>
                                </tr>
                            </table>

                            <h3 style="color: #333333; margin: 30px 0 15px 0; font-size: 16px; border-bottom: 2px solid #f0f0f0; padding-bottom: 10px;">Isi Pesan:</h3>
                            <div style="color: #444444; font-size: 15px; line-height: 1.6; background-color: #ffffff; border-left: 4px solid #7A9C59; padding-left: 15px; margin-bottom: 30px;">
                                {!! nl2br(e($contactData['message'])) !!}
                            </div>

                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td align="center">
                                        <a href="mailto:{{ $contactData['email'] }}" style="display: inline-block; background-color: #7A9C59; color: #ffffff; text-decoration: none; font-size: 15px; font-weight: bold; padding: 12px 30px; border-radius: 4px;">Balas Pesan Ini</a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #f9f9f9; padding: 20px; text-align: center; border-top: 1px solid #eeeeee;">
                            <p style="margin: 0; color: #999999; font-size: 12px;">Email ini dikirimkan secara otomatis oleh sistem Recyclink.</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
