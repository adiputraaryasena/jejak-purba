/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        'purba-dark': '#1A1C23',
        'purba-card': '#232530',
        'purba-gold': '#FFD166',
        'purba-green': '#10B981',
      }
    },
  },
  plugins: [],
}