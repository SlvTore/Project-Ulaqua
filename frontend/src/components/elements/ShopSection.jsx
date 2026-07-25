import React from 'react';
import { Link } from 'react-router-dom';

const ShopSection = ({ 
  products = [
    {
      id: 1,
      image: "assets/images/resource/shop/shop-1.jpg",
      category: "2L 3 Bottles",
      name: "Mineral Water Bottle",
      price: "$70.00",
      description: "Lorem ipsum dolor sit amet adipelit sed eiusmte.mpor encid dolore.",
      link: "/shop/mineral-water-bottle-1",
      delay: "00ms"
    },
    {
      id: 2,
      image: "assets/images/resource/shop/shop-2.jpg",
      category: "3L 3 Bottles",
      name: "Mineral Water Bottle",
      price: "$60.00",
      description: "Lorem ipsum dolor sit amet adipelit sed eiusmte.mpor encid dolore.",
      link: "/shop/mineral-water-bottle-2",
      delay: "300ms"
    },
    {
      id: 3,
      image: "assets/images/resource/shop/shop-3.jpg",
      category: "3L 2 Bottles",
      name: "Mineral Water Bottle",
      price: "$55.00",
      description: "Lorem ipsum dolor sit amet adipelit sed eiusmte.mpor encid dolore.",
      link: "/shop/mineral-water-bottle-3",
      delay: "600ms"
    }
  ],
  sectionTitle = "We Deliver Best Quality Bottle Packs.",
  sectionClass = "shop-section centred pt-145"
}) => {
  const handleProductClick = (id) => {
    if (id && (typeof id === 'number' || !isNaN(id))) {
      fetch(`/api/public/items/${id}/view`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        }
      }).catch(err => console.error("Error logging product view:", err));
    }
  };

  return (
    <section className={sectionClass}>
      <div className="auto-container">
        <div className="sec-title">
          <h2 dangerouslySetInnerHTML={{ __html: sectionTitle }}></h2>
        </div>
        <div className="row clearfix">
          {products.map((product) => (
            <div key={product.id} className="col-lg-4 col-md-6 col-sm-12 shop-block">
              <div 
                className="shop-block-one wow fadeInUp animated" 
                data-wow-delay={product.delay} 
                data-wow-duration="1500ms"
              >
                <div className="inner-box">
                  <figure className="image-box">
                    <img src={product.image} alt={product.name} />
                  </figure>
                  <div className="lower-content">
                    <div 
                      className="shape" 
                      style={{ backgroundImage: 'url(assets/images/shape/shape-7.png)' }}
                    ></div>
                    <span>{product.category}</span>
                    <h4>
                      <Link to={product.link} onClick={() => handleProductClick(product.id)}>{product.name}</Link>
                    </h4>
                    <h6>{product.price}</h6>
                    {product.is_out_of_stock ? (
                      <span className="stock-status out-of-stock" style={{ color: '#ff4d4f', fontWeight: 'bold', fontSize: '14px', display: 'block', marginBottom: '10px' }}>
                        Stok Habis
                      </span>
                    ) : (
                      product.stock !== undefined && (
                        <span className="stock-status in-stock" style={{ color: '#52c41a', fontWeight: 'bold', fontSize: '14px', display: 'block', marginBottom: '10px' }}>
                          Tersedia ({product.stock} {product.unit || 'Pcs'})
                        </span>
                      )
                    )}
                    <p>{product.description}</p>
                    <div className="btn-box">
                      {product.is_out_of_stock ? (
                        <button className="theme-btn btn-two" disabled style={{ backgroundColor: '#d9d9d9', color: '#8c8c8c', border: '1px solid #d9d9d9', cursor: 'not-allowed', padding: '10px 24px', borderRadius: '4px' }}>
                          Stok Habis
                        </button>
                      ) : (
                        <Link to={product.link} onClick={() => handleProductClick(product.id)} className="theme-btn btn-two">
                          Pesan Sekarang
                        </Link>
                      )}
                    </div>
                  </div>
                </div>
              </div>
            </div>
          ))}
        </div>
      </div>
    </section>
  );
};

export default ShopSection;
