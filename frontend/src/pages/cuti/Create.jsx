import React, { useState } from 'react';
import { useNavigate } from 'react-router-dom';
import api from '../../api';

const CutiForm = () => {
  const navigate = useNavigate();
  const [loading, setLoading] = useState(false);
  const [errors, setErrors] = useState({});

  const [form, setForm] = useState({
    nama: '',
    nip: '',
    pangkat: '',
    jabatan: '',
    departemen: '',
    sub_departemen: '',
    tanggal_mulai: '',
    tanggal_akhir: '',
    alamat: '',
  });

  const handleChange = (e) => {
    setForm({
      ...form,
      [e.target.name]: e.target.value,
    });
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    setLoading(true);
    setErrors({});

    try {
      const res = await api.post('/cutis', form);
      alert('Data cuti berhasil disimpan!');
      navigate('/cuti');
    } catch (err) {
      console.error(err);
      if (err.response?.data?.errors) {
        setErrors(err.response.data.errors);
      } else if (err.response?.data?.error) {
        alert("Gagal simpan cuti: " + err.response.data.error);
      } else {
        alert('Terjadi kesalahan saat menyimpan data.');
      }
    } finally {
      setLoading(false);
    }
  };

  const renderError = (field) =>
    errors[field] && <div className="text-danger small">{errors[field][0]}</div>;

  return (
    <div className="container mt-4">
      <h4>Tambah Surat Cuti</h4>
      <form onSubmit={handleSubmit}>
        <div className="row">
          {[ // Kolom teks
            { name: 'nama', label: 'Nama', required: true },
            { name: 'nip', label: 'NIP', required: true },
            { name: 'pangkat', label: 'Pangkat / Golongan' },
            { name: 'jabatan', label: 'Jabatan' },
            { name: 'departemen', label: 'Departemen' },
            { name: 'sub_departemen', label: 'Sub Departemen' },
          ].map((field) => (
            <div key={field.name} className="mb-3 col-md-6">
              <label>{field.label}</label>
              <input
                type="text"
                name={field.name}
                className="form-control"
                value={form[field.name]}
                onChange={handleChange}
                required={field.required}
              />
              {renderError(field.name)}
            </div>
          ))}

          <div className="mb-3 col-md-6">
            <label>Tanggal Mulai</label>
            <input
              type="date"
              name="tanggal_mulai"
              className="form-control"
              value={form.tanggal_mulai}
              onChange={handleChange}
              required
            />
            {renderError('tanggal_mulai')}
          </div>

          <div className="mb-3 col-md-6">
            <label>Tanggal Akhir</label>
            <input
              type="date"
              name="tanggal_akhir"
              className="form-control"
              value={form.tanggal_akhir}
              onChange={handleChange}
              required
            />
            {renderError('tanggal_akhir')}
          </div>

          <div className="mb-3 col-md-12">
            <label>Alamat Selama Cuti</label>
            <textarea
              name="alamat"
              className="form-control"
              rows="2"
              value={form.alamat}
              onChange={handleChange}
            />
            {renderError('alamat')}
          </div>
        </div>

        <button type="submit" className="btn btn-success" disabled={loading}>
          {loading ? 'Menyimpan...' : 'Simpan'}
        </button>
        <button type="button" className="btn btn-secondary ms-2" onClick={() => navigate('/cuti')}>
          Batal
        </button>
      </form>
    </div>
  );
};

export default CutiForm;
