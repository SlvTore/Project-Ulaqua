import React from 'react';
import { Link } from 'react-router-dom';

const ChooseUsSection = ({
  title = "Protect Your Family with One of The Best Water Filtering System.",
  features = [
    {
      id: 1,
      title: "Advanced Filtration Technology",
      description: "State-of-the-art filtration systems that remove 99.9% of contaminants for pure, clean water.",
      icon: "flaticon-draw-check-mark"
    },
    {
      id: 2,
      title: "24/7 Customer Support",
      description: "Round-the-clock technical support and maintenance services for all our water systems.",
      icon: "flaticon-draw-check-mark"
    }
  ],
  image = "assets/images/resource/chooseus-1.jpg",
  imageAlt = "Choose Us",
  sectionClass = "chooseus-section sec-pad-2",
  reverse = false,
  showBackground = true
}) => {
  return (
    <section className={sectionClass}>
      {showBackground && (
        <>
          <div className="bg-layer" style={{ backgroundImage: "url(assets/images/shape/shape-5.png)" }}></div>
          <div className="shape-layer">
            <div className="shape-1" style={{ backgroundImage: "url(assets/images/shape/shape-6.png)" }}></div>
            <div className="shape-2"></div>
            <div className="shape-3"></div>
  
          </div>
        </>
      )}
      
      <div className="auto-container">
        <div className="row clearfix">
          <div className={`col-lg-6 col-md-12 col-sm-12 ${reverse ? 'image-column' : 'content-column'}`}>
            {reverse ? (
              <div className="image-box top-0 wow fadeInLeft animated" data-wow-delay="00ms" data-wow-duration="1500ms">
                <figure className="image">
                  <img src={image} alt={imageAlt} />
                </figure>
              </div>
            ) : (
              <div className="content_block_2">
                <div className="content-box">
                  <div className="sec-title light">
                    <h2>{title}</h2>
                  </div>
                  <div className="inner-box">
                    {features.map((feature) => (
                      <div key={feature.id} className="single-item">
                        <div className="icon-box">
                          <i className={feature.icon}></i>
                        </div>
                        <div className="text">
                          <h4>{feature.title}</h4>
                          <p>{feature.description}</p>
                        </div>
                      </div>
                    ))}
                  </div>
                </div>
              </div>
            )}
          </div>
          
          <div className={`col-lg-6 col-md-12 col-sm-12 ${reverse ? 'content-column' : 'image-column'}`}>
            {reverse ? (
              <div className="content_block_2">
                <div className="content-box">
                  <div className="sec-title light">
                    <h2>{title}</h2>
                  </div>
                  <div className="inner-box">
                    {features.map((feature) => (
                      <div key={feature.id} className="single-item">
                        <div className="icon-box">
                          <i className={feature.icon}></i>
                        </div>
                        <div className="text">
                          <h4>{feature.title}</h4>
                          <p>{feature.description}</p>
                        </div>
                      </div>
                    ))}
                  </div>
                </div>
              </div>
            ) : (
              <div className="image-box top-0 wow fadeInRight animated" data-wow-delay="00ms" data-wow-duration="1500ms">
                <figure className="image">
                  <img src={image} alt={imageAlt} />
                </figure>
              </div>
            )}
          </div>
        </div>
      </div>
    </section>
  );
};

export default ChooseUsSection;
