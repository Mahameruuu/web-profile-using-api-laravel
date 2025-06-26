import React, { useState } from 'react';
import Layout from '../components/Layout';
import { Link, useNavigate } from 'react-router-dom';
import api from '../api';

function Register() {
  const navigate = useNavigate();
  const [form, setForm] = useState({
    name: '', email: '', password: '', password_confirmation: '', role: ''
  });
  const [errors, setErrors] = useState([]);

  const handleChange = (e) => setForm({ ...form, [e.target.name]: e.target.value });

  const handleSubmit = async (e) => {
    e.preventDefault();
    setErrors([]);
    try {
      await api.post('/register', form);
      alert('Registrasi berhasil, silakan login');
      navigate('/login');
    } catch (err) {
      if (err.response?.data?.errors) {
        const allErrors = Object.values(err.response.data.errors).flat();
        setErrors(allErrors);
      } else {
        setErrors(['Terjadi kesalahan saat registrasi.']);
      }
    }
  };

  return (
    <Layout title="Register">
      <div className="row justify-content-center">
        <div className="col-md-6">
          <div className="card shadow p-4">
            <h2 className="mb-4 text-center">Register</h2>

            {errors.length > 0 && (
              <div className="alert alert-danger">
                <ul className="mb-0">
                  {errors.map((err, idx) => <li key={idx}>{err}</li>)}
                </ul>
              </div>
            )}

            <form onSubmit={handleSubmit}>
              <div className="mb-3">
                <label className="form-label">Nama</label>
                <input className="form-control" name="name" onChange={handleChange} required />
              </div>
              <div className="mb-3">
                <label className="form-label">Email</label>
                <input type="email" className="form-control" name="email" onChange={handleChange} required />
              </div>
              <div className="mb-3">
                <label className="form-label">Password</label>
                <input type="password" className="form-control" name="password" onChange={handleChange} required />
              </div>
              <div className="mb-3">
                <label className="form-label">Konfirmasi Password</label>
                <input type="password" className="form-control" name="password_confirmation" onChange={handleChange} required />
              </div>
              <div className="mb-4">
                <label className="form-label">Role</label>
                <select className="form-control" name="role" onChange={handleChange} required>
                  <option value="">Pilih Role</option>
                  <option value="admin">Admin</option>
                  <option value="user">User</option>
                </select>
              </div>

              <div className="mb-3 text-end">
                <span className="small">
                  Sudah punya akun?{' '}
                  <Link to="/login" className="text-primary fw-semibold text-decoration-none">
                    Login di sini
                  </Link>
                </span>
              </div>

              <div className="d-grid">
                <button type="submit" className="btn btn-primary">
                  Register
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </Layout>
  );
}

export default Register;
