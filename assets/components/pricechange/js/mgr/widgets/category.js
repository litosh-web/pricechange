pricechange.tree.Categories = function (config) {

    var id = Ext.getCmp('pricechange-form-settings').getForm().findField('id').getValue();

    config = config || {};
    Ext.applyIf(config, {
        url: pricechange.config.connectorUrl
        , id: 'pricechange-tree'
        , title: ''
        , anchor: '100%'
        , rootVisible: false
        , expandFirst: true
        , enableDD: false
        , ddGroup: 'modx-treedrop-dd'
        , remoteToolbar: false
        , action: 'mgr/category/getnodes'
        , tbarCfg: {id: config.id ? config.id + '-tbar' : 'modx-tree-resource-tbar'}
        , baseParams: {
            action: 'mgr/category/getnodes'
            // , currentResource: MODx.request.id || 0
            // , currentAction: MODx.request.a || 0
            // , preset: config.preset || 0
        }
        //,tbar: []
        , listeners: {
            checkchange: function (node, checked) {
                this.mask.show();
                var arr = [];
                var id = Ext.getCmp('pricechange-form-settings').getForm().findField('id').getValue();

                var selected = Ext.getCmp('pricechange-tree').getChecked();
                Ext.each(selected, function (r, i) {
                    arr.push(r.attributes.pk);
                });

                arr = JSON.stringify(arr);

                //console.log(arr);
                MODx.Ajax.request({
                    url: pricechange.config.connectorUrl
                    , params: {
                        action: 'mgr/category/category',
                        categories: arr,
                        id: id

                    }
                    , listeners: {
                        success: {
                            fn: function () {
                                this.mask.hide();
                            }, scope: this
                        }
                        , failure: {
                            fn: function () {
                                this.mask.hide();
                            }, scope: this
                        }
                    }
                });
            }
            , afterrender: function () {
                this.mask = new Ext.LoadMask(this.getEl());
            }
        }
    });
    pricechange.tree.Categories.superclass.constructor.call(this, config);
};
Ext.extend(pricechange.tree.Categories, MODx.tree.Tree, {});
Ext.reg('pricechange-tree-categories', pricechange.tree.Categories);