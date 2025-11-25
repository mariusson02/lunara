const fs = require("fs");
const esbuild = require("esbuild");

async function hotReload() {

    const bundlesPath = "public/assets/js/build";
    const distPath = "public/assets/js/dist";

    const filesToBuild = fs.readdirSync(bundlesPath, { withFileTypes: true});

    for (const file of filesToBuild) {
        const source = bundlesPath + "/" + file.name;
        const dest = distPath + "/" + file.name;

        const ctx = await esbuild.context({
            entryPoints: [source],
            bundle: true,
            outfile: dest,
            minify: true,
            format: "esm"
        });
        await ctx.rebuild();

        fs.watch(source, async () => {
            console.log(`File change detected in ${source}, rebuilding...`);
            try {
                await ctx.rebuild();
                console.log(`Rebuilt ${source} successfully.`);
            } catch (error) {
                console.error(`Error rebuilding ${source}:`, error);
            }
        });

        console.log(`Watching for changes in ${source}...`);
    }
}

hotReload().catch((error) => {
    console.error("Error while setting up watch mode:", error);
});