import { Route, Routes as RouterDomRoutes } from "react-router-dom";

import Home from "./pages/home/Home";
import Login from "./pages/authentication/login/Login";
import Cardapio from "./pages/client/Cardapio";

export default function Routes() {
  return (
    <RouterDomRoutes>
      <Route path="/" element={<Home />} />
      <Route path="/login" element={<Login />} />

      <Route path="cardapios/:slug" element={<Cardapio />} />
    </RouterDomRoutes>
  );
}
