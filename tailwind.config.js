// import defaultTheme from 'tailwindcss/defaultTheme';
// import forms from '@tailwindcss/forms';

// /** @type {import('tailwindcss').Config} */
// export default {
//     content: [
//         './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
//         './storage/framework/views/*.php',
//         './resources/views/**/*.blade.php',
        
//     ],

//     theme: {
//         extend: {
//             fontFamily: {
//                 sans: ['Figtree', ...defaultTheme.fontFamily.sans],
//             },
//         },
//     },

//     plugins: [forms],
// };
import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            keyframes: {
                colorChange: {
                    '0%, 100%': { color: '#1F222C' }, // Negro
                    '33%': { color: '#C2C7CB' }, // Gris oscuro
                    '66%': { color: '#72F0B7' }, // Gris más claro
                },
            },
            animation: {
                colorChange: 'colorChange 6s ease-in-out infinite', // 6 segundos para mantener el cambio suave
            },
            colors: {
                peach: '#FFABAB', // Melocotón suave
                mint: '#B2F7EF',  // Verde menta
                lavender: '#C3B1E1', // Lavanda clara
                mustard: '#FFB319', // Amarillo mostaza
                turquoiseDark: '#17A2B8', // Turquesa oscuro
                emerald: '#FF5E00', // Verde esmeralda
                brickRed: '#D9534F', // Rojo ladrillo
            },
        },
    },

    plugins: [forms],
};



