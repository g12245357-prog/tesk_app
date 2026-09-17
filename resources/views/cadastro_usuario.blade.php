<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SESI — Painel de Controle</title>
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
            background-image:
                repeating-linear-gradient(0deg, rgba(0,0,0,0.025) 0px, rgba(0,0,0,0.025) 1px, transparent 1px, transparent 40px),
                repeating-linear-gradient(90deg, rgba(0,0,0,0.025) 0px, rgba(0,0,0,0.025) 1px, transparent 1px, transparent 40px);
            padding: 1rem;
        }

        .wrapper { width: 100%; max-width: 335px; }
        .card { background: #fff; border-radius: 12px; box-shadow: 0 8px 28px rgba(0,0,0,0.08); border: 1px solid rgba(0,0,0,0.06); padding: 1.6rem; display: flex; flex-direction: column; gap: 1rem; }
            .register-header { display:flex; align-items:center; gap:12px; }
            .back-btn { width:34px; height:34px; border-radius:8px; border:1px solid rgba(0,0,0,0.08); background:none; cursor:pointer; display:flex; align-items:center; justify-content:center; color:#6b7280; }
            .back-btn:hover { background:#fafafa; color:#1a1a2e; }
            .mini-logo { width:34px; height:34px; border-radius:8px; background:linear-gradient(135deg,#e8192c 0%,#c01020 100%); display:flex; align-items:center; justify-content:center; box-shadow:0 2px 8px rgba(232,25,44,0.25); }
            .mini-logo span{ color:#fff; font-size:0.65rem; font-weight:900 }
            .register-header-text p{ font-size:0.95rem; font-weight:700; color:#1a1a2e; margin:0 }
            .register-header-text small{ display:block; font-size:0.72rem; color:#6b7280 }

            .info-box { display:flex; align-items:flex-start; gap:10px; background:#fff2f2; border-radius:8px; padding:10px 12px; }
            .info-box svg{ color:#e8192c; flex-shrink:0; }
            .info-box p{ margin:0; font-size:0.82rem; color:#6b7280 }
        .brand { display: flex; flex-direction: column; align-items: center; gap: 1rem; }
        .logo { width: 68px; height: 68px; border-radius: 16px; background: linear-gradient(135deg, #e8192c 0%, #c01020 100%); display: flex; align-items: center; justify-content: center; box-shadow: 0 6px 20px rgba(232,25,44,0.35); }
        .logo span { color: #fff; font-size: 1.15rem; font-weight: 900; letter-spacing: -0.05em; }
        .brand-text { text-align: center; }
        .brand-text h1 { font-size: 1.25rem; font-weight: 700; color: #1a1a2e; line-height: 1.3; }
        .brand-text h1 .red { color: #e8192c; }
        .brand-text p { font-size: 0.82rem; color: #6b7280; margin-top: 3px; }
        .divider { border: none; border-top: 1px solid rgba(0,0,0,0.08); }
        form { display: flex; flex-direction: column; gap: 1rem; }
        .field { display: flex; flex-direction: column; gap: 6px; }
        .field label { font-size: 0.85rem; font-weight: 500; color: #1a1a2e; }
        .input-wrap { position: relative; }
        .input-wrap .icon { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #9ca3af; pointer-events: none; display: flex; }
        .input-wrap input, .input-wrap select { width: 100%; padding: 12px 12px 12px 44px; border: 1px solid rgba(0,0,0,0.08); border-radius: 10px; background: #fbfbfc; font-family: 'Inter', sans-serif; font-size: 0.9rem; color: #1a1a2e; outline: none; transition: border-color 0.15s, box-shadow 0.15s, background 0.15s; }
        .input-wrap input::placeholder { color: #9ca3af; }
        .input-wrap input:focus, .input-wrap select:focus { border-color: #e8192c; box-shadow: 0 0 0 3px rgba(232,25,44,0.12); background: #fff; }
        .toggle-pass { position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: #9ca3af; display: flex; padding: 4px; transition: color 0.15s; }
        .toggle-pass:hover { color: #1a1a2e; }
        .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
        select.bare { width: 100%; padding: 10px 12px; border: 1px solid rgba(0,0,0,0.12); border-radius: 8px; background: #f5f5f7; font-family: 'Inter', sans-serif; font-size: 0.875rem; color: #9ca3af; outline: none; appearance: none; cursor: pointer; transition: border-color 0.2s, box-shadow 0.2s, background 0.2s; }
        select.bare.selected { color: #1a1a2e; }
        .error-msg { display: none; align-items: center; gap: 8px; background: #fce8ea; border: 1px solid rgba(232,25,44,0.2); color: #c01020; font-size: 0.8rem; padding: 10px 12px; border-radius: 8px; }
        .error-msg.show { display: flex; }
        .error-dot { width: 6px; height: 6px; border-radius: 50%; background: #e8192c; flex-shrink: 0; }
        .forgot { display: flex; justify-content: flex-end; margin-top: -4px; }
        .forgot a { font-size: 0.75rem; color: #6b7280; text-decoration: none; transition: color 0.2s; }
        .forgot a:hover { color: #e8192c; }
        .btn-primary { width: 100%; padding: 12px; border: none; border-radius: 10px; background: #e8192c; color: #fff; font-family: 'Inter', sans-serif; font-size: 0.95rem; font-weight: 700; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px; transition: opacity 0.15s, transform 0.08s; box-shadow: 0 6px 18px rgba(232,25,44,0.18); margin-top: 6px; }
        .btn-primary:hover { opacity: 0.9; }
        .btn-primary:active { transform: scale(0.98); }
        .btn-primary:disabled { opacity: 0.65; cursor: not-allowed; }
        .spinner { display: none; width: 16px; height: 16px; border: 2px solid rgba(255,255,255,0.3); border-top-color: #fff; border-radius: 50%; animation: spin 0.7s linear infinite; }
        @keyframes spin { to { transform: rotate(360deg); } }
        .footer-note { text-align: center; font-size: 0.75rem; color: #9ca3af; }
        .switch-link { text-align: center; padding-top: 10px; font-size: 0.78rem; color: #6b7280; }
        .switch-link a { color: #e8192c; font-weight: 600; text-decoration: none; }
        .switch-link a:hover { opacity: 0.8; }
        .credit { text-align: center; font-size: 0.72rem; color: #9ca3af; margin-top: 14px; opacity: 0.55; }
        .success-screen { display: flex; flex-direction: column; align-items: center; gap: 1.25rem; text-align: center; }
        .success-icon { width: 68px; height: 68px; border-radius: 16px; background: linear-gradient(135deg, #16a34a 0%, #15803d 100%); display: flex; align-items: center; justify-content: center; box-shadow: 0 6px 20px rgba(22,163,74,0.35); }
        .success-screen h2 { font-size: 1.1rem; font-weight: 700; color: #1a1a2e; }
        .success-screen p { font-size: 0.85rem; color: #6b7280; margin-top: 4px; line-height: 1.5; }
        .screen { display: none; }
        .screen.active { display: flex; flex-direction: column; gap: 1.5rem; }
    </style>
</head>
<body>

<div class="wrapper">
    <div class="card">

        <!-- ══ TELA: LOGIN ══ -->
        <div id="screen-login" class="screen active">

            <div class="brand">
                <div class="logo"><span>SESI</span></div>
                <div class="brand-text">
                    <h1><span class="red">SESI</span> Painel de Controle</h1>
                    <p>Monitoramento de intervalos por sala</p>
                </div>
            </div>

            <hr class="divider" />

            <form id="form-login" novalidate>
                <div class="field">
                    <label>Usuário</label>
                    <div class="input-wrap">
                        <span class="icon">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
                            </svg>
                        </span>
                        <input id="login-usuario" type="text" placeholder="seu.usuario@sesi.org.br" autocomplete="username" />
                    </div>
                </div>

                <div class="field">
                    <label>Senha</label>
                    <div class="input-wrap">
                        <span class="icon">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                            </svg>
                        </span>
                        <input id="login-senha" type="password" placeholder="••••••••" autocomplete="current-password" />
                        <button type="button" class="toggle-pass" onclick="toggleSenha('login-senha', this)">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="error-msg" id="login-error">
                    <span class="error-dot"></span>
                    <span id="login-error-text"></span>
                </div>

                <div class="forgot"><a href="#">Esqueci minha senha</a></div>

                <button type="submit" class="btn-primary" id="btn-login">
                    <span class="spinner" id="spin-login"></span>
                    <span id="txt-login">Entrar no Painel</span>
                </button>
            </form>

            <p class="footer-note">Acesso restrito a funcionários autorizados</p>

            <div class="switch-link">
                Não tem conta? <a href="#" onclick="showScreen('register')">Solicitar cadastro</a>
            </div>
        </div>

        <!-- ══ TELA: CADASTRO ══ -->
        <div id="screen-register" class="screen">

            <div class="register-header">
                <button class="back-btn" onclick="showScreen('login')">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="15 18 9 12 15 6"/>
                    </svg>
                </button>
                <div class="mini-logo"><span>SESI</span></div>
                <div class="register-header-text">
                    <p><span class="red">SESI</span> Painel de Controle</p>
                    <small>Solicitar cadastro</small>
                </div>
            </div>

            <hr class="divider" />

            <div class="info-box">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                </svg>
                <p>O acesso será liberado após aprovação de um administrador.</p>
            </div>

            <form id="form-register" novalidate>
                <div class="field">
                    <label>Nome completo *</label>
                    <div class="input-wrap">
                        <span class="icon">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
                            </svg>
                        </span>
                        <input id="reg-nome" type="text" placeholder="João da Silva" />
                    </div>
                </div>

                <div class="field">
                    <label>E-mail institucional *</label>
                    <div class="input-wrap">
                        <span class="icon">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/>
                            </svg>
                        </span>
                        <input id="reg-email" type="email" placeholder="seu.nome@sesi.org.br" />
                    </div>
                </div>

                <div class="grid-2">
                    <div class="field">
                        <label>Matrícula *</label>
                        <input id="reg-matricula" type="text" placeholder="00000"
                            style="padding: 10px 12px; border: 1px solid rgba(0,0,0,0.12); border-radius: 8px; background: #f5f5f7; font-family: Inter,sans-serif; font-size: 0.875rem; color: #1a1a2e; outline: none; transition: border-color .2s, box-shadow .2s, background .2s; width:100%;"
                            onfocus="this.style.borderColor='#e8192c';this.style.boxShadow='0 0 0 3px rgba(232,25,44,0.12)';this.style.background='#fff'"
                            onblur="this.style.borderColor='rgba(0,0,0,0.12)';this.style.boxShadow='none';this.style.background='#f5f5f7' />
                    </div>
                    <div class="field">
                        <label>Cargo *</label>
                        <select id="reg-cargo" class="bare" onchange="this.classList.add('selected')"
                            onfocus="this.style.borderColor='#e8192c';this.style.boxShadow='0 0 0 3px rgba(232,25,44,0.12)';this.style.background='#fff'"
                            onblur="this.style.borderColor='rgba(0,0,0,0.12)';this.style.boxShadow='none';this.style.background='#f5f5f7'">
                            <option value="" disabled selected>Selecionar</option>
                            <option value="professor">Professor</option>
                            <option value="coordenador">Coordenador</option>
                            <option value="administrativo">Administrativo</option>
                            <option value="diretor">Diretor</option>
                        </select>
                    </div>
                </div>

                <div class="grid-2">
                    <div class="field">
                        <label>Data de Nascimento *</label>
                        <input id="reg-data" type="date" style="padding: 10px 12px; border: 1px solid rgba(0,0,0,0.12); border-radius: 8px; background: #f5f5f7; width:100%" />
                    </div>
                    <div class="field">
                        <label>CPF *</label>
                        <input id="reg-cpf" type="text" placeholder="00000000000" style="padding: 10px 12px; border: 1px solid rgba(0,0,0,0.12); border-radius: 8px; background: #f5f5f7; width:100%" />
                    </div>
                </div>

                <div class="field">
                    <label>Senha *</label>
                    <div class="input-wrap">
                        <span class="icon">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                            </svg>
                        </span>
                        <input id="reg-senha" type="password" placeholder="Mín. 6 caracteres" />
                        <button type="button" class="toggle-pass" onclick="toggleSenha('reg-senha', this)">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="field">
                    <label>Confirmar senha *</label>
                    <div class="input-wrap">
                        <span class="icon">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                            </svg>
                        </span>
                        <input id="reg-confirmar" type="password" placeholder="Repita a senha" />
                        <button type="button" class="toggle-pass" onclick="toggleSenha('reg-confirmar', this)">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="error-msg" id="reg-error">
                    <span class="error-dot"></span>
                    <span id="reg-error-text"></span>
                </div>

                <button type="submit" class="btn-primary" id="btn-register">
                    <span class="spinner" id="spin-register"></span>
                    <span id="txt-register">Enviar solicitação</span>
                </button>
            </form>

            <div class="switch-link">
                Já tem conta? <a href="#" onclick="showScreen('login')">Fazer login</a>
            </div>
        </div>

        <!-- ══ TELA: SUCESSO ══ -->
        <div id="screen-success" class="screen">
            <div class="success-screen">
                <div class="success-icon">
                    <svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
                    </svg>
                </div>
                <div>
                    <h2>Solicitação enviada!</h2>
                    <p>Seu cadastro foi enviado para análise.<br>Você receberá um e-mail assim que for aprovado.</p>
                </div>
                <button class="btn-primary" style="margin-top:0" onclick="showScreen('login')">
                    Voltar ao Login
                </button>
            </div>
        </div>

    </div>
    <p class="credit">SESI — Serviço Social da Indústria</p>
</div>

<script>
    const EYE_OPEN = `<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>`;
    const EYE_OFF  = `<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/>`;

    function toggleSenha(inputId, btn) {
        const input = document.getElementById(inputId);
        const visible = input.type === 'text';
        input.type = visible ? 'password' : 'text';
        btn.querySelector('svg').innerHTML = visible ? EYE_OPEN : EYE_OFF;
    }

    function showScreen(name) {
        document.querySelectorAll('.screen').forEach(s => s.classList.remove('active'));
        document.getElementById('screen-' + name).classList.add('active');
    }

    function showError(id, msg) {
        const el = document.getElementById(id);
        document.getElementById(id + '-text').textContent = msg;
        el.classList.add('show');
    }

    function hideError(id) {
        document.getElementById(id).classList.remove('show');
    }

    /* ── Login (integração com /api/login) ── */
    document.getElementById('form-login').addEventListener('submit', async function(e) {
        e.preventDefault();
        hideError('login-error');
        const usuario = document.getElementById('login-usuario').value.trim();
        const senha   = document.getElementById('login-senha').value.trim();

        if (!usuario || !senha) { showError('login-error', 'Preencha todos os campos.'); return; }

        const btn = document.getElementById('btn-login');
        const spin = document.getElementById('spin-login');
        const txt = document.getElementById('txt-login');
        btn.disabled = true; spin.style.display = 'block'; txt.textContent = 'Entrando...';

        try {
            const resp = await fetch('/api/login', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
                body: JSON.stringify({ email: usuario, senha })
            });
            const data = await resp.json();
            if (data && data.erro === 'n') {
                window.location.href = '/bem-vindos';
                return;
            }
            showError('login-error', data.mensagem || 'Credenciais inválidas.');
        } catch (err) {
            showError('login-error', 'Não foi possível fazer login. Tente novamente.');
        } finally {
            btn.disabled = false; spin.style.display = 'none'; txt.textContent = 'Entrar no Painel';
        }
    });

    /* ── Cadastro local (mock) ── */
    document.getElementById('form-register').addEventListener('submit', function(e) {
        e.preventDefault();
        hideError('reg-error');

        const nome      = document.getElementById('reg-nome').value.trim();
        const email     = document.getElementById('reg-email').value.trim();
        const matricula = document.getElementById('reg-matricula').value.trim();
        const cargo     = document.getElementById('reg-cargo').value;
        const senha     = document.getElementById('reg-senha').value;
        const confirmar = document.getElementById('reg-confirmar').value;

        if (!nome || !email || !matricula || !cargo || !senha || !confirmar) {
            showError('reg-error', 'Preencha todos os campos obrigatórios.'); return;
        }
        if (senha.length < 6) { showError('reg-error', 'A senha deve ter pelo menos 6 caracteres.'); return; }
        if (senha !== confirmar) { showError('reg-error', 'As senhas não coincidem.'); return; }

        const btn = document.getElementById('btn-register');
        const spin = document.getElementById('spin-register');
        const txt = document.getElementById('txt-register');
        btn.disabled = true; spin.style.display = 'block'; txt.textContent = 'Enviando...';

        // Envia para a API real de cadastro
        (async () => {
            try {
                const payload = { nome, email, senha, cpf: document.getElementById('reg-cpf').value.trim(), data_nascimento: document.getElementById('reg-data').value };
                const resp = await fetch('/api/cadastro_usuario', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
                    body: JSON.stringify(payload)
                });
                const data = await resp.json();
                if (data && data.erro === 'n') {
                    showScreen('success');
                } else {
                    showError('reg-error', data.mensagem || 'Erro ao enviar solicitação.');
                }
            } catch (err) {
                showError('reg-error', 'Não foi possível enviar. Tente novamente.');
            } finally {
                btn.disabled = false; spin.style.display = 'none'; txt.textContent = 'Enviar solicitação';
            }
        })();
    });
</script>

</body>
</html>
