import React from 'react';
import { Link } from 'react-router-dom';

const AboutSection = ({
  title = "We Always Want Safe and Healthy Water for Healthy Life.",
  description1 = "Dolor sit amet consectur elit sed eiusmod tempor incid dunt labore dolore magna aliqua enim minim veniam quis nostrud exercitation ullamco laboris nisi ut aliquip ex comodo consequat.duis aute irure dolor in reprehenderit. in voluptate velit esse cillum dolore eu fugiat.",
  description2 = "Cepteur sint occaecat cupidatat non proident sunt in culpa qui officia dese runt mollit anim id est laborum. Sed ut perspiciatis unde omnis iste natus error sit voluptatem.",
  buttonText = "Read More",
  buttonLink = "/about",
  imageSrc = "assets/images/resource/about-1.png",
  imageAlt = "About Acuasafe",
  reverse = false,
  sectionClass = "about-section"
}) => {
  return (
    <section className={sectionClass}>
      <div className="auto-container">
        <div className={`row align-items-center clearfix ${reverse ? 'flex-row-reverse' : ''}`}>
          <div className="col-lg-6 col-md-12 col-sm-12 image-column">
            <figure className="image-box clearfix wow fadeInLeft animated" data-wow-delay="00ms" data-wow-duration="1500ms">
              <img src={imageSrc} alt={imageAlt} />
            </figure>
          </div>
          <div className="col-lg-6 col-md-12 col-sm-12 content-column">
            <div className="content_block_1">
              <div className="content-box wow fadeInRight animated" data-wow-delay="00ms" data-wow-duration="1500ms">
                <div className="sec-title">
                  <h2>{title}</h2>
                </div>
                <div className="text">
                  <p>{description1}</p>
                  {description2 && <p>{description2}</p>}
                </div>
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

export default AboutSection;
