<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SESI — Login</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    body {
      font-family: 'Inter', sans-serif;
      background-color: #f0f2f5;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 1rem;
      background-image:
        repeating-linear-gradient(0deg, rgba(0,0,0,0.03) 0px, rgba(0,0,0,0.03) 1px, transparent 1px, transparent 40px),
        repeating-linear-gradient(90deg, rgba(0,0,0,0.03) 0px, rgba(0,0,0,0.03) 1px, transparent 1px, transparent 40px);
    }

    .wrapper { width: 100%; max-width: 335px; }

    .card { background: #fff; border-radius: 12px; box-shadow: 0 8px 28px rgba(0,0,0,0.08); border: 1px solid rgba(0,0,0,0.06); padding: 1.6rem; display: flex; flex-direction: column; gap: 1rem; }

    .brand { display:flex; flex-direction:column; align-items:center; gap:0.8rem }
    .logo { width:48px; height:48px; border-radius:10px; background: linear-gradient(135deg, #e8192c 0%, #c01020 100%); display:flex; align-items:center; justify-content:center; box-shadow:0 4px 12px rgba(232,25,44,0.28) }
    .logo span{ color:#fff; font-weight:900 }
    .brand-text h1{ font-size:1rem; margin:0; font-weight:700 }
    .brand-text p{ font-size:0.78rem; color:#6b7280 }

    .divider { border:none; border-top:1px solid rgba(0,0,0,0.06) }

    form{ display:flex; flex-direction:column; gap:0.9rem }
    .field{ display:flex; flex-direction:column; gap:6px }
    .field label{ font-size:0.85rem; font-weight:600 }
    .input-wrap{ position:relative }
    .input-wrap .icon{ position:absolute; left:12px; top:50%; transform:translateY(-50%); color:#9ca3af }
    .input-wrap input{ width:100%; padding:12px 12px 12px 44px; border:1px solid rgba(0,0,0,0.08); border-radius:10px; background:#fbfbfc; font-size:0.9rem }
    .toggle-pass{ position:absolute; right:10px; top:50%; transform:translateY(-50%); background:none; border:none; cursor:pointer; color:#9ca3af }

    .error-msg{ display:none; align-items:center; gap:8px; background:#fce8ea; border:1px solid rgba(232,25,44,0.2); color:#c01020; font-size:0.82rem; padding:10px 12px; border-radius:8px }
    .error-msg.show{ display:flex }

    .forgot{ display:flex; justify-content:flex-end }
    .forgot a{ font-size:0.75rem; color:#6b7280 }

    .btn-login{ width:100%; padding:12px; border-radius:10px; border:none; background:#e8192c; color:#fff; font-weight:700; box-shadow:0 6px 18px rgba(232,25,44,0.18); cursor:pointer }
    .btn-login:disabled{ opacity:0.6; cursor:not-allowed }

    .spinner{ display:none; width:16px; height:16px; border:2px solid rgba(255,255,255,0.3); border-top-color:#fff; border-radius:50%; animation:spin 0.7s linear infinite }
    @keyframes spin{ to{ transform:rotate(360deg) } }

    .footer-note{ text-align:center; font-size:0.75rem; color:#9ca3af }
    .credit{ text-align:center; font-size:0.72rem; color:#9ca3af; opacity:0.6 }
    svg{ display:block }
  </style>
</head>
<body>

<div class="wrapper">
  <div class="card">
    <div class="brand">
      <div class="logo">
        <span>SESI</span>
      </div>
      <div class="brand-text">
        <h1><span class="sesi">SESI</span> Painel de Controle</h1>
        <p>Monitoramento de intervalos por sala</p>
      </div>
    </div>

    <hr class="divider" />

    <form id="loginForm" novalidate>
      <div class="field">
        <label for="email">Usuário</label>
        <div class="input-wrap">
          <span class="icon">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
            </svg>
          </span>
          <input type="email" id="email" name="email" placeholder="seu.usuario@sesi.org.br" autocomplete="username" required />
        </div>
      </div>

      <div class="field">
        <label for="senha">Senha</label>
        <div class="input-wrap">
          <span class="icon">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>
            </svg>
          </span>
          <input type="password" id="senha" name="senha" placeholder="••••••••" autocomplete="current-password" required />
          <button type="button" class="toggle-pass" id="togglePass" aria-label="Mostrar senha">
            <svg id="eyeIcon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
            </svg>
          </button>
        </div>
      </div>

      <div class="error-msg" id="errorMsg">
        <span class="error-dot"></span>
        <span id="errorText">Preencha todos os campos.</span>
      </div>

      <div class="forgot">
        <a href="#">Esqueci minha senha</a>
      </div>

      <button type="submit" class="btn-login" id="btnLogin">
        <span class="spinner" id="spinner"></span>
        <span id="btnText">Entrar no Painel</span>
      </button>
    </form>

    <p class="footer-note">Acesso restrito a funcionários autorizados</p>
  </div>

  <p class="credit">SESI — Serviço Social da Indústria</p>
</div>

<script>
  const form = document.getElementById('loginForm');
  const togglePass = document.getElementById('togglePass');
  const senhaInput = document.getElementById('senha');
  const eyeIcon = document.getElementById('eyeIcon');
  const errorMsg = document.getElementById('errorMsg');
  const errorText = document.getElementById('errorText');
  const btnLogin = document.getElementById('btnLogin');
  const spinner = document.getElementById('spinner');
  const btnText = document.getElementById('btnText');

  togglePass.addEventListener('click', () => {
    const visible = senhaInput.type === 'text';
    senhaInput.type = visible ? 'password' : 'text';
    eyeIcon.innerHTML = visible
      ? '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>'
      : '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/>';
  });

  form.addEventListener('submit', async (e) => {
    e.preventDefault();

    const email = document.getElementById('email').value.trim();
    const senha = senhaInput.value.trim();

    errorMsg.classList.remove('show');

    if (!email || !senha) {
      errorText.textContent = 'Preencha todos os campos.';
      errorMsg.classList.add('show');
      return;
    }

    btnLogin.disabled = true;
    spinner.style.display = 'block';
    btnText.textContent = 'Entrando...';

    try {
      const response = await fetch('/api/login', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
        },
        body: JSON.stringify({ email, senha })
      });

      const data = await response.json();

      if (data.erro === 'n') {
        // token available in data.token if needed
        window.location.href = '/bem-vindos';
        return;
      }

      errorText.textContent = data.mensagem || 'Credenciais inválidas.';
      errorMsg.classList.add('show');
    } catch (error) {
      errorText.textContent = 'Não foi possível fazer login. Tente novamente.';
      errorMsg.classList.add('show');
    } finally {
      btnLogin.disabled = false;
      spinner.style.display = 'none';
      btnText.textContent = 'Entrar no Painel';
    }
  });
</script>

</body>
</html>
