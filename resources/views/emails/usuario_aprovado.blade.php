<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Cadastro aprovado</title>
</head>
<body style="font-family:Inter,system-ui,Arial;line-height:1.4;color:#111">
  <div style="max-width:600px;margin:0 auto;padding:20px;background:#fff">
    <h2 style="color:#111">Seu cadastro foi aprovado</h2>
    <p>Olá {{ $usuario->nome }},</p>
    <p>Seu cadastro no <strong>SESI — Painel de Controle</strong> foi aprovado por um administrador. Agora você já pode acessar o sistema com seu e-mail.</p>
    <p>Se precisar, solicite redefinição de senha usando o link de login.</p>
    <p>Atenciosamente,<br/>Equipe SESI</p>
  </div>
</body>
</html>
