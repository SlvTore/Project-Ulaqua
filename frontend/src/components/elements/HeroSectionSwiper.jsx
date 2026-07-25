import React, { useRef } from 'react';
import { Swiper, SwiperSlide } from 'swiper/react';
import { Navigation, Pagination, Autoplay, EffectFade } from 'swiper/modules';
import { Link } from 'react-router-dom';

// Import Swiper styles
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';
import 'swiper/css/effect-fade';

const HeroSectionSwiper = ({
  slides = [
    {
      title: "Always Want Safe and Good Water for Healthy Life",
      description: "Excepteur sint occaecat cupidatat non proident sunt culpa qui officia deserunt mollit.",
      primaryButton: { text: "Our Services", link: "/services" },
      secondaryButton: { text: "Discover", link: "/about" },
      backgroundImage: "assets/images/banner/banner-1.png",
      vectorImage: "assets/images/banner/vector-3.png"
    },
    {
      title: "Pure Water Solutions for Your Family",
      description: "We provide the highest quality water filtration systems for residential and commercial use.",
      primaryButton: { text: "Get Quote", link: "/contact" },
      secondaryButton: { text: "View Products", link: "/shop" },
      backgroundImage: "assets/images/banner/banner-2.png",
      vectorImage: "assets/images/banner/vector-4.png"
    },
    {
      title: "Advanced Filtration Technology",
      description: "Experience the future of water purification with our cutting-edge filtration systems.",
      primaryButton: { text: "Our Services", link: "/services" },
      secondaryButton: { text: "Learn More", link: "/about" },
      backgroundImage: "assets/images/banner/banner-3.png",
      vectorImage: "assets/images/banner/vector-5.png"
    }
  ],
  autoPlay = true,
  autoPlayDelay = 5000
}) => {
  const swiperRef = useRef(null);

  return (
    <section className="banner-style-two">
      <div className="pattern-layer" style={{ backgroundImage: "url(assets/images/shape/shape-15.png)" }}></div>
      
      <Swiper
        modules={[Navigation, Pagination, Autoplay, EffectFade]}
        spaceBetween={0}
        slidesPerView={1}
        loop={true}
        autoplay={autoPlay ? {
          delay: autoPlayDelay,
          disableOnInteraction: false,
        } : false}
        pagination={{
          clickable: true,
          bulletClass: 'swiper-pagination-bullet hero-bullet',
          bulletActiveClass: 'swiper-pagination-bullet-active hero-bullet-active'
        }}
        navigation={{
          nextEl: '.hero-button-next',
          prevEl: '.hero-button-prev',
        }}
        effect="fade"
        fadeEffect={{
          crossFade: true
        }}
        onSwiper={(swiper) => {
          swiperRef.current = swiper;
        }}
        className="banner-carousel hero-swiper"
      >
        {slides.map((slide, index) => (
          <SwiperSlide key={index}>
            <div className="slide-item">
              <div 
                className="image-layer" 
                style={{ backgroundImage: `url(${slide.backgroundImage})` }}
              ></div>
              
              {/* Add pattern layer for slide 3 (like in index-2.html) */}
              {index === 2 && (
                <div 
                  className="pattern-layer-2" 
                  style={{ backgroundImage: "url(assets/images/shape/shape-17.png)" }}
                ></div>
              )}
              
              <div className="auto-container">
                <div className="inner-box">
                  {/* Right Side - Vector Image (always show) */}
                  <div className="image-box">
                    <figure className="image">
                      <img src={slide.vectorImage} alt={`Slide ${index + 1}`} />
                    </figure>
                  </div>
                  
                  {/* Left Side - Content */}
                  <div className="content-box">
                    <h2>{slide.title}</h2>
                    <p>{slide.description}</p>
                    <div className="btn-box clearfix">
                      {slide.primaryButton && (
                        <Link to={slide.primaryButton.link} className="theme-btn btn-one">
                          {slide.primaryButton.text}
                        </Link>
                      )}
                      {slide.secondaryButton && (
                        <Link to={slide.secondaryButton.link} className="theme-btn banner-btn">
                          {slide.secondaryButton.text}
                        </Link>
                      )}
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </SwiperSlide>
        ))}
      </Swiper>

      {/* Custom Navigation Buttons */}
      <div className="hero-navigation">
        <button className="hero-button-prev swiper-button">
          <i className="fas fa-angle-left"></i>
        </button>
        <button className="hero-button-next swiper-button">
          <i className="fas fa-angle-right"></i>
        </button>
      </div>
    </section>
  );
};

export default HeroSectionSwiper;
