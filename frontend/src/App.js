import React from "react";
import { BrowserRouter as Router, Route, Routes } from "react-router-dom";
import Home from "./pages/Home";

function App() { // Rutas de la aplicación
  return (
    <Router>
      <Routes>
        <Route path="/" element={<Home />} /> {/* Ruta principal */}
      </Routes>
    </Router>
  );
}

export default App;


