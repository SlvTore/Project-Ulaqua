import React from 'react';
import { Swiper, SwiperSlide } from 'swiper/react';
import { Navigation, Pagination, Autoplay } from 'swiper/modules';
import { Link } from 'react-router-dom';

// Import Swiper styles
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';

const TeamSection = ({ 
  title = "Meet Our Professional Team",
  subtitle = "Our Experts",
  teamMembers = [
    {
      id: 1,
      name: "Christian Bale",
      designation: "CEO & Founder",
      image: "assets/images/team/team-1.jpg",
      socialLinks: [
        { platform: "facebook", url: "/", icon: "fab fa-facebook-f" },
        { platform: "twitter", url: "/", icon: "fab fa-twitter" },
        { platform: "google", url: "/", icon: "fab fa-google-plus-g" }
      ],
      profileUrl: "/"
    },
    {
      id: 2,
      name: "Hard Branots",
      designation: "Technical Director",
      image: "assets/images/team/team-2.jpg",
      socialLinks: [
        { platform: "facebook", url: "/", icon: "fab fa-facebook-f" },
        { platform: "twitter", url: "/", icon: "fab fa-twitter" },
        { platform: "google", url: "/", icon: "fab fa-google-plus-g" }
      ],
      profileUrl: "/"
    },
    {
      id: 3,
      name: "Monica Bana",
      designation: "Water Quality Expert",
      image: "assets/images/team/team-3.jpg",
      socialLinks: [
        { platform: "facebook", url: "/", icon: "fab fa-facebook-f" },
        { platform: "twitter", url: "/", icon: "fab fa-twitter" },
        { platform: "google", url: "/", icon: "fab fa-google-plus-g" }
      ],
      profileUrl: "/"
    }
  ],
  sectionClass = "team-section sec-pad",
  showTitle = true
}) => {
  return (
    <section className={sectionClass}>
      <div className="auto-container">
        {showTitle && (
          <div className="sec-title centred">
            {subtitle && <span className="sub-title">{subtitle}</span>}
            <h2>{title}</h2>
          </div>
        )}
        
        <Swiper
          modules={[Navigation, Pagination, Autoplay]}
          spaceBetween={30}
          slidesPerView={1}
          navigation={{
            nextEl: '.team-button-next',
            prevEl: '.team-button-prev',
          }}
          pagination={{
            clickable: true,
            bulletClass: 'swiper-pagination-bullet team-bullet',
            bulletActiveClass: 'swiper-pagination-bullet-active team-bullet-active'
          }}
          autoplay={{
            delay: 4000,
            disableOnInteraction: false,
          }}
          loop={true}
          breakpoints={{
            768: {
              slidesPerView: 2,
            },
            1024: {
              slidesPerView: 3,
            },
          }}
          className="team-swiper three-item-carousel"
        >
          {teamMembers.map((member) => (
            <SwiperSlide key={member.id}>
              <div className="team-block-one">
                <div className="inner-box">
                  <div className="image-box">
                    <figure className="image">
                      <img src={member.image} alt={member.name} />
                    </figure>
                    <ul className="social-links clearfix">
                      {member.socialLinks.map((social, index) => (
                        <li key={index}>
                          <Link to={social.url}>
                            <i className={social.icon}></i>
                          </Link>
                        </li>
                      ))}
                    </ul>
                  </div>
                  <div className="lower-content">
                    <h4>
                      <Link to={member.profileUrl}>{member.name}</Link>
                    </h4>
                    <span className="designation">{member.designation}</span>
                    <div className="share-box">
                      <Link to={member.profileUrl}>
                        <i className="fas fa-share-alt"></i>
                      </Link>
                    </div>
                  </div>
                </div>
              </div>
            </SwiperSlide>
          ))}
        </Swiper>

        {/* Custom Navigation */}
        <div className="team-navigation">
          <button className="team-button-prev swiper-button-team">
            <i className="fas fa-angle-left"></i>
          </button>
          <button className="team-button-next swiper-button-team">
            <i className="fas fa-angle-right"></i>
          </button>
        </div>
      </div>
    </section>
  );
};

export default TeamSection;
