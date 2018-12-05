const mailTemplateClass = function () {
    this.initAce = function () {
        const textarea = $('#mailtemplate-template');
        if (textarea.length) {
            const editor = ace.edit("mail-template-editor");
            editor.setTheme("ace/theme/dracula");
            editor.getSession().setMode({path: "ace/mode/twig", inline: true});
            editor.getSession().on("change", function () {
                textarea.val(editor.getSession().getValue());
            });
            editor.getSession().setValue(textarea.val());
        }
    };
    this.init = function () {
        this.initAce();
    };
};

const mailTemplate = new mailTemplateClass();
mailTemplate.init();