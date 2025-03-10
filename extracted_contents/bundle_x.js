const { execSync } = require('child_process');
const packageJson = require('./package.json');

// const outputFileName = `${packageJson.name}-${packageJson.version}.zip`;
const outputFileName = `${packageJson.name}.zip`;
const excludes = `.DS_Store */.DS_Store */*/.DS_Store mix-manifest.json .git .gitattributes .github .editorconfig .gitignore README.md .php-cs-fixer.cache gulpfile.js composer.json composer.lock node_modules package-lock.json package.json webpack.mix.js src yarn.lock bundle.js phpcs.xml *.zip`;

const cmd = `npm run build && dir-archiver --src . --dest ./${outputFileName} --exclude ${excludes}`;
try {
	execSync(cmd);
	console.log(`Created zip file: ${outputFileName}`);
} catch (error) {
	console.error('Error creating zip file:', error);
	process.exit(1);
}
