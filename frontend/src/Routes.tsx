import { Route, Routes as RouterDomRoutes } from "react-router-dom";

import Home from "./pages/home/Home";
import Login from "./pages/authentication/login/Login";

export default function Routes() {
  return (
    <RouterDomRoutes>
      <Route path="/" element={<Home />} />
      <Route path="/login" element={<Login />} />
    </RouterDomRoutes>
  );
}
