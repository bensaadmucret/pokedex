/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
      './templates/**/*.html.twig',
      './assets/controllers/**/*.js',
      './src/Components/**/*.php',
  ],
  theme: {
      extend: {},
  },
  plugins: [
      require('@tailwindcss/forms'),
  ],
}