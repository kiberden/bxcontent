(function ($, document, window) {


    /**
     * Класс для сниппета.
     */
    var SnippetClass = function (type, settings, controlsFactory) {
        var self = this;
        var controls = [];

        //создаем контролы для текущего сниппета
        if (settings.controls) {
            for (var k in settings.controls) {
                if (!settings.controls.hasOwnProperty(k)) continue;
                var control = controlsFactory.createInstance(settings.controls[k]);
                if (control) {
                    controls.setParent(self);
                    controls.push(control);
                }
            }
        }

        self.settings = settings;
        self.settings.type = type;
        self.settings.controls = controls;

        self.getType = function () {
            return self.settings.type || '';
        };

        self.getLabel = function () {
            return self.settings.label || '';
        };

        self.getControls = function () {
            return self.settings.controls || [];
        };

        self.getName = function () {
            var parent = self.getParent();
            return parent.getName ? parent.getName() : '';
        };

        self.setValue = function (value) {
            if (!value) return;
            for (var k in self.settings.controls) {
                if (!self.settings.controls.hasOwnProperty(k)) continue;
                self.settings.controls[k].setValue(value[k] || null);
            }
        };

        self.setParent = function (parent) {
            self.parent = parent;
        };

        self.getParent = function () {
            return self.parent;
        };
    };


    /**
     * Коллекция из нескольких сниппетов.
     */
    var SnippetCollectionClass = function (name) {
        var self = this;

        self.snippets = [];

        self.addSnippet = function (snippet) {
            snippet.setParent(self);
            self.snippets.push(snippet);
        };

        self.setSnippets = function (newSnippets) {
            self.snippets = newSnippets;
        };

        self.getSnippets = function () {
            return self.snippets;
        };

        self.hasSnippet = function (snippet) {
            var hasSnippet = false;
            for (var k in self.snippets) {
                if (!self.snippets.hasOwnProperty(k)) continue;
                if (snippet === self.snippets[k]) {
                    hasSnippet = true;
                    break;
                }
            }
            return hasSnippet;
        };

        self.removeSnippet = function (snippet) {
            for (var k in self.snippets) {
                if (!self.snippets.hasOwnProperty(k)) continue;
                if (snippet === self.snippets[k]) {
                    delete self.snippets[k];
                    break;
                }
            }
        };

        self.getName = function () {
            return name;
        };
    };


    /**
     * Фабричный класс для создания новых объектов контролов.
     */
    var ControlFactoryClass = function () {
        var self = this;

        self.list = {};

        self.register = function (type, construct) {
            self.list[type] = construct;
        };

        self.createInstance = function (settings) {
            if (!settings.type || !self.list[settings.type]) return;
            return new self.list[settings.type](settings, self);
        };
    };


    /**
     * Фабричный класс для создания новых объектов сниппетов.
     */
    var SnippetFactoryClass = function (controlsFactory) {
        var self = this;

        self.list = {};
        self.controlsFactory = controlsFactory;

        self.register = function (type, settings) {
            self.list[type] = settings;
        };

        self.createInstance = function (type) {
            if (!self.list[type]) return;
            return new SnippetClass(type, self.list[type], self.controlsFactory);
        };

        self.getList = function () {
            return self.list;
        };
    };


    /**
     * Представление для блока сниппетов.
     */
    var SnippetCollectionViewClass = function ($domBlock, collection, snippetsFactory) {
        var self = this;

        self.domBlock = $($domBlock);
        self.collection = collection;
        self.snippetsFactory = snippetsFactory;

        self.getDomBlock = function () {
            return self.domBlock;
        };

        self.getCollection = function () {
            return self.collection;
        };

        self.getSnippetsFactory = function () {
            return self.snippetsFactory;
        };

        self.render = function () {
            self.renderSnippets();
            self.renderSelector();
        };

        self.renderSnippets = function () {
            var $snippetsBlock = self.domBlock.find('.marvin255bxcontent-snippets-block');
            if (!$snippetsBlock.length) {
                $snippetsBlock = $('<div class="marvin255bxcontent-snippets-block" />').appendTo(self.domBlock);
            }
            var snippets = self.getCollection().getSnippets();
            console.log('rendering snippets');
        };

        self.renderSelector = function () {
            var $selectorBlock = self.domBlock.find('.marvin255bxcontent-selector-block');
            if (!$selectorBlock.length) {
                $selectorBlock = $('<div class="marvin255bxcontent-selector-block" />').appendTo(self.domBlock);
            }

            var typesOptions = '<option value="">Выберите тип блока</option>';
            $.each(self.getSnippetsFactory().getList(), function (key, item) {
                typesOptions += '<option value="' + key + '">' + item.label + '</option>';
            });
            var $select = $selectorBlock.find('select');
            if (!$select.length) {
                $select = $('<select />').html(typesOptions).appendTo($selectorBlock);
            } else if ($select.html() !== typesOptions) {
                $select.html(typesOptions);
            }

            var $button = $selectorBlock.find('button');
            if (!$button.length) {
                $button = $('<button />').text('Добавить блок').appendTo($selectorBlock);
            }
            $button.off('click').on('click', function () {
                var type = $select.val();
                var snippet = self.getSnippetsFactory().createInstance(type);
                if (snippet) {
                    self.getCollection().addSnippet(snippet);
                    self.renderSnippets();
                }
                $select.val('');
                return false;
            });
        };

        self.destroy = function () {
            self.domBlock.empty().remove();
        };
    };


    /**
     * Инициируем объекты фабрики для сниппетов и контролов.
     */
    var controlsFactory = new ControlFactoryClass(),
        snippetsFactory = new SnippetFactoryClass(controlsFactory);


    /**
     * Методы jquery плагина.
     */
    var methods = {
        //добавляет новый тип контрола в фабричный объект контролов
        'registerControl': function (type, construct) {
            return controlsFactory.register(type, construct);
        },
        //добавляет новый тип сниппета в фабричный объект сниппетов
        'registerSnippet': function (type, settings) {
            return snippetsFactory.register(type, settings);
        },
        //инициирует плагин на выбранных элементах
        'init': function () {
            return this.filter('textarea').each(function (i) {
                var $textarea = $(this).hide();
                var $snippetsBlock = $('<div />').insertAfter($textarea);
                var collection = new SnippetCollectionClass($textarea.attr('name'));
                var view = new SnippetCollectionViewClass($snippetsBlock, collection, snippetsFactory);
                view.render();
                $textarea.data('marvin255bxcontent_viewer', view);
            });
        },
        //перестраивает представление для инициированного плагина
        'refresh': function () {
            return this.filter('textarea').each(function (i) {
                var $this = $(this);
                var view = $this.data('marvin255bxcontent_viewer');
                if (view) {
                    view.render();
                }
            });
        },
        //удаляет плагин
        'destroy': function () {
            return this.filter('textarea').each(function (i) {
                var $this = $(this);
                var view = $this.data('marvin255bxcontent_viewer');
                if (view) {
                    view.destroy();
                    $this.removeData('marvin255bxcontent_viewer');
                }
            });
        },
    };


    /**
     * Регистрация jquery плагина.
     */
    $.fn.marvin255bxcontent = function (method) {
        if (methods[method]) {
            return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
        } else if(typeof method === 'object' || !method) {
            return methods.init.apply(this, arguments);
        }
        return false;
    };


    /**
     * Подготовительные операции после загрузки всего dom.
     */
    $(document).on('ready', function () {
        //регистрируем типы сниппетов по умолчанию, если заданы
        if (window.marvin255bxcontent) {
            for (var k in window.marvin255bxcontent) {
                if (!window.marvin255bxcontent.hasOwnProperty(k)) continue;
                $.fn.marvin255bxcontent('registerSnippet', k, window.marvin255bxcontent[k]);
            }
        }
        //инициируем поля со сниппетами, у которых указан класс по умолчанию
        $('.marvin255bxcontent-init').marvin255bxcontent();
    });


})(jQuery, document, window);
