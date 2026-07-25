import React from 'react';
import HeroSectionSwiper from '../components/elements/HeroSectionSwiper';
import FeatureSection from '../components/elements/FeatureSection';
import AboutSection from '../components/elements/AboutSection';
import ServiceSection from '../components/elements/ServiceSection';
import CTASection from '../components/elements/CTA';
import ShopSection from '../components/elements/ShopSection';
import TestimonialSection from '../components/elements/TestimonialSection';
import '../styles/hero-swiper.css';
import '../styles/shop-section.css';
import '../styles/testimonial-section.css';

const Home = () => {
  // Custom data for home page sections with background images
  const heroSlides = [
    {
      title: "Air Bersih dan Sehat untuk Kehidupan yang Lebih Baik",
      description: "Nikmati air minum berkualitas premium dengan teknologi filtrasi terkini untuk kesehatan keluarga Anda.",
      primaryButton: { text: "Pesan Sekarang", link: "" },
      secondaryButton: { text: "Kenali Kami", link: "/about" },
      backgroundImage: "assets/images/banner/banner-1.png",
      vectorImage: "assets/images/banner/vector-3.png"
    },
    {
      title: "Solusi Air Murni untuk Keluarga Indonesia",
      description: "Kami menyediakan sistem filtrasi air berkualitas tinggi untuk kebutuhan rumah tangga dan bisnis Anda.",
      primaryButton: { text: "Pesan Sekarang", link: "" },
      secondaryButton: { text: "Kenali Kami", link: "/about" },
      backgroundImage: "assets/images/banner/banner-2.png",
      vectorImage: "assets/images/banner/vector-4.png"
    },
    {
      title: "Teknologi Filtrasi Canggih untuk Air Terbaik",
      description: "Rasakan inovasi terdepan dalam pemurnian air dengan sistem filtrasi modern dan solusi terpercaya.",
      primaryButton: { text: "Pesan Sekarang", link: "" },
      secondaryButton: { text: "Kenali Kami", link: "/about" },
      backgroundImage: "assets/images/banner/banner-3.png",
      vectorImage: "assets/images/banner/vector-5.png"
    }
  ];

  const aboutData = {
    title: "Air Bersih dan Sehat Adalah Hak Setiap Keluarga.",
    description1: "Kami berkomitmen menyediakan air minum berkualitas premium yang telah melalui proses filtrasi canggih dan teruji. Dengan teknologi terkini dan standar kebersihan internasional, kami memastikan setiap tetes air yang sampai ke keluarga Anda adalah air terbaik untuk kesehatan jangka panjang.",
    description2: "Dipercaya oleh ribuan keluarga Indonesia, sistem filtrasi kami telah terbukti menghilangkan kontaminan berbahaya dan menjaga mineral penting dalam air. Investasi untuk kesehatan keluarga Anda dimulai dari pilihan air minum yang tepat. Bergabunglah dengan komunitas kami dan rasakan perbedaannya.",
    buttonText: "Pelajari Selengkapnya",
    buttonLink: "/about",
    imageSrc: "assets/images/resource/about-1.png",
    imageAlt: "Tentang Ulaqua"
  };

  const servicesData = [
    {
      icon: "flaticon-water-bottle-1",
      title: "Air Minum Rumah Tangga",
      description: "Solusi filtrasi air lengkap untuk rumah Anda memastikan air minum murni dan bersih.",
      link: "/service/residential-waters"
    },
    {
      icon: "flaticon-water",
      title: "Pabrik Filtrasi",
      description: "Sistem pengolahan air tingkat industri untuk kebutuhan pemurnian air skala besar.",
      link: "/service/filtration-plants"
    },
    {
      icon: "flaticon-water-bottle",
      title: "Air Komersial",
      description: "Solusi air profesional untuk kantor, restoran, dan tempat usaha komersial.",
      link: "/service/commercial-waters"
    }
  ];

  const ctaData = {
    title: "Siap Menggunakan Layanan Pengiriman Air Premium Kami?",
    description: "Kami melayani lebih dari 10 negara dengan jaringan kurir lebih dari 50 mitra pengiriman dalam waktu 2 jam ke seluruh kota.",
    features: ["Pengiriman Gratis", "Layanan 7 Hari Seminggu", "Dukungan Pelanggan 24/7"],
    buttonText: "Mulai Sekarang",
    buttonLink: "/contact",
    imageSrc: "assets/images/resource/cta-1.png",
    imageAlt: "Layanan Pengiriman Air"
  };

  const shopData = [
    {
      id: 1,
      image: "assets/images/resource/shop/shop-1.jpg",
      category: "2L 3 Botol",
      name: "Botol Air Mineral",
      price: "Rp 70.000",
      description: "Air mineral berkualitas tinggi dengan proses filtrasi modern untuk kesehatan keluarga.",
      link: "https://wa.me/6282119425191?text=Halo%20Ulaqua,%20saya%20tertarik%20untuk%20memesan%20Botol%20Air%20Mineral%202L%20(3%20Botol).",
      delay: "00ms"
    },
    {
      id: 2,
      image: "assets/images/resource/shop/shop-2.jpg",
      category: "3L 3 Botol",
      name: "Botol Air Mineral",
      price: "Rp 60.000",
      description: "Air mineral murni dengan teknologi filtrasi terkini untuk konsumsi keluarga sehari-hari.",
      link: "https://wa.me/6282119425191?text=Halo%20Ulaqua,%20saya%20tertarik%20untuk%20memesan%20Botol%20Air%20Mineral%203L%20(3%20Botol).",
      delay: "300ms"
    },
    {
      id: 3,
      image: "assets/images/resource/shop/shop-3.jpg",
      category: "3L 2 Botol",
      name: "Botol Air Mineral",
      price: "Rp 55.000",
      description: "Paket hemat air mineral bersih dengan kualitas terjamin dan harga terjangkau.",
      link: "https://wa.me/6282119425191?text=Halo%20Ulaqua,%20saya%20tertarik%20untuk%20memesan%20Botol%20Air%20Mineral%203L%20(2%20Botol).",
      delay: "600ms"
    }
  ];

  const testimonialsData = [
    {
      id: 1,
      image: "assets/images/resource/testimonial-1.jpg",
      rating: 5,
      text: "Produk ini sangat bagus dan air benar-benar bersih. Kami keluarga sangat puas dengan kualitas dan pelayanannya.",
      name: "Nicolas Lawson",
      designation: "Desainer"
    },
    {
      id: 2,
      image: "assets/images/resource/testimonial-2.jpg",
      rating: 5,
      text: "Pengiriman cepat dan produk sesuai harapan. Air mineral ini aman untuk dikonsumsi oleh seluruh keluarga.",
      name: "Michael Bean",
      designation: "Manajer"
    },
    {
      id: 3,
      image: "assets/images/resource/testimonial-3.jpg",
      rating: 5,
      text: "Layanan pelanggan yang responsif dan produk berkualitas premium. Saya merekomendasikan kepada semua teman.",
      name: "Sarah Johnson",
      designation: "CEO"
    },
    {
      id: 4,
      image: "assets/images/resource/testimonial-4.jpg",
      rating: 5,
      text: "Harga terjangkau dengan kualitas terbaik. Sudah menjadi langganan setia dan tidak akan pindah ke produk lain.",
      name: "David Wilson",
      designation: "Direktur Pemasaran"
    }
  ];

  const [products, setProducts] = React.useState([]);

  React.useEffect(() => {
    fetch('/api/public/items')
      .then(res => {
        if (!res.ok) throw new Error("Failed to fetch");
        return res.json();
      })
      .then(data => {
        if (Array.isArray(data) && data.length > 0) {
          setProducts(data);
        }
      })
      .catch(err => {
        console.error("Error fetching dynamic products from IMS:", err);
      });
  }, []);

  return (
    <div>
      <HeroSectionSwiper slides={heroSlides} />

      {/* Feature Section with Title */}
      <section className="feature-section alternat-2 centred">
        <div className="auto-container">
          <div className="inner-container wow fadeInLeft animated" data-wow-delay="00ms" data-wow-duration="1500ms">
            <div className="title-text">
              <h2>KEMURNIAN AIR <br></br>KEBAIKAN UNTUK KELUARGA</h2> <br></br>
              <p>Air minum berkualitas yang diproses dengan teknologi modern, <br></br>membawa keberkahan dari Pondok Pesantren Ulul Albab untuk keluarga Anda.</p>
            </div>
            <FeatureSection />
          </div>
        </div>
      </section>

      {/* About Section */}
      <AboutSection 
        title={aboutData.title}
        description1={aboutData.description1}
        description2={aboutData.description2}
        buttonText={aboutData.buttonText}
        buttonLink={aboutData.buttonLink}
        imageSrc={aboutData.imageSrc}
        imageAlt={aboutData.imageAlt}
        sectionClass="about-section sec-pad"
      />

      {/* Services Section */}
      <ServiceSection 
        services={servicesData}
        sectionClass="service-section sec-pad bg-color-1"
        sectionTitle="Layanan Filtrasi Air Kami"
        sectionSubtitle="Pilihan Solusi Air Murni untuk Keluarga dan Bisnis Anda"
      />

      {/* CTA Section */}
      <CTASection 
        title={ctaData.title}
        description={ctaData.description}
        features={ctaData.features}
        buttonText={ctaData.buttonText}
        buttonLink={ctaData.buttonLink}
        imageSrc={ctaData.imageSrc}
        imageAlt={ctaData.imageAlt}
      />

      {/* Shop Section */}
      <ShopSection 
        products={products.length > 0 ? products : shopData}
        sectionTitle="Kami Menyajikan Pilihan<br />Air Berkualitas."
        sectionClass="shop-section centred pt-145"
      />

      {/* Testimonial Section */}
      <TestimonialSection 
        testimonials={testimonialsData}
        sectionTitle="Apa Yang Mereka Katakan Tentang <br />Ulaqua?"
        sectionClass="testimonial-section alternat-2 bg-color-1"
        autoPlay={true}
        autoPlayDelay={3000}
      />
    </div>
  );
};

export default Home;
