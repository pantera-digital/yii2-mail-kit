const mailTemplateClass = function () {
    this.init = function () {
        this.initAce();
        this.initEvents();
    };
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
    this.initEvents = function () {
        $(document).on('click', '.mail-template-preview', function () {
            const self = $(this);
            $.post(self.attr('href'), self.parents('form').serialize()).done(function (result) {
                const iframe = document.createElement('iframe');
                const html = result;
                iframe.src = 'data:text/html;charset=utf-8,' + encodeURI(html);
                iframe.classList.add('fancybox-iframe');
                iframe.width = '600px';
                iframe.height = '800px';
                $.fancybox.open(iframe, {
                    baseClass: 'fancybox-container__mail-template-preview',
                });
            });
            return false;
        });
    }
};

const mailTemplate = new mailTemplateClass();
mailTemplate.init();