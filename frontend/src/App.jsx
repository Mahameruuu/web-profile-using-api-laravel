import { BrowserRouter, Routes, Route } from 'react-router-dom';
import { useEffect } from 'react';
import axios from 'axios';

// Public Pages
import LandingPage from './pages/LandingPage';
import Login from './pages/Login';
import Register from './pages/Register';
import ResetPassword from './pages/ResetPassword';

// Protected Pages
import Dashboard from './pages/Dashboard';
import KegiatanIndex from './pages/kegiatan/Index';
import KegiatanForm from './pages/kegiatan/Form';
import UserIndex from './pages/user/index';
import UserForm from './pages/user/edit';
import UserImport from './pages/user/import';
import InputIndex from './pages/input/Index';
import InputForm from './pages/input/Form';

// 📄 Surat Cuti Pages
import CutiIndex from './pages/cuti/Index';
import CutiForm from './pages/cuti/Create';

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
        {/* ✅ Landing Page untuk User */}
        <Route path="/" element={<LandingPage />} />

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

        {/* Inputs */}
        <Route path="/inputs" element={<ProtectedRoute><InputIndex /></ProtectedRoute>} />
        <Route path="/inputs/create" element={<ProtectedRoute><InputForm /></ProtectedRoute>} />

        {/* 📄 Surat Cuti */}
        <Route path="/cuti" element={<ProtectedRoute><CutiIndex /></ProtectedRoute>} />
        <Route path="/cuti/create" element={<ProtectedRoute><CutiForm /></ProtectedRoute>} />
      </Routes>
    </BrowserRouter>
  );
}

export default App;
