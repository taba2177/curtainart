/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./src/**/*.{html,ts}",
  ],
  theme: {
    extend: {
      colors: {
        // Navy palette — used for dark surfaces (footer, hero overlay).
        // Kept as-is so dramatic dark sections still read; the brand blue
        // owns the accent highlights instead of gold.
        wood: {
          50: '#F1F3F6',
          100: '#E0E4EB',
          200: '#C2C9D6',
          300: '#9BA6B8',
          400: '#6F7E96',
          500: '#536179',
          600: '#3D4B63',
          700: '#2A3447',
          800: '#1E2533',
          900: '#151A25',
          950: '#0B1828',
        },
        // Brand accent — مصنع فن الستارة blue (#0074b3 used 185× on the
        // upstream WP site). Replaces the previous starter-template gold.
        accent: {
          DEFAULT: '#0074b3',
          hover: '#005a8e',
          light: '#E2F0FB',
        },
        surface: {
          DEFAULT: '#FFFFFF',
          dark: '#0B1828',
        }
      },
      fontFamily: {
        // Single Tajawal stack across all roles — matches curtainart.sa.
        // Amiri/Alexandria/Inter kept as fallback aliases only.
        serif: ['Tajawal', 'Amiri', 'serif'],
        sans: ['Tajawal', 'Alexandria', 'Inter', 'sans-serif'],
        display: ['Tajawal', 'sans-serif'],
      },
      animation: {
        'fade-in-up': 'fadeInUp 1.2s cubic-bezier(0.19, 1, 0.22, 1) forwards',
        'fade-in': 'fadeIn 1.5s ease-out forwards',
        'scale-in': 'scaleIn 1.5s cubic-bezier(0.19, 1, 0.22, 1) forwards',
        'slide-in-right': 'slideInRight 1s cubic-bezier(0.19, 1, 0.22, 1) forwards',
        'slide-in-left': 'slideInLeft 1s cubic-bezier(0.19, 1, 0.22, 1) forwards',
        'draw-line': 'drawLine 1.5s cubic-bezier(0.19, 1, 0.22, 1) forwards',
        'float': 'float 6s ease-in-out infinite',
        'pulse-glow': 'pulseGlow 3s ease-in-out infinite',
        'count-up': 'countUp 0.6s ease-out forwards',
        'marquee': 'marquee 30s linear infinite',
      },
      keyframes: {
        fadeInUp: {
          '0%': { opacity: '0', transform: 'translateY(40px)' },
          '100%': { opacity: '1', transform: 'translateY(0)' },
        },
        fadeIn: {
          '0%': { opacity: '0' },
          '100%': { opacity: '1' },
        },
        scaleIn: {
          '0%': { opacity: '0', transform: 'scale(1.05)' },
          '100%': { opacity: '1', transform: 'scale(1)' },
        },
        slideInRight: {
          '0%': { opacity: '0', transform: 'translateX(80px)' },
          '100%': { opacity: '1', transform: 'translateX(0)' },
        },
        slideInLeft: {
          '0%': { opacity: '0', transform: 'translateX(-80px)' },
          '100%': { opacity: '1', transform: 'translateX(0)' },
        },
        drawLine: {
          '0%': { width: '0%' },
          '100%': { width: '100%' },
        },
        float: {
          '0%, 100%': { transform: 'translateY(0)' },
          '50%': { transform: 'translateY(-12px)' },
        },
        pulseGlow: {
          // Brand-blue glow (was gold rgba(232,184,75,…))
          '0%, 100%': { boxShadow: '0 0 20px rgba(0, 116, 179, 0.20)' },
          '50%':      { boxShadow: '0 0 40px rgba(0, 116, 179, 0.50)' },
        },
        countUp: {
          '0%': { opacity: '0', transform: 'translateY(20px)' },
          '100%': { opacity: '1', transform: 'translateY(0)' },
        },
        marquee: {
          '0%': { transform: 'translateX(0)' },
          '100%': { transform: 'translateX(-50%)' },
        },
      },
      backgroundImage: {
        'noise': "url('/assets/noise.png')",
      }
    },
  },
  plugins: [],
}
