import React, { useState } from 'react';
import Layout from '../components/Layout';
import api from '../api';
import { useNavigate } from 'react-router-dom';

function ResetPassword() {
  const navigate = useNavigate();
  const [form, setForm] = useState({
    email: '',
    password: '',
    password_confirmation: '',
  });

  const [errors, setErrors] = useState([]);
  const [success, setSuccess] = useState(null);

  const handleChange = (e) => {
    setForm({ ...form, [e.target.name]: e.target.value });
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    setErrors([]);
    setSuccess(null);

    try {
      await api.post('/reset-password', form); // Sesuaikan dengan endpoint kamu
      setSuccess('Password berhasil direset. Silakan login.');
      setTimeout(() => navigate('/login'), 2000);
    } catch (err) {
      if (err.response?.data?.errors) {
        const allErrors = Object.values(err.response.data.errors).flat();
        setErrors(allErrors);
      } else {
        setErrors(['Terjadi kesalahan saat mereset password.']);
      }
    }
  };

  return (
    <Layout title="Reset Password">
      <div className="row justify-content-center">
        <div className="col-md-6">
          <div className="card shadow p-4">
            <h2 className="mb-4 text-center">Reset Password</h2>

            {success && <div className="alert alert-success">{success}</div>}
            {errors.length > 0 && (
              <div className="alert alert-danger">
                <ul className="mb-0">
                  {errors.map((err, idx) => <li key={idx}>{err}</li>)}
                </ul>
              </div>
            )}

            <form onSubmit={handleSubmit}>
              <div className="mb-3">
                <label className="form-label">Email</label>
                <input
                  type="email"
                  name="email"
                  className="form-control"
                  value={form.email}
                  onChange={handleChange}
                  required
                />
              </div>

              <div className="mb-3">
                <label className="form-label">Password Baru</label>
                <input
                  type="password"
                  name="password"
                  className="form-control"
                  value={form.password}
                  onChange={handleChange}
                  required
                />
              </div>

              <div className="mb-4">
                <label className="form-label">Konfirmasi Password Baru</label>
                <input
                  type="password"
                  name="password_confirmation"
                  className="form-control"
                  value={form.password_confirmation}
                  onChange={handleChange}
                  required
                />
              </div>

              <div className="d-grid">
                <button type="submit" className="btn btn-primary">
                  Reset Password
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </Layout>
  );
}

export default ResetPassword;
