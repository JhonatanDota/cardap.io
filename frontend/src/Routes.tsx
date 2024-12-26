import { Route, Routes as RouterDomRoutes } from "react-router-dom";

import Home from "./pages/home/Home";
import Login from "./pages/authentication/login/Login";
import Cardapio from "./pages/client/cardapio/Cardapio";

export default function Routes() {
  return (
    <RouterDomRoutes>
      <Route path="/" element={<Home />} />
      <Route path="/login" element={<Login />} />

      <Route path="menus/:slug" element={<Cardapio />} />
    </RouterDomRoutes>
  );
}
