(function (blocks, element, components, blockEditors) {
    var el = element.createElement;
    var InspectorControls = blockEditors.InspectorControls;
    var PanelBody = components.PanelBody;
    var SelectControl = components.SelectControl;
    var TextControl = components.TextControl;

    blocks.registerBlockType('custom/top-5-blog', {
        title: 'Top 5 custom blog',
        icon: 'admin-post',
        category: 'widgets',
        attributes: {
            orderBy: { type: 'string', default: 'date' },
            order: { type: 'string', default: 'DESC' },
            numberofPosts: { type: 'number', default: 5 }
        },

        edit: function (props) {
            var attrs = props.attributes;
            return el('div', {},
                el(
                    InspectorControls,
                    {},
                    el(
                        PanelBody,
                        { title: 'Block Settings' },
                        el(SelectControl, {
                            label: 'Order By',
                            value: attrs.orderBy,
                            options: [
                                { label: 'Name', value: 'name' },
                                { label: 'Publish Date', value: 'date' }
                            ],
                            onChange: function (val) {
                                props.setAttributes({ orderBy: val });
                            }
                        }),
                        el(SelectControl, {
                            label: 'Order',
                            value: attrs.order,
                            options: [
                                { label: 'ASC', value: 'ASC' },
                                { label: 'DESC', value: 'DESC' }
                            ],
                            onChange: function (val) {
                                props.setAttributes({ order: val });
                            }
                        }),
                        el(TextControl, {
                            label: 'Number of blogs to display',
                            type: 'number',
                            value: attrs.numberofPosts,
                            onChange: function (val) {
                                props.setAttributes({ numberofPosts: parseInt(val) || 1 });
                            }
                        })
                    )
                ),
                el('p', {}, 'Blog settings from sidebar')
            );
        },

        save: function () {
            return null;
        }
    });
})(
    window.wp.blocks,
    window.wp.element,
    window.wp.components,
    window.wp.blockEditor
);
