function selecttime(flag)
{
    if(flag == 'start')
    {
        var endTime = $("#countTimeend").val();
        if(endTime != "")
        {
            WdatePicker({dateFmt:'yyyy-MM-dd',maxDate:endTime})
        }
        else
        {
        WdatePicker({dateFmt:'yyyy-MM-dd'})
        }
    }
    else
    {
        var startTime = $("#countTimestart").val();
        if(startTime != "")
        {
            WdatePicker({dateFmt:'yyyy-MM-dd',minDate:startTime})
        }
        else
        {
        WdatePicker({dateFmt:'yyyy-MM-dd'})
        }
    }
}