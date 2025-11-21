@push('css')
<link rel="stylesheet" href="{{ url(mix('css/dist/bootstrap-table.css')) }}">
@endpush

@push('js')

<script src="{{ url(mix('js/dist/bootstrap-table.js')) }}"></script>

<script nonce="{{ csrf_token() }}">
    // $(function () {

    //     var locale = '{{ config('app.locale') }}';
    //     var blockedFields = "searchable,sortable,switchable,title,visible,formatter,class".split(",");

    //     var keyBlocked = function(key) {
    //         for(var j in blockedFields) {
    //             if (key === blockedFields[j]) {
    //                 return true;
    //             }
    //         }
    //         return false;
    //     }

    //     $('.snipe-table').bootstrapTable('destroy').each(function () {

    //         var $table = $(this);
    //         data_export_options = $table.attr('data-export-options');
    //         export_options = data_export_options ? JSON.parse(data_export_options) : {};
    //         export_options['htmlContent'] = false; // this is already the default; but let's be explicit about it

    //         // tempat menyimpan posisi akhir header untuk dipakai startY tabel (PDF export)
    //         var headerEndY = null;

    //         // Konfigurasi jsPDF + AutoTable agar menambahkan header statis di atas tabel ekspor
    //         export_options['jspdf'] = {
    //             orientation: 'l',
    //             unit: 'pt',
    //             format: 'a4',
    //             margins: { top: 20, right: 20, bottom: 20, left: 20 },
    //             onDocCreated: function(doc) {
    //                 try { doc.setFont('helvetica', 'bold'); } catch (e) {}

    //                 var pageWidth  = (doc.internal.pageSize.getWidth) ? doc.internal.pageSize.getWidth() : doc.internal.pageSize.width;
    //                 var pageHeight = (doc.internal.pageSize.getHeight) ? doc.internal.pageSize.getHeight() : doc.internal.pageSize.height;

    //                 var outerMargin = 12; // border luar halaman dengan margin lebih besar
    //                 doc.setLineWidth(0.8);
    //                 doc.rect(outerMargin, outerMargin, pageWidth - 2*outerMargin, pageHeight - 2*outerMargin);

    //                 // Kotak kecil kanan atas (teks dinamis berdasarkan route)
    //                 var rightBoxW = 150, rightBoxH = 40;
    //                 var rightBoxX = pageWidth - outerMargin - rightBoxW;
    //                 var rightBoxY = outerMargin + 10; // tambah padding atas
    //                 doc.setLineWidth(0.6);
    //                 doc.rect(rightBoxX, rightBoxY, rightBoxW, rightBoxH);
    //                 doc.setFontSize(9);
                    
    //                 // Deteksi route dan set teks yang sesuai
    //                 var currentPath = window.location.pathname;
    //                 var moduleText = 'PPKEK PEMASUKAN'; 
                    
    //                 if (currentPath.includes('/pemasukan')) {
    //                     moduleText = 'PPKEK PEMASUKAN';
    //                 } else if (currentPath.includes('/pengeluaran')) {
    //                     moduleText = 'PPKEK PENGELUARAN';
    //                 } else if (currentPath.includes('/adjusment')) {
    //                     moduleText = 'PPKEK ADJUSTMENT';
    //                 } else if (currentPath.includes('/stockopname')) {
    //                     moduleText = 'PPKEK STOCKOPNAME';
    //                 }
                    
    //                 try { doc.text(moduleText, rightBoxX + rightBoxW/2, rightBoxY + 16, { align: 'center' }); } catch(e) { doc.text(moduleText, rightBoxX + rightBoxW/2, rightBoxY + 16, null, null, 'center'); }
    //                 try { doc.text('LDP', rightBoxX + rightBoxW/2, rightBoxY + 30, { align: 'center' }); } catch(e) { doc.text('LDP', rightBoxX + rightBoxW/2, rightBoxY + 30, null, null, 'center'); }

    //                 // Judul pusat dengan spacing yang lebih baik
    //                 var y = outerMargin + 22; // tambah padding atas
    //                 doc.setFontSize(12);
    //                 try { doc.text('LEMBAR LAMPIRAN DATA BARANG', pageWidth/2, y, { align: 'center' }); } catch(e) { doc.text('LEMBAR LAMPIRAN DATA BARANG', pageWidth/2, y, null, null, 'center'); }
    //                 y += 16; // tambah spacing antar judul
    //                 try { doc.text('PEMBERITAHUAN PABEAN', pageWidth/2, y, { align: 'center' }); } catch(e) { doc.text('PEMBERITAHUAN PABEAN', pageWidth/2, y, null, null, 'center'); }
    //                 y += 16; // tambah spacing antar judul
    //                 try { doc.text('KAWASAN EKONOMI KHUSUS', pageWidth/2, y, { align: 'center' }); } catch(e) { doc.text('KAWASAN EKONOMI KHUSUS', pageWidth/2, y, null, null, 'center'); }

    //                 // Blok informasi A. Nomor dan Tanggal Pemberitahuan Pabean (statis)
    //                 var blockX = outerMargin + 10; // tambah padding kiri
    //                 var blockY = y + 18; // tambah spacing dari judul
    //                 var blockW = pageWidth - 2*(outerMargin + 10); // sesuaikan dengan padding
    //                 var blockH = 52; // tambah tinggi untuk spacing yang lebih baik

    //                 // Judul blok "A. ..."
    //                 doc.setFontSize(9);
    //                 doc.text('A. NOMOR DAN TANGGAL PEMBERITAHUAN PABEAN', blockX, blockY - 6);

    //                 // Kotak besar
    //                 doc.setLineWidth(0.6);
    //                 doc.rect(blockX, blockY, blockW, blockH);

    //                 // Bagi menjadi 2 kolom (kiri: poin 1&2, kanan: poin 3&4)
    //                 var colW = blockW / 2;
    //                 var vx = blockX + colW;
    //                 doc.line(vx, blockY, vx, blockY + blockH);

    //                 // Nilai statis sesuai contoh
    //                 var values = {
    //                     nomor_pengajuan: '201038F9AB2902210202400001',
    //                     tanggal_pengajuan: '22-10-2024',
    //                     nomor_pendaftaran: '000060',
    //                     tanggal_pendaftaran: '24-10-2024'
    //                 };

    //                 // Teks per kolom (2 baris per kolom)
    //                 doc.setFontSize(8.5);
    //                 var leftX = blockX + 6; // tambah padding kiri
    //                 var rightX = blockX + colW + 6; // tambah padding kiri
    //                 var line1Y = blockY + 18;  // baris pertama dengan spacing lebih baik
    //                 var line2Y = blockY + 36;  // baris kedua dengan spacing lebih baik

    //                 // Kolom kiri: poin 1 & 2
    //                 doc.text('1. NOMOR PENGAJUAN : ' + values.nomor_pengajuan, leftX, line1Y);
    //                 doc.text('2. TANGGAL PENGAJUAN : ' + values.tanggal_pengajuan, leftX, line2Y);

    //                 // Kolom kanan: poin 3 & 4
    //                 doc.text('3. NOMOR PENDAFTARAN : ' + values.nomor_pendaftaran, rightX, line1Y);
    //                 doc.text('4. TANGGAL PENDAFTARAN : ' + values.tanggal_pendaftaran, rightX, line2Y);

    //                 // Tambahkan teks statis 4 bagian di bawah blok A (mirip gambar)
    //                 var legendTopY = blockY + blockH + 12; // tambah spacing dari blok A
    //                 var legendLeftX = blockX;
    //                 var legendWidth = blockW;

    //                 // Garis horizontal atas area legend
    //                 doc.setLineWidth(0.6);
    //                 doc.line(legendLeftX, legendTopY, legendLeftX + legendWidth, legendTopY);

    //                 // Bagi area menjadi 3 kolom utama (teks) + 1 kolom kanan (Kotak 5. Keterangan)
    //                 var keteranganW = legendWidth * 0.25; // lebar kotak kanan ~25%
    //                 var leftAreaW = legendWidth - keteranganW;
    //                 var colW3 = leftAreaW / 3;

    //                 var col1X = legendLeftX;
    //                 var col2X = col1X + colW3;
    //                 var col3X = col2X + colW3;
    //                 var ketX  = col3X + colW3;

    //                 // Garis vertikal pemisah ke area Keterangan (akan diperpanjang sesuai tinggi konten)
    //                 // doc.line(ketX, legendTopY, ketX, legendTopY + 1); // removed: no border for right section
                    
    //                 // Daftar item untuk 3 kolom pertama
    //                 doc.setFontSize(8);
    //                 try { doc.setFont('helvetica', 'normal'); } catch (e) {}
    //                 var lh = 12; // line-height dengan spacing lebih baik
    //                 var pad = 2; // tambah padding horizontal
    //                 function drawListAt(x, y, w, items, options){
    //                     var ycur = y;
    //                     var textW = w - 2*pad;
    //                     var firstGap = (options && typeof options.firstGap === 'number') ? options.firstGap : lh;
    //                     var gap = firstGap;
    //                     for (var i=0;i<items.length;i++){
    //                         var lines = doc.splitTextToSize(items[i], textW);
    //                         doc.text(lines, x + pad, ycur + gap);
    //                         // Tambah tinggi: gap awal untuk baris pertama + lh untuk baris berikutnya
    //                         ycur += gap + Math.max(0, (lines.length - 1)) * lh;
    //                         gap = lh; // item berikutnya gunakan lh standar
    //                     }
    //                     return ycur;
    //                 }

    //                 // Area 6 kolom Pos Tarif HS sesuai gambar
    //                 var detailAreaY = legendTopY + 8;
    //                 var detailAreaH = 85;
                    
    //                 // Gambar border area utama
    //                 doc.setLineWidth(0.6);
    //                 doc.rect(legendLeftX, detailAreaY, legendWidth, detailAreaH);
                    
    //                 // Bagi menjadi 5 kolom dengan proporsi yang sesuai gambar
    //                 var col1W = legendWidth / 5;
    //                 var col2W = legendWidth / 5;
    //                 var col3W = legendWidth / 5;
    //                 var col4W = legendWidth / 5;
    //                 var col5W = legendWidth / 5;
                    
    //                 // Garis vertikal pemisah kolom
    //                 var currentX = legendLeftX;
    //                 for(var i = 1; i < 5; i++) {
    //                     currentX += legendWidth / 5;
    //                     doc.line(currentX, detailAreaY, currentX, detailAreaY + detailAreaH);
    //                 }
                    
    //                 // Isi konten 5 kolom sesuai gambar
    //                 doc.setFontSize(7);
    //                 var colStartX = legendLeftX + 3;
    //                 var textY = detailAreaY + 10;
    //                 var lineHeight = 8;
                    
    //                 // Kolom 1
    //                 doc.text('1.a Pos Tarif HS', colStartX, textY);
    //                 doc.text('b. Uraian Jenis Secara', colStartX, textY + lineHeight);
    //                 doc.text('Lengkap, Merek, Tipe,', colStartX, textY + lineHeight*2);
    //                 doc.text('Ukuran, dan Spesifikasi Lain', colStartX, textY + lineHeight*3);
    //                 doc.text('c. Kode Barang', colStartX, textY + lineHeight*4);
    //                 doc.text('d. Negara Asal Barang', colStartX, textY + lineHeight*5);
    //                 doc.text('e. Daerah Asal Barang', colStartX, textY + lineHeight*6);
                    
    //                 // Kolom 2
    //                 colStartX += col1W;
    //                 doc.text('2.a Pos Tarif HS Kategori Barang', colStartX, textY);
    //                 doc.text('b. Tujuan Pemasukan/Pengeluaran', colStartX, textY + lineHeight);
    //                 doc.text('3.a Jumlah/Kode Kemasan', colStartX, textY + lineHeight*2);
    //                 doc.text('b. Jumlah/Kode Satuan', colStartX, textY + lineHeight*3);
    //                 doc.text('4. Amount (CIF USD)', colStartX, textY + lineHeight*4);
    //                 doc.text('5. BT Diskon', colStartX, textY + lineHeight*5);
                    
    //                 // Kolom 3
    //                 colStartX += col2W;
    //                 doc.text('a. Harga Satuan', colStartX, textY);
    //                 doc.text('a. Skema Tarif & Fasilitas', colStartX, textY + lineHeight);
    //                 doc.text('c. Spesifikasi Khusus', colStartX, textY + lineHeight*2);
    //                 doc.text('d. Cukai', colStartX, textY + lineHeight*3);
    //                 doc.text('e. Harga Patokan Ekspor', colStartX, textY + lineHeight*4);
                    
    //                 // Kolom 4
    //                 colStartX += col3W;
    //                 doc.text('f. Bea Keluar', colStartX, textY);
    //                 doc.text('g. Jenis Tarif', colStartX, textY + lineHeight);
    //                 doc.text('h. Jenis Bayar', colStartX, textY + lineHeight*2);
    //                 doc.text('5. Keterangan', colStartX, textY + lineHeight*3);
    //                 doc.text('a. Persyaratan & No. Urut', colStartX, textY + lineHeight*4);
    //                 doc.text('b. SKEP SKA (Inland FTA)', colStartX, textY + lineHeight*5);
                    
    //                 // Kolom 5
    //                 colStartX += col4W;
    //                 doc.text('c. Referensi Dokumen Asal', colStartX, textY);
    //                 doc.text('d. Barang Baru/Bukan Baru', colStartX, textY + lineHeight);
    //                 doc.text('e. Lartas Non Lartas', colStartX, textY + lineHeight*2);
    //                 doc.text('f. Jenis Transaksi', colStartX, textY + lineHeight*3);
                    
    //                 headerEndY = detailAreaY + detailAreaH + 15; // Set posisi akhir header dengan spacing
    //              },
    //             // Tambahkan konfigurasi AutoTable bawaan seperti pada contoh awal
    //             autotable: {
    //                 startY: 130, // fallback startY
    //                 styles: {
    //                     cellPadding: 2,
    //                     rowHeight: 12,
    //                     fontSize: 8,
    //                     textColor: 50,
    //                     fontStyle: 'normal',
    //                     overflow: 'ellipsize',
    //                     halign: 'left',
    //                     valign: 'middle',
    //                     lineWidth: 0.25,
    //                     lineColor: [0, 0, 0]
    //                 },
    //                 headerStyles: {
    //                     fillColor: [230, 230, 230],
    //                     textColor: 0,
    //                     fontStyle: 'bold',
    //                     halign: 'center',
    //                     valign: 'middle',
    //                     lineWidth: 0.35,
    //                     lineColor: [0, 0, 0]
    //                 },
    //                 alternateRowStyles: { fillColor: 245 },
    //                 tableExport: {
    //                     onBeforeAutotable: function($el, columns, rows, atOptions){
    //                         try {
    //                             atOptions = atOptions || {};
    //                             atOptions.startY = (headerEndY ? headerEndY + 8 : 130);
    //                         } catch(e) {}
    //                     }
    //                 }
    //             }
    //         };

    //         // Hook alternatif untuk beberapa versi tableExport
    //         export_options['onBeforeAutotable'] = function($el, columns, rows, atOptions){
    //             try {
    //                 atOptions = atOptions || {};
    //                 atOptions.startY = (headerEndY ? headerEndY + 8 : 170);
    //             } catch(e) {}
    //         };
    //         // the following callback method is necessary to prevent XSS vulnerabilities
    //         // (this is taken from Bootstrap Tables's default wrapper around jQuery Table Export)
    //         export_options['onCellHtmlData'] = function (cell, rowIndex, colIndex, htmlData) {
    //             if (cell.is('th')) {
    //                 return cell.find('.th-inner').text()
    //             }
    //             return htmlData
    //         }
    //         // Normalisasi tanggal saat ekspor dan pastikan kolom Actions kosong (diabaikan)
    //         export_options['onCellData'] = function ($cell, rowIndex, colIndex, cellText) {
    //             try {
    //                 var $tbl = $cell.closest('table');
    //                 var $th = $tbl.find('thead th').eq(colIndex);
    //                 var headerText = $.trim($th.text()).toLowerCase();
    //                 var dataField = ($th.data('field') || '').toString().toLowerCase();
    //                 if (dataField === 'actions' || headerText === 'actions' || headerText === 'aksi' || headerText === '{{ strtolower(trans("table.actions")) }}') {
    //                     return '';
    //                 }
    //                 if (headerText.indexOf('tanggal') !== -1) {
    //                     var s = (cellText || '').toString().trim();
    //                     var m = s.match(/^(\d{4})[-\/.](\d{2})[-\/.](\d{2})(.*)$/);
    //                     if (m) {
    //                         var rest = (m[4] || '').trim();
    //                         var out = m[3] + '-' + m[2] + '-' + m[1];
    //                         return rest ? (out + ' ' + rest) : out;
    //                     }
    //                     var m2 = s.match(/^(\d{2})[-\/.](\d{2})[-\/.](\d{4})(.*)$/);
    //                     if (m2) {
    //                         var rest2 = (m2[4] || '').trim();
    //                         var out2 = m2[1] + '-' + m2[2] + '-' + m2[3];
    //                         return rest2 ? (out2 + ' ' + rest2) : out2;
    //                     }
    //                 }
    //             } catch (e) {}
    //             return cellText;
    //         };
    //         $table.bootstrapTable({
    //         classes: 'table table-responsive table-no-bordered',
    //         ajaxOptions: {
    //             headers: {
    //                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //             }
    //         },
    //         // reorderableColumns: true,
    //         stickyHeader: true,
    //         stickyHeaderOffsetLeft: parseInt($('body').css('padding-left'), 10),
    //         stickyHeaderOffsetRight: parseInt($('body').css('padding-right'), 10),
    //         locale: locale,
    //         undefinedText: '',
    //         iconsPrefix: 'fa',
    //         cookieStorage: '{{ config('session.bs_table_storage') }}',
    //         cookie: true,
    //         cookieExpire: '2y',
    //         mobileResponsive: true,
    //         maintainSelected: true,
    //         trimOnSearch: false,
    //         showSearchClearButton: true,
    //         paginationFirstText: "{{ trans('general.first') }}",
    //         paginationLastText: "{{ trans('general.last') }}",
    //         paginationPreText: "{{ trans('general.previous') }}",
    //         paginationNextText: "{{ trans('general.next') }}",
    //         pageList: ['10','20', '30','50','100','150','200'{!! ((config('app.max_results') > 200) ? ",'500'" : '') !!}{!! ((config('app.max_results') > 500) ? ",'".config('app.max_results')."'" : '') !!}],
    //         pageSize: {{  (($snipeSettings->per_page!='') && ($snipeSettings->per_page > 0)) ? $snipeSettings->per_page : 20 }},
    //         paginationVAlign: 'both',
    //         queryParams: function (params) {
    //             var newParams = {};
    //             for(var i in params) {
    //                 if(!keyBlocked(i)) { // only send the field if it's not in blockedFields
    //                     newParams[i] = params[i];
    //                 }
    //             }
    //             return newParams;
    //         },
    //         formatLoadingMessage: function () {
    //             return '<h2><i class="fas fa-spinner fa-spin" aria-hidden="true"></i> {{ trans('general.loading') }} </h4>';
    //         },
    //         icons: {
    //             advancedSearchIcon: 'fas fa-search-plus',
    //             paginationSwitchDown: 'fa-caret-square-o-down',
    //             paginationSwitchUp: 'fa-caret-square-o-up',
    //             fullscreen: 'fa-expand',
    //             columns: 'fa-columns',
    //             refresh: 'fas fa-sync-alt',
    //             export: 'fa-download',
    //             clearSearch: 'fa-times'
    //         },
    //             exportOptions: export_options,

    //         exportTypes: ['xlsx', 'excel', 'csv', 'pdf','json', 'xml', 'txt', 'sql', 'doc' ],
    //         onLoadSuccess: function () {
    //             $('[data-tooltip="true"]').tooltip(); // Needed to attach tooltips after ajax call
    //         }

    //         });

    //     });
    // });
    $(function () {

        var locale = '{{ config('app.locale') }}';
        var blockedFields = "searchable,sortable,switchable,title,visible,formatter,class".split(",");

        var keyBlocked = function(key) {
            for(var j in blockedFields) {
                if (key === blockedFields[j]) {
                    return true;
                }
            }
            return false;
        }

        $('.snipe-table').bootstrapTable('destroy').each(function () {

            var $table = $(this);
            data_export_options = $table.attr('data-export-options');
            export_options = data_export_options ? JSON.parse(data_export_options) : {};
            export_options['htmlContent'] = false; // this is already the default; but let's be explicit about it

            // tempat menyimpan posisi akhir header untuk dipakai startY tabel (PDF export)
            var headerEndY = null;

            // Konfigurasi jsPDF + AutoTable agar menambahkan header statis di atas tabel ekspor
            export_options['jspdf'] = {
                orientation: 'l',
                unit: 'pt',
                format: 'a4',
                margins: { top: 20, right: 20, bottom: 20, left: 20 },
                onDocCreated: function(doc) {
                    try { doc.setFont('helvetica', 'bold'); } catch (e) {}

                    var pageWidth  = (doc.internal.pageSize.getWidth) ? doc.internal.pageSize.getWidth() : doc.internal.pageSize.width;
                    var pageHeight = (doc.internal.pageSize.getHeight) ? doc.internal.pageSize.getHeight() : doc.internal.pageSize.height;

                    var outerMargin = 12; // border luar halaman dengan margin lebih besar
                    doc.setLineWidth(0.8);
                    doc.rect(outerMargin, outerMargin, pageWidth - 2*outerMargin, pageHeight - 2*outerMargin);

                    
                    var img = document.getElementById("logo");
                    if (img) {
                        var canvas = document.createElement("canvas");
                        var ctx = canvas.getContext("2d");
                        canvas.width = img.width;
                        canvas.height = img.height;
                        ctx.drawImage(img, 0, 0);
                        var imgData = canvas.toDataURL("image/png"); // jadi base64
                        doc.addImage(imgData, "PNG", 10, 10, 150, 50);
                    }
                    
                    // Deteksi route dan set teks yang sesuai
                    var currentPath = window.location.pathname;
                    var moduleText = 'DAFTAR ALL ASET'; 
                    
                    if (currentPath.includes('/pemasukan')) {
                        moduleText = 'DAFTAR ASET PEMASUKAN';
                    } else if (currentPath.includes('/pengeluaran')) {
                        moduleText = 'DAFTAR ASET PENGELUARAN';
                    } else if (currentPath.includes('/adjusment')) {
                        moduleText = 'DAFTAR ASET ADJUSMENT';
                    } else if (currentPath.includes('/stockopname')) {
                        moduleText = 'DAFTAR ASET STOCK OPNAME';
                    } 
                    

                    var headingY = outerMargin + 30; // jarak dari atas
                    doc.setFontSize(14);
                    doc.text(moduleText, pageWidth / 2, headingY, { align: 'center' });
                    // tambahkan padding bottom
                    var paddingBottom = 20; // misal 20pt
                    headingY += paddingBottom;

                    // simpan posisi terakhir heading untuk startY table
                    headerEndY = headingY;

                    
                 },
                // Tambahkan konfigurasi AutoTable bawaan seperti pada contoh awal
                autotable: {
                    startY: 130, // fallback startY
                    styles: {
                        cellPadding: 2,
                        rowHeight: 12,
                        fontSize: 8,
                        textColor: 50,
                        fontStyle: 'normal',
                        overflow: 'linebreak',
                        halign: 'left',
                        valign: 'middle',
                        lineWidth: 0.25,
                        lineColor: [0, 0, 0]
                    },
                    headerStyles: {
                        fillColor: [230, 230, 230],
                        textColor: 0,
                        fontStyle: 'bold',
                        halign: 'center',
                        valign: 'middle',
                        lineWidth: 0.35,
                        lineColor: [0, 0, 0]
                    },
                    alternateRowStyles: { fillColor: 245 },
                    tableExport: {
                        onBeforeAutotable: function($el, columns, rows, atOptions){
                            try {
                                atOptions = atOptions || {};
                                atOptions.startY = (headerEndY ? headerEndY + 8 : 130);
                            } catch(e) {}
                        }
                    }
                }
            };

            // Hook alternatif untuk beberapa versi tableExport
            export_options['onBeforeAutotable'] = function($el, columns, rows, atOptions){
                try {
                    atOptions = atOptions || {};
                    atOptions.startY = (headerEndY ? headerEndY + 8 : 170);
                } catch(e) {}
            };
            // the following callback method is necessary to prevent XSS vulnerabilities
            // (this is taken from Bootstrap Tables's default wrapper around jQuery Table Export)
            export_options['onCellHtmlData'] = function (cell, rowIndex, colIndex, htmlData) {
                if (cell.is('th')) {
                    return cell.find('.th-inner').text()
                }
                return htmlData
            }
            // Normalisasi tanggal saat ekspor dan pastikan kolom Actions kosong (diabaikan)
            export_options['onCellData'] = function ($cell, rowIndex, colIndex, cellText) {
                try {
                    var $tbl = $cell.closest('table');
                    var $th = $tbl.find('thead th').eq(colIndex);
                    var headerText = $.trim($th.text()).toLowerCase();
                    var dataField = ($th.data('field') || '').toString().toLowerCase();
                    if (dataField === 'actions' || headerText === 'actions' || headerText === 'aksi' || headerText === '{{ strtolower(trans("table.actions")) }}') {
                        return '';
                    }
                    if (headerText.indexOf('tanggal') !== -1) {
                        var s = (cellText || '').toString().trim();
                        var m = s.match(/^(\d{4})[-\/.](\d{2})[-\/.](\d{2})(.*)$/);
                        if (m) {
                            var rest = (m[4] || '').trim();
                            var out = m[3] + '-' + m[2] + '-' + m[1];
                            return rest ? (out + ' ' + rest) : out;
                        }
                        var m2 = s.match(/^(\d{2})[-\/.](\d{2})[-\/.](\d{4})(.*)$/);
                        if (m2) {
                            var rest2 = (m2[4] || '').trim();
                            var out2 = m2[1] + '-' + m2[2] + '-' + m2[3];
                            return rest2 ? (out2 + ' ' + rest2) : out2;
                        }
                    }
                } catch (e) {}
                return cellText;
            };
            $table.bootstrapTable({
            classes: 'table table-responsive table-no-bordered',
            ajaxOptions: {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            },
            // reorderableColumns: true,
            stickyHeader: true,
            stickyHeaderOffsetLeft: parseInt($('body').css('padding-left'), 10),
            stickyHeaderOffsetRight: parseInt($('body').css('padding-right'), 10),
            locale: locale,
            undefinedText: '',
            iconsPrefix: 'fa',
            cookieStorage: '{{ config('session.bs_table_storage') }}',
            cookie: true,
            cookieExpire: '2y',
            mobileResponsive: true,
            maintainSelected: true,
            trimOnSearch: false,
            showSearchClearButton: true,
            paginationFirstText: "{{ trans('general.first') }}",
            paginationLastText: "{{ trans('general.last') }}",
            paginationPreText: "{{ trans('general.previous') }}",
            paginationNextText: "{{ trans('general.next') }}",
            pageList: ['10','20', '30','50','100','150','200'{!! ((config('app.max_results') > 200) ? ",'500'" : '') !!}{!! ((config('app.max_results') > 500) ? ",'".config('app.max_results')."'" : '') !!}],
            pageSize: {{  (($snipeSettings->per_page!='') && ($snipeSettings->per_page > 0)) ? $snipeSettings->per_page : 20 }},
            paginationVAlign: 'both',
            queryParams: function (params) {
                var newParams = {};
                for(var i in params) {
                    if(!keyBlocked(i)) { // only send the field if it's not in blockedFields
                        newParams[i] = params[i];
                    }
                }
                return newParams;
            },
            formatLoadingMessage: function () {
                return '<h2><i class="fas fa-spinner fa-spin" aria-hidden="true"></i> {{ trans('general.loading') }} </h4>';
            },
            icons: {
                advancedSearchIcon: 'fas fa-search-plus',
                paginationSwitchDown: 'fa-caret-square-o-down',
                paginationSwitchUp: 'fa-caret-square-o-up',
                fullscreen: 'fa-expand',
                columns: 'fa-columns',
                refresh: 'fas fa-sync-alt',
                export: 'fa-download',
                clearSearch: 'fa-times'
            },
                exportOptions: export_options,

            exportTypes: ['xlsx', 'excel', 'csv', 'pdf','json', 'xml', 'txt', 'sql', 'doc' ],
            onLoadSuccess: function () {
                $('[data-tooltip="true"]').tooltip(); // Needed to attach tooltips after ajax call
            }

            });

        });
    });





    function dateRowCheckStyle(value) {
        if ((value.days_to_next_audit) && (value.days_to_next_audit < {{ $snipeSettings->audit_warning_days ?: 0 }})) {
            return { classes : "danger" }
        }
        return {};
    }


    // These methods dynamically add/remove hidden input values in the bulk actions form
    $('.snipe-table').on('check.bs.table .btSelectItem', function (row, $element) {
        var buttonName =  $(this).data('bulk-button-id');
        var tableId =  $(this).data('id-table');

        $(buttonName).removeAttr('disabled');
        $(buttonName).after('<input id="' + tableId + '_checkbox_' + $element.id + '" type="hidden" name="ids[]" value="' + $element.id + '">');
    });

    $('.snipe-table').on('check-all.bs.table', function (event, rowsAfter) {

        var buttonName =  $(this).data('bulk-button-id');
        $(buttonName).removeAttr('disabled');
        var tableId =  $(this).data('id-table');

        for (var i in rowsAfter) {
            // Do not select things that were already selected
            if($('#'+ tableId + '_checkbox_' + rowsAfter[i].id).length == 0) {
                $(buttonName).after('<input id="' + tableId + '_checkbox_' + rowsAfter[i].id + '" type="hidden" name="ids[]" value="' + rowsAfter[i].id + '">');
            }
        }
    });


    $('.snipe-table').on('uncheck.bs.table .btSelectItem', function (row, $element) {
        var tableId =  $(this).data('id-table');
        $( "#" + tableId + "_checkbox_" + $element.id).remove();
    });


    // Handle whether or not the edit button should be disabled
    $('.snipe-table').on('uncheck.bs.table', function () {

        var buttonName =  $(this).data('bulk-button-id');

        if ($(this).bootstrapTable('getSelections').length == 0) {
            $(buttonName).attr('disabled', 'disabled');
        }
    });

    $('.snipe-table').on('uncheck-all.bs.table', function (event, rowsAfter, rowsBefore) {

        var buttonName =  $(this).data('bulk-button-id');
        $(buttonName).attr('disabled', 'disabled');
        var tableId =  $(this).data('id-table');

        for (var i in rowsBefore) {
            $('#' + tableId + "_checkbox_" + rowsBefore[i].id).remove();
        }

    });

    // Initialize sort-order for bulk actions (label-generation) for snipe-tables
    $('.snipe-table').each(function (i, table) {
        table_cookie_segment = $(table).data('cookie-id-table');
        sort = '';
        order = '';
        cookies = document.cookie.split(";");
        for(i in cookies) {
            cookiedef = cookies[i].split("=", 2);
            cookiedef[0] = cookiedef[0].trim();
            if (cookiedef[0] == table_cookie_segment + ".bs.table.sortOrder") {
                order = cookiedef[1];
            }
            if (cookiedef[0] == table_cookie_segment + ".bs.table.sortName") {
                sort = cookiedef[1];
            }
        }
        if (sort && order) {
            domnode = $($(this).data('bulk-form-id')).get(0);
            if ( domnode && domnode.elements && domnode.elements.sort ) {
                domnode.elements.sort.value = sort;
                domnode.elements.order.value = order;
            }
        }
    });

    // If sort order changes, update the sort-order for bulk-actions (for label-generation)
    $('.snipe-table').on('sort.bs.table', function (event, name, order) {
       domnode = $($(this).data('bulk-form-id')).get(0);
       // make safe in case there isn't a bulk-form-id, or it's not found, or has no 'sort' element
       if ( domnode && domnode.elements && domnode.elements.sort ) {
           domnode.elements.sort.value = name;
           domnode.elements.order.value = order;
       }
    });


    

    // This only works for model index pages because it uses the row's model ID
    function genericRowLinkFormatter(destination) {
        return function (value,row) {
            if (value) {
                return '<a href="{{ config('app.url') }}/' + destination + '/' + row.id + '">' + value + '</a>';
            }
        };
    }

    // Use this when we're introspecting into a column object and need to link
    function genericColumnObjLinkFormatter(destination) {
        return function (value,row) {
            if ((value) && (value.status_meta)) {

                var text_color;
                var icon_style;
                var text_help;
                var status_meta = {
                  'deployed': '{{ strtolower(trans('general.deployed')) }}',
                  'deployable': '{{ strtolower(trans('admin/hardware/general.deployable')) }}',
                  'archived': '{{ strtolower(trans('general.archived')) }}',
                  'pending': '{{ strtolower(trans('general.pending')) }}'
                }

                switch (value.status_meta) {
                    case 'deployed':
                        text_color = 'blue';
                        icon_style = 'fa-circle';
                        text_help = '<label class="label label-default">{{ trans('general.deployed') }}</label>';
                    break;
                    case 'deployable':
                        text_color = 'green';
                        icon_style = 'fa-circle';
                        text_help = '';
                    break;
                    case 'pending':
                        text_color = 'orange';
                        icon_style = 'fa-circle';
                        text_help = '';
                        break;
                    default:
                        text_color = 'red';
                        icon_style = 'fa-times';
                        text_help = '';
                }

                return '<nobr><a href="{{ config('app.url') }}/' + destination + '/' + value.id + '" data-tooltip="true" title="'+ status_meta[value.status_meta] + '"> <i class="fa ' + icon_style + ' text-' + text_color + '"></i> ' + value.name + ' ' + text_help + ' </a> </nobr>';
            } else if ((value) && (value.name)) {

                // Add some overrides for any funny urls we have
                var dest = destination;
                var dpolymorphicItemFormatterest = '';
                if (destination=='fieldsets') {
                    var dpolymorphicItemFormatterest = 'fields/';
                }

                return '<nobr><a href="{{ config('app.url') }}/' + dpolymorphicItemFormatterest + dest + '/' + value.id + '">' + value.name + '</a></span>';
            }
        };
    }

    function hardwareAuditFormatter(value, row) {
        return '<a href="{{ config('app.url') }}/hardware/audit/' + row.id + '/" class="btn btn-sm bg-yellow" data-tooltip="true" title="Audit this item">{{ trans('general.audit') }}</a>';
    }


    // Make the edit/delete buttons
    function genericActionsFormatter(owner_name, element_name) {
        if (!element_name) {
            element_name = '';
        }

        return function (value,row) {

            var actions = '<nobr>';

            // Add some overrides for any funny urls we have
            var dest = owner_name;

            if (dest =='groups') {
                var dest = 'admin/groups';
            }

            if (dest =='maintenances') {
                var dest = 'hardware/maintenances';
            }

            if(element_name != '') {
                dest = dest + '/' + row.owner_id + '/' + element_name;
            }

            if ((row.available_actions) && (row.available_actions.clone === true)) {
                actions += '<a href="{{ config('app.url') }}/' + dest + '/' + row.id + '/clone" class="actions btn btn-sm btn-info" data-tooltip="true" title="{{ trans('general.clone_item') }}"><i class="far fa-clone" aria-hidden="true"></i><span class="sr-only">Clone</span></a>&nbsp;';
            }

            if ((row.available_actions) && (row.available_actions.update === true)) {
                actions += '<a href="{{ config('app.url') }}/' + dest + '/' + row.id + '/edit" class="actions btn btn-sm btn-warning" data-tooltip="true" title="{{ trans('general.update') }}"><i class="fas fa-pencil-alt" aria-hidden="true"></i><span class="sr-only">{{ trans('general.update') }}</span></a>&nbsp;';
                actions += '<a href="{{ config('app.url') }}/' + dest + '/' + row.id + '" '
                    + ' class="actions btn btn-danger btn-sm delete-asset " data-tooltip="true"  '
                    + ' data-toggle="modal" '
                    + ' data-content="{{ trans('general.sure_to_delete') }} ' + name_for_box + '?" '
                    + ' data-title="{{  trans('general.delete') }}" onClick="return false;">'
                    + '<i class="fas fa-trash" aria-hidden="true"></i><span class="sr-only">{{ trans('general.delete') }}</span></a>&nbsp;';
                
            } else {
                if ((row.available_actions) && (row.available_actions.update != true)) {
                    actions += '<span data-tooltip="true" title="{{ trans('general.cannot_be_edited') }}"><a class="btn btn-warning btn-sm disabled" onClick="return false;"><i class="fas fa-pencil-alt"></i></a></span>&nbsp;';
                    actions += '<span data-tooltip="true" title="{{ trans('general.cannot_be_deleted') }}"><a href="{{ config('app.url') }}/' + dest + '/' + row.id + '" '
                    + ' class="actions btn btn-danger btn-sm delete-asset disabled" data-tooltip="true"  '
                    + ' data-content="{{ trans('general.sure_to_delete') }} ' + name_for_box + '?" '
                    + ' data-title="{{  trans('general.delete') }}" onClick="return false;">'
                    + '<i class="fas fa-trash" aria-hidden="true"></i><span class="sr-only">{{ trans('general.delete') }}</span></a>&nbsp;';
                }
            }


            if ((row.available_actions) && (row.available_actions.delete === true)) {

                // use the asset tag if no name is provided
                var name_for_box = row.name
                if (row.name=='') {
                    var name_for_box = row.asset_tag
                }
                
                // actions += '<a href="{{ config('app.url') }}/' + dest + '/' + row.id + '" '
                //     + ' class="actions btn btn-danger btn-sm delete-asset" data-tooltip="true"  '
                //     + ' data-toggle="modal" '
                //     + ' data-content="{{ trans('general.sure_to_delete') }} ' + name_for_box + '?" '
                //     + ' data-title="{{  trans('general.delete') }}" onClick="return false;">'
                //     + '<i class="fas fa-trash" aria-hidden="true"></i><span class="sr-only">{{ trans('general.delete') }}</span></a>&nbsp;';
                
                    
            } else {
                // Do not show the delete button on things that are already deleted
                if ((row.available_actions) && (row.available_actions.restore != true)) {
                    actions += '<span data-tooltip="true" title="{{ trans('general.cannot_be_deleted') }}"><a class="btn btn-danger btn-sm delete-asset disabled" onClick="return false;"><i class="fas fa-trash"></i></a></span>&nbsp;';
                }
                

            }


            if ((row.available_actions) && (row.available_actions.restore === true)) {
                actions += '<form style="display: inline;" method="POST" action="{{ config('app.url') }}/' + dest + '/' + row.id + '/restore"> ';
                actions += '@csrf';
                actions += '<button class="btn btn-sm btn-warning" data-tooltip="true" title="{{ trans('general.restore') }}"><i class="fas fa-retweet"></i></button>&nbsp;';
            }

            actions +='</nobr>';
            return actions;

        };
    }
    
    function genericActionsFormatterHardware(owner_name, element_name) {
        if (!element_name) {
            element_name = '';
        }

        return function (value,row) {

            console.log(row);

            var actions = '<nobr>';

            // Add some overrides for any funny urls we have
            var dest = owner_name;

            if (dest =='groups') {
                var dest = 'admin/groups';
            }

            if (dest =='maintenances') {
                var dest = 'hardware/maintenances';
            }

            if(element_name != '') {
                dest = dest + '/' + row.owner_id + '/' + element_name;
            }


            if ((row.available_actions) && (row.available_actions.pemasukan === true)) {
                actions += '<a href="{{ config('app.url') }}/' + dest + '/' + row.id + '/pemasukan" class="actions btn btn-sm btn-info" data-tooltip="true" title="{{ trans('Pemasukan') }}"><i class="fa fa-arrow-left" aria-hidden="true"></i><span class="sr-only">Pemasukan</span></a>&nbsp;';
            }else{
                actions += '<a href="{{ config('app.url') }}/' + dest + '/' + row.id + '/pemasukan" class="actions btn btn-sm btn-info disabled" data-tooltip="true" title="{{ trans('Pemasukan') }}"><i class="fa fa-arrow-left" aria-hidden="true"></i><span class="sr-only">Pemasukan</span></a>&nbsp;';
            }

            if ((row.available_actions) && (row.available_actions.pengeluaran === true)) {
                actions += '<a href="{{ config('app.url') }}/' + dest + '/' + row.id + '/checkout" class="actions btn btn-sm btn-primary" data-tooltip="true" title="{{ trans('Pengeluaran') }}"><i class="fa fa-arrow-right" aria-hidden="true"></i><span class="sr-only">Pengeluaran</span></a>&nbsp;';
            }else{
                actions += '<a href="{{ config('app.url') }}/' + dest + '/' + row.id + '/checkout" class="actions btn btn-sm btn-primary disabled" data-tooltip="true" title="{{ trans('Pengeluaran') }}"><i class="fa fa-arrow-right" aria-hidden="true"></i><span class="sr-only">Pengeluaran</span></a>&nbsp;';
            }

            if ((row.available_actions) && (row.available_actions.stockOpname === true)) {
                actions += '<a href="{{ config('app.url') }}/' + dest + '/' + row.id + '/stockOpname" class="actions btn btn-sm btn-danger" data-tooltip="true" title="{{ trans('Stock Opname') }}"><i class="fa fa-warehouse" aria-hidden="true"></i><span class="sr-only">Stock Opname</span></a>&nbsp;';
            }else{
                actions += '<a href="{{ config('app.url') }}/' + dest + '/' + row.id + '/stockOpname" class="actions btn btn-sm btn-danger disabled" data-tooltip="true" title="{{ trans('Stock Opname') }}"><i class="fa fa-warehouse" aria-hidden="true"></i><span class="sr-only">Stock Opname</span></a>&nbsp;';
            }

            if ((row.available_actions) && (row.available_actions.adjusment === true)) {
                actions += '<a href="{{ config('app.url') }}/' + dest + '/' + row.id + '/adjusment" class="actions btn btn-sm btn-success" data-tooltip="true" title="{{ trans('Adjusment') }}"><i class="fa fa-gear" aria-hidden="true"></i><span class="sr-only">Adjusment</span></a>&nbsp;';
            }else{
                actions += '<a href="{{ config('app.url') }}/' + dest + '/' + row.id + '/adjusment" class="actions btn btn-sm btn-success disabled" data-tooltip="true" title="{{ trans('Adjusment') }}"><i class="fa fa-gear" aria-hidden="true"></i><span class="sr-only">Adjusment</span></a>&nbsp;';
                
            }

            

            {{--  if ((row.available_actions) && (row.available_actions.clone === true)) {
                actions += '<a href="{{ config('app.url') }}/' + dest + '/' + row.id + '/clone" class="actions btn btn-sm btn-info" data-tooltip="true" title="{{ trans('general.clone_item') }}"><i class="far fa-clone" aria-hidden="true"></i><span class="sr-only">Clone</span></a>&nbsp;';
            }  --}}

            if ((row.available_actions) && (row.available_actions.update === true)) {
                actions += '<a href="{{ config('app.url') }}/' + dest + '/' + row.id + '/edit" class="actions btn btn-sm btn-warning" data-tooltip="true" title="{{ trans('general.update') }}"><i class="fas fa-pencil-alt" aria-hidden="true"></i><span class="sr-only">{{ trans('general.update') }}</span></a>&nbsp;';
            } else {
                if ((row.available_actions) && (row.available_actions.update != true)) {
                    actions += '<span data-tooltip="true" title="{{ trans('general.cannot_be_edited') }}"><a class="btn btn-warning btn-sm disabled" onClick="return false;"><i class="fas fa-pencil-alt"></i></a></span>&nbsp;';
                }
            }

            if ((row.available_actions) && (row.available_actions.delete === true)) {

                // use the asset tag if no name is provided
                var name_for_box = row.name
                if (row.name=='') {
                    var name_for_box = row.asset_tag
                }
                
                actions += '<a href="{{ config('app.url') }}/' + dest + '/' + row.id + '" '
                    + ' class="actions btn btn-danger btn-sm delete-asset" data-tooltip="true"  '
                    + ' data-toggle="modal" '
                    + ' data-content="{{ trans('general.sure_to_delete') }} ' + name_for_box + '?" '
                    + ' data-title="{{  trans('general.delete') }}" onClick="return false;">'
                    + '<i class="fas fa-trash" aria-hidden="true"></i><span class="sr-only">{{ trans('general.delete') }}</span></a>&nbsp;';                
            } else {
                // Do not show the delete button on things that are already deleted
                if ((row.available_actions) && (row.available_actions.restore != true)) {
                    actions += '<span data-tooltip="true" title="{{ trans('general.cannot_be_deleted') }}"><a class="btn btn-danger btn-sm delete-asset disabled" onClick="return false;"><i class="fas fa-trash"></i></a></span>&nbsp;';
                }

            }


            if ((row.available_actions) && (row.available_actions.restore === true)) {
                actions += '<form style="display: inline;" method="POST" action="{{ config('app.url') }}/' + dest + '/' + row.id + '/restore"> ';
                actions += '@csrf';
                actions += '<button class="btn btn-sm btn-warning" data-tooltip="true" title="{{ trans('general.restore') }}"><i class="fas fa-retweet"></i></button>&nbsp;';
            }

            actions +='</nobr>';
            return actions;

        };
    }


    // This handles the icons and display of polymorphic entries
    function polymorphicItemFormatter(value) {

        var item_destination = '';
        var item_icon;

        if ((value) && (value.type)) {

            if (value.type == 'asset') {
                item_destination = 'hardware';
                item_icon = 'fas fa-barcode';
            } else if (value.type == 'accessory') {
                item_destination = 'accessories';
                item_icon = 'far fa-keyboard';
            } else if (value.type == 'component') {
                item_destination = 'components';
                item_icon = 'far fa-hdd';
            } else if (value.type == 'consumable') {
                item_destination = 'consumables';
                item_icon = 'fas fa-tint';
            } else if (value.type == 'license') {
                item_destination = 'licenses';
                item_icon = 'far fa-save';
            } else if (value.type == 'user') {
                item_destination = 'users';
                item_icon = 'fas fa-user';
            } else if (value.type == 'location') {
                item_destination = 'locations'
                item_icon = 'fas fa-map-marker-alt';
            } else if (value.type == 'model') {
                item_destination = 'models'
                item_icon = '';
            }

            // display the username if it's checked out to a user, but don't do it if the username's there already
            if (value.username && !value.name.match('\\(') && !value.name.match('\\)')) {
                value.name = value.name + ' (' + value.username + ')';
            }

            return '<nobr><a href="{{ config('app.url') }}/' + item_destination +'/' + value.id + '" data-tooltip="true" title="' + value.type + '"><i class="' + item_icon + ' text-{{ $snipeSettings->skin!='' ? $snipeSettings->skin : 'blue' }} "></i> ' + value.name + '</a></nobr>';

        } else {
            return '';
        }


    }

    // This just prints out the item type in the activity report
    function itemTypeFormatter(value, row) {

        if ((row) && (row.item) && (row.item.type)) {
            return row.item.type;
        }
    }


    // Convert line breaks to <br>
    function notesFormatter(value) {
        if (value) {
            return value.replace(/(?:\r\n|\r|\n)/g, '<br />');;
        }
    }


    // We need a special formatter for license seats, since they don't work exactly the same
    // Checkouts need the license ID, checkins need the specific seat ID

    function licenseSeatInOutFormatter(value, row) {
        // The user is allowed to check the license seat out and it's available
        if ((row.available_actions.checkout == true) && (row.user_can_checkout == true) && ((!row.asset_id) && (!row.assigned_to))) {
            return '<a href="{{ config('app.url') }}/licenses/' + row.license_id + '/checkout/'+row.id+'" class="btn btn-sm bg-maroon" data-tooltip="true" title="{{ trans('general.checkout_tooltip') }}">{{ trans('general.checkout') }}</a>';
        } else {
            return '<a href="{{ config('app.url') }}/licenses/' + row.id + '/checkin" class="btn btn-sm bg-purple" data-tooltip="true" title="Check in this license seat.">{{ trans('general.checkin') }}</a>';
        }

    }

    function genericCheckinCheckoutFormatter(destination) {
        return function (value,row) {

            // The user is allowed to check items out, AND the item is deployable
            if ((row.available_actions.checkout == true) && (row.user_can_checkout == true) && ((!row.asset_id) && (!row.assigned_to))) {

                    return '<a href="{{ config('app.url') }}/' + destination + '/' + row.id + '/checkout" class="btn btn-sm bg-maroon" data-tooltip="true" title="{{ trans('general.checkout_tooltip') }}">{{ trans('general.checkout') }}</a>';

            // The user is allowed to check items out, but the item is not able to be checked out
            } else if (((row.user_can_checkout == false)) && (row.available_actions.checkout == true) && (!row.assigned_to)) {

                // We use slightly different language for assets versus other things, since they are the only
                // item that has a status label
                if (destination =='hardware') {
                    return '<span  data-tooltip="true" title="{{ trans('admin/hardware/general.undeployable_tooltip') }}"><a class="btn btn-sm bg-maroon disabled">{{ trans('general.checkout') }}</a></span>';
                } else {
                    return '<span  data-tooltip="true" title="{{ trans('general.undeployable_tooltip') }}"><a class="btn btn-sm bg-maroon disabled">{{ trans('general.checkout') }}</a></span>';
                }

            // The user is allowed to check items in
            } else if (row.available_actions.checkin == true)  {
                if (row.assigned_to) {
                    return '<a href="{{ config('app.url') }}/' + destination + '/' + row.id + '/checkin" class="btn btn-sm bg-purple" data-tooltip="true" title="Check this item in so it is available for re-imaging, re-issue, etc.">{{ trans('general.checkin') }}</a>';
                } else if (row.assigned_pivot_id) {
                    return '<a href="{{ config('app.url') }}/' + destination + '/' + row.assigned_pivot_id + '/checkin" class="btn btn-sm bg-purple" data-tooltip="true" title="Check this item in so it is available for re-imaging, re-issue, etc.">{{ trans('general.checkin') }}</a>';
                }

            }

        }


    }


    // This is only used by the requestable assets section
    function assetRequestActionsFormatter (row, value) {
        if (value.assigned_to_self == true){
            return '<button class="btn btn-danger btn-sm disabled" data-tooltip="true" title="Cancel this item request">{{ trans('button.cancel') }}</button>';
        } else if (value.available_actions.cancel == true)  {
            return '<form action="{{ config('app.url') }}/account/request-asset/'+ value.id + '" method="POST">@csrf<button class="btn btn-danger btn-sm" data-tooltip="true" title="Cancel this item request">{{ trans('button.cancel') }}</button></form>';
        } else if (value.available_actions.request == true)  {
            return '<form action="{{ config('app.url') }}/account/request-asset/'+ value.id + '" method="POST">@csrf<button class="btn btn-primary btn-sm" data-tooltip="true" title="Request this item">{{ trans('button.request') }}</button></form>';
        }

    }



    var formatters = [
        'hardware',
        'accessories',
        'consumables',
        'components',
        'locations',
        'users',
        'manufacturers',
        'maintenances',
        'statuslabels',
        'models',
        'licenses',
        'categories',
        'suppliers',
        'departments',
        'companies',
        'depreciations',
        'fieldsets',
        'groups',
        'kits',
        'pemasukan',
        'pengeluaran',
        'stockopname',
        'adjusment',
    ];

    for (var i in formatters) {
        window[formatters[i] + 'LinkFormatter'] = genericRowLinkFormatter(formatters[i]);
        window[formatters[i] + 'LinkObjFormatter'] = genericColumnObjLinkFormatter(formatters[i]);
        window[formatters[i] + 'ActionsFormatter'] = genericActionsFormatter(formatters[i]);
        window[formatters[i] + 'ActionsFormatterHardware'] = genericActionsFormatterHardware(formatters[i]);
        window[formatters[i] + 'InOutFormatter'] = genericCheckinCheckoutFormatter(formatters[i]);
    }

    var child_formatters = [
        ['kits', 'models'],
        ['kits', 'licenses'],
        ['kits', 'consumables'],
        ['kits', 'accessories'],
        ['kits', 'pemasukan'],
        ['kits', 'pengeluaran'],
        ['kits', 'stockopname'],
        ['kits', 'adjusment'],
    ];

    for (var i in child_formatters) {
        var owner_name = child_formatters[i][0];
        var child_name = child_formatters[i][1];
        window[owner_name + '_' + child_name + 'ActionsFormatter'] = genericActionsFormatter(owner_name, child_name);
        window[owner_name + '_' + child_name + 'ActionsFormatterHardware'] = genericActionsFormatterHardware(owner_name, child_name);
    }



    // This is  gross, but necessary so that we can package the API response
    // for custom fields in a more useful way.
    function customFieldsFormatter(value, row) {


            if ((!this) || (!this.title)) {
                return '';
            }

            var field_column = this.title;

            // Pull out any HTMl that might be passed via the presenter
            // (for example, the locked icon for encrypted fields)
            var field_column_plain = field_column.replace(/<(?:.|\n)*?> ?/gm, '');
            if ((row.custom_fields) && (row.custom_fields[field_column_plain])) {

                // If the field type needs special formatting, do that here
                if ((row.custom_fields[field_column_plain].field_format) && (row.custom_fields[field_column_plain].value)) {
                    if (row.custom_fields[field_column_plain].field_format=='URL') {
                        return '<a href="' + row.custom_fields[field_column_plain].value + '" target="_blank" rel="noopener">' + row.custom_fields[field_column_plain].value + '</a>';
                    } else if (row.custom_fields[field_column_plain].field_format=='BOOLEAN') {
                        return (row.custom_fields[field_column_plain].value == 1) ? "<span class='fas fa-check-circle' style='color:green' />" : "<span class='fas fa-times-circle' style='color:red' />";
                    } else if (row.custom_fields[field_column_plain].field_format=='EMAIL') {
                        return '<a href="mailto:' + row.custom_fields[field_column_plain].value + '">' + row.custom_fields[field_column_plain].value + '</a>';
                    }
                }
                return row.custom_fields[field_column_plain].value;

            }

    }


    function createdAtFormatter(value) {
        if ((value) && (value.formatted)) {
            return value.formatted;
        }
    }

    function externalLinkFormatter(value) {

        if (value) {
            if ((value.indexOf("{") === -1) || (value.indexOf("}") ===-1)) {
                return '<nobr><a href="' + value + '" target="_blank" title="External link to ' + value + '" data-tooltip="true" ><i class="fa fa-external-link"></i> ' + value + '</a></nobr>';
            }
            return value;
        }
    }

    function groupsFormatter(value) {

        if (value) {
            var groups = '';
            for (var index in value.rows) {
                groups += '<a href="{{ config('app.url') }}/admin/groups/' + value.rows[index].id + '" class="label label-default">' + value.rows[index].name + '</a> ';
            }
            return groups;
        }
    }



    function changeLogFormatter(value) {

        var result = '';
        var pretty_index = '';

            for (var index in value) {


                // Check if it's a custom field
                if (index.startsWith('_snipeit_')) {
                    pretty_index = index.replace("_snipeit_", "Custom:_");
                } else {
                    pretty_index = index;
                }

                extra_pretty_index = prettyLog(pretty_index);

                result += extra_pretty_index + ': <del>' + value[index].old + '</del>  <i class="fas fa-long-arrow-alt-right" aria-hidden="true"></i> ' + value[index].new + '<br>'
            }

        return result;

    }

    function prettyLog(str) {
        let frags = str.split('_');
        for (let i = 0; i < frags.length; i++) {
            frags[i] = frags[i].charAt(0).toUpperCase() + frags[i].slice(1);
        }
        return frags.join(' ');
    }


    // Create a linked phone number in the table list
    function phoneFormatter(value) {
        if (value) {
            return  '<a href="tel:' + value + '">' + value + '</a>';
        }
    }


    function deployedLocationFormatter(row, value) {
        if ((row) && (row!=undefined)) {
            return '<a href="{{ config('app.url') }}/locations/' + row.id + '">' + row.name + '</a>';
        } else if (value.rtd_location) {
            return '<a href="{{ config('app.url') }}/locations/' + value.rtd_location.id + '" data-tooltip="true" title="Default Location">' + value.rtd_location.name + '</a>';
        }

    }

    function groupsAdminLinkFormatter(value, row) {
        return '<a href="{{ config('app.url') }}/admin/groups/' + row.id + '">' + value + '</a>';
    }

    function assetTagLinkFormatter(value, row) {
        if ((row.asset) && (row.asset.id)) {
            if (row.asset.deleted_at!='') {
                return '<span style="white-space: nowrap;"><i class="fas fa-times text-danger"></i><span class="sr-only">deleted</span> <del><a href="{{ config('app.url') }}/hardware/' + row.asset.id + '" data-tooltip="true" title="{{ trans('admin/hardware/general.deleted') }}">' + row.asset.asset_tag + '</a></del></span>';
            }
            return '<a href="{{ config('app.url') }}/hardware/' + row.asset.id + '">' + row.asset.asset_tag + '</a>';
        }
        return '';

    }

    function departmentNameLinkFormatter(value, row) {
        if ((row.assigned_user) && (row.assigned_user.department) && (row.assigned_user.department.name)) {
            return '<a href="{{ config('app.url') }}/departments/' + row.assigned_user.department.id + '">' + row.assigned_user.department.name + '</a>';
        }

    }

    function assetNameLinkFormatter(value, row) {
        if ((row.asset) && (row.asset.name)) {
            return '<a href="{{ config('app.url') }}/hardware/' + row.asset.id + '">' + row.asset.name + '</a>';
        }
    }

    function assetSerialLinkFormatter(value, row) {

        if ((row.asset) && (row.asset.serial)) {
            if (row.asset.deleted_at!='') {
                return '<span style="white-space: nowrap;"><i class="fas fa-times text-danger"></i><span class="sr-only">deleted</span> <del><a href="{{ config('app.url') }}/hardware/' + row.asset.id + '" data-tooltip="true" title="{{ trans('admin/hardware/general.deleted') }}">' + row.asset.serial + '</a></del></span>';
            }
            return '<a href="{{ config('app.url') }}/hardware/' + row.asset.id + '">' + row.asset.serial + '</a>';
        }
        return '';
    }

    function trueFalseFormatter(value) {
        if ((value) && ((value == 'true') || (value == '1'))) {
            return '<i class="fas fa-check text-success"></i><span class="sr-only">{{ trans('general.true') }}</span>';
        } else {
            return '<i class="fas fa-times text-danger"></i><span class="sr-only">{{ trans('general.false') }}</span>';
        }
    }

    function dateDisplayFormatter(value) {
        if (value) {
            return  value.formatted;
        }
    }

    function iconFormatter(value) {
        if (value) {
            return '<i class="' + value + '  icon-med"></i>';
        }
    }

    function emailFormatter(value) {
        if (value) {
            return '<a href="mailto:' + value + '">' + value + '</a>';
        }
    }

    function linkFormatter(value) {
        if (value) {
            return '<a href="' + value + '">' + value + '</a>';
        }
    }

    function assetCompanyFilterFormatter(value, row) {
        if (value) {
            return '<a href="{{ config('app.url') }}/hardware/?company_id=' + row.id + '">' + value + '</a>';
        }
    }

    function assetCompanyObjFilterFormatter(value, row) {
        if ((row) && (row.company)) {
            return '<a href="{{ config('app.url') }}/hardware/?company_id=' + row.company.id + '">' + row.company.name + '</a>';
        }
    }

    function usersCompanyObjFilterFormatter(value, row) {
        if (value) {
            return '<a href="{{ config('app.url') }}/users/?company_id=' + row.id + '">' + value + '</a>';
        } else {
            return value;
        }
    }

    function employeeNumFormatter(value, row) {

        if ((row) && (row.assigned_to) && ((row.assigned_to.employee_number))) {
            return '<a href="{{ config('app.url') }}/users/' + row.assigned_to.id + '">' + row.assigned_to.employee_number + '</a>';
        }
    }

    function orderNumberObjFilterFormatter(value, row) {
        if (value) {
            return '<a href="{{ config('app.url') }}/hardware/?order_number=' + row.order_number + '">' + row.order_number + '</a>';
        }
    }

    function auditImageFormatter(value){
        if (value){
            return '<a href="' + value.url + '" data-toggle="lightbox" data-type="image"><img src="' + value.url + '" style="max-height: {{ $snipeSettings->thumbnail_max_h }}px; width: auto;" class="img-responsive"></a>'
        }
    }


   function imageFormatter(value, row) {

        if (value) {

            // This is a clunky override to handle unusual API responses where we're presenting a link instead of an array
            if (row.avatar) {
                var altName = '';
            }
            else if (row.name) {
                var altName = row.name;
            }
            else if ((row) && (row.model)) {
                var altName = row.model.name;
           }
            return '<a href="' + value + '" data-toggle="lightbox" data-type="image"><img src="' + value + '" style="max-height: {{ $snipeSettings->thumbnail_max_h }}px; width: auto;" class="img-responsive" alt="' + altName + '"></a>';
        }
    }
    function downloadFormatter(value) {
        if (value) {
            return '<a href="' + value + '" target="_blank"><i class="fas fa-download"></i></a>';
        }
    }

    function fileUploadFormatter(value) {
        if ((value) && (value.url) && (value.inlineable)) {
            return '<a href="' + value.url + '" data-toggle="lightbox" data-type="image"><img src="' + value.url + '" style="max-height: {{ $snipeSettings->thumbnail_max_h }}px; width: auto;" class="img-responsive"></a>';
        } else if ((value) && (value.url)) {
            return '<a href="' + value.url + '" class="btn btn-default"><i class="fas fa-download"></i></a>';
        }
    }


    function fileUploadNameFormatter(value) {
        console.dir(value);
        if ((value) && (value.filename) && (value.url)) {
            return '<a href="' + value.url + '">' + value.filename + '</a>';
        }
    }

    function labelPerPageFormatter(value, row, index, field) {
        if (row) {
            if (!row.hasOwnProperty('sheet_info')) { return 1; }
            else { return row.sheet_info.labels_per_page; }
        }
    }

    function labelRadioFormatter(value, row, index, field) {
        if (row) {
            return row.name == '{{ str_replace("\\", "\\\\", $snipeSettings->label2_template) }}';
        }
    }

    function labelSizeFormatter(value, row) {
        if (row) {
            return row.width + ' x ' + row.height + ' ' + row.unit;
        }
    }

    function cleanFloat(number) {
        if(!number) { // in a JavaScript context, meaning, if it's null or zero or unset
            return 0.0;
        }
        if ("{{$snipeSettings->digit_separator}}" == "1.234,56") {
            // yank periods, change commas to periods
            periodless = number.toString().replace(/\./g,"");
            decimalfixed = periodless.replace(/,/g,".");
        } else {
            // yank commas, that's it.
            decimalfixed = number.toString().replace(/\,/g,"");
        }
        return parseFloat(decimalfixed);
    }

    function sumFormatter(data) {
        if (Array.isArray(data)) {
            var field = this.field;
            var total_sum = data.reduce(function(sum, row) {
                
                return (sum) + (cleanFloat(row[field]) || 0);
            }, 0);
            
            return numberWithCommas(total_sum.toFixed(2));
        }
        return 'not an array';
    }

    function sumFormatterQuantity(data){
        if(Array.isArray(data)) {
            
            // Prevents issues on page load where data is an empty array
            if(data[0] == undefined){
                return 0.00
            }
            // Check that we are actually trying to sum cost from a table
            // that has a quantity column. We must perform this check to
            // support licences which use seats instead of qty
            if('qty' in data[0]) {
                var multiplier = 'qty';
            } else if('seats' in data[0]) {
                var multiplier = 'seats';
            } else {
                return 'no quantity';
            }
            var total_sum = data.reduce(function(sum, row) {
                return (sum) + (cleanFloat(row["purchase_cost"])*row[multiplier] || 0);
            }, 0);
            return numberWithCommas(total_sum.toFixed(2));
        }
        return 'not an array';
    }

    function numberWithCommas(value) {
        
        if ((value) && ("{{$snipeSettings->digit_separator}}" == "1.234,56")){
            var parts = value.toString().split(".");
             parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".");
             return parts.join(",");
         } else {
             var parts = value.toString().split(",");
             parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
             return parts.join(".");
        }
        return value
    }

    $(function () {
        $('#bulkEdit').click(function () {
            var selectedIds = $('.snipe-table').bootstrapTable('getSelections');
            $.each(selectedIds, function(key,value) {
                $( "#bulkForm" ).append($('<input type="hidden" name="ids[' + value.id + ']" value="' + value.id + '">' ));
            });

        });
    });



    $(function() {

        // This handles the search box highlighting on both ajax and client-side
        // bootstrap tables
        var searchboxHighlighter = function (event) {

            $('.search-input').each(function (index, element) {

                if ($(element).val() != '') {
                    $(element).addClass('search-highlight');
                    $(element).next().children().addClass('search-highlight');
                } else {
                    $(element).removeClass('search-highlight');
                    $(element).next().children().removeClass('search-highlight');
                }
            });
        };

        $('.search button[name=clearSearch]').click(searchboxHighlighter);
        searchboxHighlighter({ name:'pageload'});
        $('.search-input').keyup(searchboxHighlighter);

        //  This is necessary to make the bootstrap tooltips work inside of the
        // wenzhixin/bootstrap-table formatters
        $('#table').on('post-body.bs.table', function () {
            $('[data-tooltip="true"]').tooltip({
                container: 'body'
            });


        });
    });

</script>

@endpush