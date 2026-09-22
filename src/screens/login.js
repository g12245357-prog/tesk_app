import React, { useState } from 'react';
import {
  KeyboardAvoidingView,
  Platform,
  Pressable,
  SafeAreaView,
  StyleSheet,
  Text,
  TextInput,
  TouchableOpacity,
  View,
} from 'react-native';
import { StatusBar } from 'expo-status-bar';
import { apiRequest } from '../services/api';

export default function Login({ onGoToCadastro, onLoginSuccess }) {
  const [email, setEmail] = useState('');
  const [senha, setSenha] = useState('');
  const [showSenha, setShowSenha] = useState(false);
  const [error, setError] = useState('');
  const [loading, setLoading] = useState(false);
  const [token, setToken] = useState('');

  const handleLogin = async () => {
    if (!email.trim() || !senha.trim()) {
      setError('Preencha todos os campos.');
      return;
    }

    setError('');
    setLoading(true);

    try {
      const data = await apiRequest('/login', {
        method: 'POST',
        body: JSON.stringify({
          email: email.trim(),
          senha: senha,
        }),
      });

      if (data?.erro === 's') {
        setError(data.mensagem || 'Email ou senha inválidos.');
        return;
      }

      if (!data?.token) {
        setError('Resposta do servidor inválida.');
        return;
      }

      console.log('[LOGIN TOKEN]', data.token);
      setToken(data.token);

      if (onLoginSuccess) {
        onLoginSuccess();
      }
    } catch (err) {
      setError(err.message || 'Falha ao entrar no painel.');
    } finally {
      setLoading(false);
    }
  };

  return (
    <SafeAreaView style={styles.safeArea}>
      <StatusBar style="dark" />
      <KeyboardAvoidingView
        style={styles.container}
        behavior={Platform.OS === 'ios' ? 'padding' : undefined}
      >
        <View style={styles.wrapper}>
          <View style={styles.card}>
            <View style={styles.brand}>
              <View style={styles.logo}>
                <Text style={styles.logoText}>SESI</Text>
              </View>

              <View style={styles.brandTextWrap}>
                <Text style={styles.brandTitle}>
                  <Text style={styles.brandAccent}>SESI</Text> Painel de Controle
                </Text>
                <Text style={styles.brandSubtitle}>Monitoramento de intervalos por sala</Text>
              </View>
            </View>

            <View style={styles.divider} />

            <View style={styles.form}>
              <View style={styles.field}>
                <Text style={styles.label}>Usuário</Text>
                <View style={styles.inputWrap}>
                  <Text style={styles.icon}>👤</Text>
                  <TextInput
                    style={styles.input}
                    placeholder="seu.usuario@sesi.org.br"
                    placeholderTextColor="#9ca3af"
                    value={email}
                    onChangeText={setEmail}
                    keyboardType="email-address"
                    autoCapitalize="none"
                    autoCorrect={false}
                    autoComplete="username"
                  />
                </View>
              </View>

              <View style={styles.field}>
                <Text style={styles.label}>Senha</Text>
                <View style={styles.inputWrap}>
                  <Text style={styles.icon}>🔒</Text>
                  <TextInput
                    style={styles.input}
                    placeholder="••••••••"
                    placeholderTextColor="#9ca3af"
                    value={senha}
                    onChangeText={setSenha}
                    secureTextEntry={!showSenha}
                    autoComplete="current-password"
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

              {error ? (
                <View style={styles.errorBox}>
                  <Text style={styles.errorDot}>•</Text>
                  <Text style={styles.errorText}>{error}</Text>
                </View>
              ) : null}

              {token ? (
                <View style={styles.tokenBox}>
                  <Text style={styles.tokenLabel}>Token:</Text>
                  <Text style={styles.tokenText}>{token}</Text>
                </View>
              ) : null}

              <View style={styles.forgotWrap}>
                <Text style={styles.forgotText}>Esqueci minha senha</Text>
              </View>

              <TouchableOpacity
                style={[styles.button, loading && styles.buttonDisabled]}
                onPress={handleLogin}
                disabled={loading}
                activeOpacity={0.9}
              >
                {loading ? <Text style={styles.spinner}>⏳</Text> : null}
                <Text style={styles.buttonText}>
                  {loading ? 'Entrando...' : 'Entrar no Painel'}
                </Text>
              </TouchableOpacity>
            </View>

            <Text style={styles.footerText}>Acesso restrito a funcionários autorizados</Text>

            <Text style={styles.switchText}>
              Não tem conta?{' '}
              <Text style={styles.switchLink} onPress={onGoToCadastro}>Solicitar cadastro</Text>
            </Text>
          </View>

          <Text style={styles.credit}>SESI — Serviço Social da Indústria</Text>
        </View>
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
    justifyContent: 'center',
    alignItems: 'center',
    backgroundColor: '#f0f2f5',
    paddingHorizontal: 16,
  },
  wrapper: {
    width: '100%',
    maxWidth: 335,
    alignItems: 'center',
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
  brand: {
    alignItems: 'center',
    gap: 12,
  },
  logo: {
    width: 48,
    height: 48,
    borderRadius: 10,
    backgroundColor: '#e8192c',
    alignItems: 'center',
    justifyContent: 'center',
    shadowColor: '#e8192c',
    shadowOffset: { width: 0, height: 4 },
    shadowOpacity: 0.28,
    shadowRadius: 12,
    elevation: 4,
  },
  logoText: {
    color: '#fff',
    fontWeight: '900',
    fontSize: 16,
    letterSpacing: 0.3,
  },
  brandTextWrap: {
    alignItems: 'center',
  },
  brandTitle: {
    fontSize: 16,
    fontWeight: '700',
    color: '#111827',
    textAlign: 'center',
  },
  brandAccent: {
    color: '#e8192c',
    fontWeight: '800',
  },
  brandSubtitle: {
    marginTop: 4,
    fontSize: 12,
    color: '#6b7280',
    textAlign: 'center',
  },
  divider: {
    height: 1,
    backgroundColor: 'rgba(0,0,0,0.06)',
    marginVertical: 16,
  },
  form: {
    gap: 14,
  },
  field: {
    gap: 6,
  },
  label: {
    fontSize: 13,
    fontWeight: '600',
    color: '#111827',
  },
  inputWrap: {
    position: 'relative',
    justifyContent: 'center',
  },
  icon: {
    position: 'absolute',
    left: 14,
    color: '#9ca3af',
    fontSize: 16,
    zIndex: 1,
  },
  input: {
    width: '100%',
    height: 44,
    backgroundColor: '#fbfbfc',
    borderWidth: 1,
    borderColor: 'rgba(0,0,0,0.08)',
    borderRadius: 10,
    paddingLeft: 42,
    paddingRight: 40,
    fontSize: 14,
    color: '#111827',
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
  forgotWrap: {
    alignItems: 'flex-end',
  },
  forgotText: {
    color: '#6b7280',
    fontSize: 12,
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
    opacity: 0.6,
  },
  spinner: {
    fontSize: 14,
  },
  buttonText: {
    color: '#fff',
    fontWeight: '700',
    fontSize: 14,
  },
  footerText: {
    marginTop: 18,
    textAlign: 'center',
    color: '#9ca3af',
    fontSize: 12,
  },
  switchText: {
    marginTop: 12,
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
});
