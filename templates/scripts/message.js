'use strict';

var Toast = function (element, config) {
    var _this = this,
        _element = element,
        _config = {
            autohide: false,
            delay: 5000
        };

    for (var prop in config) {
        _config[prop] = config[prop];
    }

    Object.defineProperty(this, 'element', {
        get: function () {
            return _element;
        }
    });
    Object.defineProperty(this, 'config', {
        get: function () {
            return _config;
        }
    });

    _element.addEventListener('click', function (e) {
        if (e.target.classList.contains('toast__close')) {
            _this.hide();
        }
    });
}

Toast.prototype = {
    show: function () {
        var _this = this;
        this.element.classList.add('toast_show');
        if (this.config.autohide) {
            setTimeout(function () {
                _this.hide();
            }, this.config.delay)
        }
    },
    hide: function () {
        this.element.classList.remove('toast_show');
    }
};

Toast.create = function (header, body, color) {
    var
        fragment = document.createDocumentFragment(),
        toast = document.createElement('div'),
        toastHeader = document.createElement('div'),
        toastClose = document.createElement('button'),
        toastBody = document.createElement('div');
        toast.classList.add('toast');
        toast.style.backgroundColor = 'rgba(255, 255, 255, 0.5)';
        toastHeader.classList.add('toast__header');
        let classV = color + '-class';

        if (classV !== null) {
            toast.classList.add(classV);
            toastHeader.classList.add(classV);
        }

        toastHeader.classList.add('toast__header');
        toastHeader.classList.add('text');
        toastHeader.textContent = header;
        toastClose.classList.add('toast__close');
        toastClose.setAttribute('type', 'button');
        toastClose.textContent = '×';
        toastBody.classList.add('toast__body');
        toastBody.classList.add('text');
        toastBody.textContent = body;
        toastHeader.appendChild(toastClose);
        toast.appendChild(toastHeader);
        toast.appendChild(toastBody);
        fragment.appendChild(toast);
    return fragment;
};

Toast.add = function (params) {
    var config = {
        header: 'Название заголовка',
        body: 'Текст сообщения...',
        color: 'white',
        autohide: true,
        delay: 10000
    };
    if (params !== undefined) {
        for (var item in params) {
            config[item] = params[item];
        }
    }
    if (!document.querySelector('.toasts')) {
        var container = document.createElement('div');
        container.classList.add('toasts');
        container.style.cssText = 'position: fixed; bottom: 15px; right: 15px; width: 250px;';
        document.body.appendChild(container);
    }
    document.querySelector('.toasts').appendChild(Toast.create(config.header, config.body, config.color));
    var toasts = document.querySelectorAll('.toast');
    var toast = new Toast(toasts[toasts.length - 1], { autohide: config.autohide, delay: config.delay });
    toast.show();
    return toast;
}