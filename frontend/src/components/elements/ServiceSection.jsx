import React from 'react';
import { Link } from 'react-router-dom';
import { SERVICES_LIST } from '../../data/services';
import '../../styles/service-section.css';

const ServiceBlock = ({ 
  icon, 
  title, 
  description, 
  link = "#",
  blockClass = "service-block-two",
  delay = "0ms"
}) => {
  return (
    <div className="col-lg-4 col-md-6 col-sm-12 service-block">
      <div className={`${blockClass} wow fadeInUp animated`} data-wow-delay={delay} data-wow-duration="1500ms">
        <div className="inner-box">
          <div className="icon-box">
            <div className="icon">
              <i className={icon}></i>
            </div>
          </div>
          <h4>
            <Link to={link}>{title}</Link>
          </h4>
          <p>{description}</p>
          <div className="btn-box">
            <Link to={link} className="theme-btn btn-two">Informasi Lebih Lanjut </Link>
          </div>
        </div>
      </div>
    </div>
  );
};

const ServiceSection = ({ 
  services, 
  sectionClass = "service-page-section centred",
  sectionTitle,
  sectionSubtitle,
  blockClass = "service-block-two"
}) => {
  const servicesData = services || SERVICES_LIST;

  return (
    <section className={sectionClass}>
      <div className="auto-container">
        {(sectionTitle || sectionSubtitle) && (
          <div className="sec-title">
            {sectionSubtitle && <span className="top-title">{sectionSubtitle}</span>}
            {sectionTitle && <h2 dangerouslySetInnerHTML={{ __html: sectionTitle }}></h2>}
          </div>
        )}
        <div className="row clearfix">
          {servicesData.map((service, index) => (
            <ServiceBlock
              key={index}
              icon={service.icon}
              title={service.title}
              description={service.description}
              link={service.link}
              blockClass={service.blockClass || blockClass}
              delay={`${index * 300}ms`}
            />
          ))}
        </div>
      </div>
    </section>
  );
};

export default ServiceSection;
