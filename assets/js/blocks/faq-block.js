/* global wp */
const el = wp.element.createElement;
const { registerBlockType } = wp.blocks;
const { InnerBlocks, RichText, InspectorControls } = wp.blockEditor;
const { PanelBody, ToggleControl } = wp.components;

// 1. Parent Wrapper Block
registerBlockType('himalayanmart/faq', {
    title: 'Theme FAQ Wrapper',
    icon: 'editor-ul',
    category: 'himalayanmart-blocks',
    description: 'A wrapper container for HimalayanMart FAQ items.',
    supports: {
        align: ['wide', 'full']
    },
    edit: function(props) {
        return el('div', { className: props.className + ' hm-faq-wrapper mb-8' },
            el(InnerBlocks, {
                allowedBlocks: ['himalayanmart/faq-item'],
                template: [
                    ['himalayanmart/faq-item', {}]
                ]
            })
        );
    },
    save: function(props) {
        return el('div', { className: 'hm-faq-wrapper space-y-4 my-8' },
            el(InnerBlocks.Content, {})
        );
    }
});

// 2. Child FAQ Item Block
registerBlockType('himalayanmart/faq-item', {
    title: 'FAQ Question',
    parent: ['himalayanmart/faq'],
    icon: 'text',
    category: 'himalayanmart-blocks',
    description: 'A single open/close FAQ question and answer.',
    attributes: {
        question: {
            type: 'string',
            source: 'html',
            selector: '.hm-faq-question-text'
        },
        isOpenByDefault: {
            type: 'boolean',
            default: false
        }
    },
    edit: function(props) {
        const attributes = props.attributes;

        return el('div', { className: 'hm-faq-item-edit bg-white border border-[#f1f1f1] rounded-xl overflow-hidden mb-2' },
            
            // Inspector Controls
            el(InspectorControls, {},
                el(PanelBody, { title: 'FAQ Settings', initialOpen: true },
                    el(ToggleControl, {
                        label: 'Open by default',
                        checked: attributes.isOpenByDefault,
                        onChange: function(val) { props.setAttributes({ isOpenByDefault: val }); }
                    })
                )
            ),

            // Question Input matching Contact Page "summary"
            el('div', { className: 'flex items-center justify-between p-[18px_20px] font-bold text-[14px] text-[#1e293b] border-b border-dashed border-slate-100' },
                el(RichText, {
                    tagName: 'span',
                    className: 'hm-faq-question-text flex-1 outline-none',
                    placeholder: 'Type the FAQ question here...',
                    value: attributes.question,
                    onChange: function(content) { props.setAttributes({ question: content }); }
                }),
                el('span', { className: 'text-[20px] font-light text-[#94a3b8] ml-3' }, '+')
            ),
            
            // Answer InnerBlocks matching Contact Page
            el('div', { className: 'hm-faq-answer-edit p-[18px_20px] pt-4 text-[13px] text-[#64748b] bg-slate-50/30' },
                el(InnerBlocks, {
                    template: [ ['core/paragraph', { placeholder: 'Type the answer here...' }] ]
                })
            )
        );
    },
    save: function(props) {
        return el('details', { 
                className: 'hm-faq-item-block group bg-white border border-[#f1f1f1] rounded-xl overflow-hidden mb-2 transition-shadow duration-300 hover:shadow-[0_4px_12px_rgba(0,0,0,0.04)]',
                open: props.attributes.isOpenByDefault 
            },
            el('summary', { className: 'hm-faq-summary-block flex items-center justify-between p-[18px_20px] cursor-pointer list-none outline-none font-bold text-[14px] text-[#1e293b] select-none bg-white' },
                el('span', { className: 'hm-faq-question-text' }, props.attributes.question)
            ),
            el('div', { className: 'p-[0_20px_18px] text-[13px] text-[#64748b] leading-[1.7] prose prose-sm prose-slate max-w-none' },
                el(InnerBlocks.Content, {})
            )
        );
    }
});
