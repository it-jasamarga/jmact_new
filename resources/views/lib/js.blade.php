<script type="text/javascript">

    $(document).on('keypress',function(e) {
        if(e.which == 13) {
        }
    });

    //ACTION COMMAND ----------------------------------------------------------------------------//
    $('.alphabetonly').keypress(function (e) {
        var regex = new RegExp(/^[a-zA-Z\s]+$/);
        var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
        if (regex.test(str)) {
            return true;
        }
        else
        {
            e.preventDefault();
            return false;
        }
    });

    // DYNAMIC Input SELECT
    $(document).on('change', '.option-ajax', function () {
        var append = $(this).data('child');
        var value = $(this).val();
        if (value != null) {
            $.ajax({
                url: '{{ url("option") }}/' + append + '/' + value,
                type: 'GET',
                success: function (resp) {
                    $('#' + append).html(resp);
                },
                error: function (resp) {
                }
            });
        }
    });  

    // OPEN MODAL FOR CREATE DATA
    $(document).on('click', '.add-modal', function (e) {
        console.log('test')
        var modal = $(this).data('modal')
        loadModal({
            url: "{!! isset($route) ? route($route.'.create') : '' !!}",
            modal: modal,
        }, function (resp) {
            onShow();
        }); 
    });
    
    // OPEN PAGE FOR CREATE DATA
    $(document).on('click', '.add-page', function(event) {
        var url = $(this).data('url')
        window.location = url;
    });

     // OPEN CUSTOM CREATE PAGE 
     $(document).on('click', '.add-custome-page', function(event) {
        url = $(this).data('url');
        window.location = url;

    });

     $(document).on('click', '.delete-data', function (e) {
        var idx = $(this).data('id');
        var callback = $(this).data('callback');
        var url = '{!! isset($route) ? route($route.'.index') : '' !!}/' + idx
        deleteData(url, callback);
    });

    // OPEN MODAL FOR ADD URL DATA
    $(document).on('click', '.custome-modal', function (e) {
        var modal = $(this).data('modal');
        var url = $(this).data('url');
        
        loadModal({
            url: "{{ url('/') }}/" + url,
            modal: modal,
        }, function (resp) {
            onShow();
        });

    });

    // SAVE DATA
    $(document).on('click', '.save', function (e) {
        var form = $(this).data('form');
        var callback = $(this).data('callback');
            if(!form){
              form = 'formData';
            } 

            if(!callback){
                callback = null;
            } 
        saveData(form,callback);

    });

    // GLOBAL FUNCTION DOWNLOAD PDF
    $(document).on('click','.downloadPdf',function(){
        var url = $(this).data('url');
        var id = $(this).data('id');
        $.ajax({
            url: "{{ url('') }}/"+url,
            type: "POST",
            data : {
              '_token' : "{{ csrf_token() }}",
              'id' : id,
            },
            success: function(resp){
                window.open(resp,'_blank');
            },
            error : function(resp){
                toastr.error('Terjadi Kesalahan / data tidak ada', 'Gagal Mendownload');
            },
        });
    });

    // FUNCTION ---------------------------------------------------------------------------------------------------------
    $.fn.modal.Constructor.prototype.enforceFocus = function() {};
    
    $(document).ready(function(){
        $('.pickadate').pickadate({
            format: 'yyyy-mm-dd',
            selectYears: 100,
            selectMonths: true
        });

        $('.pickadate-start').pickadate({
            format: 'yyyy-mm-dd',
            selectYears: 100,
            selectMonths: true,
            onClose: function(context) {
                var end = $('.pickadate-end').pickadate('picker');
                end.set('min', new Date($('.pickadate-start').val()));
            }
        });

        $('.pickadate-end').pickadate({
            format: 'yyyy-mm-dd',
            selectYears: 100,
            selectMonths: true,
            onClose: function(context) {
                var start = $('.pickadate-start').pickadate('picker');
                start.set('max', new Date($('.pickadate-end').val()));
            }
        }); 

        $('.datetimepicker').datetimepicker({
            format:'Y-m-d h:i:s',
            useCurrent: false,
            autoclose: true
        });
        
        $(".select2").select2({
            dropdownAutoWidth: true,
            width: '100%',
            placeholder: "Pilih Data"
        });
        
        $('.dropify').dropify();

        $('.summernote').summernote({
            height : 240,
            maximumImageFileSize: 409715,
            lineHeight : 10,
            fontSizes: ['8', '9', '10', '11', '12', ,'13', '14', '15', '16', '17', '18'],
            fontName: 'Arial',
            toolbar: [
            // [groupName, [list of button]]
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']]
            ],
            callbacks: {
              onPaste: function (e) {
                var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');
                e.preventDefault();

                  // Firefox fix
                  setTimeout(function () {
                    document.execCommand('insertText', false, bufferText);
                }, 10);
              },
              onImageUpload: function(image) {
                  uploadImage(image[0]);
              }
          }
      });    

    });

    // DYNAMIC SHOW MODAL
    function loadModal(param, callback) {

        var url = (typeof param['url'] === 'undefined') ? '#' : param['url'];
        var modal = (typeof param['modal'] === 'undefined') ? 'mediumModal' : param['modal'];
        var formId = (typeof param['formId'] === 'undefined') ? 'formData' : param['formId'];
        var onShow = (typeof callback === 'undefined') ? function () {} : callback;
        var modals = $(modal);

        $.ajax({
            url: url,
            type: 'GET',
        })
        .done(function(response){
            modals.modal('show');
            modals.off('shown.bs.modal');
            modals.find('.modal-content').empty();

            modals.on('shown.bs.modal', function (event) {
                event.preventDefault();
                modals.find('.modal-content').html(response);
                onShow();
            });
        })
        .fail(function(response){
            if(response.status == 401){
                Swal.fire({
                  type: 'info',
                  title: "Sorry Your's Session Has Expired",
                  text: 'Please to Re-login',
                  button: true,
                  confirmButtonText:'Close',
                  confirmButtonColor:'#0BB7AF'
              }).then((res) => {
                if (res.value) {
                    location.href = "{{ (@$route) ? route($route.'.index') : url('/') }}";
                }
            })
          }
      })
    } 

    // DYNAMIC SAVE DATA
    function saveData(formid, callback) {

        $('#'+formid).append(`
            <div class="loadings" >Loading&#8230;</div>
            `);
        console.log('test',formid)
        $("#" + formid).ajaxSubmit({
            success: function (resp) {
                var textResp = (resp.messageBox) ? resp.messageBox : 'Proses penyimpan data berhasil';
                Swal.fire({
                  type: 'success',
                  title: 'Sukses',
                  text: textResp,
                  confirmButtonText:'<i class="fa fa-thumbs-up"></i> Kembali !',
                  confirmButtonAriaLabel: 'Thumbs up, great!',
                  // footer: '<a href>Why do I have this issue?</a>'
              }).then(function(){
                if(callback != null){
                    location.href = callback;
                }else{
                    location.href  = "{{ isset($route) ? route($route.'.index') : url('/') }}";
                }
            });

          },
          error: function (resp) {
            console.log('resp',resp)
            $('.loadings').hide();
            var response = resp.responseJSON;
            var addErr = {};

            if(resp.responseJSON && resp.responseJSON.errors){
                $.each(response.errors, function (index, val) {

                    var response = resp.responseJSON;
                    if (index.includes(".")) {
                        res = index.split('.');
                        index = '';
                        for (i = 0; i < res.length; i++) {
                            if (i == 0) {
                                res[i] = res[i];
                            } else {
                                if (res[i] == 0) {
                                    res[i] = '\\[\\]';
                                } else {
                                    res[i] = '[' + res[i] + ']';
                                }
                            }
                            index += res[i];
                        }
                    }
                    clearFormError(index,val,formid);

                    var name = index.split('.').reduce((all, item) => {
                        all += (index == 0 ? item : '[' + item + ']');
                        return all;
                    });
                    var fg = $('[name="' + name + '"], [name="' + name + '[]"]').closest('.form-group');

                    fg.addClass('has-error');

                    fg.append('<small class="control-label error-label font-bold" style="margin-top: 0.25rem;font-size: smaller;color: #ea5455;">' + val + '</small>')
                });

                $("html, body").animate({ scrollTop: 0 }, "slow");

                Swal.fire({
                  type: 'info',
                  title: 'Terjadi Kesalahan',
                  html: showBoxValidation(resp),
              });
            }else{
                Swal.fire({
                  type: 'info',
                  title: 'Terjadi Kesalahan',
                  html: showBoxValidation(resp),
              });
            }
            
            var intrv = setInterval(function(){
                $('.form-group .error-label').slideUp(500, function(e) {
                    $(this).remove();
                    $('.form-group.has-error').removeClass('has-error');
                    clearTimeout(intrv);
                });
            }, 14000)

        }
    });
    }

    // DELETED DATA
    function deleteData(url, callback) 
    {
        Swal.fire({
            title: "Are You Sure To Delete Data?",
            text: "Once deleted, you will not be able to recover data!",
            type: "question",
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            confirmButtonColor:'#0BB7AF',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        '_method' : 'DELETE',
                        '_token' : '{{ csrf_token() }}'
                    }
                })
                .done(function(response) {
                    Swal.fire({
                      type: 'success',
                      title: 'Deleted',
                      text: 'Data success deleted!',
                      button: true,
                      confirmButtonText:'Close',
                      confirmButtonColor:'#0BB7AF'
                  }).then((res) => {
                    if (result.value) {
                        if(callback){
                            location.href = callback;
                        }else{
                            location.href = "{{ isset($route) ? route($route.'.index') : url('/') }}";
                        }
                    }
                })
              })
                .fail(function(response) {
                    // console.log(response);
                    if(response.responseJSON.status == false){
                        Swal.fire({
                          type: 'info',
                          title: 'Deleted data Failed !',
                          text: 'data is being used by another module',
                          button: true,
                          confirmButtonText:'Close',
                          confirmButtonColor:'#0BB7AF'
                      }).then((res) => {
                        if (result.value) {
                            if(callback){
                                location.href = callback;
                            }else{
                                location.href = "{{ isset($route) ? route($route.'.index') : url('/') }}";
                            }
                        }
                    })
                  }else{
                    Swal.fire({
                      type: 'error',
                      title: 'Deleted data Failed !',
                      text: 'Looks like something wrong',
                      button: true,
                      confirmButtonText:'Close',
                      confirmButtonColor:'#0BB7AF'
                  }).then((res) => {
                    if (result.value) {
                        if(callback){
                            location.href = callback;
                        }else{
                            location.href = "{{ isset($route) ? route($route.'.index') : url('/') }}";
                        }
                    }
                })
              }
          })

            }
        })
    }

    var modal = '#mediumModal';
    var onShow = function () {
        $(".select2").select2({
            dropdownAutoWidth: true,
            width: '100%',
            placeholder: "Pilih Data"
        });
        $('.pickadate').pickadate({
            format: 'yyyy-mm-dd',
            selectYears: 100,
            selectMonths: true
        });
        $('.datetimepicker').datetimepicker({
            format:'yyyy-mm-DD hh:mm',
            useCurrent: false,
            autoclose: true
        });
        $('.dropify').dropify();
        $('.summernote').summernote({
            height : 240,
            maximumImageFileSize: 409715,
            lineHeight : 10,
            fontSizes: ['8', '9', '10', '11', '12', ,'13', '14', '15', '16', '17', '18'],
            fontName: 'Arial',
            toolbar: [
            // [groupName, [list of button]]
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']]
            ],
            callbacks: {
              onPaste: function (e) {
                var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');
                e.preventDefault();

                  // Firefox fix
                  setTimeout(function () {
                    document.execCommand('insertText', false, bufferText);
                }, 10);
              },
              onImageUpload: function(image) {
                  uploadImage(image[0]);
              }
          }
      });
    };

    // SHOW ERROR
    function showBoxValidation(resp, message){
        var temp = ``;
        if(resp.statusText = 'Unprocessable Entity'){
            temp += `<div class="sidebar-widget wow fadeInUp outer-top-vs animated" style="visibility: visible; animation-name: fadeInUp;"><h3 class="section-title "><b>Incomplete Data Input</> </h3><div class="sidebar-widget-body" ><div class="compare-report"><ul class="list text-left bold" style="font-size:16px;list-style:inside;">`;
            if(resp.responseJSON){
                if(resp.responseJSON.errors){
                    var data = resp.responseJSON.errors;
                    $.each(data,function(key,value){
                        temp += `<li><small>`+upperCase(key.replace("_", " "))+` : ` +value[0]+ `</small></li>`;
                    });
                }
            }
            temp += `</ul></div></div></div>`;
        }else{
            temp = 'Terjadi Kesalahan Sistem';
        }
        return temp;
    }

    function upperCase(data){
        var result = data.toLowerCase().replace(/\b[a-z]/g, function(letter) {
            return letter.toUpperCase();
        });
        return result;
    }

    function showFormError(key, value) {
        if (key.includes(".")) {
            res = key.split('.');
            key = res[0] + '[' + res[1] + ']';
            if (res[1] == 0) {
                key = res[0] + '\\[\\]';
            }
            if (res[2]) {
                key = res[0] + '[' + res[1] + ']' + '[' + res[2] + ']';
                if (res[2] == 0) {
                    key = res[0] + '[' + res[1] + ']' + '\\[\\]';
                }
            }
            if (res[3]) {
                key = res[0] + '[' + res[1] + ']' + '[' + res[2] + ']' + '[' + res[3] + ']';
                if (res[3] == 0) {
                    key = res[0] + '[' + res[1] + ']' + '\\[\\]';
                }
            }
        }
        var elm = $("#dataForm").find('[name="' + key + '"]').closest('.field');
        $(elm).addClass('error');
        
        var message = `<div class="ui basic red pointing prompt label transition visible">` + value + `</div>`;

        var showerror = $("#dataForm").find('[name="' + key + '"]').closest('.field');
        $(showerror).append('<div class="ui basic red pointing prompt label transition visible">' + value + '</div>');
    }

    function clearFormError(key, value, formData) {
        if (key.includes(".")) {
            res = key.split('.');
            key = res[0] + '[' + res[1] + ']';
            if (res[1] == 0) {
                key = res[0] + '\\[\\]';
            }
            // 
        }
        var elm = $("#" + formData).find('[name="' + key + '"]').closest('.form-group');
        $(elm).removeClass('has-error');
        var showerror = $("#" + formData).find('[name="' + key + '"]').closest('.form-group').find('.control-label.error-label.font-bold').remove();
    }
    // END SHOW ERROR

    function changeFormatDate(data){
        var  tgl= new Date(data);
        if(tgl){
            var year = tgl.getFullYear();
            var month = new Array();
            month[0] = "Januari";
            month[1] = "Februari";
            month[2] = "Maret";
            month[3] = "April";
            month[4] = "Mei";
            month[5] = "Juni";
            month[6] = "Juli";
            month[7] = "Agustus";
            month[8] = "September";
            month[9] = "Oktober";
            month[10] = "November";
            month[11] = "Desember";
            var month = month[tgl.getMonth()];
            var day = tgl.getDate();
            return  day + ' ' + month + ' ' + year; 
        }else{
            return '';
        }

    }
    function changeFormatDateWithHours(data){
        var  tgl= new Date(data);
        if(tgl){
            var year = tgl.getFullYear();
            var month = new Array();
            month[0] = "Januari";
            month[1] = "Februari";
            month[2] = "Maret";
            month[3] = "April";
            month[4] = "Mei";
            month[5] = "Juni";
            month[6] = "Juli";
            month[7] = "Agustus";
            month[8] = "September";
            month[9] = "Oktober";
            month[10] = "November";
            month[11] = "Desember";
            var month = month[tgl.getMonth()];
            var day = tgl.getDate();
            var hour = tgl.getHours();
            var minutes = tgl.getMinutes();
            return  day + ' ' + month + ', ' + year +'<br/>'+ hour + '.' +minutes; 
        }else{
            return '';
        }

    }

    function fromNow(date, type = "YYYYMMDDhmmss"){
        return moment(date, type).fromNow();
    }

    function showLoadingInput(elemchild) {
        var loading = `<div class="ui active mini centered inline loader"></div>`;

        $('#' + elemchild).parent().closest('.field').addClass('disabled');
        $('#' + elemchild).parent().closest('.field').append(loading);
    }

    function stopLoadingInput(elemchild) {
        $('#' + elemchild).parent().closest('.field').removeClass('disabled');
        $('#' + elemchild).parent().closest('.field').find('.inline.loader').remove();
    }

    function convertToRupiah(angka)
    {
        var rupiah = '';
        var angkarev = angka.toString().split('').reverse().join('');
        for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
            var hasil = ''+rupiah.split('',rupiah.length-1).reverse().join('');
        if(hasil == 'NaN'){
            hasil = '';
        }
        return hasil;
    }

    function convertToAngka(rupiah)
    {
        return parseInt(rupiah.replace(/,.*|[^0-9]/g, ''), 10);
    }

    // GLOBAL FUNCTION CHECK IMG
    function checkImg(url){
        var http = new XMLHttpRequest();
        http.open('HEAD', url, false);
        http.send();
        return (http.status!=404) ? url : "{{ asset('no-images.png') }}";
    }

</script>