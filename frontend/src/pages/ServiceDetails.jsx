import React from 'react';
import { useParams, Link } from 'react-router-dom';
import { SERVICES } from '../data/services';
import '../styles/service-details.css';

const ServiceDetails = () => {
  const { serviceId } = useParams();
  const data = SERVICES[serviceId];

  if (!data) {
    return (
      <section className="service-details sec-pad centred">
        <div className="auto-container">
          <h2>Layanan Tidak Ditemukan</h2>
          <p>Layanan yang Anda cari tidak tersedia.</p>
          <Link to="/services" className="theme-btn btn-one">Kembali ke Layanan</Link>
        </div>
      </section>
    );
  }

  const primarySection = data.sections?.[0];
  const secondarySection = data.sections?.[1];

  return (
    <>
      {/* Page Title */}
      <section className="page-title centred" style={{ backgroundImage: 'url(assets/images/background/page-title.jpg)' }}>
        <div className="shape" style={{ backgroundImage: 'url(assets/images/shape/banner-shap.png)' }}></div>
        <div className="auto-container">
          <div className="content-box">
            <h1>{data.title}</h1>
            <ul className="bread-crumb clearfix">
              <li><Link to="/">Beranda</Link></li>
              <li><Link to="/services">Layanan</Link></li>
              <li>{data.title}</li>
            </ul>
          </div>
        </div>
      </section>
    <section className="service-details sec-pad">
      <div className="auto-container">
        <div className="row clearfix">
          <div className="col-lg-8 col-md-12 col-sm-12 content-side">
            <div className="service-details-content">
              <div className="content-one">
                <div className="text">
                  <h2>{data.title}</h2>
                  <p>{data.short}</p>
                </div>
                <figure className="image-box"><img src={data.heroImage} alt={data.title} /></figure>
              </div>

              {primarySection && (
                <div className="content-two">
                  <div className="text">
                    <h3>{primarySection.heading}</h3>
                    <p>{primarySection.text}</p>
                  </div>

                  {data.features?.length > 0 && (
                    <div className="inner-box">
                      {data.features.map(f => (
                        <div key={f.title} className="single-item">
                          <div className="icon-box"><i className="flaticon-draw-check-mark"></i></div>
                          <div className="feature-content">
                            <h4>{f.title}</h4>
                            <p>{f.desc}</p>
                          </div>
                        </div>
                      ))}
                    </div>
                  )}
                </div>
              )}

              {secondarySection && (
                <div className="content-three">
                  <div className="text">
                    <h3>{secondarySection.heading}</h3>
                    <p>{secondarySection.text}</p>
                    <p>Pendekatan kami membantu menjaga performa sistem tetap optimal, hemat biaya operasional, dan andal untuk kebutuhan air bersih jangka panjang.</p>
                  </div>
                </div>
              )}

              {data.images && data.images.length > 0 && (
                <div className="content-gallery">
                  <div className="image-box">
                    <div className="row clearfix">
                      {data.images.map((img, idx) => (
                        <div key={idx} className="col-lg-6 col-md-6 col-sm-12 image-column">
                          <figure className="image"><img src={img} alt={`${data.title} ${idx + 1}`} /></figure>
                        </div>
                      ))}
                    </div>
                  </div>
                  <div className="text">
                    <h3>Implementasi Profesional</h3>
                    <p>Tim ahli kami memastikan proses instalasi berjalan rapi, aman, dan sesuai kebutuhan. Kami juga menyediakan pendampingan penggunaan serta perawatan berkala agar performa sistem tetap maksimal.</p>
                    <p>Setiap proyek dilengkapi dokumentasi teknis, garansi layanan, dan dukungan cepat tanggap agar Anda merasa tenang dalam penggunaan jangka panjang.</p>
                  </div>
                </div>
              )}
            </div>
          </div>
          <div className="col-lg-4 col-md-12 col-sm-12 sidebar-side">
            <div className="service-sidebar">
              <div className="category-widget">
                <h3>Layanan Kami</h3>
                <ul className="category-list clearfix">
                  {Object.values(SERVICES).map(s => (
                    <li key={s.id}>
                      <Link to={`/service/${s.id}`} className={s.id === data.id ? 'current' : ''}>
                        <i className="fas fa-caret-right"></i>{s.title}
                      </Link>
                    </li>
                  ))}
                </ul>
              </div>
              <div className="support-box">
                <div className="inner-box">
                  <div className="icon-box"><i className="fas fa-phone"></i></div>
                  <h4>Butuh Bantuan?</h4>
                  <p>Hubungi tim kami untuk konsultasi solusi dan penawaran terbaik.</p>
                  <div className="phone-number">
                    <a href="tel:+6282119425191">+62 821-1942-5191</a>
                  </div>
                  <Link to="/contact" className="theme-btn btn-one">Hubungi Kami</Link>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    </>
  );
};

export default ServiceDetails;
