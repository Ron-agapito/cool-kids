import globals from "globals";
import pluginJs from "@eslint/js";


/** @type {import('eslint').Linter.Config[]} */
export default [
  {files: ["**/*.js"], languageOptions: {sourceType: "script"}},
	{languageOptions: { globals: { ...globals.browser, wp: "readonly", Alpine: "readonly" }}},

  pluginJs.configs.recommended,
];
