const mailTemplateClass = function () {
    this.initAce = function () {
        const textarea = $('#mailtemplate-template');
        const editor = ace.edit("mail-template-editor");
        editor.setTheme("ace/theme/dracula");
        editor.getSession().setMode({path: "ace/mode/twig", inline: true});
        editor.getSession().on("change", function () {
            textarea.val(editor.getSession().getValue());
        });
        editor.getSession().setValue(textarea.val());
    };
};

const mailTemplate = new mailTemplateClass();
mailTemplate.initAce();