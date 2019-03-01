var __ = wp.i18n.__;
var el = wp.element.createElement;
var registerBlockType = wp.blocks.registerBlockType;
const { SelectControl } = wp.components;
const { Fragment } = wp.element;
var adTitleList = ad_list['aic_ad_title'];
var selectData = [];

if(adTitleList){
    Object.keys(adTitleList).forEach(function(key) {
        selectData.push({ value: key, label: adTitleList[key] })
    });

    registerBlockType( 'aic/block', {
        title: __( 'Ads In Content', 'ads-in-content' ),
        description: __( 'You can add your ad codes in content easily', 'ads-in-content' ),
        icon: 'archive',
        category: 'widgets',
        attributes: {
            adKey: {
                type: 'string',
            },
        },

        edit({ attributes, setAttributes }) {
            if (!attributes.adKey) {
                setAttributes({adKey : selectData[0]['value']})
            }

            return (
                <SelectControl
                    label={ __( 'Select ad:', 'ads-in-content' ) }
                    value = { attributes.adKey}
                    onChange={ ( adKey ) => setAttributes( { adKey } ) }
                    options={ selectData }
                />
            );
        },

        save: function() {
            return null;
        }
    } );
}