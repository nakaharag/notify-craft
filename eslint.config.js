import vuePlugin from "eslint-plugin-vue";
import tsPlugin  from "@typescript-eslint/eslint-plugin";

export default [
    {
        files: ["*.ts", "*.tsx"],
        parserOptions: {
            project: "./tsconfig.json",
        },
        rules: {
            "@typescript-eslint/explicit-function-return-type": "error",
        },
    },
    {
        files: ["*.vue"],
        plugins: {
            vue: vuePlugin,
            "@typescript-eslint": tsPlugin
        },
        extends: ["plugin:vue/vue3-essential", "eslint:recommended"],
        rules: {
            "vue/no-unused-vars": "error",
        },
    },
];
