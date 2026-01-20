/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./blocks/**/*.{php,html,js}",
    "./template-parts/**/*.php",
    "./templates/**/*.php",
    "./inc/**/*.php",
    "./functions.php",
    "./*.php",
  ],
  important: true,
  theme: {
    extend: {
      // Color System
      colors: {
        primary: {
          DEFAULT: '#0047AB',
          hover: '#003A8C',
          active: '#002E6E',
        },
        heading: '#1D2938',
        body: '#667085',
        muted: '#98A2B3',
        inverse: '#FFFFFF',
        bg: {
          page: '#FFFFFF',
          section: '#F2F4F7',
          dark: '#1D2939',
        },
        border: {
          DEFAULT: '#E4E7EC',
          strong: '#D0D5DD',
        },
      },
      // Typography
      fontFamily: {
        sans: ['Inter', 'system-ui', '-apple-system', 'BlinkMacSystemFont', 'Segoe UI', 'sans-serif'],
      },
      fontSize: {
        h1: ['48px', { lineHeight: '1.2', fontWeight: '700' }],
        h2: ['36px', { lineHeight: '1.2', fontWeight: '600' }],
        h3: ['28px', { lineHeight: '1.2', fontWeight: '600' }],
        h4: ['20px', { lineHeight: '1.2', fontWeight: '600' }],
        body: ['16px', { lineHeight: '1.5', fontWeight: '400' }],
        small: ['14px', { lineHeight: '1.5', fontWeight: '400' }],
      },
      // Layout & Spacing
      maxWidth: {
        container: '1280px',
      },
      padding: {
        container: '24px',
        'section-y': '96px',
        'section-y-small': '64px',
        card: '32px',
      },
      // Border Radius
      borderRadius: {
        card: '12px',
        button: '8px',
      },
    },
  },
  plugins: [],
};
