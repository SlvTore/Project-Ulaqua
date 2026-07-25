import React from 'react';
import AboutSection from '../components/elements/AboutSection';
import TeamSection from '../components/elements/TeamSection';
import ChooseUsSection from '../components/elements/ChooseUsSection';
import CTASection from '../components/elements/CTA';
import '../styles/team-section.css';
import '../styles/chooseus-section.css';

const About = () => {
  return (
    <>
      {/* Page Title */}
      <section className="page-title centred" style={{ backgroundImage: "url(assets/images/background/page-title.jpg)" }}>
        <div className="shape" style={{ backgroundImage: "url(assets/images/shape/banner-shap.png)" }}></div>
        <div className="auto-container">
          <div className="content-box" style={{ marginTop: '100px' }}>
            <h1 style={{ color: '#103d67' }}>Tentang Kami</h1>
            <ul className="bread-crumb clearfix">
              <li><a href="/" style={{ color: '#103d67'}}>Beranda</a></li>
              <li style={{ color: '#47e7f6' }}>Tentang Kami</li>
            </ul>
          </div>
        </div>
      </section>

      {/* About Section */}
      <AboutSection 
        title="Penyedia Solusi Air Terdepan Sejak 2025"
        description1="Ulul Albab Hidro Prima adalah perusahaan yang bergerak di bidang Air Mineral Dalam Kemasan (AMDK) dengan merek dagang UlaQua."
        description2="Berdiri sejak tahun 2025, kami hadir untuk memberikan solusi air minum yang berkualitas, aman, dan terpercaya bagi masyarakat Indonesia. Selain menyediakan produk terbaik, kami juga berkomitmen aktif dalam mendukung program kesehatan dan pendidikan anak-anak Indonesia."
        buttonText="Layanan Kami"
        buttonLink="/services"
        imageSrc="assets/images/resource/about-1.png"
        imageAlt="Solusi Air UlaQua"
        sectionClass="about-section sec-pad"
      />

      {/* Team Section */}
      <TeamSection 
        title="Jajaran Staff Ulaqua"
        subtitle="Tim Profesional Kami"
        teamMembers={[
          {
            id: 1,
            name: "Dai Wiralikrama S.",
            designation: "Direktur Utama",
            image: "assets/images/team/team-1.jpg",
            socialLinks: [
              { platform: "facebook", url: "/", icon: "fab fa-facebook-f" },
              { platform: "twitter", url: "/", icon: "fab fa-twitter" },
              { platform: "linkedin", url: "/", icon: "fab fa-linkedin-in" }
            ],
            profileUrl: "/"
          },
          {
            id: 2,
            name: "Adityo S. H.",
            designation: "Direktur",
            image: "assets/images/team/team-2.jpg",
            socialLinks: [
              { platform: "facebook", url: "/", icon: "fab fa-facebook-f" },
              { platform: "twitter", url: "/", icon: "fab fa-twitter" },
              { platform: "linkedin", url: "/", icon: "fab fa-linkedin-in" }
            ],
            profileUrl: "/"
          },
          {
            id: 3,
            name: "Tintin Wartiningsih",
            designation: "Wakil Direktur",
            image: "assets/images/team/team-3.jpg",
            socialLinks: [
              { platform: "facebook", url: "/", icon: "fab fa-facebook-f" },
              { platform: "twitter", url: "/", icon: "fab fa-twitter" },
              { platform: "linkedin", url: "/", icon: "fab fa-linkedin-in" }
            ],
            profileUrl: "/"
          },
          {
            id: 4,
            name: "Ade Muharam",
            designation: "Komanditer",
            image: "assets/images/team/team-1.jpg",
            socialLinks: [
              { platform: "facebook", url: "/", icon: "fab fa-facebook-f" },
              { platform: "twitter", url: "/", icon: "fab fa-twitter" },
              { platform: "linkedin", url: "/", icon: "fab fa-linkedin-in" }
            ],
            profileUrl: "/"
          },
          {
            id: 5,
            name: "Eka Suryaningsih",
            designation: "Komanditer",
            image: "assets/images/team/team-4.jpg",
            socialLinks: [
              { platform: "facebook", url: "/", icon: "fab fa-facebook-f" },
              { platform: "twitter", url: "/", icon: "fab fa-twitter" },
              { platform: "linkedin", url: "/", icon: "fab fa-linkedin-in" }
            ],
            profileUrl: "/"
          }
        ]}
        sectionClass="team-section sec-pad bg-color-1"
      />

      {/* Choose Us Section */}
      <ChooseUsSection 
        title="Mengapa Memilih Solusi Air Kami?"
        features={[
          {
            id: 1,
            title: "Teknologi Filtrasi Canggih",
            description: "Sistem filtrasi multi-tahap tercanggih yang menghilangkan 99,9% kontaminan, bakteri, dan bahan kimia untuk memberikan air yang paling murni dan sehat.",
            icon: "flaticon-draw-check-mark"
          },
          {
            id: 2,
            title: "Dukungan Ahli 24/7",
            description: "Layanan pelanggan dan perawatan sepanjang waktu dengan teknisi bersertifikat siap membantu kapan pun Anda membutuhkan.",
            icon: "flaticon-draw-check-mark"
          }
        ]}
        image="assets/images/resource/chooseus-1.jpg"
        imageAlt="Teknologi Filtrasi Air Canggih"
        sectionClass="chooseus-section sec-pad-2"
        showBackground={true}
      />

      {/* Mission Section */}
      <AboutSection 
        title="Misi Kami: Air Murni untuk Setiap Keluarga"
        description1="UlaQua bertujuan menjadi bagian dari solusi peningkatan kesehatan dan kesejahteraan pendidikan anak-anak Indonesia melalui produk air minum berkualitas tinggi dan terpercaya."
        description2="Kami berkomitmen untuk mendukung program-program kesehatan dan pendidikan anak-anak Indonesia melalui kegiatan tanggung jawab sosial dan inisiatif kemanusiaan."
        buttonText="Hubungi Kami"
        buttonLink="/contact"
        imageSrc="assets/images/resource/about-2.png"
        imageAlt="Misi Kami"
        reverse={true}
        sectionClass="about-section"
      />

      {/* CTA Section */}
      <CTASection 
        title="Siap Meningkatkan Kualitas Air Anda?"
        description="Bergabunglah dengan ribuan pelanggan puas yang mempercayai UlaQua untuk kebutuhan pemurnian air mereka. Hubungi kami hari ini untuk konsultasi gratis dan dapatkan solusi terbaik."
        features={["Pengujian Air Gratis", "Instalasi Profesional", "Dukungan Seumur Hidup"]}
        buttonText="Mulai Sekarang"
        buttonLink="/contact"
      />
    </>
  );
};

export default About;
