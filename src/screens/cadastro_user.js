import React, { useMemo, useState } from 'react';
import {
  KeyboardAvoidingView,
  Platform,
  Pressable,
  SafeAreaView,
  ScrollView,
  StyleSheet,
  Text,
  TextInput,
  TouchableOpacity,
  View,
} from 'react-native';
import { StatusBar } from 'expo-status-bar';
import { apiRequest } from '../services/api';

export default function Cadastro_User({ onBackToLogin }) {
  const [form, setForm] = useState({
    nome: '',
    email: '',
    matricula: '',
    cargo: '',
    dataNascimento: '',
    cpf: '',
    senha: '',
    confirmarSenha: '',
  });
  const [showSenha, setShowSenha] = useState(false);
  const [showConfirmar, setShowConfirmar] = useState(false);
  const [error, setError] = useState('');
  const [loading, setLoading] = useState(false);
  const [enviado, setEnviado] = useState(false);

  const cargoOptions = useMemo(
    () => ['Professor', 'Coordenador', 'Administrativo', 'Diretor'],
    []
  );

  const updateField = (field, value) => {
    setForm((prev) => ({ ...prev, [field]: value }));
  };

  const handleSubmit = async () => {
    if (
      !form.nome.trim() ||
      !form.email.trim() ||
      !form.matricula.trim() ||
      !form.cargo.trim() ||
      !form.senha.trim() ||
      !form.confirmarSenha.trim()
    ) {
      setError('Preencha todos os campos obrigatórios.');
      return;
    }

    if (form.senha.length < 6) {
      setError('A senha deve ter pelo menos 6 caracteres.');
      return;
    }

    if (form.senha !== form.confirmarSenha) {
      setError('As senhas não coincidem.');
      return;
    }

    const dataNascimento = form.dataNascimento?.trim();
    if (!dataNascimento) {
      setError('Informe a data de nascimento.');
      return;
    }

    const cpf = form.cpf?.replace(/\D/g, '') || '';
    if (cpf.length < 11) {
      setError('Informe um CPF válido com 11 dígitos.');
      return;
    }

    setError('');
    setLoading(true);

    try {
      const [dia, mes, ano] = dataNascimento.split('/');
      const dataPayload = ano && mes && dia ? `${ano}-${mes}-${dia}` : dataNascimento;

      const response = await apiRequest('/cadastro_usuario', {
        method: 'POST',
        body: JSON.stringify({
          nome: form.nome.trim(),
          email: form.email.trim(),
          senha: form.senha,
          cpf,
          data_nascimento: dataPayload,
        }),
      });

      if (response?.erro === 's') {
        setError(response.mensagem || 'Não foi possível cadastrar.');
        return;
      }

      setEnviado(true);
    } catch (err) {
      setError(err.message || 'Erro ao cadastrar usuário.');
    } finally {
      setLoading(false);
    }
  };

  if (enviado) {
    return (
      <SafeAreaView style={styles.safeArea}>
        <StatusBar style="dark" />
        <View style={styles.containerCentered}>
          <View style={styles.successCard}>
            <View style={styles.successIcon}>
              <Text style={styles.successIconText}>✓</Text>
            </View>
            <Text style={styles.successTitle}>Solicitação enviada!</Text>
            <Text style={styles.successText}>
              Seu cadastro foi enviado para análise. Você receberá um e-mail assim que for aprovado.
            </Text>
            <TouchableOpacity style={styles.button} onPress={onBackToLogin} activeOpacity={0.9}>
              <Text style={styles.buttonText}>Voltar ao Login</Text>
            </TouchableOpacity>
          </View>
        </View>
      </SafeAreaView>
    );
  }

  return (
    <SafeAreaView style={styles.safeArea}>
      <StatusBar style="dark" />
      <KeyboardAvoidingView
        style={styles.container}
        behavior={Platform.OS === 'ios' ? 'padding' : undefined}
      >
        <ScrollView
          contentContainerStyle={styles.scrollContent}
          showsVerticalScrollIndicator={false}
          keyboardShouldPersistTaps="handled"
        >
          <View style={styles.wrapper}>
            <View style={styles.card}>
              <View style={styles.headerRow}>
                <TouchableOpacity style={styles.backButton} onPress={onBackToLogin} activeOpacity={0.8}>
                  <Text style={styles.backButtonText}>←</Text>
                </TouchableOpacity>

                <View style={styles.miniLogo}>
                  <Text style={styles.miniLogoText}>SESI</Text>
                </View>

                <View style={styles.headerTextWrap}>
                  <Text style={styles.headerTitle}>SESI Painel de Controle</Text>
                  <Text style={styles.headerSubtitle}>Solicitar cadastro</Text>
                </View>
              </View>

              <View style={styles.divider} />

              <View style={styles.infoBox}>
                <Text style={styles.infoIcon}>🛡️</Text>
                <Text style={styles.infoText}>O acesso será liberado após aprovação de um administrador.</Text>
              </View>

              <View style={styles.form}>
                <View style={styles.field}>
                  <Text style={styles.label}>Nome completo *</Text>
                  <View style={styles.inputWrap}>
                    <Text style={styles.icon}>👤</Text>
                    <TextInput
                      style={styles.input}
                      placeholder="João da Silva"
                      placeholderTextColor="#9ca3af"
                      value={form.nome}
                      onChangeText={(value) => updateField('nome', value)}
                    />
                  </View>
                </View>

                <View style={styles.field}>
                  <Text style={styles.label}>E-mail institucional *</Text>
                  <View style={styles.inputWrap}>
                    <Text style={styles.icon}>✉️</Text>
                    <TextInput
                      style={styles.input}
                      placeholder="seu.nome@sesi.org.br"
                      placeholderTextColor="#9ca3af"
                      keyboardType="email-address"
                      autoCapitalize="none"
                      autoCorrect={false}
                      value={form.email}
                      onChangeText={(value) => updateField('email', value)}
                    />
                  </View>
                </View>

                <View style={styles.gridTwo}>
                  <View style={styles.field}>
                    <Text style={styles.label}>Matrícula *</Text>
                    <TextInput
                      style={styles.inlineInput}
                      placeholder="00000"
                      placeholderTextColor="#9ca3af"
                      value={form.matricula}
                      onChangeText={(value) => updateField('matricula', value)}
                    />
                  </View>

                  <View style={styles.field}>
                    <Text style={styles.label}>Cargo *</Text>
                    <TextInput
                      style={styles.inlineInput}
                      placeholder="Selecionar"
                      placeholderTextColor="#9ca3af"
                      value={form.cargo}
                      onChangeText={(value) => updateField('cargo', value)}
                    />
                  </View>
                </View>

                <View style={styles.gridTwo}>
                  <View style={styles.field}>
                    <Text style={styles.label}>Data de Nascimento *</Text>
                    <TextInput
                      style={styles.inlineInput}
                      value={form.dataNascimento}
                      onChangeText={(value) => updateField('dataNascimento', value)}
                      placeholder="DD/MM/AAAA"
                      placeholderTextColor="#9ca3af"
                    />
                  </View>

                  <View style={styles.field}>
                    <Text style={styles.label}>CPF *</Text>
                    <TextInput
                      style={styles.inlineInput}
                      placeholder="00000000000"
                      placeholderTextColor="#9ca3af"
                      keyboardType="numeric"
                      value={form.cpf}
                      onChangeText={(value) => updateField('cpf', value)}
                    />
                  </View>
                </View>

                <View style={styles.field}>
                  <Text style={styles.label}>Senha *</Text>
                  <View style={styles.inputWrap}>
                    <Text style={styles.icon}>🔒</Text>
                    <TextInput
                      style={styles.input}
                      placeholder="Mín. 6 caracteres"
                      placeholderTextColor="#9ca3af"
                      secureTextEntry={!showSenha}
                      value={form.senha}
                      onChangeText={(value) => updateField('senha', value)}
                    />
                    <Pressable
                      style={styles.togglePass}
                      onPress={() => setShowSenha((prev) => !prev)}
                      accessibilityRole="button"
                    >
                      <Text style={styles.eyeIcon}>{showSenha ? '🙈' : '👁️'}</Text>
                    </Pressable>
                  </View>
                </View>

                <View style={styles.field}>
                  <Text style={styles.label}>Confirmar senha *</Text>
                  <View style={styles.inputWrap}>
                    <Text style={styles.icon}>🔒</Text>
                    <TextInput
                      style={styles.input}
                      placeholder="Repita a senha"
                      placeholderTextColor="#9ca3af"
                      secureTextEntry={!showConfirmar}
                      value={form.confirmarSenha}
                      onChangeText={(value) => updateField('confirmarSenha', value)}
                    />
                    <Pressable
                      style={styles.togglePass}
                      onPress={() => setShowConfirmar((prev) => !prev)}
                      accessibilityRole="button"
                    >
                      <Text style={styles.eyeIcon}>{showConfirmar ? '🙈' : '👁️'}</Text>
                    </Pressable>
                  </View>
                </View>

                {error ? (
                  <View style={styles.errorBox}>
                    <Text style={styles.errorDot}>•</Text>
                    <Text style={styles.errorText}>{error}</Text>
                  </View>
                ) : null}

                <TouchableOpacity
                  style={[styles.button, loading && styles.buttonDisabled]}
                  onPress={handleSubmit}
                  disabled={loading}
                  activeOpacity={0.9}
                >
                  {loading ? <Text style={styles.spinner}>⏳</Text> : null}
                  <Text style={styles.buttonText}>{loading ? 'Enviando...' : 'Enviar solicitação'}</Text>
                </TouchableOpacity>
              </View>

              <Text style={styles.switchText}>
                Já tem conta?{' '}
                <Text style={styles.switchLink} onPress={onBackToLogin}>Fazer login</Text>
              </Text>
            </View>

            <Text style={styles.credit}>SESI — Serviço Social da Indústria</Text>
          </View>
        </ScrollView>
      </KeyboardAvoidingView>
    </SafeAreaView>
  );
}

