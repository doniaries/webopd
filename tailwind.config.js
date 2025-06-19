/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class', // or 'media' for OS-level dark mode
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Instrument Sans', 'ui-sans-serif', 'system-ui', 'sans-serif'],
            },
            colors: {
                // Custom colors for dark mode
                dark: {
                    primary: '#1a202c',
                    secondary: '#2d3748',
                    accent: '#4a5568',
                },
            },
        },
    },
    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/typography'),
    ],
}
