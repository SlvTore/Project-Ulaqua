# Acuasafe React SPA - Water Solutions Website

A modern React Single Page Application (SPA) based on the Acuasafe HTML template, providing water filtration and purification solutions.

## 🚀 Project Overview

This project converts the Acuasafe HTML template into a React-based SPA with:
- **React Router** for navigation
- **Reusable component architecture** extracted from template elements
- **Modern React patterns** and best practices
- **Responsive design** maintained from original template
- **Bootstrap CSS framework** integration

## 📁 Project Structure

```
app/
├── public/
│   ├── assets/                 # All Acuasafe template assets (CSS, JS, Images)
│   │   ├── css/               # Bootstrap, FontAwesome, Custom styles
│   │   ├── images/            # All template images and icons
│   │   ├── fonts/             # Icon fonts and typography
│   │   └── js/                # Template JavaScript files
│   └── index.html             # Main HTML file with asset links
├── src/
│   ├── components/
│   │   ├── elements/          # Reusable UI components from template
│   │   │   ├── AboutSection.jsx      # About block component
│   │   │   ├── FeatureSection.jsx    # Feature blocks component
│   │   │   ├── HeroSection.jsx       # Banner/Hero component
│   │   │   ├── ServiceSection.jsx    # Service blocks component
│   │   │   └── CTA.jsx              # Call-to-action component
│   │   ├── layout/
│   │   │   └── Layout.jsx            # Main layout wrapper
│   │   ├── partials/
│   │   │   ├── Navbar.jsx           # Navigation component
│   │   │   └── Footer.jsx           # Footer component
│   │   └── landing/home/
│   │       └── App.jsx              # Main App component with routing
│   ├── pages/
│   │   ├── Home.jsx                 # Homepage
│   │   ├── About.jsx                # About page
│   │   ├── Services.jsx             # Services page
│   │   └── Contact.jsx              # Contact page
│   ├── styles/                      # Custom CSS files
│   └── main.jsx                     # Application entry point
├── package.json
└── README.md
```

## 🧩 Component Architecture

### Element Components (Extracted from Acuasafe)

1. **FeatureSection** - Feature blocks with icons and descriptions
2. **AboutSection** - About content with image and text
3. **ServiceSection** - Service blocks with links
4. **HeroSection** - Banner carousel with slides
5. **CTASection** - Call-to-action blocks

### Layout Components

1. **Layout** - Main wrapper with header/footer
2. **Navbar** - Responsive navigation with mobile menu
3. **Footer** - Site footer with links and contact info

### Pages

1. **Home** - Landing page combining multiple elements
2. **About** - Company information and mission
3. **Services** - Service offerings and process
4. **Contact** - Contact form and information

## 🎨 Features

### From Acuasafe Template
- ✅ Responsive design (mobile-first)
- ✅ Bootstrap 4+ CSS framework
- ✅ FontAwesome icons
- ✅ Animate.css animations
- ✅ Owl Carousel functionality
- ✅ Modern typography (Spartan + Open Sans)
- ✅ Professional color scheme

### React Enhancements
- ✅ Single Page Application (SPA) routing
- ✅ Component-based architecture
- ✅ Reusable and configurable components
- ✅ Modern React hooks (useState, useEffect)
- ✅ Responsive navigation with mobile menu
- ✅ Form handling with state management
- ✅ SEO-friendly page titles and structure

## 🛠️ Installation & Setup

1. **Clone and Navigate**
   ```bash
   cd app
   ```

2. **Install Dependencies**
   ```bash
   npm install
   ```

3. **Start Development Server**
   ```bash
   npm run dev
   ```

4. **Open Browser**
   Navigate to `http://localhost:5173`

## 🔧 Available Scripts

- `npm run dev` - Start development server
- `npm run build` - Build for production
- `npm run preview` - Preview production build
- `npm run lint` - Run ESLint

## 📱 Responsive Breakpoints

- **Mobile**: < 768px
- **Tablet**: 768px - 991px
- **Desktop**: 992px - 1199px
- **Large Desktop**: > 1200px

## 🎯 Usage Examples

### Using Feature Section Component

```jsx
import FeatureSection from '../components/elements/FeatureSection';

const features = [
  {
    icon: "flaticon-water-drop",
    title: "Maximum Purity",
    description: "Pure water guaranteed"
  }
];

<FeatureSection features={features} />
```

### Using About Section Component

```jsx
import AboutSection from '../components/elements/AboutSection';

<AboutSection 
  title="Safe Water Solutions"
  description1="Your primary text content"
  description2="Additional details"
  buttonText="Learn More"
  buttonLink="/about"
  imageSrc="assets/images/resource/about-1.png"
/>
```

## 🌍 Navigation Structure

- **Home** (`/`) - Landing page with hero, features, about, services
- **About** (`/about`) - Company information and mission
- **Services** (`/services`) - Service offerings and process
- **Contact** (`/contact`) - Contact form and business information
- **Service Details** (`/service/:serviceId`) - Individual service pages
- **Shop** (`/shop`) - Product catalog (placeholder)
- **Blog** (`/blog`) - Blog/news section (placeholder)

## 🎨 Customization

### Styling
- Modify `/public/assets/css/style.css` for global styles
- Use Bootstrap classes for responsive design
- Add custom CSS in `/src/styles/` directory

### Colors
The template uses a professional blue/aqua color scheme defined in `/public/assets/css/color.css`

### Components
All components accept props for customization:
- Text content
- Images
- Links
- Styling classes
- Layout options

## 📧 Contact Integration

The contact form includes:
- Name, email, phone, subject, message fields
- Form validation
- Responsive design
- Professional styling

## 🔗 Dependencies

- **React 19.1.1** - UI library
- **React Router DOM** - SPA routing
- **Vite** - Build tool and dev server
- **Tailwind CSS** - Utility-first CSS (additional)
- **Bootstrap** - CSS framework (from template)
- **FontAwesome** - Icon library (from template)

## 📝 Development Notes

- All original Acuasafe assets are preserved in `/public/assets/`
- Components are designed to be reusable and configurable
- React Router provides smooth SPA navigation
- Mobile-first responsive design maintained
- SEO-friendly structure with proper meta tags

## 🚀 Production Deployment

1. Build the application:
   ```bash
   npm run build
   ```

2. Deploy the `dist` folder to your web server

3. Configure server to handle SPA routing (redirect all routes to index.html)

---

**Built with ❤️ using React and the Acuasafe HTML template**+ Vite

This template provides a minimal setup to get React working in Vite with HMR and some ESLint rules.

Currently, two official plugins are available:

- [@vitejs/plugin-react](https://github.com/vitejs/vite-plugin-react/blob/main/packages/plugin-react) uses [Babel](https://babeljs.io/) for Fast Refresh
- [@vitejs/plugin-react-swc](https://github.com/vitejs/vite-plugin-react/blob/main/packages/plugin-react-swc) uses [SWC](https://swc.rs/) for Fast Refresh

## Expanding the ESLint configuration

If you are developing a production application, we recommend using TypeScript with type-aware lint rules enabled. Check out the [TS template](https://github.com/vitejs/vite/tree/main/packages/create-vite/template-react-ts) for information on how to integrate TypeScript and [`typescript-eslint`](https://typescript-eslint.io) in your project.
