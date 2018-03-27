<tr>
    <td align="center" valign="top">
        <!-- BEGIN FOOTER // -->
        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #eaeaea; margin-bottom: 50px;">
            <tr>
                <td valign="top" class="footerContent" style="padding:10px 20px; border-bottom: 1px solid #CCCCCC;">
                    <p style="    color: #808080;
    font-family: Arial, sans-serif;
    font-size: 12px;
    line-height: 150%;">{{ env('SITE_NAME') }} <a href="{{ env('APP_URL') }}" target="_blank">{{ env('APP_URL') }}</a>
                        @if(env('MAIL_TEMPLATE_ADDRESS'))
                            <br/>Адрес: {{ env('MAIL_TEMPLATE_ADDRESS') }}
                        @endif
                        @if(env('MAIL_TEMPLATE_PHONE'))
                            <br>Телефон/факc: {{ env('MAIL_TEMPLATE_PHONE') }}
                        @endif
                        @if(env('MAIL_TEMPLATE_MAIL'))
                            <br/>Email:&nbsp;<a href="mailto:{{ env('MAIL_TEMPLATE_MAIL') }}">{{ env('MAIL_TEMPLATE_MAIL') }}</a>
                        @else
                            <br/>Email:&nbsp;<a href="mailto:{{ env('MAIL_TO_ADMIN') }}">{{ env('MAIL_TO_ADMIN') }}</a>
                        @endif
                    </p>
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