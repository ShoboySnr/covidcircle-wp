/*
|-------------------------------------------------------------------------------
| Tailwind – The Utility-First CSS Framework
|-------------------------------------------------------------------------------
|
| Documentation at https://tailwindcss.com
|
*/

/**
 * Global Styles Plugin
 *
 * This plugin modifies Tailwind’s base styles using values from the theme.
 * https://tailwindcss.com/docs/adding-base-styles#using-a-plugin
 */
const globalStyles = ({ addBase, config }) => {
  addBase({
    body: {
      fontFamily: 'Poppins',
      overflowX: 'hidden',
      color: '#222',
    },
    a: {
      color: config('theme.textColor.primary'),
      textDecoration: 'none',
      borderBottom: 'none',
      transition: '0.2s ease',
    },
    'a:hover': {
      color: config('theme.textColor.primary'),
    },
    p: {
      marginBottom: 0,
      lineHeight: '1.5',
    },
    'h1, h2, h3, h4, h5': {
      marginBottom: config('theme.margin.0'),
      lineHeight: config('theme.lineHeight.tight'),
    },
    'h1, h2, h3, h4, h5, h6, b, strong': {
      fontWeight: 'bold',
    },
    h1: { fontSize: config('theme.fontSize.5xl') },
    h2: { fontSize: config('theme.fontSize.4xl') },
    h3: { fontSize: config('theme.fontSize.3xl') },
    h4: { fontSize: config('theme.fontSize.2xl') },
    h5: { fontSize: config('theme.fontSize.xl') },
    'ol, ul': { paddingLeft: '0' },
    ol: { listStyleType: 'decimal' },
    ul: { listStyleType: 'disc' },
    '.primary-link': {
      color: config('theme.textColor.purple'),
      width: 'max-content',
      backgroundColor: 'none',
      fontWeight: '700',
      lineHeight: '1.25rem',
      fontSize: '1.25rem',
      letterSpacing: '0.3px',
      display: 'flex',
      alignContent: 'center',
      alignItems: 'center',
    },
    '.select-control': {
      fontSize: '1.125rem',
      padding: '1.25rem 3.125rem 1.25rem 0.625rem',
      lineHeight: '1.5',
      fontWeight: '400',
      appearance: 'none',
      background: 'url(data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMTMiIHZpZXdCb3g9IjAgMCAyMCAxMyIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHBhdGggZD0iTTE4LjUwNTkgMkwxMC41NTE4IDEwTDEuOTg1ODMgMiIgc3Ryb2tlPSJibGFjayIgc3Ryb2tlLXdpZHRoPSIzIi8+Cjwvc3ZnPgo=) 95%/11px no-repeat #edf2f7',
    },
    '.select-control:focus': {
      outline: 'none',
    },
    'button:focus': {
      outline: 'none',
    },
    '.primary-link span': {
      borderBottom: '2px solid',
      borderBottomColor: config('theme.textColor.purple'),
      paddingBottom: '3px',
    },
    '.primary-link svg': {
      marginLeft: '0.937rem',
    },
    '.primary-button:hover': {
      color: config('theme.textColor.primary'),
    },
    '.primary-link:hover span': {
      borderBottomColor: config('theme.textColor.primary'),
    },
    '.primary-link:hover svg path': {
      fill: config('theme.textColor.primary'),
      stroke: config('theme.textColor.primary'),
    },
    '.secondary-button': {
      color: config('theme.textColor.primary'),
    },
    '.secondary-button:hover': {
      color: config('theme.textColor.black'),
    },
  });
}

/**
 * Configuration
 */
module.exports = {
  theme: {
    colors: {
      primary: '#00b5b4',
      black: '#000',
      white: '#fff',
      purple: '#071d6f',
      yellow: '#ffba07',
      gray: {
        100: '#f7fafc',
        200: '#edf2f7',
        300: '#e2e8f0',
        400: '#cbd5e0',
        500: '#a0aec0',
        600: '#718096',
        700: '#4a5568',
        800: '#2d3748',
        900: '#1a202c',
      },
      grey: '#f7f7f7',
      transparent: 'transparent',
    },
    shadows: {
      outline: '0 0 0 3px rgba(82,93,220,0.3)',
    },
    extend: {
      screens: {
        light: { raw: '(prefers-color-scheme: light)' },
        dark: { raw: '(prefers-color-scheme: dark)' },
      },
    },
    container: {
      center: true,
      padding: '1rem',
    },
  },
  variants: {
    // Define variants
  },
  darkMode: 'class',
  plugins: [
    globalStyles,
    function({ addBase, config }) {
      addBase({
        body: {
          color: config('theme.colors.black'),
          backgroundColor: config('theme.colors.white'),
        },
      });
    },
  ],
}
