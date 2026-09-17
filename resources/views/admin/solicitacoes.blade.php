<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Solicitações pendentes</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    body{font-family:Inter,system-ui,Arial;padding:24px;background:#f5f7fb}
    .card{max-width:900px;margin:0 auto;background:#fff;padding:20px;border-radius:10px;box-shadow:0 8px 20px rgba(6,18,43,0.06)}
    table{width:100%;border-collapse:collapse}
    th,td{padding:10px;border-bottom:1px solid #eee;text-align:left}
    th{color:#6b7280;font-size:13px}
    .btn{padding:8px 12px;border-radius:8px;border:none;cursor:pointer}
    .btn-approve{background:#16a34a;color:#fff}
  </style>
</head>
<body>
  <div class="card">
    <h2>Solicitações pendentes</h2>
    <p>Forneça um token de administrador (Bearer) ou inclua na query: <code>?token=SEU_TOKEN</code></p>
    <table>
      <thead>
        <tr><th>Nome</th><th>Email</th><th>CPF</th><th>Criado em</th><th></th></tr>
      </thead>
      <tbody>
        @foreach($pending as $p)
        <tr id="row-{{ $p->id }}">
          <td>{{ $p->nome }}</td>
          <td>{{ $p->email }}</td>
          <td>{{ $p->cpf }}</td>
          <td>{{ $p->created_at }}</td>
          <td><button class="btn btn-approve" onclick="aprovar({{ $p->id }})">Aprovar</button></td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>

<script>
  const token = new URLSearchParams(window.location.search).get('token') || '';
  async function aprovar(id){
    if (!token) { alert('Forneça token na query string ou envie Authorization: Bearer <token>'); return; }
    if (!confirm('Aprovar usuário #'+id+'?')) return;
    try {
      const res = await fetch('/admin/aprovar_usuario/'+id, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'Authorization': 'Bearer ' + token },
        body: JSON.stringify({ token })
      });
      const data = await res.json();
      if (data.erro === 'n') { document.getElementById('row-'+id).remove(); alert('Aprovado e e-mail enviado.'); }
      else { alert(data.mensagem || 'Erro'); }
    } catch (e) { alert('Erro na rede'); }
  }
</script>
</body>
</html>
