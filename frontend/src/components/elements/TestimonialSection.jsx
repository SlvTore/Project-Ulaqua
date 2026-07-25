import React from 'react';
import { Swiper, SwiperSlide } from 'swiper/react';
import { Navigation, Pagination, Autoplay } from 'swiper/modules';

// Import Swiper styles
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';

const TestimonialSection = ({
  testimonials = [
    {
      id: 1,
      image: "assets/images/resource/testimonial-1.jpg",
      rating: 5,
      text: "Lorem ipsum dolor amet consectur adicing elit sed do usmod tempor incididunt enim ad minim veniam.",
      name: "Nicolas Lawson",
      designation: "Designer"
    },
    {
      id: 2,
      image: "assets/images/resource/testimonial-2.jpg",
      rating: 5,
      text: "Lorem ipsum dolor amet consectur adicing elit sed do usmod tempor incididunt enim ad minim veniam.",
      name: "Michael Bean",
      designation: "Manager"
    },
    {
      id: 3,
      image: "assets/images/resource/testimonial-1.jpg",
      rating: 5,
      text: "Lorem ipsum dolor amet consectur adicing elit sed do usmod tempor incididunt enim ad minim veniam.",
      name: "Nicolas Lawson",
      designation: "Designer"
    },
    {
      id: 4,
      image: "assets/images/resource/testimonial-2.jpg",
      rating: 5,
      text: "Lorem ipsum dolor amet consectur adicing elit sed do usmod tempor incididunt enim ad minim veniam.",
      name: "Michael Bean",
      designation: "Manager"
    }
  ],
  sectionTitle = "What Our Client are Saying About Acuasafe",
  sectionClass = "testimonial-section alternat-2 bg-color-1",
  autoPlay = true,
  autoPlayDelay = 3000
}) => {
  const renderStars = (rating) => {
    return Array.from({ length: 5 }, (_, index) => (
      <li key={index}>
        <i className={index < rating ? "fas fa-star" : "far fa-star"}></i>
      </li>
    ));
  };

  return (
    <section className={sectionClass}>
      <div className="pattern-layer">
        <div 
          className="pattern-1" 
          style={{ backgroundImage: 'url(assets/images/shape/shape-21.png)' }}
        ></div>
        <div 
          className="pattern-2" 
          style={{ backgroundImage: 'url(assets/images/shape/shape-22.png)' }}
        ></div>
      </div>
      <div className="auto-container">
        <div className="sec-title centred light">
          <h2 dangerouslySetInnerHTML={{ __html: sectionTitle }}></h2>
        </div>
        
        <div className="testimonial-container">
          <Swiper
            modules={[Navigation, Pagination, Autoplay]}
            spaceBetween={30}
            slidesPerView={2}
            loop={true}
            autoplay={autoPlay ? {
              delay: autoPlayDelay,
              disableOnInteraction: false,
            } : false}
            pagination={{
              clickable: true,
              el: '.testimonial-pagination',
              bulletClass: 'swiper-pagination-bullet testimonial-bullet',
              bulletActiveClass: 'swiper-pagination-bullet-active testimonial-bullet-active'
            }}
            navigation={{
              nextEl: '.testimonial-button-next',
              prevEl: '.testimonial-button-prev',
            }}
            breakpoints={{
              320: {
                slidesPerView: 1,
                spaceBetween: 20,
              },
              768: {
                slidesPerView: 1,
                spaceBetween: 25,
              },
              1024: {
                slidesPerView: 2,
                spaceBetween: 30,
              },
            }}
            className="two-column-carousel testimonial-swiper"
          >
            {testimonials.map((testimonial) => (
              <SwiperSlide key={testimonial.id}>
                <div className="testimonial-block-one">
                  <div className="inner-box">
                    <div className="author-section">
                      <figure className="author-thumb">
                        <img src={testimonial.image} alt={testimonial.name} />
                      </figure>
                      <div className="author-info">
                        <h5>{testimonial.name}</h5>
                        <span className="designation">{testimonial.designation}</span>
                      </div>
                    </div>
                    <div className="inner">
                      <ul className="rating clearfix">
                        {renderStars(testimonial.rating)}
                      </ul>
                      <p>{testimonial.text}</p>
                    </div>
                  </div>
                </div>
              </SwiperSlide>
            ))}
          </Swiper>

          {/* Custom Navigation Buttons */}
          <div className="testimonial-navigation">
            <button className="testimonial-button-prev swiper-button">
              <i className="fas fa-angle-left"></i>
            </button>
            <button className="testimonial-button-next swiper-button">
              <i className="fas fa-angle-right"></i>
            </button>
          </div>

          {/* Custom Pagination */}
          <div className="testimonial-pagination"></div>
        </div>
      </div>
    </section>
  );
};

export default TestimonialSection;
