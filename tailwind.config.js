/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./assets/**/*.js",
    "./templates/**/*.html.twig",
  ],
  theme: {
    fontFamily: {
      'mono': ['Roboto mono', 'ui-monospace', 'SFMono-Regular'],
    },
    extend: {
      colors: {
        'primary-background': '#BCB5A4',
        'secondary-background': '#646A5D',
        'main-dark': '#333333',
        'main-dark-tint-1': '#656565',
        'main-light': "#CDCDCD",
        'button-primary': '#4F4444',
        'button-secondary': '#720D0D',
        'button-ternary': '#0D4D72',
      },
    },
  },
  plugins: [],
}

