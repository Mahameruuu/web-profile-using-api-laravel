import { BrowserRouter, Routes, Route } from 'react-router-dom';

import Login from './pages/Login';
import Register from './pages/Register';
import Dashboard from './pages/Dashboard';
import KegiatanIndex from './pages/kegiatan/Index';
import KegiatanForm from './pages/kegiatan/Form';
import UserIndex from './pages/user/index';
import UserForm from './pages/user/edit';
import UserImport from './pages/user/import';

function App() {
  return (
    <BrowserRouter>
      <Routes>
        {/* Auth */}
        <Route path="/login" element={<Login />} />
        <Route path="/register" element={<Register />} />

        {/* Dashboard */}
        <Route path="/dashboard" element={<Dashboard />} />

        {/* Kegiatan */}
        <Route path="/kegiatan" element={<KegiatanIndex />} />
        <Route path="/kegiatan/create" element={<KegiatanForm />} />
        <Route path="/kegiatan/edit/:id" element={<KegiatanForm />} />

        {/* Users */}
        <Route path="/users" element={<UserIndex />} />
        <Route path="/users/add" element={<UserForm />} />
        <Route path="/users/edit/:id" element={<UserForm />} />
        <Route path="/users/import" element={<UserImport />} />
      </Routes>
    </BrowserRouter>
  );
}

export default App;
