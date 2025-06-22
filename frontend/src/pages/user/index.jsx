import React, { useEffect, useState } from 'react';
import { Link } from 'react-router-dom';
import api from '../../api';

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
    <div className="container mt-4">
      <h2>Daftar Users</h2>
      <Link to="/users/add" className="btn btn-primary me-2">Tambah User</Link>
      <Link to="/users/import" className="btn btn-secondary">Import Excel</Link>

      <table className="table table-bordered table-striped mt-3">
        <thead>
          <tr>
            <th>Nama</th>
            <th>Email</th>
            <th>Role</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          {users.map((u) => (
            <tr key={u.id}>
              <td>{u.name}</td>
              <td>{u.email}</td>
              <td>{u.role}</td>
              <td>
                <Link to={`/users/edit/${u.id}`} className="btn btn-sm btn-warning me-2">Edit</Link>
                <button className="btn btn-sm btn-danger" onClick={() => deleteUser(u.id)}>Hapus</button>
              </td>
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  );
}

export default UserIndex;
