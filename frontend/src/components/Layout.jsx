import React from 'react';
import 'bootstrap/dist/css/bootstrap.min.css';

function Layout({ children, title = 'Aplikasi' }) {
  document.title = title;

  return (
    <div className="container mt-5">
      {children}
    </div>
  );
}

export default Layout;
