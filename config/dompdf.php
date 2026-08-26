<?php

return [
    /*
    |--------------------------------------------------------------------------
    | DOMPDF Configuration
    |--------------------------------------------------------------------------
    |
    | These options are the configuration for the DOMPDF library.
    |
    */

    'show_warnings' => false,   // Throw an Exception on warnings from DOMPDF
    'orientation' => 'portrait', // landscape or portrait
    'defines' => [
        /**
         * The location of the DOMPDF font directory.
         *
         * The location of the directory where DOMPDF will store fonts and font metrics
         * Note: This directory must be writable by the webserver process.
         */
        'font_dir' => storage_path('fonts/'),

        /**
         * The location of the DOMPDF font cache directory.
         *
         * This directory contains the cached font metrics that are used to speed up
         * the rendering of PDF files.
         */
        'font_cache' => storage_path('fonts/'),

        /**
         * The location of the temporary directory.
         *
         * This directory is used to store temporary files during the PDF generation process.
         */
        'temp_dir' => sys_get_temp_dir(),

        /**
         * The location of the DOMPDF font directory.
         *
         * The location of the directory where DOMPDF will look for fonts.
         */
        'font_height_ratio' => 1.1,

        /**
         * Enable remote file access.
         *
         * This option allows DOMPDF to access remote files (e.g. images, CSS files).
         * This is disabled by default for security reasons.
         */
        'enable_remote' => true,

        /**
         * Enable CSS float.
         *
         * This option enables the CSS float property.
         */
        'enable_css_float' => true,

        /**
         * Enable HTML5 parser.
         *
         * This option enables the HTML5 parser.
         */
        'enable_html5_parser' => true,

        /**
         * Enable PHP.
         *
         * This option enables the use of PHP in the HTML.
         */
        'enable_php' => false,

        /**
         * Enable inline JavaScript.
         *
         * This option enables the use of inline JavaScript in the HTML.
         */
        'enable_javascript' => true,

        /**
         * Enable smart shrinking.
         *
         * This option enables smart shrinking of the content to fit the page.
         */
        'enable_smart_shrinking' => true,

        /**
         * Enable native fonts.
         *
         * This option enables the use of native fonts.
         */
        'enable_native_fonts' => true,

        /**
         * Enable font subsetting.
         *
         * This option enables font subsetting, which reduces the size of the PDF file.
         */
        'enable_font_subsetting' => true,

        /**
         * Enable debug mode.
         *
         * This option enables debug mode, which outputs additional information.
         */
        'debug_png' => false,

        /**
         * Enable debug mode for CSS.
         *
         * This option enables debug mode for CSS, which outputs additional information.
         */
        'debug_css' => false,

        /**
         * Enable debug mode for layout.
         *
         * This option enables debug mode for layout, which outputs additional information.
         */
        'debug_layout' => false,

        /**
         * Enable debug mode for keep text.
         *
         * This option enables debug mode for keep text, which outputs additional information.
         */
        'debugKeepText' => true,

        /**
         * Enable debug mode for paragraph.
         *
         * This option enables debug mode for paragraph, which outputs additional information.
         */
        'debugParagraphs' => true,

        /**
         * Enable debug mode for tables.
         *
         * This option enables debug mode for tables, which outputs additional information.
         */
        'debugTables' => true,

        /**
         * Enable debug mode for line boxes.
         *
         * This option enables debug mode for line boxes, which outputs additional information.
         */
        'debugLineBoxes' => true,

        /**
         * Enable debug mode for inline.
         *
         * This option enables debug mode for inline, which outputs additional information.
         */
        'debugInline' => true,

        /**
         * Enable debug mode for block.
         *
         * This option enables debug mode for block, which outputs additional information.
         */
        'debugBlock' => true,

        /**
         * Enable debug mode for page break.
         *
         * This option enables debug mode for page break, which outputs additional information.
         */
        'debugPageBreak' => true,

        /**
         * Enable debug mode for layout.
         *
         * This option enables debug mode for layout, which outputs additional information.
         */
        'debugLayoutLines' => true,

        /**
         * Enable debug mode for layout boxes.
         *
         * This option enables debug mode for layout boxes, which outputs additional information.
         */
        'debugLayoutBoxes' => true,

        /**
         * Enable debug mode for layout blocks.
         *
         * This option enables debug mode for layout blocks, which outputs additional information.
         */
        'debugLayoutBlocks' => true,

        /**
         * Enable debug mode for layout inline.
         *
         * This option enables debug mode for layout inline, which outputs additional information.
         */
        'debugLayoutInline' => true,

        /**
         * Enable debug mode for layout table.
         *
         * This option enables debug mode for layout table, which outputs additional information.
         */
        'debugLayoutTable' => true,

        /**
         * Enable debug mode for layout cell.
         *
         * This option enables debug mode for layout cell, which outputs additional information.
         */
        'debugLayoutCell' => true,

        /**
         * Enable debug mode for layout list.
         *
         * This option enables debug mode for layout list, which outputs additional information.
         */
        'debugLayoutList' => true,

        /**
         * Enable debug mode for layout image.
         *
         * This option enables debug mode for layout image, which outputs additional information.
         */
        'debugLayoutImage' => true,

        /**
         * Enable debug mode for layout padding.
         *
         * This option enables debug mode for layout padding, which outputs additional information.
         */
        'debugLayoutPadding' => true,

        /**
         * Enable debug mode for layout border.
         *
         * This option enables debug mode for layout border, which outputs additional information.
         */
        'debugLayoutBorder' => true,

        /**
         * Enable debug mode for layout margin.
         *
         * This option enables debug mode for layout margin, which outputs additional information.
         */
        'debugLayoutMargin' => true,

        /**
         * Enable debug mode for layout background.
         *
         * This option enables debug mode for layout background, which outputs additional information.
         */
        'debugLayoutBackground' => true,

        /**
         * Enable debug mode for layout text.
         *
         * This option enables debug mode for layout text, which outputs additional information.
         */
        'debugLayoutText' => true,

        /**
         * Enable debug mode for layout font.
         *
         * This option enables debug mode for layout font, which outputs additional information.
         */
        'debugLayoutFont' => true,

        /**
         * Enable debug mode for layout color.
         *
         * This option enables debug mode for layout color, which outputs additional information.
         */
        'debugLayoutColor' => true,

        /**
         * Enable debug mode for layout border box.
         *
         * This option enables debug mode for layout border box, which outputs additional information.
         */
        'debugLayoutBorderBox' => true,

        /**
         * Enable debug mode for layout content box.
         *
         * This option enables debug mode for layout content box, which outputs additional information.
         */
        'debugLayoutContentBox' => true,

        /**
         * Enable debug mode for layout padding box.
         *
         * This option enables debug mode for layout padding box, which outputs additional information.
         */
        'debugLayoutPaddingBox' => true,

        /**
         * Enable debug mode for layout margin box.
         *
         * This option enables debug mode for layout margin box, which outputs additional information.
         */
        'debugLayoutMarginBox' => true,

        /**
         * Enable debug mode for layout clip.
         *
         * This option enables debug mode for layout clip, which outputs additional information.
         */
        'debugLayoutClip' => true,

        /**
         * Enable debug mode for layout overflow.
         *
         * This option enables debug mode for layout overflow, which outputs additional information.
         */
        'debugLayoutOverflow' => true,

        /**
         * Enable debug mode for layout visibility.
         *
         * This option enables debug mode for layout visibility, which outputs additional information.
         */
        'debugLayoutVisibility' => true,

        /**
         * Enable debug mode for layout z-index.
         *
         * This option enables debug mode for layout z-index, which outputs additional information.
         */
        'debugLayoutZIndex' => true,

        /**
         * Enable debug mode for layout position.
         *
         * This option enables debug mode for layout position, which outputs additional information.
         */
        'debugLayoutPosition' => true,

        /**
         * Enable debug mode for layout float.
         *
         * This option enables debug mode for layout float, which outputs additional information.
         */
        'debugLayoutFloat' => true,

        /**
         * Enable debug mode for layout clear.
         *
         * This option enables debug mode for layout clear, which outputs additional information.
         */
        'debugLayoutClear' => true,

        /**
         * Enable debug mode for layout display.
         *
         * This option enables debug mode for layout display, which outputs additional information.
         */
        'debugLayoutDisplay' => true,

        /**
         * Enable debug mode for layout white-space.
         *
         * This option enables debug mode for layout white-space, which outputs additional information.
         */
        'debugLayoutWhitespace' => true,

        /**
         * Enable debug mode for layout word-spacing.
         *
         * This option enables debug mode for layout word-spacing, which outputs additional information.
         */
        'debugLayoutWordSpacing' => true,

        /**
         * Enable debug mode for layout letter-spacing.
         *
         * This option enables debug mode for layout letter-spacing, which outputs additional information.
         */
        'debugLayoutLetterSpacing' => true,

        /**
         * Enable debug mode for layout text-transform.
         *
         * This option enables debug mode for layout text-transform, which outputs additional information.
         */
        'debugLayoutTextTransform' => true,

        /**
         * Enable debug mode for layout text-decoration.
         *
         * This option enables debug mode for layout text-decoration, which outputs additional information.
         */
        'debugLayoutTextDecoration' => true,

        /**
         * Enable debug mode for layout text-align.
         *
         * This option enables debug mode for layout text-align, which outputs additional information.
         */
        'debugLayoutTextAlign' => true,

        /**
         * Enable debug mode for layout vertical-align.
         *
         * This option enables debug mode for layout vertical-align, which outputs additional information.
         */
        'debugLayoutVerticalAlign' => true,

        /**
         * Enable debug mode for layout line-height.
         *
         * This option enables debug mode for layout line-height, which outputs additional information.
         */
        'debugLayoutLineHeight' => true,

        /**
         * Enable debug mode for layout font-size.
         *
         * This option enables debug mode for layout font-size, which outputs additional information.
         */
        'debugLayoutFontSize' => true,

        /**
         * Enable debug mode for layout font-weight.
         *
         * This option enables debug mode for layout font-weight, which outputs additional information.
         */
        'debugLayoutFontWeight' => true,

        /**
         * Enable debug mode for layout font-style.
         *
         * This option enables debug mode for layout font-style, which outputs additional information.
         */
        'debugLayoutFontStyle' => true,

        /**
         * Enable debug mode for layout font-family.
         *
         * This option enables debug mode for layout font-family, which outputs additional information.
         */
        'debugLayoutFontFamily' => true,

        /**
         * Enable debug mode for layout color.
         *
         * This option enables debug mode for layout color, which outputs additional information.
         */
        'debugLayoutColor' => true,

        /**
         * Enable debug mode for layout background-color.
         *
         * This option enables debug mode for layout background-color, which outputs additional information.
         */
        'debugLayoutBackgroundColor' => true,

        /**
         * Enable debug mode for layout background-image.
         *
         * This option enables debug mode for layout background-image, which outputs additional information.
         */
        'debugLayoutBackgroundImage' => true,

        /**
         * Enable debug mode for layout background-repeat.
         *
         * This option enables debug mode for layout background-repeat, which outputs additional information.
         */
        'debugLayoutBackgroundRepeat' => true,

        /**
         * Enable debug mode for layout background-position.
         *
         * This option enables debug mode for layout background-position, which outputs additional information.
         */
        'debugLayoutBackgroundPosition' => true,

        /**
         * Enable debug mode for layout background-attachment.
         *
         * This option enables debug mode for layout background-attachment, which outputs additional information.
         */
        'debugLayoutBackgroundAttachment' => true,

        /**
         * Enable debug mode for layout background-clip.
         *
         * This option enables debug mode for layout background-clip, which outputs additional information.
         */
        'debugLayoutBackgroundClip' => true,

        /**
         * Enable debug mode for layout background-origin.
         *
         * This option enables debug mode for layout background-origin, which outputs additional information.
         */
        'debugLayoutBackgroundOrigin' => true,

        /**
         * Enable debug mode for layout background-size.
         *
         * This option enables debug mode for layout background-size, which outputs additional information.
         */
        'debugLayoutBackgroundSize' => true,

        /**
         * Enable debug mode for layout border-width.
         *
         * This option enables debug mode for layout border-width, which outputs additional information.
         */
        'debugLayoutBorderWidth' => true,

        /**
         * Enable debug mode for layout border-style.
         *
         * This option enables debug mode for layout border-style, which outputs additional information.
         */
        'debugLayoutBorderStyle' => true,

        /**
         * Enable debug mode for layout border-color.
         *
         * This option enables debug mode for layout border-color, which outputs additional information.
         */
        'debugLayoutBorderColor' => true,

        /**
         * Enable debug mode for layout border-radius.
         *
         * This option enables debug mode for layout border-radius, which outputs additional information.
         */
        'debugLayoutBorderRadius' => true,

        /**
         * Enable debug mode for layout border-collapse.
         *
         * This option enables debug mode for layout border-collapse, which outputs additional information.
         */
        'debugLayoutBorderCollapse' => true,

        /**
         * Enable debug mode for layout border-spacing.
         *
         * This option enables debug mode for layout border-spacing, which outputs additional information.
         */
        'debugLayoutBorderSpacing' => true,

        /**
         * Enable debug mode for layout padding-top.
         *
         * This option enables debug mode for layout padding-top, which outputs additional information.
         */
        'debugLayoutPaddingTop' => true,

        /**
         * Enable debug mode for layout padding-right.
         *
         * This option enables debug mode for layout padding-right, which outputs additional information.
         */
        'debugLayoutPaddingRight' => true,

        /**
         * Enable debug mode for layout padding-bottom.
         *
         * This option enables debug mode for layout padding-bottom, which outputs additional information.
         */
        'debugLayoutPaddingBottom' => true,

        /**
         * Enable debug mode for layout padding-left.
         *
         * This option enables debug mode for layout padding-left, which outputs additional information.
         */
        'debugLayoutPaddingLeft' => true,

        /**
         * Enable debug mode for layout margin-top.
         *
         * This option enables debug mode for layout margin-top, which outputs additional information.
         */
        'debugLayoutMarginTop' => true,

        /**
         * Enable debug mode for layout margin-right.
         *
         * This option enables debug mode for layout margin-right, which outputs additional information.
         */
        'debugLayoutMarginRight' => true,

        /**
         * Enable debug mode for layout margin-bottom.
         *
         * This option enables debug mode for layout margin-bottom, which outputs additional information.
         */
        'debugLayoutMarginBottom' => true,

        /**
         * Enable debug mode for layout margin-left.
         *
         * This option enables debug mode for layout margin-left, which outputs additional information.
         */
        'debugLayoutMarginLeft' => true,

        /**
         * Enable debug mode for layout width.
         *
         * This option enables debug mode for layout width, which outputs additional information.
         */
        'debugLayoutWidth' => true,

        /**
         * Enable debug mode for layout height.
         *
         * This option enables debug mode for layout height, which outputs additional information.
         */
        'debugLayoutHeight' => true,

        /**
         * Enable debug mode for layout min-width.
         *
         * This option enables debug mode for layout min-width, which outputs additional information.
         */
        'debugLayoutMinWidth' => true,

        /**
         * Enable debug mode for layout max-width.
         *
         * This option enables debug mode for layout max-width, which outputs additional information.
         */
        'debugLayoutMaxWidth' => true,

        /**
         * Enable debug mode for layout min-height.
         *
         * This option enables debug mode for layout min-height, which outputs additional information.
         */
        'debugLayoutMinHeight' => true,

        /**
         * Enable debug mode for layout max-height.
         *
         * This option enables debug mode for layout max-height, which outputs additional information.
         */
        'debugLayoutMaxHeight' => true,

        /**
         * Enable debug mode for layout overflow.
         *
         * This option enables debug mode for layout overflow, which outputs additional information.
         */
        'debugLayoutOverflow' => true,

        /**
         * Enable debug mode for layout overflow-x.
         *
         * This option enables debug mode for layout overflow-x, which outputs additional information.
         */
        'debugLayoutOverflowX' => true,

        /**
         * Enable debug mode for layout overflow-y.
         *
         * This option enables debug mode for layout overflow-y, which outputs additional information.
         */
        'debugLayoutOverflowY' => true,

        /**
         * Enable debug mode for layout position.
         *
         * This option enables debug mode for layout position, which outputs additional information.
         */
        'debugLayoutPosition' => true,

        /**
         * Enable debug mode for layout top.
         *
         * This option enables debug mode for layout top, which outputs additional information.
         */
        'debugLayoutTop' => true,

        /**
         * Enable debug mode for layout right.
         *
         * This option enables debug mode for layout right, which outputs additional information.
         */
        'debugLayoutRight' => true,

        /**
         * Enable debug mode for layout bottom.
         *
         * This option enables debug mode for layout bottom, which outputs additional information.
         */
        'debugLayoutBottom' => true,

        /**
         * Enable debug mode for layout left.
         *
         * This option enables debug mode for layout left, which outputs additional information.
         */
        'debugLayoutLeft' => true,

        /**
         * Enable debug mode for layout z-index.
         *
         * This option enables debug mode for layout z-index, which outputs additional information.
         */
        'debugLayoutZIndex' => true,

        /**
         * Enable debug mode for layout float.
         *
         * This option enables debug mode for layout float, which outputs additional information.
         */
        'debugLayoutFloat' => true,

        /**
         * Enable debug mode for layout clear.
         *
         * This option enables debug mode for layout clear, which outputs additional information.
         */
        'debugLayoutClear' => true,

        /**
         * Enable debug mode for layout display.
         *
         * This option enables debug mode for layout display, which outputs additional information.
         */
        'debugLayoutDisplay' => true,

        /**
         * Enable debug mode for layout visibility.
         *
         * This option enables debug mode for layout visibility, which outputs additional information.
         */
        'debugLayoutVisibility' => true,

        /**
         * Enable debug mode for layout opacity.
         *
         * This option enables debug mode for layout opacity, which outputs additional information.
         */
        'debugLayoutOpacity' => true,

        /**
         * Enable debug mode for layout transform.
         *
         * This option enables debug mode for layout transform, which outputs additional information.
         */
        'debugLayoutTransform' => true,

        /**
         * Enable debug mode for layout transition.
         *
         * This option enables debug mode for layout transition, which outputs additional information.
         */
        'debugLayoutTransition' => true,

        /**
         * Enable debug mode for layout animation.
         *
         * This option enables debug mode for layout animation, which outputs additional information.
         */
        'debugLayoutAnimation' => true,

        /**
         * Enable debug mode for layout box-shadow.
         *
         * This option enables debug mode for layout box-shadow, which outputs additional information.
         */
        'debugLayoutBoxShadow' => true,

        /**
         * Enable debug mode for layout text-shadow.
         *
         * This option enables debug mode for layout text-shadow, which outputs additional information.
         */
        'debugLayoutTextShadow' => true,

        /**
         * Enable debug mode for layout filter.
         *
         * This option enables debug mode for layout filter, which outputs additional information.
         */
        'debugLayoutFilter' => true,

        /**
         * Enable debug mode for layout backdrop-filter.
         *
         * This option enables debug mode for layout backdrop-filter, which outputs additional information.
         */
        'debugLayoutBackdropFilter' => true,

        /**
         * Enable debug mode for layout mix-blend-mode.
         *
         * This option enables debug mode for layout mix-blend-mode, which outputs additional information.
         */
        'debugLayoutMixBlendMode' => true,

        /**
         * Enable debug mode for layout isolation.
         *
         * This option enables debug mode for layout isolation, which outputs additional information.
         */
        'debugLayoutIsolation' => true,

        /**
         * Enable debug mode for layout clip-path.
         *
         * This option enables debug mode for layout clip-path, which outputs additional information.
         */
        'debugLayoutClipPath' => true,

        /**
         * Enable debug mode for layout mask.
         *
         * This option enables debug mode for layout mask, which outputs additional information.
         */
        'debugLayoutMask' => true,

        /**
         * Enable debug mode for layout mask-image.
         *
         * This option enables debug mode for layout mask-image, which outputs additional information.
         */
        'debugLayoutMaskImage' => true,

        /**
         * Enable debug mode for layout mask-repeat.
         *
         * This option enables debug mode for layout mask-repeat, which outputs additional information.
         */
        'debugLayoutMaskRepeat' => true,

        /**
         * Enable debug mode for layout mask-position.
         *
         * This option enables debug mode for layout mask-position, which outputs additional information.
         */
        'debugLayoutMaskPosition' => true,

        /**
         * Enable debug mode for layout mask-size.
         *
         * This option enables debug mode for layout mask-size, which outputs additional information.
         */
        'debugLayoutMaskSize' => true,

        /**
         * Enable debug mode for layout mask-clip.
         *
         * This option enables debug mode for layout mask-clip, which outputs additional information.
         */
        'debugLayoutMaskClip' => true,

        /**
         * Enable debug mode for layout mask-origin.
         *
         * This option enables debug mode for layout mask-origin, which outputs additional information.
         */
        'debugLayoutMaskOrigin' => true,

        /**
         * Enable debug mode for layout mask-composite.
         *
         * This option enables debug mode for layout mask-composite, which outputs additional information.
         */
        'debugLayoutMaskComposite' => true,

        /**
         * Enable debug mode for layout mask-mode.
         *
         * This option enables debug mode for layout mask-mode, which outputs additional information.
         */
        'debugLayoutMaskMode' => true,

        /**
         * Enable debug mode for layout columns.
         *
         * This option enables debug mode for layout columns, which outputs additional information.
         */
        'debugLayoutColumns' => true,

        /**
         * Enable debug mode for layout column-width.
         *
         * This option enables debug mode for layout column-width, which outputs additional information.
         */
        'debugLayoutColumnWidth' => true,

        /**
         * Enable debug mode for layout column-count.
         *
         * This option enables debug mode for layout column-count, which outputs additional information.
         */
        'debugLayoutColumnCount' => true,

        /**
         * Enable debug mode for layout column-gap.
         *
         * This option enables debug mode for layout column-gap, which outputs additional information.
         */
        'debugLayoutColumnGap' => true,

        /**
         * Enable debug mode for layout column-rule.
         *
         * This option enables debug mode for layout column-rule, which outputs additional information.
         */
        'debugLayoutColumnRule' => true,

        /**
         * Enable debug mode for layout column-rule-width.
         *
         * This option enables debug mode for layout column-rule-width, which outputs additional information.
         */
        'debugLayoutColumnRuleWidth' => true,

        /**
         * Enable debug mode for layout column-rule-style.
         *
         * This option enables debug mode for layout column-rule-style, which outputs additional information.
         */
        'debugLayoutColumnRuleStyle' => true,

        /**
         * Enable debug mode for layout column-rule-color.
         *
         * This option enables debug mode for layout column-rule-color, which outputs additional information.
         */
        'debugLayoutColumnRuleColor' => true,

        /**
         * Enable debug mode for layout column-span.
         *
         * This option enables debug mode for layout column-span, which outputs additional information.
         */
        'debugLayoutColumnSpan' => true,

        /**
         * Enable debug mode for layout column-fill.
         *
         * This option enables debug mode for layout column-fill, which outputs additional information.
         */
        'debugLayoutColumnFill' => true,

        /**
         * Enable debug mode for layout break-before.
         *
         * This option enables debug mode for layout break-before, which outputs additional information.
         */
        'debugLayoutBreakBefore' => true,

        /**
         * Enable debug mode for layout break-after.
         *
         * This option enables debug mode for layout break-after, which outputs additional information.
         */
        'debugLayoutBreakAfter' => true,

        /**
         * Enable debug mode for layout break-inside.
         *
         * This option enables debug mode for layout break-inside, which outputs additional information.
         */
        'debugLayoutBreakInside' => true,

        /**
         * Enable debug mode for layout page-break-before.
         *
         * This option enables debug mode for layout page-break-before, which outputs additional information.
         */
        'debugLayoutPageBreakBefore' => true,

        /**
         * Enable debug mode for layout page-break-after.
         *
         * This option enables debug mode for layout page-break-after, which outputs additional information.
         */
        'debugLayoutPageBreakAfter' => true,

        /**
         * Enable debug mode for layout page-break-inside.
         *
         * This option enables debug mode for layout page-break-inside, which outputs additional information.
         */
        'debugLayoutPageBreakInside' => true,

        /**
         * Enable debug mode for layout orphans.
         *
         * This option enables debug mode for layout orphans, which outputs additional information.
         */
        'debugLayoutOrphans' => true,

        /**
         * Enable debug mode for layout widows.
         *
         * This option enables debug mode for layout widows, which outputs additional information.
         */
        'debugLayoutWidows' => true,
    ],
];
