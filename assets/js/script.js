const mailTemplateClass = function () {
    this.init = function () {
        this.initAce();
        this.initDataField()
        this.initEvents();
    };
    this.initAce = function () {
        const textarea = $('#mailtemplate-template');
        if (textarea.length) {
            const editor = ace.edit("mail-template-editor");
            editor.setOptions({
                fontSize: "10pt"
            });
            editor.setTheme("ace/theme/dracula");
            editor.getSession().setMode({path: "ace/mode/twig", inline: true});
            editor.getSession().on("change", function () {
                textarea.val(editor.getSession().getValue());
            });
            editor.getSession().setValue(textarea.val());
        }
    };
    this.initDataField = function () {
        const textarea = $('#mailtemplate-data');
        if (textarea.length) {
            const editor = ace.edit("mail-data-editor");
            editor.setOptions({
                fontSize: "10pt"
            });
            editor.setTheme("ace/theme/dracula");
            editor.getSession().setMode({path: "ace/mode/json", inline: true});
            editor.getSession().on("change", function () {
                textarea.val(editor.getSession().getValue());
            });
            editor.getSession().setValue(textarea.val());
        }
    };
    this.initEvents = function () {
        //Открытие превью в модальном окне
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
        //Удаление шаблона
        $(document).on('click', '.mail-template-delete', function () {
            const self = $(this);
            if (confirm(self.data('confirm-text'))) {
                $.post(self.attr('href')).always(function (result) {
                    if (result.status) {
                        window.location.reload();
                    } else {
                        const defaultConfig = {
                            html: result.message,
                            type: 'warning',
                            showCloseButton: true,
                            showCancelButton: true,
                            showLoaderOnConfirm: true,
                            cancelButtonColor: '#3085d6',
                            confirmButtonColor: '#d33',
                            preConfirm: (result) => {
                                return new Promise(function (resolve) {
                                    const data = {
                                        force: true,
                                    };
                                    return $.post(self.attr('href'), data, function (result) {
                                        resolve(result);
                                    });
                                });
                            },
                        };
                        const config = $.extend(defaultConfig, result.swalConfig);
                        swal(config).then(function(result){
                            if (result.status) {
                                window.location.reload();
                            }
                        });
                    }
                });
            }
            return false;
        });
    }
};

const mailTemplate = new mailTemplateClass();
mailTemplate.init();