/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      fontFamily: {
        'gordita-light': ['gordita-light'],
        'gordita-regular': ['gordita-regular'],
        'gordita-ultra': ['gordita-ultra'],
        'poppins-light': ['poppins-light'],
        'poppins-regular': ['poppins-regular'],
        'poppins-ultra': ['poppins-ultra'],
      },
      colors: {
        raisin: {
          200: '#BFAEA9',
          500: '#69605D',
          900: '#221F1E',
        },
        upsdell: {
          200: '#FF2C32',
          500: '#D4242A',
          900: '#A41C20',
        },
        metallicGold: {
          200: '#FFD187',
          500: '#FFB643',
          900: '#DBA043',
        },
        minion: {
          200: '#FFEEA0',
          500: '#FFE572',
          900: '#F6D853',
        },
        isabelline: {
          900: '#F4F1EB',
        }
      }
    },
  },
  plugins: [],
}
