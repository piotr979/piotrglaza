/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./assets/**/*.js",
    "./templates/**/*.html.twig",
  ],
  theme: {
    fontFamily: {
      'mono': ['Roboto mono', 'ui-monospace', 'SFMono-Regular'],
      'sans': ['Rubik'],
    },
    extend: {
      colors: {
        'primary-background': '#BCB5A4',
        'primary-shade-1': '#A69D87',
        'secondary-background': '#646A5D',
        'admin-background': "#3C3A34",
        'main-dark': '#333333',
        'main-dark-tint-1': '#656565',
        'main-dark-tint-2': "#B2B3A2",
        'main-dark-tint-3': "#C3C4B3",
        'main-dark-shade-1': "#32322B",
        'main-light': "#CDCDCD",
        'button-primary': '#4F4444',
        'button-secondary': '#720D0D',
        'button-ternary': '#0D4D72',
      },
      boxShadow: {
        '3xl': '0px 8px 16px #9A9382',
        '4xl': '0px 12px 16px #787160'
      },
      zIndex: {
        '200': '200',
      }
    },
  },
  plugins: [],
}

