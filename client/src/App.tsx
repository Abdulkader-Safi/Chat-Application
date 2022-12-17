import React from 'react'
import axios from "axios";
import { Navbar } from './Components';
import { Route, Routes, Navigate } from 'react-router-dom';
import { Home, Login, Register } from './Pages';

axios.defaults.baseURL = import.meta.env.VITE_API_BASE_URL || "http://localhost:8000/";
axios.defaults.headers.post["Content-Type"] = "application/json";
axios.defaults.headers.post["Accept"] = "application/json";

axios.defaults.withCredentials = false;
axios.interceptors.request.use((config: any) => {
  const token = localStorage.getItem("auth_token");
  config.headers.Authorization = token ? `Bearer ${token}` : "";
  return config;
});

const App = () => {

  return (
    <div>
      <Navbar />
      <Routes>
        <Route path='/' element={<Home />} />
        <Route path='/home' element={<Home />} />

        <Route
          path='/login'
          element={
            localStorage.getItem("auth_token") ? (
              <Navigate to="/" replace />
            ) : (
              <Login />
            )
          }
        />

        <Route
          path='/register'
          element={
            localStorage.getItem("auth_token") ? (
              <Navigate to="/" replace />
            ) : (
              <Register />
            )
          }
        />

      </Routes>
    </div>
  )
}

export default App