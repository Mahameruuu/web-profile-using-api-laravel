import axios from 'axios';

const api = axios.create({
  baseURL: 'http://localhost:8000/api', // arahkan langsung ke /api
  withCredentials: true,
  headers: {
    Accept: 'application/json',
  },
});

// ✅ Tambahkan Authorization Header secara otomatis jika ada token
api.interceptors.request.use(config => {
  const token = localStorage.getItem('token');
  if (token) {
    config.headers.Authorization = `Bearer ${token}`;
  }
  return config;
});

export default api;
