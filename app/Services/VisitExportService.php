<?php

namespace App\Services;

use App\Models\UksVisit;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use ZipArchive;

class VisitExportService
{
    /**
     * Generate a styled native XLSX spreadsheet from a collection of UKS visits.
     *
     * @param  Collection<int, UksVisit>  $visits
     * @return string Path to temporary .xlsx file
     */
    public function exportVisits(Collection $visits, ?string $periodLabel = null): string
    {
        $tempDir = sys_get_temp_dir();
        $tempFile = $tempDir.DIRECTORY_SEPARATOR.'uks_export_'.uniqid('', true).'.xlsx';

        $zip = new ZipArchive;
        if ($zip->open($tempFile, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            throw new \RuntimeException('Gagal membuat file arsip Excel sementara.');
        }

        $periodText = $periodLabel ?: 'Keseluruhan Data Riwayat Kunjungan';
        $exportTime = Carbon::now()->translatedFormat('d F Y, H:i').' WIB';

        // 1. [Content_Types].xml
        $contentTypes = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types">
  <Default Extension="rels" ContentType="application/vnd.openxmlformats-package.relationships+xml"/>
  <Default Extension="xml" ContentType="application/xml"/>
  <Override PartName="/xl/workbook.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet.main+xml"/>
  <Override PartName="/xl/worksheets/sheet1.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.worksheet+xml"/>
  <Override PartName="/xl/styles.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.styles+xml"/>
</Types>';
        $zip->addFromString('[Content_Types].xml', $contentTypes);

        // 2. _rels/.rels
        $rels = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">
  <Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument" Target="xl/workbook.xml"/>
</Relationships>';
        $zip->addFromString('_rels/.rels', $rels);

        // 3. xl/_rels/workbook.xml.rels
        $wbRels = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">
  <Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/worksheet" Target="worksheets/sheet1.xml"/>
  <Relationship Id="rId2" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/styles" Target="styles.xml"/>
</Relationships>';
        $zip->addFromString('xl/_rels/workbook.xml.rels', $wbRels);

        // 4. xl/workbook.xml
        $wb = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<workbook xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships">
  <bookViews>
    <workbookView xWindow="0" yWindow="0" windowWidth="20480" windowHeight="10240"/>
  </bookViews>
  <sheets>
    <sheet name="Laporan Kunjungan" sheetId="1" r:id="rId1"/>
  </sheets>
</workbook>';
        $zip->addFromString('xl/workbook.xml', $wb);

        // 5. xl/styles.xml (Colors, borders, fonts, alignments)
        $styles = $this->buildStylesXml();
        $zip->addFromString('xl/styles.xml', $styles);

        // 6. xl/worksheets/sheet1.xml (Main Data Sheet with Merge Cells & Gridlines)
        $sheetXml = $this->buildWorksheetXml($visits, $periodText, $exportTime);
        $zip->addFromString('xl/worksheets/sheet1.xml', $sheetXml);

        $zip->close();

        return $tempFile;
    }

    /**
     * XML stylesheet definition for clean Excel presentation.
     */
    private function buildStylesXml(): string
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<styleSheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main">
  <fonts count="9">
    <!-- 0: Regular Data (Calibri 10pt) -->
    <font><sz val="10"/><name val="Calibri"/></font>
    <!-- 1: Title (Bold 14pt Dark) -->
    <font><b/><sz val="14"/><color rgb="FF0F172A"/><name val="Calibri"/></font>
    <!-- 2: Subtitle / Meta (9.5pt Muted) -->
    <font><sz val="9.5"/><color rgb="FF475569"/><name val="Calibri"/></font>
    <!-- 3: Table Header (Bold 10pt White) -->
    <font><b/><sz val="10"/><color rgb="FFFFFFFF"/><name val="Calibri"/></font>
    <!-- 4: Date Section Header (Bold 10.5pt Emerald) -->
    <font><b/><sz val="10.5"/><color rgb="FF065F46"/><name val="Calibri"/></font>
    <!-- 5: Status Ditangani (Bold 9.5pt Green) -->
    <font><b/><sz val="9.5"/><color rgb="FF166534"/><name val="Calibri"/></font>
    <!-- 6: Status Dirujuk (Bold 9.5pt Orange) -->
    <font><b/><sz val="9.5"/><color rgb="FF9A3412"/><name val="Calibri"/></font>
    <!-- 7: Status Pulang (Bold 9.5pt Blue) -->
    <font><b/><sz val="9.5"/><color rgb="FF1E40AF"/><name val="Calibri"/></font>
    <!-- 8: Summary Title (Bold 10pt Slate) -->
    <font><b/><sz val="10"/><color rgb="FF1E293B"/><name val="Calibri"/></font>
  </fonts>
  <fills count="8">
    <!-- 0 & 1: Required defaults -->
    <fill><patternFill patternType="none"/></fill>
    <fill><patternFill patternType="gray125"/></fill>
    <!-- 2: Header Emerald #059669 -->
    <fill><patternFill patternType="solid"><fgColor rgb="FF059669"/></patternFill></fill>
    <!-- 3: Date Header Soft Green #ECFDF5 -->
    <fill><patternFill patternType="solid"><fgColor rgb="FFECFDF5"/></patternFill></fill>
    <!-- 4: Status Ditangani #DCFCE7 -->
    <fill><patternFill patternType="solid"><fgColor rgb="FFDCFCE7"/></patternFill></fill>
    <!-- 5: Status Dirujuk #FFEDD5 -->
    <fill><patternFill patternType="solid"><fgColor rgb="FFFFEDD5"/></patternFill></fill>
    <!-- 6: Status Pulang #DBEAFE -->
    <fill><patternFill patternType="solid"><fgColor rgb="FFDBEAFE"/></patternFill></fill>
    <!-- 7: Zebra Row #F8FAFC -->
    <fill><patternFill patternType="solid"><fgColor rgb="FFF8FAFC"/></patternFill></fill>
  </fills>
  <borders count="2">
    <!-- 0: No border -->
    <border><left/><right/><top/><bottom/><diagonal/></border>
    <!-- 1: Solid All Borders (Crisp Black thin) -->
    <border>
      <left style="thin"><color rgb="FF000000"/></left>
      <right style="thin"><color rgb="FF000000"/></right>
      <top style="thin"><color rgb="FF000000"/></top>
      <bottom style="thin"><color rgb="FF000000"/></bottom>
    </border>
  </borders>
  <cellStyleXfs count="1">
    <xf numFmtId="0" fontId="0" fillId="0" borderId="0"/>
  </cellStyleXfs>
  <cellXfs count="14">
    <!-- 0: Normal Text -->
    <xf numFmtId="0" fontId="0" fillId="0" borderId="0" xfId="0"/>
    <!-- 1: Sheet Title Centered -->
    <xf numFmtId="0" fontId="1" fillId="0" borderId="0" xfId="0" applyFont="1" applyAlignment="1"><alignment horizontal="center" vertical="center"/></xf>
    <!-- 2: Subtitle / Meta Centered -->
    <xf numFmtId="0" fontId="2" fillId="0" borderId="0" xfId="0" applyFont="1" applyAlignment="1"><alignment horizontal="center" vertical="center"/></xf>
    <!-- 3: Table Header (Emerald, White Text, Centered, All Borders) -->
    <xf numFmtId="0" fontId="3" fillId="2" borderId="1" xfId="0" applyFont="1" applyFill="1" applyBorder="1" applyAlignment="1"><alignment horizontal="center" vertical="center" wrapText="1"/></xf>
    <!-- 4: Data Left (All Borders, Align Left, Wrap Text) -->
    <xf numFmtId="0" fontId="0" fillId="0" borderId="1" xfId="0" applyBorder="1" applyAlignment="1"><alignment horizontal="left" vertical="center" wrapText="1"/></xf>
    <!-- 5: Data Center (All Borders, Align Center) -->
    <xf numFmtId="0" fontId="0" fillId="0" borderId="1" xfId="0" applyBorder="1" applyAlignment="1"><alignment horizontal="center" vertical="center"/></xf>
    <!-- 6: Date Section Banner (Soft Green, All Borders, Bold Left) -->
    <xf numFmtId="0" fontId="4" fillId="3" borderId="1" xfId="0" applyFont="1" applyFill="1" applyBorder="1" applyAlignment="1"><alignment horizontal="left" vertical="center"/></xf>
    <!-- 7: Status Ditangani (Green pill, All Borders, Center) -->
    <xf numFmtId="0" fontId="5" fillId="4" borderId="1" xfId="0" applyFont="1" applyFill="1" applyBorder="1" applyAlignment="1"><alignment horizontal="center" vertical="center"/></xf>
    <!-- 8: Status Dirujuk (Orange pill, All Borders, Center) -->
    <xf numFmtId="0" fontId="6" fillId="5" borderId="1" xfId="0" applyFont="1" applyFill="1" applyBorder="1" applyAlignment="1"><alignment horizontal="center" vertical="center"/></xf>
    <!-- 9: Status Pulang (Blue pill, All Borders, Center) -->
    <xf numFmtId="0" fontId="7" fillId="6" borderId="1" xfId="0" applyFont="1" applyFill="1" applyBorder="1" applyAlignment="1"><alignment horizontal="center" vertical="center"/></xf>
    <!-- 10: Data Left Zebra (All Borders, Align Left, Wrap Text) -->
    <xf numFmtId="0" fontId="0" fillId="7" borderId="1" xfId="0" applyFill="1" applyBorder="1" applyAlignment="1"><alignment horizontal="left" vertical="center" wrapText="1"/></xf>
    <!-- 11: Data Center Zebra (All Borders, Align Center) -->
    <xf numFmtId="0" fontId="0" fillId="7" borderId="1" xfId="0" applyFill="1" applyBorder="1" applyAlignment="1"><alignment horizontal="center" vertical="center"/></xf>
    <!-- 12: Summary Label Bold (Soft Green, All Borders, Center) -->
    <xf numFmtId="0" fontId="8" fillId="3" borderId="1" xfId="0" applyFont="1" applyFill="1" applyBorder="1" applyAlignment="1"><alignment horizontal="center" vertical="center"/></xf>
    <!-- 13: Summary Value Bold (White, All Borders, Center) -->
    <xf numFmtId="0" fontId="8" fillId="0" borderId="1" xfId="0" applyFont="1" applyBorder="1" applyAlignment="1"><alignment horizontal="center" vertical="center"/></xf>
  </cellXfs>
</styleSheet>';
    }

