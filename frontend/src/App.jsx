import { BrowserRouter, Routes, Route } from 'react-router-dom';
import { useEffect } from 'react';
import axios from 'axios';

import Login from './pages/Login';
import Register from './pages/Register';
import ResetPassword from './pages/ResetPassword';
import Dashboard from './pages/Dashboard';

import KegiatanIndex from './pages/kegiatan/Index';
import KegiatanForm from './pages/kegiatan/Form';

import UserIndex from './pages/user/index';
import UserForm from './pages/user/edit';
import UserImport from './pages/user/import';

import InputIndex from './pages/input/Index';   
import InputForm from './pages/input/Form';     

import ProtectedRoute from './components/ProtectedRoute';

function App() {
  useEffect(() => {
    const token = localStorage.getItem('token');
    if (token) {
      axios.get('http://localhost:8000/api/user', {
        headers: {
          Authorization: `Bearer ${token}`,
        },
      }).catch((err) => {
        if (err.response && err.response.status === 401) {
          localStorage.removeItem('token');
          window.location.href = '/login';
        }
      });
    }
  }, []);

  return (
    <BrowserRouter>
      <Routes>
        {/* Public Routes */}
        <Route path="/login" element={<Login />} />
        <Route path="/register" element={<Register />} />
        <Route path="/reset-password" element={<ResetPassword />} />

        {/* Protected Routes */}
        <Route path="/dashboard" element={<ProtectedRoute><Dashboard /></ProtectedRoute>} />

        {/* Kegiatan */}
        <Route path="/kegiatan" element={<ProtectedRoute><KegiatanIndex /></ProtectedRoute>} />
        <Route path="/kegiatan/create" element={<ProtectedRoute><KegiatanForm /></ProtectedRoute>} />
        <Route path="/kegiatan/edit/:id" element={<ProtectedRoute><KegiatanForm /></ProtectedRoute>} />

        {/* Users */}
        <Route path="/users" element={<ProtectedRoute><UserIndex /></ProtectedRoute>} />
        <Route path="/users/add" element={<ProtectedRoute><UserForm /></ProtectedRoute>} />
        <Route path="/users/edit/:id" element={<ProtectedRoute><UserForm /></ProtectedRoute>} />
        <Route path="/users/import" element={<ProtectedRoute><UserImport /></ProtectedRoute>} />

        {/* ✅ Manajemen Input */}
        <Route path="/inputs" element={<ProtectedRoute><InputIndex /></ProtectedRoute>} />
        <Route path="/inputs/create" element={<ProtectedRoute><InputForm /></ProtectedRoute>} />
      </Routes>
    </BrowserRouter>
  );
}

export default App;
