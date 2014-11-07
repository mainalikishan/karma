<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<div style="padding:0;width:100%!important;margin:0" marginheight="0" marginwidth="0">
    <center>
        <table cellpadding="8" cellspacing="0"
               style="padding:0;width:100%!important;background:#ffffff;margin:0;background-color:#ffffff" border="0">
            <tbody>
            <tr>
                <td valign="top">
                    <table cellpadding="0" cellspacing="0" style="border-radius:4px;border:1px #cccccc solid" border="0"
                           align="center">
                        <tbody>
                        <tr>
                            <td colspan="3" height="20"></td>
                        </tr>
                        <tr style="line-height:0px">
                            <td width="100%" style="font-size:0px" align="center" height="1"><img alt="Jagirr"
                                                                                                  src="{{$logo}}"
                                                                                                  width="150">
                            </td>
                        </tr>
                        <tr>
                            <td width="100%" align="left" style="padding: 20px 10px;">

                                <span style="color:#666666; font-size: 14px; line-height: 24px; ">
                                    Hi <span style=" font-weight: bold;">{{$toName}}</span> , <br/> <br/>

                                   <span style=" font-weight: bold;"> {{$fromName}} </span> recently reviewed your profile
                                    @if($reviewSummary!="")
                                    <br/><br/>
                                    {{$reviewSummary}}
                                    @endif
                                    <br/><br/>

                                    <span style="color: #777;">PS: For more information, please login to  <span
                                            style=" font-weight: bold;">Jagirr</span>.</span>

                                </span>
                            </td>
                        <tr>
                            <td width="100%" align="left"
                                style="padding: 0 10px; color:#666666; font-size: 14px; line-height: 24px; ">
                                {{$signature}} <br/><br/>
                            </td>
                        </tr>

                        </tbody>
                    </table>
                    <table cellpadding="0" cellspacing="0" align="right" border="0">
                        <tbody>
                        <tr>
                            <td height="10"></td>
                        </tr>
                        <tr>
                            <td style="padding:0;border-collapse:collapse">
                                <table cellpadding="0" cellspacing="0" align="center" border="0">
                                    <tbody>
                                    <tr style="color:#1ABC9C;font-size:11px;font-family:proxima_nova,'Open Sans','Lucida Grande','Segoe UI',Arial,Verdana,'Lucida Sans Unicode',Tahoma,'Sans Serif'">
                                        <td align="left">&nbsp;
                                        </td>
                                        <td align="right">&copy; {{ date('Y') }} <span>Jagirr</span></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            </tbody>
        </table>
    </center>
</div>
</body>
</html>
