import React, { useState, useEffect, useRef } from 'react';
import { useNavigate } from 'react-router-dom';

const Navbar = () => {
  const [user, setUser] = useState(null);
  const [showMenu, setShowMenu] = useState(false);
  const dropdownRef = useRef();
  const navigate = useNavigate();

  // Ambil user dari localStorage
  useEffect(() => {
    const stored = localStorage.getItem('user');
    if (stored) {
      setUser(JSON.parse(stored));
    }
  }, []);

  // Deteksi klik di luar dropdown
  useEffect(() => {
    const handleClickOutside = (e) => {
      if (dropdownRef.current && !dropdownRef.current.contains(e.target)) {
        setShowMenu(false);
      }
    };
    document.addEventListener('mousedown', handleClickOutside);
    return () => document.removeEventListener('mousedown', handleClickOutside);
  }, []);

  const handleLogout = () => {
    localStorage.removeItem('token');
    localStorage.removeItem('user');
    navigate('/login');
  };

  const handleChangePassword = () => {
    navigate('/change-password');
  };

  return (
    <nav className="relative flex flex-wrap items-center justify-between px-0 py-2 mx-6 transition-all ease-in duration-250 shadow-none rounded-2xl lg:flex-nowrap lg:justify-start bg-blue-600">
      <div className="flex items-center justify-between w-full px-4 py-1 mx-auto flex-wrap-inherit">
        
        {/* Breadcrumb + Judul */}
        <div>
          <ol className="flex flex-wrap pt-1 mr-12 text-sm text-white opacity-70">
            <li>Pages</li>
            <li className="pl-2 before:content-['/'] before:pr-2 text-white">Dashboard</li>
          </ol>
          <h6 className="mb-0 font-bold text-white capitalize">Dashboard</h6>
        </div>

        {/* Profil dan Dropdown */}
        <div className="relative" ref={dropdownRef}>
          <button
            className="flex items-center text-white gap-2 focus:outline-none transition duration-200 hover:opacity-90"
            onClick={() => setShowMenu(!showMenu)}
          >
            <i className="fa fa-user text-lg"></i>
            {user && <span className="text-sm font-medium">{user.name}</span>}
          </button>

          {/* Smooth Dropdown */}
          <div
            className={`absolute right-0 mt-2 w-44 bg-white text-gray-700 rounded-xl shadow-xl py-2 text-sm z-50 transition-all duration-200 origin-top-right transform ${
              showMenu ? 'opacity-100 scale-100' : 'opacity-0 scale-95 pointer-events-none'
            }`}
          >
            <button
              onClick={handleChangePassword}
              className="block w-full text-left px-4 py-2 hover:bg-gray-100 rounded-t-xl"
            >
              Ganti Password
            </button>
            <button
              onClick={handleLogout}
              className="block w-full text-left px-4 py-2 hover:bg-gray-100 rounded-b-xl"
            >
              Logout
            </button>
          </div>
        </div>
      </div>
    </nav>
  );
};

export default Navbar;
