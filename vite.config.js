import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/css/app.css",
                "resources/css/instructor.css",
                "resources/js/app.js",
                "resources/js/inasistencias.js",
                "resources/js/fichas-show.js",
            ],
            refresh: true,
        }),
    ],
});
