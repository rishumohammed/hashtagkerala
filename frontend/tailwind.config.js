export default {
  content: ['./index.html', './src/**/*.{vue,js,ts,jsx,tsx}'],
  theme: {
    extend: {
      colors: {
        brand: {
          primary: '#F99D1C',
          secondary: '#1A1A1A',
          surface: '#FAFAF9',
          accent: '#C5A059',
          ink: '#1A1A1A',
          mist: '#FFF7ED',
          leaf: '#FDFCFB',
          ocean: '#F1F5F9',
          line: '#E7E5E4',
        },
      },
      fontFamily: {
        heading: ['"Playfair Display"', 'ui-serif', 'Georgia', 'serif'],
        sans: ['Inter', 'ui-sans-serif', 'system-ui', 'sans-serif'],
      },
      borderRadius: {
        xl: '1rem',
        '2xl': '1.5rem',
        '3xl': '2rem',
      },
      boxShadow: {
        soft: '0 18px 45px -24px rgba(17, 24, 39, 0.22)',
        glass: '0 20px 60px -28px rgba(26, 26, 26, 0.18)',
        'glass-lg': '0 30px 80px -20px rgba(26, 26, 26, 0.3)',
      },
      letterSpacing: {
        widest: '0.28em',
      },
      backdropBlur: {
        xs: '2px',
      },
    },
  },
}
