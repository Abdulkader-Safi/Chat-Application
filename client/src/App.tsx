import React from 'react'
import axios from "axios";

axios.defaults.baseURL = import.meta.env.VITE_API_BASE_URL;
axios.defaults.headers.post["Content-Type"] = "application/json";
axios.defaults.headers.post["Accept"] = "application/json";

axios.defaults.withCredentials = true;

// axios.interceptors.request.use((config) => {
//   const token = localStorage.getItem("auth_token");
//   config.headers.Authorization = token ? `Bearer ${token}` : "";
//   return config;
// });

const App = () => {

  return (
    <div className=''>
      <h1 className="text-3xl font-bold underline">
        Hello world!
      </h1>
    </div>
  )

}
export default App