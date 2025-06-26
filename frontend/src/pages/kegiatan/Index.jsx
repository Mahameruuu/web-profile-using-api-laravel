import React, { useEffect, useState } from 'react';
import { Link } from 'react-router-dom';
import api from '../../api';
import DashboardLayout from '../../components/DashboardLayout';

const Index = () => {
  const [kegiatan, setKegiatan] = useState([]);

  const fetchData = async () => {
    try {
      const res = await api.get('/kegiatan');
      setKegiatan(res.data);
    } catch (error) {
      console.error('Gagal memuat data kegiatan', error);
    }
  };

  const handleDelete = async (id) => {
    if (window.confirm('Yakin ingin menghapus kegiatan ini?')) {
      try {
        await api.delete(`/kegiatan/${id}`);
        fetchData();
      } catch (error) {
        console.error('Gagal menghapus', error);
      }
    }
  };

  useEffect(() => {
    fetchData();
  }, []);

  return (
    <DashboardLayout title="Manajemen Kegiatan">
      <div className="p-6">
        <div className="flex justify-between items-center mb-6">
          <h2 className="text-2xl font-bold text-gray-800">Daftar Kegiatan</h2>
          <Link
            to="/kegiatan/create"
            className="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow"
          >
            + Tambah
          </Link>
        </div>

        <div className="overflow-x-auto bg-white rounded-lg shadow">
          <table className="min-w-full divide-y divide-gray-200 text-sm">
            <thead className="bg-gray-100 text-gray-600 uppercase text-xs">
              <tr>
                <th className="px-4 py-3 text-left">No</th>
                <th className="px-4 py-3 text-left">Judul</th>
                <th className="px-4 py-3 text-left">Deskripsi</th>
                <th className="px-4 py-3 text-left">Gambar</th>
                <th className="px-4 py-3 text-left">Aksi</th>
              </tr>
            </thead>
            <tbody className="divide-y divide-gray-200">
              {kegiatan.length > 0 ? (
                kegiatan.map((item, index) => (
                  <tr key={item.id} className="hover:bg-gray-50">
                    <td className="px-4 py-3">{index + 1}</td>
                    <td className="px-4 py-3">{item.judul}</td>
                    <td className="px-4 py-3">{item.deskripsi}</td>
                    <td className="px-4 py-3">
                      {item.gambar ? (
                        <img
                          src={`http://localhost:8000/storage/${item.gambar}`}
                          alt={item.judul}
                          className="w-16 h-16 object-cover rounded border"
                          onError={(e) => {
                            if (!e.target.src.includes('no-image.png')) {
                              e.target.onerror = null;
                              e.target.src = '/no-image.png';
                            }
                          }}
                        />
                      ) : (
                        <span className="text-gray-500 italic text-xs">Tidak ada gambar</span>
                      )}
                    </td>
                    <td className="px-4 py-3">
                      <Link
                        to={`/kegiatan/edit/${item.id}`}
                        className="btn btn-sm btn-warning me-2"
                      >
                        Edit
                      </Link>
                      <button
                        onClick={() => handleDelete(item.id)}
                        className="btn btn-sm btn-danger"
                      >
                        Hapus
                      </button>
                    </td>
                  </tr>
                ))
              ) : (
                <tr>
                  <td colSpan="5" className="text-center py-6 text-gray-500">
                    Belum ada data kegiatan.
                  </td>
                </tr>
              )}
            </tbody>
          </table>
        </div>
      </div>
    </DashboardLayout>
  );
};

export default Index;
