import { Route, Routes as RouterDomRoutes } from "react-router-dom";

import Home from "./pages/home/Home";
import Login from "./pages/authentication/login/Login";

import AdminLayout from "./pages/admin/layout/AdminLayout";
import AdminHome from "./pages/admin/home/AdminHome";
import AdminCompany from "./pages/admin/company/AdminCompany";
import AdminCardapio from "./pages/admin/cardapio/AdminCardapio";
import AdminMetrics from "./pages/admin/metrics/AdminMetrics";

import Cardapio from "./pages/client/cardapio/Cardapio";

export default function Routes() {
  return (
    <RouterDomRoutes>
      <Route path="/" element={<Home />} />
      <Route path="/login" element={<Login />} />

      <Route path="/admin" element={<AdminLayout />}>
        <Route index element={<AdminHome />} />
        <Route path="company" element={<AdminCompany />} />
        <Route path="menu" element={<AdminCardapio />} />
        <Route path="metrics" element={<AdminMetrics />} />
      </Route>

      <Route path="/menus/:slug" element={<Cardapio />} />
    </RouterDomRoutes>
  );
}
