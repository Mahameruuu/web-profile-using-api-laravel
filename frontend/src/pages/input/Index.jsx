import React, { useEffect, useState } from 'react';
import axios from 'axios';
import DashboardLayout from '../../components/DashboardLayout';

const InputIndex = () => {
  const [inputs, setInputs] = useState([]);

  const fetchInputs = async () => {
    const token = localStorage.getItem('token');
    const res = await axios.get('http://localhost:8000/api/inputs', {
      headers: { Authorization: `Bearer ${token}` },
    });
    setInputs(res.data);
  };

  const toggleActive = async (input) => {
    const token = localStorage.getItem('token');
    await axios.put(
      `http://localhost:8000/api/inputs/${input.id}`,
      { active: !input.active },
      { headers: { Authorization: `Bearer ${token}` } }
    );
    fetchInputs();
  };

  useEffect(() => {
    fetchInputs();
  }, []);

  return (
    <DashboardLayout title="Manajemen Input">
      <div className="p-6 max-w-6xl mx-auto">
        <div className="flex justify-between items-center mb-4">
          <h2 className="text-2xl font-bold text-gray-800">Manajemen Input</h2>
          <a
            href="/inputs/create"
            className="btn btn-primary"
          >
            + Tambah Input
          </a>
        </div>

        <div className="overflow-x-auto bg-white rounded shadow">
          <table className="w-full table-auto text-sm">
            <thead className="bg-gray-100 text-gray-600 uppercase text-xs">
              <tr>
                <th className="px-4 py-3 text-left whitespace-nowrap">Label</th>
                <th className="px-4 py-3 text-left whitespace-nowrap">Name</th>
                <th className="px-4 py-3 text-left whitespace-nowrap">Type</th>
                <th className="px-4 py-3 text-left whitespace-nowrap">Status</th>
                <th className="px-4 py-3 text-left whitespace-nowrap">Aksi</th>
              </tr>
            </thead>
            <tbody className="divide-y divide-gray-100">
              {inputs.map((item) => (
                <tr key={item.id} className="hover:bg-gray-50">
                  <td className="px-4 py-2">{item.label}</td>
                  <td className="px-4 py-2">{item.name}</td>
                  <td className="px-4 py-2">{item.type}</td>
                  <td className="px-4 py-2">
                    <span
                      className={`px-2 py-1 text-xs rounded font-medium ${
                        item.active
                          ? 'bg-green-100 text-green-700'
                          : 'bg-yellow-100 text-yellow-700'
                      }`}
                    >
                      {item.active ? 'Aktif' : 'Non-Aktif'}
                    </span>
                  </td>
                  <td className="px-4 py-2">
                    <button
                      onClick={() => toggleActive(item)}
                      className={`btn btn-sm ${
                        item.active ? 'btn-danger' : 'btn-success'
                      }`}
                    >
                      {item.active ? 'Nonaktifkan' : 'Aktifkan'}
                    </button>
                  </td>
                </tr>
              ))}
              {inputs.length === 0 && (
                <tr>
                  <td colSpan="5" className="text-center py-6 text-gray-500">
                    Tidak ada data input.
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

export default InputIndex;
