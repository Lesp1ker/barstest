<HEAD>
    <link rel="stylesheet" href="libraries/jquery/jquery-ui.css">
    <script src="libraries/jquery/jquery-3.2.1.js" type="text/javascript"></script>
    <script src="libraries/jquery/jquery-ui.js" type="text/javascript"></script>
    <meta charset="utf-8">
    <meta name="format-detection" content="telephone=no">
    <link rel="icon" href="images/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="libraries/template/css/grid.css">
    <link rel="stylesheet" href="libraries/template/css/style.css">
    <link rel="stylesheet" href="libraries/template/css/camera.css">
    <link rel="stylesheet" href="libraries/template/css/owl-carousel.css">
    <link rel="stylesheet" href="libraries/template/css/mailform.css">
    <!--[if lt IE 9]>
    <html class="lt-ie9">
    <div style="clear: both; text-align:center; position: relative;"><a
            href="http://windows.microsoft.com/en-US/internet-explorer/.."><img
            src="images/ie8-panel/warning_bar_0000_us.jpg" border="0" height="42" width="820"
            alt="You are using an outdated browser. For a faster, safer browsing experience, upgrade for free today."></a>
    </div>
    </html>
    <script src="libraries/template/js/html5shiv.js"></script><![endif]-->
    <script src="libraries/template/js/device.min.js"></script>

    <script src="libraries/template/js/mailform/jquery.rd-mailform.min.c.js"></script>
    <script src="libraries/template/js/mailform/jquery.form.min.js"></script>
    <script src="libraries/template/js/script.js"></script>

    <link rel="stylesheet" href="libraries/style.css">
</HEAD>

<script>
    $(document).ready(function () {
        setTimeout(function() {
            $('body').unbind('mousewheel');
        }, 100);
    });
</script>
<?
require 'functions.php';

$data = file_get_contents('json_data.json');
$data = json_decode($data);
$data = $data->LPU;
$hids = unique_multidim_array($data,'hid');
$parent_ids = array();
foreach ($hids as $element){
    if (isset($element->hid)){
        $parent_ids[] = $element->hid;
    }
}
?>
<a data-name="save-changes" data-name="add" class="fa " style="cursor:pointer;height: 40px;font-size: 24px !important;line-height: 40px;color: #fff;background: #888;padding: 10px;position: fixed;right: 22px;top: 15px;overflow: hidden;text-align: center;border-radius: 3px;text-decoration: none;z-index: 20;">
    Сохранить изменения
</a>
<a data-name="add" class="fa " style="cursor:pointer;height: 40px;font-size: 24px !important;line-height: 40px;color: #fff;background: #888;padding: 10px;position: fixed;right: 289px;top: 15px;overflow: hidden;text-align: center;border-radius: 3px;text-decoration: none;z-index: 20;">
    Добавить раздел
</a>

<table border=1 data-name="main" style="    margin-top: 92px;">
        <thead>
            <tr>
                <td>
                    <button class="btn fa" style="width: 175px;background: #888;display:none;" data-name="show-all"">
                        Развернуть всё
                    </button>
                    <button class="btn fa" style="width: 175px;background: #888;margin-top:0px;" data-name="hide-all"">
                        Свернуть всё
                    </button>
                </td>
                <td><b>Наименование</b></td>
                <td><b>Адрес</b></td>
                <td><b>Телефон</b></td>
            </tr>
        </thead>
<?foreach ($data as $element){
    ?>
        <tr data-id="<?=e($element->id)?>" data-hid="<?=e($element->hid)?>" class="mailform off2 rd-mailform <? if (!empty($element->hid)) echo 'child';?>" >
            <td>
                <button class="btn fa" style="width: 175px;margin-top: 0px;background: #888;margin-bottom: 5px;margin-top: 5px;" data-name="delete" data-id="<?=e($element->id)?>">
                    Удалить раздел <? if (array_search($element->id,$parent_ids)!==false){?>и подразделы<?}?>
                </button>
                <? if (empty($element->hid)){?>
                    <button class="btn fa" style="width: 175px;margin-top: 0px;background: #888;margin-bottom: 5px;margin-top: 5px;" data-name="add" data-id="<?=e($element->id)?>">
                        Добавить подразделение
                    </button>
                    <button class="btn fa" style="width: 175px;margin-top: 0px;display:none;background: #888;margin-bottom: 5px;margin-top: 5px;" data-name="show-childs" data-id="<?=e($element->id)?>">Показать подразделения</button>
                    <button class="btn fa" style="width: 175px;margin-top: 0px;background: #888;margin-bottom: 5px;margin-top: 5px;<? if (array_search($element->id,$parent_ids)===false){?>display:none;<?}?>" data-name="hide-childs" data-id="<?=e($element->id)?>">Скрыть подразделения</button>
                <?}?>
            </td>
            <td>
                <label class="mfInput">
                    <input type="text" data-name="full-name" value="<?=e($element->full_name)?>" style="background-color: inherit;">
                </label>
            </td>
            <td>
                <label class="mfInput">
                    <input type="text" data-name="address" value="<?=e($element->address)?>" style="background-color: inherit;">
                </label>
            </td>
            <td>
                <label class="mfInput">
                    <input type="text" data-name="phone" value="<?=e($element->phone)?>" style="background-color: inherit;">
                </label>
            </td>
        </tr>
    <?
}
?>
</table>

