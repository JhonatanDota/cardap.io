import { Route, Routes as RouterDomRoutes } from "react-router-dom";

import Home from "./pages/home/Home";

export default function Routes() {
  return (
    <RouterDomRoutes>
      <Route path="/" element={<Home />} />
    </RouterDomRoutes>
  );
}
