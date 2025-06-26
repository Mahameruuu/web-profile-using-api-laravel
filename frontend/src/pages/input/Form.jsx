import React, { useState } from 'react';
import axios from 'axios';
import DashboardLayout from '../../components/DashboardLayout';

const InputForm = () => {
  const [form, setForm] = useState({
    label: '',
    name: '',
    type: 'text',
    active: true,
    options: '',
  });

  const handleChange = (e) => {
    const { name, value, type, checked } = e.target;
    const newValue = type === 'checkbox' ? checked : value;
    setForm({ ...form, [name]: newValue });
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    const token = localStorage.getItem('token');
    const payload = {
      ...form,
      options: form.options ? form.options.split(',').map(o => o.trim()) : null,
    };

    try {
      await axios.post('http://localhost:8000/api/inputs', payload, {
        headers: { Authorization: `Bearer ${token}` },
      });

      alert('Input berhasil ditambahkan');
      window.location.href = '/inputs';
    } catch (error) {
      alert('Gagal menambahkan input');
      console.error(error);
    }
  };

  return (
    <DashboardLayout title="Tambah Input">
      <div className="p-6 max-w-2xl mx-auto">
        <div className="bg-white shadow rounded p-6">
          <h2 className="text-2xl font-semibold text-gray-800 mb-4">Tambah Input Baru</h2>
          <form onSubmit={handleSubmit} className="space-y-5">
            <div>
              <label className="block mb-1 font-medium text-gray-700">Label</label>
              <input
                type="text"
                name="label"
                value={form.label}
                onChange={handleChange}
                className="w-full border px-3 py-2 rounded"
                required
              />
            </div>

            <div>
              <label className="block mb-1 font-medium text-gray-700">Name (unik)</label>
              <input
                type="text"
                name="name"
                value={form.name}
                onChange={handleChange}
                className="w-full border px-3 py-2 rounded"
                required
              />
            </div>

            <div>
              <label className="block mb-1 font-medium text-gray-700">Tipe Input</label>
              <select
                name="type"
                value={form.type}
                onChange={handleChange}
                className="w-full border px-3 py-2 rounded"
              >
                <option value="text">Text</option>
                <option value="textarea">Textarea</option>
                <option value="select">Select</option>
                <option value="checkbox">Checkbox</option>
                <option value="radio">Radio</option>
              </select>
            </div>

            <div>
              <label className="block mb-1 font-medium text-gray-700">
                Opsi (untuk select/checkbox/radio, pisahkan dengan koma)
              </label>
              <input
                type="text"
                name="options"
                value={form.options}
                onChange={handleChange}
                className="w-full border px-3 py-2 rounded"
              />
            </div>

            <div className="flex items-center">
              <input
                type="checkbox"
                name="active"
                checked={form.active}
                onChange={handleChange}
                className="mr-2"
              />
              <label className="text-gray-700 font-medium">Aktif</label>
            </div>

            <div className="pt-3">
              <button type="submit" className="btn btn-primary mt-4">
                Simpan
              </button>
            </div>
          </form>
        </div>
      </div>
    </DashboardLayout>
  );
};

export default InputForm;
