import React from 'react';
import { Link, useLocation } from 'react-router-dom';
import logoDark from '../assets/img/logo-ct-dark.png';
import logo from '../assets/img/logo-ct.png';
import '@fortawesome/fontawesome-free/css/all.min.css';

const Sidebar = () => {
  const location = useLocation();
  const isActive = (path) => location.pathname === path;

  const menuClass = (path) =>
    `flex items-center gap-2 px-6 py-3 my-1 rounded-lg transition-all duration-200 ${
      isActive(path)
        ? 'bg-gradient-to-tr from-blue-200 to-blue-400 text-black font-semibold'
        : 'text-black hover:bg-slate-100'
    }`;

  return (
    <aside className="fixed inset-y-0 flex-wrap items-center justify-between block w-full p-0 my-4 overflow-y-auto antialiased transition-transform duration-200 bg-white shadow-xl max-w-64 ease-nav-brand z-990 xl:ml-6 rounded-2xl translate-x-0">
      <div className="h-19">
        <button className="block px-8 py-6 m-0 text-sm whitespace-nowrap text-black cursor-pointer">
          <img src={logoDark} className="inline dark:hidden max-h-8" alt="logo dark" />
          <img src={logo} className="hidden dark:inline max-h-8" alt="logo" />
          <span className="ml-1 font-semibold">Argon Dashboard 2</span>
        </button>
      </div>

      <div className="px-6 mt-4">
        <nav>
          <ul>
            <li>
              <Link to="/dashboard" className={menuClass('/dashboard')}>
                <i className="fas fa-home w-5 text-sm"></i> <span>Dashboard</span>
              </Link>
            </li>
            <li>
              <Link to="/users" className={menuClass('/users')}>
                <i className="fas fa-users w-5 text-sm"></i> <span>User</span>
              </Link>
            </li>
            <li>
              <Link to="/kegiatan" className={menuClass('/kegiatan')}>
                <i className="fas fa-calendar w-5 text-sm"></i> <span>Kegiatan</span>
              </Link>
            </li>
          </ul>
        </nav>
      </div>
    </aside>
  );
};

export default Sidebar;
