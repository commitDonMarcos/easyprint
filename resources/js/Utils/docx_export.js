import {
    Document,
    Packer,
    Paragraph,
    TextRun,
    Table,
    TableRow,
    TableCell,
    WidthType,
    AlignmentType,
    VerticalAlign,
    ImageRun,
    BorderStyle,
    ShadingType,
    HeightRule,
    convertInchesToTwip
} from 'docx';
import { saveAs } from 'file-saver';

// ─── Helpers ────────────────────────────────────────────────────────────────

/**
 * Load a URL and return { data: ArrayBuffer, width: px, height: px } pre-scaled to the target height.
 * This draws the image to a canvas first, which strips any print/custom DPI metadata
 * and ensures it exports at exactly the correct aspect ratio and target height in Word.
 */
async function getImage(url, targetHeight) {
    if (!url) return null;
    try {
        const img = await new Promise((resolve, reject) => {
            const i = new Image();
            i.crossOrigin = 'anonymous'; // Handle potential CORS issues gracefully
            i.onload = () => resolve(i);
            i.onerror = () => reject(new Error(`Failed to load image: ${url}`));
            i.src = url;
        });

        const naturalWidth = img.naturalWidth;
        const naturalHeight = img.naturalHeight;
        if (!naturalWidth || !naturalHeight) return null;

        const ratio = naturalWidth / naturalHeight;
        
        // Use 4x multiplier for high-DPI resolution rendering
        const scaleFactor = 4;
        const displayW = Math.round(targetHeight * ratio);
        const displayH = targetHeight;
        
        const canvasW = displayW * scaleFactor;
        const canvasH = displayH * scaleFactor;

        // Render to high-resolution canvas to resize and strip custom DPI metadata (forces clean 96 DPI output)
        const canvas = document.createElement('canvas');
        canvas.width = canvasW;
        canvas.height = canvasH;
        const ctx = canvas.getContext('2d');
        
        // Enable high-quality image smoothing
        ctx.imageSmoothingEnabled = true;
        ctx.imageSmoothingQuality = 'high';
        
        ctx.drawImage(img, 0, 0, canvasW, canvasH);

        const dataUrl = canvas.toDataURL('image/png');
        const base64Data = dataUrl.split(',')[1];
        const binaryString = window.atob(base64Data);
        const len = binaryString.length;
        const bytes = new Uint8Array(len);
        for (let i = 0; i < len; i++) {
            bytes[i] = binaryString.charCodeAt(i);
        }

        // Return the display size for layout but the binary contains high-resolution pixel data
        return { data: bytes.buffer, width: displayW, height: displayH };
    } catch (e) {
        console.error('DOCX – failed to load image:', url, e);
        return null;
    }
}

/**
 * Apply a CSS text-transform value to a plain string.
 */
function applyTransform(text, transform) {
    if (!text) return '';
    switch (transform) {
        case 'uppercase':  return text.toUpperCase();
        case 'lowercase':  return text.toLowerCase();
        case 'capitalize': return text.toLowerCase().replace(/(?:^|\s)\S/g, c => c.toUpperCase());
        default:           return text;
    }
}

/**
 * Scale a logo (returns pre-computed dimensions if available).
 */
function scaledDimensions(logo, targetHeight = 80) {
    if (logo.width && logo.height && logo.width > 0 && logo.height > 0) {
        return { width: logo.width, height: logo.height };
    }
    return { width: targetHeight, height: targetHeight }; // fallback square
}

/** Invisible borders for table cells / tables. */
const noBorder = { style: BorderStyle.NONE, size: 0, color: 'auto' };
const noBorders = { top: noBorder, bottom: noBorder, left: noBorder, right: noBorder };
const noTableBorders = { ...noBorders, insideHorizontal: noBorder, insideVertical: noBorder };

// ─── Main export ────────────────────────────────────────────────────────────

