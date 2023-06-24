/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            colors: {
                primary: "#5c5c5c",
                "on-primary": "#fff",
            },
            letterSpacing: {
                widest2: "0.2em",
            },
        },
    },
    plugins: [require("@tailwindcss/forms")],
};
