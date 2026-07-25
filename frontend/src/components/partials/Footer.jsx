import React from 'react';
import { Link } from 'react-router-dom';
import '../../styles/footer.css';
import '../../styles/whatsapp-button.css';

const Footer = () => {
  return (
    <footer className="main-footer">
      <div className="pattern-layer">
        <div className="pattern-1" style={{ backgroundImage: "url(assets/images/shape/shape-12.png)" }}></div>
        <div className="pattern-2" style={{ backgroundImage: "url(assets/images/shape/shape-13.png)" }}></div>
        <div className="pattern-3" style={{ backgroundImage: "url(assets/images/shape/shape-14.png)" }}></div>
      </div>
      <div className="auto-container">
        <div className="footer-top clearfix">
          <div className="line-shape" style={{ backgroundImage: "url(assets/images/shape/shape-11.png)" }}></div>
          <div className="text pull-left">
            <h2>Hubungi Kami <span> Untuk Mendapatkan </span> <br />Layanan Pelanggan Ulaqua</h2>
          </div>
          <div className="support-box pull-right">
            <a href="https://wa.me/6282119425191" className="wa-btn" target="_blank" rel="noreferrer">
              <i className="fab fa-whatsapp"></i>Hubungi Kami
            </a>
          </div>
        </div>
        <div className="widget-section">
          <div className="row clearfix">
            <div className="col-lg-3 col-md-6 col-sm-12 footer-column">
              <div className="footer-widget logo-widget">
                <figure className="footer-logo">
                  <Link to="/">
                    <img src="assets/images/logo-2.png" alt="Acuasafe" />
                  </Link>
                </figure>
                <div className="text">
                  <p>Solusi air murni untuk keluarga dan bisnis Anda.</p>
                </div>
                <div className="schedule-box">
                  <h6>Waktu Operasional:</h6>
                  <ul className="list clearfix">
                    <li>Senin - Sabtu: 9.00 WIB - 6.00 WIB</li>
                    <li>Minggu: Tutup</li>
                  </ul>
                </div>
              </div>
            </div>
            <div className="col-lg-3 col-md-6 col-sm-12 footer-column">
              <div className="footer-widget contact-widget ml-70">
                <div className="widget-title">
                  <h4>Informasi</h4>
                </div>
                <div className="widget-content">
                  <ul className="info-list clearfix">
                    <li><i className="fal fa-map-marker-alt"></i>Kp. Leles RT/RW 003/011 Ds. Mekarsari Kec. Ciparay Kab. Bandung</li>
                    <li><i className="fal fa-phone"></i>Call Us: <a href="tel:082119425191">0821-194-25191</a></li>
                    <li><i className="fal fa-envelope-open-text"></i><a href="mailto:cvululalbabhidroprima@gmail.com">cvululalbabhidroprima@gmail.com</a></li>
                  </ul>
                </div>
              </div>
            </div>
            <div className="col-lg-3 col-md-6 col-sm-12 footer-column">
              <div className="footer-widget links-widget ml-70">
                <div className="widget-title">
                  <h4>Link Terkait</h4>
                </div>
                <div className="widget-content">
                  <ul className="links-list clearfix">
                    <li><Link to="/about">Tentang Kami</Link></li>
                    <li><Link to="/services">Layanan</Link></li>
                    <li><Link to="/contact">Hubungi Kami</Link></li>
                    <li><Link to="/">Testimoni</Link></li>
                  </ul>
                </div>
              </div>
            </div>
            <div className="col-lg-3 col-md-6 col-sm-12 footer-column">
              <div className="footer-widget subscribe-widget">
                <div className="widget-title">
                  <h4>Sosial Media</h4>
                </div>
                <div className="widget-content">
                  <div className="social-links">
                    <h6>Temukan Kami di:</h6>
                    <ul className="clearfix">
                      <li><a href="#"><i className="fab fa-facebook-f"></i></a></li>
                      <li><a href="#"><i className="fab fa-twitter"></i></a></li>
                      <li><a href="#"><i className="fab fa-instagram"></i></a></li>
                      <li><a href="#"><i className="fab fa-linkedin-in"></i></a></li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div className="footer-bottom centred">
          <div className="auto-container">
            <div className="copyright">
              <p>&copy; 2026 Ulaqua. All rights reserved.</p>
            </div>
          </div>
        </div>
      </div>
    </footer>
  );
};

export default Footer;