export async function exportToDocx(settings, project) {
    const template  = project?.template ?? {};
    const slots     = template?.json_structure?.slots ?? {};
    const leftSlots  = slots.left  ?? [];
    const rightSlots = slots.right ?? [];

    // Pre-decode a 1x1 transparent PNG buffer to use as a spacer in Word inline text runs (prevents font descender spacing issues)
    const transparentPngBase64 = 'iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNkYAAAAAYAAjCB0C8AAAAASUVORK5CYII=';
    const binaryString = window.atob(transparentPngBase64);
    const len = binaryString.length;
    const bytes = new Uint8Array(len);
    for (let i = 0; i < len; i++) {
        bytes[i] = binaryString.charCodeAt(i);
    }
    const transparentPngBuffer = bytes.buffer;

    // Scale by 1.15 to match browser's visual proportions against Word's taller font height
    const logoTargetHeight = Math.round((settings.logoSize ?? 80) * 1.15);

    // ── Load logos ──
    const loadSlotLogos = async (slotList, prefix) => {
        const out = [];
        for (let i = 0; i < slotList.length; i++) {
            const url = settings.logos?.[`${prefix}_${i}`];
            const img = url ? await getImage(url, logoTargetHeight) : null;
            if (img) out.push(img);
        }
        return out;
    };

    const [leftLogos, rightLogos] = await Promise.all([
        loadSlotLogos(leftSlots,  'left'),
        loadSlotLogos(rightSlots, 'right'),
    ]);

    // ── Pre-compute content and column widths based on margins and logo sizes ──
    const effectiveMarginDxa = Math.max(144, Math.round((settings.margin ?? 20) * 15));
    const contentWidthDxa    = 11906 - 2 * effectiveMarginDxa;

    const divider = settings.divider;
    const spaceBeforeDxa = divider?.enabled ? Math.max(0, Math.round((divider.top ?? 20) * 15)) : 0;

    const hasVerticalDividers = (template?.json_structure?.vertical_dividers ?? false) && (settings.verticalDivider?.enabled ?? true);
    
    // Dynamic vertical divider width/color calculations via canvas
    let verticalDividerImage = null;
    let dividerWidthPt = 0;

    if (hasVerticalDividers) {
        const thinWidthPx = settings.verticalDivider?.thinWidth ?? 2;
        const thickWidthPx = settings.verticalDivider?.thickWidth ?? 5;
        const gapPx = settings.verticalDivider?.gap ?? 6;
        const thinDivColor = settings.verticalDivider?.thinColor || settings.verticalDivider?.color || settings.textColor || '#000000';
        const thickDivColor = settings.verticalDivider?.thickColor || settings.verticalDivider?.color || settings.textColor || '#000000';

        const scaleFactor = 4;
        
        // Incorporate a 24px left gap directly on the canvas if there are logos before it
        const leftGapPx = leftLogos.length > 0 ? 24 : 0;
        const displayW = leftGapPx + thinWidthPx + gapPx + thickWidthPx;
        const displayH = logoTargetHeight;

        const canvas = document.createElement('canvas');
        canvas.width = displayW * scaleFactor;
        canvas.height = displayH * scaleFactor;
        const ctx = canvas.getContext('2d');

        // Draw thin line scaled up
        ctx.fillStyle = thinDivColor;
        ctx.fillRect(leftGapPx * scaleFactor, 0, thinWidthPx * scaleFactor, displayH * scaleFactor);

        // Draw thick line scaled up
        ctx.fillStyle = thickDivColor;
        ctx.fillRect((leftGapPx + thinWidthPx + gapPx) * scaleFactor, 0, thickWidthPx * scaleFactor, displayH * scaleFactor);

        try {
            const dataUrl = canvas.toDataURL('image/png');
            const base64Data = dataUrl.split(',')[1];
            const binaryString = window.atob(base64Data);
            const len = binaryString.length;
            const bytes = new Uint8Array(len);
            for (let i = 0; i < len; i++) {
                bytes[i] = binaryString.charCodeAt(i);
            }

            verticalDividerImage = {
                data: bytes.buffer,
                width: displayW,
                height: displayH
            };
            
            // Width of divider in points
            dividerWidthPt = displayW * 0.75;
        } catch (e) {
            console.error('DOCX – failed to generate vertical divider image:', e);
        }
    }

    // Calculate exact width in points for left logos (1px = 0.75pt)
    let leftLogosWidthPt = 0;
    leftLogos.forEach((logo, idx) => {
        leftLogosWidthPt += logo.width * 0.75;
        if (idx > 0) {
            leftLogosWidthPt += 12; // gap between logos (16px * 0.75 = 12pt)
        }
    });

    if (hasVerticalDividers && verticalDividerImage) {
        leftLogosWidthPt += verticalDividerImage.width * 0.75;
    }

    if (leftLogos.length > 0 || (hasVerticalDividers && verticalDividerImage)) {
        leftLogosWidthPt += 4; // padding offset matching cell margin (40 DXA left, 40 DXA right = 80 DXA = 4pt)
    }
    // Add a tight multiplier matching exact content width to prevent shrinking
    const leftCellWidthDxa = Math.round(leftLogosWidthPt * 20); // 1pt = 20 DXA

    // Calculate exact width in points for right logos
    let rightLogosWidthPt = 0;
    rightLogos.forEach((logo, idx) => {
        rightLogosWidthPt += logo.width * 0.75;
        if (idx > 0) {
            rightLogosWidthPt += 12;
        }
    });
    if (rightLogos.length > 0) {
        rightLogosWidthPt += 4;
    }
    const rightCellWidthDxa = Math.round(rightLogosWidthPt * 20);

    const hasLeftCell = leftLogos.length > 0 || (hasVerticalDividers && verticalDividerImage);
    const hasRightCell = rightLogos.length > 0;

    // Center width is exactly the total width minus the actual side column widths
    const leftColWidth = hasLeftCell ? leftCellWidthDxa : 0;
    const rightColWidth = hasRightCell ? rightCellWidthDxa : 0;
    const centerWidthDxa = contentWidthDxa - leftColWidth - rightColWidth;

    // Subtract a small calibration offset (80 DXA = 5.3pt) to account for Word's default paragraph baseline/descender spacing below inline elements
    const bottomCellMarginDxa = Math.max(0, spaceBeforeDxa - 80);

    // ── Shared cell inner margins ──
    const logoCellMargins = { top: 0, bottom: bottomCellMarginDxa, left: 40, right: 40 };
    const zeroCellMargins = { top: 0, bottom: 0, left: 0, right: 0 };
    
    // Center Cell margins optimized to maximize text printable width (180 DXA = 9pt)
    const centerCellMargins = {
        top: 0,
        bottom: bottomCellMarginDxa + 80,
        left: hasLeftCell ? 180 : 120,
        right: hasRightCell ? 180 : 120
    };

    // ── Letter spacing → Word characterSpacing (1px = 15 twips) ──
    const rawLetterSpacing = settings.letterSpacing ?? 0;
    const letterSpacingTwips = Math.round(rawLetterSpacing * 15);

    // ── Build a logo paragraph ──
    const buildLogoParagraph = (logos, alignment, isLeftCell = false) => {
        const runs = [];
        logos.forEach((logo, idx) => {
            if (idx > 0) {
                runs.push(new ImageRun({
                    data: transparentPngBuffer,
                    transformation: { width: 16, height: 1 },
                    type: 'png',
                }));
            }
            const { width, height } = scaledDimensions(logo, logoTargetHeight);
            runs.push(new ImageRun({
                data: logo.data,
                transformation: { width, height },
                type: 'png',
            }));
        });

        // Add vertical divider inline if this is the left logos slot and vertical dividers are enabled
        if (isLeftCell && hasVerticalDividers && verticalDividerImage) {
            // Note: The left gap is now baked directly into the verticalDividerImage canvas
            runs.push(new ImageRun({
                data: verticalDividerImage.data,
                transformation: { width: verticalDividerImage.width, height: verticalDividerImage.height },
                type: 'png',
            }));
        }

        return new Paragraph({
            children: runs,
            alignment,
            spacing: { before: 0, after: 0, line: 240, lineRule: 'auto' },
        });
    };

    // ── Build header text paragraphs ──
    const headerLines = settings.headerLines ?? {};
    const fontName    = settings.fontFamily ?? 'Calibri';
    const lineSpacingDxa = Math.round((settings.lineHeight ?? 1.2) * 240);

    const buildTextParagraph = (key, isLast = false) => {
        const line = headerLines[key];
        if (!line || !line.text) return null;

        const displayText  = applyTransform(line.text, line.textTransform);
        const isUppercase  = line.textTransform === 'uppercase';
        const fontSizePt = line.fontSize ?? 14;

        let paraAlign = AlignmentType.CENTER;
        if (settings.textAlign === 'left') paraAlign = AlignmentType.LEFT;
        if (settings.textAlign === 'right') paraAlign = AlignmentType.RIGHT;

        return new Paragraph({
            spacing: { before: 0, after: 0, line: lineSpacingDxa, lineRule: 'auto' },
            contextualSpacing: true,
            alignment: paraAlign,
            children: [
                new TextRun({
                    text:             displayText,
                    bold:             line.bold    ?? false,
                    italics:          line.italic  ?? false,
                    size:             Math.round(fontSizePt * 2),
                    color:            (line.color ?? '#000000').replace('#', ''),
                    font:             fontName,
                    characterSpacing: letterSpacingTwips,
                    allCaps:          isUppercase,
                }),
            ],
        });
    };

    const CANONICAL_ORDER = ['top', 'middle', 'bottom'];
    const lineKeys = [
        ...CANONICAL_ORDER.filter(k => Object.prototype.hasOwnProperty.call(headerLines, k)),
        ...Object.keys(headerLines).filter(k => !CANONICAL_ORDER.includes(k)),
    ];
    const centerParagraphs = lineKeys
        .map((key, idx) => buildTextParagraph(key, idx === lineKeys.length - 1))
        .filter(Boolean);

    // ── Build table row cells ──
    const rowChildren = [];
    const colWidthsDxa = [];

    // Left Column (actual content width)
    if (hasLeftCell) {
        colWidthsDxa.push(leftCellWidthDxa);
        rowChildren.push(new TableCell({
            width:         { size: leftCellWidthDxa, type: WidthType.DXA },
            borders:       noBorders,
            margins:       logoCellMargins,
            verticalAlign: VerticalAlign.CENTER,
            children:      [buildLogoParagraph(leftLogos, AlignmentType.CENTER, true)],
        }));
    }

    // Center Column (Text content)
    colWidthsDxa.push(centerWidthDxa);
    rowChildren.push(new TableCell({
        width:         { size: centerWidthDxa, type: WidthType.DXA },
        borders:       noBorders,
        margins:       centerCellMargins,
        verticalAlign: VerticalAlign.CENTER,
        children:      centerParagraphs,
    }));

    // Right Column (actual content width)
    if (hasRightCell) {
        colWidthsDxa.push(rightCellWidthDxa);
        rowChildren.push(new TableCell({
            width:         { size: rightCellWidthDxa, type: WidthType.DXA },
            borders:       noBorders,
            margins:       logoCellMargins,
            verticalAlign: VerticalAlign.CENTER,
            children:      [buildLogoParagraph(rightLogos, AlignmentType.CENTER)],
        }));
    }

    // ── Table rows initialization ──
    const tableRows = [
        new TableRow({ children: rowChildren }),
    ];

    // ── Divider ──
    if (divider?.enabled) {
        const dividerColor   = (divider.color ?? '#e07b00').replace('#', '');

        // 2. Add divider row
        if (divider.text) {
            const divTextColor = (divider.textColor ?? '#ffffff').replace('#', '');
            const divFontSize = divider.fontSize ?? 10;
            const divLetterSpacingTwips = Math.round((divider.letterSpacing ?? 3) * 15);
            
            // Map minHeight using settings.divider.thickness and user-defined padding
            const dividerPaddingDxa = Math.round((divider.padding ?? 8) * 15);
            const minHeightDxa = Math.max(60, Math.round((divider.thickness ?? 6) * 15));

            tableRows.push(new TableRow({
                height: { value: minHeightDxa, rule: HeightRule.ATLEAST },
                children: [
                    new TableCell({
                        columnSpan: colWidthsDxa.length,
                        shading: { type: ShadingType.SOLID, fill: dividerColor, color: dividerColor },
                        borders: noBorders,
                        margins: { top: dividerPaddingDxa, bottom: dividerPaddingDxa, left: 120, right: 120 },
                        verticalAlign: VerticalAlign.CENTER,
                        children: [
                            new Paragraph({
                                alignment: AlignmentType.CENTER,
                                children: [
                                    new TextRun({
                                        text:    divider.text.toUpperCase(),
                                        color:   divTextColor,
                                        bold:    divider.bold ?? true,
                                        italics:  divider.italic ?? false,
                                        size:    Math.round(divFontSize * 2), // docx uses half-points
                                        font:    fontName,
                                        characterSpacing: divLetterSpacingTwips,
                                    }),
                                ],
                            }),
                        ],
                    }),
                ],
            }));
        } else {
            // Convert browser thickness (px) to DXA: 1px = 15 DXA
            const heightDxa = Math.max(60, Math.round((divider.thickness ?? 6) * 15));

            tableRows.push(new TableRow({
                height: { value: heightDxa, rule: HeightRule.EXACT },
                children: [
                    new TableCell({
                        columnSpan: colWidthsDxa.length,
                        shading: { type: ShadingType.SOLID, fill: dividerColor, color: dividerColor },
                        borders: noBorders,
                        margins: zeroCellMargins,
                        children: [
                            new Paragraph({
                                spacing: { before: 0, after: 0, line: 20, lineRule: 'exact' },
                                children: [new TextRun({ text: '', size: 2 })],
                            })
                        ],
                    }),
                ],
            }));
        }
    }

    // ── Header table ──
    const headerTable = new Table({
        alignment: AlignmentType.CENTER,
        width:     { size: contentWidthDxa, type: WidthType.DXA },
        columnWidths: colWidthsDxa,
        borders:   noTableBorders,
        rows:      tableRows,
    });

    // ── Document children ──
    const docChildren = [headerTable];

    // ── Body placeholder ──
    docChildren.push(new Paragraph({
        spacing: { before: 480 },
        children: [],
    }));
    docChildren.push(new Paragraph({
        children: [
            new TextRun({ text: 'Document Body Starts Here…', color: 'AAAAAA', italics: true, size: 20 }),
        ],
    }));

    // ── Page size & margins (A4, px → DXA: 1px = 15 DXA) ──
    const marginDxa    = Math.max(144, Math.round((settings.margin    ?? 20) * 15));
    const topMarginDxa = Math.max(0, Math.round((settings.headerTop ?? 0)  * 15));

    const doc = new Document({
        styles: {
            paragraphStyles: [
                {
                    id:   'Normal',
                    name: 'Normal',
                    basedOn: 'Normal',
                    run: {
                        font: fontName,
                    },
                    paragraph: {
                        spacing: { before: 0, after: 0, line: 240, lineRule: 'auto' },
                    },
                },
            ],
        },
        sections: [{
            properties: {
                page: {
                    size:   { width: 11906, height: 16838 },   // A4 in DXA
                    margin: {
                        top:    topMarginDxa,
                        bottom: marginDxa,
                        left:   marginDxa,
                        right:  marginDxa,
                        header: 0,
                        footer: 0,
                    },
                },
            },
            children: docChildren,
        }],
    });

    const blob = await Packer.toBlob(doc);
    saveAs(blob, `${project?.project_name ?? 'EasyPrint'}_Header.docx`);
}
