import React from 'react';
import ServiceSection from '../components/elements/ServiceSection';
import CTASection from '../components/elements/CTA';
import { SERVICES_LIST } from '../data/services';
import '../styles/service-section.css';

const Services = () => {
  const allServices = SERVICES_LIST;

  return (
    <>
      {/* Judul Halaman */}
      <section className="page-title centred" style={{ backgroundImage: "url(assets/images/background/page-title.jpg)" }}>
        <div className="shape" style={{ backgroundImage: "url(assets/images/shape/banner-shap.png)" }}></div>
        <div className="auto-container">
          <div className="content-box">
            <h1 className='mt-5'>Layanan Kami</h1>
            <ul className="bread-crumb clearfix">
              <li><a href="/">Beranda</a></li>
              <li>Layanan</li>
            </ul>
          </div>
        </div>
      </section>

      {/* Bagian Layanan */}
      <ServiceSection 
        services={allServices}
        sectionClass="service-page-section centred"
        sectionTitle="Lindungi Keluarga Anda dengan Sistem <br />Penyaringan Air Terbaik dan Terpercaya"
        blockClass="service-block-two"
      />

      {/* Bagian Proses */}
      <section className="process-section sec-pad bg-color-1">
        <div className="auto-container">
          <div className="sec-title centred">
            <span className="top-title">Proses Kami</span>
            <h2>Bagaimana Kami Bekerja</h2>
          </div>
          <div className="row clearfix">
            <div className="col-lg-3 col-md-6 col-sm-12 process-block">
              <div className="process-block-one">
                <div className="inner-box">
                  <div className="count-box">
                    <span>01</span>
                  </div>
                  <h4>Analisis Air</h4>
                  <p>Kami memulai dengan analisis menyeluruh untuk mengidentifikasi kontaminan dan masalah kualitas air Anda.</p>
                </div>
              </div>
            </div>
            <div className="col-lg-3 col-md-6 col-sm-12 process-block">
              <div className="process-block-one">
                <div className="inner-box">
                  <div className="count-box">
                    <span>02</span>
                  </div>
                  <h4>Solusi Khusus</h4>
                  <p>Berdasarkan analisis, kami merancang solusi pengolahan air yang disesuaikan dengan kebutuhan spesifik Anda.</p>
                </div>
              </div>
            </div>
            <div className="col-lg-3 col-md-6 col-sm-12 process-block">
              <div className="process-block-one">
                <div className="inner-box">
                  <div className="count-box">
                    <span>03</span>
                  </div>
                  <h4>Pemasangan Profesional</h4>
                  <p>Teknisi bersertifikat kami memasang sistem Anda dengan presisi dan memastikan performa optimal.</p>
                </div>
              </div>
            </div>
            <div className="col-lg-3 col-md-6 col-sm-12 process-block">
              <div className="process-block-one">
                <div className="inner-box">
                  <div className="count-box">
                    <span>04</span>
                  </div>
                  <h4>Dukungan Berkelanjutan</h4>
                  <p>Kami memberikan pemeliharaan dan dukungan berkelanjutan agar sistem Anda selalu berjalan efisien.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      {/* Bagian Ajakan Aksi */}
      <CTASection 
        title="Butuh Solusi Air yang Tepat?"
        description="Setiap tantangan air adalah unik. Biarkan ahli kami merancang solusi sempurna sesuai kebutuhan dan anggaran Anda."
        features={["Konsultasi Gratis", "Desain Khusus", "Pemasangan Profesional"]}
        buttonText="Hubungi Kami"
        buttonLink="/contact"
      />
    </>
  );
};

export default Services;
