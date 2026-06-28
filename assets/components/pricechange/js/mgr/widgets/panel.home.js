pricechange.page.Home = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        baseParams: {
            url: pricechange.config.connectorUrl,
            action: 'mgr/settings/get'
        },
        components: [{
            xtype: 'pricechange-panel-home'

        }],
        buttons: this.getButtons(),
    });
    pricechange.page.Home.superclass.constructor.call(this, config);

    this.check();
};
Ext.extend(pricechange.page.Home, MODx.Component, {
    getButtons: function () {
        var buttons = [];

        buttons.push({
            text: '<i class="icon icon-play"></i> ' + _('pricechange_start'),
            handler: this.import,
            scope: this,
            keys: [{
                key: MODx.config.keymap_save || 's',
                ctrl: true,
                fn: this.save
            }]
        });

        buttons.push({
            text: _('pricechange_save_btn'),
            handler: this.save,
            cls: 'primary-button',
            scope: this,
            keys: [{
                key: MODx.config.keymap_save || 's',
                ctrl: true,
                fn: this.save
            }]
        });

        return buttons;
    },
    save: function () {
        var fp = Ext.getCmp('pricechange-form-settings');
        var form = fp.getForm();

        if (fp && form) {
            var params = fp.getForm().getValues();
            params['action'] = 'mgr/settings/save';

            fp.el.mask(_('saving'));
            MODx.Ajax.request({
                url: pricechange.config.connectorUrl,
                params: params,
                listeners: {
                    success: {
                        fn: function (r) {
                            fp.el.unmask();
                            MODx.msg.status({
                                title: _('pricechange_saved'),
                                message: _('pricechange_saved_desc'),
                                delay: 4
                            })
                        }, scope: this
                    },
                    failure: {
                        fn: function (r) {
                            Ext.each(r.data, function (error) {
                                form.findField(error.id).markInvalid(error.msg);
                            });
                            fp.el.unmask();
                        }, scope: this
                    },
                    scope: this
                }
            });
        }
    },

    check: function () {
        MODx.Ajax.request({
            url: pricechange.config.connectorUrl
            , params: {
                action: 'mgr/resources/check'
            }
            , listeners: {
                'success': {
                    fn: function (r) {
                        this.progress();
                    }, scope: this
                },
            }
        });
    },

    import: function () {

        MODx.Ajax.request({
            url: pricechange.config.connectorUrl
            , params: {
                action: 'mgr/resources/update'
            }
        });

        this.progress();
    },

    progress: function () {

        Ext.Msg.show({
            title: _('please_wait'),
            msg: _('pricechange_process'),
            progressText: _('pricechange_process_text'),
            progress: true
        });

        var interval_id = setInterval(function () {

            MODx.Ajax.request({
                url: pricechange.config.connectorUrl
                , params: {
                    action: 'mgr/resources/progress'
                }
                , listeners: {
                    'success': {
                        fn: function (r) {
                            Ext.MessageBox.updateProgress(0, r.current + " / " + r.total, _('pricechange_process'));

                            if (r.current === r.total) {
                                clearInterval(interval_id);
                                Ext.MessageBox.hide();
                                MODx.msg.alert(_('success'), _('pricechange_process_success'));
                            }
                        }, scope: this
                    },
                }
            });

        }, 1000);
    },


});
Ext.reg('pricechange-page-home', pricechange.page.Home);