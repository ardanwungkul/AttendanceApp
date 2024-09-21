import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: "class",
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
            },
            colors: {
                "mineral-green": {
                    50: "#f5f8f6",
                    100: "#dee9e4",
                    200: "#bcd3c9",
                    300: "#93b5a8",
                    400: "#6c9586",
                    500: "#527a6c",
                    600: "#43655a",
                    700: "#364f47",
                    800: "#2e413c",
                    900: "#293833",
                    950: "#141f1b",
                },
            },
        },
    },

    plugins: [forms],
};
