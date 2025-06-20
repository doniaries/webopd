/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class', // or 'media' for OS-level dark mode
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./node_modules/flowbite/**/*.js"
    ],
    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/typography'),
        require('flowbite/plugin')
    ],
}
