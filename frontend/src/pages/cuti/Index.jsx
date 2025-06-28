import React, { useEffect, useState } from 'react';
import { Link } from 'react-router-dom';
import api from '../../api';

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
    <div className="container mt-4">
      <div className="d-flex justify-content-between align-items-center mb-3">
        <h4>Data Surat Cuti</h4>
        <Link to="/cuti/create" className="btn btn-primary">+ Tambah Cuti</Link>
      </div>

      {loading ? (
        <div>Memuat data...</div>
      ) : (
        <table className="table table-bordered table-striped">
          <thead className="table-dark">
            <tr>
              <th>No</th>
              <th>Nama</th>
              <th>NIP</th>
              <th>Tgl Mulai</th>
              <th>Tgl Akhir</th>
              <th>Jumlah</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            {cutis.length > 0 ? (
              cutis.map((cuti, index) => (
                <tr key={cuti.id}>
                  <td>{index + 1}</td>
                  <td>{cuti.nama}</td>
                  <td>{cuti.nip}</td>
                  <td>{cuti.tanggal_mulai}</td>
                  <td>{cuti.tanggal_akhir}</td>
                  <td>{cuti.jumlah_hari} hari</td>
                  <td>
                    <span className={`badge bg-${
                      cuti.status === 'Disetujui' ? 'success' :
                      cuti.status === 'Ditolak' ? 'danger' : 'warning'
                    }`}>
                      {cuti.status}
                    </span>
                  </td>
                  <td>
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
                      <span className="text-muted">Tidak ada file</span>
                    )}

                    {/* Tombol Hapus (aktifkan jika kamu admin) */}
                    <button
                      onClick={() => handleDelete(cuti.id)}
                      className="btn btn-sm btn-danger ms-1"
                    >
                      🗑 Hapus
                    </button>
                  </td>
                </tr>
              ))
            ) : (
              <tr>
                <td colSpan="8" className="text-center">Tidak ada data</td>
              </tr>
            )}
          </tbody>
        </table>
      )}
    </div>
  );
};

export default CutiIndex;
