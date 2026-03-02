# Himalayan Homestay Theme

**Version:** 1.0.0  
**Requires:** WordPress 6.0+, PHP 7.4+  
**Companion Plugin:** [Himalayan Homestay Bookings](../plugins/himalayan-homestay-bookings/)  
**License:** Proprietary  

A purpose-built WordPress theme for homestay and vacation rental businesses in the Himalayan region. Designed to work seamlessly with the Himalayan Homestay Bookings plugin for end-to-end property listing and reservation management.

---

## Features

### Design
- Modern, premium aesthetic with gradient overlays and micro-animations
- Fully responsive (desktop, tablet, mobile)
- GLightbox-powered image galleries
- Tailwind CSS integration for homestay pages
- Font Awesome 6.5 icon library
- Material Symbols for property amenity icons
- Custom login page styling (branded WP admin login)

### Template System

| Template | Purpose |
|----------|---------|
| `front-page.php` | Homepage with hero section, featured properties, testimonials |
| `archive-hhb_homestay.php` | Homestay listing grid with filters |
| `single-hhb_homestay.php` | Property detail page (gallery, amenities, map, reviews, booking widget) |
| `taxonomy-hhb_location.php` | Location-filtered property archive |
| `taxonomy-hhb_property_type.php` | Property type filtered archive |
| `page-become-a-host.php` | Host application form |
| `page-contact.php` | Contact page with form |
| `page-host-panel.php` | Host dashboard panel |
| `home.php` | Blog listing page |
| `single.php` | Blog post detail |
| `archive.php` | Blog archive |
| `search.php` | Search results |
| `404.php` | Custom 404 page |

### Template Parts

```
template-parts/
├── header/              # 7 header components (navigation, mobile menu, etc.)
├── footer/              # 5 footer components (columns, newsletter, social)
├── host-dashboard/      # 6 host panel components (listings, bookings, stats)
├── blog/                # Blog card layout
├── content.php          # Default content loop
├── content-single.php   # Single post layout
├── content-page.php     # Page layout
├── content-search.php   # Search result item
└── content-none.php     # No results found
```

### Navigation Menus
- **Primary Menu** — Main site navigation
- **Footer Menu 1** — First footer column links
- **Footer Menu 2** — Second footer column links
- **Footer: Discover** — Discover section links
- **Footer: Company** — Company info links
- **Footer: Support** — Support/help links

### Widgets
Custom widgets located in `inc/widgets/`:
- Newsletter subscription
- Contact information
- Social media links
- Recent posts
- And more (8 custom widget files)

### Customizer
Full WordPress Customizer integration (`inc/customizer/`):
- Homepage section controls
- Contact page settings
- Color and typography options
- AJAX-powered contact form handler

### Blog System
- Dedicated blog stylesheet (`assets/css/blog.css`)
- Blog sidebar with widget areas (`sidebar-blog.php`)
- Conditional asset loading (blog CSS only on blog pages)

---

## File Structure

```
himalayan-homestay/
├── assets/
│   ├── css/
│   │   ├── main.css              # Core styles
│   │   ├── responsive.css        # Breakpoints
│   │   └── blog.css              # Blog-specific styles
│   ├── js/                       # Frontend scripts
│   └── images/                   # Theme images
├── inc/
│   ├── customizer/               # WP Customizer sections (3 files)
│   ├── customizer-pages.php      # Homepage & Contact page settings
│   ├── helpers.php               # Utility functions
│   ├── widgets/                  # Custom widgets (8 files)
│   └── widgets.php               # Widget registration
├── template-parts/               # Reusable template components
├── functions.php                 # Theme setup, enqueues, hooks
├── style.css                     # Theme metadata
└── *.php                         # Page & archive templates
```

---

## Theme Support

The theme registers support for:
- `automatic-feed-links`
- `title-tag`
- `post-thumbnails`
- `custom-logo` (250×250, flexible)

---

## External Dependencies

| Library | Version | Usage |
|---------|---------|-------|
| Tailwind CSS | CDN (latest) | Homestay page layouts |
| GLightbox | 3.2.0 | Image gallery lightbox |
| Font Awesome | 6.5.1 | UI icons |
| Material Symbols | CDN | Property amenity icons |

---

## Setup

1. Upload the theme to `/wp-content/themes/himalayan-homestay/`
2. Activate from WP Admin → Appearance → Themes
3. Install and activate the **Himalayan Homestay Bookings** plugin
4. Configure menus via Appearance → Menus
5. Set up the homepage via Settings → Reading → "A static page"
6. Customize via Appearance → Customize

---

## Plugin Integration

This theme is designed to work with the **Himalayan Homestay Bookings** plugin which provides:
- Custom post type: `hhb_homestay`
- Taxonomies: `hhb_location`, `hhb_property_type`
- Booking widget on property pages
- Price calculation and availability checking
- Razorpay payment integration
- Guest reviews and ratings
- Host application processing

The theme provides the presentation layer while the plugin handles all business logic and data management.
