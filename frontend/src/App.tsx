import { BrowserRouter } from "react-router-dom";
import Routes from "./Routes";
import { Toaster } from "react-hot-toast";

function App() {
  return (
    <>
      <BrowserRouter>
        <Routes />
      </BrowserRouter>
      <Toaster />
    </>
  );
}

export default App;
