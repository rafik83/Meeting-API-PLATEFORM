const { generateFromFolder } = require('svg-to-svelte');

(async () => {
  await generateFromFolder('./icons-draft', 'src/ui-kit/icons', {
    clean: true,
  });
})();
