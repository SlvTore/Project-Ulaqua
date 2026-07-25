import React, { useState, useEffect } from 'react';
import { Link, useLocation } from 'react-router-dom';
import '../../styles/whatsapp-button.css';

const Navbar = () => {
    const [isMenuOpen, setIsMenuOpen] = useState(false);
    const [isSticky, setIsSticky] = useState(false);
    const [expandedMenu, setExpandedMenu] = useState({});
    
    // Removed isSearchOpen state since it's no longer needed
    const location = useLocation();

    useEffect(() => {
        const handleScroll = () => {
            setIsSticky(window.scrollY > 100);
        };

        window.addEventListener('scroll', handleScroll);
        return () => window.removeEventListener('scroll', handleScroll);
    }, []);

    // Toggle body class for mobile menu
    useEffect(() => {
        if (isMenuOpen) {
            document.body.classList.add('mobile-menu-visible');
        } else {
            document.body.classList.remove('mobile-menu-visible');
        }
    }, [isMenuOpen]);

    const toggleMobileMenu = () => {
        setIsMenuOpen(!isMenuOpen);
    };

    const toggleSubmenu = (key) => {
        setExpandedMenu(prev => ({
            ...prev,
            [key]: !prev[key]
        }));
    };

    // Removed toggleSearch function since it's no longer needed

    const isActive = (path) => {
        return location.pathname === path ? 'current' : '';
    };

    // Navigation items to reuse
    const navigationItems = (
        <ul className="navigation clearfix">
            <li className={isActive('/')}>
                <Link to="/">Beranda</Link>
            </li>
            <li className={isActive('/about')}>
                <Link to="/about">Tentang Kami</Link>
            </li>
            <li className={`dropdown ${location.pathname.startsWith('/service') || isActive('/services') ? 'current' : ''}`}>
                <Link to="/services">Layanan</Link>
                <ul>
                    <li><Link to="/services">Semua Layanan</Link></li>
                    <li><Link to="/service/project-planning">Perencanaan Proyek</Link></li>
                    <li><Link to="/service/residential-waters">Air Rumah Tangga</Link></li>
                    <li><Link to="/service/commercial-waters">Air Komersial</Link></li>
                    <li><Link to="/service/filtration-plants">Pabrik Filtrasi</Link></li>
                    <li><Link to="/service/water-softening">Pelunakan Air</Link></li>
                    <li><Link to="/service/market-research">Riset Pasar</Link></li>
                </ul>
            </li>
            <li className={isActive('/contact')}>
                <Link to="/contact">Kontak</Link>
            </li>
        </ul>
    );

    return (
        <>
            {/* Main Header */}
            <header className="main-header">
                {/* Header Lower */}
                <div className="header-lower">
                    <div className="shape" style={{ backgroundImage: "url(assets/images/shape/shape-1.png)" }}></div>
                    <div className="outer-box">
                        <div className="logo-box">
                            <figure className="logo">
                                <Link to="/">
                                    <img src="assets/images/logo.png" alt="Acuasafe" />
                                </Link>
                            </figure>
                        </div>
                        <div className="menu-area clearfix">
                            {/* Mobile Navigation Toggler */}
                            <div className="mobile-nav-toggler" onClick={toggleMobileMenu}>
                                <i className="icon-bar"></i>
                                <i className="icon-bar"></i>
                                <i className="icon-bar"></i>
                            </div>
                            <nav className="main-menu navbar-expand-md navbar-light">
                                <div className="collapse navbar-collapse show clearfix" id="navbarSupportedContent">
                                    {navigationItems}
                                </div>
                            </nav>
                        </div>
                        <ul className="nav-right">
                            <li>
                                <a href="https://wa.me/6282119425191" className="wa-btn" target="_blank" rel="noreferrer">
                                    <i className="fab fa-whatsapp"></i>Hubungi Kami
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                {/* Sticky Header */}
                {isSticky && (
                    <div className="sticky-header">
                        <div className="outer-box">
                            <div className="logo-box">
                                <figure className="logo">
                                    <Link to="/">
                                        <img src="assets/images/logo-2.png" alt="Acuasafe" />
                                    </Link>
                                </figure>
                            </div>
                            <div className="menu-area clearfix">
                                <nav className="main-menu clearfix">
                                    {navigationItems}
                                </nav>
                            </div>
                            <ul className="nav-right">
                                {/* Removed search-box-outer and cart-box items */}
                                <li>
                                    <a href="https://wa.me/6282119425191" className="wa-btn" target="_blank" rel="noreferrer">
                                        <i className="fab fa-whatsapp"></i>Hubungi Kami
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                )}
            </header>
            {/* Mobile Menu */}
            <div className="mobile-menu">
                <div className="menu-backdrop" onClick={toggleMobileMenu}></div>
                <div className="close-btn" onClick={toggleMobileMenu}>
                    <i className="fas fa-times"></i>
                </div>
                
                <nav className="menu-box">
                    <div className="nav-logo">
                        <Link to="/">
                            <img src="assets/images/logo-2.png" alt="" title="" />
                        </Link>
                    </div>
                    <div className="menu-outer">
                        <ul className="navigation clearfix">
                            <li><Link to="/" onClick={toggleMobileMenu}>Beranda</Link></li>
                            <li><Link to="/about" onClick={toggleMobileMenu}>Tentang Kami</Link></li>
                            <li className="dropdown">
                                <Link to="/services" onClick={toggleMobileMenu}>Layanan</Link>
                                <div className={`dropdown-btn ${expandedMenu['services'] ? 'open' : ''}`} onClick={() => toggleSubmenu('services')}>
                                    <span className="fas fa-angle-down"></span>
                                </div>
                                <ul style={{ display: expandedMenu['services'] ? 'block' : 'none' }}>
                                    <li><Link to="/services" onClick={toggleMobileMenu}>Semua Layanan</Link></li>
                                    <li><Link to="/service/project-planning" onClick={toggleMobileMenu}>Perencanaan Proyek</Link></li>
                                    <li><Link to="/service/residential-waters" onClick={toggleMobileMenu}>Air Rumah Tangga</Link></li>
                                    <li><Link to="/service/commercial-waters" onClick={toggleMobileMenu}>Air Komersial</Link></li>
                                    <li><Link to="/service/filtration-plants" onClick={toggleMobileMenu}>Pabrik Filtrasi</Link></li>
                                    <li><Link to="/service/water-softening" onClick={toggleMobileMenu}>Pelunakan Air</Link></li>
                                    <li><Link to="/service/market-research" onClick={toggleMobileMenu}>Riset Pasar</Link></li>
                                </ul>
                            </li>
                            <li><Link to="/contact" onClick={toggleMobileMenu}>Kontak</Link></li>
                        </ul>
                    </div>
                    <div className="contact-info">
                        <h4>Info Kontak</h4>
                        <ul>
                            <li>Kp. Leles RT/RW 003/011, Mekarsari, Ciparay, Bandung</li>
                            <li><a href="tel:+6282119425191">+62 821-1942-5191</a></li>
                            <li><a href="mailto:cvululalbabhidroprima@gmail.com">cvululalbabhidroprima@gmail.com</a></li>
                        </ul>
                    </div>
                    <div className="social-links">
                        <ul className="clearfix">
                            <li><a href="#"><span className="fab fa-twitter"></span></a></li>
                            <li><a href="#"><span className="fab fa-facebook-square"></span></a></li>
                            <li><a href="#"><span className="fab fa-pinterest-p"></span></a></li>
                            <li><a href="#"><span className="fab fa-instagram"></span></a></li>
                            <li><a href="#"><span className="fab fa-youtube"></span></a></li>
                        </ul>
                    </div>
                </nav>
            </div>
        </>
    );
};

export default Navbar;
