import { Navigate } from "react-router-dom";

import { getToken } from "../functions/auth";

interface RouteGuardProps {
  children: JSX.Element;
}

export function RouteGuard({ children }: RouteGuardProps) {
  const isAuthenticated = !!getToken();

  if (!isAuthenticated) {
    return <Navigate to="/login" />;
  }

  return children;
}
