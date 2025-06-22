import React, { useState, useEffect } from 'react';
import { useNavigate, useParams } from 'react-router-dom';
import api from '../../api'; 

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
    <div className="p-6">
      <h2 className="text-xl font-bold mb-4">{id ? 'Edit Kegiatan' : 'Tambah Kegiatan'}</h2>

      {error && <div className="bg-red-100 text-red-600 p-2 mb-4 rounded">{error}</div>}

      <form onSubmit={handleSubmit} encType="multipart/form-data">
        <div className="mb-4">
          <label className="block mb-1">Judul</label>
          <input
            type="text"
            className="border rounded w-full p-2"
            value={judul}
            onChange={(e) => setJudul(e.target.value)}
            required
          />
        </div>

        <div className="mb-4">
          <label className="block mb-1">Deskripsi</label>
          <textarea
            className="border rounded w-full p-2"
            value={deskripsi}
            onChange={(e) => setDeskripsi(e.target.value)}
            required
          />
        </div>

        <div className="mb-4">
          <label className="block mb-1">Gambar</label>
          <input
            type="file"
            onChange={(e) => setGambar(e.target.files[0])}
            className="border rounded w-full p-2"
            accept="image/*"
          />
        </div>

        <button type="submit" className="bg-blue-600 text-white px-4 py-2 rounded">
          {id ? 'Update' : 'Simpan'}
        </button>
      </form>
    </div>
  );
};

export default Form;
