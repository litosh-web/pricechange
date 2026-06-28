pricechange.panel.Home = function (config) {

    //var data = pricechange.data;

    config = config || {};
    Ext.apply(config, {
            border: false,
            baseCls: 'modx-formpanel',
            cls: 'container',
            layout: 'anchor',
            items: [{
                html: '<h2>' + _('pricechange') + '</h2>',
                border: false,
                cls: 'modx-page-header'
            }, {
                xtype: 'modx-tabs',
                defaults: {border: false, autoHeight: true},
                border: true,
                stateful: true,
                stateId: 'pricechange-panel-home',
                stateEvents: ['tabchange'],
                getState: function () {
                    return {activeTab: this.items.indexOf(this.getActiveTab())};
                },
                hideMode: 'offsets',
                items: [{
                    title: _('settings'),
                    layout: 'column',
                    items: [{
                        layout: 'form',
                        columnWidth: .5,
                        items: [{
                            layout: 'form',
                            xtype: 'form',
                            id: 'pricechange-form-settings',
                            labelAlign: 'top',
                            cls: 'main-wrapper',
                            listeners: {
                                afterrender: {
                                    fn: function (c) {
                                        c.getForm().setValues(pricechange.data);
                                    }, scope: this
                                },
                            },
                            items: [{
                                xtype: 'hidden',
                                name: 'id',
                                //value: data.id
                            }, {
                                hiddenName: 'type',
                                fieldLabel: _('pricechange_type'),
                                xtype: 'modx-combo',
                                mode: 'local',
                                anchor: '100%',
                                store: new Ext.data.ArrayStore({
                                    fields: ['id', 'name'],
                                    data: [
                                        ["ms", _('pricechange_type_ms')],
                                        ["tv", _('pricechange_type_tv')],
                                    ],
                                }),
                                listeners: {
                                    select: this.initType,
                                    afterrender: this.initType,
                                }
                                //value: data.skip_first,
                            }, {
                                id: 'tv_block',
                                hidden: true,
                                layout: 'form',
                                items: [{
                                    fieldLabel: _('pricechange_tv_name'),
                                    anchor: '100%',
                                    xtype: 'textfield',
                                    name: 'tv_name'
                                }]
                            }, {
                                name: 'scope',
                                anchor: '100%',
                                fieldLabel: _('pricechange_scope'),
                                xtype: 'numberfield',
                            }, {
                                xtype: 'label',
                                text: _('pricechange_scope_desc'),
                                cls: 'desc-under'
                            },]
                        }]

                    }, {
                        layout: 'form',
                        columnWidth: .5,
                        title: _('pricechange_categories'),
                        style: 'margin-top: 30px; margin-bottom: 30px;',
                        items: [{
                            xtype: 'pricechange-tree-categories'
                        }]
                    }]
                }]
            }]
        }
    )
    ;
    pricechange.panel.Home.superclass.constructor.call(this, config);
}
;
Ext.extend(pricechange.panel.Home, MODx.Panel, {
    initType: function (c) {
        var v = c.getValue();
        var b = Ext.getCmp('tv_block');

        switch (v) {
            default:
                b.setVisible(false);
                break;
            case 'tv':
                b.setVisible(true);
                break;
        }
    }
});
Ext.reg('pricechange-panel-home', pricechange.panel.Home);