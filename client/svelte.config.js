const sveltePreprocess = require('svelte-preprocess');

module.exports = {
  // Options for `svelte-check` and the VS Code extension
  preprocess: sveltePreprocess({ postcss: true }),
};
