import React, { useEffect } from 'react';
import Sidebar from './Sidebar';
import Navbar from './Navbar';

import '../assets/css/argon-dashboard-tailwind.css';
import '../assets/css/nucleo-icons.css';
import '../assets/css/nucleo-svg.css';
import '@fortawesome/fontawesome-free/css/all.min.css';

function DashboardLayout({ children, title = 'Dashboard' }) {
  useEffect(() => {
    document.title = title;

    const loadScript = (src) => {
      const script = document.createElement('script');
      script.src = src;
      script.async = true;
      document.body.appendChild(script);
    };

    loadScript('/assets/js/plugins/chartjs.min.js');
    loadScript('/assets/js/plugins/perfect-scrollbar.min.js');
    loadScript('/assets/js/argon-dashboard-tailwind.js');
  }, [title]);

  return (
    <div className="m-0 font-sans text-base antialiased font-normal dark:bg-slate-900 leading-default bg-gray-50 text-slate-500">
      <div className="absolute w-full bg-blue-500 dark:hidden min-h-75"></div>
      <Sidebar />
      <main className="relative h-full max-h-screen transition-all duration-200 ease-in-out xl:ml-68 rounded-xl">
        <Navbar />
        <div className="w-full px-6 py-6 mx-auto">
          {children}
        </div>
      </main>
    </div>
  );
}

export default DashboardLayout;
