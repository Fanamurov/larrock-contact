<center>
    <table align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" style="background-color: #dcdcdc; height: 100% !important;
    margin: 0;
    padding: 0;
    width: 100% !important; border-collapse: collapse !important; margin-bottom: 50px;">
        <tr>
            <td align="center" valign="top">
                <!-- BEGIN TEMPLATE // -->
                <table border="0" cellpadding="0" cellspacing="0" style="border-top: 1px solid #FFFFFF;">
                    <tr>
                        <td align="center" valign="top">
                            <!-- BEGIN HEADER // -->
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td valign="top" class="headerContent">
                                        <a href="{{ env('APP_URL') }}" target="_blank">
                                            <img src="{{ env('APP_URL') }}/_assets/_front/_images/logo.png" style="max-width:600px; padding: 20px;" />
                                        </a>
                                    </td>
                                </tr>
                            </table>
                            <!-- // END HEADER -->
                        </td>
                    </tr>
                    <tr>
                        <td align="center" valign="top">
                            <!-- BEGIN BODY // -->
                            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="padding: 20px; background-color: #F4F4F4; border-top: 1px solid #FFFFFF;
    border-bottom: 1px solid #CCCCCC;">
                                <tr>
                                    <td valign="top" class="bodyContent">
                                        @yield('content')
                                    </td>
                                </tr>
                            </table>
                            <!-- // END BODY -->
                        </td>
                    </tr>
                    <tr>
                        <td align="center" valign="top">
                            <!-- BEGIN FOOTER // -->
                            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #eaeaea; margin-bottom: 50px;">
                                <tr>
                                    <td valign="top" class="footerContent" style="padding:10px 20px; border-bottom: 1px solid #CCCCCC;">
                                        @yield('footer')
                                    </td>
                                </tr>
                                <tr style="background: #dcdcdc; border-top: 1px solid #FFFFFF;">
                                    <td valign="top" class="footerContent2" style="padding: 20px;text-align: right">
                                        <a href="{{ env('APP_URL') }}" target="_blank"
                                           style="color: #ffffff; font-size: 16px; background: #f71f00; padding: 7px 11px; border: 1px solid #d4d4d4; text-decoration: none; font-family: Arial, sans-serif;">
                                            Перейти к сайту</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="background: gainsboro; padding-top: 30px;">
                                        <p style="font: 13px/16px Calibri,Helvetica,Arial,sans-serif; color: grey; font-style: italic;">Пожалуйста, не отвечайте на это письмо,<br/>оно сгенерировано автоматически нашим почтовым роботом.</p>
                                    </td>
                                </tr>
                            </table>
                            <!-- // END FOOTER -->
                        </td>
                    </tr>
                </table>
                <!-- // END TEMPLATE -->
            </td>
        </tr>
    </table>
</center>