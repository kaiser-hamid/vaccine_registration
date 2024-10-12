import { createBrowserRouter } from "react-router-dom";
import App from "./src/App";
import Home from "./src/components/pages/Home";
import Registration from "./src/components/pages/Registration";
import Search from "./src/components/pages/Search";

export default createBrowserRouter([
  {
    path: "/",
    element: <App />,
    children: [
      {
        index: true,
        element: <Home />,
      },
      {
        path: "/search",
        element: <Search />,
      },
      {
        path: "/registration",
        element: <Registration />,
      },
    ],
  },
]);
