<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SESI - Painel de Controle</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: #f0f2f5;
            min-height: 100vh;
            padding: 20px;
            color: #1a1a2e;
        }

        .header-sesi {
            max-width: 1400px;
            margin: 0 auto 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 16px;
            background: #ffffff;
            padding: 14px 28px;
            border-radius: 16px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06);
            border: 1px solid #e8ecf0;
        }

        .logo-sesi {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .logo-sesi .icone-sesi {
            width: 52px;
            height: 52px;
            background: #cc092f;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-weight: 900;
            font-size: 20px;
            flex-shrink: 0;
            font-family: 'Inter', sans-serif;
            box-shadow: 0 2px 8px rgba(204, 9, 47, 0.2);
        }

        .logo-sesi .texto .nome {
            font-size: 24px;
            font-weight: 800;
            color: #1a1a2e;
            line-height: 1.1;
        }

        .logo-sesi .texto .nome span {
            color: #cc092f;
        }

        .logo-sesi .texto .sub {
            font-size: 13px;
            color: #6b7280;
            font-weight: 400;
        }

        .header-sesi .info-direita {
            display: flex;
            align-items: center;
            gap: 16px;
            flex-wrap: wrap;
        }

        .header-sesi .info-direita .relogio {
            font-family: 'Inter', monospace;
            font-size: 18px;
            font-weight: 600;
            color: #1a1a2e;
            background: #f7f8fa;
            padding: 8px 18px;
            border-radius: 10px;
            border: 1px solid #e8ecf0;
        }

        .btn-admin {
            padding: 8px 20px;
            background: #cc092f;
            color: #fff;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.25s ease;
            font-family: 'Inter', sans-serif;
        }

        .btn-admin:hover {
            background: #a80726;
            transform: scale(1.02);
        }

        .btn-admin.ativo {
            background: #1a1a2e;
        }

        .btn-admin.ativo:hover {
            background: #2d2d4a;
        }

        .legenda-sesi {
            max-width: 1400px;
            margin: 0 auto 18px;
            display: flex;
            gap: 28px;
            flex-wrap: wrap;
            background: #ffffff;
            padding: 10px 24px;
            border-radius: 12px;
            border: 1px solid #e8ecf0;
        }

        .legenda-sesi .item {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 13px;
            color: #4b5563;
            font-weight: 500;
        }

        .legenda-sesi .item .led-mini {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .legenda-sesi .item .led-mini.verde {
            background: #16a34a;
        }

        .legenda-sesi .item .led-mini.vermelho {
            background: #dc2626;
        }

        .painel-salas {
            max-width: 1400px;
            margin: 0 auto 20px;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(148px, 1fr));
            gap: 12px;
        }

        .sala-card {
            background: #ffffff;
            border-radius: 14px;
            padding: 16px 10px 14px;
            text-align: center;
            border: 1px solid #e8ecf0;
            transition: all 0.25s ease;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.02);
            position: relative;
        }

        .sala-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.06);
        }

        .sala-card .sala-nome {
            font-size: 16px;
            font-weight: 700;
            color: #1a1a2e;
            letter-spacing: 0.3px;
        }

        .sala-card .sala-led {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            margin: 10px auto 8px;
            transition: all 0.4s ease;
            position: relative;
        }

        .sala-card .sala-led.verde {
            background: #16a34a;
            box-shadow: 0 0 0 4px rgba(22, 163, 74, 0.1);
        }

        .sala-card .sala-led.vermelho {
            background: #dc2626;
            box-shadow: 0 0 0 4px rgba(220, 38, 38, 0.1);
        }

        .sala-card .sala-status {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .sala-card .sala-status.verde {
            color: #16a34a;
        }

        .sala-card .sala-status.vermelho {
            color: #dc2626;
        }

        .sala-card .sala-horario {
            font-size: 11px;
            color: #9ca3af;
            margin-top: 4px;
            font-weight: 500;
        }

        .sala-card.intervalo .sala-led {
            animation: pulseSutil 2.5s ease-in-out infinite;
        }

        @keyframes pulseSutil {
            0%,
            100% {
                box-shadow: 0 0 0 4px rgba(22, 163, 74, 0.1);
            }
            50% {
                box-shadow: 0 0 0 8px rgba(22, 163, 74, 0.05), 0 0 20px rgba(22, 163, 74, 0.04);
            }
        }

        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
            z-index: 1000;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .modal-overlay.ativo {
            display: flex;
        }

        .modal-admin {
            background: #ffffff;
            border-radius: 20px;
            max-width: 700px;
            width: 100%;
            max-height: 90vh;
            overflow-y: auto;
            padding: 32px 36px 36px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
            animation: modalIn 0.3s ease;
        }

        @keyframes modalIn {
            from {
                opacity: 0;
                transform: scale(0.95) translateY(20px);
            }
            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }

        .modal-admin .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            padding-bottom: 16px;
            border-bottom: 1px solid #e8ecf0;
        }

        .modal-admin .modal-header h2 {
            font-size: 22px;
            font-weight: 700;
            color: #1a1a2e;
        }

        .modal-admin .modal-header h2 span {
            color: #cc092f;
        }

        .modal-admin .modal-header .fechar {
            font-size: 28px;
            cursor: pointer;
            color: #9ca3af;
            transition: color 0.2s;
            background: none;
            border: none;
            line-height: 1;
        }

        .modal-admin .modal-header .fechar:hover {
            color: #1a1a2e;
        }

        .form-adicionar {
            background: #f7f8fa;
            border-radius: 14px;
            padding: 20px;
            margin-bottom: 24px;
            border: 1px solid #e8ecf0;
        }

        .form-adicionar .titulo-form {
            font-size: 14px;
            font-weight: 600;
            color: #4b5563;
            margin-bottom: 14px;
        }

        .form-adicionar .linha-form {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr auto;
            gap: 12px;
            align-items: end;
        }

        .form-adicionar .linha-form .campo {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .form-adicionar .linha-form .campo label {
            font-size: 12px;
            font-weight: 600;
            color: #6b7280;
        }

        .form-adicionar .linha-form .campo input {
            padding: 9px 12px;
            border: 1px solid #e8ecf0;
            border-radius: 8px;
            font-size: 14px;
            font-family: 'Inter', sans-serif;
            background: #ffffff;
            outline: none;
            transition: border-color 0.2s;
        }

        .form-adicionar .linha-form .campo input:focus {
            border-color: #cc092f;
            box-shadow: 0 0 0 3px rgba(204, 9, 47, 0.06);
        }

        .form-adicionar .linha-form .btn-add {
            padding: 9px 20px;
            background: #cc092f;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.2s ease;
            font-family: 'Inter', sans-serif;
            height: 42px;
            white-space: nowrap;
        }

        .form-adicionar .linha-form .btn-add:hover {
            background: #a80726;
        }

        .lista-salas-admin {
            display: flex;
            flex-direction: column;
            gap: 6px;
            max-height: 350px;
            overflow-y: auto;
            padding-right: 4px;
        }

        .lista-salas-admin::-webkit-scrollbar {
            width: 4px;
        }

        .lista-salas-admin::-webkit-scrollbar-track {
            background: #f0f2f5;
            border-radius: 4px;
        }

        .lista-salas-admin::-webkit-scrollbar-thumb {
            background: #d1d5db;
            border-radius: 4px;
        }

        .item-sala-admin {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 16px;
            background: #f7f8fa;
            border-radius: 10px;
            border: 1px solid #e8ecf0;
            transition: all 0.2s ease;
        }

        .item-sala-admin:hover {
            background: #f0f2f5;
        }

        .item-sala-admin .info-sala {
            display: flex;
            align-items: center;
            gap: 16px;
            flex-wrap: wrap;
        }

        .item-sala-admin .info-sala .nome-sala {
            font-weight: 700;
            font-size: 15px;
            color: #1a1a2e;
            min-width: 70px;
        }

        .item-sala-admin .info-sala .horarios {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .item-sala-admin .info-sala .horarios .tag-horario {
            background: #ffffff;
            padding: 2px 12px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 500;
            color: #4b5563;
            border: 1px solid #e8ecf0;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .item-sala-admin .info-sala .horarios .tag-horario .remover-horario {
            color: #dc2626;
            cursor: pointer;
            font-weight: 700;
            font-size: 14px;
            margin-left: 4px;
            background: none;
            border: none;
            line-height: 1;
        }

        .item-sala-admin .info-sala .horarios .tag-horario .remover-horario:hover {
            color: #b91c1c;
        }

        .item-sala-admin .acoes {
            display: flex;
            gap: 6px;
        }

        .item-sala-admin .acoes .btn-remover-sala {
            padding: 4px 12px;
            background: #dc2626;
            color: #fff;
            border: none;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            font-family: 'Inter', sans-serif;
        }

        .item-sala-admin .acoes .btn-remover-sala:hover {
            background: #b91c1c;
        }

        .item-sala-admin .acoes .btn-editar {
            padding: 4px 12px;
            background: #3b82f6;
            color: #fff;
            border: none;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            font-family: 'Inter', sans-serif;
        }

        .item-sala-admin .acoes .btn-editar:hover {
            background: #2563eb;
        }

        .sem-salas {
            text-align: center;
            padding: 30px;
            color: #9ca3af;
            font-size: 14px;
        }

        .toast {
            position: fixed;
            top: 24px;
            right: 24px;
            min-width: 320px;
            max-width: 420px;
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 16px 18px;
            border-radius: 16px;
            color: #fff;
            z-index: 2000;
            opacity: 0;
            transform: translateY(-20px) scale(0.96);
            transition: all 0.35s ease;
            box-shadow: 0 18px 40px rgba(17, 24, 39, 0.22);
            border: 1px solid rgba(255, 255, 255, 0.18);
            backdrop-filter: blur(6px);
        }

        .toast.ativo {
            opacity: 1;
            transform: translateY(0) scale(1);
        }

        .toast .toast-icon {
            width: 42px;
            height: 42px;
            min-width: 42px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            background: rgba(255, 255, 255, 0.14);
            box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.12);
        }

        .toast .toast-content {
            display: flex;
            flex-direction: column;
            gap: 4px;
            flex: 1;
        }

        .toast .toast-title {
            font-size: 12px;
            font-weight: 800;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            opacity: 0.9;
        }

        .toast .toast-message {
            font-size: 14px;
            font-weight: 600;
            line-height: 1.4;
            word-break: break-word;
        }

        .toast.sucesso {
            background: linear-gradient(135deg, #16a34a, #15803d);
        }

        .toast.erro {
            background: linear-gradient(135deg, #dc2626, #b91c1c);
        }

        .toast.info {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
        }

        @media (max-width: 768px) {
            .toast {
                top: 16px;
                right: 16px;
                left: 16px;
                min-width: auto;
                max-width: none;
            }
        }

        @media (max-width: 1024px) {
            .painel-salas {
                grid-template-columns: repeat(auto-fill, minmax(130px, 1fr));
            }
        }

        @media (max-width: 768px) {
            body {
                padding: 12px;
            }

            .header-sesi {
                padding: 12px 18px;
                flex-direction: column;
                align-items: stretch;
                gap: 12px;
            }

            .logo-sesi .icone-sesi {
                width: 44px;
                height: 44px;
                font-size: 16px;
            }

            .logo-sesi .texto .nome {
                font-size: 20px;
            }

            .header-sesi .info-direita {
                justify-content: space-between;
            }

            .painel-salas {
                grid-template-columns: repeat(auto-fill, minmax(110px, 1fr));
                gap: 8px;
            }

            .sala-card {
                padding: 12px 8px 10px;
            }

            .sala-card .sala-nome {
                font-size: 14px;
            }

            .sala-card .sala-led {
                width: 36px;
                height: 36px;
            }

            .modal-admin {
                padding: 24px 20px;
            }

            .form-adicionar .linha-form {
                grid-template-columns: 1fr 1fr;
            }

            .form-adicionar .linha-form .btn-add {
                grid-column: 1 / -1;
                height: 40px;
            }

            .item-sala-admin {
                flex-direction: column;
                align-items: stretch;
                gap: 8px;
            }

            .item-sala-admin .info-sala {
                flex-direction: column;
                align-items: flex-start;
                gap: 6px;
            }

            .item-sala-admin .acoes {
                justify-content: flex-end;
            }
        }

        @media (max-width: 480px) {
            .painel-salas {
                grid-template-columns: repeat(auto-fill, minmax(90px, 1fr));
                gap: 6px;
            }

            .sala-card .sala-nome {
                font-size: 12px;
            }

            .sala-card .sala-led {
                width: 30px;
                height: 30px;
                margin: 6px auto;
            }

            .sala-card .sala-status {
                font-size: 8px;
            }

            .sala-card .sala-horario {
                font-size: 9px;
            }

            .modal-admin {
                padding: 16px;
            }

            .form-adicionar .linha-form {
                grid-template-columns: 1fr;
            }

            .item-sala-admin .info-sala .horarios .tag-horario {
                font-size: 11px;
                padding: 2px 8px;
            }
        }
    </style>
</head>
<body>
    <header class="header-sesi">
        <div class="logo-sesi">
            <div class="icone-sesi">SESI</div>
            <div class="texto">
                <div class="nome">SESI <span>Painel de Controle</span></div>
                <div class="sub">Monitoramento de intervalos por sala</div>
            </div>
        </div>
        <div class="info-direita">
            <div class="relogio" id="relogioGlobal">⏰ 00:00:00</div>
            <button class="btn-admin" id="btnAdmin">⚙️ Administrar Salas</button>
        </div>
    </header>

    <div class="legenda-sesi">
        <div class="item">
            <span class="led-mini verde"></span>
            <span>🟢 Intervalo — Sala liberada</span>
        </div>
        <div class="item">
            <span class="led-mini vermelho"></span>
            <span>🔴 Em aula — Sala fechada</span>
        </div>
        <div class="item">
            <span style="color:#9ca3af;">⏳</span>
            <span style="color:#6b7280;">Atualização automática a cada 1s</span>
        </div>
        <div class="item" id="contadorSalas" style="font-weight:600;color:#1a1a2e;">
            <span id="contVerde" style="color:#16a34a;">0</span> abertas ·
            <span id="contVermelho" style="color:#dc2626;">0</span> fechadas ·
            <span id="contTotal">0</span> salas
        </div>
    </div>

    <div class="painel-salas" id="painelSalas"></div>

    <div class="modal-overlay" id="modalAdmin">
        <div class="modal-admin">
            <div class="modal-header">
                <h2>⚙️ Administrar <span>Salas</span></h2>
                <button class="fechar" id="fecharModal">✕</button>
            </div>

            <div class="form-adicionar">
                <div class="titulo-form">➕ Adicionar Nova Sala</div>
                <div class="linha-form">
                    <div class="campo">
                        <label>Nome da Sala</label>
                        <input type="text" id="inputNomeSala" placeholder="Ex: 10A">
                    </div>
                    <div class="campo">
                        <label>Início do Intervalo</label>
                        <input type="time" id="inputInicio" value="09:30">
                    </div>
                    <div class="campo">
                        <label>Fim do Intervalo</label>
                        <input type="time" id="inputFim" value="10:00">
                    </div>
                    <button class="btn-add" id="btnAddSala">➕ Adicionar</button>
                </div>
            </div>

            <div class="titulo-form" style="font-size:14px;font-weight:600;color:#4b5563;margin-bottom:12px;">
                📋 Salas Cadastradas
            </div>
            <div class="lista-salas-admin" id="listaSalasAdmin"></div>
        </div>
    </div>

    <div class="toast" id="toast"></div>

    <script>
        const DADOS_PADRAO = {
            // Exemplo: cada sala pode ter 'intervalos' (pausas) e opcionalmente 'aulas' (disciplinas com horário)
            '1A': { 
                intervalos: [{ inicio: '09:30', fim: '10:00' }, { inicio: '15:20', fim: '15:50' }],
                aulas: [{ inicio: '08:00', fim: '09:30', nome: 'Matemática' }, { inicio: '10:00', fim: '12:00', nome: 'Português' }]
            },
            '1B': { intervalos: [{ inicio: '09:30', fim: '10:00' }, { inicio: '15:20', fim: '15:50' }] },
            '2A': { intervalos: [{ inicio: '09:45', fim: '10:15' }, { inicio: '15:35', fim: '16:05' }], aulas: [{ inicio: '08:00', fim: '09:45', nome: 'História' }] },
            '2B': { intervalos: [{ inicio: '09:45', fim: '10:15' }, { inicio: '15:35', fim: '16:05' }] },
            '3A': { intervalos: [{ inicio: '10:00', fim: '10:30' }, { inicio: '15:50', fim: '16:20' }], aulas: [{ inicio: '07:30', fim: '10:00', nome: 'Química' }] },
            '3B': { intervalos: [{ inicio: '10:00', fim: '10:30' }, { inicio: '15:50', fim: '16:20' }] },
            '4A': { intervalos: [{ inicio: '10:15', fim: '10:45' }, { inicio: '16:05', fim: '16:35' }] },
            '4B': { intervalos: [{ inicio: '10:15', fim: '10:45' }, { inicio: '16:05', fim: '16:35' }] },
            '5A': { intervalos: [{ inicio: '10:30', fim: '11:00' }, { inicio: '16:20', fim: '16:50' }] },
            '5B': { intervalos: [{ inicio: '10:30', fim: '11:00' }, { inicio: '16:20', fim: '16:50' }] },
            '6A': { intervalos: [{ inicio: '10:45', fim: '11:15' }, { inicio: '16:35', fim: '17:05' }] },
            '6B': { intervalos: [{ inicio: '10:45', fim: '11:15' }, { inicio: '16:35', fim: '17:05' }] },
            '7A': { intervalos: [{ inicio: '11:00', fim: '11:30' }, { inicio: '16:50', fim: '17:20' }] },
            '7B': { intervalos: [{ inicio: '11:00', fim: '11:30' }, { inicio: '16:50', fim: '17:20' }] },
            '8A': { intervalos: [{ inicio: '11:15', fim: '11:45' }, { inicio: '17:05', fim: '17:35' }] },
            '8B': { intervalos: [{ inicio: '11:15', fim: '11:45' }, { inicio: '17:05', fim: '17:35' }] },
            '9A': { intervalos: [{ inicio: '11:30', fim: '12:00' }, { inicio: '17:20', fim: '17:50' }] },
            '9B': { intervalos: [{ inicio: '11:30', fim: '12:00' }, { inicio: '17:20', fim: '17:50' }] },
            '1º EM A': { intervalos: [{ inicio: '12:00', fim: '12:30' }, { inicio: '17:50', fim: '18:20' }] },
            '1º EM B': { intervalos: [{ inicio: '12:00', fim: '12:30' }, { inicio: '17:50', fim: '18:20' }] },
            '2º EM A': { intervalos: [{ inicio: '12:15', fim: '12:45' }, { inicio: '18:05', fim: '18:35' }] },
            '2º EM B': { intervalos: [{ inicio: '12:15', fim: '12:45' }, { inicio: '18:05', fim: '18:35' }] },
            '3º EM A': { intervalos: [{ inicio: '12:30', fim: '13:00' }, { inicio: '18:20', fim: '18:50' }] },
            '3º EM B': { intervalos: [{ inicio: '12:30', fim: '13:00' }, { inicio: '18:20', fim: '18:50' }] }
        };

        function carregarDados() {
            const dados = localStorage.getItem('sesi_horarios_salas');
            if (dados) {
                try {
                    return JSON.parse(dados);
                } catch (e) {
                    return JSON.parse(JSON.stringify(DADOS_PADRAO));
                }
            }
            localStorage.setItem('sesi_horarios_salas', JSON.stringify(DADOS_PADRAO));
            return JSON.parse(JSON.stringify(DADOS_PADRAO));
        }

        function salvarDados(dados) {
            localStorage.setItem('sesi_horarios_salas', JSON.stringify(dados));
        }

        let horariosSalas = carregarDados();
        let ultimoEstadoSalas = {};

        function getSalasOrdenadas() {
            return Object.keys(horariosSalas).sort((a, b) => {
                const numA = parseInt(a);
                const numB = parseInt(b);
                if (!isNaN(numA) && !isNaN(numB)) return numA - numB;
                if (!isNaN(numA)) return -1;
                if (!isNaN(numB)) return 1;
                return a.localeCompare(b);
            });
        }

        function paraMinutos(hora) {
            const partes = hora.split(':');
            return parseInt(partes[0]) * 60 + parseInt(partes[1]);
        }

        function formatarHora(agora) {
            const h = String(agora.getHours()).padStart(2, '0');
            const m = String(agora.getMinutes()).padStart(2, '0');
            const s = String(agora.getSeconds()).padStart(2, '0');
            return `${h}:${m}:${s}`;
        }

        function salaEmIntervalo(sala, horaAtual) {
            const horarios = horariosSalas[sala];
            if (!horarios) return false;
            for (let i = 0; i < horarios.intervalos.length; i++) {
                const inicio = paraMinutos(horarios.intervalos[i].inicio);
                const fim = paraMinutos(horarios.intervalos[i].fim);
                if (horaAtual >= inicio && horaAtual <= fim) return true;
            }
            return false;
        }

        function proximoHorarioSala(sala, horaAtual) {
            const horarios = horariosSalas[sala];
            if (!horarios) return null;
            let proximo = null;
            let menorDiff = Infinity;
            for (let i = 0; i < horarios.intervalos.length; i++) {
                const inicio = paraMinutos(horarios.intervalos[i].inicio);
                if (horaAtual < inicio) {
                    const diff = inicio - horaAtual;
                    if (diff < menorDiff) {
                        menorDiff = diff;
                        proximo = horarios.intervalos[i];
                    }
                }
            }
            if (!proximo && horarios.intervalos.length > 0) {
                return horarios.intervalos[0];
            }
            return proximo;
        }

        function salaAulaAtual(sala, horaAtual) {
            const dados = horariosSalas[sala];
            if (!dados || !dados.aulas) return null;
            for (let i = 0; i < dados.aulas.length; i++) {
                const inicio = paraMinutos(dados.aulas[i].inicio);
                const fim = paraMinutos(dados.aulas[i].fim);
                if (horaAtual >= inicio && horaAtual <= fim) return dados.aulas[i].nome;
            }
            return null;
        }

        function showToast(mensagem, tipo = 'sucesso') {
            const toast = document.getElementById('toast');
            const titulo = tipo === 'erro' ? 'Alerta' : tipo === 'info' ? 'Informação' : 'Sucesso';
            const icone = tipo === 'erro' ? '🚨' : tipo === 'info' ? 'ℹ️' : '✅';

            toast.innerHTML = `
                <div class="toast-icon">${icone}</div>
                <div class="toast-content">
                    <div class="toast-title">${titulo}</div>
                    <div class="toast-message">${mensagem}</div>
                </div>
            `;

            toast.className = `toast ${tipo} ativo`;
            clearTimeout(toast._timeout);
            toast._timeout = setTimeout(() => {
                toast.classList.remove('ativo');
            }, 3000);
        }

        function renderizarPainel() {
            const agora = new Date();
            const horaAtual = agora.getHours() * 60 + agora.getMinutes();
            const horaString = formatarHora(agora);

            document.getElementById('relogioGlobal').textContent = `⏰ ${horaString}`;

            const painel = document.getElementById('painelSalas');
            painel.innerHTML = '';

            let contVerde = 0;
            let contVermelho = 0;
            const salas = getSalasOrdenadas();

            salas.forEach(sala => {
                const emIntervalo = salaEmIntervalo(sala, horaAtual);
                const prox = proximoHorarioSala(sala, horaAtual);
                const eraIntervalo = !!ultimoEstadoSalas[sala];

                if (emIntervalo) contVerde++;
                else contVermelho++;

                if (eraIntervalo && !emIntervalo) {
                    showToast(`🚨 Sala ${sala} voltou para aula!`, 'erro');
                }

                ultimoEstadoSalas[sala] = emIntervalo;

                const card = document.createElement('div');
                card.className = `sala-card ${emIntervalo ? 'intervalo' : ''}`;

                let horarioTexto = '';
                if (emIntervalo) {
                    const horarios = horariosSalas[sala];
                    for (let i = 0; i < horarios.intervalos.length; i++) {
                        const inicio = paraMinutos(horarios.intervalos[i].inicio);
                        const fim = paraMinutos(horarios.intervalos[i].fim);
                        if (horaAtual >= inicio && horaAtual <= fim) {
                            horarioTexto = `⏳ Volta às ${horarios.intervalos[i].fim}`;
                            break;
                        }
                    }
                } else if (prox) {
                    horarioTexto = `⏳ Próximo: ${prox.inicio}`;
                } else {
                    horarioTexto = '⏳ —';
                }

                const aulaAtual = salaAulaAtual(sala, horaAtual);

                card.innerHTML = `
                    <div class="sala-nome">${sala}</div>
                    <div class="sala-led ${emIntervalo ? 'verde' : 'vermelho'}"></div>
                    <div class="sala-status ${emIntervalo ? 'verde' : 'vermelho'}">
                        ${emIntervalo ? '🟢 INTERVALO' : (aulaAtual ? '🔴 ' + aulaAtual.toUpperCase() : '🔴 EM AULA')}
                    </div>
                    <div class="sala-horario">${horarioTexto}</div>
                `;

                painel.appendChild(card);
            });

            document.getElementById('contVerde').textContent = contVerde;
            document.getElementById('contVermelho').textContent = contVermelho;
            document.getElementById('contTotal').textContent = salas.length;
        }

        function renderizarAdmin() {
            const lista = document.getElementById('listaSalasAdmin');
            const salas = getSalasOrdenadas();

            if (salas.length === 0) {
                lista.innerHTML = '<div class="sem-salas">Nenhuma sala cadastrada. Adicione uma acima!</div>';
                return;
            }

            lista.innerHTML = '';
            salas.forEach(sala => {
                const horarios = horariosSalas[sala];
                const div = document.createElement('div');
                div.className = 'item-sala-admin';

                let tagsHorarios = '';
                horarios.intervalos.forEach((h, idx) => {
                    tagsHorarios += `
                        <span class="tag-horario">
                            ${h.inicio} → ${h.fim}
                            <button class="remover-horario" data-sala="${sala}" data-idx="${idx}">✕</button>
                        </span>
                    `;
                });

                div.innerHTML = `
                    <div class="info-sala">
                        <span class="nome-sala">${sala}</span>
                        <div class="horarios">${tagsHorarios}</div>
                    </div>
                    <div class="acoes">
                        <button class="btn-editar" data-sala="${sala}">✏️ Editar</button>
                        <button class="btn-remover-sala" data-sala="${sala}">🗑️ Remover</button>
                    </div>
                `;

                lista.appendChild(div);
            });

            document.querySelectorAll('.remover-horario').forEach(btn => {
                btn.addEventListener('click', function() {
                    const sala = this.dataset.sala;
                    const idx = parseInt(this.dataset.idx);
                    removerHorario(sala, idx);
                });
            });

            document.querySelectorAll('.btn-remover-sala').forEach(btn => {
                btn.addEventListener('click', function() {
                    const sala = this.dataset.sala;
                    removerSala(sala);
                });
            });

            document.querySelectorAll('.btn-editar').forEach(btn => {
                btn.addEventListener('click', function() {
                    const salaAntiga = this.dataset.sala;
                    const novoNome = prompt('Editar nome da sala:', salaAntiga);
                    if (novoNome && novoNome.trim() !== '' && novoNome !== salaAntiga) {
                        editarSala(salaAntiga, novoNome.trim());
                    } else if (novoNome === '') {
                        showToast('O nome da sala não pode estar vazio!', 'erro');
                    }
                });
            });
        }

        function adicionarSala() {
            const nome = document.getElementById('inputNomeSala').value.trim();
            const inicio = document.getElementById('inputInicio').value;
            const fim = document.getElementById('inputFim').value;

            if (!nome) {
                showToast('Digite o nome da sala!', 'erro');
                return;
            }

            if (!inicio || !fim) {
                showToast('Selecione os horários!', 'erro');
                return;
            }

            if (horariosSalas[nome]) {
                showToast(`A sala "${nome}" já existe!`, 'erro');
                return;
            }

            horariosSalas[nome] = {
                intervalos: [{ inicio, fim }]
            };

            salvarDados(horariosSalas);
            document.getElementById('inputNomeSala').value = '';
            renderizarAdmin();
            renderizarPainel();
            showToast(`✅ Sala "${nome}" adicionada com sucesso!`, 'sucesso');
        }

        function removerSala(sala) {
            if (confirm(`Tem certeza que deseja remover a sala "${sala}"?`)) {
                delete horariosSalas[sala];
                salvarDados(horariosSalas);
                renderizarAdmin();
                renderizarPainel();
                showToast(`🗑️ Sala "${sala}" removida!`, 'info');
            }
        }

        function editarSala(salaAntiga, novoNome) {
            if (horariosSalas[novoNome] && novoNome !== salaAntiga) {
                showToast(`A sala "${novoNome}" já existe!`, 'erro');
                return;
            }
            horariosSalas[novoNome] = horariosSalas[salaAntiga];
            delete horariosSalas[salaAntiga];
            salvarDados(horariosSalas);
            renderizarAdmin();
            renderizarPainel();
            showToast(`✏️ Sala "${salaAntiga}" renomeada para "${novoNome}"`, 'sucesso');
        }

        function removerHorario(sala, idx) {
            const horarios = horariosSalas[sala];
            if (!horarios) return;

            if (horarios.intervalos.length <= 1) {
                showToast(`A sala "${sala}" precisa ter pelo menos um horário!`, 'erro');
                return;
            }

            horarios.intervalos.splice(idx, 1);
            salvarDados(horariosSalas);
            renderizarAdmin();
            renderizarPainel();
            showToast(`⏳ Horário removido da sala "${sala}"`, 'info');
        }

        document.getElementById('btnAdmin').addEventListener('click', function() {
            const modal = document.getElementById('modalAdmin');
            modal.classList.toggle('ativo');
            if (modal.classList.contains('ativo')) {
                renderizarAdmin();
                this.textContent = '✕ Fechar';
                this.classList.add('ativo');
            } else {
                this.textContent = '⚙️ Administrar Salas';
                this.classList.remove('ativo');
            }
        });

        document.getElementById('fecharModal').addEventListener('click', function() {
            document.getElementById('modalAdmin').classList.remove('ativo');
            document.getElementById('btnAdmin').textContent = '⚙️ Administrar Salas';
            document.getElementById('btnAdmin').classList.remove('ativo');
        });

        document.getElementById('modalAdmin').addEventListener('click', function(e) {
            if (e.target === this) {
                this.classList.remove('ativo');
                document.getElementById('btnAdmin').textContent = '⚙️ Administrar Salas';
                document.getElementById('btnAdmin').classList.remove('ativo');
            }
        });

        document.getElementById('btnAddSala').addEventListener('click', adicionarSala);

        document.getElementById('inputNomeSala').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') adicionarSala();
        });

        renderizarPainel();
        setInterval(renderizarPainel, 1000);
    </script>
</body>
</html>
