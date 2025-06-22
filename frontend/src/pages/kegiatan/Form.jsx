import React, { useState, useEffect } from 'react';
import { useNavigate, useParams } from 'react-router-dom';
import axios from 'axios';

const Form = () => {
  const [judul, setJudul] = useState('');
  const [deskripsi, setDeskripsi] = useState('');
  const [gambar, setGambar] = useState(null);
  const { id } = useParams();
  const navigate = useNavigate();

  useEffect(() => {
    if (id) {
      axios.get(`http://localhost:8000/api/kegiatan/${id}`).then((res) => {
        setJudul(res.data.judul);
        setDeskripsi(res.data.deskripsi);
      });
    }
  }, [id]);

  const handleSubmit = async (e) => {
    e.preventDefault();
    const formData = new FormData();
    formData.append('judul', judul);
    formData.append('deskripsi', deskripsi);
    if (gambar) formData.append('gambar', gambar);

    if (id) {
      await axios.post(`http://localhost:8000/api/kegiatan/${id}?_method=PUT`, formData);
    } else {
      await axios.post('http://localhost:8000/api/kegiatan', formData);
    }
    navigate('/kegiatan');
  };

  return (
    <div className="p-6">
      <h2 className="text-xl font-bold mb-4">{id ? 'Edit Kegiatan' : 'Tambah Kegiatan'}</h2>
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