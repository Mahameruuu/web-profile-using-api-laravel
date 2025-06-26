import React, { useEffect, useState } from 'react';
import DashboardLayout from '../components/DashboardLayout';
import api from '../api';

function Dashboard() {
  const [summary, setSummary] = useState({
    users: 0,
    kegiatan: 0,
    fitur: 0,
    user_items: [],
    kegiatan_items: [],
    fitur_items: [],
  });

  const [bulanIni, setBulanIni] = useState('');
  const [baruBulanIni, setBaruBulanIni] = useState({
    users: 0,
    kegiatan: 0,
    fitur: 0,
  });

  useEffect(() => {
    const fetchSummary = async () => {
      try {
        const response = await api.get('/dashboard-summary');
        const data = response.data;

        const now = new Date();
        const bulan = now.toLocaleString('default', { month: 'long' });
        const tahun = now.getFullYear();
        setBulanIni(`${bulan} ${tahun}`);

        const isThisMonth = (dateStr) => {
          const date = new Date(dateStr);
          return date.getMonth() === now.getMonth() && date.getFullYear() === now.getFullYear();
        };

        setBaruBulanIni({
          users: data.user_items.filter(item => isThisMonth(item.created_at)).length,
          kegiatan: data.kegiatan_items.filter(item => isThisMonth(item.created_at)).length,
          fitur: data.fitur_items.filter(item => isThisMonth(item.created_at)).length,
        });

        setSummary(data);
      } catch (error) {
        console.error('Gagal fetch summary:', error);
      }
    };

    fetchSummary();
  }, []);

  return (
    <DashboardLayout title="Dashboard Admin">
      <h2 className="mb-4 fw-bold text-dark">Selamat Datang, Admin!</h2>

      <div className="row">
        {/* Card: Jumlah User */}
        <div className="col-xl-3 col-sm-6 mb-4">
          <div className="card shadow border-0">
            <div className="card-body">
              <p className="text-uppercase text-muted mb-1">Jumlah User</p>
              <h5>{summary.users.toLocaleString()}</h5>
              <p className="mb-0 text-success">
                +{baruBulanIni.users} <small>ditambahkan {bulanIni}</small>
              </p>
            </div>
          </div>
        </div>

        {/* Card: Jumlah Kegiatan */}
        <div className="col-xl-3 col-sm-6 mb-4">
          <div className="card shadow border-0">
            <div className="card-body">
              <p className="text-uppercase text-muted mb-1">Jumlah Kegiatan</p>
              <h5>{summary.kegiatan}</h5>
              <p className="mb-0 text-primary">
                +{baruBulanIni.kegiatan} <small>ditambahkan {bulanIni}</small>
              </p>
            </div>
          </div>
        </div>

        {/* Card: Jumlah Fitur */}
        <div className="col-xl-3 col-sm-6 mb-4">
          <div className="card shadow border-0">
            <div className="card-body">
              <p className="text-uppercase text-muted mb-1">Jumlah Fitur</p>
              <h5>{summary.fitur}</h5>
              <p className="mb-0 text-warning">
                +{baruBulanIni.fitur} <small>ditambahkan {bulanIni}</small>
              </p>
            </div>
          </div>
        </div>

        {/* Card kosong */}
        <div className="col-xl-3 col-sm-6 mb-4">
          <div className="card shadow border-0">
            <div className="card-body">
              <p className="text-uppercase text-muted mb-1">Informasi Lain</p>
              <h5>Coming Soon</h5>
              <p className="mb-0 text-muted"><small>Sedang disiapkan</small></p>
            </div>
          </div>
        </div>
      </div>
    </DashboardLayout>
  );
}

export default Dashboard;
