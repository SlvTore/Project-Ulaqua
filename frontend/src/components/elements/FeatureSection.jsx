import React from 'react';

const FeatureBlock = ({ 
  icon, 
  title, 
  description, 
  hasShape = true,
  blockClass = "feature-block-one"
}) => {
  return (
    <div className="col-lg-3 col-md-6 col-sm-12 feature-block">
      <div className={blockClass}>
        <div className="inner-box">
          {hasShape && (
            <div className="shape" style={{ backgroundImage: "url(assets/images/shape/shape-3.png)" }}></div>
          )}
          <div className="icon-box">
            <i className={icon}></i>
          </div>
          <h4>{title}</h4>
          <p>{description}</p>
        </div>
      </div>
    </div>
  );
};

const FeatureSection = ({ features, sectionClass = "feature-section centred sec-pad-2" }) => {
  const defaultFeatures = [
    {
      icon: "flaticon-water-drop",
      title: "Kemurnian Maksimal",
      description: "Air berkualitas tinggi dengan tingkat kemurnian terbaik untuk kesehatan keluarga Anda."
    },
    {
      icon: "flaticon-water-drop-1",
      title: "Bebas Klorin",
      description: "Proses filtrasi canggih yang menghilangkan klorin dan bahan kimia berbahaya."
    },
    {
      icon: "flaticon-recycle",
      title: "5 Tahap Filtrasi",
      description: "Sistem penyaringan berlapis untuk memastikan air yang aman dan sehat untuk diminum."
    },
    {
      icon: "flaticon-glass",
      title: "Air Sehat",
      description: "Air murni yang kaya mineral dan optimal untuk kesehatan tubuh Anda.",
      hasShape: false
    }
  ];

  const featuresData = features || defaultFeatures;

  return (
    <section className={sectionClass}>
      <div className="auto-container">
        <div className="row clearfix">
          {featuresData.map((feature, index) => (
            <FeatureBlock
              key={index}
              icon={feature.icon}
              title={feature.title}
              description={feature.description}
              hasShape={feature.hasShape}
              blockClass={feature.blockClass}
            />
          ))}
        </div>
      </div>
    </section>
  );
};

export default FeatureSection;
