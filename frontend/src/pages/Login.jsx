import React, { useState } from 'react';
import Layout from '../components/Layout';
import { Link, useNavigate } from 'react-router-dom';
import api from '../api';

function Login() {
  const navigate = useNavigate();
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
  const [errors, setErrors] = useState(null);
  const [success, setSuccess] = useState(null);

  const handleLogin = async (e) => {
    e.preventDefault();
    setErrors(null);
    try {
      const res = await api.post('/login', { email, password });
      localStorage.setItem('token', res.data.token);
      setSuccess('Login berhasil!');
      navigate('/dashboard');
    } catch (err) {
      setErrors('Email atau password salah');
    }
  };

  return (
    <Layout title="Login">
      <div className="row justify-content-center">
        <div className="col-md-6">
          <div className="card shadow p-4">
            <h2 className="mb-4 text-center">Login</h2>

            {success && <div className="alert alert-success">{success}</div>}
            {errors && <div className="alert alert-danger">{errors}</div>}

            <form onSubmit={handleLogin}>
              <div className="mb-3">
                <label className="form-label">Email</label>
                <input
                  type="email"
                  className="form-control"
                  value={email}
                  required
                  onChange={(e) => setEmail(e.target.value)}
                />
              </div>
              <div className="mb-3">
                <label className="form-label">Password</label>
                <input
                  type="password"
                  className="form-control"
                  value={password}
                  required
                  onChange={(e) => setPassword(e.target.value)}
                />
              </div>

              <div className="mb-3 d-flex justify-content-between align-items-center">
                <span className="small">
                  Belum punya akun?{' '}
                  <Link to="/register" className="text-success fw-semibold text-decoration-none">
                    Daftar
                  </Link>
                </span>
                <Link to="/reset-password" className="small text-primary text-decoration-none">
                  Lupa password?
                </Link>

              </div>

              <div className="d-grid">
                <button type="submit" className="btn btn-primary">
                  Login
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </Layout>
  );
}

export default Login;
