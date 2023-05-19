const path = require("path");
const miniCssExtractPlugin = require("mini-css-extract-plugin");

module.exports = {
    entry: "/src/assets/main.js",
    mode: "development",
    plugins: [new miniCssExtractPlugin()],
    output: {
        path: path.resolve(__dirname, "public/build"),
        filename: "main.js",
    },
    module: {
        rules: [
            {
                test: /\.(scss)$/,
                use: [
                    {
                        // loader: 'style-loader'
                        loader: miniCssExtractPlugin.loader,
                    },
                    {
                        loader: "css-loader",
                    },
                    {
                        loader: "postcss-loader",
                        options: {
                            postcssOptions: {
                                plugins: () => [require("autoprefixer")],
                            },
                        },
                    },
                    {
                        loader: "sass-loader",
                    },
                ],
            },
        ],
    },
};