<script language="javascript" type="text/javascript">
    $(document).ready(function() {
        $('[data-name=show-all]').click(function() {
            console.info('click ' + $( this ).data('name'));
            $( 'tbody' ).show();
            $( '[data-name=hide-all]' ).show();
            $( this ).hide();
        });
        $('[data-name=hide-all]').click(function() {
            console.info('click ' + $( this ).data('name'));
            $( 'tbody' ).hide();
            $( '[data-name=show-all]' ).show();
            $( this ).hide();
        });
        $('[data-name=hide-childs]').click(function() {
            console.info('click ' + $( this ).data('name'));
            var hid = $( this ).data('id');
            $( '[data-hid='+hid+']' ).hide();
            $( '[data-name=show-childs][data-id='+hid+']' ).show();
            $( this ).hide();
        });
        $('[data-name=show-childs]').click(function() {
            console.info('click ' + $( this ).data('name'));
            var hid = $( this ).data('id');
            $( '[data-hid='+hid+']' ).show();
            $( '[data-name=hide-childs][data-id='+hid+']' ).show();
            $( this ).hide();
        });
        $('[data-name=add]').click(function() {
            console.info('click ' + $( this ).data('name'));
            var id = $( this ).data('id');
            console.log(id);
            var ajax_result = $.ajax({
                method: "POST",
                url: "/test/table_add.php",
                beforeSend: function() {
//                    $('table,button').hide();
//                    $('.loading').show();
                },
                data: {id:id},
                dataType:"json",
                async:false
            })
                .always(function(a1,a2) {
                    var text;
                    if (a1 && a1.text){
                        text = a1.text;
                        if(!a1.hid) {
                            $(window).scrollTop(9999999999999);
                        }
                        location.reload()
//                        console.log(id);
//                        var element;
//                        if(a1.hid) {
//                            element = $('[data-name=child-exemplar]').clone();
//                            element.removeAttr('data-name');
//                            element.attr('data-hid',a1.hid);
//                            element.attr('data-id',a1.id);
//                            element.find('[data-id]').each(function() {
//                                if ($( this ).data('id')==''){
//                                    $( this ).attr('data-id',a1.id);
//                                }
//                            });
//                            $('tr[data-id=' + a1.hid + ']').after(element);
//                            $('tr[data-id=' + a1.hid + ']').find('[data-name=show-childs]').click();
//                        } else {
//                            element = $('[data-name=parent-exemplar]').clone();
//                            element.attr('data-id',a1.id);
//                            element.find('[data-id]').each(function() {
//                                if ($( this ).data('id')){
//                                    $( this ).attr('data-id',a1.id);
//                                }
//                            });
//                            $('table[data-name=main]').append(element);
//                        }
                    } else {
                        text = 'Ошибка, обратитесь к разработчикам.';
                    }
                    alert(text);
                    console.log('always');
                    console.log(a1);
                    console.log(a2);
                });
        });
        $('[data-name=delete]').click(function() {
            console.info('click ' + $( this ).data('name'));
            var id = $( this ).data('id');
            var ajax_result = $.ajax({
                method: "POST",
                url: "/test/table_delete.php",
                beforeSend: function() {
//                    $('table,button').hide();
//                    $('.loading').show();
                },
                data: {id:id},
                dataType:"json",
                async:false
            })
            .always(function(a1,a2) {
                var text;
                if (a1 && a1.text){
                    text = a1.text;
                    console.log(id);
                    location.reload()
//                    $('[data-id='+id+'],[data-hid='+id+']').remove();
                } else {
                    text = 'Ошибка, обратитесь к разработчикам.';
                }
                alert(text);
                console.log('always');
                console.log(a1);
                console.log(a2);
            });
        });
        $('[data-name="save-changes"]').click(function() {
            console.info('click ' + $( this ).data('name'));
            var data = [];
            $('table[data-name=main] tr[data-id]').each(function() {
                data.push(
                    {
                        'id':$( this ).data('id'),
                        'hid':$( this ).data('hid') ? $( this ).data('hid') : null,
                        'full_name':$( this ).find('[data-name=full-name]').val() || null,
                        'address':$( this ).find('[data-name=address]').val() || null,
                        'phone':$( this ).find('[data-name=phone]').val() || null
                    }
                )
            });
            console.log(data);
            var ajax_result = $.ajax({
                method: "POST",
                url: "/test/table_save_changes.php",
                beforeSend: function() {
//                    $('table,button').hide();
//                    $('.loading').show();
                },
                data: {data:data},
                dataType:"json",
                async:false
            })
//            .done(function(a1,a2) {
//                console.log('done');
//                console.log(a1);
//                console.log(a2);
//            })
//            .fail(function(a1,a2) {
//                console.log('fail');
//                console.log(a1);
//                console.log(a2);
//            })
            .always(function(a1,a2) {
                var text;
                if (a1 && a1.text){
                    text = a1.text;
                } else {
                    text = 'Ошибка, обратитесь к разработчикам.';
                }
                alert(text);
//                $('table,button').show();
//                $('.loading').hide();
                console.log('always');
                console.log(a1);
                console.log(a2);
            });
        });
    });
</script>
