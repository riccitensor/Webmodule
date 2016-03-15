<script type="text/javascript" src="/engine/lib/tinymce/tinymce.min.js"></script>
<script type="text/javascript">
tinymce.init({
        menubar:false,
        statusbar: false,
        force_p_newlines : false,
        forced_root_block : "",
        force_br_newlines : true,
        
//                content_css : "css/custom_content.css",
//        theme_advanced_font_sizes: "10px,12px,13px,14px,16px,18px,20px",
//        font_size_style_values : "10px,12px,13px,14px,16px,18px,20px",

        fontsize_formats: "8pt 9pt 10pt 11pt 12pt 14pt 16pt 18pt 20pt 22pt 24pt 26pt 36pt",
        
         theme: 'modern',
        toolbar: "undo redo pastetext | bold | italic | underline | styleselect | fontselect | fontsizeselect | link image",
        
        language: "pl",
        selector: "textarea",
        plugins: [
            "link image"
        ]
});</script>

<!--
<form method="post" action="somepage">
    <textarea name="content" style="width:100%"></textarea>
</form>-->


<!--,
        
        plugins: [
                "advlist autolink autosave link image lists charmap print preview hr anchor pagebreak spellchecker",
                "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                "table contextmenu directionality emoticons template textcolor paste fullpage textcolor"
        ],

        toolbar1: "newdocument fullpage | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | styleselect formatselect fontselect fontsizeselect",
      
        menubar: false,
        toolbar_items_size: 'small',

        

        templates: [
                {title: 'Test template 1', content: 'Test 1'},
                {title: 'Test template 2', content: 'Test 2'}
        ]-->