    /**
     * Build sheet1.xml containing report headers, date-grouped records, summary, and merge cells.
     *
     * @param  Collection<int, UksVisit>  $visits
     */
    private function buildWorksheetXml(Collection $visits, string $periodText, string $exportTime): string
    {
        $mergeCells = [];

        $xml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'."\n";
        $xml .= '<worksheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main">'."\n";

        // View settings: Enable visible gridlines
        $xml .= '  <sheetViews>'."\n";
        $xml .= '    <sheetView tabSelected="1" workbookViewId="0" showGridLines="1"/>'."\n";
        $xml .= '  </sheetViews>'."\n";

        // Column widths - carefully calculated so no text is truncated
        $xml .= '  <cols>'."\n";
        $xml .= '    <col min="1" max="1" width="6" customWidth="1"/>'."\n";   // A: No
        $xml .= '    <col min="2" max="2" width="16" customWidth="1"/>'."\n";  // B: Tanggal Kunjungan
        $xml .= '    <col min="3" max="3" width="13" customWidth="1"/>'."\n";  // C: Jam Masuk
        $xml .= '    <col min="4" max="4" width="28" customWidth="1"/>'."\n";  // D: Nama Siswa Pasien
        $xml .= '    <col min="5" max="5" width="16" customWidth="1"/>'."\n";  // E: Kelas
        $xml .= '    <col min="6" max="6" width="15" customWidth="1"/>'."\n";  // F: Jurusan
        $xml .= '    <col min="7" max="7" width="16" customWidth="1"/>'."\n";  // G: Jenis Kelamin
        $xml .= '    <col min="8" max="8" width="40" customWidth="1"/>'."\n";  // H: Keluhan / Gejala Sakit (Expanded)
        $xml .= '    <col min="9" max="9" width="40" customWidth="1"/>'."\n";  // I: Tindakan Awal / Obat (Expanded)
        $xml .= '    <col min="10" max="10" width="26" customWidth="1"/>'."\n"; // J: Status Penanganan (Expanded)
        $xml .= '  </cols>'."\n";

        $xml .= '  <sheetData>'."\n";

        // Row 1: Title (Centered across A1:J1, generous height so 14pt bold text never clips)
        $xml .= '    <row r="1" ht="38" customHeight="1">'."\n";
        $xml .= sprintf('      <c r="A1" t="inlineStr" s="1"><is><t>%s</t></is></c>'."\n", $this->escapeXml('LAPORAN REKAPITULASI KUNJUNGAN UKS SEKOLAH'));
        for ($c = 'B'; $c <= 'J'; $c++) {
            $xml .= sprintf('      <c r="%s1" s="1"/>'."\n", $c);
        }
        $xml .= "    </row>\n";
        $mergeCells[] = 'A1:J1';

        // Row 2: Subtitle (Centered across A2:J2)
        $xml .= '    <row r="2" ht="22" customHeight="1">'."\n";
        $xml .= sprintf('      <c r="A2" t="inlineStr" s="2"><is><t>%s</t></is></c>'."\n", $this->escapeXml('Sistem Pelayanan Unit Kesehatan Sekolah (UKS)'));
        for ($c = 'B'; $c <= 'J'; $c++) {
            $xml .= sprintf('      <c r="%s2" s="2"/>'."\n", $c);
        }
        $xml .= "    </row>\n";
        $mergeCells[] = 'A2:J2';

        // Row 3: Period & Export metadata (Centered across A3:J3)
        $xml .= '    <row r="3" ht="22" customHeight="1">'."\n";
        $metaText = "Periode: {$periodText}  |  Dicetak: {$exportTime}  |  Total Data: ".$visits->count().' Siswa Pasien';
        $xml .= sprintf('      <c r="A3" t="inlineStr" s="2"><is><t>%s</t></is></c>'."\n", $this->escapeXml($metaText));
        for ($c = 'B'; $c <= 'J'; $c++) {
            $xml .= sprintf('      <c r="%s3" s="2"/>'."\n", $c);
        }
        $xml .= "    </row>\n";
        $mergeCells[] = 'A3:J3';

        // Row 4: Subtle spacing row
        $xml .= '    <row r="4" ht="12" customHeight="1">'."\n";
        $xml .= "    </row>\n";

        // Row 5: Main Table Headers (Emerald Background with White Bold Text)
        $xml .= '    <row r="5" ht="28" customHeight="1">'."\n";
        $headers = [
            'A' => 'No',
            'B' => 'Tanggal',
            'C' => 'Jam Masuk',
            'D' => 'Nama Siswa Pasien',
            'E' => 'Kelas',
            'F' => 'Jurusan',
            'G' => 'Jenis Kelamin',
            'H' => 'Keluhan / Gejala Sakit',
            'I' => 'Tindakan Awal / Obat',
            'J' => 'Status Penanganan',
        ];
        foreach ($headers as $col => $title) {
            $xml .= sprintf('      <c r="%s5" t="inlineStr" s="3"><is><t>%s</t></is></c>'."\n", $col, $this->escapeXml($title));
        }
        $xml .= "    </row>\n";

        $rowIdx = 6;

        if ($visits->isEmpty()) {
            $xml .= sprintf('    <row r="%d" ht="26" customHeight="1">'."\n", $rowIdx);
            $xml .= sprintf('      <c r="A%d" t="inlineStr" s="5"><is><t>-</t></is></c>'."\n", $rowIdx);
            $xml .= sprintf('      <c r="B%d" t="inlineStr" s="4"><is><t>%s</t></is></c>'."\n", $rowIdx, $this->escapeXml('Tidak ada data catatan kunjungan untuk periode/filter ini.'));
            for ($c = 'C'; $c <= 'J'; $c++) {
                $xml .= sprintf('      <c r="%s%d" s="4"/>'."\n", $c, $rowIdx);
            }
            $xml .= "    </row>\n";
            $mergeCells[] = sprintf('B%d:J%d', $rowIdx, $rowIdx);
            $rowIdx++;
        } else {
            // Group visits by date for organized chronological per-date reporting
            $groupedByDate = $visits->groupBy(function (UksVisit $visit) {
                return $visit->visit_date ? $visit->visit_date->format('Y-m-d') : 'Tanpa Tanggal';
            });

            $counter = 1;
            foreach ($groupedByDate as $dateKey => $dateVisits) {
                // Format the section banner title for this date
                if ($dateKey !== 'Tanpa Tanggal') {
                    $dateObj = Carbon::parse($dateKey);
                    $formattedDateBanner = 'Tanggal: '.$dateObj->translatedFormat('l, d F Y').' ('.$dateVisits->count().' Siswa)';
                } else {
                    $formattedDateBanner = 'Tanggal Belum Tercatat ('.$dateVisits->count().' Siswa)';
                }

                // Section Banner Row: Merged across entire table width A through J with solid border
                $xml .= sprintf('    <row r="%d" ht="26" customHeight="1">'."\n", $rowIdx);
                $xml .= sprintf('      <c r="A%d" t="inlineStr" s="6"><is><t>%s</t></is></c>'."\n", $rowIdx, $this->escapeXml('  '.$formattedDateBanner));
                for ($c = 'B'; $c <= 'J'; $c++) {
                    $xml .= sprintf('      <c r="%s%d" s="6"/>'."\n", $c, $rowIdx);
                }
                $xml .= "    </row>\n";
                $mergeCells[] = sprintf('A%d:J%d', $rowIdx, $rowIdx);
                $rowIdx++;

                // Data Rows for each visit on this date
                foreach ($dateVisits as $visit) {
                    $isZebra = ($counter % 2 === 0);
                    $styleLeft = $isZebra ? 10 : 4;
                    $styleCenter = $isZebra ? 11 : 5;

                    // Formatted Date
                    $visitDateStr = $visit->visit_date ? $visit->visit_date->format('d/m/Y') : '-';

                    // Formatted Time
                    $timeStr = '-';
                    if ($visit->created_at) {
                        $timeStr = $visit->created_at->format('H:i').' WIB';
                    } elseif ($visit->visit_date) {
                        $timeStr = $visit->visit_date->format('H:i').' WIB';
                    }

                    // Student attributes
                    $student = $visit->student;
                    $studentName = $student?->name ?: 'Siswa Tidak Diketahui';
                    $cleanClass = trim((string) preg_replace('/^kelas\s*/i', '', $student?->class_name ?? ''));
                    $className = $cleanClass !== '' && $cleanClass !== '-' ? 'Kelas '.$cleanClass : ($student?->class_name ?: '-');
                    $major = $student?->major ?: '-';
                    $gender = match ($student?->gender) {
                        'L' => 'Laki-laki',
                        'P' => 'Perempuan',
                        default => '-'
                    };

                    // Medical notes
                    $complaint = $visit->complaint ?: '-';
                    $treatment = $visit->initial_treatment ?: '-';

                    // Status and Status Style
                    $statusLabel = match ($visit->status) {
                        'ditangani' => 'Ditangani di UKS',
                        'dirujuk' => 'Dirujuk ke Faskes',
                        'pulang' => 'Diizinkan Pulang',
                        default => ucfirst((string) $visit->status)
                    };

                    $statusStyle = match ($visit->status) {
                        'ditangani' => 7,
                        'dirujuk' => 8,
                        'pulang' => 9,
                        default => $styleCenter
                    };

                    // Dynamic row height calculation so text in Keluhan / Tindakan / Nama is NEVER cut off
                    $lenH = mb_strlen((string) $complaint);
                    $lenI = mb_strlen((string) $treatment);
                    $lenD = mb_strlen((string) $studentName);

                    $linesH = substr_count((string) $complaint, "\n") + 1;
                    $linesI = substr_count((string) $treatment, "\n") + 1;
                    $explicitLines = max($linesH, $linesI);

                    // Width 40 allows ~34 chars per line comfortably
                    $estLinesH = (int) ceil(max(1, $lenH) / 34);
                    $estLinesI = (int) ceil(max(1, $lenI) / 34);
                    $estLinesD = (int) ceil(max(1, $lenD) / 24);
                    $totalLines = max($explicitLines, $estLinesH, $estLinesI, $estLinesD);

                    if ($totalLines >= 4) {
                        $rowHeight = 72;
                    } elseif ($totalLines === 3) {
                        $rowHeight = 54;
                    } elseif ($totalLines === 2) {
                        $rowHeight = 38;
                    } else {
                        $rowHeight = 24;
                    }

                    $xml .= sprintf('    <row r="%d" ht="%d" customHeight="1">'."\n", $rowIdx, $rowHeight);
                    $xml .= sprintf('      <c r="A%d" t="inlineStr" s="%d"><is><t>%d</t></is></c>'."\n", $rowIdx, $styleCenter, $counter);
                    $xml .= sprintf('      <c r="B%d" t="inlineStr" s="%d"><is><t>%s</t></is></c>'."\n", $rowIdx, $styleCenter, $this->escapeXml($visitDateStr));
                    $xml .= sprintf('      <c r="C%d" t="inlineStr" s="%d"><is><t>%s</t></is></c>'."\n", $rowIdx, $styleCenter, $this->escapeXml($timeStr));
                    $xml .= sprintf('      <c r="D%d" t="inlineStr" s="%d"><is><t>%s</t></is></c>'."\n", $rowIdx, $styleLeft, $this->escapeXml($studentName));
                    $xml .= sprintf('      <c r="E%d" t="inlineStr" s="%d"><is><t>%s</t></is></c>'."\n", $rowIdx, $styleCenter, $this->escapeXml($className));
                    $xml .= sprintf('      <c r="F%d" t="inlineStr" s="%d"><is><t>%s</t></is></c>'."\n", $rowIdx, $styleCenter, $this->escapeXml($major));
                    $xml .= sprintf('      <c r="G%d" t="inlineStr" s="%d"><is><t>%s</t></is></c>'."\n", $rowIdx, $styleCenter, $this->escapeXml($gender));
                    $xml .= sprintf('      <c r="H%d" t="inlineStr" s="%d"><is><t>%s</t></is></c>'."\n", $rowIdx, $styleLeft, $this->escapeXml($complaint));
                    $xml .= sprintf('      <c r="I%d" t="inlineStr" s="%d"><is><t>%s</t></is></c>'."\n", $rowIdx, $styleLeft, $this->escapeXml($treatment));
                    $xml .= sprintf('      <c r="J%d" t="inlineStr" s="%d"><is><t>%s</t></is></c>'."\n", $rowIdx, $statusStyle, $this->escapeXml($statusLabel));
                    $xml .= "    </row>\n";

                    $rowIdx++;
                    $counter++;
                }
            }
        }

        // Summary Box at bottom with full All Borders spanning A through J (5 balanced 2-column pairs)
        $rowIdx++;
        $totalVisits = $visits->count();
        $ditanganiCount = $visits->where('status', 'ditangani')->count();
        $dirujukCount = $visits->where('status', 'dirujuk')->count();
        $pulangCount = $visits->where('status', 'pulang')->count();

        $summaryRow = $rowIdx;
        $xml .= sprintf('    <row r="%d" ht="26" customHeight="1">'."\n", $summaryRow);
        $xml .= sprintf('      <c r="A%d" t="inlineStr" s="12"><is><t>%s</t></is></c>'."\n", $summaryRow, $this->escapeXml('RINGKASAN TOTAL'));
        $xml .= sprintf('      <c r="B%d" s="12"/>'."\n", $summaryRow);
        $xml .= sprintf('      <c r="C%d" t="inlineStr" s="13"><is><t>%s</t></is></c>'."\n", $summaryRow, $this->escapeXml("Total: {$totalVisits} Siswa Pasien"));
        $xml .= sprintf('      <c r="D%d" s="13"/>'."\n", $summaryRow);
        $xml .= sprintf('      <c r="E%d" t="inlineStr" s="7"><is><t>%s</t></is></c>'."\n", $summaryRow, $this->escapeXml("Ditangani di UKS: {$ditanganiCount}"));
        $xml .= sprintf('      <c r="F%d" s="7"/>'."\n", $summaryRow);
        $xml .= sprintf('      <c r="G%d" t="inlineStr" s="8"><is><t>%s</t></is></c>'."\n", $summaryRow, $this->escapeXml("Dirujuk: {$dirujukCount}"));
        $xml .= sprintf('      <c r="H%d" s="8"/>'."\n", $summaryRow);
        $xml .= sprintf('      <c r="I%d" t="inlineStr" s="9"><is><t>%s</t></is></c>'."\n", $summaryRow, $this->escapeXml("Diizinkan Pulang: {$pulangCount}"));
        $xml .= sprintf('      <c r="J%d" s="9"/>'."\n", $summaryRow);
        $xml .= "    </row>\n";
        $mergeCells[] = sprintf('A%d:B%d', $summaryRow, $summaryRow);
        $mergeCells[] = sprintf('C%d:D%d', $summaryRow, $summaryRow);
        $mergeCells[] = sprintf('E%d:F%d', $summaryRow, $summaryRow);
        $mergeCells[] = sprintf('G%d:H%d', $summaryRow, $summaryRow);
        $mergeCells[] = sprintf('I%d:J%d', $summaryRow, $summaryRow);

        $xml .= '  </sheetData>'."\n";

        // Merge Cells block (Placed immediately after </sheetData> according to OpenXML specification)
        if (! empty($mergeCells)) {
            $xml .= sprintf('  <mergeCells count="%d">'."\n", count($mergeCells));
            foreach ($mergeCells as $ref) {
                $xml .= sprintf('    <mergeCell ref="%s"/>'."\n", $ref);
            }
            $xml .= '  </mergeCells>'."\n";
        }

        $xml .= '</worksheet>'."\n";

        return $xml;
    }

    /**
     * Escape characters for valid XML.
     */
    private function escapeXml(string $value): string
    {
        return htmlspecialchars($value, ENT_QUOTES | ENT_XML1, 'UTF-8');
    }
}
