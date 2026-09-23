<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Réinitialisation de mot de passe</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; margin: 0; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: #fff; border-radius: 8px; overflow: hidden; }
        .header { background: #2d6a4f; padding: 30px; text-align: center; }
        .header h1 { color: #fff; margin: 0; font-size: 22px; }
        .body { padding: 30px; color: #333; }
        .btn { display: inline-block; padding: 14px 28px; background: #2d6a4f; color: #fff;
               text-decoration: none; border-radius: 6px; font-size: 16px; margin: 20px 0; }
        .footer { padding: 20px 30px; background: #f8f8f8; font-size: 12px; color: #999; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🌿 Boutique Guyanaise</h1>
        </div>
        <div class="body">
            <h2>Réinitialisation de mot de passe</h2>
            <p>Vous avez demandé à réinitialiser votre mot de passe. Cliquez sur le bouton ci-dessous :</p>
            <a href="{{ $url }}" class="btn">Réinitialiser mon mot de passe</a>
            <p>Ce lien est valable pendant <strong>60 minutes</strong>.</p>
            <p>Si vous n'avez pas demandé cette réinitialisation, ignorez cet email.</p>
            <hr>
            <p style="font-size:13px; color:#666;">
                Si le bouton ne fonctionne pas, copiez ce lien dans votre navigateur :<br>
                <a href="{{ $url }}">{{ $url }}</a>
            </p>
        </div>
        <div class="footer">
            © {{ date('Y') }} Boutique Guyanaise — Tous droits réservés
        </div>
    </div>
</body>
</html>
