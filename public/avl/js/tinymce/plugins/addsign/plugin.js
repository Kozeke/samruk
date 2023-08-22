tinymce.PluginManager.add('addsign', function(editor, url) {
    // Add a button that opens a window
    editor.addButton('addsign', {
        text: '♦',
        icon: false,
        onclick: function() {

            var values = [{text: '---', value: 0}];

            $.ajax({
                url: '/admin/ajax/uniform.ajax.class.php',
                type: 'post',
                async: false,
                dataType: 'json',
                data: {func: 'getSigns', id_element: id_element, lang: glob_LangSite},       
                success: function(data) {

                    if (!data.error) {

                        for (var i = 0; i < data.signs.length; i++) {
                             values.push({text: data.signs[i].title, value: data.signs[i].id});
                        };
                    }
                }
            });

            // Open window
            editor.windowManager.open({
                title: 'Указать знак отличия',
                body: [
                    {type: 'listbox', 
                        name: 'sign', 
                        label: 'Выберите из списка: ',
                        'values': values }
                ],
                onsubmit: function(e) {
                    // Insert content when the window form is submitted
                    editor.insertContent('<span data-sign="'+ e.data.sign+'">'+editor.selection.getContent({format : 'html'})+'</span>');
                }
            });
        }
    });
});