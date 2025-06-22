import React, { useEffect, useState } from 'react';
import { Link } from 'react-router-dom';
import axios from 'axios';

const Index = () => {
  const [kegiatan, setKegiatan] = useState([]);

  const fetchData = async () => {
    try {
      const res = await axios.get('http://localhost:8000/api/kegiatan');
      setKegiatan(res.data);
    } catch (error) {
      console.error('Gagal memuat data kegiatan', error);
    }
  };

  const handleDelete = async (id) => {
    if (window.confirm('Yakin ingin menghapus kegiatan ini?')) {
      await axios.delete(`http://localhost:8000/api/kegiatan/${id}`);
      fetchData();
    }
  };

  useEffect(() => {
    fetchData();
  }, []);

  return (
    <div className="p-6">
      <div className="flex justify-between items-center mb-4">
        <h2 className="text-xl font-bold">Daftar Kegiatan</h2>
        <Link to="/kegiatan/create" className="bg-blue-500 text-white px-4 py-2 rounded">+ Tambah</Link>
      </div>

      <table className="w-full border text-sm">
        <thead>
          <tr className="bg-gray-100 text-left">
            <th className="p-2 border">No</th>
            <th className="p-2 border">Judul</th>
            <th className="p-2 border">Deskripsi</th>
            <th className="p-2 border">Gambar</th>
            <th className="p-2 border">Aksi</th>
          </tr>
        </thead>
        <tbody>
          {kegiatan.map((item, index) => (
            <tr key={item.id} className="border-b">
              <td className="p-2 border">{index + 1}</td>
              <td className="p-2 border">{item.judul}</td>
              <td className="p-2 border">{item.deskripsi}</td>
              <td className="p-2 border">
                {item.gambar && (
                  <img
                    src={`http://localhost:8000/storage/public/${item.gambar}`}
                    alt={item.judul}
                    className="w-16 h-16 object-cover"
                  />
                )}
              </td>
              <td className="p-2 border space-x-2">
                <Link to={`/kegiatan/edit/${item.id}`} className="text-blue-600">Edit</Link>
                <button onClick={() => handleDelete(item.id)} className="text-red-600">Hapus</button>
              </td>
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  );
};

export default Index;