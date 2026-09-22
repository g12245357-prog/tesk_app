export const API_BASE_URL = 'http://10.0.2.2:8000/api';

export async function apiRequest(path, options = {}) {
  const url = `${API_BASE_URL}${path}`;

  const response = await fetch(url, {
    headers: {
      'Content-Type': 'application/json',
      ...(options.headers || {}),
    },
    ...options,
  });

  const rawText = await response.text();
  let payload = null;

  try {
    payload = rawText ? JSON.parse(rawText) : null;
  } catch (error) {
    payload = rawText;
  }

  console.log('[API]', path, JSON.stringify({ status: response.status, payload }, null, 2));

  if (!response.ok) {
    const message = payload?.message || payload?.error || 'Erro ao comunicar com o servidor.';
    throw new Error(message);
  }

  return payload;
}
