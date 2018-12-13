const mailTemplateClass = function () {
    this.init = function () {
        this.initAce();
        this.initDataField();
        this.initEvents();
    };
    this.initEvents = function () {
        //Открытие превью в модальном окне
        $(document).on('click', '.mail-template-preview', this.openPreview.bind(this));
        //Удаление шаблона
        $(document).on('click', '.mail-template-delete', this.templateDelete.bind(this));
    };
};
mailTemplateClass.prototype.initDataField = function () {
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
mailTemplateClass.prototype.initAce = function () {
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
//Открытие превью в модальном окне
mailTemplateClass.prototype.openPreview = function (e) {
    const self = $(e.target);
    $.post(self.attr('href'), self.parents('form').serialize()).done(function (result) {
        const iframe = document.createElement('iframe');
        iframe.src = 'data:text/html;charset=utf-8,' + encodeURI(result);
        iframe.classList.add('fancybox-iframe');
        $.fancybox.open(iframe, {
            baseClass: 'fancybox-container--mail-template-preview',
        });
        $('.fancybox-container--mail-template-preview .fancybox-content').width($(result).find('div:first').width());
    });
    return false;
};
//Удаление шаблона
mailTemplateClass.prototype.templateDelete = function () {
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
                    preConfirm: () => {
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
                // noinspection JSUnresolvedVariable
                const config = $.extend(defaultConfig, result.swalConfig);
                swal(config).then(function (result) {
                    if (result.status) {
                        window.location.reload();
                    }
                });
            }
        });
    }
    return false;
};