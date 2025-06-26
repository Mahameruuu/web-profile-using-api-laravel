import React, { useState } from 'react';
import { useNavigate } from 'react-router-dom';
import api from '../../api';
import DashboardLayout from '../../components/DashboardLayout'; 

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
    <DashboardLayout title="Import User">
      <div className="p-6 max-w-xl mx-auto">
        <div className="bg-white shadow rounded p-6">
          <h2 className="text-2xl font-semibold text-gray-800 mb-4">Import User dari Excel</h2>

          <form onSubmit={handleSubmit} className="space-y-4">
            <div>
              <input
                type="file"
                accept=".xls,.xlsx"
                onChange={(e) => setFile(e.target.files[0])}
                className="w-full border px-3 py-2 rounded file:bg-gray-100 file:border-none file:px-3 file:py-1"
                required
              />
            </div>
            <div>
              <button className="btn mt-4 btn-primary">
                Upload
              </button>
            </div>
          </form>
        </div>
      </div>
    </DashboardLayout>
  );
}

export default UserImport;
