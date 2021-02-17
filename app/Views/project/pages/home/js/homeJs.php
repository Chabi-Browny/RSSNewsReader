<script>

function regist()
{
    event.preventDefault();
    
    var alertTargetName = 'div.alert.alert-danger';
    var regsend = $.ajax(
                {
                    url:document.location.origin+'/'+'registration',
                    method:'post',
                    data:$('#reg').serializeArray(),
                    datatype:'json'
                });
        regsend.done(function(req)
        {
            var respData = JSON.parse(req);

            $.each(respData, function(key, val)
            {
                if( key == 'success')
                {
                    $('.msg-succ').html(val).delay(5000).fadeOut();
                    
                    $('[name="regname"]').val('');
                    $('[name="regpass"]').val('');
                    
                    if($('#gregname').children(alertTargetName).length == 1)
                        $('#gregname').find(alertTargetName).remove();
                    
                    if($('#gregpass').children(alertTargetName).length == 1)
                        $('#gregpass').find(alertTargetName).remove();   
                }
                else if(val != '')
                {
                    $('#g'+key).append(val);   
                }
            });
        });
    
}

function logg()
{
    event.preventDefault();
    
    var regsend = $.ajax(
                {
                    url:document.location.origin+'/'+'login',
                    method:'post',
                    data:$('#log').serializeArray(),
                    datatype:'json'
                });
        regsend.done(function(req)
        {
            var respData = JSON.parse(req);
            console.log(respData=='logged');
            if( respData != 'logged')
            {
                $.each(respData, function(key, val)
                {
                    if( key == 'success')
                    {
                        document.location.href = document.location.origin+'/userfeed';
                    }
                    else if( key == 'fail')
                    {
                        $('.msg-fail').html(val);
                    }
                    else if(val != '')
                    {
                        $('#l'+key).append(val);   
                    }
                });
            }
            else
            {
                document.location.href = document.location.origin+'/userfeed';
            }
            
        });
}


</script>