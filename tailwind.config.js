/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
        './vendor/filament/**/*.blade.php',
    ],
    theme: {
        extend: {
            colors: {
                primary: {
                    50: '#EFF6FF',
                    100: '#DBEAFE',
                    200: '#BFDBFE',
                    300: '#93C5FD',
                    400: '#60A5FA', 
                    500: '#2563EB', // Biru utama
                    600: '#1E40AF',
                    700: '#1E3A8A',
                    800: '#1E3A8A',
                    900: '#1E3A8A',
                },
                accent: {
                    500: '#F97316', // Oranye
                    600: '#EA580C',
                }
            }
        }
    },
    plugins: [],
}