var pricechange = function(config) {
	config = config || {};
	pricechange.superclass.constructor.call(this,config);
};
Ext.extend(pricechange,Ext.Component,{
	page:{},window:{},grid:{},tree:{},panel:{},combo:{},config: {},view: {}, utils: {}
});
Ext.reg('pricechange', pricechange);

pricechange = new pricechange();