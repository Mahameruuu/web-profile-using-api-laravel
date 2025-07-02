import React, { useEffect, useState } from 'react';
import { Link } from 'react-router-dom';
import api from '../../api';
import DashboardLayout from '../../components/DashboardLayout';

const CutiIndex = () => {
  const [cutis, setCutis] = useState([]);
  const [loading, setLoading] = useState(true);

  const fetchCutis = async () => {
    try {
      const response = await api.get('/cutis');
      setCutis(response.data);
    } catch (error) {
      console.error('Gagal mengambil data cuti:', error);
      alert('Gagal mengambil data. Silakan coba lagi.');
    } finally {
      setLoading(false);
    }
  };

  const handleDelete = async (id) => {
    if (!window.confirm('Yakin ingin menghapus data ini?')) return;

    try {
      await api.delete(`/cutis/${id}`);
      setCutis((prev) => prev.filter((item) => item.id !== id));
    } catch (error) {
      console.error('Gagal menghapus:', error);
      alert('Gagal menghapus data.');
    }
  };

  useEffect(() => {
    fetchCutis();
  }, []);

  return (
    <DashboardLayout title="Data Surat Cuti">
      <div className="p-6 max-w-6xl mx-auto">
        <div className="flex justify-between items-center mb-4">
          <h2 className="text-2xl font-bold text-gray-800">Manajemen Surat Cuti</h2>
          <Link
            to="/cuti/create"
            className="btn btn-primary"
          >
            + Tambah Cuti
          </Link>
        </div>

        <div className="overflow-x-auto bg-white rounded shadow">
          {loading ? (
            <div className="p-4 text-center text-gray-500">Memuat data...</div>
          ) : (
            <table className="w-full table-auto text-sm">
              <thead className="bg-gray-100 text-gray-600 uppercase text-xs">
                <tr>
                  <th className="px-4 py-3 text-left">No</th>
                  <th className="px-4 py-3 text-left">Nama</th>
                  <th className="px-4 py-3 text-left">NIP</th>
                  <th className="px-4 py-3 text-left">Tgl Mulai</th>
                  <th className="px-4 py-3 text-left">Tgl Akhir</th>
                  <th className="px-4 py-3 text-left">Jumlah</th>
                  <th className="px-4 py-3 text-left">Status</th>
                  <th className="px-4 py-3 text-left">Aksi</th>
                </tr>
              </thead>
              <tbody className="divide-y divide-gray-100">
                {cutis.length > 0 ? (
                  cutis.map((cuti, index) => (
                    <tr key={cuti.id} className="hover:bg-gray-50">
                      <td className="px-4 py-2">{index + 1}</td>
                      <td className="px-4 py-2">{cuti.nama}</td>
                      <td className="px-4 py-2">{cuti.nip}</td>
                      <td className="px-4 py-2">{cuti.tanggal_mulai}</td>
                      <td className="px-4 py-2">{cuti.tanggal_akhir}</td>
                      <td className="px-4 py-2">{cuti.jumlah_hari} hari</td>
                      <td className="px-4 py-2">
                        <span className={`px-2 py-1 text-xs rounded font-medium ${
                          cuti.status === 'Disetujui'
                            ? 'bg-green-100 text-green-700'
                            : cuti.status === 'Ditolak'
                            ? 'bg-red-100 text-red-700'
                            : 'bg-yellow-100 text-yellow-700'
                        }`}>
                          {cuti.status}
                        </span>
                      </td>
                      <td className="px-4 py-2 space-x-1">
                        {cuti.file_pdf ? (
                          <a
                            href={`http://localhost:8000/storage/surat_cuti/${cuti.file_pdf}`}
                            target="_blank"
                            rel="noreferrer"
                            className="btn btn-sm btn-success"
                          >
                            📄 PDF
                          </a>
                        ) : (
                          <span className="text-muted text-xs">Tidak ada file</span>
                        )}
                        <button
                          onClick={() => handleDelete(cuti.id)}
                          className="btn btn-sm btn-danger"
                        >
                          🗑 Hapus
                        </button>
                      </td>
                    </tr>
                  ))
                ) : (
                  <tr>
                    <td colSpan="8" className="text-center py-6 text-gray-500">
                      Tidak ada data cuti.
                    </td>
                  </tr>
                )}
              </tbody>
            </table>
          )}
        </div>
      </div>
    </DashboardLayout>
  );
};

export default CutiIndex;
