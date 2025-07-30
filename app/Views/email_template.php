<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Template</title>
</head>

<body style="background: #fff;">
    <table style=" width: 100%; max-width: 600px; margin: 0 auto; padding: 20px; border-collapse: collapse; border: 1px solid #ddd;">
        <tr>
            <td style="padding: 20px; text-align: left;">
                <img src="<?= base_url('public/images/logo-kecil.png') ?>" alt="Sahabat Agro" style="height: 50px; margin-bottom: 10px;">
                <hr>
                <p style="font-size: 16px;">Pengirim : <span style="font-weight: 900;"><?= $nama ?> (<?= $email ?>).</span></p> 
                <hr>
                <p style="font-size: 16px;">Pesan :</p>
                <p style="font-size: 16px;"><?= $pesan ?></p>
            </td>
        </tr>
    </table>

</body>

</html>