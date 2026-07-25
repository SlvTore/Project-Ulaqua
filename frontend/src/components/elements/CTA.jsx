import React from 'react';
import { Link } from 'react-router-dom';

const CTASection = ({
  title = "Ready To Get Our Premium Water Delivery Service?",
  description = "We give our services to more than 10 countries. We give our delivery service using more than 50 couriers within 2hr anywhere in the city.",
  features = ["Free Delivery", "7 Days In A Week Service"],
  buttonText = "Our Services",
  buttonLink = "/services",
  imageSrc = "assets/images/resource/cta-1.png",
  imageAlt = "Water Delivery Service",
  sectionClass = "cta-section bg-color-2",
  reverse = false
}) => {
  return (
    <section className={sectionClass}>
      <div className="pattern-layer">
        <div className="pattern-1" style={{ backgroundImage: "url(assets/images/shape/shape-10.png)" }}></div>
        <div className="pattern-2" style={{ backgroundImage: "url(assets/images/shape/shape-2.png)" }}></div>
        <div className="pattern-3" style={{ backgroundImage: "url(assets/images/shape/shape-33.png)" }}></div>
        <div className="pattern-4" style={{ backgroundImage: "url(assets/images/shape/shape-34.png)" }}></div>
      </div>
      <div className="auto-container">
        <div className={`row align-items-center clearfix ${reverse ? 'flex-row-reverse' : ''}`}>
          <div className="col-lg-6 col-md-12 col-sm-12 image-column">
            <figure className="image-box wow slideInLeft animated" data-wow-delay="00ms" data-wow-duration="1500ms">
              <img src={imageSrc} alt={imageAlt} />
            </figure>
          </div>
          <div className="col-lg-6 col-md-12 col-sm-12 content-column">
            <div className="content_block_3">
              <div className="content-box">
                <div className="sec-title light">
                  <h2>{title}</h2>
                </div>
                <div className="text">
                  <p>{description}</p>
                </div>
                {features && features.length > 0 && (
                  <ul className="list clearfix">
                    {features.map((feature, index) => (
                      <li key={index}>{feature}</li>
                    ))}
                  </ul>
                )}
                {buttonText && (
                  <div className="btn-box">
                    <Link to={buttonLink} className="theme-btn btn-one">{buttonText}</Link>
                  </div>
                )}
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  );
};

export default CTASection;
