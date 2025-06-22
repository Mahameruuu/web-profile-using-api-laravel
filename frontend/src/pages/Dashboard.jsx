import React from 'react';
import DashboardLayout from '../components/DashboardLayout';

function Dashboard() {
  return (
    <DashboardLayout title="Dashboard Admin">
      <h2 className="mb-4 fw-bold text-dark">Selamat Datang, Admin!</h2>

      <div className="row">
        {/* Card 1 */}
        <div className="col-xl-3 col-sm-6 mb-4">
          <div className="card shadow border-0">
            <div className="card-body">
              <p className="text-uppercase text-muted mb-1">Today's Money</p>
              <h5>$53,000</h5>
              <p className="mb-0 text-success">+55% <small>since yesterday</small></p>
            </div>
          </div>
        </div>

        {/* Card 2 */}
        <div className="col-xl-3 col-sm-6 mb-4">
          <div className="card shadow border-0">
            <div className="card-body">
              <p className="text-uppercase text-muted mb-1">Today's Users</p>
              <h5>2,300</h5>
              <p className="mb-0 text-success">+3% <small>since last week</small></p>
            </div>
          </div>
        </div>

        {/* Card 3 */}
        <div className="col-xl-3 col-sm-6 mb-4">
          <div className="card shadow border-0">
            <div className="card-body">
              <p className="text-uppercase text-muted mb-1">New Clients</p>
              <h5>3,462</h5>
              <p className="mb-0 text-danger">-2% <small>since last quarter</small></p>
            </div>
          </div>
        </div>

        {/* Card 4 */}
        <div className="col-xl-3 col-sm-6 mb-4">
          <div className="card shadow border-0">
            <div className="card-body">
              <p className="text-uppercase text-muted mb-1">Sales</p>
              <h5>$103,430</h5>
              <p className="mb-0 text-success">+5% <small>than last month</small></p>
            </div>
          </div>
        </div>
      </div>
    </DashboardLayout>
  );
}

export default Dashboard;
