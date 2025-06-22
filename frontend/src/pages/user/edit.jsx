import React, { useEffect, useState } from 'react';
import { useParams, useNavigate } from 'react-router-dom';
import api from '../../api';

function UserForm() {
  const { id } = useParams();
  const navigate = useNavigate();
  const [form, setForm] = useState({
    name: '',
    email: '',
    password: '',
    role: 'user',
  });

  const getUser = async () => {
    const res = await api.get(`/users/${id}`);
    setForm({ ...res.data, password: '' }); // kosongkan password saat edit
  };

  useEffect(() => {
    if (id) getUser();
  }, [id]);

  const handleChange = (e) => {
    setForm({ ...form, [e.target.name]: e.target.value });
  };

  const handleSubmit = async (e) => {
    e.preventDefault();

    if (id) {
      await api.put(`/users/${id}`, form);
    } else {
      await api.post('/users', form);
    }

    navigate('/users');
  };

  return (
    <div className="container mt-4">
      <h2>{id ? 'Edit' : 'Tambah'} User</h2>
      <form onSubmit={handleSubmit}>
        <div className="mb-3">
          <label>Nama</label>
          <input type="text" name="name" value={form.name} onChange={handleChange} className="form-control" required />
        </div>
        <div className="mb-3">
          <label>Email</label>
          <input type="email" name="email" value={form.email} onChange={handleChange} className="form-control" required />
        </div>
        <div className="mb-3">
          <label>Password {id && '(Kosongkan jika tidak diubah)'}</label>
          <input type="password" name="password" value={form.password} onChange={handleChange} className="form-control" />
        </div>
        <div className="mb-3">
          <label>Role</label>
          <select name="role" value={form.role} onChange={handleChange} className="form-control">
            <option value="user">User</option>
            <option value="admin">Admin</option>
          </select>
        </div>
        <button className="btn btn-success">Simpan</button>
      </form>
    </div>
  );
}

export default UserForm;
