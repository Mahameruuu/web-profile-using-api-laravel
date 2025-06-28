import React, { useState, useEffect } from 'react';
import { Link, useLocation } from 'react-router-dom';
import logoDark from '../assets/img/logo-ct-dark.png';
import logo from '../assets/img/logo-ct.png';
import '@fortawesome/fontawesome-free/css/all.min.css';

const Sidebar = () => {
  const location = useLocation();
  const [isOpen, setIsOpen] = useState(true);
  const [isMobile, setIsMobile] = useState(window.innerWidth < 1280);

  const isActive = (path) => location.pathname === path;

  const menuClass = (path) =>
    `py-2.7 text-sm ease-nav-brand my-0 mx-2 flex items-center whitespace-nowrap rounded-lg px-4 font-semibold transition-colors duration-200 ${
      isActive(path)
        ? 'bg-blue-500/13 text-slate-700 dark:text-white dark:opacity-80'
        : 'text-slate-700 hover:bg-gray-100 dark:text-white dark:opacity-80'
    }`;

  const iconClass = (color) => `relative top-0 text-sm leading-normal ${color} ni`;

  const handleClose = () => {
    if (isMobile) setIsOpen(false);
  };

  const handleOpen = () => {
    if (isMobile) setIsOpen(true);
  };

  const handleResize = () => {
    const mobile = window.innerWidth < 1280;
    setIsMobile(mobile);
    if (!mobile) setIsOpen(true);
  };

  useEffect(() => {
    window.addEventListener('resize', handleResize);
    handleResize();
    return () => window.removeEventListener('resize', handleResize);
  }, []);

  return (
    <>
      {/* Open Button */}
      {isMobile && !isOpen && (
        <button
          onClick={handleOpen}
          className="fixed top-4 left-4 z-50 p-2"
        >
          <i className="fas fa-bars text-slate-700"></i>
        </button>
      )}

      <aside
        className={`fixed inset-y-0 flex-wrap items-center justify-between block w-full p-0 my-4 overflow-y-auto antialiased transition-transform duration-200 bg-white border-0 shadow-xl dark:shadow-none dark:bg-slate-850 max-w-64 ease-nav-brand z-990 xl:ml-6 rounded-2xl ${
          isOpen ? 'translate-x-0 xl:left-0' : '-translate-x-full'
        }`}
      >
        <div className="h-19 relative">
          <i
            className="absolute top-0 right-0 p-4 opacity-50 cursor-pointer fas fa-times dark:text-white text-slate-400 xl:hidden"
            onClick={handleClose}
          ></i>
          <Link className="block px-8 py-6 m-0 text-sm whitespace-nowrap dark:text-white text-slate-700" to="/">
            <img
              src={logoDark}
              className="inline h-full max-w-full transition-all duration-200 dark:hidden ease-nav-brand max-h-8"
              alt="main_logo"
            />
            <img
              src={logo}
              className="hidden h-full max-w-full transition-all duration-200 dark:inline ease-nav-brand max-h-8"
              alt="main_logo"
            />
            <span className="ml-1 font-semibold transition-all duration-200 ease-nav-brand">
              Argon Dashboard 2
            </span>
          </Link>
        </div>

        <hr className="h-px mt-0 bg-transparent bg-gradient-to-r from-transparent via-black/40 to-transparent dark:via-white" />

        <div className="items-center block w-auto max-h-screen overflow-auto h-sidenav grow basis-full">
          <ul className="flex flex-col pl-0 mb-0">
            <li className="mt-0.5 w-full">
              <Link to="/dashboard" className={menuClass('/dashboard')}>
                <div className="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center text-center xl:p-2.5">
                  <i className={iconClass('text-blue-500 ni-tv-2')}></i>
                </div>
                <span className="ml-1 duration-300 opacity-100 pointer-events-none ease">Dashboard</span>
              </Link>
            </li>

            <li className="mt-0.5 w-full">
              <Link to="/users" className={menuClass('/users')}>
                <div className="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center text-center xl:p-2.5">
                  <i className={iconClass('text-cyan-500 ni-single-02')}></i>
                </div>
                <span className="ml-1 duration-300 opacity-100 pointer-events-none ease">Users</span>
              </Link>
            </li>

            <li className="mt-0.5 w-full">
              <Link to="/kegiatan" className={menuClass('/kegiatan')}>
                <div className="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center text-center xl:p-2.5">
                  <i className={iconClass('text-orange-500 ni ni-calendar-grid-58')}></i>
                </div>
                <span className="ml-1 duration-300 opacity-100 pointer-events-none ease">Kegiatan</span>
              </Link>
            </li>

            <li className="mt-0.5 w-full">
              <Link to="/inputs" className={menuClass('/inputs')}>
                <div className="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center text-center xl:p-2.5">
                  <i className={iconClass('text-orange-500 ni ni-settings')}></i>
                </div>
                <span className="ml-1 duration-300 opacity-100 pointer-events-none ease">Manajemen Input</span>
              </Link>
            </li>

            {/* ✅ Menu Baru: Surat Cuti */}
            <li className="mt-0.5 w-full">
              <Link to="/cuti" className={menuClass('/cuti')}>
                <div className="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center text-center xl:p-2.5">
                  <i className={iconClass('text-red-500 ni ni-archive-2')}></i>
                </div>
                <span className="ml-1 duration-300 opacity-100 pointer-events-none ease">Surat Cuti</span>
              </Link>
            </li>
          </ul>
        </div>
      </aside>
    </>
  );
};

export default Sidebar;
