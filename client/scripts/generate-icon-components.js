const { generateFromFolder } = require('svg-to-svelte');

(async () => {
  await generateFromFolder('./svgIcons', 'src/components/icons', {
    clean: true,
  });
})();
