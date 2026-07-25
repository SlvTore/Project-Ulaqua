import React, { useState, useEffect } from 'react';
import { Link } from 'react-router-dom';

const HeroSection = ({
  slides = [
    {
      title: "Always Want Safe and Good Water for Healthy Life",
      description: "Excepteur sint occaecat cupidatat non proident sunt culpa qui officia deserunt mollit.",
      primaryButton: { text: "Our Services", link: "/services" },
      secondaryButton: { text: "Discover", link: "/about" },
      image1: "assets/images/banner/vector-1.png",
      image2: "assets/images/banner/vector-2.png"
    }
  ],
  autoPlay = true,
  autoPlayInterval = 5000
}) => {
  const [currentSlide, setCurrentSlide] = useState(0);

  useEffect(() => {
    if (autoPlay && slides.length > 1) {
      const interval = setInterval(() => {
        setCurrentSlide((prev) => (prev + 1) % slides.length);
      }, autoPlayInterval);

      return () => clearInterval(interval);
    }
  }, [autoPlay, autoPlayInterval, slides.length]);

  const goToSlide = (index) => {
    setCurrentSlide(index);
  };

  const nextSlide = () => {
    setCurrentSlide((prev) => (prev + 1) % slides.length);
  };

  const prevSlide = () => {
    setCurrentSlide((prev) => (prev - 1 + slides.length) % slides.length);
  };

  return (
    <section className="banner-section">
      <div className="shape" style={{ backgroundImage: "url(assets/images/shape/banner-shap.png)" }}></div>
      <div className="banner-carousel">
        {slides.map((slide, index) => (
          <div 
            key={index} 
            className={`slide-item ${index === currentSlide ? 'active' : ''}`}
            style={{ display: index === currentSlide ? 'block' : 'none' }}
          >
            <div className="pattern-box">
              <div className="pattern-1"></div>
              <div className="pattern-2"></div>
              <div className="pattern-3" style={{ backgroundImage: "url(assets/images/shape/shape-2.png)" }}></div>
            </div>
            <div className="auto-container">
              <div className="inner-box">
                <div className="image-box">
                  <figure className="image image-1">
                    <img src={slide.image1} alt="Banner" />
                  </figure>
                  <figure className="image image-2">
                    <img src={slide.image2} alt="Banner" />
                  </figure>
                </div>
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
        ))}
      </div>

      {/* Navigation Controls */}
      {slides.length > 1 && (
        <>
          <div className="banner-controls">
            <button className="prev-btn" onClick={prevSlide}>
              <i className="fas fa-arrow-left"></i>
            </button>
            <button className="next-btn" onClick={nextSlide}>
              <i className="fas fa-arrow-right"></i>
            </button>
          </div>

          {/* Dots Navigation */}
          <div className="banner-dots">
            {slides.map((_, index) => (
              <button
                key={index}
                className={`dot ${index === currentSlide ? 'active' : ''}`}
                onClick={() => goToSlide(index)}
              />
            ))}
          </div>
        </>
      )}
    </section>
  );
};

export default HeroSection;
