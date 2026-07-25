import React from 'react';
import { Outlet } from 'react-router-dom';
import Navbar from '../partials/Navbar.jsx';  // Add .jsx extension
import Footer from '../partials/Footer.jsx';  // Add .jsx extension

const Layout = () => {
  return (
    <div className="boxed_wrapper">
      {/* Preloader - Commented out for now */}
      {/* 
      <div className="loader-wrap">
        <div className="preloader">
          <div className="preloader-close">Preloader Close</div>
          <div id="handle-preloader" className="handle-preloader">
            <div className="animation-preloader">
              <div className="spinner"></div>
              <div className="txt-loading">
                <span data-text-preloader="a" className="letters-loading">a</span>
                <span data-text-preloader="c" className="letters-loading">c</span>
                <span data-text-preloader="u" className="letters-loading">u</span>
                <span data-text-preloader="a" className="letters-loading">a</span>
                <span data-text-preloader="s" className="letters-loading">s</span>
                <span data-text-preloader="a" className="letters-loading">a</span>
                <span data-text-preloader="f" className="letters-loading">f</span>
                <span data-text-preloader="e" className="letters-loading">e</span>
              </div>
            </div>
          </div>
        </div>
      </div>
      */}

      <Navbar />
      
      <main>
        <Outlet />
      </main>

      <Footer />
    </div>
  );
};

export default Layout;
