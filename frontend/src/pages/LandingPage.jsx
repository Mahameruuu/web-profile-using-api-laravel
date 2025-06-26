import React, { useEffect, useState } from 'react';
import api from '../api';

const LandingPage = () => {
  const [kegiatan, setKegiatan] = useState([]);

  const fetchKegiatan = async () => {
    try {
      const res = await api.get('/kegiatan');
      setKegiatan(res.data);
    } catch (err) {
      console.error('Gagal memuat kegiatan:', err);
    }
  };

  useEffect(() => {
    fetchKegiatan();
  }, []);

  return (
    <div className="min-h-screen bg-gray-100 py-10 px-4">
      <div className="max-w-5xl mx-auto">
        <h1 className="text-3xl font-bold text-center text-gray-800 mb-10">Informasi Kegiatan</h1>

        <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
          {kegiatan.length > 0 ? (
            kegiatan.map((item) => (
              <div key={item.id} className="bg-white shadow rounded-lg overflow-hidden">
                {item.gambar ? (
                  <img
                    src={`http://localhost:8000/storage/${item.gambar}`}
                    alt={item.judul}
                    className="w-full h-40 object-cover"
                    onError={(e) => {
                      if (!e.target.src.includes('no-image.png')) {
                        e.target.onerror = null;
                        e.target.src = '/no-image.png';
                      }
                    }}
                  />
                ) : (
                  <div className="w-full h-40 bg-gray-200 flex items-center justify-center text-gray-500 text-sm italic">
                    Tidak ada gambar
                  </div>
                )}
                <div className="p-4">
                  <h3 className="text-lg font-semibold text-gray-700">{item.judul}</h3>
                  <p className="text-sm text-gray-600 mt-1">{item.deskripsi}</p>
                </div>
              </div>
            ))
          ) : (
            <p className="text-center text-gray-500 col-span-full">Tidak ada kegiatan yang tersedia.</p>
          )}
        </div>
      </div>
    </div>
  );
};

export default LandingPage;
