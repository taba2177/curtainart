import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import angular from "@analogjs/vite-plugin-angular";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/css/app.css",
                "resources/js/app.js",
                "vendor/taba/crm/src/resources/css/admin.css",
                "resources/angular/main.ts",
            ],
            refresh: true,
        }),
        angular(),
    ],
    resolve: {
        alias: {
            "@": "/resources/angular",
        },
    },
});
