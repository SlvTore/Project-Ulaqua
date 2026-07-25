import React, { useState } from 'react';
import { MapContainer, TileLayer, Marker, Popup } from 'react-leaflet';
import 'leaflet/dist/leaflet.css';
import L from 'leaflet';

const markerIcon = new L.Icon({
  iconUrl: 'assets/images/icons/map-marker.png',
  iconSize: [40, 40],
  iconAnchor: [20, 40],
  popupAnchor: [0, -36]
});

const Contact = () => {
  const [formData, setFormData] = useState({
    name: '',
    email: '',
    phone: '',
    subject: '',
    message: ''
  });

  const handleChange = (e) => setFormData({ ...formData, [e.target.name]: e.target.value });

  const handleSubmit = (e) => {
    e.preventDefault();
    console.log('Form submitted:', formData);
    alert('Terima kasih atas pesan Anda! Kami akan segera menghubungi Anda kembali.');
    setFormData({ name: '', email: '', phone: '', subject: '', message: '' });
  };

  const branches = [
    { id: 1, name: 'Pondok Pesantren Ulul Albab', position: [-6.927832, 107.618177], address: 'Bandung, Jawa Barat, Indonesia' }
  ];

  return (
    <>
      {/* Judul Halaman */}
      <section className="page-title centred" style={{ backgroundImage: 'url(assets/images/background/page-title.jpg)' }}>
        <div className="shape" style={{ backgroundImage: 'url(assets/images/shape/banner-shap.png)' }}></div>
        <div className="auto-container">
          <div className="content-box">
            <h1>Hubungi Kami</h1>
            <ul className="bread-crumb clearfix">
              <li><a href="/">Beranda</a></li>
              <li>Kontak</li>
            </ul>
          </div>
        </div>
      </section>

      {/* Bagian Kontak */}
      <section className="contact-style-two sec-pad">
        <div className="auto-container">
          <div className="row clearfix">
            <div className="col-lg-5 col-md-12 col-sm-12 info-column">
              <div className="info-inner">
                <div className="shape" style={{ backgroundImage: 'url(assets/images/shape/shape-42.png)' }}></div>
                <h3>Informasi Kontak</h3>
                <ul className="info-list clearfix">
                  <li>
                    <i className="fas fa-map-marker-alt"></i>
                    <h5>Lokasi Kantor</h5>
                    <p>Jl. 12 No. 629, Modesto, CA <br />95354, Amerika Serikat</p>
                  </li>
                  <li>
                    <i className="fas fa-envelope-open"></i>
                    <h5>Email Kami</h5>
                    <p><a href="mailto:info@example.com">info@example.com</a><br /><a href="mailto:information@gmail.com">information@gmail.com</a></p>
                  </li>
                  <li>
                    <i className="fas fa-phone"></i>
                    <h5>Hubungi Kami</h5>
                    <p><a href="tel:11165458856">+(111) 65_458_856</a><br /><a href="tel:11165458857">+(111) 65_458_857</a></p>
                  </li>
                </ul>
              </div>
            </div>
            <div className="col-lg-7 col-md-12 col-sm-12 form-column">
              <div className="form-inner">
                <h3>Tinggalkan Pesan Anda</h3>
                <form onSubmit={handleSubmit} className="default-form"> 
                  <div className="row clearfix">
                    <div className="col-lg-6 col-md-6 col-sm-12 form-group">
                      <input type="text" name="name" placeholder="Nama Lengkap Anda" required value={formData.name} onChange={handleChange} />
                    </div>
                    <div className="col-lg-6 col-md-6 col-sm-12 form-group">
                      <input type="email" name="email" placeholder="Alamat Email" required value={formData.email} onChange={handleChange} />
                    </div>
                    <div className="col-lg-6 col-md-12 col-sm-12 form-group">
                      <input type="text" name="phone" placeholder="Nomor Telepon" value={formData.phone} onChange={handleChange} />
                    </div>
                    <div className="col-lg-6 col-md-12 col-sm-12 form-group">
                      <input type="text" name="subject" placeholder="Subjek" value={formData.subject} onChange={handleChange} />
                    </div>
                    <div className="col-lg-12 col-md-12 col-sm-12 form-group">
                      <textarea name="message" placeholder="Tulis Pesan Anda Di Sini" rows="6" value={formData.message} onChange={handleChange}></textarea>
                    </div>
                    <div className="col-lg-12 col-md-12 col-sm-12 form-group message-btn">
                      <button type="submit" className="theme-btn btn-one">Kirim Sekarang</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </section>

      {/* Bagian Peta */}
      <section className="google-map-section">
        <div className="auto-container">
          <div className="map-inner">
            <MapContainer center={[-6.927832, 107.618177]} zoom={12} style={{ height: '450px', width: '100%', borderRadius: '12px', overflow: 'hidden' }} scrollWheelZoom={false}>
              <TileLayer url="https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png" attribution="&copy; OpenStreetMap contributors" />
              {branches.map(b => (
                <Marker key={b.id} position={b.position} icon={markerIcon}>
                  <Popup>
                    <strong>{b.name}</strong><br />{b.address}
                  </Popup>
                </Marker>
              ))}
            </MapContainer>
          </div>
        </div>
      </section>
    </>
  );
};

export default Contact;
