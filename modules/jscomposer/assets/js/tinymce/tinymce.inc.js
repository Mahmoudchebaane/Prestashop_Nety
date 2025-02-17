function tinySetup(config) {

    if (!config)
        config = {};
    if (typeof config['editor_selector'] != 'undefined')
        config['selector'] = '.' + config['editor_selector'];
    default_config = {
        selector: ".rte",
        plugins: "colorpicker link image paste pagebreak table contextmenu filemanager table code media autoresize textcolor",
        toolbar1: "code,|,bold,italic,underline,strikethrough,|,alignleft,aligncenter,alignright,alignfull,formatselect,|,blockquote,colorpicker,pasteword,|,bullist,numlist,|,outdent,indent,|,link,unlink,|,cleanup,|,media,image",
        toolbar2: "",
        external_filemanager_path: ad + "/filemanager/",
        filemanager_title: "File manager",
        external_plugins: { "filemanager": ad + "/filemanager/plugin.min.js" },
        language: iso,
        skin: "prestashop",
        statusbar: false,
        relative_urls: false,
        convert_urls: false,
        forced_root_block: '',
        force_p_newlines: false,
        remove_linebreaks: false,
        force_br_newlines: true,
        remove_trailing_nbsp: false,
        verify_html: false,
        extended_valid_elements: "em[class|name|id],span[*],i[*],br[*],script[src|type|language]",
        menu: {
            edit: { title: 'Edit', items: 'undo redo | cut copy paste | selectall' },
            insert: { title: 'Insert', items: 'media image link | pagebreak' },
            view: { title: 'View', items: 'visualaid' },
            format: { title: 'Format', items: 'bold italic underline strikethrough superscript subscript | formats | removeformat' },
            table: { title: 'Table', items: 'inserttable tableprops deletetable | cell row column' },
            tools: { title: 'Tools', items: 'code' }
        }
    }
    $.each(default_config, function(index, el) {
        if (config[index] === undefined)
            config[index] = el;
    });
    tinyMCE.init(config);
};