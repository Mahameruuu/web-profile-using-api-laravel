import React, { useState } from 'react';
import { useNavigate } from 'react-router-dom';
import api from '../../api';

function UserImport() {
  const [file, setFile] = useState(null);
  const navigate = useNavigate();

  const handleSubmit = async (e) => {
    e.preventDefault();
    if (!file) return alert('Pilih file terlebih dahulu');

    const formData = new FormData();
    formData.append('file', file);

    try {
      await api.post('/users/import', formData, {
        headers: {
          'Content-Type': 'multipart/form-data',
        },
      });
      alert('Data berhasil diimport');
      navigate('/users');
    } catch (error) {
      alert('Gagal import, periksa format file');
    }
  };

  return (
    <div className="container mt-4">
      <h2>Import User dari Excel</h2>
      <form onSubmit={handleSubmit}>
        <div className="mb-3">
          <input type="file" accept=".xls,.xlsx" onChange={(e) => setFile(e.target.files[0])} className="form-control" required />
        </div>
        <button className="btn btn-primary">Upload</button>
      </form>
    </div>
  );
}

export default UserImport;
