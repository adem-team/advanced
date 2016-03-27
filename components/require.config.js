var components = {
    "packages": [
        {
            "name": "ui-select",
            "main": "ui-select-built.js"
        },
        {
            "name": "tinymce",
            "main": "tinymce-built.js"
        },
        {
            "name": "jquery",
            "main": "jquery-built.js"
        },
        {
            "name": "moment",
            "main": "moment-built.js"
        }
    ],
    "baseUrl": "components"
};
if (typeof require !== "undefined" && require.config) {
    require.config(components);
} else {
    var require = components;
}
if (typeof exports !== "undefined" && typeof module !== "undefined") {
    module.exports = components;
}