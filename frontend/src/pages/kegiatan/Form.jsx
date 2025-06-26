import React, { useState, useEffect } from 'react';
import { useNavigate, useParams } from 'react-router-dom';
import api from '../../api';
import DashboardLayout from '../../components/DashboardLayout';

const Form = () => {
  const [judul, setJudul] = useState('');
  const [deskripsi, setDeskripsi] = useState('');
  const [gambar, setGambar] = useState(null);
  const [error, setError] = useState(null);
  const { id } = useParams();
  const navigate = useNavigate();

  useEffect(() => {
    if (id) {
      api.get(`/kegiatan/${id}`)
        .then((res) => {
          setJudul(res.data.judul);
          setDeskripsi(res.data.deskripsi);
        })
        .catch((err) => {
          setError('Gagal memuat data kegiatan.');
          console.error(err);
        });
    }
  }, [id]);

  const handleSubmit = async (e) => {
    e.preventDefault();
    setError(null);

    const formData = new FormData();
    formData.append('judul', judul);
    formData.append('deskripsi', deskripsi);
    if (gambar) formData.append('gambar', gambar);

    try {
      if (id) {
        await api.post(`/kegiatan/${id}?_method=PUT`, formData, {
          headers: { 'Content-Type': 'multipart/form-data' },
        });
      } else {
        await api.post('/kegiatan', formData, {
          headers: { 'Content-Type': 'multipart/form-data' },
        });
      }
      navigate('/kegiatan');
    } catch (err) {
      console.error(err);
      if (err.response?.status === 401 || err.response?.status === 403) {
        setError('Akses ditolak. Pastikan Anda sudah login sebagai admin.');
      } else {
        setError('Terjadi kesalahan saat menyimpan data.');
      }
    }
  };

  return (
    <DashboardLayout title={id ? 'Edit Kegiatan' : 'Tambah Kegiatan'}>
      <div className="p-6 max-w-3xl mx-auto">
        <div className="bg-white shadow rounded p-6">
          <h2 className="text-2xl font-semibold text-gray-800 mb-4">
            {id ? 'Edit Kegiatan' : 'Tambah Kegiatan'}
          </h2>

          {error && (
            <div className="bg-red-100 text-red-700 border border-red-300 p-3 rounded mb-4">
              {error}
            </div>
          )}

          <form onSubmit={handleSubmit} encType="multipart/form-data" className="space-y-5">
            <div>
              <label className="block mb-1 font-medium text-gray-700">Judul</label>
              <input
                type="text"
                className="w-full border px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                value={judul}
                onChange={(e) => setJudul(e.target.value)}
                required
              />
            </div>

            <div>
              <label className="block mb-1 font-medium text-gray-700">Deskripsi</label>
              <textarea
                className="w-full border px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                value={deskripsi}
                onChange={(e) => setDeskripsi(e.target.value)}
                rows="4"
                required
              />
            </div>

            <div>
              <label className="block mb-1 font-medium text-gray-700">Gambar</label>
              <input
                type="file"
                onChange={(e) => setGambar(e.target.files[0])}
                className="w-full border px-3 py-2 rounded file:bg-gray-100 file:border-none file:px-3 file:py-1"
                accept="image/*"
              />
            </div>

            <div className="mt-6">
              <button type="submit" className="btn mt-4 btn-success">
                {id ? 'Update' : 'Simpan'}
              </button>
            </div>
          </form>
        </div>
      </div>
    </DashboardLayout>
  );
};

export default Form;
