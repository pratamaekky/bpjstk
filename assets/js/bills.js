!(function ($) {
    'use strict';

    var yankesItems = [
        'ranap', 'rajal'
    ];

    var items = {
        room: {
            type: 'selectMultiple',
            id: 'room',
            label: 'Kamar',
            placeholder: '-- Pilih Kamar --',
            text_add_new: 'Tambahkan kamar',
            subtotal: {
                readonly: true
            }
        },
        room_nurse: {
            type: 'emptyInline',
            id: 'room_nurse',
            label: 'Jasa Perawat Kamar',
            placeholder: 'Jasa Perawat Kamar',
            text_add_new: 'Tambahkan Perawat Kamar',
            subtotal: {
                readonly: false
            }
        },
        admin: {
            type: 'selectInline',
            id: 'admin',
            label: 'Administrasi',
            placeholder: '-- Pilih Administrasi --',
            text_add_new: 'Tambahkan Administrasi',
            subtotal: {
                readonly: false
            }
        },
        medicine: {
            type: 'emptyInline',
            id: 'medicine',
            label: 'Obat-obatan',
            placeholder: 'Paracetamol',
            text_add_new: 'Tambahkan Obat-obatan',
            subtotal: {
                readonly: false
            }
        },
        docter: {
            type: 'selectMultiple',
            id: 'docter',
            label: 'Dokter Umum / IGD',
            placeholder: '-- Pilih Dokter Umum / IGD --',
            text_add_new: 'Tambahkan Dokter Umum / IGD',
            subtotal: {
                readonly: true
            },
            with_do: true
        },
        surgery: {
            type: 'selectInline',
            id: 'surgery',
            label: 'Dokter Spesialis',
            placeholder: '-- Pilih Dokter Spesialis --',
            text_add_new: 'Tambahkan Dokter Spesialis',
            subtotal: {
                readonly: false
            },
            with_do: true
        },
        surgery_nurse: {
            type: 'emptyInline',
            id: 'surgery_nurse',
            label: 'Jasa Perawat Operasi',
            placeholder: 'Jasa Perawat Operasi',
            text_add_new: 'Tambahkan Perawat Operasi',
            subtotal: {
                readonly: false
            }
        },
        anestesi: {
            type: 'selectInline',
            id: 'anestesi',
            label: 'Dokter Anestesi',
            placeholder: '-- Pilih Dokter Anestesi --',
            text_add_new: 'Tambahkan Dokter Anestesi',
            subtotal: {
                readonly: false
            },
            with_do: true
        },
        laboratory: {
            type: 'selectMultiple',
            id: 'laboratory',
            label: 'Laboratorium',
            placeholder: '-- Pilih Laboratorium --',
            text_add_new: 'Tambahkan Laboratorium',
            subtotal: {
                readonly: true
            }
        },
        radiology: {
            type: 'selectMultiple',
            id: 'radiology',
            label: 'Radiologi',
            placeholder: '-- Pilih Radiologi --',
            text_add_new: 'Tambahkan Radiologi',
            subtotal: {
                readonly: true
            }
        },
        medic: {
            type: 'selectMultiple',
            id: 'medic',
            label: 'Medikal',
            placeholder: '-- Pilih Medikal --',
            text_add_new: 'Tambahkan Medikal',
            subtotal: {
                readonly: true
            }
        },
        rehab: {
            type: 'selectMultiple',
            id: 'rehab',
            label: 'Rehabilitasi',
            placeholder: '-- Pilih Rehabilitasi --',
            text_add_new: 'Tambahkan Rehabilitasi',
            subtotal: {
                readonly: true
            }
        },
        ambulance: {
            type: 'selectInline',
            id: 'ambulance',
            label: 'Ambulance',
            placeholder: '-- Pilih Ambulance --',
            text_add_new: 'Tambahkan Ambulance',
            subtotal: {
                readonly: false
            }
        }
    };

    var Elements, Calculation, Append;

    function resolve(path, obj) {
        return path.split('.').reduce(function (prev, curr) {
            return prev ? prev[curr] : null
        }, obj || self)
    }

    Elements = {
        create: function(data, baseUrl) {
            $.each(yankesItems, function(i, yankes) {
                var elems = '';
                $.each(items, function (index, item) {
                    var isWithDo;
                    switch (item.type) {
                        case 'emptyInline':
                            elems += Elements.emptyInline(yankes, item.label, item.id, item.text_add_new, item.placeholder, item.subtotal);
                            break;
                        case 'selectInline':
                            isWithDo = (typeof item.with_do !== 'undefined') ? item.with_do : false;
                            elems += Elements.selectInline(data, yankes, item.label, item.id, item.text_add_new, item.placeholder, item.subtotal, baseUrl, isWithDo);
                            break;
                        case 'selectMultiple':
                            isWithDo = (typeof item.with_do !== 'undefined') ? item.with_do : false;
                            elems += Elements.selectMultiple(data, yankes, item.label, item.id, item.text_add_new, item.placeholder, item.subtotal, baseUrl, isWithDo);
                            break;
                    }
                });

                $('#ctc-yankes-' + yankes).html(elems);
            });

            $.each(yankesItems, function (i, yankes) {
                $.each(items, function (index, item) {
                    if (item.type == 'selectInline' || item.type == 'selectMultiple') {
                        $('#' + yankes + '_' + item.id + '_1').select2({
                            theme: 'bootstrap4',
                            width: '100%'
                        }).one('select2:open', function (e) {
                            $('input.select2-search__field').prop('placeholder', 'Cari disini...');
                        });
                    }
                });
            });
        },

        emptyInline: function(yankes, label, id, text_add_new, placeholder, subtotal) {
            let isReadonly = subtotal.readonly == true ? 'readonly' : '';

            var elem = '' +
                '<div class="form-group col-12 separate-div-bottom pl-0" id="div_' + id + '">' +
                '   <div class="row">' +
                '       <label for="' + yankes + '_' + id + '_1" class="col-form-label col-sm-3 col-3">' + label + '</label>' +
                '       <div class="no-padding col-sm-9 col-9">' +
                '           <div class="row ' + yankes + '_row_' + id + '_div" id="' + yankes + '_row_' + id + '_div" data-count="1">' +
                '               <div class="row-flex ' + yankes + '_row_' + id + ' col-sm-12 col-12 pl-0" id="' + yankes + '_row_' + id + '_1">' +
                '                   <input type="text" name="yankes[' + yankes + '][' + id + '][1][value]" id="' + yankes + '_' + id + '_1" placeholder="Contoh: ' + placeholder + '" class="form-control col-sm-9 col-9" />' +
                '                   <label class="col-form-label col-sm-1 col-1 text-right">IDR</label>' +
                '                   <label class="row-flex col-sm-2 col-2 no-padding">' +
                '                       <input type="number" name="yankes[' + yankes + '][' + id + '][1][subtotal]" id="' + yankes + '_' + id + '_subtotal_1" class="' + yankes + '_' + id + '_subtotal form-control text-right col-sm-11 col-11" value="0" onblur="calculation.subtotalInline(\'' + yankes + '\', \'' + id + '\')" ' + isReadonly + '/>' +
                '                       <label class="col-sm-1 col-1">&nbsp;</label>' +
                '                   </label>' +
                '               </div>' +
                '           </div>' +
                '           <label class="col-form-label add-pic" onclick="append.emptyInline(\'' + yankes + '\', \'' + id + '\', \'' + placeholder + '\', \'' + isReadonly + '\');">+ ' + text_add_new + '</label>' +
                '           <div class="sbtotal row">' +
                '               <div class="row-flex col-sm-12 col-12 pl-0">' +
                '                   <label class="col-form-label col-sm-9 col-9 pl-0">Sub Total</label>' +
                '                   <label class="col-form-label col-sm-1 col-1 text-right">IDR</label>' +
                '                   <label class="row-flex col-sm-2 col-2 no-padding">' +
                '                       <input type="number" name="subtotal" id="' + yankes + '_total_' + id + '_subtotal" class="subtotal ' + yankes + '_total_' + id + '_subtotal form-control text-right col-sm-11 col-11" value="0" readonly />' +
                '                       <label class="col-sm-1 col-1">&nbsp;</label>' +
                '                   </label>' +
                '               </div>' +
                '           </div>' +
                '       </div>' +
                '   </div>' +
                '</div>';

            return elem;
        },

        selectInline: function(ajax, yankes, label, id, text_add_new, placeholder, subtotal, baseUrl, isWithDo) {
            let data = resolve(id, ajax);
            let isReadonly = subtotal.readonly == true ? 'readonly' : '';

            var elem =  '<div class="form-group col-12 separate-div-bottom pl-0" id="div_' + id + '">' +
                        '   <div class="row">' +
                        '       <label for="' + yankes + '_' + id + '_1" class="col-form-label col-sm-3 col-3">' + label + '</label>' +
                        '       <div class="no-padding col-sm-9 col-9">' +
                        '           <div class="row ' + yankes + '_row_' + id + '_div" id="' + yankes + '_row_' + id + '_div" data-count="1">' +
                        '               <div class="row-flex ' + yankes + '_row_' + id + ' col-sm-12 col-12 pl-0" id="' + yankes + '_row_' + id + '_1">' +
                        '                   <select name="yankes[' + yankes + '][' + id + '][1][value]" id="' + yankes + '_' + id + '_1" class="admin form-control select2 col-sm-9 col-9" data-id="1" onchange="calculation.subtotalSelectInline(this, \'' + yankes + '\', \'' + id + '\');">'+
                        '                       <option value="">' + placeholder + '</option>';

                $.each(data, function (index, value) {
                    elem += '                   <option value="' + value.id + '-' + value.fare + '">' + ((typeof value.name !== 'undefined') ? value.name : value.value) + '</option>';
                })

                elem += '                   </select>' +
                        '                   <label class="col-form-label col-sm-1 col-1 text-right">IDR</label>' +
                        '                   <label class="row-flex col-sm-2 col-2 no-padding">'+
                        '                       <input type="number" name="yankes[' + yankes + '][' + id + '][1][subtotal]" id="' + yankes + '_' + id + '_subtotal_1" class="' + yankes + '_' + id + '_subtotal form-control text-right col-sm-11 col-11" value="0" onblur="calculation.subtotalInline(\'' + yankes + '\', \'' + id + '\')" ' + isReadonly + '/>'+
                        '                       <label class="col-sm-1 col-1">&nbsp;</label>' +
                        '                   </label>' +
                        '               </div>';

                if (isWithDo == true) {
                    elem += '           <div class="row_' + id + '_do_div col-sm-12 col-12 pl-0 pr-0" id="row_' + id + '_do_div_1" data-count="0">' +
                            '           </div>' +
                            '           <label class="col-form-label add-pic ml-3" onclick="append.selectInlineDo(1, \'' + yankes + '\', \'' + id + '\');">+ Tambahkan Tindakan ' + label + '</label>';
                }

                elem += '           </div>' +
                        '           <label class="col-form-label add-pic" onclick="append.selectInline(\'' + baseUrl + '\', \'' + yankes + '\', \'' + id + '\', \'' + placeholder + '\', \'' + isReadonly + '\', \'' + isWithDo + '\');">+ ' + text_add_new + '</label>' +
                        '           <div class="sbtotal row">' +
                        '               <div class="row-flex col-sm-12 col-12 pl-0">' +
                        '                   <label class="col-form-label col-sm-9 col-9 pl-0">Sub Total</label>' +
                        '                   <label class="col-form-label col-sm-1 col-1 text-right">IDR</label>' +
                        '                   <label class="row-flex col-sm-2 col-2 no-padding">' +
                        '                       <input type="number" name="subtotal" id="' + yankes + '_total_' + id + '_subtotal" class="subtotal ' + yankes + '_total_' + id + '_subtotal form-control text-right col-sm-11 col-11" value="0" readonly />' +
                        '                       <label class="col-sm-1 col-1">&nbsp;</label>' +
                        '                   </label>' +
                        '               </div>' +
                        '           </div>' +
                        '       </div>' +
                        '   </div>' +
                        '</div>';

            return elem;
        },

        selectMultiple: function (ajax, yankes, label, id, text_add_new, placeholder, subtotal, baseUrl, isWithDo) {
            let data = resolve(id, ajax);
            let isReadonly = subtotal.readonly == true ? 'readonly' : '';

            var elem = '<div class="form-group col-12 separate-div-bottom pl-0" id="div_' + id + '">' +
                '   <div class="row">' +
                '       <label for="' + yankes + '_' + id + '_1" class="col-form-label col-sm-3 col-3">' + label + '</label>' +
                '       <div class="no-padding col-sm-9 col-9">' +
                '           <div class="row ' + yankes + '_row_' + id + '_div" id="' + yankes + '_row_' + id + '_div" data-count="1">' +
                '               <div class="row-flex ' + yankes + '_row_' + id + ' col-sm-12 col-12 pl-0" id="' + yankes + '_row_' + id + '_1">' +
                '                   <select name="yankes[' + yankes + '][' + id + '][1][value]" id="' + yankes + '_' + id + '_1" class="admin form-control select2 col-sm-4 col-4" data-id="1" onchange="calculation.subtotalSelectMultiple(this, \'' + yankes + '\', \'' + id + '\');">' +
                '                       <option value="">' + placeholder + '</option>';

            $.each(data, function (index, value) {
                elem += '                   <option value="' + value.id + '-' + value.fare + '">' + ((typeof value.name !== 'undefined') ? value.name : value.value) + '</option>';
            })

            elem += '               </select>' +
                '                   <div class="row-flex col-sm-2 col-2">' +
                '                       <input type="number" name="yankes[' + yankes + '][' + id + '][1][qty]" id="' + yankes + '_' + id + '_days_1" class="room_days form-control col-sm-8 col-8" min="1" value="1" data-id="1" onchange="calculation.subtotalSelectMultiple(this, \'' + yankes + '\', \'' + id + '\', true);" />' +
                '                       <label class="col-form-label col-sm-4 col-4 text-center"> Hari</label>' +
                '                   </div>' +
                '                   <div class="row-flex col-form-label col-sm-1 col-1 text-right pl-0 pr-0">' +
                '                       <label class="col-sm-5 col-5 text-center no-padding">X</label>' +
                '                       <label class="col-sm-7 col-7 pl-0">IDR</label>' +
                '                   </div>' +
                '                   <input type="number" name="yankes[' + yankes + '][' + id + '][1][rate]" id="' + yankes + '_' + id + '_rate_1" class="room_rate form-control text-right col-sm-2 col-2" value="0" data-id="1" onblur="calculation.subtotalSelectMultiple(this, \'' + yankes + '\', \'' + id + '\', false, true);" />' +
                '                   <label class="col-form-label col-sm-1 col-1 text-right">IDR</label>' +
                '                   <label class="row-flex col-sm-2 col-2 no-padding">' +
                '                       <input type="number" name="yankes[' + yankes + '][' + id + '][1][subtotal]" id="' + yankes + '_' + id + '_subtotal_1" class="' + yankes + '_' + id + '_subtotal form-control text-right col-sm-11 col-11" value="0" ' + isReadonly + '/>' +
                '                       <label class="col-sm-1 col-1">&nbsp;</label>' +
                '                   </label>' +
                '               </div>';

            if (isWithDo == true) {
                elem += '           <div class="row_' + id + '_do_div col-sm-12 col-12 pl-0 pr-0" id="row_' + id + '_do_div_1" data-count="0">' +
                    '           </div>' +
                    '           <label class="col-form-label add-pic ml-3" onclick="append.selectInlineDo(1, \'' + yankes + '\', \'' + id + '\');">+ Tambahkan Tindakan ' + label + '</label>';
            }

            elem += '           </div>' +
                '           <label class="col-form-label add-pic" onclick="append.selectMultiple(\'' + baseUrl + '\', \'' + yankes + '\', \'' + id + '\', \'' + placeholder + '\', \'' + isReadonly + '\', \'' + isWithDo + '\');">+ ' + text_add_new + '</label>' +
                '           <div class="sbtotal row">' +
                '               <div class="row-flex col-sm-12 col-12 pl-0">' +
                '                   <label class="col-form-label col-sm-9 col-9 pl-0">Sub Total</label>' +
                '                   <label class="col-form-label col-sm-1 col-1 text-right">IDR</label>' +
                '                   <label class="row-flex col-sm-2 col-2 no-padding">' +
                '                       <input type="number" name="subtotal" id="' + yankes + '_total_' + id + '_subtotal" class="subtotal ' + yankes + '_total_' + id + '_subtotal form-control text-right col-sm-11 col-11" value="0" readonly />' +
                '                       <label class="col-sm-1 col-1">&nbsp;</label>' +
                '                   </label>' +
                '               </div>' +
                '           </div>' +
                '       </div>' +
                '   </div>' +
                '</div>';

            return elem;
        },
    };

    Append = {
        emptyInline: function(yankes, id, placeholder, isReadonly) {
            let xElem = parseInt($('.' + yankes + '_row_' + id + '_div').attr('data-count'));
            let nXElem = xElem + 1;
            $('.' + yankes + '_row_' + id + '_div').attr('data-count', (xElem + 1));

            $('.' + yankes + '_row_' + id + '_div').append('' +
                '<div class="row-flex ' + yankes + '_row_' + id + ' col-sm-12 col-12 pl-0" id="' + yankes + '_row_' + id + '_' + nXElem + '">' +
                '   <input type="text" name="yankes[' + yankes + '][' + id + '][' + nXElem + '][value]" id="' + yankes + '_' + id + '_' + nXElem + '" placeholder="Contoh: ' + placeholder + '" class="form-control col-sm-9 col-9" />' +
                '   <label class="col-form-label col-sm-1 col-1 text-right">IDR</label>' +
                '   <label class="row-flex col-sm-2 col-2 no-padding">' +
                '       <input type="number" name="yankes[' + yankes + '][' + id + '][' + nXElem + '][subtotal]" id="' + yankes + '_' + id + '_subtotal_' + nXElem + '" class="' + yankes + '_' + id + '_subtotal form-control text-right col-sm-11 col-11" value="0" onblur="calculation.subtotalInline(\'' + yankes + '\', \'' + id + '\')" ' + isReadonly + '/>' +
                '       <div class="col-form-label col-sm-1 col-1 text-right row_' + id + '_' + nXElem + '" style="padding-left: 5px;" onclick="javascript:$(\'#' + yankes + '_row_' + id + '_' + nXElem + '\').remove(); calculation.subtotalInline(\'' + yankes + '\', \'' + id + '\')">'+
                '           <i class="far fa-window-close add-pic" style="font-size: 18px;"></i>' +
                '       </div>' +
                '   </label>' +
                '</div>');
        },

        selectInline: function(baseUrl, yankes, id, placeholder, isReadonly, isWithDo) {
            var xElem = parseInt($('.' + yankes + '_row_' + id + '_div').attr("data-count"));
            var nXElem = xElem + 1;
            $('.' + yankes + '_row_' + id + '_div').attr("data-count", (xElem + 1));

            var rs_id = ($("#rs_id").find(":selected").val());
            $.ajax({
                url: baseUrl + 'master/datas/layanan',
                type: "post",
                dataType: "json",
                data: {
                    rs_id: rs_id
                },
                success: function (response) {
                    $('.overlay-loading').hide();
                    if (response.hasOwnProperty(id)) {
                        var htmlSelect = '' +
                            '<div class="row-flex ' + yankes + '_row_' + id + ' col-sm-12 col-12 pl-0" id="' + yankes + '_row_' + id + '_' + nXElem + '">' +
                            '   <select name="yankes[' + yankes + '][' + id + '][' + nXElem + '][value]" id="' + yankes + '_' + id + '_' + nXElem + '" class="form-control select2 col-sm-9 col-9" data-id="' + nXElem + '" onchange="calculation.subtotalSelectInline(this, \'' + yankes + '\', \'' + id + '\');">' +
                            '       <option value="">' + placeholder + '</option>';

                        $.each(resolve(id, response), function (index, value) {
                            htmlSelect += '<option value="' + value.id + '-' + value.fare + '">' + ((typeof value.name !== 'undefined') ? value.name : value.value) + '</option>';
                        })

                        htmlSelect += '' +
                            '   </select>' +
                            '   <label class="col-form-label col-sm-1 col-1 text-right">IDR</label>' +
                            '   <label class="row-flex col-sm-2 col-2 no-padding">' +
                            '       <input type="number" name="yankes[' + yankes + '][' + id + '][' + nXElem + '][subtotal]" id="' + yankes + '_' + id + '_subtotal_' + nXElem + '" class="' + yankes + '_' + id + '_subtotal form-control text-right col-sm-11 col-11" value="0" onblur="calculation.subtotalInline(\'' + yankes + '\', \'' + id + '\')" ' + isReadonly + '/>' +
                            '       <div class="col-form-label col-sm-1 col-1 text-right row_' + id + '_' + nXElem + '" style="padding-left: 5px;" onclick="javascript:$(\'#' + yankes + '_row_' + id + '_' + nXElem + '\').remove(); calculation.subtotalInline(\'' + yankes + '\', \'' + id + '\')">' +
                            '           <i class="far fa-window-close add-pic" style="font-size: 18px;"></i>' +
                            '       </div>' +
                            '   </label>' +
                            '</div>';

                        if (isWithDo === 'true') {
                            htmlSelect += '' + 
                                '<div class="row_' + id + '_do_div col-sm-12 col-12 pl-0 pr-0" id="row_' + id + '_do_div_' + nXElem + '" data-count="' + nXElem + '">' +
                                '</div>' +
                                '<label class="col-form-label add-pic ml-3" onclick="append.selectInlineDo(' + nXElem + ', \'' + yankes + '\', \'' + id + '\');">+ Tambahkan Tindakan Dokter Spesialis</label>';
                        }

                        $('.' + yankes + '_row_' + id + '_div').append(htmlSelect);
                        $('#' + yankes + '_' + id + '_' + nXElem).select2({
                            theme: 'bootstrap4'
                        }).one('select2:open', function (e) {
                            $('input.select2-search__field').prop('placeholder', 'Cari disini...');
                        });
                    }
                }
            })
        },

        selectInlineDo: function(id, yankes, name, placeholder) {
            var xElem = parseInt($('.row_' + name + '_do_div').attr("data-count"));
            var nXElem = xElem + 1;
            $('.row_' + name + '_do_div').attr("data-count", (nXElem));

            let htmlDo = '' +
                '<div class="row-flex ' + yankes + '_do_row_' + id + ' col-sm-12 col-12 pl-0" id="' + yankes + '_row_' + id + '_do_' + nXElem + '">' +
                '    <label class="row-flex col-sm-9 col-9 pr-3">' +
                '       <input type="text" name="yankes[' + yankes + '][' + name + '][' + id + '][do][' + nXElem + '][value]" id="' + yankes + '_' + name + '_do_' + nXElem + '" placeholder="Contoh: Kunjungan" class="form-control col-sm-12 col-12 ml-3" />' +
                '    </label>' +
                '    <label class="col-form-label col-sm-1 col-1 text-right">IDR</label>' +
                '    <label class="row-flex col-sm-2 col-2 no-padding">' +
                '        <input type="number" name="yankes[' + yankes + '][' + name + '][' + id + '][do][' + nXElem + '][subtotal]" id="' + yankes + '_' + name + '_do_subtotal' + nXElem + '" class="' + yankes + '_' + name + '_subtotal form-control text-right col-sm-11 col-11" value="0" onblur="calculation.subtotalInline(\'' + yankes + '\', \'' + name + '\')" />' +
                '        <div class="col-form-label col-sm-1 col-1 text-right row-surgery-' + nXElem + '" style="padding-left: 5px;" onclick="javascript:$(\'#' + yankes + '_row_' + id + '_do_' + nXElem + '\').remove(); calculation.subtotalInline(\'' + yankes + '\', \'' + name + '\')">'+
                '           <i class="far fa-window-close add-pic" style="font-size: 18px;"></i>'+
                '       </div>' +
                '    </label>' +
                '</div>';

            $('#row_' + name + '_do_div_' + id).append(htmlDo)
        },

        selectMultiple: function (baseUrl, yankes, id, placeholder, isReadonly, isWithDo) {
            var xElem = parseInt($('.' + yankes + '_row_' + id + '_div').attr("data-count"));
            var nXElem = xElem + 1;
            $('.' + yankes + '_row_' + id + '_div').attr("data-count", (xElem + 1));

            var rs_id = ($("#rs_id").find(":selected").val());
            $.ajax({
                url: baseUrl + 'master/datas/layanan',
                type: "post",
                dataType: "json",
                data: {
                    rs_id: rs_id
                },
                success: function (response) {
                    $('.overlay-loading').hide();
                    if (response.hasOwnProperty(id)) {
                        var htmlSelect = '' +
                            '<div class="row-flex ' + yankes + '_row_' + id + ' col-sm-12 col-12 pl-0" id="' + yankes + '_row_' + id + '_' + nXElem + '">' +
                            '   <select name="yankes[' + yankes + '][' + id + '][' + nXElem + '][value]" id="' + yankes + '_' + id + '_' + nXElem + '" class="form-control select2 col-sm-4 col-4" data-id="' + nXElem + '" onchange="calculation.subtotalSelectMultiple(this, \'' + yankes + '\', \'' + id + '\');">' +
                            '       <option value="">' + placeholder + '</option>';

                        $.each(resolve(id, response), function (index, value) {
                            htmlSelect += '<option value="' + value.id + '-' + value.fare + '">' + ((typeof value.name !== 'undefined') ? value.name : value.value) + '</option>';
                        })

                        htmlSelect += '' +
                            '   </select>' +
                            '   <div class="row-flex col-sm-2 col-2">' +
                            '       <input type="number" name="yankes[' + yankes + '][' + id + '][' + nXElem + '][qty]" id="' + yankes + '_' + id + '_days_' + nXElem + '" class="room_days form-control col-sm-8 col-8" min="1" value="1" data-id="' + nXElem + '" onchange="calculation.subtotalSelectMultiple(this, \'' + yankes + '\', \'' + id + '\', true);" />' +
                            '       <label class="col-form-label col-sm-4 col-4 text-center"> Hari</label>' +
                            '   </div>' +
                            '   <div class="row-flex col-form-label col-sm-1 col-1 text-right pl-0 pr-0">' +
                            '       <label class="col-sm-5 col-5 text-center no-padding">X</label>' +
                            '       <label class="col-sm-7 col-7 pl-0">IDR</label>' +
                            '   </div>' +
                            '   <input type="number" name="yankes[' + yankes + '][' + id + '][' + nXElem + '][rate]" id="' + yankes + '_' + id + '_rate_' + nXElem + '" class="room_rate form-control text-right col-sm-2 col-2" value="0" data-id="' + nXElem + '" onblur="calculation.subtotalSelectMultiple(this, \'' + yankes + '\', \'' + id + '\', false, true);" />' +
                            '   <label class="col-form-label col-sm-1 col-1 text-right">IDR</label>' +
                            '   <label class="row-flex col-sm-2 col-2 no-padding">' +
                            '       <input type="number" name="yankes[' + yankes + '][' + id + '][' + nXElem + '][subtotal]" id="' + yankes + '_' + id + '_subtotal_' + nXElem + '" class="' + yankes + '_' + id + '_subtotal form-control text-right col-sm-11 col-11" value="0" ' + isReadonly + '/>' +
                            '       <div class="col-form-label col-sm-1 col-1 text-right row_' + id + '_' + nXElem + '" style="padding-left: 5px;" onclick="javascript:$(\'#' + yankes + '_row_' + id + '_' + nXElem + '\').remove(); calculation.subtotalSelectMultiple(this, \'' + yankes + '\', \'' + id + '\');">' +
                            '           <i class="far fa-window-close add-pic" style="font-size: 18px;"></i>' +
                            '       </div>' +
                            '   </label>' +
                            '</div>';

                        if (isWithDo === 'true') {
                            htmlSelect += '' +
                                '<div class="row_' + id + '_do_div col-sm-12 col-12 pl-0 pr-0" id="row_' + id + '_do_div_' + nXElem + '" data-count="' + nXElem + '">' +
                                '</div>' +
                                '<label class="col-form-label add-pic ml-3" onclick="append.selectInlineDo(' + nXElem + ', \'' + yankes + '\', \'' + id + '\');">+ Tambahkan Tindakan Dokter Spesialis</label>';
                        }

                        $('.' + yankes + '_row_' + id + '_div').append(htmlSelect);
                        $('#' + yankes + '_' + id + '_' + nXElem).select2({
                            theme: 'bootstrap4'
                        }).one('select2:open', function (e) {
                            $('input.select2-search__field').prop('placeholder', 'Cari disini...');
                        });
                    }
                }
            })
        },
    };

    Calculation = {
        subtotalInline: function(yankes, id) {
            var subtotal = 0;
            $.each($('.' + yankes + '_' + id + '_subtotal'), function (index, value) {
                subtotal = subtotal + parseInt($(value).val());
            })

            $('#' + yankes + '_total_' + id + '_subtotal').val(subtotal);
            this.total();
        },

        subtotalSelectInline: function(e, yankes, id) {
            var select_id = $(e).attr("data-id");

            var fare = $(e).val();
            fare = fare.split("-");
            fare = fare[1];

            $('#' + yankes + '_' + id + '_subtotal_' + select_id).val(fare);

            var subtotal = 0;
            $.each($('.' + yankes + '_' + id + '_subtotal'), function (index, value) {
                subtotal = subtotal + parseInt($(value).val());
            })

            $('#' + yankes + '_total_' + id + '_subtotal').val(subtotal);
            this.total();
        },

        subtotalSelectMultiple: function(e, yankes, id, is_rooms = false, is_rate = false) {
            var sMultiple_subtotal;
            var select_id = $(e).attr("data-id");
            var days = $('#' + yankes + '_' + id + '_days_' + select_id).val();
            console.log(select_id);
            console.log(days);

            if (is_rooms === true) {
                sMultiple_subtotal = $('#' + yankes + '_' + id + '_rate_' + select_id).val();
            } else if (is_rooms === false && is_rate === true) {
                sMultiple_subtotal = $(e).val();
            } else {
                sMultiple_subtotal = $(e).val();
                sMultiple_subtotal = sMultiple_subtotal.split("-");
                sMultiple_subtotal = sMultiple_subtotal[1];
            }

            $('#' + yankes + '_' + id + '_rate_' + select_id).val(sMultiple_subtotal);
            $('#' + yankes + '_' + id + '_subtotal_' + select_id).val(sMultiple_subtotal * days);

            var subtotal = 0;
            $.each($('.' + yankes + '_' + id + '_subtotal'), function (index, value) {
                subtotal = subtotal + parseInt($(value).val());
            })
            $('#' + yankes + '_total_' + id + '_subtotal').val(subtotal);
            this.total();
        },

        total: function() {
            var subtotal = 0;
            $.each($(".subtotal"), function (index, value) {
                subtotal = subtotal + parseInt($(value).val());
            })
            $(".total").val(subtotal);
        }
    };

    window.elements = Elements;
    window.calculation = Calculation;
    window.append = Append;
})(this.jQuery);