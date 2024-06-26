/* eslint-env node */
require('@rushstack/eslint-patch/modern-module-resolution')

module.exports = {
    root: true,
    'extends': [
        'plugin:vue/vue3-essential',
        'eslint:recommended',
        '@vue/eslint-config-typescript',
        '@vue/eslint-config-prettier/skip-formatting',
        "plugin:vue/recommended"
    ],
    parserOptions: {
        ecmaVersion: 'latest'
    },
    "rules": {
        "vue/html-self-closing": "off",

        // -------------------------------------
        // https://typescript-eslint.io/rules/no-unused-vars/
        // Note: you must disable the base rule as it can report incorrect errors
        "no-unused-vars": "off",
        "@typescript-eslint/no-unused-vars": "off", // "off"|"error"
        // -------------------------------------

        // https://eslint.vuejs.org/rules/attribute-hyphenation.html
        "vue/attribute-hyphenation": [
            "error", "always" | "never", {
            "ignore": [
                // "custom-prop",
            ]
        }],
        // ...
    }
}
