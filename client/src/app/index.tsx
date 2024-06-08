import * as React from 'react';
import '@coreui/coreui/dist/css/coreui.min.css';
import { Routes, BrowserRouter, Route } from 'react-router-dom';
import '../styles/scss/style.scss';
import { Dashboard } from './containers/Dashboard/Loadable';
import SetPassword from './containers/Security/SetPassword';
import Login from './containers/Security/Login';

export function App() {
  return (
    <BrowserRouter>
      <Routes>
        <Route path="/" element={<Dashboard />} />
        <Route path="/set-password" element={<SetPassword />} />
        <Route path="/login" element={<Login />} />
      </Routes>
    </BrowserRouter>
  );
}
