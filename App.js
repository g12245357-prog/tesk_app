import React, { useState } from 'react';
import Login from './src/screens/login';
import Cadastro_User from './src/screens/cadastro_user';
import Home from './src/screens/home';

export default function App() {
  const [screen, setScreen] = useState('login');

  if (screen === 'cadastro') {
    return <Cadastro_User onBackToLogin={() => setScreen('login')} />;
  }

  if (screen === 'home') {
    return <Home onLogout={() => setScreen('login')} />;
  }

  return (
    <Login
      onGoToCadastro={() => setScreen('cadastro')}
      onLoginSuccess={() => setScreen('home')}
    />
  );
}
