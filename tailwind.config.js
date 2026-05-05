import defaultTheme from 'tailwindcss/defaultTheme';
// colors

import colors from 'tailwindcss/colors';

module.exports = {
    presets: [
        require('./vendor/taba/crm/tailwind-preset.js'),require("./vendor/taba/crm/tailwind-preset.js")],
    content: [
        "./app/Filament/**/*.php",
        "./resources/views/filament/**/*.blade.php",
        "./resources/views/**/*.blade.php",
        "./vendor/filament/**/*.blade.php",
        "./vendor/taba/crm/resources/views/**/*.blade.php",
    ],
    corePlugins: {
        visibility: false,
    },
    theme: {
        extend: {
            colors: {
                ...colors,
                // primary: {
                //     DEFAULT: "#151A25",
                //     dark: "#151A25",
                // },
                primary: colors.slate,
                secondary: colors.amber,
                background: {
                    light: "#F7F7F7",
                    dark: "#FFFFFF",
                },
                text: {
                    primary: "#3C3C3C",
                    secondary: "#5C5C5C",
                },
                divider: "#8C734466",
                error: "rgb(230, 87, 87)",
            },
            fontFamily: {
                sans: ["DM Sans", ...defaultTheme.fontFamily.sans],
                accent: ["Manrope", "sans-serif"],
            },
        },
    },
};
