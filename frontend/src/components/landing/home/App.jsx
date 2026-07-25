import React from 'react';
import { BrowserRouter as Router, Routes, Route } from 'react-router-dom';
import Layout from '../../layout/Layout';
import Home from '../../../pages/Home';
import About from '../../../pages/About';
import Services from '../../../pages/Services';
import ServiceDetails from '../../../pages/ServiceDetails';
import Contact from '../../../pages/Contact';
import '../../../styles/home.css';

function App() {
  return (
    <Router>
      <Routes>
        <Route path="/" element={<Layout />}>
          <Route index element={<Home />} />
          <Route path="about" element={<About />} />
          <Route path="services" element={<Services />} />
          <Route path="service/:serviceId" element={<ServiceDetails />} />
          <Route path="contact" element={<Contact />} />
          <Route path="*" element={<div>404 Page Not Found</div>} />
        </Route>
      </Routes>
    </Router>
  );
}

export default App;