const styles = StyleSheet.create({
  safeArea: {
    flex: 1,
    backgroundColor: '#f0f2f5',
  },
  container: {
    flex: 1,
    backgroundColor: '#f0f2f5',
  },
  containerCentered: {
    flex: 1,
    justifyContent: 'center',
    alignItems: 'center',
    backgroundColor: '#f0f2f5',
    paddingHorizontal: 16,
  },
  scrollContent: {
    flexGrow: 1,
    justifyContent: 'center',
    paddingHorizontal: 16,
    paddingVertical: 20,
  },
  wrapper: {
    width: '100%',
    maxWidth: 335,
    alignSelf: 'center',
  },
  card: {
    width: '100%',
    backgroundColor: '#fff',
    borderRadius: 12,
    borderWidth: 1,
    borderColor: 'rgba(0,0,0,0.06)',
    padding: 24,
    shadowColor: '#000',
    shadowOffset: { width: 0, height: 8 },
    shadowOpacity: 0.08,
    shadowRadius: 28,
    elevation: 6,
  },
  headerRow: {
    flexDirection: 'row',
    alignItems: 'center',
    gap: 12,
  },
  backButton: {
    width: 34,
    height: 34,
    borderRadius: 8,
    borderWidth: 1,
    borderColor: 'rgba(0,0,0,0.08)',
    backgroundColor: '#fff',
    alignItems: 'center',
    justifyContent: 'center',
  },
  backButtonText: {
    fontSize: 22,
    color: '#6b7280',
    fontWeight: '600',
  },
  miniLogo: {
    width: 34,
    height: 34,
    borderRadius: 8,
    backgroundColor: '#e8192c',
    alignItems: 'center',
    justifyContent: 'center',
    shadowColor: '#e8192c',
    shadowOffset: { width: 0, height: 2 },
    shadowOpacity: 0.25,
    shadowRadius: 8,
    elevation: 2,
  },
  miniLogoText: {
    color: '#fff',
    fontSize: 11,
    fontWeight: '900',
  },
  headerTextWrap: {
    flex: 1,
  },
  headerTitle: {
    fontSize: 13,
    fontWeight: '700',
    color: '#1a1a2e',
  },
  headerSubtitle: {
    fontSize: 11,
    color: '#6b7280',
    marginTop: 2,
  },
  divider: {
    height: 1,
    backgroundColor: 'rgba(0,0,0,0.08)',
    marginVertical: 16,
  },
  infoBox: {
    flexDirection: 'row',
    alignItems: 'flex-start',
    gap: 10,
    backgroundColor: '#fff2f2',
    borderRadius: 8,
    paddingHorizontal: 12,
    paddingVertical: 10,
  },
  infoIcon: {
    fontSize: 16,
  },
  infoText: {
    flex: 1,
    color: '#6b7280',
    fontSize: 12,
    lineHeight: 18,
  },
  form: {
    marginTop: 18,
    gap: 14,
  },
  field: {
    gap: 6,
  },
  label: {
    fontSize: 13,
    fontWeight: '600',
    color: '#1a1a2e',
  },
  inputWrap: {
    position: 'relative',
    justifyContent: 'center',
  },
  icon: {
    position: 'absolute',
    left: 14,
    zIndex: 1,
    fontSize: 16,
    color: '#9ca3af',
  },
  input: {
    width: '100%',
    backgroundColor: '#fbfbfc',
    borderWidth: 1,
    borderColor: 'rgba(0,0,0,0.08)',
    borderRadius: 10,
    paddingHorizontal: 42,
    paddingVertical: 12,
    fontSize: 14,
    color: '#1a1a2e',
  },
  gridTwo: {
    flexDirection: 'row',
    gap: 12,
  },
  inlineInput: {
    flex: 1,
    backgroundColor: '#f5f5f7',
    borderWidth: 1,
    borderColor: 'rgba(0,0,0,0.12)',
    borderRadius: 8,
    paddingHorizontal: 12,
    paddingVertical: 10,
    fontSize: 13,
    color: '#1a1a2e',
  },
  pickerWrap: {
    flex: 1,
  },
  togglePass: {
    position: 'absolute',
    right: 10,
    width: 24,
    height: 24,
    alignItems: 'center',
    justifyContent: 'center',
  },
  eyeIcon: {
    fontSize: 16,
    color: '#9ca3af',
  },
  errorBox: {
    flexDirection: 'row',
    alignItems: 'center',
    gap: 8,
    backgroundColor: '#fce8ea',
    borderWidth: 1,
    borderColor: 'rgba(232,25,44,0.2)',
    borderRadius: 8,
    paddingHorizontal: 12,
    paddingVertical: 10,
  },
  errorDot: {
    color: '#c01020',
    fontSize: 18,
    lineHeight: 18,
  },
  errorText: {
    color: '#c01020',
    fontSize: 12,
    flexShrink: 1,
  },
  button: {
    height: 44,
    backgroundColor: '#e8192c',
    borderRadius: 10,
    alignItems: 'center',
    justifyContent: 'center',
    flexDirection: 'row',
    gap: 8,
    shadowColor: '#e8192c',
    shadowOffset: { width: 0, height: 6 },
    shadowOpacity: 0.18,
    shadowRadius: 18,
    elevation: 4,
  },
  buttonDisabled: {
    opacity: 0.7,
  },
  buttonText: {
    color: '#fff',
    fontWeight: '700',
    fontSize: 14,
  },
  spinner: {
    fontSize: 14,
  },
  switchText: {
    marginTop: 16,
    textAlign: 'center',
    color: '#6b7280',
    fontSize: 12,
  },
  switchLink: {
    color: '#e8192c',
    fontWeight: '600',
  },
  credit: {
    marginTop: 18,
    textAlign: 'center',
    fontSize: 11,
    color: '#9ca3af',
    opacity: 0.6,
  },
  successCard: {
    width: '100%',
    maxWidth: 335,
    backgroundColor: '#fff',
    borderRadius: 12,
    borderWidth: 1,
    borderColor: 'rgba(0,0,0,0.06)',
    padding: 24,
    alignItems: 'center',
    shadowColor: '#000',
    shadowOffset: { width: 0, height: 8 },
    shadowOpacity: 0.08,
    shadowRadius: 28,
    elevation: 6,
  },
  successIcon: {
    width: 68,
    height: 68,
    borderRadius: 16,
    backgroundColor: '#16a34a',
    alignItems: 'center',
    justifyContent: 'center',
    marginBottom: 18,
  },
  successIconText: {
    color: '#fff',
    fontSize: 32,
    fontWeight: '900',
  },
  successTitle: {
    fontSize: 20,
    fontWeight: '700',
    color: '#1a1a2e',
    marginBottom: 8,
  },
  successText: {
    fontSize: 13,
    color: '#6b7280',
    textAlign: 'center',
    lineHeight: 20,
    marginBottom: 18,
  },
});
