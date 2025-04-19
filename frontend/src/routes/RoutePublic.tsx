import { Navigate } from "react-router-dom";
import { getToken } from "../functions/auth";

interface RoutePublicProps {
  children: JSX.Element;
}

export function RoutePublic({ children }: RoutePublicProps) {
  const isAuthenticated = !!getToken();

  if (isAuthenticated) {
    return <Navigate to="/admin" replace />;
  }

  return children;
}
