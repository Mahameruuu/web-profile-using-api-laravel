import React, { useEffect, useState } from 'react';
import { Link } from 'react-router-dom';
import api from '../../api';
import DashboardLayout from '../../components/DashboardLayout'; 

function UserIndex() {
  const [users, setUsers] = useState([]);

  const getUsers = async () => {
    const res = await api.get('/users');
    setUsers(res.data);
  };

  const deleteUser = async (id) => {
    if (window.confirm('Yakin ingin menghapus user ini?')) {
      await api.delete(`/users/${id}`);
      getUsers();
    }
  };

  useEffect(() => {
    getUsers();
  }, []);

  return (
    <DashboardLayout title="Manajemen User">
      <div className="p-6 max-w-6xl mx-auto">
        <div className="flex justify-between items-center mb-4">
          <h2 className="text-2xl font-bold text-gray-800">Daftar Users</h2>
          <div>
            <Link to="/users/add" className="btn btn-primary me-2">Tambah User</Link>
            <Link to="/users/import" className="btn btn-secondary">Import Excel</Link>
          </div>
        </div>

        <div className="overflow-x-auto bg-white rounded shadow">
          <table className="table table-bordered table-striped w-full">
            <thead className="bg-gray-100">
              <tr>
                <th className="px-4 py-2">Nama</th>
                <th className="px-4 py-2">Email</th>
                <th className="px-4 py-2">Role</th>
                <th className="px-4 py-2">Aksi</th>
              </tr>
            </thead>
            <tbody>
              {users.map((u) => (
                <tr key={u.id}>
                  <td className="px-4 py-2">{u.name}</td>
                  <td className="px-4 py-2">{u.email}</td>
                  <td className="px-4 py-2">{u.role}</td>
                  <td className="px-4 py-2">
                    <Link to={`/users/edit/${u.id}`} className="btn btn-sm btn-warning me-2">Edit</Link>
                    <button className="btn btn-sm btn-danger" onClick={() => deleteUser(u.id)}>Hapus</button>
                  </td>
                </tr>
              ))}
              {users.length === 0 && (
                <tr>
                  <td colSpan="4" className="text-center text-gray-500 py-4">Tidak ada data user.</td>
                </tr>
              )}
            </tbody>
          </table>
        </div>
      </div>
    </DashboardLayout>
  );
}

export default UserIndex;
