# Griffin Quartz Website

A clean, modern HTML/CSS/JS recreation of the Griffin Quartz Shopify website, ready for hosting on Cloudflare Pages.

## Project Structure

```
griffinquartz/
├── index.html          # Main homepage
├── styles.css          # All styling
├── script.js           # Countdown timer, mobile menu, forms
├── images/             # Add your images here (see below)
│   ├── hero-kitchen.jpg
│   ├── pink-kitchen.jpg
│   ├── project-1.jpg through project-7.jpg
│   ├── savings-kitchen.jpg
│   ├── explore-kitchen.jpg
│   ├── explore-outdoor.jpg
│   ├── explore-gallery.jpg
│   ├── waterfall-kitchen.jpg
│   ├── bathroom-ocean.jpg
│   ├── process-1.jpg through process-4.jpg
│   ├── cta-kitchen.jpg
│   ├── cta-bathroom.jpg
│   ├── cta-brands.jpg
│   ├── blog-1.jpg through blog-4.jpg
│   └── partners/
│       ├── cambria.png
│       ├── caesarstone.png
│       ├── compac.png
│       ├── viatera.png
│       ├── corian.png
│       └── silestone.png
└── README.md
```

## Setup Instructions

### 1. Add Your Images

The HTML references images that need to be added to the `images/` folder. You can:

**Option A: Download from your Shopify site**
1. Go to your Shopify admin → Settings → Files
2. Download all images
3. Place them in the `images/` folder with matching filenames

**Option B: Use browser developer tools**
1. Visit your live Shopify site
2. Right-click images → "Save image as"
3. Name them according to the structure above

**Option C: Extract from Shopify CDN**
Your Shopify images are hosted on URLs like:
```
https://griffinquartz.com/cdn/shop/files/[filename]
```

### 2. Local Testing

Open `index.html` in your browser to preview locally.

For proper testing with a local server:
```bash
# Using Python
python -m http.server 8000

# Using Node.js
npx serve
```

Then visit `http://localhost:8000`

### 3. Deploy to Cloudflare Pages

1. **Push to GitHub:**
   ```bash
   git init
   git add .
   git commit -m "Initial commit"
   git branch -M main
   git remote add origin https://github.com/YOUR_USERNAME/griffinquartz.git
   git push -u origin main
   ```

2. **Connect to Cloudflare Pages:**
   - Log in to Cloudflare dashboard
   - Go to Pages → Create a project
   - Connect your GitHub account
   - Select the `griffinquartz` repository
   - Build settings:
     - Framework preset: None
     - Build command: (leave empty)
     - Build output directory: `/` (root)
   - Click "Save and Deploy"

3. **Custom Domain (optional):**
   - In Cloudflare Pages, go to your project
   - Click "Custom domains"
   - Add `griffinquartz.com`
   - Update DNS records as instructed

## Features Included

- ✅ Fully responsive design (mobile, tablet, desktop)
- ✅ Sticky header with dropdown navigation
- ✅ Mobile hamburger menu
- ✅ Hero section with overlay
- ✅ Contact form (ready for backend integration)
- ✅ Countdown timer (auto-updates, configurable)
- ✅ Project gallery grid
- ✅ Customer reviews section
- ✅ Newsletter signup form
- ✅ Smooth scroll navigation
- ✅ Scroll animations on elements
- ✅ SEO-friendly meta tags

## Customization

### Colors
Edit the CSS variables in `styles.css`:
```css
:root {
    --color-primary: #1a1a1a;
    --color-accent: #c9a962;  /* Gold accent */
    /* ... */
}
```

### Fonts
The site uses:
- **Playfair Display** for headings
- **Inter** for body text

Loaded from Google Fonts in the HTML `<head>`.

### Countdown Timer
Edit in `script.js`:
```javascript
// Set end date to 30 days from now
const endDate = new Date();
endDate.setDate(endDate.getDate() + 30);
```

### Form Handling
Forms currently log to console. To connect to a backend:
1. Use Cloudflare Workers
2. Use a form service like Formspree or Netlify Forms
3. Connect to your own API

Example with Formspree:
```html
<form action="https://formspree.io/f/YOUR_FORM_ID" method="POST">
```

## Additional Pages Needed

The homepage links to these pages (create as needed):
- `our-services.html`
- `quartz-brands.html`
- `kitchen-bath.html`
- `commercial.html`
- `locations.html`
- `gallery.html`
- `contact.html`
- `about.html`
- Individual city pages (boca-raton.html, miami.html, etc.)
- Blog posts

## Browser Support

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Mobile browsers

## License

This code is created for Griffin Quartz. All content, images, and branding are property of Griffin Quartz.

---
Last deployment trigger: 2026-01-17

