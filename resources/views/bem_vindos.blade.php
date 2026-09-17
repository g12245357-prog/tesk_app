<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bem-vindo — SESI Painel</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    *{box-sizing:border-box;margin:0;padding:0}
    body{font-family:Inter,system-ui,-apple-system,Segoe UI,Roboto,Helvetica,Arial;min-height:100vh;background:#f5f7fb;display:flex;align-items:center;justify-content:center;padding:24px}
    .card{width:100%;max-width:980px;background:#fff;border-radius:12px;box-shadow:0 12px 30px rgba(6,18,43,0.08);overflow:hidden;display:flex}
    .aside{background:linear-gradient(180deg,#fff2f2 0%,#fff 60%);width:360px;padding:28px;display:flex;flex-direction:column;gap:18px}
    .logo{width:56px;height:56px;border-radius:12px;background:linear-gradient(135deg,#e8192c,#c01020);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:800}
    .brand h1{font-size:18px;margin:0;color:#1a1a2e}
    .brand p{font-size:13px;color:#6b7280;margin:0}
    .welcome-title{font-size:22px;font-weight:700;color:#111;margin-top:8px}
    .welcome-sub{color:#60656f;margin-top:6px}
    .meta{margin-top:auto;font-size:13px;color:#9aa0a6}
    .main{flex:1;padding:36px 40px;display:flex;flex-direction:column;justify-content:center;gap:18px}
    .greeting{font-size:20px;font-weight:700;color:#111}
    .desc{color:#6b7280}
    .actions{display:flex;gap:12px;margin-top:8px}
    .btn{padding:12px 16px;border-radius:10px;border:none;cursor:pointer;font-weight:700}
    .btn-primary{background:#e8192c;color:#fff;box-shadow:0 8px 18px rgba(232,25,44,0.16)}
    .btn-outline{background:transparent;border:1px solid rgba(26,26,26,0.06);color:#1a1a2e}
    .cards-row{display:flex;gap:12px;margin-top:18px}
    .stat{background:#fbfbfc;padding:14px;border-radius:10px;flex:1}
    .stat h3{margin:0;font-size:14px;color:#6b7280}
    .stat p{margin-top:8px;font-size:20px;font-weight:700;color:#111}
    @media(max-width:800px){.card{flex-direction:column}.aside{width:100%;padding:18px}.main{padding:20px}}
  </style>
</head>
<body>
  <div class="card">
    <div class="aside">
      <div style="display:flex;gap:12px;align-items:center">
        <div class="logo">SESI</div>
        <div class="brand">
          <h1>SESI Painel de Controle</h1>
          <p>Monitoramento de intervalos por sala</p>
        </div>
      </div>

      <div class="welcome-title">Painel de Controle</div>
      <div class="welcome-sub">Bem-vindo ao painel administrativo. Aqui você pode acompanhar estados por sala, controlar intervalos e gerenciar usuários.</div>

      <div class="meta">SESI — Serviço Social da Indústria</div>
    </div>

    <div class="main">
      <div>
        <div class="greeting">Bem-vindo,
          @auth
            {{ auth()->user()->nome ?? auth()->user()->email }}
          @else
            Usuário
          @endauth
        </div>
        <div class="desc">Seu painel está pronto. Use os botões abaixo para acessar o painel principal ou gerenciar solicitações de cadastro.</div>

        <div class="actions">
          <a href="/dashboard" class="btn btn-primary">Ir para o Painel</a>
          <a href="/cadastro_usuario" class="btn btn-outline">Solicitações</a>
        </div>
      </div>

      <div class="cards-row">
        <div class="stat">
          <h3>Solicitações pendentes</h3>
          <p>{{ $pending ?? 0 }}</p>
        </div>
        <div class="stat">
          <h3>Usuários ativos</h3>
          <p>{{ $totalUsers ?? 0 }}</p>
        </div>
        <div class="stat">
          <h3>Sessões ativas</h3>
          <p>{{ $activeSessions ?? 0 }}</p>
        </div>
      </div>
    </div>
  </div>
</body>
</html>