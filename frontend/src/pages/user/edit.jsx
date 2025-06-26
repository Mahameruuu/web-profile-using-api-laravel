import React, { useEffect, useState } from 'react';
import { useParams, useNavigate } from 'react-router-dom';
import api from '../../api';
import DashboardLayout from '../../components/DashboardLayout'; // ← Tambah ini

function UserForm() {
  const { id } = useParams();
  const navigate = useNavigate();

  const [form, setForm] = useState({
    name: '',
    email: '',
    password: '',
    role: 'user',
  });

  const [dynamicInputs, setDynamicInputs] = useState([]);
  const [dynamicValues, setDynamicValues] = useState({});

  const getUser = async () => {
    const res = await api.get(`/users/${id}`);
    setForm({ ...res.data, password: '' });
    if (res.data.dynamic_fields) {
      setDynamicValues(res.data.dynamic_fields);
    }
  };

  const getDynamicInputs = async () => {
    const res = await api.get('/inputs');
    const activeInputs = res.data.filter(i => i.active);
    setDynamicInputs(activeInputs);

    const initialValues = {};
    activeInputs.forEach(i => {
      if (!(i.name in dynamicValues)) {
        initialValues[i.name] = i.type === 'checkbox' ? [] : '';
      }
    });
    setDynamicValues(prev => ({ ...initialValues, ...prev }));
  };

  useEffect(() => {
    if (id) getUser();
    getDynamicInputs();
    // eslint-disable-next-line react-hooks/exhaustive-deps
  }, [id]);

  const handleChange = (e) => {
    setForm({ ...form, [e.target.name]: e.target.value });
  };

  const handleDynamicChange = (e) => {
    setDynamicValues({ ...dynamicValues, [e.target.name]: e.target.value });
  };

  const handleSubmit = async (e) => {
    e.preventDefault();

    const payload = {
      ...form,
      dynamic_fields: dynamicValues,
    };

    if (id) {
      await api.put(`/users/${id}`, payload);
    } else {
      await api.post('/users', payload);
    }

    navigate('/users');
  };

  return (
    <DashboardLayout title={id ? 'Edit User' : 'Tambah User'}>
      <div className="p-6 max-w-3xl mx-auto">
        <div className="bg-white shadow rounded p-6">
          <h2 className="text-2xl font-semibold text-gray-800 mb-4">
            {id ? 'Edit User' : 'Tambah User'}
          </h2>
          <form onSubmit={handleSubmit} className="space-y-4">
            <div>
              <label>Nama</label>
              <input
                type="text"
                name="name"
                value={form.name}
                onChange={handleChange}
                className="form-control"
                required
              />
            </div>
            <div>
              <label>Email</label>
              <input
                type="email"
                name="email"
                value={form.email}
                onChange={handleChange}
                className="form-control"
                required
              />
            </div>
            <div>
              <label>Password {id && '(Kosongkan jika tidak diubah)'}</label>
              <input
                type="password"
                name="password"
                value={form.password}
                onChange={handleChange}
                className="form-control"
              />
            </div>
            <div>
              <label>Role</label>
              <select
                name="role"
                value={form.role}
                onChange={handleChange}
                className="form-control"
              >
                <option value="user">User</option>
                <option value="admin">Admin</option>
              </select>
            </div>

            {/* Dynamic Fields */}
            <div>
              <h5 className="mt-4">Data Tambahan</h5>
              {dynamicInputs.map((input) => (
                <div className="mb-3" key={input.id}>
                  <label>{input.label}</label>

                  {['text', 'textarea'].includes(input.type) && (
                    <input
                      type={input.type}
                      name={input.name}
                      value={dynamicValues[input.name] || ''}
                      onChange={handleDynamicChange}
                      className="form-control"
                    />
                  )}

                  {input.type === 'select' && (
                    <select
                      name={input.name}
                      value={dynamicValues[input.name] || ''}
                      onChange={handleDynamicChange}
                      className="form-control"
                    >
                      <option value="">-- Pilih --</option>
                      {input.options.map((opt, idx) => (
                        <option key={idx} value={opt}>{opt}</option>
                      ))}
                    </select>
                  )}

                  {input.type === 'radio' && input.options.map((opt, idx) => (
                    <div className="form-check form-check-inline" key={idx}>
                      <input
                        type="radio"
                        className="form-check-input"
                        name={input.name}
                        value={opt}
                        checked={dynamicValues[input.name] === opt}
                        onChange={handleDynamicChange}
                      />
                      <label className="form-check-label">{opt}</label>
                    </div>
                  ))}

                  {input.type === 'checkbox' && input.options.map((opt, idx) => (
                    <div className="form-check" key={idx}>
                      <input
                        type="checkbox"
                        className="form-check-input"
                        name={input.name}
                        value={opt}
                        checked={(dynamicValues[input.name] || []).includes(opt)}
                        onChange={(e) => {
                          const isChecked = e.target.checked;
                          const old = dynamicValues[input.name] || [];
                          const updated = isChecked
                            ? [...old, opt]
                            : old.filter(o => o !== opt);
                          setDynamicValues({ ...dynamicValues, [input.name]: updated });
                        }}
                      />
                      <label className="form-check-label">{opt}</label>
                    </div>
                  ))}
                </div>
              ))}
            </div>

            <button className="btn btn-success">Simpan</button>
          </form>
        </div>
      </div>
    </DashboardLayout>
  );
}

export default UserForm;
