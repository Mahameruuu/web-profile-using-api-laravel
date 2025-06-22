// src/components/Navbar.jsx
import React from 'react';

const Navbar = () => {
  return (
    <nav className="relative flex flex-wrap items-center justify-between px-0 py-2 mx-6 transition-all ease-in shadow-none duration-250 rounded-2xl lg:flex-nowrap lg:justify-start">
      <div className="flex items-center justify-between w-full px-4 py-1 mx-auto flex-wrap-inherit">
        <h6 className="mb-0 font-bold text-white capitalize">Dashboard</h6>
      </div>
    </nav>
  );
};

export default Navbar;
